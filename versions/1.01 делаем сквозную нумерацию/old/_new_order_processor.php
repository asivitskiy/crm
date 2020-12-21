<?php
//формирование записай в базу данных о новом заказе, либо обновление строк по нему
session_start();
include "dbconnect.php";
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
if ($_POST['doubleflag'] == "Дублировать заказ") {$action = "new";}
//данные по контрагенту
$contragent_address	= $_POST['contragent_address'];
$contragent_fullinfo	= $_POST['contragent_fullinfo'];
$contragent_contacts	= $_POST['contragent_contacts'];
$contragent_name	= $_POST['contragent_name'];
$contragent_id	= $_POST['contragent_id'];

//общие данные по заказу	
$order_description	= $_POST['order_description'];
$order_manager	= $_POST['order_manager'];
$order_number	= $_POST['nomer_blanka'];

$order_pre_check_sql = "SELECT * FROM `order` WHERE ((`order_manager` = '$order_manager') AND (`order_number` = '$order_number')) LIMIT 0,1";
$order_pre_check_array = mysql_query($order_pre_check_sql);
$order_pre_check_data = mysql_fetch_array($order_pre_check_array);
	//УСЛОВИЯ УБИРАЮТ КОСЯК С ПЕРЕЗАПИСЬЮ ДАТЫ ГОТОВНОСТИ ЭТАПА НА ТЕКУЩУЮ ПРИ РЕДАКТИРОВАНИИ
	//проверка что было в согласовании (чтобы дата не перезаписывалась при каждом обновлении заказа!!!!! первое условие - перебор всех условий кроме даты)
	$soglas	= $_POST['soglas'];
	if ((($order_pre_check_data['soglas']==0)or($order_pre_check_data['soglas']==1))and($soglas == "set_ok")) { $soglas = date("YmdHi");}
	if ((($order_pre_check_data['soglas']<>1)and($order_pre_check_data['soglas']<>0))and($soglas == "set_ok")) { $soglas = $order_pre_check_data['soglas'];}
	
	//проверка что было в допечатке (чтобы дата не перезаписывалась при каждом обновлении заказа)
	$preprint = $_POST['preprint'];
	if (($preprint=='Алиса') or ($preprint=='Аня')) { $preprinter = $preprint;} else if ($preprint<>'set_ok') {$preprinter = $order_pre_check_data['preprinter'];}
	if (($preprint=='Нет')) { $preprinter = 'Нет';}
	if (
		//(($order_pre_check_data['preprint']=='Аня')or($order_pre_check_data['preprint']=='Алиса'))
		//and
		($preprint == "set_ok")
		) { $preprint = date("YmdHi");}
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
$paymethod	= $_POST['paymethod'];
$datetoend	= $_POST['datetoend'];
$timetoend	= $_POST['timetoend'];

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

$work_count		= $_POST['work_count'];
$work_price		= $_POST['work_price'];
$work_rashod	= $_POST['work_rashod'];


//проверка есть-нет контрагент. новый - вставляем  нового, редактирование - сохраняем старую версию и перезаписываем новую
//следующие строки - проверка на повтор по имени, если есть - нового в базу не пишем, заказ создаем без заказчика и выводим сообщение сверху в бланке что хуй
//echo($doublecontragentcount);
if (($contragent_id == "new")) {
	$contragent_check_sql = "SELECT * FROM `contragents` WHERE (`name` = '$contragent_name')";
	$contragent_check_query = mysql_query($contragent_check_sql);
	$doublecontragentcount = mysql_num_rows($contragent_check_query);
	if ($doublecontragentcount == 0) {
	$contragent_sql = "INSERT INTO `contragents` 
		(name,address,fullinfo,contacts) 
		VALUES 
		('$contragent_name','$contragent_address','$contragent_fullinfo','$contragent_contacts')";
		mysql_query($contragent_sql);}} 
