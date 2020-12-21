<? //$start = microtime(true); ?>
<? //include 'dbconnect.php'; ?>
<? //session_start(); ?>
<? //include './inc/global_functions.php'; ?>
<? //include './inc/cfg.php'; ?>
<? //$page = $_GET['page']; ?>
<? $current_manager = $_SESSION['manager']; //взять из сессии//$current_manager = $_SESSION['manager']; 
//echo $current_manager;?>
	<? 
	//проверяем последний оформленный бланк текущего менеджера
	//свич переключает тип работы - нью для добавления, редакт для редактирования
	switch ($_GET['action']) {
		case "new": //в случае нового заказа - ищем последний у менеджера, ставим следующий номер
			$action = $_GET['action'];
			$query_cclist_2 = "SELECT `order_number` FROM `order` ORDER BY `order_number` DESC LIMIT 1";
			$res_cclist_2 = mysql_query($query_cclist_2);
			mysql_error();
			$row_cclist_2 = mysql_fetch_array($res_cclist_2);
			$order_manager = $current_manager;
			$order_number = $row_cclist_2['order_number'] + 1;
			$contragent_id = "new";
				//получение планируемой даты сдачи (+1 день)
			$plan_date = date("Y")."-".date("m")."-".(date("d"));
			$plan_time = date("H").":00";
			break;
		
		case "redact": //в случае редакирования - принимаем данные из GET и используем их дальше
			$action = $_GET['action'];
			$order_number = $_GET['order_number'];
			 //получаем строку заказа (сам заказ)
				$order_redact_sql = "SELECT * FROM `order` WHERE ((`order_number`='$order_number'))";
				$order_redact_array = mysql_query($order_redact_sql);
				$order_redact_data = mysql_fetch_array($order_redact_array);
				$order_manager = $order_redact_data['order_manager'];
				
			 //получаем массив работ этого заказа (сам заказ)
				$works_order_redact_sql = "SELECT * FROM `works` WHERE ((`work_order_number`='$order_number'))";
				$works_order_redact_array = mysql_query($works_order_redact_sql);
				//подставляем дату уже вписанную в заказ в случа редактирования
			$plan_date = dig_to_y($order_redact_data['datetoend'])."-".dig_to_m($order_redact_data['datetoend'])."-".dig_to_d($order_redact_data['datetoend']);
			$plan_time = $order_redact_data['timetoend'];
				//на выходе двумерный массив работ (распиливаться будет в процессе составления страницы)	
			
				$contragent_from_order_id = $order_redact_data['contragent'];
				$contragent_redact_sql = "SELECT * FROM `contragents` WHERE `id`='$contragent_from_order_id'";
				$contragent_redact_array = mysql_query($contragent_redact_sql);
				$contragent_redact_data = mysql_fetch_array($contragent_redact_array);
			$contragent_id = $contragent_redact_data['id'];
			break;
	
	}

	?>

	<? //РАСЧЕТ МАТЬ ЕГО ОБЩЕЙ СУММЫ ЗАКАЗА
		$order_count_sql = "SELECT * FROM `works` WHERE ((`work_order_number`='$order_number'))";
		$order_count_array = mysql_query($order_count_sql);
		$order_summ = 0;
		while ($order_count_data = mysql_fetch_array($order_count_array)) 
			{$order_summ = number_format(($order_summ + $order_count_data['work_price']*$order_count_data['work_count']),2,'.','');}

	?>
<?  // подключение двух скриптов автодополнения для поля заказчик и для поля работ
	//include("./blank_incs/autocomplete.php"); ?>
<form action="_new_order_processor.php" method="POST" id="mainform">
<div class="orderrow" style="width: 1300px;">
	<input type="hidden" name="action" value="<? echo $action; ?>">
	<input type="text" name="order_manager" readonly value="<? echo $order_manager; ?>" style="width:25px; ">-<input name="nomer_blanka" readonly type="text" value="<? echo $order_number; ?>" style="width:50px;"> 
	<input type="text" name="order_description" placeholder="описние заказа" style="width: 745px; margin-top: 10px;" value="<?
