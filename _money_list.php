<div class="zarplata-table">
<?php
$year_count = $_GET['year']*1;
?>
<a class="a_orderrow" href="?action=zarplata&year=2020">2020</a>
<a class="a_orderrow" href="?action=zarplata&year=2021">2021</a>
<Br>
<?php

if (($_SESSION['manager'] == 'Марина') and (isset($_GET['year']))) {

	//общая сумма неоплаченных заказов
	$dolg_opl_data = mysql_fetch_array(mysql_query("SELECT SUM(money.summ) `opl` FROM `money`"));
	$dolg_neopl_data = mysql_fetch_array(mysql_query("SELECT SUM(works.work_price * works.work_count) `neopl` FROM `works`"));
	$dolg = $dolg_neopl_data['neopl'] - $dolg_opl_data['opl'];
	echo "Сумарная задолжность: ".$dolg."<br>";
	//////////////////////////////////
	
	/////////////////////////////////////////////
	//										   //	
	// СЧИТАЕТСЯ ПРОЦЕНТНАЯ ЧАСТЬ ДОПЕЧАТНИКОВ //
	//				И дизайнеров			   //
	/////////////////////////////////////////////
	
	
	echo ("Допечатная подготовка (обороты):<br>");
	?>
	<table style=" border: 1px solid black; border-spacing: 0px;">
<tr><td>&nbsp;</td><td>янв</td><td>фев</td><td>мар</td><td>апр</td><td>май</td><td>июНь</td><td>июЛь</td><td>авг</td><td>сен</td><td>окт</td><td>ноя</td><td>дек</td></tr>
		<?
	
	
$preprinters_array[] = 'Аня';
$preprinters_array[] = 'Алиса';
/*$preprinters_array[] = 'Нет';*/
	//ставка допечатника - 1% от общей суммы заказа
	//выборка идёт
	
for ($p = 0; $p<=1; $p++) {
$imager = $preprinters_array[$p];
$imager_sql = "
SELECT *,SUM(money.summ) ordersumm ,MAX(money.date_in) as maxdate FROM `order` 
LEFT JOIN `money` ON order.order_number = money.parent_order_number

WHERE ((order.deleted = 1) and (order.preprinter = '$imager'))
GROUP BY `parent_order_number`
ORDER BY maxdate
";

$imager_array = mysql_query($imager_sql);
	while ($imager_data = mysql_fetch_array($imager_array)) {
		$month_of_ready = dig_to_m($imager_data['maxdate']);
		$year_of_ready = dig_to_y($imager_data['maxdate']);
			$cur_order = $imager_data['order_number'];
			$diz_counter_sql = "SELECT SUM(`work_price`*`work_count`) dizsum FROM `works` WHERE ((`work_order_number` = '$cur_order')and(`work_tech`='Дизайн'))";	
			$diz_counter_data = mysql_fetch_array(mysql_query($diz_counter_sql));
			
			$diz_counter[$imager][$year_of_ready][$month_of_ready] = $diz_counter[$imager][$year_of_ready][$month_of_ready] + $diz_counter_data['dizsum'];
			$order_nums[$imager][$month_of_ready][$year_of_ready][] = $imager_data['order_number'];
		
			$preprinter_amount[$imager][$year_of_ready][$month_of_ready] = $preprinter_amount[$imager][$year_of_ready][$month_of_ready] + $imager_data['ordersumm'];
	}
	

		
	for ($iy=$year_count;$iy<=$year_count;$iy++) {
		?>
		<tr>
			<td style='border:1px solid black; padding:5px;'><? echo $imager; ?></td>
		<?
		for ($im=01;$im<=12;$im++) {
			echo "<td style='border:1px solid black; padding:5px;'>";
			$str = str_pad($im, 2, 0, STR_PAD_LEFT);
			$strr = $str.'';$iyr = $iy.'';
			echo /*'['.$strr.']->'.*/$preprinter_amount[$imager][$iyr][$strr]*0.02 + $diz_counter[$imager][$iyr][$strr]*0.5."<br>";
			/*echo "<b>".$diz_counter[$imager][$iyr][$strr]."</b>";*/
			echo "</td>";
		} echo "</tr>";
	}
	
	
	
}
	
	?>
	</table>
	<?
	
	
	ob_flush();
	
	/////////////////////////////////////////////
	//										   //	
	//	СЧИТАЕТСЯ ПРОЦЕНТНАЯ ЧАСТЬ МЕНЕДЖЕРОВ  //
	//										   //
	/////////////////////////////////////////////
	
	
	
	
	//массив с менеджерами для перебора
$managers_array[] = 'Ю';
$managers_array[] = 'Н';
$managers_array[] = 'А';
$managers_array[] = 'Ч';
$managers_array[] = 'П';

//начало перебора менеджеров	
for ($i=0; $i<=4;$i++) {
$managerrrr = $managers_array[$i];	

$zp_sql = "
SELECT *,SUM(money.summ) ordersumm ,MAX(money.date_in) as maxdate FROM `order` 
LEFT JOIN `money` ON order.order_number = money.parent_order_number

WHERE ((order.deleted = 1) and (order.order_manager = '$managerrrr'))
GROUP BY `parent_order_number`
ORDER BY maxdate

";

$zp_array = mysql_query($zp_sql);

					
while ($zp_data = mysql_fetch_array($zp_array)) {
	//////////////////////////////////////
		$month_of_ready = dig_to_m($zp_data['maxdate']);
		$year_of_ready = dig_to_y($zp_data['maxdate']);
	
		$errorwork = 0;
		$temporary_order_number = $zp_data['order_number'];
				$order_details_sql = "
				SELECT * FROM `works`
				LEFT JOIN `order` ON works.work_order_number=order.order_number
				LEFT JOIN `outcontragent` ON works.work_tech=outcontragent.outcontragent_fullname
				WHERE works.work_order_number='$temporary_order_number'
										";
				$order_details_array = mysql_query($order_details_sql);
					
		
				
				while ($order_details_data = mysql_fetch_array($order_details_array)) {
				//расчет всех значений работ (перезаказы, расходы, типы работ и прочее)	
				$errorwork = 0;
				if ($order_details_data['outcontragent_group'] == 'outer') {
				// все внешние заказы (все готовые перезаказы)
					if (($order_details_data['work_rashod_list'] == '') or ($order_details_data['work_rashod'] < 0.1)) {
					$errorwork = 1; /*echo $order_details_data['order_number']."<br>";*///вычисление перезаказов без счетов расхода (тутже можно и посчитать их коилчество)
						}
				}		

					if ($errorwork <> 1) {
					switch ($order_details_data['outcontragent_group']) {
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 case 'digital':$digital_part_of_order[$managerrrr][$year_of_ready][$month_of_ready] = $digital_part_of_order[$managerrrr][$year_of_ready][$month_of_ready] + $order_details_data['work_count']*$order_details_data['work_price'];
$printer_amount[$year_of_ready][$month_of_ready] = $printer_amount[$year_of_ready][$month_of_ready] + $order_details_data['work_count']*$order_details_data['work_price'];
 	break;
 case 'outer' : $reorder_part_of_order[$managerrrr][$year_of_ready][$month_of_ready]	= $reorder_part_of_order[$managerrrr][$year_of_ready][$month_of_ready] + $order_details_data['work_count']*$order_details_data['work_price'] - $order_details_data['work_rashod'];
 	break;
 case 'design': //разбивка на свой дизайн и на дизайн принятый и отданый кому то
				if ($order_details_data['work_tech'] == 'менеджер') { $own_design_part_of_order[$managerrrr][$year_of_ready][$month_of_ready] = $own_design_part_of_order[$managerrrr][$year_of_ready][$month_of_ready]  + $order_details_data['work_count']*$order_details_data['work_price'];}
				if ($order_details_data['work_tech'] <> 'менеджер') { $design_part_of_order[$managerrrr][$year_of_ready][$month_of_ready] = $design_part_of_order[$managerrrr][$year_of_ready][$month_of_ready]  + $order_details_data['work_count']*$order_details_data['work_price'];}
								
 	break;
/*case 'design': $design_part_of_order 	= $design_part_of_order  + $order_details_data['work_count']*$order_details_data['work_price'];
 	break;*/
 case 'books' : $book_part_of_order[$managerrrr][$year_of_ready][$month_of_ready] 	= $book_part_of_order[$managerrrr][$year_of_ready][$month_of_ready]    + $order_details_data['work_count']*$order_details_data['work_price'];
$printer_amount[$year_of_ready][$month_of_ready] = $printer_amount[$year_of_ready][$month_of_ready] + $order_details_data['work_count']*$order_details_data['work_price'];
 	break;
 

 					}}
				}

}

}
//конец перебора менеджеров
    ob_flush();

//$managers_array[] = 'Ю';
//$managers_array[] = 'Н';
//$managers_array[] = 'А';
//$managers_array[] = 'Е';
//$managers_array[] = 'П';

//начало перебора менеджеров	
?>
<table style=" border: 1px solid black; border-spacing: 0px;">
<tr><td style='border:1px solid black; padding:5px;'>&nbsp;</td>
	<td style='border:1px solid black; padding:5px;'>янв</td>
	<td style='border:1px solid black; padding:5px;'>фев</td>
	<td style='border:1px solid black; padding:5px;'>мар</td>
	<td style='border:1px solid black; padding:5px;'>апр</td>
	<td style='border:1px solid black; padding:5px;'>май</td>
	<td style='border:1px solid black; padding:5px;'>июНь</td>
	<td style='border:1px solid black; padding:5px;'>июЛь</td>
	<td style='border:1px solid black; padding:5px;'>авг</td>
	<td style='border:1px solid black; padding:5px;'>сен</td>
	<td style='border:1px solid black; padding:5px;'>окт</td>
	<td style='border:1px solid black; padding:5px;'>ноя</td>
	<td style='border:1px solid black; padding:5px;'>дек</td>
</tr>
<?

for ($i=0; $i<=4;$i++) {
$managerrrr = $managers_array[$i];	
?> <tr><td style='border:1px solid black; padding:5px;' colspan=4><? echo $managerrrr; ?></td></tr><?

	
	for ($iy=$year_count;$iy<=$year_count;$iy++) {
		?>
		<tr>
			<td style='border:1px solid black; padding:5px;'><? echo 'Цифровая печать' ?></td>
		<?
		for ($im=01;$im<=12;$im++) {
			echo "<td style='border:1px solid black; padding:5px;'>";
			$str = str_pad($im, 2, 0, STR_PAD_LEFT);
			$strr = $str.'';$iyr = $iy.'';
			echo 1*$digital_part_of_order[$managerrrr][$iyr][$strr]."<br>";
			/*echo "<b>".$diz_counter[$imager][$iyr][$strr]."</b>";*/
			echo "</td>";
		} echo "</tr>";
		
		?>
		<tr>
			<td style='border:1px solid black; padding:5px;'><? echo 'Перезаказы(разница)' ?></td>
		<?
		for ($im=01;$im<=12;$im++) {
			echo "<td style='border:1px solid black; padding:5px;'>";
			$str = str_pad($im, 2, 0, STR_PAD_LEFT);
			$strr = $str.'';$iyr = $iy.'';
			echo 1*$reorder_part_of_order[$managerrrr][$iyr][$strr]."<br>";
			/*echo "<b>".$diz_counter[$imager][$iyr][$strr]."</b>";*/
			echo "</td>";
		} echo "</tr>";
		
		?>
		<tr>
			<td style='border:1px solid black; padding:5px;'><? echo 'Принятый дизайн' ?></td>
		<?
		for ($im=01;$im<=12;$im++) {
			echo "<td style='border:1px solid black; padding:5px;'>";
			$str = str_pad($im, 2, 0, STR_PAD_LEFT);
			//вот тут вставляется юрин оборот от менеджеров (сувенирка которую скинули)
			//формируются две даты для фильтра в запросе
			$jur_start = $iy.$str.'000000';
			$ttt = $str+1;
			$jur_end = $iy.str_pad($ttt, 2, 0, STR_PAD_LEFT).'000000';
			//echo $jur_start.'->'.$jur_end;
			if ($managerrrr == 'П') {
//////////////////////юра//////////////////////////////
				$month = $im;
				$year = $iy;
				$amount_summ_inner = 0;
				$amount_summ_outer_rashod = 0;
				$amount_summ_outer = 0;
				$jur_sql = "
				SELECT * FROM `order` 
				LEFT JOIN `works` ON order.order_number = works.work_order_number
				WHERE ((order.order_manager = 'П') and (order.date_in > ".$year.str_pad((string)$month*1, 2, '0', STR_PAD_LEFT)."000000) and (order.date_in < ".$year.str_pad((string)$month*1+1, 2, '0', STR_PAD_LEFT)."000000))";
				$jur_array = mysql_query($jur_sql);
				while ($jur_data = mysql_fetch_array($jur_array)) {
					
					if ($jur_data['work_rashod'] > 0) {
						$amount_summ_outer = $amount_summ_outer + $jur_data['work_price'] * $jur_data['work_count'];
						$amount_summ_outer_rashod = $amount_summ_outer_rashod + $jur_data['work_rashod'];
					} 
					else {
						$amount_summ_inner = $amount_summ_inner + $jur_data['work_price'] * $jur_data['work_count'];
					}
				}
				echo $amount_summ_outer; echo ' сумма перезаказных позиций <br>';
				echo $amount_summ_outer_rashod; echo ' расход по перезаказным позициям <br>';
				echo $amount_summ_inner; echo ' собственные заказы<br>';
////////////////////////////////////////////////////////
			}		else {	


			//а вот тут не для юры блок а для остальных менеджеров
			$strr = $str.'';$iyr = $iy.'';
			echo 1*$design_part_of_order[$managerrrr][$iyr][$strr]."<br>";
			/*echo "<b>".$diz_counter[$imager][$iyr][$strr]."</b>";*/
			}
			echo "</td>";
		} echo "</tr>";
		
		
		?>
		<tr>
			<td style='border:1px solid black; padding:5px;'><? echo 'Свой дизайн<br>(сам сделал)'; ?></td>
		<?
		for ($im=01;$im<=12;$im++) {
			echo "<td style='border:1px solid black; padding:5px;'>";
			$str = str_pad($im, 2, 0, STR_PAD_LEFT);
			$strr = $str.'';$iyr = $iy.'';
			echo 1*$own_design_part_of_order[$managerrrr][$iyr][$strr]."<br>";
			/*echo "<b>".$diz_counter[$imager][$iyr][$strr]."</b>";*/
			echo "</td>";
		} echo "</tr>";
		
		
		?>
		<tr>
			<td style='border:1px solid black; padding:5px;'><? echo 'Тетради'; ?></td>
		<?
		for ($im=01;$im<=12;$im++) {
			echo "<td style='border:1px solid black; padding:5px;'>";
			$str = str_pad($im, 2, 0, STR_PAD_LEFT);
			$strr = $str.'';$iyr = $iy.'';
			echo 1*$book_part_of_order[$managerrrr][$iyr][$strr]."<br>";
			/*echo "<b>".$diz_counter[$imager][$iyr][$strr]."</b>";*/
			echo "</td>";
		} echo "</tr>";
		
		
		?>
		<tr>
			<td style='border:1px solid black; padding:5px;'><? echo 'Итог(зп за месяц)'; ?></td>
		<?
		for ($im=01;$im<=12;$im++) {
			echo "<td style='border:1px solid black; padding:5px;'>";
			$str = str_pad($im, 2, 0, STR_PAD_LEFT);
			$strr = $str.'';$iyr = $iy.'';
			$zp[$managerrrr][$iyr][$strr] = 
				$book_part_of_order[$managerrrr][$iyr][$strr]*0.05+
				$own_design_part_of_order[$managerrrr][$iyr][$strr]*0.5+
				$design_part_of_order[$managerrrr][$iyr][$strr]*0.1+
				$reorder_part_of_order[$managerrrr][$iyr][$strr]*0.25+
				$digital_part_of_order[$managerrrr][$iyr][$strr]*0.06;
				
				
			if ($managerrrr == 'А') {$dop = $preprinter_amount['Аня'][$iyr][$strr]*0.02 + $diz_counter['Аня'][$iyr][$strr]*0.5;}	
			echo 1*$zp[$managerrrr][$iyr][$strr]+$dop;$dop = 0;
			/*echo "<b>".$diz_counter[$imager][$iyr][$strr]."</b>";*/
			echo "</td>";
		} echo "</tr>";
		
		
		
		
		
	}
}
	?>
	</table>
	<?
	}

