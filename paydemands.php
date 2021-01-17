<? //проверка на разнос оплаты с допуском рубль (если проходит - исчезает из списка выбора в заказах)
$paylist_demand_sql = "SELECT * FROM `paylist_demands` WHERE `closed` <> 1";
$paylist_demand_query = mysql_query($paylist_demand_sql);
while ($paylist_demand_data = mysql_fetch_array($paylist_demand_query)) {
	$work_rashod_list = $paylist_demand_data['number'];

	$demand_amount = 0;
	$work_search_sql = "SELECT `work_rashod` FROM `works` WHERE `work_rashod_list` = '$work_rashod_list'";
	$work_search_array = mysql_query($work_search_sql);
	while ($work_search_data = mysql_fetch_array($work_search_array)) {
		//считаем скоько из счета привязано к расходу заказов
		$demand_amount = $demand_amount + $work_search_data['work_rashod']*1;
	}


		if ((abs($paylist_demand_data['summ']-$demand_amount))<1) {
		$pid = $paylist_demand_data['id'];
		mysql_query("UPDATE `paylist_demands` SET `closed` = 1 WHERE `id` = '$pid'");
		}
	}

?>

<div class="cashbox_wrapper">

	<h3>Регистрация счетов от поставщиков</h3>

	<form action="paydemands_processor.php" method="post">
		<input type="hidden" name="paylist_flag" value="1">

		<div style="width: 200px; display: inline-block">Поставщик</div>

		<select name="paylist_demand_owner" style="width: 204px;">
			<option selected ></option>
			<?
			$work_types_sql = "SELECT * FROM `work_types` WHERE `id`>'5'";
			$work_types_query = mysql_query($work_types_sql);
			while ($work_types_data = mysql_fetch_array($work_types_query)) {
			?>
			<option><? echo $work_types_data['name']; ?></option>

			<? } ?>
		</select>

		<br><br>
		<div style="width: 204px; display: inline-block;">Номер входящего счета</div><input autocomplete="off" type="text" name="paylist_demand_number" placeholder="номер">
		<br><br>
		<div style="width: 204px; display: inline-block;">Юрлицо</div><input autocomplete="off" type="text" name="paylist_demand_payer" placeholder="юрлицо (куда платить)">
		<br><br>
		<div style="width: 204px; display: inline-block">Сумма по счету</div><input autocomplete="off" type="text" placeholder="сумма" name="paylist_demand_summ">
		<br><br>
		<input type="submit" value="Зарегистрировать счет" name="submit_flag" style="margin-left: 204px;">
		<br>
	</form>



	<?
	if (isset($_POST['paylist_demand_work_type'])) {}
	?>

	<br>Зарегистрированные счета расхода:<br><br>
	<table class="cashbox_table">
			<tr style="background-color: #cccccc">
				<td>Поставщик</td>
				<td align="right">Номер счета + дата</td>
				<td align="right">Юрлицо</td>
				<td align="right">Сумма</td>
				<td align="right">Разнесено</td>
				<td align="right">Остаток</td>
				<td align="right" style="width: 200px"></td>

			</tr>
	<?
		//******************
		//******************
		//Срез закрытых счетов, видны только супервайзерам
		//******************

		//все видят только незакрытые счета, чтобы изменить - нужно что то придумать
		/*if ($_SESSION['supervisor'] == 1) {*/
		$paylist_demands_sql = "SELECT * FROM `paylist_demands` ORDER by `checked` ASC , `closed` ASC, `owner` DESC";
        /*}*/
/*		if ($_SESSION['supervisor'] <> 1) {$paylist_demands_sql = "SELECT * FROM `paylist_demands` WHERE `closed` <> 1 ORDER by `owner` DESC";}*/



		$paylist_demands_query = mysql_query($paylist_demands_sql);
		while ($paylist_demands_data = mysql_fetch_array($paylist_demands_query)) {
		//открыт цикл перебора счетов от поставщиков
		//дальше идёт выемка из работ чтобы взаимозачет выполнить
			//номер счета расхода
			$pld_number = $paylist_demands_data['number'];

			//sql запрос в таблицу работ чтобы отыскать те работы, где этот счет указан
			$amount_work_of_paylists = 0;
			$work_of_paylist_demands_sql = "SELECT `work_rashod` FROM `works` WHERE `work_rashod_list` = '$pld_number'";
			$work_of_paylist_demands_query = mysql_query($work_of_paylist_demands_sql);
				while ($work_of_paylist_demands_data = mysql_fetch_array($work_of_paylist_demands_query)) {
					$amount_work_of_paylists = $amount_work_of_paylists + $work_of_paylist_demands_data['work_rashod'];
				}
						//поиск id поставщика
						$owner = $paylist_demands_data['owner'];
						$post_array = mysql_query("SELECT * FROM `work_types` WHERE `name` = '$owner' LIMIT 1");
						$post_array_data = mysql_fetch_array($post_array);
						$owner_id = $post_array_data['id'];

					?>
			<tr style="<?
				if ($paylist_demands_data['closed'] == 1) {echo 'opacity: 0.6';}
			?>">
				<td style="width: 200px;">
					<a href="?&myorder=1&noready=&showlist=&delivery=1&clientstring=<? echo $owner_id; ?>">
					<? echo $paylist_demands_data['owner']; ?>
					</a>
				 </td>

				<td style="width: 200px;" align="right">
					<a href="?&delivery=1&myorder=1&noready=0&showlist=&paylist_demand=<? echo $paylist_demands_data['number']; ?>">
						<? echo $paylist_demands_data['number']; ?>
					</a>
				 </td>
				<td style="width: 200px;" align="right"><? echo $paylist_demands_data['paylist_demand_payer']; ?></td>
				<td style="width: 100px;" align="right"><? echo $paylist_demands_data['summ']; ?></td>
				<td style="width: 100px;" align="right"><? echo $amount_work_of_paylists; ?></td>
				<td style="width: 100px;" align="right"><? echo number_format(abs($paylist_demands_data['summ']*1 - $amount_work_of_paylists*1),2,'.',''); ?></td>
				<td style="width: 100px;" align="right">
					<? if ($paylist_demands_data['checked'] == '') {?>
					<a href="paydemands_processor.php?id=<? echo $paylist_demands_data['id']; ?>&checked=now" style="display: inline-block; background-color: #FDA3A5; padding: 2px; border-radius: 3px;">Оплатить!</a>
					<?}?>

					<? if ($paylist_demands_data['checked'] <> '') {
			$date_string = dig_to_d($paylist_demands_data['checked']).'/'.dig_to_m($paylist_demands_data['checked']).'/'.dig_to_y($paylist_demands_data['checked']);	?>
					<a href="paydemands_processor.php?id=<? echo $paylist_demands_data['id']; ?>&checked=no" style="display: inline-block; background-color: #B3DD87; padding: 2px; border-radius: 3px;">Оплачено <? echo $date_string; ?></a>
					<?}?>

				</td>
			</tr>


		<?

		} ///тут конец общего цикла

		?>
		</table>

</div>