echo $order_redact_data['order_description']; ?>"><br>
	<div style="display: inline; margin-left: 85px;">Сдача :</div><input type="date" style="margin-top: 5px; margin-left: 5px;" name="datetoend" value="<? echo $plan_date; ?>"><input type="time" style="margin-top: 5px;" name="timetoend" value="<? echo $plan_time; ?>" >
<br>
 
<div class="contragent_block" style="float: left; margin: 0px auto; padding: 5px;">Заказчик<br>
  <div class="posRelative">
	<input name="contragent_id" type="hidden" data-column="id" value="<? echo $contragent_id; ?>"> 
	<input name="contragent_name" type="text" placeholder="Заказчик" style="width: 300px;" data-column="name" value='<? echo($contragent_redact_data['name']); ?>' autocomplete="disabled">
  </div>
	<div class="posRelative" style="margin-left: 30px;">
		<input type="button" value="++" onclick="disp(document.getElementById('omnisearch'))" /><input type="text" id="omnisearch" style=" padding-left: 6px; display: none" placeholder="поиск клиента" onkeyup="searchClient(this, event)" autocomplete="off">
		<div class="searchResults" style="display:none"></div>
	</div>
	<br>
	<textarea name="contragent_contacts" style="height: 130px; width: 99%; resize: none; margin-top: 5px;" placeholder="Контактные данные" data-column="contacts" autocomplete="disabled"><? echo($contragent_redact_data['contacts']); ?></textarea>
	<textarea name="contragent_fullinfo" style="height: 130px; width: 99%; resize: none; margin-top: 5px;" placeholder="Реквизиты" data-column="fullinfo" autocomplete="disabled"><? echo($contragent_redact_data['fullinfo']); ?></textarea>
	<textarea name="contragent_address" style="height: 80px; width: 99%; resize: none; margin-top: 5px;" placeholder="Адрес доставки" data-column="address" autocomplete="disabled"><? echo($contragent_redact_data['address']); ?></textarea>
</div>


<div class="addition_status_block" style="margin: 0px auto; float: left;padding: 5px; margin-left: 5px;">Заметки к заказу<textarea  name="order_message" style="resize: none; height: 35px; font-size: 14px; width: 98%"></textarea>
<input type="submit" value="добавить" style="padding: 0px; height: 25px; font-size: 14px; margin-top: 5px;">
<div style="padding: 5px; border: 1px solid #E5E5E5; border-radius: 3px;  background-color: white; display: block; width: 250px; height: 200px;margin-top: 10px; overflow-y: scroll;"><? include "./_order_message_read.php"; ?></div>
</div>



<div class="status_block" style="margin-top: -83px; float: left; margin-left: 5px;<?
if ($order_redact_data['deleted'] == 1) {echo "background-color:#D0FBC7;";}
?>">
<div class="blok-ramka">
Статус
<br><select name="soglas"  style="<? if ($order_redact_data['soglas'] >1) {echo("background-color:#D0FBC7");} ?>" onchange="if (this.selectedIndex) this.form.submit ()">
		<option style="display: none">------------------------</option>
		<option value="set_ok" style="border: 2px solid green;background:#E6FFE9" <? if ((!isset($order_redact_data['soglas'])) OR ($order_redact_data['soglas'] > 0)) {echo("selected");} ?> >В работе</option>
		<option value="0" <? if (($order_redact_data['soglas'] == 0) AND (isset($order_redact_data['soglas']))) {echo("selected");} ?> style="border: 2px solid green;background:#F3B1B2">Ожидание</option>
	</select>

<br><select name="preprint" style="<? if ((($order_redact_data['preprint'] >1) or ($order_redact_data['preprint'] == 'Нет')) and ($action == "redact")) {echo("background-color:#D0FBC7");} ?>" onchange="if (this.selectedIndex) this.form.submit ()">
		<option style="display: none">Допечать готова</option>
		<option value="Аня" <? if (($order_redact_data['preprinter'] == 'Аня') or ($action == "new")) {echo("selected");} ?>>Допечать Аня</option>
		<option value="Алиса" <? if (($order_redact_data['preprinter'] == 'Алиса')) {echo("selected");} ?>>Допечать Алиса</option>
		<option value="Катя" <? if (($order_redact_data['preprinter'] == 'Катя')) {echo("selected");} ?>>Допечать Катя</option>
		<option value="Нет" <? if ($order_redact_data['preprinter'] == 'Нет') {echo("selected");} ?>>Не требуется</option>
		<!--<option value="set_ok" <?// if ($order_redact_data['preprint'] >1) {echo("selected");} ?>>Допечать готова</option> !-->
	</select>  

