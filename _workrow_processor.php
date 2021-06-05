<?php
// поиск и формирование строки для вставки в данные заказчика в заказ
include "dbconnect.php";

$search = $_GET['search'];

$query = "SELECT * 
FROM  `contragents` 
WHERE  `name` LIKE  '%$search%'
OR  `address` LIKE  '%$search%'
OR  `fullinfo` LIKE  '%$search%'
OR  `notification_number` LIKE  '%$search%'
OR  `contacts` LIKE  '%$search%'";

$query_result = mysql_query($query);
$rows = Array();
while ($result = mysql_fetch_array($query_result))
{
	$rows[] = $result;
}

header('Content-type: application/json');
echo JSON_encode($rows);
?>

