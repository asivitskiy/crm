<?  //блок настроек
    include_once 'dbconnect.php';        
    include_once './inc/global_functions.php'; 
    include_once './inc/config_reader.php';     
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
   echo "Paylistmailer sender end of script ... ok || time - ".dig_to_d(date('YmdHi'))."/".dig_to_m(date('YmdHi'))." (".dig_to_h(date('YmdHi')).":".dig_to_minute(date('YmdHi')).")";
   ?>