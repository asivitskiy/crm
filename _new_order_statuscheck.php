<?php
//формирование записай в базу данных о новом заказе, либо обновление строк по нему
session_start();
include "dbconnect.php";
//вывод массива POST

$order_number = $_GET['order_number'];

if ($_GET['paystatus'] == "paystatuschange") {

	$order_pre_check_sql = "SELECT * FROM `order` WHERE ((`order_number` = '$order_number')) LIMIT 0,1";
	$order_pre_check_array = mysql_query($order_pre_check_sql);
	$order_pre_check_data = mysql_fetch_array($order_pre_check_array);

	if (strlen($order_pre_check_data['paystatus']) == '12') {$pscurenttime = ''; } else {$pscurenttime = date("YmdHi"); }

	$readyqueryps = "UPDATE `order` SET `paystatus` = '$pscurenttime' WHERE (`order_number` = '$order_number')";
	mysql_query($readyqueryps);
	?>
	<script>window.close()</script>
	<?
}

if ($_GET['send_notification'] == "sendmessage") {

    $order_pre_check_sql = "SELECT * FROM `order` WHERE ((`order_number` = '$order_number')) LIMIT 0,1";
    $order_pre_check_array = mysql_query($order_pre_check_sql);
    $order_pre_check_data = mysql_fetch_array($order_pre_check_array);

    if (strlen($order_pre_check_data['notification_status']) <> '12') {

    $readyqueryps = "UPDATE `order` SET `notification_status` = 1 WHERE (`order_number` = '$order_number')";
    mysql_query($readyqueryps);}
    ?>
    <script>window.close()</script>
    <?
}


?>

