<?
//вроде как мёртвый файл, видимо старая верся, не должен нигде использоватся (но это не факт)
session_start();
include 'dbconnect.php'; ?>
<?

//формируем таблицу имён контрагентов
//Достаём все данные из POST 
include('./inc/_processor_POST.php');
//Проверяем контрагента. Если Такого нет - добавляем.
//На выходе имеем переменную $contragent_shortcut с именем контрагента! и $zakazchik с номерм в базе (ID) любом случае (если новый - отформатировано и добавлено в базу)
include('./processor_incs/list_of_contragents.php');




$kolichestvo_strok = count($work_name_array) - 1;
if (($_POST['changeorder'] == 1) or ($_GET['changeorder'] == 1)) {
									$upd_order_id = $current_manager."-".$name;
									$upd_sql = "UPDATE `works` SET `deleted`='1' WHERE `order_id`='$upd_order_id'";
									mysql_query($upd_sql);
									$_SESSION['changeorder_complete'] = $_SESSION['changeorder_complete'] + 1;
								}
for ($i = 0; $i <= $kolichestvo_strok; $i++) {
	if (($work_name_array[$i] <> '') and ($work_count_array[$i]>0)) {
	$workid = $name.rand(10000,99999);
	$a1 = $work_name_array[$i];
	$a2 = $work_tehnika_array[$i];
    $a3 = str_replace(",", ".", $work_price_array[$i]);$work_price_array[$i];
    $a4 = $work_count_array[$i];
	$a5 = $current_manager."-".$name;
    $a6 = $work_postprint_array[$i];
    $a7 = $work_description_array[$i];
    $a8 = $work_color_array[$i];
	$a9 = $work_media_array[$i];
    $a10 = $work_rashod_array[$i];
    $a11 = $work_format_array[$i];
    
    
    
			  	/////////////////////////////////
				//формируем таблицу имён работ
				//БЕРЕТ ПЕРЕМЕННУЮ $a1 и првоеряет есть ли она в базе имен, если нет - добавляет
				include('./processor_incs/list_of_works.php');
				/////////////////////////////////
    $sql = "INSERT INTO `works` (work_id,order_id,name,tech,price,count,postprint,work_description,color,media,rashod,format) VALUES ('$workid','$a5','$a1','$a2','$a3','$a4','$a6','$a7','$a8','$a9','$a10','$a11')";
	mysql_query($sql);
		//echo mysql_error();
		//echo('rashod'.$a8);
	}}
if (($_POST['changeorder'] == 1) or ($_GET['changeorder'] == 1)) {
									$upd_work_id = $current_manager."-".$name;
									$upd_sql = "UPDATE `order` SET `deleted`='1' WHERE ((`manager`='$current_manager') AND (`name`='$name'))";
									mysql_query($upd_sql);
									$_SESSION['changeorder_complete'] = $_SESSION['changeorder_complete'] + 1;
								}
$sq2 = "INSERT INTO `order` (contragent,date_in,name,time_to_end,date_to_end,vremya_sdachi,manager,order_description,preprint,handing,paymethod,paystatus,vneseno,date_of_end,soglas,delivery) VALUES ('$zakazchik','$date_in','$name','$timetoend','$datetoend','$vremya_sdachi','$current_manager','$base_description','$preprint','$handing','$paymethod','$paystatus','$vneseno','$date_of_end','$soglas','$delivery')";
mysql_query($sq2);



// -------------------------------------------------------------------------------
// ----обновление заказа-----------------------------------------------
// -------------------------------------------------------------------------------
//if ($_POST['changeorder'] == 1) {
header('Location: http://192.168.1.221/index.php?page=blank_zakaz&changeorder=1&changeorder_number='.$name.'&changeorder_manager='.$current_manager);//}
 //else { header('Location: http://192.168.1.221');}
?>
