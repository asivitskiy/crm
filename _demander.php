<?
//Выбор счетов определенного заказчика
include "./inc/dbconnect.php";
?>

 <head>
<link rel="stylesheet" href="./select2/dist/css/select2.min.css">
<script src="./jquery-1.12.4.js"></script>
<script src="./select2/dist/js/select2.min.js"></script>
<script src="./select2/dist/js/i18n/ru.js"></script>
 </head>
 <body>
<? if (isset($_GET['menu'])) { ?>
<form method="get" action="">  
<input type="hidden" name="find_by_contragent">
    <select class="js-select2" name="contragent" placeholder="Заказчик">
        
        <option value=""></option>
        <?
            $contragent_list_sql = "SELECT * FROM `contragents`";
            $contragent_list_array = mysql_query($contragent_list_sql);
            while ($contragent_list_data = mysql_fetch_array($contragent_list_array)) {
        ?>
            <option value="<? echo $contragent_list_data['id']; ?>"><? echo $contragent_list_data['name']; ?></option>

        <? } ?>
        

        
    </select>
    <button>Показать счета</button>
</form>
<? } ?>


<? if (isset($_GET['find_by_contragent'])) { 
    $contragent =  $_GET['contragent']; 
    $contragent_demand_list_sql = " SELECT DISTINCT `paylist`,`contragent`,`date_in` FROM `order` 
                                    LEFT JOIN contragents ON contragents.id = order.contragent
                                    WHERE ((contragents.id = '$contragent') and (order.paylist<>'')) ORDER by order.date_in DESC";
    $contragent_demand_list_array = mysql_query($contragent_demand_list_sql);
    
    while ($contragent_demand_list_data = mysql_fetch_array($contragent_demand_list_array)) {
        $current_paylist = $contragent_demand_list_data['paylist'];
        echo "<details>";
        echo "<summary>";
        echo 'Счет '.$current_paylist.'<br>';
        echo "</summary>";
        $demand_order_sql = "SELECT * FROM `order` WHERE order.paylist = '$current_paylist'";
        $demand_order_array = mysql_query($demand_order_sql);
        while ($demand_order_data = mysql_fetch_array($demand_order_array)) {
            $current_order = $demand_order_data['order_number'];
            echo '-------> Заказ '.$current_order.'<br>';
                $order_works_sql = "SELECT * FROM `works` WHERE works.work_order_number = ' $current_order'";
                $order_works_array = mysql_query($order_works_sql);
                while ( $order_works_data = mysql_fetch_array($order_works_array)) {
                    $current_work= $order_works_data['work_name'];
                    echo '----------------> Изд. '.$current_work.'<br>';
                }
        }
        echo "</details>";
    }
    

} ?>
































<script>
$(document).ready(function() {
	$('.js-select2').select2({
		placeholder: "Выберите город",
		maximumSelectionLength: 2,
		language: "ru"
	});
});
</script>
 </body>