echo '<br>Цифра+тетради для зарплаты печатки<br>';
for ($iy=$year_count;$iy<=$year_count;$iy++) {
		
		for ($im=01;$im<=12;$im++) {
			echo "<td style='border:1px solid black; padding:5px;'>";
			$str = str_pad($im, 2, 0, STR_PAD_LEFT);
			$strr = $str.'';$iyr = $iy.'';
			echo ' ['.$iyr.'/'.$strr.'] -> '.$printer_amount[$iyr][$strr].' ';
			
			
		} 
	}



echo '<br>Калькулятор оборотов<br>';
//прошлый месяц
$interval_summ 		= 0;
$interval_rashod 	= 0;
$start_interval = date('YmdHi', mktime(0, 0, 0, date('m'), 1))*1;
$end_interval = date('YmdHi', mktime(0, 0, 0, date('m') - 1, 1))*1;
/*echo $end_interval; echo $start_interval;*/
$interval_order_sql = "SELECT `order_number` FROM `order` WHERE ((`date_in` < '$start_interval') and (`date_in` > '$end_interval'))";
$interval_order_array = mysql_query($interval_order_sql);
while ($interval_order_data = mysql_fetch_array($interval_order_array)) {
	$interval_works_number = $interval_order_data['order_number'];
	
	$interval_works_sql = "SELECT * FROM `works` WHERE `work_order_number` = '$interval_works_number'";
	$interval_works_array = mysql_query($interval_works_sql);
	while ($interval_works_data = mysql_fetch_array($interval_works_array)) {
		$interval_summ = $interval_summ + $interval_works_data['work_count']*$interval_works_data['work_price'];
		$interval_rashod = $interval_rashod + $interval_works_data['work_rashod'];
	}

}

