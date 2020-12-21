<!--Файл - рассыльщик, стоит на автозапуске раз в пять минут

1 - запрос айпишника внешнего, и если изменился - отправить на почту-->

<?  include 'dbconnect.php'; 
	include './inc/global_functions.php';
set_time_limit(0);
?>
<? include 'dbdump.php'; // подключение отправки бэкапа на сервер и на почту?>


<?  //отправка счетов и прочего на почту
	$ip_sender_array = mysql_query("SELECT * FROM `ip_sender` LIMIT 1");
	$ip_sender_data = mysql_fetch_array($ip_sender_array);
	$current_ip = $ip_sender_data['ip'];
		if (((date("YmdHi")*1) - ($ip_sender_data['last_try']*1)) >= 1) {
			$ip = file_get_contents('https://api.ipify.org');
		/*	echo $ip;
			echo $ip_sender_data['ip'];*/
			$last_try = date("YmdHi");
			mysql_query("UPDATE `ip_sender` SET `ip`='$ip',`last_try`='$last_try' WHERE (`id`=1)");
			if (($ip <> $ip_sender_data['ip']) and ($ip <> '')) { 
				
				
					$to  = $ip_sender_data['mailed'] ;
					$subject = "Обновление IP адреса";
					$message = "Текущий IP-адрес:".$ip."<br>Ссылка для доступа в базу: <a href=http://".$ip.":3030>База</a>";
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($to, $subject, $message, $headers);
					
					$to  = "marina@admixprint.ru" ;
					$subject = "Обновление IP адреса";
					$message = "Текущий IP-адрес:".$ip."<br>Ссылка для доступа в базу: <a href=http://".$ip.":3030>База</a>";
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($to, $subject, $message, $headers);
					
					$to  = "zakaz@admixprint.ru" ;
					$subject = "Обновление IP адреса";
					$message = "Текущий IP-адрес:".$ip."<br>Ссылка для доступа в базу: <a href=http://".$ip.":3030>База</a>";
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($to, $subject, $message, $headers);
					
					$to  = 'sivikmail@gmail.com' ;
					$subject = "Обновление IP адреса";
					$message = "Текущий IP-адрес:".$ip."<br>Ссылка для доступа в базу: <a href=http://".$ip.":3030>База</a>";
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($to, $subject, $message, $headers);
					
					$to  = 'buh@ametansk.ru' ;
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
					$to  = "sales10@admixprint.ru" ;
					$subject = "Регистрация счета расхода (".$paylist_sender_data['number'].") - (".$paylist_sender_data['owner'].")";
					$message = "Регистрация счета расхода (".$paylist_sender_data['number'].") - (".$paylist_sender_data['owner'].")";
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($to, $subject, $message, $headers);
					mysql_query("UPDATE `paylist_demands` SET `paylist_demands_mailed`=1 WHERE (`id`='$id')");
			
		}
	}
?>



<? $to = 'sales10@admixprint.ru';
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
					mail($to, $subject1, $message1, $headers1);
			}
   }






?>