<div style="display: block; width: 800px;">
<?
if (!isset($_GET['red_num'])) {

$client_list_sql = "SELECT * FROM `contragents` ORDER by `name` ASC";
$client_list_array = mysqli_query($connect,$client_list_sql);

while ($client_list_data = mysqli_fetch_array($client_list_array)) {
$number_of_orders = 0;
$order_price = 0;
$order_pays = 0;
$contragent_id = $client_list_data['id'];
																   //echo($contragent_id);
//достаём айди текущего заказчика чтобы после этого  искать его заказы
      $client_order_sql = "SELECT * FROM `order` WHERE `contragent` = '$contragent_id'";
      $client_order_query = mysqli_query($connect,$client_order_sql);
//перебор заказов клиента для просчета общей суммы
				while ($client_order_data = mysqli_fetch_array($client_order_query)) {
				$number_of_orders = $number_of_orders + 1;
				$order_manager = $client_order_data['order_manager'];$order_number = $client_order_data['order_number'];//echo($order_manager);echo($order_number);
					$work_of_order_sql = "SELECT * FROM `works` WHERE ((`work_order_manager` = '$order_manager') AND (`work_order_number` = '$order_number'))";
					$work_of_order_query = mysqli_query($connect,$work_of_order_sql);
//перебор работ в заказе для расчета общей суммы
					while ($work_of_order_data = mysqli_fetch_array($work_of_order_query)) {
						$workprice = floatval($work_of_order_data['work_price']) * floatval($work_of_order_data['work_count']);
						$order_price = $workprice + $order_price;
					}
			}
//перебор оплат для вычисления общей суммы оплат
	$order_pays_sql = "
	SELECT * FROM `order` 
	LEFT JOIN `money` ON money.parent_order_number = order.order_number
	WHERE ((`contragent` = '$contragent_id'))
	";
	$order_pays_query = mysqli_query($connect,$order_pays_sql);
	while ($order_pays_data = mysqli_fetch_array($order_pays_query)) {
		$order_pays = $order_pays + $order_pays_data['summ'];
	}
	
	
/*	$order_pays_sql = "SELECT * FROM `money` WHERE ((`parent_contragent` = '$contragent_id'))";
	$order_pays_query = mysql_query($order_pays_sql);
	while ($order_pays_data = mysql_fetch_array($order_pays_query)) {
		$order_pays = $order_pays + $order_pays_data['summ'];
	}*/
?>
<table style="margin-top: -4px; margin-bottom: -8px; font-family:'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, 'sans-serif'; border-color: white; border-radius: 3px; width: 850px;">
	<tr>
		<td style="font-size: 14px; font-weight: 550; width: 420px;"><? echo $client_list_data['name']; ?></td>
		<td align="left"><div style="font-size: 12px; width: 80px;">сумма</div></td>
		<td align="center"><div style="font-size: 12px;"></div></td>
		<td align="left"><div style="font-size: 12px; width: 80px;">долг</div></td>
		<td rowspan="2" align="right"><!--<input type="button" button onclick="location.href = ''" value="Карточка клиента">-->
		<a target="_blank" class="a_orderrow" href = "?action=showlist&filter=client&argument=<? echo $client_list_data['id']; ?>">карточка клиента</a>
		<!--&nbsp;<input type="button" onclick="location.href = '?action=client_list&red_num=<? /*echo $client_list_data['id'];*/ ?>'" value="Удалить">--></td>
	</tr>
	<tr height="15">
		<td style="font-size: 11px; font-weight: 350; width: 420px;"><? echo $client_list_data['contacts']; ?></td>
		<td align="left"><div style="font-weight: 500; display: inline-block; font-size: 14px;"><? echo $order_price; ?> </div></td>
		<td align="center"></td> <? $dolg = number_format(($order_price - $order_pays),2,'.',''); ?>
		<td align="left"><div style="font-weight: 100; display: inline-block; font-size: 14px;<? if ($dolg > 0) { echo("color:red;"); } ?>"> <? echo ($dolg); ?></div></td>
	</tr>
	
</table>

<!--<input type="button" value="Редактировать" onclick="location.href = '?action=client_list&red_num=<? //echo $client_list_data['id']; ?>'"> !-->

<hr>
<?}

} else {
$contragent_id = $_GET['red_num'];
$client_list_sql = "SELECT * FROM `contragents` WHERE `id`='$contragent_id'";
$client_list_array = mysql_query($client_list_sql);
$client_list_data = mysql_fetch_array($client_list_array);
	?>
	<form method="post" action="_contragent_redactor.php">
		<input type="hidden" name="id" value="<? echo $client_list_data['id']; ?>">
<textarea name="name"><? echo($client_list_data['name']); ?></textarea>	<textarea name="contacts"><? echo($client_list_data['contacts']); ?></textarea><br>
		<textarea name="address" style="width: 500px; height: 50px;"><? echo($client_list_data['address']); ?></textarea><br>
		<textarea name="fullinfo" style="width: 500px; min-height: 200px;"><? echo($client_list_data['fullinfo']); ?></textarea><br>
		<input type="submit">
	</form>
	<?
}
?>
</div>