else { 	
	//перенос в таблицу изменений контрагентов
		//if ($contragent_id == "new") {$doublecontragentcount = 0;}
		$contragents_changes_sql = "INSERT INTO `contragents_changes` (old_id,name,address,fullinfo,contacts) SELECT `id`,`name`,`address`,`fullinfo`,`contacts` FROM `contragents` WHERE (`id`='$contragent_id')";
		mysql_query($contragents_changes_sql);
	//обновление данных
		$update_old_contragent_sql = "UPDATE `contragents` SET `name`='$contragent_name',`address`='$contragent_address',`fullinfo` ='$contragent_fullinfo',`contacts`='$contragent_contacts' WHERE (`id`='$contragent_id')";
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
$contragent_address		= 	$refresh_contragent_data_row['address'];
$contragent_fullinfo	= 	$refresh_contragent_data_row['fullinfo'];
$contragent_contacts	= 	$refresh_contragent_data_row['contacts'];
$contragent_name		= 	$refresh_contragent_data_row['name'];
$contragent_id			= 	$refresh_contragent_data_row['id'];

//NEW ORDER INSERT ($contragent_id уже провереный и перезапрошенный)
		//переприсвоение номера бланка (вдруг уже есть такой из другой вкладки добавленный) только для новых заказов, при редактировании пишется в тот же номр
		if ((isset($action)) and ($action == 'new')) {
		//если новый заказ - просто доьалвяем, проверив номер
		$temp_order_number = $order_number;
		$num_of_rows = 1;
			while ($num_of_rows <> 0) {
				$order_check = "SELECT `id` FROM `order` WHERE ((`order_manager`='$order_manager') AND (`order_number`='$temp_order_number'))";
				$order_check_array = mysql_query($order_check);
				$num_of_rows = mysql_num_rows($order_check_array);
				$temp_order_number = $temp_order_number + 1;
			}
		$order_number = $temp_order_number - 1;
		
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
			 FROM `order` WHERE ((`order_manager`='$order_manager') AND (`order_number`='$order_number'))";	
			mysql_query($temp_orderd_sql);
		//удаление заказа из основной таблицы
			$order_delete_sql = "DELETE FROM `order` WHERE ((`order_manager`='$order_manager') AND (`order_number`='$order_number'))";
			mysql_query($order_delete_sql);
		}

		
//номерки поправлены, всё удалено, вставляем начисто строку с заказом
//дата приема пищется один раз и неизменяется
if ($action=="new") {$date_in = date("YmdHi");}
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
			
			date_in)
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
			
			'$date_in')";
mysql_query($order_sql);

//\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\///
//Запись в таблицу поступления денег//
//\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\///
if ($_POST['vneseno'] <> "") {
$date_in_money = date('YmdHi');
$summ = str_replace(",",".",$_POST['vneseno']);
$money_in_sql = "INSERT INTO `money` (`summ`,`date_in`,`parent_order_manager`,`parent_order_number`,`parent_contragent`) VALUES ('$summ','$date_in_money','$order_manager','$order_number','$contragent_id')";
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

$work_delete = "DELETE FROM `works` WHERE ((`work_order_manager` = '$order_manager') AND (`work_order_number` = '$order_number'))";
mysql_query($work_delete);

$work_counter = count($work_name) - 1;
for ($i = 0; $i <= $work_counter; $i++) 
	{
//переменные для запроса  $a = str_replace(',','.',$a);
$work_namei=$work_name[$i];	
$work_descriptioni=$work_description[$i];
$work_techi=$work_tech[$i];
$work_colori=$work_color[$i];
$work_shiri=$work_shir[$i];	
$work_visi=$work_vis[$i];
$work_mediai=$work_media[$i];
$work_postprinti=$work_postprint[$i];
$work_raskladi=$work_rasklad[$i];
$work_counti=$work_count[$i];
$work_pricei=str_replace(',','.',$work_price[$i]);
$work_rashodi=$work_rashod[$i];

			$workname = str_replace("\r", "", str_replace("\n", "\\n", $work_namei));
			$query_2 = "SELECT `workname` FROM `worknames` WHERE `workname` = '$workname'";
			$res_2 = mysql_query($query_2);
			$row_2 = mysql_fetch_array($res_2);
			$iii2 = count($row_2['workname']);
			if ($iii2<1){
					$sq4 = "INSERT INTO `worknames` (workname) VALUES ('$workname')";
					mysql_query($sq4);
				}
		
$work_add_sql = "INSERT INTO `works` (work_order_manager,work_order_number,work_name,work_description,work_vis,work_shir,work_color,work_media,work_tech,work_price,work_count,work_postprint,work_rashod, work_rasklad) 
VALUES ('$order_manager','$order_number','$work_namei','$work_descriptioni','$work_visi','$work_shiri','$work_colori','$work_mediai','$work_techi','$work_pricei','$work_counti','$work_postprinti','$work_rashodi','$work_raskladi')";
		mysql_query($work_add_sql);
			}

//////////////////////////////
////вставка работ окончена////
//////////////////////////////

//редиректы
//if ($action == 'new') 	{
					///	header('Location: http://192.168.1.221/_workrow.php?action='.$action);
///						} else if ($action == 'redact') {
						
	header('Location: http://192.168.1.221/index.php?double_contragent='.($doublecontragentcount*1).'&action=redact&order_manager='.$order_manager.'&order_number='.$order_number);
//														}
?>
