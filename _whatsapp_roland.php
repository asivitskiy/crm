<?  //блок настроек
include_once 'dbconnect.php';
include_once './inc/global_functions.php';
include_once './inc/config_reader.php';
//$br = '! %0A ';
//функция проверяет ответ от вамчата, что там пришло. разбирает строку в массив, получает ошибку, получает номер, пишет в базу это
function checkerror($json_responce,$blank_number,$message) {
    $checkerror_string = $json_responce;
    $checkerror_string = str_replace('{','',$checkerror_string);
    $checkerror_string = str_replace('}','',$checkerror_string);

    $arr = explode(',',$checkerror_string);

    $err_array = explode(':',$arr[0]);
    $msg_number_array = explode(':',$arr[1]);
    //echo $blank_number."-> id ".$msg_number_array[1]."<br>";
    $cur_date = date('YmdHi')*1;
    mysql_query("INSERT INTO `whatsapp_messages` (`error_w` , `order_number_w` , `text`, `message_id`, `date_w`)
    VALUES ('$err_array[1]'  ,'$blank_number' , '$message',  '$msg_number_array[1]',' $cur_date')");
    return $err_array[1];
}



//входное оповещение о создании или изменении заказа
$messages_sql ="SELECT *,works.id as `works_id`,contragents.name as cname FROM `order`
             LEFT JOIN `works` ON works.work_order_number = order.order_number
             LEFT JOIN `contragents` ON contragents.id = order.contragent
             WHERE      (
                            ((works.work_roland_status = '') or (works.work_roland_status = '0')) 
                        and (works.work_tech = 'ROLAND') 
                        and (`deleted` <> '1') 
                        and (`date_of_end` = '') 
                        and ((order.preprint >200000000) or (order.preprint ='Нет')))
";
$messages_array = mysql_query($messages_sql);
while($messages_data = mysql_fetch_array($messages_array)) {
    $cur_phone = $messages_data['notification_number'];
    //$br = ' %0A ';

    $manager = $mng_words_array[$messages_data['order_manager']];
    $ordernumber = $messages_data['order_number'];
    $cur_msg_string = urlencode('Добрый день!').$br;
    $cur_msg_string .= urlencode('---------------------').$br;
    if ($messages_data['notification_status'] == 2) {$cur_msg_string .= urlencode('Данные заказа обновлены. Ожидайте сообщения о готовности.').$br;$mess_alert_for_mailer = urlencode(' (обновление)');} else {
        $cur_msg_string .= urlencode('Ваш заказ принят в работу. Ожидайте сообщения о готовности.').$br; }
    $cur_msg_string .= urlencode('---------------------').$br;
    $cur_msg_string .= urlencode('Это автоматическое сообщение о статусе заказа.').$br;
    $cur_msg_string .= urlencode('---------------------').$br;
    $mess_alert_for_mailer = urlencode(' (оформление)');
    //if ($messages_data['notification_status'] == 2) {$cur_msg_string .= 'Данные заказа обновлены'.$br;$mess_alert_for_mailer = ' (обновление)';}
    $cur_msg_string .= urlencode('Номер вашего заказа: '.$ordernumber).$br;
    $cur_msg_string .= urlencode('Сумма к оплате: '.number_format($messages_data['ordersumm'], 2, ',', ' ').' руб.').$br;
    $cur_msg_string .= urlencode('Ваш менеджер: '.$manager).$br;
    $cur_msg_string .= urlencode('---------------------').$br;
    $cur_msg_string .= urlencode('Типография АДМИКС').$br;
    $cur_msg_string .= urlencode('Гурьевская, 78  (левый цоколь)').$br;
    $cur_msg_string .= urlencode('тел. +7(383)207-56-42').$br.urlencode('сот. +7(923)240-10-20').$br;
    $cur_msg_string .= urlencode('Режим работы: ').$br.urlencode('Пн - Пт 10:00 - 19:00').$br;
    $cur_msg_string .= urlencode('zakaz@admixprint.ru').$br;
    $cur_msg_string .= urlencode('При проблемах с заказом:').$br;
    $cur_msg_string .= urlencode('z@admixprint.ru (руководитель)');
    $cur_msg = $cur_msg_string;
    $cur_getpage = 'https://wamm.chat/api2/msg_to/'.$cfg['whatsapp_token'].'/?phone='.$cur_phone.'&text='.$cur_msg;
    $homepage = file_get_contents(($cur_getpage));
    echo $ordernumber.' отправлен'.$mess_alert_for_mailer.'<br>';
    $today=date(YmdHi);
    $update_query = "UPDATE `order` SET `notification_status` = '$today' WHERE (`order_number` = '$ordernumber')";
    if (checkerror($homepage,$ordernumber,$cur_msg_string) == 0) {
        mysql_query($update_query);

    }
    sleep(2);

}

//echo $cur_getpage;
echo "WhatsappROLAND sender end of script ... ok || time - ".dig_to_d(date('YmdHi'))."/".dig_to_m(date('YmdHi'))." (".dig_to_h(date('YmdHi')).":".dig_to_minute(date('YmdHi')).")";
?>