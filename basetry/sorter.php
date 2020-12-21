<? $start = microtime(true); ?>
<? include 'dbconnect.php'; ?>
<? session_start(); ?>

<? include './inc/global_functions.php'; ?>
<? include './inc/cfg.php'; ?>
<? $action = $_GET['action']; ?>
<?
/*
$contragent_sql = "SELECT * FROM `contragents`";
$contragent_array = mysql_query($contragent_sql);
while($contragent_data = mysql_fetch_array($contragent_array)) {
	$order_number = 0;
	
	$ssss = $contragent_data['id'];
	echo 'asdasd'.$ssss;
	$order_coubter_sql = mysql_query("SELECT `id` FROM `order` WHERE `contragent` = '$ssss'");
	$order_number = mysql_num_rows($order_coubter_sql);
	mysql_query("UPDATE `contragents` SET `relativity` = '$order_number' WHERE `id` = '$ssss'");
		
}
*/


phpinfo();


?>