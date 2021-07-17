<!--Файл - рассыльщик, стоит на автозапуске раз в пять минут

1 - запрос айпишника внешнего, и если изменился - отправить на почту-->

<?  include 'dbconnect.php'; 
	include './inc/global_functions.php';
    include './inc/config_reader.php';    
   


set_time_limit(0);
?>
<? require 'dbdump.php'; // подключение отправки бэкапа на сервер и на почту?>
<?  if ($cfg['whatsapp'] == '1'){ include '_whatsapp.php'; } ?>

<?  //отправка счетов и прочего на почту

	$ip_sender_array = mysql_query("SELECT * FROM `ip_sender` LIMIT 1");
	$ip_sender_data = mysql_fetch_array($ip_sender_array);
	$current_ip = $ip_sender_data['ip'];
		if (((date("YmdHi")*1) - ($ip_sender_data['last_try']*1)) >= 1) {
            
			$ip = file_get_contents('http://api.ipify.org');
            if ($ip == '') {
                $ip = file_get_contents('http://ip-api.com/php/?fields=query');
                $pos = strripos($ip,':"');
                $string = substr($ip,$pos+2);
                $pos2 = strripos($string,'";}');
                $string2 = substr($string,0,$pos2);
                $ip = $string2;
            }
			$last_try = date("YmdHi");
			mysql_query("UPDATE `ip_sender` SET `ip`='$ip',`last_try`='$last_try' WHERE (`id`=1)");
			if (($ip <> $ip_sender_data['ip']) and ($ip <> '')) { 
					$to  = $cfg['admin_mail'] ;
					$subject = "Обновление IP адреса";
					$message = "Текущий IP-адрес:".$ip;
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($to, $subject, $message, $headers);

                    $to  =  $cfg['owner_mail'] ;
					$subject = "Обновление IP адреса";
					$message = "Текущий IP-адрес:".$ip;
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($to, $subject, $message, $headers);
			}
		}
?>

<?
	$paylist_sender_array = mysql_query("SELECT * FROM `paylist_demands`");
	while ($paylist_sender_data = mysql_fetch_array($paylist_sender_array)) {
		
		if ($paylist_sender_data['paylist_demands_mailed'] == 0) {
				
					$id = $paylist_sender_data['id'];
					$subject = "Регистрация счета расхода (".$paylist_sender_data['number'].") - (".$paylist_sender_data['owner'].")";
					$message = "Регистрация счета расхода (".$paylist_sender_data['number'].") - (".$paylist_sender_data['owner'].")";
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($cfg['money_man'], $subject, $message, $headers);
					mysql_query("UPDATE `paylist_demands` SET `paylist_demands_mailed`=1 WHERE (`id`='$id')");
			
		}
	}
?>



<? 
   $mail_sender_sql = "SELECT * FROM `order` 
   					   LEFT JOIN `contragents` ON contragents.id = order.contragent
					   WHERE ((`paystatus` <> '') and (`paylist` = ''))";
   $mail_sender_array = mysql_query($mail_sender_sql);
   while ($mail_sender_data = mysql_fetch_array($mail_sender_array)) {
   			$order_number = $mail_sender_data['order_number'];
	   		$send_check_sql = "SELECT * FROM `mail_sender` WHERE `occasion` = '$order_number'";
			$send_check_array = mysql_query($send_check_sql);
			$row_count = mysql_num_rows($send_check_array);
			/*echo $row_count;*/
			if ($row_count == 0) {
				$mail_date = date("YmdHi");
				
				mysql_query("INSERT INTO `mail_sender` (`occasion`,`mail_date`) VALUES ('$order_number','$mail_date')");
			
					$subject1 = "".$mail_sender_data['order_manager']."-".$mail_sender_data['order_number']." от ".$mail_sender_data['name']." -- Запрос счета";
					$message1 = mail_body($order_number);
					$headers1  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers1 .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					echo $subject1;
					mail($cfg['money_man'], $subject1, $message1, $headers1);
			}
   }

//actualizer - статусы меняет заказам (работает по таблице ордеров)
set_time_limit(0);

$check_sql = "SELECT `order_number`,`preprint` FROM `order` WHERE `order_status-check` = 0";
$check_array = mysql_query($check_sql);

