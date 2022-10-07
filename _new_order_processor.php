<?php
//формирование записай в базу данных о новом заказе, либо обновление строк по нему
include "dbconnect.php";
include "./inc/global_functions.php";
session_start();

//вывод массива POST
$arr=array();
$arr=$_POST;
foreach ($arr as $key => $value) {
   //echo "$key".' --> '."$value".'<br>';
}
//что делаем (новый/редактирование)
$action = $_POST['action'];
//echo $_POST['doubleflag'];
//echo $action;
//данные по контрагенту
$contragent_address	= ($_POST['contragent_address']);
$contragent_notification_number	= ($_POST['notification_number']);
$contragent_fullinfo	= ($_POST['contragent_fullinfo']);
$contragent_contacts	= ($_POST['contragent_contacts']);
$contragent_name	= ($_POST['contragent_name']);
$contragent_id	= ($_POST['contragent_id']);

//общие данные по заказу	
$order_description	= $_POST['order_description'];
$order_manager	= $_POST['order_manager'];
$order_number	= $_POST['nomer_blanka'];
//echo ($order_number);

//ДОПОЛНИТЕЛЬНЫЕ КНОПКИ (ДУБЛИРОВАНИЕ, ГОТОВНОСТЬ ПЕЧАТИ) также правится дата в 78 строке по этом же условию
if ($_POST['doubleflag'] == "Дублировать заказ") {$action = "new";}




$order_pre_check_sql = "SELECT * FROM `order` 
						LEFT JOIN `contragents` ON contragents.id = order.contragent
						WHERE ((`order_number` = '$order_number')) LIMIT 0,1";
$order_pre_check_array = mysql_query($order_pre_check_sql);
$order_pre_check_data = mysql_fetch_array($order_pre_check_array);

	//перенос простых переменных (например,запрос счета)
	//там может быть либо ничего, либо 12-значное число - дата

	$paystatus 					= $order_pre_check_data['paystatus'];
	$price_change_flag 			= $order_pre_check_data['price_change_flag'];
	$notification_status 		= $order_pre_check_data['notification_status'];
	$notification_of_end_status = $order_pre_check_data['notification_of_end_status'];
	$date_of_end 				= $order_pre_check_data['date_of_end'];
	$order_has_digital 			= $order_pre_check_data['order_has_digital'];
	$order_has_reorder 			= $order_pre_check_data['order_has_reorder'];
	$order_ready_digital 		= $order_pre_check_data['order_ready_digital'];
	$order_ready_reorder 		= $order_pre_check_data['order_ready_reorder'];

