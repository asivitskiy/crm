<?
$cur_date = date("YmdHi");
$plan_date = date("Y")."-".date("m")."-".(date("d"));
$plan_time = date("H").":00";

?>
<div class="cashbox_wrapper" style="overflow: visible;;">
<br><br>
<a class="a_orderrow" href="?action=qr_checker">Учет и проверка QR кодов</a>
<br><br>
<form method="get" action="">
Дата отчета:<br>
<input type="hidden" name="action" value="cashbox">
<input type="date" name="date" value="<? if(!isset($_GET['date'])){ echo $plan_date;} else {echo $_GET['date'];}?>"><input type=submit value="показать">
</form>

<table class="cashbox_table" border="1" cellspacing="0">
	 	<tr class="">
	 		<td>Бланк</td>
	 		<td>Клиент</td>
	 		<td>ООО</td>
	 		<td>ИП</td>
	 		<td>Терминал</td>
	 		<td>Нал()</td>
	 		<td>Нал. чек</td>
	 		<td>СБОЛ</td>
			<td>QR</td>
	 		<td>Потеряшка<br>(нет способа оплаты)</td>
	 		<td>Пометки</td>
	 		
	 	</tr>
<?  if (isset($_GET['date'])) {
		$poteryashka = $sum_ooo = $sum_ip = $sum_term = $sum_nal = $sum_nal4ek = $sum_sbol = 0;
	   $filtrstart = (substr($_GET['date'],0,4).substr($_GET['date'],5,2).substr($_GET['date'],8,2))*10000;
	   $filtrend   = (substr($_GET['date'],0,4).substr($_GET['date'],5,2).substr($_GET['date'],8,2))*10000+10000;
	   // AND ((`paymethod`<>'ООО') AND (`paymethod`<>'ИП')) вставить в условие снизудля отсева ооо и ип
	   		$cashbox_query = "
			SELECT *,money.paymethod as pmm FROM `money` 
			LEFT JOIN `order` ON order.order_number = money.parent_order_number
			LEFT JOIN `contragents` ON contragents.id = order.contragent
			WHERE ((money.date_in>'$filtrstart') AND (money.date_in<'$filtrend')) 
			ORDER by money.date_in DESC
			";
	   		$cashobx_array = mysql_query($cashbox_query);
			
	   			while ($cashbox_data = mysql_fetch_array($cashobx_array)) {
				//	echo($cashbox_data['summ'].' - '.$cashbox_data['parent_order_manager'].$cashbox_data['parent_order_number'].'<br>');
					?>
					
					
						 <tr>
	 						<td><a class="cashboxBlank" target="_blank" href="index.php?check&action=redact&order_manager=<? echo $cashbox_data['parent_order_manager']; ?>&order_number=<? echo $cashbox_data['parent_order_number']; ?>">
	 							<? echo $cashbox_data['parent_order_manager'].'-'.$cashbox_data['parent_order_number']; ?>
                            </td>
	 						<td><? echo $cashbox_data['name'];?></td>
	 						<td><? if ($cashbox_data['pmm'] == 'ООО') {echo $cashbox_data['summ'];	$sum_ooo=$sum_ooo+$cashbox_data['summ'];}	 	?></td>
	 						<td><? if ($cashbox_data['pmm'] == 'ИП') {echo $cashbox_data['summ'];		$sum_ip=$sum_ip+$cashbox_data['summ'];} 	 	?></td>
	 						<td><? if ($cashbox_data['pmm'] == 'Терм') {echo $cashbox_data['summ'];	$sum_term=$sum_term+$cashbox_data['summ'];}  	?></td>
	 						<td><? if ($cashbox_data['pmm'] == 'Нал') {echo $cashbox_data['summ'];	$sum_nal=$sum_nal+$cashbox_data['summ'];}    	?></td>
	 						<td><? if ($cashbox_data['pmm'] == 'Нал ЧЕК') {echo $cashbox_data['summ'];$sum_nal4ek=$sum_nal4ek+$cashbox_data['summ'];} ?></td>
	 						<td><? if ($cashbox_data['pmm'] == 'СБОЛ') {echo $cashbox_data['summ'];	$sum_sbol=$sum_sbol+$cashbox_data['summ'];}  	?></td>
	 						<td><? if ($cashbox_data['pmm'] == 'QR') {echo $cashbox_data['summ'];	$sum_qr=$sum_qr+$cashbox_data['summ'];}  	?></td>
	 						<td><? if ($cashbox_data['pmm'] == '') {echo $cashbox_data['summ'];$poteryashka = $poteryashka+$cashbox_data['summ'];}  ?></td>
	 						<td>
	 							<? $cashbox_order_number = $cashbox_data['parent_order_number'];
								$cashbox_order_number_array = mysql_query("SELECT `paylist` FROM `order` WHERE `order_number` = '$cashbox_order_number'");
								$cashbox_order_number_data = mysql_fetch_array($cashbox_order_number_array);
								echo $cashbox_order_number_data['paylist'];
								?>
	 						</td>
	 					</tr>
						
					
					
					<?
					$day_nal_summ = 0;
				}	?>	
						<tr>
							<td><? echo (''); ?></td>
							<td><? echo (''); ?></td>
							<td><? echo ($sum_ooo); ?></td>
							<td><? echo ($sum_ip); ?></td>
							<td><? echo ($sum_term); ?></td>
							<td><? echo ($sum_nal); ?></td>
							<td><? echo ($sum_nal4ek); ?></td>
							<td><? echo ($sum_sbol); ?></td>
							<td><? echo ($sum_qr); ?></td>
							<td>ИТОГ -> </td>
							<td><? echo ($sum_ooo+$sum_ip+$sum_term+$sum_nal+$sum_nal4ek+$sum_sbol+$poteryashka); ?></td>
							
						</tr>
	
	
	
					<?		}
	   
	   ?>
	   
	  
	 

	 	
	 	
	 </table>

    </div>