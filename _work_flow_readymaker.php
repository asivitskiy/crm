<?
include "./dbconnect.php";
$cur_order = $_GET['order_number'];
$cur_date = date("YmdHi")*1;
mysql_query("UPDATE `order` SET order.order_ready_digital='$cur_date' WHERE order.order_number = '$cur_order'");
header('Location: http://'.$_SERVER['SERVER_NAME'].'/_work_flow.php');

?>
