<?
 include_once 'dbconnect.php';        
 include_once './inc/global_functions.php'; 
 include_once './inc/config_reader.php';     

function backup_tables($timeout_of_create_file,$timeout_of_mail_file,$host,$user,$pass,$name,$tables = '*',$cfg)
{
	$timeout_of_create_file = $timeout_of_create_file*60*60;
	$timeout_of_mail_file = $timeout_of_mail_file*60*60;
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	 //print_r($tables);
	//cycle through
	foreach($tables as $table)
	{	//echo($table);
		$ttt = "SELECT * FROM `".$table."`";
		//echo $ttt;
	 	$result = mysql_query($ttt);
	 	
		/*print_r(mysql_fetch_row($result));*/
		$num_fields = mysql_num_fields($result);
		//echo($num_fields.'количество филдов<br>');
		/*$return.= 'DROP TABLE '.$table.';';*/
	 	$ttt2 = "SHOW CREATE TABLE `".$table."`";
		$row2 = mysql_fetch_row(mysql_query($ttt2));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{	/*echo($num_fields.'количество филдов<br>');*/
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO `'.$table.'` VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					/*$row[$j] = addslashes($row[$j]);*/
					/*$row[$j] = str_replace("/\n/","\\r\\n",$row[$j]);*/
					$row[$j] = str_replace("\r","",str_replace("\n", "\\r\\n", $row[$j]));
					$row[$j] = addslashes($row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	//$handle = fopen('/\\192.168.1.112\server_1\_reserved\base_backup\dbb-'.date('YmdHi').'-'.time().'.sql','w+t');
	//fwrite($handle,$return);
	//fclose($handle);
	
	
//запись в таблицу backups данных о последнем созданном бэкапе (чтобы они не создавались раз в 5 минут)
	$cur_date = date('YmdHi')*1;
	$cur_time = time()*1;
	$timeout_sql = "SELECT * FROM `backups` WHERE `backup_type`='file'  ORDER BY `id` DESC LIMIT 0,1";
	$timeout_array = mysql_query($timeout_sql);
	$timeout_data = mysql_fetch_array($timeout_array);
		if (((time())*1 - ($timeout_data['backup_time'])*1) > $timeout_of_create_file ) {
			mysql_query("INSERT INTO `backups` (backup_time,
												backup_type,
												backup_date,
												backup_place) 
												VALUES (
												'$cur_time',
												'file',
												'$cur_date',
												'')
												");
			
			$filename = $cfg['path_to_backup'].'dbb-'.date('YmdHi').'-'.time();
			/*echo $filename;*/
			$handle = fopen($filename.'.sql','w+t');
			fwrite($handle,$return);
			fclose($handle);
				
				sleep(2);

					//Заархивируем файлы
					$zip = new ZipArchive(); //Создаём объект для работы с ZIP-архивами
					$zip->open($filename.".zip", ZIPARCHIVE::CREATE); //Открываем или создаем архив, если его не существует
					$zip->addFile($filename.".sql"); //Добавляем в архив файл in.php
                    sleep(20);
                    $zip->close(); //Завершаем работу с архивом
				sleep(10);
				unlink($filename.'.sql');



                            //запись в таблицу backups данных о последней отправке бекапа на поучту)
                            //$cur_date = date('YmdHi')*1;
                            //$cur_time = time()*1;
                            //$timeout_sql = "SELECT * FROM `backups` WHERE `backup_type`='mail'  ORDER BY `id` DESC LIMIT 0,1";
                            //$timeout_array = mysql_query($timeout_sql);
                            //$timeout_data = mysql_fetch_array($timeout_array);
                            //if (((time())*1 - ($timeout_data['backup_time'])*1) > $timeout_of_mail_file ) {
                            //    mysql_query("INSERT INTO `backups` (backup_time,
                            //                                    backup_type,
                            //                                    backup_date,
                            //                                    backup_place)
                            //                                    VALUES (
                            //                                    '$cur_time',
                            //                                    'mail',
                            //                                    '$cur_date',
                            //                                    '')
                            //                                    ");
                            //    $filename_inner = "backup.zip"; //Имя файла для прикрепления
                            //
                            //    $from = "admixcrm@gmail.com"; //От кого
                            //    $subject = "backUP! ".$cfg['base_name']; //Тема
                            //    $message = "Резервная копия базы"; //Текст письма
                            //    $boundary = "---"; //Разделитель
                            //    /* Заголовки */
                            //    $headers = "From: $from\nReply-To: $from\n";
                            //    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
                            //    $body = "--$boundary\n";
                            //    /* Присоединяем текстовое сообщение */
                            //    $body .= "Content-type: text/html; charset='utf-8'\n";
                            //    $body .= "Content-Transfer-Encoding: quoted-printablenn";
                            //    $body .= "Content-Disposition: attachment; filename=".$filename_inner."\n\n";
                            //    $body .= $message."\n";
                            //    $body .= "--$boundary\n";
                            //    $file = fopen($filename.".zip", "r"); //Открываем файл
                            //    $text = fread($file, filesize($filename.".zip")); //Считываем весь файл
                            //    fclose($file); //Закрываем файл
                            //    /* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
                            //    $body .= "Content-Type: application/octet-stream; name=".$filename_inner."\n";
                            //    $body .= "Content-Transfer-Encoding: base64\n";
                            //    $body .= "Content-Disposition: attachment; filename=".$filename_inner."\n\n";
                            //    $body .= chunk_split(base64_encode($text))."\n";
                            //    $body .= "--".$boundary ."--\n";
                            //    //mail($cfg['admin_mail'], $subject, $body, $headers); //Отправляем письмо админу
							//	//mail($cfg['owner_mail'], $subject, $body, $headers); //Отправляем письмо владельцу
//


                            }


		}


		
	
	
	
	
}
	
//процедура вызова функции
$host1 = '127.0.0.1';
$user1 = 'root';
$pass1 = '';
$name1 = 'admix';
$tocf = 1; //период создания файла бэкапа на сервере (часы)
$tomf = 24; //период отправки файла мне на почту (часы)
backup_tables($tocf,$tomf,$host1,$user1,$pass1,$name1,$tables1 = '*',$cfg);







echo "Dbdump complete ... ok || time - ".dig_to_d(date('YmdHi'))."/".dig_to_m(date('YmdHi'))." (".dig_to_h(date('YmdHi')).":".dig_to_minute(date('YmdHi')).")";
?>