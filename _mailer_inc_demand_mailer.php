<?  //блок настроек
    include_once 'dbconnect.php';        
    include_once './inc/global_functions.php'; 
    include_once './inc/config_reader.php';     
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
	echo "Demandmailer end of script ... ok || time - ".dig_to_d(date('YmdHi'))."/".dig_to_m(date('YmdHi'))." (".dig_to_h(date('YmdHi')).":".dig_to_minute(date('YmdHi')).")";
    ?>