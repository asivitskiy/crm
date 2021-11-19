<?  //блок настроек
    include_once 'dbconnect.php';        
    include_once './inc/global_functions.php'; 
    include_once './inc/config_reader.php';     
    //include_once 'dbdump.php';

    /*проставляет есть цифра, нет цифры для вделения заказов для внутреннего цеха*/
$sql = "SELECT * FROM `order`
LEFT JOIN `works` ON works.work_order_number = order.order_number
LEFT JOIN `outcontragent` ON works.work_tech = outcontragent.outcontragent_fullname
WHERE order.deleted <> 1
";
$array = mysql_query($sql);
        $digital_counter = 0;
        $reorder_counter = 0;
while ($data = mysql_fetch_array($array)) {
//echo $data['order_number']."<br>";
$curorder = $data['order_number'];
    if ($curorder <> $prev_order_number) {  $digital_counter = 0;
                                            $reorder_counter = 0;}
    if (($data['outcontragent_group'] == "books") or ($data['outcontragent_alias'] == "XEROX")) {
        $digital_counter = $digital_counter + 1;
       }
    else {
        $reorder_counter = $reorder_counter + 1;
    }

    mysql_query ("UPDATE `order` SET order.order_has_digital = '$digital_counter' WHERE order.order_number = '$curorder'");
    mysql_query ("UPDATE `order` SET order.order_has_reorder = '$reorder_counter' WHERE order.order_number = '$curorder'");
    $prev_order_number = $curorder;
}
echo "digitalchecker ... ok || time - ".dig_to_d(date('YmdHi'))."/".dig_to_m(date('YmdHi'))." (".dig_to_h(date('YmdHi')).":".dig_to_minute(date('YmdHi')).")";
?>