<br>


	<input style="width: 142px; margin-top: 5px;<? if ((($order_redact_data['preprint'] >1) or ($order_redact_data['preprint'] == 'Нет')) and ($action == "redact")) {echo("background-color:#D0FBC7");} ?>" type="submit" name="preprint_button" value="Подготовлено">
	
	<input style="width: 142px; margin-top: 5px;<? if ((($order_redact_data['date_of_end'] >1) or ($order_redact_data['date_of_end'] == 'Нет')) and ($action == "redact")) {echo("background-color:#D0FBC7");} ?>" type="submit" name="ready_button" value="Отпечатано">

	<br><input style="width: 142px; margin-top: 5px;<? if (($order_redact_data['paystatus'] >1) and ($action == "redact")) {echo("background-color:#D0FBC7");} ?>" type="submit" name="paystatus" value="Запросить счет">
		<? if ((strlen($order_redact_data['paystatus']) == 12)) { ?><div style="color: forestgreen; display: inline-block;">Счет запрошен</div> <? } ?>
		<? if ((strlen($order_redact_data['paystatus']) <> 12)) { ?><div style="color: orangered; display: inline-block;">Счет не запрошен</div> <? } ?>
</div>

<div class="blok-ramka" style="margin-top: 5px;">Оплата		
<br><select name="paymethod"  onchange="if (this.selectedIndex) this.form.submit ()">

		<option style="display: none"></option>
		<option value="ООО" <? if (($order_redact_data['paymethod'] == 'ООО')) {echo("selected");} ?>>ООО</option>
		<option value="ИП" <? if (($order_redact_data['paymethod'] == 'ИП')) {echo("selected");} ?>>ИП</option>
		<option value="Терм" <? if (($order_redact_data['paymethod'] == 'Терм')) {echo("selected");} ?>>Терм</option>
		<option value="Нал ЧЕК" <? if (($order_redact_data['paymethod'] == 'Нал ЧЕК')) {echo("selected");} ?>>Нал ЧЕК</option>
		<option value="Нал" <? if (($order_redact_data['paymethod'] == 'Нал')) {echo("selected");} ?>>Нал</option>
		<option value="СБОЛ" <? if (($order_redact_data['paymethod'] == 'СБОЛ')) {echo("selected");} ?>>СБОЛ</option>
	</select>

		

<br>
<? if (($order_redact_data['paymethod'] == 'ООО') or (($order_redact_data['paymethod'] == 'ИП'))) { 
	$beznal_flag = 1;
?><br>
Счет: 
					<b>
					<a href="?action=showlist&filter=contragent_paydemand&argument=<? echo $order_redact_data['paylist'] ;?>"><? echo $order_redact_data['paylist'] ;?></a>
					<? /*echo $order_redact_data['paylist'];*/?>
					</b>

<? if ($_SESSION['supervisor'] == 1) { ?><div style="float: right;">удалить <a href="">[х]</a></div><? } ?><br>		
<? } ?>

<? if ($beznal_flag == 1) {?>
<textarea hidden readonly  type="text" name="paylist" placeholder="Номер счета/чека/дата" style="height: 60px; width: 288px; margin-top: 2px;" value=""><? echo $order_redact_data['paylist']; ?></textarea>
						<? } ?>
						
						
<? if ($beznal_flag <> 1) { ?>
<textarea  type="text" name="paylist" placeholder="Номер счета/чека/дата" style="height: 60px; width: 288px; margin-top: 2px;" value=""><? echo $order_redact_data['paylist']; ?></textarea>




<? } ?>
<br><input name="vneseno" type="text" placeholder="сумм" autocomplete="disable" style="width: 150px; margin-top: 5px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" name="payment_confirm" value="записать" style="">

