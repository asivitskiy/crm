<?
	include 'dbconnect.php';
 	session_start();
 	include './inc/global_functions.php';
 	include './inc/cfg.php';
	include_once './inc/config_reader.php';
$current_manager = $_SESSION['manager'];

if (($_POST['new_chain']) <> '') {
header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/index.php?action=messages&step=new_chain');
}



/*Блок добавления записи в базу данных (запись цепочки и ее первого сообщения)*/
if (($_POST['add_new_chain']) <> '') {
$m_date = date('YmdHis');
$m_text = $_POST['message_text'];
	if (isset($_POST['names'])) {

			$m_responders = array_keys($_POST['names']);
		foreach ($m_responders as $value) {
			sendWhatsappNocheck($mng_phones_array[$value],'Добавлена новая цепочка в базе сообещений','');
		}
			$m_responders_ss = implode(',',$m_responders);
	} else {$m_responders_ss = 'all';}
	
mysql_query("INSERT INTO `messages_chains` (
`chain_header` ,
`asking_pearson` ,
`responders` ,
`date_of_chain_start` ,
`date_of_chain_update` ,
`date_of_chain_close` ,
`flag_of_chain_close`
)
VALUES (
'$m_text', 
'$current_manager', 
'$m_responders_ss', 
'$m_date', 
'$m_date', 
'', 
'0'
)");
echo mysql_error();

header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/index.php?action=messages&step=start_page');

}


if ($_GET['action'] == 'newtext') {
header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/index.php?action=messages&step=addnewtext&arg='.$_GET['chain']);
}

//проставляем завершение цепочки
if ($_GET['action'] == 'setclose') {
$idd = $_GET['chain'];
$current_date = date('YmdHis');
mysql_query("UPDATE `messages_chains` SET `flag_of_chain_close`='1' WHERE `id` = '$idd'");
mysql_query("UPDATE `messages_chains` SET `date_of_chain_close`='$current_date' WHERE `id` = '$idd'");
mysql_query("UPDATE `messages_chains` SET `chain_closer`='$current_manager' WHERE `id` = '$idd'");
	
header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/index.php?action=messages&step=start_page');
}




/*Блок добавления записи в базу данных (запись сообщения цепочки)*/
if (($_POST['add_new_text']) <> '') {
$m_date = date('YmdHi')*1;
$m_text = $_POST['message_text'];
	if (isset($_POST['names'])) {
			$m_responders = array_keys($_POST['names']);
			$m_responders_ss = implode(',',$m_responders);
	} else {$m_responders_ss = 'all';}
$text_in = $_POST['message_text'];
$chain_in = $_POST['arg'];
$date_in = date('YmdHis');
/*$text_in = addslashes($text_in);$text_in = str_replace("\r", "",$text_in);
$text_in = str_replace("\n", "\\n",$text_in);*/

mysql_query("INSERT INTO `messages_texts` (
`text_writer` ,
`message_text` ,
`text_parent_chain` ,
`message_text_date_in`
)
VALUES (
'$current_manager', 
'$text_in', 
'$chain_in',
'$date_in'
)");
echo mysql_error();
mysql_query("UPDATE `messages_chains` SET `date_of_chain_update`='$date_in' WHERE `id` = '$chain_in'");
$wa_notify_sql = "SELECT * FROM `messages_chains` WHERE `id` = '$chain_in'";
$wa_notify_data = mysql_fetch_array(mysql_query($wa_notify_sql));
$responders_array = $wa_notify_data['responders'];
	$responders_array_ss = explode(',',$responders_array);
	//print_r($responders_array_ss);
	foreach ($responders_array_ss as $value) {
		//echo $mng_phones_array[$value];
		sendWhatsappNocheck($mng_phones_array[$value],'Добавлено сообщение в существующей цепочке','');
	}


header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/index.php?action=messages&step=start_page');

}

?>