//УСЛОВИЯ УБИРАЮТ КОСЯК С ПЕРЕЗАПИСЬЮ ДАТЫ ГОТОВНОСТИ ЭТАПА НА ТЕКУЩУЮ ПРИ РЕДАКТИРОВАНИИ
	//проверка что было в согласовании (чтобы дата не перезаписывалась при каждом обновлении заказа!!!!! первое условие - перебор всех условий кроме даты)
	$soglas	= $_POST['soglas'];
	if ((($order_pre_check_data['soglas']==0)or($order_pre_check_data['soglas']==1))and($soglas == "set_ok")) { $soglas = date("YmdHi");$soglas_change_flag = 1;}
	if ((($order_pre_check_data['soglas']<>1)and($order_pre_check_data['soglas']<>0))and($soglas == "set_ok")) { $soglas = $order_pre_check_data['soglas'];}
	
	//проверка что было в допечатке (чтобы дата не перезаписывалась при каждом обновлении заказа)
	$preprint = $_POST['preprint'];
	$preprinter = $preprint;
	$preprint_button = $_POST['preprint_button'];
	if (($preprint=='Алиса') or ($preprint=='Аня') or ($preprint=='Катя')) { $preprinter = $preprint;} else if ($preprint<>'set_ok') {$preprinter = $order_pre_check_data['preprinter'];}
	if (($preprint=='Нет')) { $preprinter = 'Нет';}
	if ((strlen($order_pre_check_data['preprint'])) == 12) { $preprint = $order_pre_check_data['preprint'];}
	if (($preprint_button == "Подготовлено") and ((strlen($order_pre_check_data['preprint'])) <> 12)) { $preprint = date("YmdHi"); $preprint_ready_flag = 1;}
	if (($preprint_button == "Подготовлено") and ((strlen($order_pre_check_data['preprint'])) == 12)) { $preprint = $preprinter;}
	
	//if ((($order_pre_check_data['preprint']<>1)and($order_pre_check_data['preprint']<>0))and($preprint == "set_ok")) { $preprint = $order_pre_check_data['preprint'];}
	
	$delivery = $_POST['delivery'];
	if ((($order_pre_check_data['delivery']==0)or($order_pre_check_data['delivery']==1))and($delivery == "set_ok")) { $delivery = date("YmdHi");}
	if ((($order_pre_check_data['delivery']<>1)and($order_pre_check_data['delivery']<>0))and($delivery == "set_ok")) { $delivery = $order_pre_check_data['delivery'];}
	
	$handing = $_POST['handing'];
	if ((($order_pre_check_data['handing']==0)or($order_pre_check_data['handing']==1))and($handing == "set_ok")) { $handing = date("YmdHi");}
	if ((($order_pre_check_data['handing']<>1)and($order_pre_check_data['handing']<>0))and($handing == "set_ok")) { $handing = $order_pre_check_data['handing'];}
	
	$paylist = $_POST['paylist'];
	//echo $paylist;
	if ((($order_pre_check_data['paylist']==0))and($paylist == "set_ok")) { $paylist = date("YmdHi");}
	if ((($order_pre_check_data['paylist']<>0))and($paylist == "set_ok")) { $paylist = $order_pre_check_data['paylist'];}
	//echo($paylist);

$vneseno	= str_replace(",",".",$_POST['vneseno']) + str_replace(",",".",$order_pre_check_data['vneseno']);
$vneseno    = number_format($vneseno,2,'.','');
$paymethod	= $_POST['paymethod'];
	
	$datetoend	= $_POST['datetoend'];
	$timetoend	= $_POST['timetoend'];
	
	if ($_POST['doubleflag'] == "Дублировать заказ") {
			$paylist = '';
			$paymethod = '';
			$paystatus = '';
			$preprint = 'Нет';
			$preprinter = 'Нет';
			$handing = 0;
			$vneseno = 0;
			$date_of_end = '';
			$delivery = 0;
			$d=strtotime("+1 day");
			$datetoend	= "";/*date("Ymd",$d);*/
			$timetoend	= "";/*date("H").':00';*/
													}
				
//данные по каждой работе
// не используется пока что $work_id		= $_POST['work_id'];
// не используется пока что $work_format	= $_POST['work_format'];
$work_name			= $_POST['work_name'];
$work_description	= $_POST['work_description'];
$work_tech		= $_POST['work_tech'];
$work_color		= $_POST['work_color'];
$work_shir		= $_POST['work_shir'];
$work_vis		= $_POST['work_vis'];
$work_media		= $_POST['work_media'];
$work_postprint	= $_POST['work_postprint'];
$work_rasklad	= $_POST['work_rasklad'];
$work_roland_status = $_POST['work_roland_status'];

$work_count		= $_POST['work_count'];
$work_sheets	= $_POST['work_sheets'];
$work_price		= $_POST['work_price'];
$work_rashod	= $_POST['work_rashod'];
$work_rashod_list	= $_POST['work_rashod_list'];
$qr_status 			= $order_pre_check_data['qr_status'];
if ($qr_status == '0') {$qr_status = '1';}
if ($qr_status == '2') {$qr_status = '1';}


