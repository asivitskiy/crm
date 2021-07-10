<?php
//этот файл формирует второй и третий столбцы для страницы добавления счетов расхода
include 'dbconnect.php';
if (isset($_GET['outerContragentId']) and isset($_GET['req'])) {
    $selectet_contragent = $_GET['outerContragentId'];
    $array = mysql_query("SELECT * FROM `outcontragent_req` WHERE `outcontragent_id` = '$selectet_contragent'");
    while ($data = mysql_fetch_array($array)) {
        ?>
        <div class="paydemand_contragent_list_element paydemand_contragent_list_element_not_clicked pd_req_block" 
        onclick="paydemand_form_generator('<? echo $data['outcontragent_req_id'];?>',this)">
        
        <?
        echo "ИНН: ".$data['outcontragent_req_inn'].'<br><br>'.$data['outcontragent_req_full'];
        ?>
        </div>
        
        <?
    }
    ?>  
        <br><br>
        <a href=_new_paydemands_red.php?outcontragent_id=<? echo $selectet_contragent; ?>>
        <div class="paydemand_contragent_list_element paydemand_contragent_list_element_not_clicked pd_req_block">
            Добавить новые реквизиты
        </div> 
        </a>
    <?
}
?>

<?php
include 'dbconnect.php';
if (isset($_GET['outerContragentId']) and isset($_GET['form'])) {
    $selectet_req = $_GET['outerContragentId'];
    //echo $selectet_req;
    $form_data_sql = "SELECT * FROM `outcontragent_req` WHERE `outcontragent_req_id` = '$selectet_req'";
    $form_data_data = mysql_fetch_array(mysql_query($form_data_sql));
    ?>
    
	<form action="_new_paydemands_processor.php" method="post">
		<div style="width: 204px; display: inline-block;">Номер входящего счета</div><input autocomplete="off" type="text" name="paylist_demand_number" placeholder="номер">
		<br><br>
		<div style="width: 204px; display: inline-block">Сумма по счету</div>
        <input autocomplete="off" type="text" placeholder="сумма" name="paylist_demand_summ">
		<br><br>
        <input calss='paydemand_date' onchange='unblock()' type="date" name='paylist_demand_date'>
        <br>
        <input type="hidden" name="outcontragent_req_id" value=<? echo $selectet_req;?>>
		<input type="hidden" name="outcontragent_id" value=<? echo $form_data_data['outcontragent_id'];?>>
		<br>
        <input class = 'paydemand_button' type="submit" disabled value="Зарегистрировать счет" name="submit_flag">
		<br>
	</form>
    <?
    }

?>