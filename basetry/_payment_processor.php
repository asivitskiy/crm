<? include 'dbconnect.php'; session_start(); ?>
<!--Обработчик для платежей из админпанели (внесение, првоерка заказа на готовность)-->
<!--************************************************-->
<!--************************************************-->
<!--Обработчик для платежей из админпанели (внесение, првоерка заказа на готовность)-->



<? // данный файл принимает по GET номер счета и отмечает его как оплаченный либо неоплаченный (т.е. проходит по заказам в которых он есть и проставляет сумму оплаты)
$action		= 	$_GET['action'];
$paylist	= 	$_GET['paylist'];
$summ 		=   $_GET['summ']; //пока что не используется (потому что)

/*echo($action);
echo($paylist);*/

$order_sql = "SELECT `order_number`,`contragent`,`order_manager`,`paymethod` FROM `order` WHERE `paylist` = '$paylist'";
$order_array = mysql_query($order_sql);
while ($order_data = mysql_fetch_array($order_array)) {
//Получены номера заказов, к которым привязан этот счет $order_data['order_number'];

	$order_number = $order_data['order_number'];
	$current_contragent = $order_data['contragent'];
	$current_manager = $order_data['order_manager'];
	$current_paymethod = $order_data['paymethod'];
	$current_date = date("YmdHi");
	//расчет стоимости заказа
	$order_amount = 0;
	
	$work_sql = "SELECT `work_price`,`work_count` FROM `works` WHERE `work_order_number` = '$order_number'";
	$work_array = mysql_query($work_sql);
	
	while ($work_data = mysql_fetch_array($work_array)) {
		$order_amount = $order_amount + $work_data['work_price']*$work_data['work_count'];
	}
	
	$order_amount = number_format($order_amount,2,'.','');
	/*	echo $order_amount;
	echo $current_order;*/

	//Внесение данных в таблицу денег
	
	mysql_query("INSERT INTO `money` (summ,date_in,parent_order_manager,parent_order_number,parent_contragent,paymethod)
									 VALUES
									 ('$order_amount','$current_date','$current_manager','$order_number','$current_contragent','$current_paymethod')");


//***********************************************************************************************
//проверка этого заказа на готовность (если готов - поставить в делитед единичку)	$order_number
//чтоб не было ошибок - заново полностью его извлекаем, смотрим, считаем, проставляем значение
//***********************************************************************************************

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
	} 
	
	else {
		mysql_query("UPDATE `order` SET `deleted`='0' WHERE `order_number` = '$order_number'");
	}


//конец проверки заказа на готовность



echo ($order_number.'     ');

}


?>
<a href="index.php?action=administrating&filter=startscreen">Вернутсья в панель администрирования</a>