//проверка есть-нет контрагент. новый - вставляем  нового, редактирование - сохраняем старую версию и перезаписываем новую
//следующие строки - проверка на повтор по имени, если есть - нового в базу не пишем, заказ создаем без заказчика и выводим сообщение сверху в бланке что хуй
//echo($doublecontragentcount);
if (($contragent_id == "new")) {
	$contragent_check_sql = "SELECT * FROM `contragents` WHERE (`name` = '$contragent_name')";
	$contragent_check_query = mysql_query($contragent_check_sql);
	$doublecontragentcount = mysql_num_rows($contragent_check_query);
			$contragent_notification_number		= addslashes($contragent_notification_number);
			$contragent_address		= addslashes($contragent_address);
			$contragent_fullinfo	= addslashes($contragent_fullinfo);
			$contragent_contacts	= addslashes($contragent_contacts);
			$contragent_name		= addslashes($contragent_name);
			$contragent_id			= addslashes($contragent_id);
	if ($doublecontragentcount == 0) {
	$contragent_sql = "INSERT INTO `contragents` 
		(name,address,fullinfo,contacts,notification_number) 
		VALUES 
		('$contragent_name','$contragent_address','$contragent_fullinfo','$contragent_contacts','$contragent_notification_number')";
		mysql_query($contragent_sql);}} 
else {
			$contragent_notification_number		= addslashes($contragent_notification_number);
			$contragent_address		= addslashes($contragent_address);
			$contragent_fullinfo	= addslashes($contragent_fullinfo);
			$contragent_contacts	= addslashes($contragent_contacts);
			$contragent_name		= addslashes($contragent_name);
			$contragent_id			= addslashes($contragent_id);
	//перенос в таблицу изменений контрагентов
		//if ($contragent_id == "new") {$doublecontragentcount = 0;}
/*		$contragents_changes_sql = "INSERT INTO `contragents_changes` (old_id,name,address,fullinfo,contacts) SELECT `id`,`name`,`address`,`fullinfo`,`contacts` FROM `contragents` WHERE (`id`='$contragent_id')";
		mysql_query($contragents_changes_sql);*/
	//обновление данных
		$update_old_contragent_sql = "UPDATE `contragents` SET `name`='$contragent_name',`address`='$contragent_address',`fullinfo` ='$contragent_fullinfo',`contacts`='$contragent_contacts',`notification_number`='$contragent_notification_number' WHERE (`id`='$contragent_id')";
		mysql_query($update_old_contragent_sql);
		

}


//ПЕРЕЗАПРОС contragent_id, получаем его ID для записи в базу заказов ( на всякий случай ПЕРЕЗАПРАЩИВАЕМ по данным пост, иначе ошибки бывают)
$refresh_contragent_data_sql = "SELECT * FROM `contragents` 
								WHERE (
								(`name`='$contragent_name') AND 
								(`address`='$contragent_address') AND 
								(`fullinfo`='$contragent_fullinfo') AND 
								(`contacts`='$contragent_contacts'))";
$refresh_contragent_data_array = mysql_query($refresh_contragent_data_sql);
$refresh_contragent_data_row = mysql_fetch_array($refresh_contragent_data_array);
$contragent_address		= 	addslashes($refresh_contragent_data_row['address']);
$contragent_fullinfo	= 	addslashes($refresh_contragent_data_row['fullinfo']);
$contragent_contacts	= 	addslashes($refresh_contragent_data_row['contacts']);
$contragent_name		= 	addslashes($refresh_contragent_data_row['name']);
$contragent_id			= 	addslashes($refresh_contragent_data_row['id']);

