<?
$contragent_name = $_POST['zakazchik'];
//id
$work_id_array			=$_POST['item_ids'];
//Название
$work_name_array		=$_POST['item_names'];
//На чём изготавливается
$work_tehnika_array		=$_POST['tehnika'];
//Описание каждой работы
$work_description_array		=$_POST['item_descriptions'];
//Количество
$work_count_array		=$_POST['item_counts'];
//Количество
$work_color_array		=$_POST['item_color'];
//Единица измерения
$work_postprint_array	=$_POST['item_postprint'];
//Материал на котором печатаем
$work_media_array	=$_POST['item_media'];
//Расход (если перезаказ)
$work_rashod_array	=$_POST['item_rashod'];
//Цена за Штуку
$work_price_array		=$_POST['item_prices'];
//Формат(размер)
$work_format_array		=$_POST['item_format'];
//Общая сумма по работе
$work_result_array		=$_POST['result'];
///////////////////////////////////////////////////////////
$current_manager	=$_POST['current_manager'];
if (isset($_GET['changeorder_manager'])) {
$current_manager	=$_GET['current_manager']; }
if (isset($_POST['changeorder_manager'])) {
$current_manager	=$_POST['current_manager']; }
$name   			=$_POST['nomer_blanka'];
$timetoend		=$_POST['timetoend'];
$datetoend		=$_POST['datetoend'];
$base_description = $_POST['base_description'];
$preprint = $_POST['preprint'];
$handing = $_POST['handing'];
$paymethod = $_POST['paymethod'];
$paystatus = $_POST['paystatus'];
$vneseno = $_POST['vneseno'];
$delivery = $_POST['delivery'];
$soglas = $_POST['soglas'];
$date_of_end = $_POST['date_of_end'];
$vremya_sdachi = $_POST['datetoend'].$_POST['timetoend'];
$date_in = date("YmdHi");
//костыль - подставляет дату из заказа - донора в случае изхменения.
if (($_POST['changeorder'] == 1) or ($_GET['changeorder'] == 1)) {
	$f_arr = mysql_query("SELECT `date_in` FROM `order` WHERE ((`manager`='$current_manager') AND (`name`='$name') AND (`deleted`<>'1'))");
	$f_dat = mysql_fetch_array($f_arr);
	$date_in = $f_dat['date_in'];
}
$vremya_sdachi = str_replace("-", '', $vremya_sdachi);
$vremya_sdachi = str_replace(":", '', $vremya_sdachi);



?>