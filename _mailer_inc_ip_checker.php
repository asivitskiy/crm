<?  //блок настроек
    include_once 'dbconnect.php';        
    include_once './inc/global_functions.php'; 
    include_once './inc/config_reader.php';     
    ?>

<?
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
					$subject = "Обновление IP адреса для ".$cfg['base_name'];
					$message = "Текущий IP-адрес:".$ip;
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($to, $subject, $message, $headers);
			}
		}
		echo "ipchecker end of script ... ok || time - ".dig_to_d(date('YmdHi'))."/".dig_to_m(date('YmdHi'))." (".dig_to_h(date('YmdHi')).":".dig_to_minute(date('YmdHi')).")";
        ?>