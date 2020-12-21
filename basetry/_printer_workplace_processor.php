<?
include 'dbconnect.php';
session_start();
$curenttimerd = date("YmdHi");
$order_number = $_GET['readyorder'];
$readyquery = "UPDATE `order` SET `date_of_end` = '$curenttimerd' WHERE (`order_number` = '$order_number')";
mysql_query($readyquery);





/*//проверка этого заказа на готовность (если готов - поставить в делитед единичку)	$order_number
//чтоб не было ошибок - заново полностью его извлекаем, смотрим, считаем, проставляем значение

//данные о заказе
$ready_checker_sql = "SELECT * FROM `order` WHERE `order_number` = '$order_number'";
$ready_checker_array = mysql_query($ready_checker_sql);
$ready_checker_data = mysql_fetch_array($ready_checker_array);//тут у нас все данные по ордеру лежат

//данные о работах из этого заказа (суммирование)
	$amount_order = 0;
	$query_works_1 = "SELECT * FROM `works` WHERE ((`work_order_number`='$order_number'))";
	$res_works_1 = mysql_query($query_works_1);
			while($row_works_1 = mysql_fetch_array($res_works_1))
							{ $amount_order = $amount_order+(($row_works_1['work_price'])*($row_works_1['work_count'])); }

//данные об оплате этого заказа (суммирование)
$order_summ = 0;
$ready_money_checker_sql = "SELECT * FROM `money` WHERE `parent_order_number` = '$order_number'";
$ready_money_checker_array = mysql_query($ready_money_checker_sql);
while ($ready_money_checker_data = mysql_fetch_array($ready_money_checker_array)) {$order_summ = $order_summ + $ready_money_checker_data['summ'];}

//собственно, сама проверка закзаа
if (((strlen($ready_checker_data['delivery'])==12) or (strlen($ready_checker_data['handing'])==12)) and (abs($amount_order - $order_summ)<0.1)) {
	
	mysql_query("UPDATE `order` SET `deleted`='1' WHERE `order_number` = '$order_number'");
} else {mysql_query("UPDATE `order` SET `deleted`='0' WHERE `order_number` = '$order_number'");}



//конец проверки заказа на готовность*/



header('Location: http://192.168.1.221/');
?>