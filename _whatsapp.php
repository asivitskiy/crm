<?php
$mng_words_array['Ю'] = 'Юлия';
$mng_words_array['Н'] = 'Наталья';
$mng_words_array['А'] = 'Анна';
$mng_words_array['Е'] = 'Екатерина';
$mng_words_array['Марина'] = 'Марина';
$mng_words_array['П'] = 'Юрий';


//входное оповещение о создании или изменении заказа
$messages_sql ="SELECT *,SUM(works.work_count*works.work_price) as ordersumm FROM `order`
                LEFT JOIN `contragents` ON contragents.id = order.contragent
                LEFT JOIN `works` ON works.work_order_number = order.order_number
                WHERE ((contragents.notification_number <> '') and ((order.notification_status = 1) or (order.notification_status = 2)))
                GROUP BY order.order_number";
$messages_array = mysql_query($messages_sql);
while($messages_data = mysql_fetch_array($messages_array)) {
    $cur_phone = $messages_data['notification_number'];
    $br = '%0A';

    $manager = $mng_words_array[$messages_data['order_manager']];
    $ordernumber = $messages_data['order_number'];
    $cur_msg_string = 'Добрый день!'.$br;
        if ($messages_data['notification_status'] == 2) {$cur_msg_string .= 'Данные заказа обновлены'.$br;}
    $cur_msg_string .= 'Номер вашего заказа '.$ordernumber.$br;
    $cur_msg_string .= 'Сумма к оплате: '.number_format($messages_data['ordersumm'], 2, ',', ' ').' руб.'.$br;
    $cur_msg_string .= 'Ваш менеджер '.$manager.$br;
    $cur_msg_string .= 'Типография АДМИКС'.$br;
    $cur_msg_string .= 'Гурьевская, 78 (левый цоколь)'.$br;
    $cur_msg_string .= 'тел. +7(383)207-56-42'.$br.'сот. +7(923)240-10-20'.$br;
    $cur_msg_string .= 'zakaz@admixprint.ru';
    $cur_msg = urlencode($cur_msg_string);
    $cur_getpage = 'https://wamm.chat/api2/msg_to/'.$cfg['whatsapp_token'].'/?phone='.$cur_phone.'&text='.$cur_msg;
    $homepage = file_get_contents(($cur_getpage));
    echo $ordernumber.' отправлен <br>';
    $today=date(YmdHi);
    $update_query = "UPDATE `order` SET `notification_status` = '$today' WHERE (`order_number` = '$ordernumber')";
    mysql_query($update_query);
    sleep(1);
}


//оповещение о готовности заказа
$messages_sql ="SELECT *,SUM(works.work_count*works.work_price) as ordersumm FROM `order`
                LEFT JOIN `contragents` ON contragents.id = order.contragent
                LEFT JOIN `works` ON works.work_order_number = order.order_number
                WHERE ((contragents.notification_number <> '') and (order.notification_of_end_status = 1))
                GROUP BY order.order_number";
                //echo $messages_sql;
$messages_array = mysql_query($messages_sql);
while($messages_data = mysql_fetch_array($messages_array)) {
    $cur_phone = $messages_data['notification_number'];
    $br = '%0A';

    $manager = $mng_words_array[$messages_data['order_manager']];
    $ordernumber = $messages_data['order_number'];
    $cur_msg_string = 'Добрый день!'.$br;
    $cur_msg_string .= 'Ваш заказ готов.'.$br;
    $cur_msg_string .= 'Номер вашего заказа '.$ordernumber.$br;
    $cur_msg_string .= 'Сумма к оплате: '.number_format($messages_data['ordersumm'], 2, ',', ' ').' руб.'.$br;
    $cur_msg_string .= 'Ваш менеджер '.$manager.$br;
    $cur_msg_string .= 'Типография АДМИКС'.$br;
    $cur_msg_string .= 'Гурьевская, 78 (левый цоколь)'.$br;
    $cur_msg_string .= 'тел. +7(383)207-56-42'.$br.'сот. +7(923)240-10-20'.$br;
    $cur_msg_string .= 'zakaz@admixprint.ru';
    $cur_msg = urlencode($cur_msg_string);
    $cur_getpage = 'https://wamm.chat/api2/msg_to/'.$cfg['whatsapp_token'].'/?phone='.$cur_phone.'&text='.$cur_msg;
    $homepage = file_get_contents(($cur_getpage));
    echo $ordernumber.' отправлен <br>';
    $today=date(YmdHi);
    $update_query = "UPDATE `order` SET `notification_of_end_status` = '$today' WHERE (`order_number` = '$ordernumber')";
    mysql_query($update_query);
    sleep(1);
}


?>