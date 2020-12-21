<? 	//данный файл выводит полностью список заказов без параметров (пока что, нужно дописать параметризацию.)
	//строки в таблице по порядку
	//по условию ставим разные запросы?>
<?php $add_cond = ''; ?>
<? //include "./_order_sorter_definitions.php" ?>

<?	/*switch ($_GET['cond']) {
		case 'not_preprinted';
			$add_cond = " and ((`preprint` = 'Аня') or ((`preprint` = 'Алиса')))";
			break;
		case 'not_printed';
			$add_cond = " and (`date_of_end` = '')";
			break;
		


}*/



						?>
<?	if (!isset($_GET['sort'])) { $sort = 'date_in';} ?>
<?	// все заказы (и свои и чужие, НЕГОТОВЫЕ)
	if (!isset($_GET['filter'])) 	{
		$query = "SELECT * FROM `order` WHERE ((`deleted` = 0)".$add_cond.") ORDER BY `$sort` DESC";
									}
	
	//заказы отфильтрованные по клиенту (обычно - из списка клиентов)
	//тут же выводится информация о клиенте
	if ((isset($_GET['filter'])) and ($_GET['filter'] == "client")) {
		$argument = $_GET['argument'];
		$query = "SELECT * FROM `order` WHERE ((`contragent` = '$argument')) ORDER BY `date_in` DESC ";
			$client_card_sql = "SELECT * FROM `contragents` WHERE `id` = '$argument'";
			$client_card_query = mysqli_query($connect,$client_card_sql);
			$client_card_data = mysqli_fetch_array($client_card_query); ?>
				<div class="clientcard"><? echo($client_card_data['name'].'<br>');
					echo($client_card_data['address'].'<br>');
					echo($client_card_data['fullinfo'].'<br>');
					echo($client_card_data['contacts'].'<br><br><br>');//include("./_contragent_redactor.php")?>
 				</div><?				}

	
	//фильтрация по менеджеру (тут - отображение только своих заказов)
	if ((isset($_GET['filter'])) and ($_GET['filter'] == "manager")) {
		$argument = $_GET['argument'];
		$query = "SELECT * FROM `order` WHERE ((`deleted` = 0) AND (`order_manager` = '$argument')".$add_cond.") ORDER BY `date_in` DESC ";
										}
	if ((isset($_GET['filter'])) and ($_GET['filter'] == "fulllist") and (isset($_GET['argument']))) {
		$argument = $_GET['argument'];
		$query = "SELECT * FROM `order` WHERE ((`id`<>'0')".$add_cond.") ORDER BY `date_in` DESC ";
										}

	if ((isset($_GET['filter'])) and ($_GET['filter'] == "archiveoverall")) {
		$query = "SELECT * FROM `order` WHERE ((`deleted` = 1)".$add_cond.") ORDER BY `date_in` DESC ";
										}

	if ((isset($_GET['filter'])) and ($_GET['filter'] == "archive")) {
		$current_manager = $_SESSION['manager'];
		$query = "SELECT * FROM `order` WHERE ((`deleted` = 1) AND (`order_manager` = '$current_manager')".$add_cond.") ORDER BY `date_in` DESC ";
										}

	if ((isset($_GET['filter'])) and ($_GET['filter'] == "delivery")) {
		$query = "SELECT * FROM `order` WHERE ((`delivery` = 1)".$add_cond.") ORDER BY `date_in` DESC ";
										}

	if ((isset($_GET['filter'])) and ($_GET['filter'] == "demand") and (isset($_GET['owner']))) {
		$argument_id = $_GET['owner'];
		$argument_name_array = mysql_query("SELECT `name` FROM `work_types` WHERE `id` = '$argument_id' LIMIT 1");
		$argument_data = mysql_fetch_array($argument_name_array);
		$argument_name = $argument_data['name'];
		$query = "SELECT `order`.* FROM `order`,`works` WHERE ((order.order_number = works.work_order_number) and (works.work_tech = '$argument_name')".$add_cond.")";
	}

	if ((isset($_GET['filter'])) and ($_GET['filter'] == "demand") and (isset($_GET['list']))) {
		$argument_list = $_GET['list'];
		$query = "SELECT `order`.* FROM `order`,`works` WHERE ((order.order_number = works.work_order_number) and (works.work_rashod_list = '$argument_list')".$add_cond.")";
	}

	if ((isset($_GET['filter'])) and ($_GET['filter'] == "contragent_paydemand") and (isset($_GET['argument']))) {
		$argument_contragent_paydemand = $_GET['argument'];
		$query = "SELECT * FROM `order` WHERE ((`paylist` = '$argument_contragent_paydemand')".$add_cond.") ORDER BY `date_in` DESC ";
	}



	//это собственно старт цикла перебора заказов для основного экрана
	//условия отбора записей сверху указаны,
	//ниже будет фильтрация по выдаче+вручению+оплате (типа не выводить готовые) ...или не будет, хер его знает

	$q = 0;
	$prev = 0;
	$res = mysqli_query($connect,$query);
	$prev_order_number = 0;
	while($row = mysqli_fetch_array($res))
	{		
		//убираем повторы
		if (($prev_order_number == 0) or ($prev_order_number <> $row['order_number'])){
		$prev_order_number 	= $row['order_number'];
		$order_manager		= $row['order_manager'];			
		$order_number	 	= $row['order_number'];	
		$amount_order 		= 0;
		$diz_flag 			= 0;
		$err_flag 			= 0;
		$reorder_flag		= 0;
			$query_works_1 = "SELECT * FROM `works` LEFT JOIN `work_types` ON works.work_tech = work_types.name WHERE ((`work_order_number`='$order_number'))";
			$res_works_1 = mysqli_query($connect,$query_works_1);
				while($row_works_1 = mysqli_fetch_array($res_works_1))
					{ 	if ($row_works_1['gotov'] <> 0) {$ready_counter = $ready_counter + 1;}
						if (($row_works_1['work_tech'] == 'Дизайн')) {$diz_flag = 1;}
						if ($row_works_1['group'] == 'outer') {$reorder_flag = 1; /*echo $reorder_flag;*/}
						//if (($row_works_1['work_tech'] == 'Дизайн') and ($row_works_1['gotov'] == 0)) {$diz_counter = $diz_counter+1;}
						$q++;
					 		if (($row_works_1['work_tech'] == '')) { $err_flag = $err_flag + 1;}
							/*if (($row_works_1['group'] == 'outer') and (($row_works_1['work_rashod_list'] == '' ) or ($row_works_1['work_rashod'] =0))) {$err_flag = $err_flag + 1;}*/
						$amount_order = $amount_order+((floatval($row_works_1['work_price']))*(floatval($row_works_1['work_count'])));
					}
			
			$err_empty_worktech_sql = "SELECT * FROM `works`  LEFT JOIN `work_types` ON works.work_tech=work_types.name  WHERE (`work_order_number`='$order_number') GROUP by works.id";
			$err_empty_worktech_array = mysqli_query($connect,$err_empty_worktech_sql);
				while($err_empty_worktech_data = mysqli_fetch_array($err_empty_worktech_array))
				{  $wrk_rashod = $err_empty_worktech_data['work_rashod'];
					if (
					
					($err_empty_worktech_data['group'] == 'outer') 
						and 
					(($err_empty_worktech_data['work_rashod_list'] == '' ) or ($err_empty_worktech_data['work_rashod'] == 0))
					
					) {$err_flag = $err_flag + 1;}	
					
					
					if (
						( ($err_empty_worktech_data['work_rashod_list'] == '')and($err_empty_worktech_data['work_rashod']*1 > 0) ) 
							or 
						( ($err_empty_worktech_data['work_rashod_list'] <> '')and($err_empty_worktech_data['work_rashod']*1 == 0) )
					) {$err_flag = $err_flag + 1; /*echo 'ХЗХЗХЗХЗХЗХЗХ'; echo $err_empty_worktech_data['work_rashod_list']; echo $err_empty_worktech_data['work_rashod'];*/}
					
				}
				
			
			
			
			
			
	if (dig_to_d($row['date_in']) <> dig_to_d($prev)) {$prev = $row['date_in'];	?>

 	 <h3 class="dator"><? echo (dig_to_d($row['date_in'])); ?>.<? echo (dig_to_m($row['date_in'])); ?>.<? echo (dig_to_y($row['date_in'])); ?></h3>
  	<? } ?>
   		<div class="order_row">
    	 <details style="font-size: 16px;">
			<summary class="workrow_summary" style="<? if ($row['deleted'] == 1) {echo ' opacity: 0.7;';} ?>">
				
				<div align="right" class="workrow_nomer_blanka"><? echo $row['order_manager'].'-'.$row['order_number']; ?>&nbsp;&nbsp;</div>
				<div style="overflow: hidden; white-space: pre;" class="workrow_contragent"><? 
							$tmp1 = $row['contragent'];
							$tmp1_array = mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM `contragents` WHERE `id`='$tmp1'"));
							echo($tmp1_array['name']);?>
				&nbsp;
				</div>
				<div class="workrow_order_description"><? echo $row['order_description']; ?>&nbsp;</div>
				<div class="workrow_data">
			    <? echo dig_to_d($row['date_in']); ?>.<? echo dig_to_m($row['date_in']); ?>&nbsp;-
					<b><? echo dig_to_d($row['datetoend']); ?>.<? echo dig_to_m($row['datetoend']); ?> (<? echo dig_to_h($row['datetoend']); ?>:<? echo dig_to_minute($row['datetoend']); ?>)</b></div>
				
    	<div class="workrow_box" style=" background-color:<? 
					switch (true) {
    					case ($row['soglas'] > 0):
							echo $main_green;
							break;
    					case ($row['soglas'] == 0):
							echo $main_red;
							break;
								} ?>
					;"> РАБ 
			   </div>
		<div class="workrow_box" style="background-color:<? 
				/*if ((strlen($row['preprint']) == 12) and ($row['preprinter'] == 'Нет')) {
					echo $main_green.";color: #111;";
				} else*/ if (($diz_flag == 1) and ((strlen($row['preprint']) == 12))) {echo $main_green.";color: #111;";} else if ($diz_flag == 1) {echo $main_yellow.";color: #111;";} else {echo("#EFEFEF");}
					?>;"> диз 
		</div>  
		
		<div class="workrow_box" style="background-color:<? 
			switch(true) {
				case (($row['preprint'] == 'Аня') or ($row['preprint'] == "Алиса")):
					echo $main_red;
					break;
    			case ((strlen($row['preprint']) == 12) or ($row['preprint'] = "Нет")):
					echo $main_green;
					break;
				
						} ?>;"> <? echo $row['preprinter']; ?> 
		</div>
		<div class="workrow_box" style="background-color:<? 
			if (((strlen($row['date_of_end'])) <> 12)) {
					echo $main_red;	} else {echo($main_green);} ?>;text-align: center; border-radius: 3px;"> гот 
			   </div>
		<div class="workrow_box" style="background-color:<? 
					switch(true) {
    					case (((strlen($row['paystatus'])) == 12) and ($row['paylist'] <> '')):
        					echo $main_green;
        					break;
						case (((strlen($row['paystatus'])) == 12) and ($row['paylist'] == '')):
							echo $main_yellow;
							break;
						case ((strlen($row['paystatus'])) <> 12):
        					echo "#efefef";
        					break;
						
								} ?>;"> выст 
		</div> 
		<? 
			switch(true) {
    					case ($row['delivery'] == 1):
							?>
							<div class="workrow_box" style="background-color:<? echo $main_red; ?>;"> дост </div><?
						break;
						case ($row['delivery'] > 1):
        					?>
							<div class="workrow_box" style="background-color:<? echo $main_green; ?>;"> дост </div><?
        					break;
						case ($row['delivery'] == 0):
        					?>
							<div class="workrow_box" style="background-color: #eeeeee;"> дост </div><?
        					break;
		} ?>
		<div class="workrow_box"><? echo($row['paymethod']); ?></div> 				
		<? //расчет долга по заказу и изменение его цвета в зависимости от статуса оплаты
				$order_money_income = 0;
				$order_money_income_array = mysqli_query($connect,"SELECT * FROM `money` WHERE `parent_order_number` = '$order_number'");
				while ($order_money_income_data = mysqli_fetch_array($order_money_income_array)) {
				$order_money_income = $order_money_income + $order_money_income_data['summ'];}
				if ($order_money_income == 0) {$money_color_flag = $main_red;} else
				if (abs($order_money_income - $amount_order) < 0.1) {$money_color_flag = $main_green;} else {$money_color_flag = $main_yellow;}
				/*echo ($order_money_income - $amount_order);*/
		?>
					<div class="workrow_box" style="background-color: <? echo $money_color_flag; ?> ; width: 60px;"> <? echo number_format($amount_order,2,'.',''); ?></div>
					
			 	<? if ($err_flag > 0) {/* echo $err_flag;*/ ?>
			 		<img src="img/alerticon.png" width="25" height="25" style="display: inline-block;">
				<? } ?>
				<? if ($reorder_flag > 0) {/* echo $err_flag;*/ ?>
			 		<img src="img/icons/refresh, reload, repeat, sync, rotate.png" width="25" height="25" style="display: inline-block;">
				<? } ?>
			</summary>
			<? if ((/*$_GET['filter']*/0 <> 1/*"fulllist"*/)) { ?>
<?/////////////////////////////////
//////////ДЕТАЛИ ЗАКАЗА НАЧАЛО/////
/////////////////////////////////?>
 <div class="details_of_order">		
		<a target="_blank" class="a_orderrow" href = "?action=redact&order_number=<? echo $row['order_number']; ?>">редактировать</a>

		<a target="_blank" class="a_orderrow" href = "index.php?action=delete&order_manager=<? echo $order_manager; ?>&order_number=<? echo $order_number; ?>">удалить заказ</a>
	
		<a target="_blank" class="a_orderrow" href = "printform.php?manager=<? echo $order_manager; ?>&number=<? echo $order_number; ?>">печатный бланк</a>

		<a target="_blank" class="a_orderrow" href = "index.php?action=showlist&filter=client&argument=<? echo($tmp1_array['id']); ?>">карточка клиента</a>
	 								
	 	<a target="_blank" class="a_orderrow" href="_small_pdf_maker.php?order=<? echo $order_number; ?>" target="_blank">PDF</a>
	 								<br><b>Контакты:</b><br> <? echo $tmp1_array['name']; ?><br>
   									<br><b>Адрес доставки:</b><br> <? echo $tmp1_array['address']; ?><br>
   									<br>Список работ:
    								<table class="master_content_table" bordercolor="black" cellspacing="3" cellpadding="3">
  <tbody>
    <tr style="background-color: antiquewhite;">
      <td style="width: 280px;">Название</td>
      <td style="width: 60px;">Техника</td>
      <td style="width: 35px;">Шир</td>
      <td style="width: 35px;">Выс</td>
      <td style="width: 40px;">Цвет</td>
      <td style="width: 150px;">Материал</td>
      <td style="width: 150px;">Постпечать</td>
      <td style="width: 50px;">Цена</td>
      <td style="width: 50px;">кол.</td>
      <td style="width: 80px;">Сумма</td>
      
    </tr>
<?		echo $order_manager;
		echo $order_number;
		$sps_redact = "SELECT * FROM `works` WHERE (`work_order_number` = '$order_number')";
		$sps_array = mysqli_query($connect,$sps_redact);
		while($sps_data = mysqli_fetch_array($sps_array))
	    { ?>
     <tr class=ml_row>
      <td cals=ml_name><b><? echo $sps_data['work_name']; ?></b><br><? echo $sps_data['work_description']; ?></td>
      <td style="padding: 3px;border-right: 1px dotted gray;"><? echo $sps_data['work_tech']; ?></td>
      <td class=ml_shir_vis><? echo $sps_data['work_shir']; ?></td>
      <td class=ml_shir_vis><? echo $sps_data['work_vis']; ?></td>
      <td class=ml_col_med_pp><? echo $sps_data['work_color']; ?></td>
      <td class=ml_col_med_pp><? echo $sps_data['work_media']; ?></td>
      <td class=ml_col_med_pp><? echo $sps_data['work_postprint']; ?></td>
      <td class=ml_price_count><? echo $sps_data['work_price']; ?></td>
      <td class=ml_price_count><? echo $sps_data['work_count']; ?></td>
      <td class=ml_sum><? echo $sps_data['work_price']*$sps_data['work_count']; ?></td>
	  
    </tr>
    <? } ?>
    
    <tr class=ml_itog>
    	<td colspan="6" style=""></td>
    	<td colspan="3" style="">
    	Итог: <b style="float: right;"><? echo $amount_order; ?>  руб.</b> 
    	</td>
    </tr>
    
  </tbody>
</table>
	
</div>
<?/////////////////////////////////
//////////ДЕТАЛИ ЗАКАЗА КОНЕЦ//////
/////////////////////////////////?>
			<? } ?>
			</details>
    	</div>
   		
    	
    	
    	
	  <? }} ?>
		<? ////////////////////////////////?>
	  </div>	