//NEW ORDER INSERT ($contragent_id уже провереный и перезапрошенный)
		//переприсвоение номера бланка (вдруг уже есть такой из другой вкладки добавленный) только для новых заказов, при редактировании пишется в тот же номр
		if ((isset($action)) and ($action == 'new')) {
		//если новый заказ - просто доьалвяем, проверив номер
		$temp_order_number = $order_number;
		//$num_of_rows = 1;
			//while ($num_of_rows <> 0) {
				$order_check = "SELECT `order_number` FROM `order` ORDER by `order_number` DESC LIMIT 1";
				$order_check_array = mysql_query($order_check);
				$order_check_data = mysql_fetch_array($order_check_array);
				$prev_order_number = $order_number;
				$order_number = $order_check_data['order_number']+1;
				//$num_of_rows = mysql_num_rows($order_check_array);
				//$temp_order_number = $temp_order_number + 1;
				
			//}
			//перенос комментариев при дублировании (там часто адреса доставки переменные - чтобы подтягивались за основным заказом)
			if ($_POST['doubleflag'] == "Дублировать заказ") {
			$comment_copy_array = mysql_query("SELECT * FROM `order_messages` WHERE `order_number` = $prev_order_number");
				while ($comment_copy_data = mysql_fetch_array($comment_copy_array)) {// echo ($prev_order_number);
					$comment_copy_data_message = $comment_copy_data['message'];
					$comment_copy_data_order_manager = $comment_copy_data['order_manager'];
					$comment_copy_data_date_in_message = $comment_copy_data['date_in_message'];
					
					$comment_insert = mysql_query("INSERT INTO `order_messages` (
																				message,
																				order_manager,
																				order_number,
																				date_in_message) 
																				VALUES (
																				'$comment_copy_data_message',
																				'$comment_copy_data_order_manager',
																				'$order_number',
																				'$comment_copy_data_date_in_message'
																				)");	
					}
				}
		
		
		} else {
		//перенос заказа в таблицу изменений
			$temp_orderd_sql = "
			INSERT INTO `order_changes` (
			contragent,
			order_description,
			order_manager,
			order_number,
			soglas,
			preprint,
			delivery,
			vneseno,
			paymethod,
			datetoend,
			timetoend,
			handing,
			paylist,
			)
			SELECT `contragent`,
			`order_description`,
			`order_manager`,
			`order_number`,
			`soglas`,
			`preprint`,
			`delivery`,
			`vneseno`,
			`paymethod`,
			`datetoend`,
			`timetoend`,
			`handing`,
			`paylist`,
			 FROM `order` WHERE ((`order_number`='$order_number'))";	
			mysql_query($temp_orderd_sql);
		//удаление заказа из основной таблицы
			$order_delete_sql = "DELETE FROM `order` WHERE ((`order_number`='$order_number'))";
			mysql_query($order_delete_sql);
		}

		
//номерки поправлены, всё удалено, вставляем начисто строку с заказом
//дата приема пищется один раз и не изменяется
if ($action=="new") {$date_in = date("YmdHi"); $qr_status = 1;
	createOrderFolder($order_number,$order_manager);
}
if ($action<>"new") {$date_in = $order_pre_check_data['date_in'];}
$datetoend = $datetoend.$timetoend;
$datetoend = str_replace(":","",$datetoend);
$datetoend = str_replace("-","",$datetoend);
$order_sql = "INSERT INTO `order` (
			contragent,
			order_description,
			order_manager,
			order_number,
			soglas,
			preprint,
			delivery,
			vneseno,
			paymethod,
			datetoend,
			timetoend,
			handing,
			paylist,
			preprinter,
			paystatus,
			notification_status,
			notification_of_end_status,
			date_of_end,
			date_in,
            order_has_digital,
            order_has_reorder,
            order_ready_digital,
            order_ready_reorder,
            price_change_flag,
        	qr_status)
			VALUES (
			'$contragent_id',
			'$order_description',
			'$order_manager',
			'$order_number',
			'$soglas',
			'$preprint',
			'$delivery',
			'$vneseno',
			'$paymethod',
			'$datetoend',
			'$timetoend',
			'$handing',
			'$paylist',
			'$preprinter',
			'$paystatus',
			'$notification_status',
			'$notification_of_end_status',
			'$date_of_end',
			'$date_in',
			'$order_has_digital',
            '$order_has_reorder',
            '$order_ready_digital',
            '$order_ready_reorder',
            '$price_change_flag',
			'$qr_status')";
mysql_query($order_sql);

//\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\///
//Запись в таблицу поступления денег//
//\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\///
if (($_POST['vneseno'] <> "")) {
$date_in_money = date('YmdHi');
$summ = str_replace(",",".",$_POST['vneseno']);
$money_in_sql = "INSERT INTO `money` (`summ`,`date_in`,`parent_order_manager`,`parent_order_number`,`parent_contragent`,`paymethod`) VALUES ('$summ','$date_in_money','$order_manager','$order_number','$contragent_id','$paymethod')";
mysql_query($money_in_sql); }
//\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\///
//Запись в таблицу сообщений//////////
//\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\///

