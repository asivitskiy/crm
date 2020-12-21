<?
//удаление работы из базы работ
session_start();
include "dbconnect.php";
$work_id = $_GET['work_id'];
$order_number = $_GET['order_number'];


if ($_GET['step'] == 1) {

echo "<br><a style=color:red; href=_work_deleter.php?step=2&work_id=".$work_id."&order_number=".$order_number."> <b>Точно удалить</b></a><br><br>";
echo "<a href=index.php?action=redact&order_number=".$order_number."> Не удалять</a>";

}

if ($_GET['step'] == 2) {
mysql_query("DELETE FROM `works` WHERE `id` = '$work_id'");
header('Location: index.php?action=redact&order_number='.$order_number);
}


?>