<br>
<div style="font-size: 18px; font-family:Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-weight: 600; margin-top: 5px;"><?
								$vnes_sum = 0;
								$vnes_sum_array = mysql_query("SELECT `summ` FROM `money` WHERE `parent_order_number` = '$order_number'");
								while ($vnes_sum_data = mysql_fetch_array($vnes_sum_array)) {$vnes_sum = $vnes_sum + $vnes_sum_data['summ'];} ?>
<div align="left">Оплачено: <? echo $vnes_sum; ?></div>
<div align="left">Общая сумма: <div id="txtSecond" style=" display: inline; color: black; font-size: 18px; font-weight: 700;"><? echo $order_summ; ?></div></div>
<div align="left">Доплатить: <? 

								echo ($order_summ - $vnes_sum); 
								?></div>
</div>
<br><select name="delivery" style="<? if ($order_redact_data['delivery'] >1) {echo("background-color:#D0FBC7");} ?>" onchange="if (this.selectedIndex) this.form.submit ()">
		<option style="display: none">------------------------</option>
		<option value="0" <? if ($order_redact_data['delivery'] == 0) {echo("selected");} ?>>Самовывоз</option>
		<option value="1" <? if ($order_redact_data['delivery'] == 1) {echo("selected");} ?>>Доставка</option>
		<option value="set_ok" <? if ($order_redact_data['delivery'] >1) {echo("selected");} ?>>ДОСТАВЛЕНО!</option>
	</select>
<br><select name="handing" style="<? if (($order_redact_data['handing'] >1)) {echo("background-color:#D0FBC7");} ?>" onchange="if (this.selectedIndex) this.form.submit ()">
		<option style="display: none">------------------------</option>
		<option value="0" <? if ($order_redact_data['handing'] == 0) {echo("selected");} ?>>Не выдано</option>
		<option value="1" <? if ($order_redact_data['handing'] == 1) {echo("selected");} ?>>Частично выдано</option>
		<option value="set_ok" <? if ($order_redact_data['handing'] >1) {echo("selected");} ?>>ВЫДАНО</option>
	</select>
</div>
</div>




<table style=" width: 1195px;">
<?//начало цикла таблицы ?>

