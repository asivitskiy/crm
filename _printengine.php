<?

include_once $_SERVER['DOCUMENT_ROOT'].'/_pdf_engine/dompdf/dompdf_config.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/dbconnect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/inc/config_reader.php';

//addtoquery = 1 => печать обычног обланка
//addtoquery = 2 => печать копии чека


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// этот файл формирует очередь печати и устанавливает статусы для вацап рассыльщика (изменилась или нет цена) / ненулевая цена / возвращение из ожидания заказа
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///
$order_number = $_GET['order_number'];

//шаг1 - проверка изменилась ли цена. если изменилась - поставить метку на отправку вацапа об изменениях и снять отметку на заказе
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
            ) { //найдены изменения цены - следовательно ставим 2 - обновление данныз по заказу
                mysql_query("UPDATE `order` SET `notification_status` = 2 WHERE `order_number` = '$order_number'");
                mysql_query("UPDATE `order` SET `price_change_flag` = 0 WHERE (`order_number` = '$order_number')");
            }

            if ((strlen($wa_status_check_data['soglas']) == 12) and ($wa_status_check_data['notification_status'] == '') and (strlen($wa_status_check_data['notification_number']) == 11) and (strlen($wa_status_check_data['soglas']) == 12) and ($summ > 0))
            {   //автоотправка если заказ был переключен из ожидания в работу
                mysql_query("UPDATE `order` SET `notification_status` = 1 WHERE `order_number` = '$order_number'");
                mysql_query("UPDATE `order` SET `price_change_flag` = 0 WHERE (`order_number` = '$order_number')");
            }



//запись бланка в очередь печати (печать и выбор принтера происходит в _printengine_processor.php )
if ($_GET['addtoquery'] == '1') {
    mysql_query("INSERT INTO `print_order` (`print_order_number`,`printed`,`printer_name`) VALUES ('$order_number','0','1')");

}

if ($_GET['addtoquery'] == '2') {
    mysql_query("INSERT INTO `print_order` (`print_order_number`,`printed`,`printer_name`) VALUES ('$order_number','0','2')");

}


//echo $order_number;
//$aa = file_get_contents('http://192.168.1.221/_pdf_engine/index.php?order_number='.$order_number);
//$aa = file_get_contents('http://192.168.1.221/_pdf_engine_check/index.php?order_number='.$order_number);
if ($_GET['addtoquery'] == 'forceMessage') {
    echo "<script>window.close()</script>";
}
?>