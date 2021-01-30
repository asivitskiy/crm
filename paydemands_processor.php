<?
//це обработчик страницы регистрации счетов от поставщиков
	//1 добавление и изменение счета
	//2 автоматическая проверка состояния счета: если счет закрыт - поставить проверку checked чтобы он исчез из списка выдачи
include 'dbconnect.php';
session_start(); 

	//смена статуса оплаты 
if ($_GET['checked'] == 'now') {
	$cur_date = date("YmdHi");
	$paylist_demands_id = $_GET['id'];
	$checked_update_sql = "UPDATE `paylist_demands` SET `checked`='$cur_date' WHERE `id`='$paylist_demands_id'";
	mysql_query($checked_update_sql);
}
if ($_GET['checked'] == 'no') {
	$cur_date = date("YmdHi");
	$paylist_demands_id = $_GET['id'];
	$checked_update_sql = "UPDATE `paylist_demands` SET `checked`='' WHERE `id`='$paylist_demands_id'";
	mysql_query($checked_update_sql);
}

if ((($_POST['paylist_flag']) == '1') and ($_POST['paylist_demand_owner'] <> '')) {
	$number = $_POST['paylist_demand_number'];
	$owner = $_POST['paylist_demand_owner'];
	$summ = str_replace(",",".",$_POST['paylist_demand_summ']);
	$summ = number_format($summ,2,'.','');
	$date_in = date("YmdHi");
	$registrator = $_SESSION['manager'];
	$payer = $_POST['paylist_demand_payer'];
	$paylist_demands_sql = "INSERT INTO `paylist_demands` (
	number,
	owner,
	summ,
	date_in,
	paylist_demand_payer,
	registrator) 
	VALUES (
	'$number',
	'$owner',
	'$summ',
	'$date_in',
	'$payer',
	'$registrator')";
	mysql_query($paylist_demands_sql);
}

if (($_POST['paylist_flag']) == '2') {
	echo '2222';
	
}




header('Location: http://'.$_SERVER['SERVER_NAME'].'/?action=paydemands');
?>