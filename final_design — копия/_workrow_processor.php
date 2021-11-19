<?php
// поиск и формирование строки для вставки в данные заказчика в заказ
include "web_inc/dbconnect.php";

$search = $_GET['search'];
if (strlen($search) > 1) {
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
}
header('Content-type: application/json');
echo JSON_encode($rows);