if ($_POST['order_message'] <> "") {
$date_in_message = date('YmdHi');
$order_message = $_POST['order_message'];
$message_in_sql = "INSERT INTO `order_messages` (`message`,`order_manager`,`order_number`,`date_in_message`) VALUES ('$order_message','$order_manager','$order_number','$date_in_message')";
mysql_query($message_in_sql);}





//////////////////
//NEW WORKS INSERT
//////////////////
//количество строк в заказе
//Работы просто перезаписываем, старые - просто удаляем
//удаление всех предыдущих работ для перезаписи обновленных

$work_delete = "DELETE FROM `works` WHERE ((`work_order_number` = '$order_number'))";
mysql_query($work_delete);
$works_summ = 0;
$work_counter = count($work_name) - 1;
for ($i = 0; $i <= $work_counter; $i++) 
	{
//переменные для запроса  $a = str_replace(',','.',$a);
$work_namei=addslashes($work_name[$i]);	
$work_descriptioni=addslashes($work_description[$i]);
$work_techi=$work_tech[$i];
$work_colori=$work_color[$i];
$work_shiri=$work_shir[$i];	
$work_visi=$work_vis[$i];
$work_mediai=$work_media[$i];
$work_postprinti=$work_postprint[$i];
$work_raskladi=$work_rasklad[$i];
$work_counti=$work_count[$i];
$work_sheetsi=round($work_sheets[$i]);
$work_roland_statusi = $work_roland_status[$i];
$work_pricei=str_replace(',','.',$work_price[$i]);
$work_rashodi=str_replace(',','.',$work_rashod[$i])*1;$work_rashodi=number_format($work_rashodi,2,'.','');
$work_rashod_listi=$work_rashod_list[$i];
			
			
			//удаление счета перезаказа для любогй работы, где производитель не перезаказ
			$work_tech_check_sql 	= "SELECT * FROM `outcontragent` WHERE `outcontragent_fullname` = '$work_techi'";
			$work_tech_check_array 	= mysql_query($work_tech_check_sql);
			$work_tech_check_data 	= mysql_fetch_array($work_tech_check_array);
			//вот тут получена группа, к которой относится работа (для понимания - нужно нам или нет удалить счет расхода)
			$work_tech_group = $work_tech_check_data['outcontragent_group'];
			//снос счета расхода (если вдруг производителем стала цифра)
			
		if ($work_tech_group <> 'outer') {
			$work_rashod_listi = '';
		}
			
			$workname = str_replace("\r", "", str_replace("\n", "\\n", $work_namei));
			$query_2 = "SELECT `workname` FROM `worknames` WHERE `workname` = '$workname'";
			$res_2 = mysql_query($query_2);
			$row_2 = mysql_fetch_array($res_2);
			$iii2 = count($row_2['workname']);
			if ($iii2<1){
					$sq4 = "INSERT INTO `worknames` (workname) VALUES ('$workname')";
					mysql_query($sq4);
				}
		
$work_add_sql = "INSERT INTO `works` (work_roland_status,work_order_manager,work_order_number,work_name,work_description,work_vis,work_shir,work_color,work_media,work_tech,work_price,work_count,work_sheets,work_postprint,work_rashod,work_rashod_list,work_rasklad) 
VALUES ('$work_roland_statusi','$order_manager','$order_number','$work_namei','$work_descriptioni','$work_visi','$work_shiri','$work_colori','$work_mediai','$work_techi','$work_pricei','$work_counti','$work_sheetsi','$work_postprinti','$work_rashodi','$work_rashod_listi','$work_raskladi')";
		mysql_query($work_add_sql);
		$works_summ = $works_summ + $work_pricei*$work_counti;
			}

//////////////////////////////
////вставка работ окончена////
//////////////////////////////

//ИСТОРИЯ
if ($action == "new") {hist_writer("order_add",$order_number,$contragent_id,$order_manager,$works_summ);} else {hist_writer("order_change",$order_number,$contragent_id,$order_manager,$works_summ);}


