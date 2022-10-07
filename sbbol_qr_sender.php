<?  
    include_once "./inc/dbconnect.php";
    include_once "./inc/global_functions.php";
    include_once "./inc/config_reader.php";

$sql = "SELECT * FROM `qr_pay` WHERE `qr_sended` = '0' LIMIT 1";
$array = mysql_query($sql);
while ($data = mysql_fetch_array($array)) {
    $cur_qr_id = $data['qr_pay_id'];
    $current_order_number = $data['qr_pay_order_number'];

    $current_summ = $data['qr_pay_summ'];
    $qr_href = urlencode($data['qr_code_image']);
        $sql2 = "SELECT contragents.id as cid,order.contragent,contragents.notification_number,contragents.qr_success,order.order_number FROM `contragents`
                 LEFT JOIN `order` ON order.contragent = contragents.id
                 WHERE order.order_number = '$current_order_number'";
        $array2 = mysql_query($sql2);
        $data2 = mysql_fetch_array($array2);
        $cur_phone = $data2['notification_number'];
        $cur_contragent = $data2['cid'];
            
            if ($data2['qr_success'] == 1 ) {
                $cur_msg_string =  urlencode('Ваш QR-код для оплаты заказа:').$br;
            }

            else {
                
                $cur_msg_string = urlencode('Инструкция по оплате QR:').$br;
                $cur_msg_string .= urlencode('Отсканировать QR код камерой вашего смартфона, либо воспользоваться ссылкой под ним (только для оплаты через приложение Сбербанка)').$br;
                $cur_msg_string .= urlencode('Для оплаты из приложения любого другого банка - воспользуйтесь инструкцией:').$br;
                $cur_msg_string .= urlencode('').$br;
                $cur_msg_string .= urlencode('1. Войти в приложение вашего банка.').$br;
                $cur_msg_string .= urlencode('2. Перейти в раздел «Платежи»').$br;
                $cur_msg_string .= urlencode('3. Выбрать «Оплата по QR или штрихкоду».').$br;
                $cur_msg_string .= urlencode('4. Направить камеру смартфона на QR-код.').$br;
                $cur_msg_string .= urlencode('5. Откроется экран с названием магазина (ИП Сивицкий_QR)').$br;
                $cur_msg_string .= urlencode('6. Если поле сумма не заполнено - введите сумму (её заранее сообщит менеджер)').$br;
                $cur_msg_string .= urlencode('7. Если поле сумма заполнено - подтвердите платеж').$br;
                $cur_msg_string .= urlencode('8. Пришлите нам в вацап либо на почту сформированный чек').$br;
            }
                $cur_msg = $cur_msg_string;
                $cur_getpage = 'https://wamm.chat/api2/msg_to/'.$cfg['whatsapp_token'].'/?phone='.$cur_phone.'&text='.$cur_msg;
                file_get_contents(($cur_getpage));
                $qr_image = "https://wamm.chat/api2/file_to/".$cfg['whatsapp_token']."/?phone=".$cur_phone."&url=".$qr_href;
                file_get_contents(($qr_image));
                //если сумма указана - будет выслан код с суммой, если сумма не указана либо 0 - будет прислан код с вводом суммы оплаты
                    
                if ($current_summ > 0.01) {
                    $text = urlencode("Ссылка для оплаты заказа:").$br.urlencode("https://sberbank.ru/qr/?uuid=2000044976&amount=".$current_summ);
                    $qr_by_href .= 'https://wamm.chat/api2/msg_to/'.$cfg['whatsapp_token'].'/?phone='.$cur_phone.'&text='.$text;
                } else{
                    $text = urlencode("Ссылка для оплаты заказа:").$br.urlencode("https://qr.nspk.ru/AS1A003AJ72EERKQ9G4P7KQN2NKTFRRP?type=01&bank=100000000111&crc=CF97");
                    $qr_by_href .= 'https://wamm.chat/api2/msg_to/'.$cfg['whatsapp_token'].'/?phone='.$cur_phone.'&text='.$text;
                }
                echo $qr_by_href;
                file_get_contents(($qr_by_href));
            
                mysql_query("UPDATE `contragents` SET `qr_success` = 1 WHERE `id` = '$cur_contragent'");
            




$date_of_mess = date('YmdHi');
mysql_query("UPDATE `qr_pay` SET `qr_sended` = '$date_of_mess' WHERE `qr_pay_id` = '$cur_qr_id'");
    }

?>