echo 'Объем принятых заказов за прошлый месяц: '.$interval_summ.'<br>';
echo 'Объем расходов на перезаказы за прошлый месяц: '.$interval_rashod.'<br>';

?> <br><br><?
//текущий месяц
$interval_summ 		= 0;
$interval_rashod 	= 0;
$start_interval = date('YmdHi', mktime(0, 0, 0, date('m'), 1))*1;
$end_interval = date('YmdHi', mktime(0, 0, 0, date('m') - 1, 1))*1;
/*echo $end_interval; echo $start_interval;*/
$interval_order_sql = "SELECT `order_number` FROM `order` WHERE ((`date_in` > '$start_interval'))";
$interval_order_array = mysql_query($interval_order_sql);
while ($interval_order_data = mysql_fetch_array($interval_order_array)) {
	$interval_works_number = $interval_order_data['order_number'];
	
	$interval_works_sql = "SELECT * FROM `works` WHERE `work_order_number` = '$interval_works_number'";
	$interval_works_array = mysql_query($interval_works_sql);
	while ($interval_works_data = mysql_fetch_array($interval_works_array)) {
		$interval_summ = $interval_summ + $interval_works_data['work_count']*$interval_works_data['work_price'];
		$interval_rashod = $interval_rashod + $interval_works_data['work_rashod'];
	}

}

