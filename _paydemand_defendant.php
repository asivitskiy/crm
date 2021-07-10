<?php
include 'dbconnect.php';
if (isset($_GET['outerContragentId']) and isset($_GET['req'])) {
    $selectet_contragent = $_GET['outerContragentId'];
    $array = mysql_query("SELECT * FROM `outcontragent_req` WHERE `outcontragent_id` = '$selectet_contragent'");
    while ($data = mysql_fetch_array($array)) {
        ?>
        <div class="paydemand_contragent_list_element paydemand_contragent_list_element_not_clicked pd_req_block" 
        onclick="paydemand_form_generator('<? echo $data['outcontragent_req_id'];?>',this)">
        
        <?
        echo $data['outcontragent_req_inn'].'<br><br>'.$data['outcontragent_req_full'];
        ?>
        </div>
        <?
    }
}
?>

<?php
include 'dbconnect.php';
if (isset($_GET['outerContragentId']) and isset($_GET['form'])) {
    $selectet_req = $_GET['outerContragentId'];
    //echo $selectet_req;
    ?>
    
	<form action="_new_paydemands_processor.php" method="post">
		<div style="width: 204px; display: inline-block;">Номер входящего счета</div><input autocomplete="off" type="text" name="paylist_demand_number" placeholder="номер">
		<br><br>
		<div style="width: 204px; display: inline-block">Сумма по счету</div><input autocomplete="off" type="text" placeholder="сумма" name="paylist_demand_summ">
		<br><br>
		<input type="submit" value="Зарегистрировать счет" name="submit_flag">
		<br>
	</form>
    <?
    }

?>