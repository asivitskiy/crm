<? $query = "SELECT * FROM `order` WHERE `deleted` <> '1' ORDER BY `date_in` DESC";
	$q = 0;
	$prev = 0;
	$res = mysql_query($query);
	while($row = mysql_fetch_array($res))
	{				//расчет суммы по заказу
					$amount_order *= 0;
					$q = 0;
					echo($amoun_order);
					$order_name_1 = $row['manager'].'-'.$row['name'];
					$query_works_1 = "SELECT * FROM `works` WHERE ((`order_id` LIKE '$order_name_1') AND (`deleted` <> 1))";
					$res_works_1 = mysql_query($query_works_1);
					while($row_works_1 = mysql_fetch_array($res_works_1))
							{ 
								$q++;
								$amount_order = $amount_order+(($row_works_1['price'])*($row_works_1['count'])); 
							}
		
	if (dig_to_d($row['date_in']) <> dig_to_d($prev)) {$prev = $row['date_in'];	
	?>
 	<br><h1 style="float: left; background-color: gray; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; color:#363636; font-weight: 600; font-size: 16px; display: inline;color: white">
 	  &nbsp;<? echo (dig_to_d($row['date_in'])); ?>.<? echo (dig_to_m($row['date_in'])); ?>.<? echo (dig_to_y($row['date_in'])); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1><? } ?>
 	<table class="master_wrap_table" style="font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'; margin-left: 0px; padding: 5px; border-bottom: 1px dashed black">
  	<tbody>
  	  <tr style="height: 3px;"><td colspan="3"> </td></tr>
      <tr style="background-color: white;">
      	<td style="width: 90px;">
    <h1 style="font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; color:#000942; font-weight: 700; font-size: 18px; display: inline;"><? echo $row['manager'].'-'.$row['name']; ?></h1>
     	<img src="./img/<? if (($row['paymethod'] == 'Безнал') or (($row['paymethod'] == 'БЕЗНАЛ'))) {echo('bnal');} else {echo('nal');} ?>.png">
     	<img src="./img/dost.png">
      	</td>
      	<td style="width: 3px; background-color:#337AB7 "></td>
      	<td style="padding-left: 15px;">   

      				<ul class="list3a">
    					<li><div class="filter">
  								<details style="font-size: 16px;">
									<summary style="font-size: 15px;">
  <table  style="width: 1000px">
  	<tr>
      
      
      <td style="width: 500px; padding-left: 16px; font-size: 17px;"><b><? echo (name_cutter($row['contragent'])); ?></b></td>
      <td style="width: 250px;" rowspan="2">флажки</td>
      <td colspan="2" style="width: 190px;"><div style="float: right; color: red; font-weight: 600; font-size: 16px;"><? echo dig_to_d($row['date_in']); ?>.<? echo dig_to_m($row['date_in']); ?>.<? echo dig_to_y($row['date_in']); ?> </div></td>
 	</tr>
	<tr>
      <td style=" padding-left: 16px;"><? echo $row['order_description']; ?></td>
      <td style="width: 10px;"></td>
		<td style="width: 250px;"><div style="float: left"> Cумма: <b><? echo $amount_order; ?></b></div><div style="float: right; ">Позиций: <b><? echo $q; ?></b></div></td>
      
	</tr>
</table>				
   								
   									</summary>
   									----------------------------------------------------------------------------------------------
   									<br><b>Контакты:</b><br> <? echo str_replace("\n","<br>",contact_cutter($row['contragent'])); ?>
   									----------------------------------------------------------------------------------------------
   									
   									
   									
   									<br>Список работ:
    								<table class="master_content_table" bordercolor="black" cellspacing="3" cellpadding="3" style="border: 1px; font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'; font-size: 14px; border: dashed 1px black; width: 1000px;">
  <tbody>
    <tr style="background-color: antiquewhite;">
      <td style="width: 280px;">Название</td>
      <td style="width: 60px;">Техника</td>
      <td style="width: 60px;">Формат</td>
      <td style="width: 50px;">Цвет</td>
      <td style="width: 150px;">Материал</td>
      <td style="width: 150px;">Постпечать</td>
      <td style="width: 50px;">Цена</td>
      <td style="width: 50px;">кол.</td>
      <td style="width: 80px;">Сумма</td>
      
    </tr>
<?		$blank_number = $row['manager'].'-'.$row['name'];
		$sps_redact = "SELECT * FROM `works` WHERE ((`order_id` = '$blank_number') AND (`deleted` <> '1'))";
		$sps_array = mysql_query($sps_redact);
		while($sps_data = mysql_fetch_array($sps_array))
	    { ?>
     <tr style="border-top: 1px dotted gray;margin-top: 5px;">
      <td style="padding: 3px;border-right: 1px dotted gray;">
      		<b><? echo $sps_data['name']; ?></b><br>
      		<? echo $sps_data['work_description']; ?>
      </td>
      <td style="padding: 3px;border-right: 1px dotted gray;"><? echo $sps_data['tech']; ?></td>
      <td style="background:#EfEfEf;padding: 3px;"><? echo $sps_data['format']; ?></td>
      <td style="border-right: 1px dotted gray;padding: 3px;"><? echo $sps_data['color']; ?></td>
      <td style="border-right: 1px dotted gray;padding: 3px;"><? echo $sps_data['media']; ?></td>
      <td style="border-right: 1px dotted gray;padding: 3px;"><? echo $sps_data['postprint']; ?></td>
      <td style="border-right: 1px dotted gray; text-align: right;padding: 3px;"><? echo $sps_data['price']; ?></td>
      <td style="border-right: 1px dotted gray; text-align: right;padding: 3px;"><? echo $sps_data['count']; ?></td>
      <td style ="text-align: right;padding: 3px;"><? echo $sps_data['price']*$sps_data['count']; ?></td>
	  
    </tr>
    <? } ?>
    
    <tr style=""><td colspan="6" style="border-right: 1px dotted gray;padding: 3px; border-top: 1px solid black; "></td><td colspan="3" style="border-right: 1px dotted gray;padding: 3px; border-top: 1px solid black; ">Итог: <b style="float: right;"><? echo $amount_order; ?>  руб.</b> </td></tr>
    
  </tbody>
</table>

    								<br><b> <? echo (contact_cutter($row['contragent'])); ?> </b> <? echo (delivery_cutter($row['contragent'])); ?><br>
    								<div style="width: 950px"><? echo (req_cutter($row['contragent'])); ?></div><br><br><br><br>
    				<button onclick="location.href = 'blank_zakaz.php?changeorder=1&changeorder_manager=<? echo $row['manager']; ?>&changeorder_number=<? echo $row['name']; ?>'">Редактировать</button>
    							<br>
 								</details>
							</div>
						</li>
  					</ul>
  		</td>
	  </tr>
     <tr style="height: 3px;">
      	<td colspan="3"> </td>
    </tr>
  </tbody>
</table>
</div>
	<? } ?>