//переустанавливаем признак изменения цены, если бланк возвращен в работу из ожидания (нужно для корректной работы вацап рассыльщика)
if ($soglas_change_flag == 1) {
	mysql_query("UPDATE `order` SET `price_change_flag`='1' WHERE (`order_number`='$order_number')");
}


//////////////////////////////
///пишем историю цен бланка///
//////////////////////////////

//$prev_price - цена текущей версии заказа уже после обновления
		$history_sql = "SELECT SUM(works.work_price*works.work_count) as `smm` FROM `order` 
						LEFT JOIN `works` ON works.work_order_number = order.order_number
						WHERE `order_number`='$order_number'";
		$history_array = mysql_query($history_sql);
		$history_data = mysql_fetch_array($history_array);
		$prev_price = $history_data['smm'];

//достаём из истории последнюю запись по этому бланку $last_checked_price
		$checked_price_sql = "SELECT * FROM `order_price_history` WHERE `order_price_history_order_number` = '$order_number' ORDER BY order_price_history_id DESC LIMIT 1";
		$checked_price_array = mysql_query($checked_price_sql);
		if (mysql_num_rows($checked_price_array)>0) {
			$checked_price_data = mysql_fetch_array($checked_price_array);
			$last_checked_price = $checked_price_data['order_price_history_price'];
		} else {$last_checked_price = 0;
				 
		}
		

		//echo $checked_price_data['order_price_history_id'];
//условие изменения цены, либо нуля
if (($last_checked_price == 0) or (abs($prev_price - $last_checked_price)>1)) {
	mysql_query("UPDATE `order` SET `price_change_flag` = 1 WHERE (`order_number` = '$order_number')");
}
mysql_query("INSERT INTO `order_price_history` (order_price_history_order_number,order_price_history_price) VALUES ('$order_number','$prev_price')");







//Кнопки обновления статуса готовности:
if ($_POST['ready_button'] == "Отпечатано") {
											$notofocation_of_end = '';
											if ((strlen($order_pre_check_data['date_of_end'])) == 12) {$curenttimerd = '';$notofocation_of_end='';} else {$curenttimerd = date("YmdHi");$notofocation_of_end='1';}
											
											$readyquery = "UPDATE `order` SET `date_of_end` = '$curenttimerd' WHERE (`order_number` = '$order_number')";
											mysql_query($readyquery);

											if ($order_pre_check_data['notification_number'] == '') {$notofocation_of_end = '';}
											$readyquery = "UPDATE `order` SET `notification_of_end_status` = '$notofocation_of_end' WHERE (`order_number` = '$order_number')";
											mysql_query($readyquery);

											}


if ($_POST['paystatus'] == "Запросить счет") {
											if (strlen($order_pre_check_data['paystatus']) == 12) {$pscurenttime = ''; } else {$pscurenttime = date("YmdHi"); }
											
											$readyqueryps = "UPDATE `order` SET `paystatus` = '$pscurenttime' WHERE (`order_number` = '$order_number')";
											mysql_query($readyqueryps);
											}


//проверка этого заказа на готовность (если готов - поставить в делитед единичку)	$order_number
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
	$current_time = date('YmdHi');
	mysql_query("UPDATE `order` SET `date_of_end`='$current_time' WHERE `order_number` = '$order_number'");
	mysql_query("UPDATE `order` SET `preprint`='$current_time' WHERE `order_number` = '$order_number'");
	mysql_query("UPDATE `order` SET `deleted`='1' WHERE `order_number` = '$order_number'");
} else {
	mysql_query("UPDATE `order` SET `deleted`='0' WHERE `order_number` = '$order_number'");
		
}


//конец проверки заказа на готовность

//сброс статуса order-checked
mysql_query("UPDATE `order` SET `order_status-check`=0 WHERE `order_number` = '$order_number'");

//отправка печатнику бланка если допечатка готова
/*if ($preprint_ready_flag == 1) {
//$aa = file_get_contents('http://192.168.1.221/_printengine.php?addtoquery=1&order_number='.$order_number);
}*/
//переадресация обратно
	header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php?double_contragent='.($doublecontragentcount*1).'&action=redact&order_number='.$order_number);


?>
