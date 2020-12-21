<?
if (isset($_GET['readyorder'])) {
$curenttimerd = date("YmdHi");
$order_number = $_GET['readyorder'];
$readyquery = "UPDATE `order` SET `date_of_end` = '$curenttimerd' WHERE (`order_number` = '$order_number')";
mysql_query($readyquery);
header('Location: http://192.168.1.221/');
}

echo '';
$preprinter_list_sql = "SELECT * FROM `order` 
						LEFT JOIN `contragents` ON contragents.id = order.contragent
						WHERE ((`deleted` <> 1) and (`soglas` <> 0) and (`soglas` <> '')) ORDER by `order_number` DESC";
$preprinter_list_array = mysql_query($preprinter_list_sql);
echo "<br>";
while ($preprinter_list_data = mysql_fetch_array($preprinter_list_array)) {
	if (((strlen($preprinter_list_data['preprint']) == 12) or ($preprinter_list_data['preprint'] == "Нет")) and (strlen($preprinter_list_data['date_of_end']) <> 12) ) {
		?>
		<div class="order_row">
		<?
		
		echo "<div style=width:75px;display:inline-block; margin-left:50px;>".$preprinter_list_data['order_manager'].'-'.$preprinter_list_data['order_number']."</div>";
		echo "<a style=display:inline-block; target=_blank class=a_orderrow href=printform.php?number=".$preprinter_list_data['order_number'].">Открыть бланк</a>";
		echo "<a style='margin-left:20px;display:inline-block' class=a_orderrow href=_printer_workplace_processor.php?readyorder=".$preprinter_list_data['order_number'].">ГОТОВ!</a>";
		echo "<div style='display:inline-block; margin-left:20px;width:450px;'>&nbsp;&nbsp;&nbsp;&nbsp;".$preprinter_list_data['order_description']."</div>";
		echo "<div style='display:inline-block; margin-left:20px; '>&nbsp;&nbsp;&nbsp;&nbsp;".$preprinter_list_data['name']."</div>";
		echo "<br>";
		?>
		</div>
		<?
		
	}
}
?>