while ($check_data = mysql_fetch_array($check_array)) {
    $current_order_number = $check_data['order_number'];
    $work_check_array = mysql_query("   SELECT * FROM `works`
                                        LEFT JOIN `outcontragent` ON works.work_tech = outcontragent.outcontragent_fullname 
                                        WHERE `work_order_number` = '$current_order_number'");

    $dis_flag = 0;
    $error_flag = 0;
    $reorder_flag = 0;

    while ($work_check_data = mysql_fetch_array($work_check_array)) {
        if ($work_check_data['outcontragent_group'] == 'outer') {$reorder_flag = 1;}
        if ($work_check_data['outcontragent_group'] == 'design') {$dis_flag = 1;}
        if (($work_check_data['outcontragent_group'] == 'design') and (strlen($check_data['preprint']) == 12)) {$dis_flag = 2;}
        if (($work_check_data['outcontragent_group'] == 'design') and ($check_data['preprint'] == 'Нет')) {$dis_flag = 2;}
        if ($work_check_data['work_tech'] == '') {$error_flag = 1;}
        if (
            ($work_check_data['outcontragent_group'] == 'outer')
            and
            (($work_check_data['work_rashod_list'] == '' ) or ($work_check_data['work_rashod'] == 0))
        )
        {$error_flag = 1;}
        if (
            ( ($work_check_data['work_rashod_list'] == '')and($work_check_data['work_rashod']*1 > 0) )
            or
            ( ($work_check_data['work_rashod_list'] <> '')and($work_check_data['work_rashod']*1 == 0) )
        )
        {$error_flag = 1;}




    }


    mysql_query("UPDATE `order` SET `order_status-check`=1 WHERE `order_number` = '$current_order_number'");
    mysql_query("DELETE FROM `order_vars` WHERE `order_vars-order_id` = '$current_order_number'");
    mysql_query("INSERT INTO `order_vars` (`order_vars-order_id`,`order_vars-design_flag`,`order_vars-reorder_flag`,`order_vars-error`) VALUES ($current_order_number,$dis_flag,$reorder_flag,$error_flag)");




}

?>

<? //sorter - сортировку клиентов делает и сумму долгов / заказов обновляет (то есть работает по таблице контрагентов)
$contragent_sql = "SELECT * FROM `contragents`";
$contragent_array = mysql_query($contragent_sql);
while($contragent_data = mysql_fetch_array($contragent_array)) {
    $amount = 0;
    $dolg = 0;
    $ssss = $contragent_data['id'];
    $inwork = 0;
    $completed = 0;
    $allworks = 0;
    $allmoney = 0;
    /*echo 'asdasd'.$ssss;*/
    $order_counter_sql = mysql_query("SELECT * FROM `order` WHERE `contragent` = '$ssss'");

    while ($order_data = mysql_fetch_array($order_counter_sql)) {
        $cur_order = $order_data['order_number'];/*echo '['.$cur_order.']';*/

        if ($order_data['deleted'] == 0) {
            $works_sql_dolg = "SELECT SUM(works.work_count*works.work_price) as summm FROM `works` WHERE ((`work_order_number` = '$cur_order')) LIMIT 1";
            $works_array_dolg = mysql_query($works_sql_dolg);
            $works_data_dolg = mysql_fetch_array($works_array_dolg);
            $inwork = $inwork*1 + $works_data_dolg['summm']*1;}

        if ($order_data['deleted'] == 1) {
            $works_sql_amount = "SELECT SUM(works.work_count*works.work_price) as summm FROM `works` WHERE ((`work_order_number` = '$cur_order')) LIMIT 1";
            $works_array_amount = mysql_query($works_sql_amount);
            $works_data_amount = mysql_fetch_array($works_array_amount);
            $completed = $completed*1 + $works_data_amount['summm']*1;}

        $allworks_sql_amount = "SELECT SUM(works.work_count*works.work_price) as summm FROM `works` WHERE ((`work_order_number` = '$cur_order')) LIMIT 1";
        $allworks_array_amount = mysql_query($allworks_sql_amount);
        $allworks_data_amount = mysql_fetch_array($allworks_array_amount);
        $allworks = $allworks*1 + $allworks_data_amount['summm']*1;

        $allmoney_sql = "SELECT SUM(summ) as smmm FROM `money` WHERE `parent_contragent` = '$ssss'";
        $allmoney_array = mysql_query($allmoney_sql);
        $allmoney_data = mysql_fetch_array($allmoney_array);
        $allmoney = $allmoney_data['smmm'];


    }
    $amount_dolg = $allworks*1 - $allmoney*1;
    mysql_query("UPDATE `contragents` SET `contragent_completed` = '$completed' WHERE `id` = '$ssss'");
    mysql_query("UPDATE `contragents` SET `contragent_inwork` = '$inwork' WHERE `id` = '$ssss'");
    mysql_query("UPDATE `contragents` SET `contragent_amount` = '$allworks' WHERE `id` = '$ssss'");
    mysql_query("UPDATE `contragents` SET `contragent_dolg` = '$amount_dolg' WHERE `id` = '$ssss'");
    if (($inwork == 0) and (abs($allmoney - $allworks)>0.1)) {echo '<a href=index.php?action=showlist&filter=client&argument='.$ssss.'>(!) </a>';}
    echo $ssss.' - всего работ (';
    echo $allworks.')      всего закрыто (';
    echo $completed.')     всего денег (';
    echo $allmoney.')     всего в работе (';
    echo $inwork.')<br>';

}



/*phpinfo();*/
$sql = "SELECT * FROM `order`
        LEFT JOIN `works` ON works.work_order_number = order.order_number
        LEFT JOIN `outcontragent` ON works.work_tech = outcontragent.outcontragent_fullname
        WHERE order.deleted <> 1
        ";
$array = mysql_query($sql);
while ($data = mysql_fetch_array($array)) {
    echo $data['order_number']."<br>";
    if (($data['outcontragent_group'] == "books") or ($data['outcontragent_alias'] == "XEROX")) {
        $curorder = $data['order_number'];
        echo $data['order_number']." имеет XEROX либо тетрадки"."<br>";
        mysql_query ("UPDATE `order` SET order.order_has_digital = '1' WHERE order.order_number = '$curorder'");

    }
    else {
        echo "нет цифры <br>";
    }
}


?>
