<?

set_include_path(get_include_path() . PATH_SEPARATOR . "./dompdf/");

require_once "dompdf_config.inc.php";
require '../dbconnect.php';
require '../inc/config_reader.php';
print_r($cfg);
$dompdf = new DOMPDF();

/*$html = <<<'ENDHTML'
.file_get_contents("http://www.example.com/").
ENDHTML;*/
$order_number = $_GET['order_number'].'';

$page = "http://".$_SERVER['HTTP_HOST']."/_pdf_engine_check/"."printform_new.php?manager=Ю&number=".$order_number;
/*echo $page;*/
/*echo $page;*/
$content = file_get_contents($page);
$dompdf->load_html($content);
$customPaper = array(0,0,220,2500);
$dompdf->set_paper($customPaper);
$dompdf->render();


$output = $dompdf->output();
/*$dompdf->stream($order_number.'-'.date("YmdHi").'.pdf',array("Attachment" => false));*/
//старый кусок для механизма оповещения о оформлении заказа
//if (($_POST['notification_status'] == "Оповестить о оформлении")) {
//	$current_contragent = $order_pre_check_data['contragent'];
//	$current_contragent_data = mysql_fetch_array(mysql_query("SELECT * FROM `contragents` WHERE contragents.id = '$current_contragent' LIMIT 1"));
//		if (strlen($current_contragent_data['notification_number']) == 11) {
//			$readyqueryps = "UPDATE `order` SET `notification_status` = '1' WHERE (`order_number` = '$order_number')";
//			mysql_query($readyqueryps);
//		}
//}
//
//if ($_POST['notification_status'] == "Оповестить об изменениях") {
//	$readyqueryps = "UPDATE `order` SET `notification_status` = '2' WHERE (`order_number` = '$order_number')";
//	mysql_query($readyqueryps);
//}

//---------------------------
//новый кусок для активации статусов вацапа
//---------------------------


//шаг1 - проверка изменилась ли цена
$summ_data = mysql_fetch_array(mysql_query("SELECT SUM(works.work_price*works.work_count) as smm FROM `order`
                LEFT JOIN `works` ON works.work_order_number = order.order_number
                WHERE order.order_number='$order_number'"));
$summ = $summ_data['smm'];

$wa_status_check_array = mysql_query("   SELECT * FROM `order` 
                                         LEFT JOIN `contragents` ON order.contragent = contragents.id
                                         WHERE `order_number` = '$order_number'
                                         LIMIT 1");
$wa_status_check_data = mysql_fetch_array($wa_status_check_array);
echo strlen($wa_status_check_data['notification_status']);
echo strlen($wa_status_check_data['notification_number']);
if (
    ( strlen($wa_status_check_data['notification_status']) == 12) 
        and 
    (strlen($wa_status_check_data['notification_number']) == 11) 
        and 
    ($wa_status_check_data['price_change_flag'] == 1) 
        and 
    (strlen($wa_status_check_data['soglas']) == 12)
        and
    ($summ > 0)
    ) {
    mysql_query("UPDATE `order` SET `notification_status` = 2 WHERE `order_number` = '$order_number'");
    mysql_query("UPDATE `order` SET `price_change_flag` = 0 WHERE (`order_number` = '$order_number')");
}

if ((strlen($wa_status_check_data['soglas']) == 12) and ($wa_status_check_data['notification_status'] == '') and (strlen($wa_status_check_data['notification_number']) == 11) and (strlen($wa_status_check_data['soglas']) == 12) and ($summ > 0)) {
    mysql_query("UPDATE `order` SET `notification_status` = 1 WHERE `order_number` = '$order_number'");
    mysql_query("UPDATE `order` SET `price_change_flag` = 0 WHERE (`order_number` = '$order_number')");
}



file_put_contents("./_toprint/".$order_number.'-'.date("YmdHi").'-'.rand(111, 999).'.pdf', $output);
//file_put_contents($cfg['pdf_arch_path'].$order_number.'-'.date("YmdHi").'-'.rand(111, 999).'.pdf', $output);

?>
<script>window.close(); </script>
