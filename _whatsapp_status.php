<?  //блок настроек
    include_once 'dbconnect.php';        
    include_once './inc/global_functions.php'; 
    include_once './inc/config_reader.php';     
    ?>
<?
//по id сообщения и токену возвращает текущий вацап статус (отправлено, доставлено и т.д.) плюс выводит резальтат работы ид-статус 
function whatsapp_message_status($message_id,$token) {
    $string = file_get_contents(("https://wamm.chat/api2/msg_state/".$token."/?msg_id=".$message_id));;
    $start_pos = strripos($string,'{');
    $end_pos = stripos($string,'}');
    $nobrackets = substr($string,$start_pos+1,$end_pos-$start_pos-1);
    $arr_main = explode(',',$nobrackets);
    $status = explode(':',$arr_main[2]);
    $message_status = str_replace('"',"",$status[1]);
    echo $message_id."->".$message_status."<br>";
    return $message_status;
}

//проверяет все новые либо недоставленные сообщения
function whataspp_message_status_checker($token) {
    $sql = "SELECT * FROM `whatsapp_messages` WHERE ((`status_w` <> 'no info') and (`status_w` <> 'sent') and (`status_w` <> 'delivered') and (`status_w` <> 'viewed') and ((`status_w` <> 'NoAccount')))";
    $arr = mysql_query($sql);
    while ($data = mysql_fetch_array($arr)) {
        $cur_id = $data['message_id'];
        $cur_status = whatsapp_message_status($cur_id,$token);
        mysql_query("UPDATE `whatsapp_messages` SET `status_w` = '$cur_status' WHERE `message_id` = '$cur_id'");
    }
}

function delete_noaccount_number($main_mail) {
    $sql = "SELECT *,contragents.id as cid FROM `whatsapp_messages` 
            LEFT JOIN `order` ON order.order_number = whatsapp_messages.order_number_w
            LEFT JOIN `contragents` ON order.contragent = contragents.id
            WHERE ((`status_w` = 'NoAccount') and (`wrong_number_status` <> 1))
            GROUP BY whatsapp_messages.message_id";
    $arr = mysql_query($sql);
    while ($data = mysql_fetch_array($arr)) {
    $cur_id = $data['message_id'];
    $order =  $data['order_number_w'];
    $cur_contragent = $data['cid'];
    $cur_contragent_contacts = $data['contacts'];
    $cur_wa_number = $data['notification_number'];
    $new_contacts = $cur_wa_number." <- нет вацапа
".$cur_contragent_contacts;
            mysql_query("UPDATE `contragents` SET `contacts` = '$new_contacts' WHERE `id` = '$cur_contragent'");
            mysql_query("UPDATE `contragents` SET `notification_number` = '' WHERE `id` = '$cur_contragent'");
    $subject = "НЕТ ВАЦАПА (Бланк ".$order.")";
    $message = "Удалён номер вацапа в бланке ".$order.".";
    $headers  = "Content-type: text/html; charset=UTF-8 \r\n";
    $headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
    mail($main_mail, $subject, $message, $headers);
    mysql_query("UPDATE `whatsapp_messages` SET `wrong_number_status` = '1' WHERE `message_id` = '$cur_id'");
    }
}

delete_noaccount_number($cfg['main_mail']);
whataspp_message_status_checker($cfg['whatsapp_token']);
echo "WhatsappStatus end of script ... ok || time - ".dig_to_d(date('YmdHi'))."/".dig_to_m(date('YmdHi'))." (".dig_to_h(date('YmdHi')).":".dig_to_minute(date('YmdHi')).")";
?>