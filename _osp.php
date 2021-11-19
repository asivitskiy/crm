<?php
include './dbconnect.php';
include './inc/global_functions.php';
include './inc/config_reader.php';
//этот кусок синхронизирует имена контактов из базы в вацапом
//$contragents_to_update_sql = "SELECT * FROM `contragents` WHERE `notification_number` <> '' LIMIT 400,50";
//$contragents_to_update_array = mysql_query($contragents_to_update_sql);
//while ($contragents_to_update_data = mysql_fetch_array($contragents_to_update_array)) {
//    $phone_number = urlencode($contragents_to_update_data['notification_number']);
//    $c_name =  urlencode($contragents_to_update_data['name']);
//    echo $contragents_to_update_data['name']." -> ".$phone_number;
//    $res = file_get_contents("http://wamm.chat/api2/contact_to/".$cfg['whatsapp_token']."/?phone=".$phone_number."&name=".$c_name); 
//   
//}

//$month = '7';
//$year = '2021';
//$amount_summ_inner = 0;
//$amount_summ_outer_rashod = 0;
//$amount_summ_outer = 0;
//$jur_sql = "
//SELECT * FROM `order` 
//LEFT JOIN `works` ON order.order_number = works.work_order_number
//WHERE ((order.order_manager = 'П') and (order.date_in > ".$year.str_pad((string)$month*1, 2, '0', STR_PAD_LEFT)."000000) and (order.date_in < ".$year.str_pad((string)$month*1+1, 2, '0', STR_PAD_LEFT)."000000))";
//$jur_array = mysql_query($jur_sql);
//while ($jur_data = mysql_fetch_array($jur_array)) {
//    echo $jur_data['work_price']*$jur_data['work_count'];
//    echo ' расход по этому заказу - '.$jur_data['work_rashod'];
//    echo '<br>';
//    if ($jur_data['work_rashod'] > 0) {
//        $amount_summ_outer = $amount_summ_outer + $jur_data['work_price'] * $jur_data['work_count'];
//        $amount_summ_outer_rashod = $amount_summ_outer_rashod + $jur_data['work_rashod'];
//    } 
//    else {
//        $amount_summ_inner = $amount_summ_inner + $jur_data['work_price'] * $jur_data['work_count'];
//    }
//}
//echo $amount_summ_outer; echo ' сумма перезаказных позиций <br>';
//echo $amount_summ_outer_rashod; echo ' расход по перезаказным позициям <br>';
//echo $amount_summ_inner; echo ' собственные заказы<br>';


//phpinfo();
$sql_array = mysql_query("SELECT * FROM `order` WHERE `order_number` IN ('1111','1112')");
$new_array = array();
$row = mysql_fetch_assoc($sql_array);
//echo serialize($row);
$try[] = $row;
$try[] = $row;
$try[] = $row;
$try[] = $row;
$try[] = $row;
$try[] = $row;
$try[] = $row;

//print_r($try);
$array_length = count($try);
for ($i = 0;$i<=$array_length;$i++) {
echo $try[$i]['order_number'];echo "<br>";
}

//function delete_noaccont_error() {
    $sql = "SELECT * FROM `whatsapp_messages` WHERE `error_w` LIKE '%acc not autorized%'";
    $arr = mysql_query($sql);
    while ($data = mysql_fetch_array($arr)) {
        $order_with_error = $data['order_number_w'];
        
    }
//}
?>