echo 'Объем принятых заказов за текущий месяц: '.$interval_summ.'<br>';
echo 'Объем расходов на перезаказы за текущий месяц: '.$interval_rashod.'<br>';


$oborot_period = dig_to_m(date("YmdHi"))."";


//приход денег за прошлый месяц
echo '<br> Приход денег за прошлый месяц<br>';
$oborot_sql = "SELECT * FROM `money` WHERE ((`date_in` > ".$year_count.str_pad($oborot_period-1,2,'0',STR_PAD_LEFT)."000000) and (`date_in` < $year_count".str_pad($oborot_period,2,'0',STR_PAD_LEFT)."000000))";
/*echo $oborot_sql;*/
$oborot_array = mysql_query($oborot_sql);
while ($oborot_data = mysql_fetch_array($oborot_array)) {
	if (($oborot_data['paymethod'] == 'Терм')) {
		$oborot_bnal = $oborot_bnal + $oborot_data['summ']*1;
		
	}
	if (($oborot_data['paymethod'] == 'Нал ЧЕК')) {
		$oborot_nal = $oborot_nal + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'Нал')) {
		$oborot_nal_b = $oborot_nal_b + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'ООО')) {
		$oborot_ooo = $oborot_ooo + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'ИП')) {
		$oborot_ip = $oborot_ip + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'СБОЛ')) {
		$oborot_sbol = $oborot_sbol + $oborot_data['summ']*1;
		
	}
	
}
echo('Терминал / '.$oborot_bnal);echo("<br>");
echo('Нал Чек  / '.$oborot_nal);echo("<br>");
echo('Нал      / '.$oborot_nal_b);echo("<br>");
echo('ООО      / '.$oborot_ooo);echo("<br>");
echo('ИП       / '.$oborot_ip);echo("<br>");
echo('СБОЛ     / '.$oborot_sbol);echo("<br>");

