<div class="clientblock"><h3>Список клиентов</h3> (долги/обороты обновляются раз в 30 минут)<br><br>
    <?
if (!isset($_GET['red_num'])) {

$client_list_sql = "SELECT * FROM `contragents` ORDER by `contragent_dolg` DESC";
$client_list_array = mysql_query($client_list_sql);
echo "<table class='clientlist_table'>";
while ($client_list_data = mysql_fetch_array($client_list_array)) {
$number_of_orders = 0;
$order_price = 0;
$order_pays = 0;
$contragent_id = $client_list_data['id'];
																   //echo($contragent_id);
//достаём айди текущего заказчика чтобы после этого  искать его заказы
      $client_order_sql = "SELECT * FROM `order` WHERE `contragent` = '$contragent_id'";
      $client_order_query = mysql_query($client_order_sql);
//перебор заказов клиента для просчета общей суммы
				while ($client_order_data = mysql_fetch_array($client_order_query)) {
				$number_of_orders = $number_of_orders + 1;
				$order_manager = $client_order_data['order_manager'];$order_number = $client_order_data['order_number'];//echo($order_manager);echo($order_number);
					$work_of_order_sql = "SELECT * FROM `works` WHERE ((`work_order_manager` = '$order_manager') AND (`work_order_number` = '$order_number'))";
					$work_of_order_query = mysql_query($work_of_order_sql);
//перебор работ в заказе для расчета общей суммы
					while ($work_of_order_data = mysql_fetch_array($work_of_order_query)) {
						$workprice = $work_of_order_data['work_price'] * $work_of_order_data['work_count'];
						$order_price = $workprice + $order_price;
					}
			}
//перебор оплат для вычисления общей суммы оплат
	$order_pays_sql = "
	SELECT * FROM `order` 
	LEFT JOIN `money` ON money.parent_order_number = order.order_number
	WHERE ((`contragent` = '$contragent_id'))
	";
	$order_pays_query = mysql_query($order_pays_sql);
	while ($order_pays_data = mysql_fetch_array($order_pays_query)) {
		$order_pays = $order_pays + $order_pays_data['summ'];
	}
	
	
/*	$order_pays_sql = "SELECT * FROM `money` WHERE ((`parent_contragent` = '$contragent_id'))";
	$order_pays_query = mysql_query($order_pays_sql);
	while ($order_pays_data = mysql_fetch_array($order_pays_query)) {
		$order_pays = $order_pays + $order_pays_data['summ'];
	}*/
?>
    <!--<tr><td colspan="6" class="clientlist_table__spacer"></td></tr>-->
	<tr>
		<td style="width: 500px;" class="clientlist_table__header"><? echo $client_list_data['name']; ?></td>
		<td align="center"><div>всего заказов</div></td>
		<!--<td align="center"><div></div></td>-->
		<td align="center"><div>в работе</div></td>
		<td align="center"><div>закрытых</div></td>

		<td align="center"><div>долг</div></td>
		<td rowspan="2" align="right" class="clientlist_table__actions">
		    <a target="_blank" class="a_orderrow" href = "?&myorder=1&noready=0&showlist=&delivery=1&clientstring=<? echo $client_list_data['id']; ?>">Заказы клиента</a>
        </td>
	</tr>
	<tr height="15">
		<td style=><? echo $client_list_data['contacts']; ?></td>
		<td align="center"><div><? echo $client_list_data['contragent_amount']; ?> </div></td>
		<!--<td align="center"></td>-->
		<td align="center"><? echo $client_list_data['contragent_inwork']; ?></td>
		<td align="center"><? echo $client_list_data['contragent_completed']; ?></td>

		<td align="center"><div style="font-weight: 100; display: inline-block; font-size: 14px;<? if ($dolg > 0) { echo("color:red;"); } ?>"> <? echo $client_list_data['contragent_dolg']; ?></div></td>
	</tr>



<!--<input type="button" value="Редактировать" onclick="location.href = '?action=client_list&red_num=<? //echo $client_list_data['id']; ?>'"> !-->
<?}
echo "</table>";
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
