<br>
<h2>Регистрация счета расхода от поставщика:</h2>
<br>
<a href="./_new_paydemands_red.php?outcontragentList">Редактирование списка</a>
<br>
<a href="./_new_paydemands_red.php?newOutcontragent">Добавить поставщика</a>
<br>

<br>


<div class="paydemand_col_wrapper">
    <!--левый столбец-->
<?php
$work_types_list_sql = "SELECT * FROM `outcontragent` WHERE outcontragent.outcontragent_group = 'outer' ORDER BY `outcontragent_id` ASC";
$work_types_list_array = mysql_query($work_types_list_sql);
while ($work_types_list_data = mysql_fetch_array($work_types_list_array)) {
    ?>

    <div class="paydemand_contragent_list_element paydemand_contragent_list_element_not_clicked pd_contragent_block"
         onclick="paydemand_req_list_generator('<? echo $work_types_list_data['outcontragent_id'];?>',this)">
         <? echo $work_types_list_data['outcontragent_fullname'];?>
    </div>
    <?
}?> 
    <br><br>
     <a href=_new_paydemands_red.php?newOutcontragent>
        <div class="paydemand_contragent_list_element paydemand_contragent_list_element_not_clicked pd_req_block">
            Добавить нового поставщика
        </div> 
    </a>

</div>

<div class="paydemand_col_wrapper" id = "req_show">
    <!--средний столбец-->
</div>

<div class="paydemand_col_wrapper" id = "form_show">
    <!--правый столбец с формой ввода данных счета расхода-->
</div>



<div style="float: left; width: 400px; margin-left: 15px;" id="showme"></div>


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

<div class="cashbox_wrapper" style="display:table-cell; margin-top:100px;">
	<?
	if (isset($_POST['paylist_demand_work_type'])) {}
	?>
<br><br>
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
		$paylist_demands_sql = "SELECT * FROM `paylist_demands` 
								LEFT JOIN `outcontragent_req` ON outcontragent_req.outcontragent_req_id = paylist_demands.paylist_demand_payer
								ORDER by `checked` ASC , `closed` ASC, `owner` DESC";
								//echo $paylist_demands_sql;
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
						$post_array = mysql_query("SELECT * FROM `outcontragent` WHERE `outcontragent_fullname` = '$owner' LIMIT 1");
						$post_array_data = mysql_fetch_array($post_array);
						$owner_id = $post_array_data['outcontragent_id'];

					?>
			<tr style="<?
				if ($paylist_demands_data['closed'] == 1) {echo 'opacity: 0.6';}
			?>">
				<td style="width: 200px;">
					<a href="?&myorder=1&noready=&showlist=&delivery=1&paylist_demand_owner=<? echo $owner_id; ?>">
					<? echo $paylist_demands_data['owner']; ?>
					</a>
				 </td>

				<td style="width: 200px;" align="right">
					<a href="?&delivery=1&myorder=1&noready=0&showlist=&paylist_demand=<? echo $paylist_demands_data['number']; ?>">
						<? echo $paylist_demands_data['number']; ?>
					</a>
				 </td>
				<td style="width: 200px;" align="right"><? 
														if ($paylist_demands_data['outcontragent_demand_new_flag'] == 1) {
															echo $paylist_demands_data['outcontragent_req_inn'];		
														} else {
															echo $paylist_demands_data['paylist_demand_payer']; }
														?>
				</td>
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
