<?
$msg_sql = "SELECT * FROM `order_messages` WHERE ((`order_number`='$order_number')) ORDER BY `id` DESC";
$msg_array = mysql_query($msg_sql);
while ($msg_data = mysql_fetch_array($msg_array)) {
	echo "<b>".dig_to_d($msg_data['date_in_message'])."-".dig_to_m($msg_data['date_in_message'])."-".dig_to_y($msg_data['date_in_message'])."[".dig_to_h($msg_data['date_in_message']).":".dig_to_d($msg_data['date_in_message'])."]</b>";
	echo("<br>");
	echo($msg_data['message']."<br>");
	
	
}
?>