<? 		$main_table_row = "SELECT * FROM `works` WHERE ((`work_order_manager`='$order_manager') AND (`work_order_number`='$order_number'))";
		$main_table_array = mysql_query($main_table_row);
		$workrowcount = mysql_num_rows($main_table_array);
		while ($main_table_data = mysql_fetch_array($main_table_array) or $workrowcount==0) { $workrowcount = $workrowcount + 1; ?>
<tr class="work_row" bordercolor="black" style="border: 2px solid gray;">
  <td>	
	<table class="workrow" border="0" style="float: left; display:inline-block; width: 1195px; margin-top: 13px; ">
	  <tbody style="border: 2px solid gray; display: inline-block; border-left-width: 15px; border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
	  <tr>
	  	<td><input class="item_ids" name="work_id[]" value="<? ?>" type="hidden" style="">
	  		<textarea class="autocomplete_deals ac_input tags2" type="text" name="work_name[]" autocomplete="" id="tags2" style="width: 300px; height: 35px; font-weight: 700; font-size: 19px;" tabindex="1"><? echo($main_table_data['work_name']); ?></textarea>
	  	</td>
	  	<td>
	  		<select  name="work_tech[]">
     								<option style="display: none"></option>
     								<? // $main_table_data['work_tech']  - в этой переменной вид работы, хзаписанный уже в базе ?>
     								<? 	
										$worktype_array  = mysql_query("SELECT * FROM `work_types` ORDER by `id`");
																							
											while ($worktype_data = mysql_fetch_array($worktype_array)) {?>
							<option <? if ($main_table_data['work_tech'] == $worktype_data['name']) {echo('selected');} ?> value="<? echo $worktype_data['name'];?>"><? echo $worktype_data['name'];?></option>
											<? } ?>
    								<?//<option <? if ($main_table_data['work_tech'] == 'XEROX') {echo('selected');}  value="XEROX">XEROX</option>
      								//<option <? if ($main_table_data['work_tech'] == 'Latex') {echo('selected');}  value="Latex">Latex</option>
									//<option <? if ($main_table_data['work_tech'] == 'Офсет') {echo('selected');}  value="Офсет">Офсет</option>
									//<option <? if ($main_table_data['work_tech'] == 'Сольвент') {echo('selected');}  value="Сольвент">Сольвент</option>
									//<option <? if ($main_table_data['work_tech'] == 'Дизайн') {echo('selected');}  value="Дизайн">Дизайн</option>
									//<option <? if ($main_table_data['work_tech'] == 'Другое') {echo('selected');}  value="Другое">Другое</option>?>
									
			</select>
	  	</td>
	  	<td>
	  		<select  name="work_color[]">
    								<option style="display: none"></option>
     								<option <? if ($main_table_data['work_color'] == 'mix') {echo('selected');} ?> value="mix">mix</option>
      								<option <? if ($main_table_data['work_color'] == '4+0') {echo('selected');} ?> value="4+0">4+0</option>
      								<option <? if ($main_table_data['work_color'] == '4+4') {echo('selected');} ?> value="4+4">4+4</option>
									<option <? if ($main_table_data['work_color'] == '4+1') {echo('selected');} ?> value="4+1">4+1</option>
									<option <? if ($main_table_data['work_color'] == '1+1') {echo('selected');} ?> value="1+1">1+1</option>
									<option <? if ($main_table_data['work_color'] == '1+0') {echo('selected');} ?> value="1+0">1+0</option>
			</select>
	  	</td>
	  	<td>
			<select name="work_format[]" onChange="matchformat(this)">
				<option value="none"></option>
				<option value="А1">А1</option>
				<option value="А2">А2</option>
				<option value="А3">А3</option>
				<option value="А4">А4</option>
				<option value="А5">А5</option>
				<option value="А6">А6</option>
				
				
			</select>
	  	</td>
	  	
	  	<td>
	  		<input data-column="recount"  name="work_shir[]" style="height: 35px; padding-left: 4px; font-size: 16px; width: 40px;" onkeyup="raskladka(this)" onClick="raskladka(this)" placeholder="Ш" value="<? echo($main_table_data['work_shir']); ?>">
	  	</td>
	  	<td>
	  		<input data-column="recount"  name="work_vis[]" style="height: 35px; padding-left: 4px; font-size: 16px; width: 40px;" onkeyup="raskladka(this)" onClick="raskladka(this)" placeholder="В" value="<? echo($main_table_data['work_vis']); ?>" class="raskladka">
	  	</td>
	  	<td>	<select name="work_media[]"  style="width: 197px;">
                //пустой дефолтный матераиал
                <option value=""></option>
	  			<? 		$media_type_query  = mysql_query("SELECT * FROM `media_types` ORDER by `id`");
							while ($media_type_data = mysql_fetch_array($media_type_query)) {?>
							<option <? if ($main_table_data['work_media'] == $media_type_data['name']) {echo('selected');} ?> value="<? echo $media_type_data['name'];?>"><? echo $media_type_data['name'];?></option>
											<? } ?>
				</select>
	  	<!--	<textarea style="width: 220px; height: 43px; font-size: 16px;" name="work_media[]" placeholder="материал"><? //echo($main_table_data['work_media']); ?></textarea> !-->
	  		
	  	</td>
	  	<td>
	  		
	  	</td>
	  	<td rowspan="2">
	  		
	  		<table style="border: 1px dotted #D99798; border-radius: 3px; height:105px; padding-left: 4px; padding-right: 4px;" class="autoClear">
            		<tr>
            			<td><input style="text-align: center; width: 80px; height: 35px;" class="checkRow" onkeyup="checkRow(this)" onKeyUp="doublesumm()"  type="text" value="<? echo($main_table_data['work_price']); ?>" name="work_price[]" id="item_price" placeholder="цена"></td>
            			<td><input style="text-align: center; width: 80px; height: 35px;" class="item_quantities number checkRow recountDeal" onkeyup="checkRow(this)" onMouseMove="checkRow(this)" type="text" value="<? echo($main_table_data['work_count']); ?>" name="work_count[]" id="item_count" placeholder="кол."></td>
            			<td><input style="width: 80px; height: 35px; text-align: center; font-weight: 700"  type="text" value="<? echo number_format($main_table_data['work_count']*$main_table_data['work_price'],2,'.',''); ?>" name="result[]" readonly></td>
            					<td style="width: 37px;">
            				<? if (($_GET['action'] == 'redact') and ($order_redact_data['deleted'] <> '1')) { ?>
            					
            						<a class="delete_button" href="_work_deleter.php?step=1&work_id=<? echo $main_table_data['id'];?>&order_number=<? echo $main_table_data['work_order_number'];?>" style="display: inline-block; width:35px; height: 35px; background-color: #FF3D40; border-radius: 3px;"><font style="font-size: 30px; margin-left: 7px;" color="#FFFFFF"><b>X</b></font></a>
            					
            				<? } ?>
            					</td>
            		</tr>
            		<tr>
            			<td colspan="1"><input style="width: 80px; height: 35px; text-align: center"  type="text" value="<? echo($main_table_data['work_rashod']); ?>" name="work_rashod[]" placeholder="расход"></td>
            			<td colspan="3">
            			<? //подтягиваем счета расходов из таблицы со счетами расходов с отбором по поставщику ?>
            			<select style="width: 225px; height: 39px;" name="work_rashod_list[]">
            				<option></option>
            				<? if ($_GET['action'] == 'redact') {
							$current_work_tech = $main_table_data['work_tech'];
						/*	if ($main_table_data['work_rashod_list'] <> '') {}*/
							$paylist_demand_sql = "SELECT * FROM `paylist_demands` WHERE ((`owner`='$current_work_tech'))";
							$paylist_demand_query = mysql_query($paylist_demand_sql);
							?>
							<option selected><? echo $main_table_data['work_rashod_list']; ?></option>
							<?
							while ($paylist_demand_data = mysql_fetch_array($paylist_demand_query)) {
									
									if (($main_table_data['work_rashod_list'] <> $paylist_demand_data['number']) and ($paylist_demand_data['closed'] <> 1)) 
										{ echo "<option>".$paylist_demand_data['number']."</option>"; }
							}}
							?>

            			</select>
            			
            			<input type=hidden name="123work_rashod_list[]" style="width: 169px; height: 35px; text-align: center"  type="text" value="<? echo($main_table_data['work_rashod_list']); ?>" placeholder="счет расхода"></td>
            			
       
            		</tr>
            		
            </table>
	  		
	  	</td>
	  </tr>
	  
	  <tr>
	  	<td colspan="2">
	  		<textarea  name="work_description[]" tabindex="2" style="width: 98%; height: 55px;" placeholder="описание работы"><? echo($main_table_data['work_description']); ?></textarea>
	  	</td>
	  	<td colspan="5">
	  			<textarea style="width: 82%; height: 55px;" tabindex="4" name="work_postprint[]" placeholder="постпечатная обработка"><? echo($main_table_data['work_postprint']); ?></textarea>
	  	<textarea style="width: 13%; height: 55px; font-size: 16px;" name="work_rasklad[]" onClick="raskladka(this)"><? echo($main_table_data['work_rasklad']); ?></textarea></td>
	  </tr>
	  	
	
	
		</tbody>
	<?// } //конец общего цикла таблицы ?>
	</table>
  </td>
  

</tr>
	<? } //конец общего цикла таблицы ?>	
<tr><td style="width: 99%;" align="right"><div style="" style="display: inline-block; float: right; width: 100%;"><button class="click" type="button">добавить</button><button type="button" class="click2">убавить</button>Итог: <input id="itog" type="text" style="text-align: right;" readonly value="<? echo number_format($order_summ,2,'.',' '); ?>"></div></td></tr>

</table>
<div>
	<input type="submit" class="final" value="Оформить / обновить">
	<input type="submit" style="margin-left: 150px;" class="111" name="doubleflag" value="Дублировать заказ">
	<input type="submit" formaction="printform.php?manager=<? echo $order_manager; ?>&number=<? echo $order_number; ?>" value="Печатный бланк">
	<input type="submit" formaction="index.php?action=delete&order_manager=<? echo $order_manager; ?>&order_number=<? echo $order_number; ?>" value="Удалить заказ">
</div>
		
</div>
</form>
<? include("_workrow_script.php"); ?>