//приход денег за ткущий месяц
echo '<br> Приход денег за текущий месяц<br>';
$oborot_sql = "SELECT * FROM `money` WHERE ((`date_in` > $year_count".str_pad($oborot_period,2,'0',STR_PAD_LEFT)."000000) and (`date_in` < $year_count".str_pad($oborot_period+1,2,'0',STR_PAD_LEFT)."000000))";
/*echo $oborot_sql;*/
$oborot_array = mysql_query($oborot_sql);
while ($oborot_data = mysql_fetch_array($oborot_array)) {
	if (($oborot_data['paymethod'] == 'Терм')) {
		$oborot_bnal_now = $oborot_bnal_now + $oborot_data['summ']*1;
		
	}
	if (($oborot_data['paymethod'] == 'Нал ЧЕК')) {
		$oborot_nal_now = $oborot_nal_now + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'Нал')) {
		$oborot_nal_b_now = $oborot_nal_b_now + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'ООО')) {
		$oborot_ooo_now = $oborot_ooo_now + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'ИП')) {
		$oborot_ip_now = $oborot_ip_now + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'СБОЛ')) {
		$oborot_sbol_now = $oborot_sbol_now + $oborot_data['summ']*1;
		
	}
	
}
echo('Терминал / '.$oborot_bnal_now);echo("<br>");
echo('Нал Чек  / '.$oborot_nal_now);echo("<br>");
echo('Нал      / '.$oborot_nal_b_now);echo("<br>");
echo('ООО      / '.$oborot_ooo_now);echo("<br>");
echo('ИП       / '.$oborot_ip_now);echo("<br>");
echo('СБОЛ     / '.$oborot_sbol_now);echo("<br>");




?>
</div>
