<? $query = "SELECT * FROM `order` ORDER BY `date_in` DESC";
	$q = 0;
	$prev = 0;
	$res = mysql_query($query);
	while($row = mysql_fetch_array($res))
	{				
		
		$order_manager	 = $row['order_manager'];			
		$order_number	 = $row['order_number'];			
		$query_works_1 = "SELECT * FROM `works` WHERE ((`work_order_manager`='$order_manager') AND (`work_order_number`='$order_number'))";
					$res_works_1 = mysql_query($query_works_1);
					while($row_works_1 = mysql_fetch_array($res_works_1))
							{ 	if ($row_works_1['gotov'] <> 0) {$ready_counter = $ready_counter + 1;}
								if (($row_works_1['tech'] == 'Дизайн')) {$diz_flag = 1;}
								if (($row_works_1['tech'] == 'Дизайн') AND ($row_works_1['gotov'] == 0)) {$diz_counter = $diz_counter+1;}
								$q++;
								$amount_order = $amount_order+(($row_works_1['work_price'])*($row_works_1['work_count'])); 
							}
		
	if (dig_to_d($row['date_in']) <> dig_to_d($prev)) {$prev = $row['date_in'];	
	?>
		<h3 style="font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'; display: block; border-bottom: 2px solid #20577B; color:#20577B; margin-top: 0px; margin-bottom: 5px; font-weight: 600;"><? echo (dig_to_d($row['date_in'])); ?>.<? echo (dig_to_m($row['date_in'])); ?>.<? echo (dig_to_y($row['date_in'])); ?>
  	    </h3>
  			<? } ?>
   		<div class="order_row">
    	 <details style="font-size: 16px;">
			<summary style="font-size: 15px; vertical-align: top">
			
				
				<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 18px; display: inline; border-right: 0px dotted #373737; margin-right: 0px; margin-left: 10px; vertical-align: top;"><? echo $row['order_manager'].'-'.$row['order_number']; ?>&nbsp;&nbsp;</div>
				
				<div style="font-weight: 500; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 18px; display: inline; border-right: 0px dotted #373737;  margin-right: 1px; width: 220px; display: inline-block; vertical-align: top; "><? 
							$tmp1 = $row['contragent'];
							$tmp1_array = mysql_fetch_array(mysql_query("SELECT * FROM `contragents` WHERE `id`='$tmp1'"));
							echo($tmp1_array['name']);
																																	?>&nbsp;</div>
				
				<div style="font-weight: 450; height: 24px; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 15px; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; width: 450px; vertical-align: top;overflow: hidden"><? echo $row['order_description']; ?>&nbsp;</div>

				<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 16px; display: inline; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; width: 155px;  vertical-align:top;">
			    <? echo dig_to_d($row['date_in']); ?>.<? echo dig_to_m($row['date_in']); ?>&nbsp;-
					<b><? echo dig_to_d($row['datetoend']); ?>.<? echo dig_to_m($row['datetoend']); ?> (<? echo dig_to_h($row['datetoend']); ?>:<? echo dig_to_minute($row['datetoend']); ?>)</b></div>
				
    	<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 12px; display: inline; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; height: 24px; width: 33px; vertical-align:text-bottom; background-color:<? 
					switch (true) {
    					case ($row['soglas'] > 0):
							echo $main_green;
							break;
    					case ($row['soglas'] == 0):
							echo $main_red;
							break;
								} ?>
					;text-align: center; border-radius: 3px;"> согл 
			   </div>
		<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 12px; display: inline; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; height: 24px; width: 33px; vertical-align:text-bottom; background-color:<? 
				if (($diz_counter > 0)) {
					echo $main_red;
				} else if ($diz_flag == 1) {echo $main_green;} else {echo("#eeeeee");}
					?>;text-align: center; border-radius: 3px;"> диз 
			   </div>  
		<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 12px; display: inline; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; height: 24px; width: 33px; vertical-align:text-bottom; background-color:<? 
					switch(true) {
    					case ($row['preprint'] == 1):
							echo $main_red;
							break;
    					case ($row['preprint'] == 0):
							echo $main_green;
							break;
						case ($row['preprint'] > 1):
        					echo $main_green;
        					break;
								} ?>;text-align: center; border-radius: 3px;"> доп 
			   </div>
	
		
	
		
		
		<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 12px; display: inline; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; height: 24px; width: 33px; vertical-align:text-bottom; background-color:<? 
			if (($ready_counter == 0)) {
					echo $main_red;	} else if (($ready_counter > 0) and ($ready_counter < $q)) {echo $main_yellow;} else {echo($main_green);} ?>;text-align: center; border-radius: 3px;"> гот 
			   </div>&nbsp;&nbsp;&nbsp;&nbsp;
		<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 12px; display: inline; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; height: 24px; width: 33px; vertical-align:text-bottom; background-color:<? 
					switch(true) {
    					case (($row['paylist'] == 0) and ($row['paymethod'] <> 'nal')):
							echo $main_red;
							break;
						case (($row['paylist'] > 0) or ($row['paymethod'] == 'nal')):
        					echo $main_green;
        					break;
								} ?>;text-align: center; border-radius: 3px; "> выст 
			   </div> 
		<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 12px; display: inline; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; height: 24px; width: 33px; vertical-align:text-bottom; background-color:#FFE26B;text-align: center; border-radius: 3px; "> оплч 
			   </div>
		
			   <? include("_nal_bnal_kavichki.php");	?>   
		 
		
		<? 
			switch(true) {
    					case ($row['delivery'] == 1):
							?>
							<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 12px; display: inline; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; height: 22px; width: 34px; vertical-align:text-bottom; background-color:<? echo $main_red; ?>;text-align:  center; border-radius: 3px; border: 1px solid gray"> дост </div><?
						break;
						case ($row['delivery'] > 1):
        					?>
							<div style="font-weight: 450; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, 'sans-serif'; font-size: 12px; display: inline; border-right: 0px dotted #373737; margin: 4px; margin-right: 1px; display: inline-block; height: 22px; width: 34px; vertical-align:text-bottom; background-color:<? echo $main_green; ?>;text-align:  center; border-radius: 3px; border: 1px solid gray"> дост </div><?
        					break;
								} ?>
			
			   	

				
			 
			</summary>
<?/////////////////////////////////
//////////ДЕТАЛИ ЗАКАЗА НАЧАЛО/////
/////////////////////////////////?>
 <div class="details_of_order">
  									----------------------------------------------------------------------------------------------
   									<br><b>Контакты:</b><br> <? echo $tmp1_array['name']; ?><br>
   									----------------------------------------------------------------------------------------------
   									<br><b>Адрес доставки:</b><br> <? echo $tmp1_array['address']; ?><br>
   									----------------------------------------------------------------------------------------------
   									
   									
   									
   									<br>Список работ:
    								<table class="master_content_table" bordercolor="black" cellspacing="3" cellpadding="3" style="border: 1px; font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'; font-size: 14px; border: dotted 1px black; width: 1000px;">
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
		$sps_redact = "SELECT * FROM `works` WHERE ((`work_order_manager` = '$order_manager') AND (`work_order_number` = '$order_number'))";
		$sps_array = mysql_query($sps_redact);
		while($sps_data = mysql_fetch_array($sps_array))
	    { ?>
     <tr style="border-top: 1px dotted gray;margin-top: 5px;">
      <td style="padding: 3px;border-right: 1px dotted gray;">
      		<b><? echo $sps_data['work_name']; ?></b><br>
      		<? echo $sps_data['work_description']; ?>
      </td>
      <td style="padding: 3px;border-right: 1px dotted gray;"><? echo $sps_data['work_tech']; ?></td>
      <td style="background:#EfEfEf;padding: 3px;"><? echo $sps_data['work_shir']; ?></td>
      <td style="background:#EfEfEf;padding: 3px;"><? echo $sps_data['work_vis']; ?></td>
      <td style="border-right: 1px dotted gray;padding: 3px;"><? echo $sps_data['work_color']; ?></td>
      <td style="border-right: 1px dotted gray;padding: 3px;"><? echo $sps_data['work_media']; ?></td>
      <td style="border-right: 1px dotted gray;padding: 3px;"><? echo $sps_data['work_postprint']; ?></td>
      <td style="border-right: 1px dotted gray; text-align: right;padding: 3px;"><? echo $sps_data['work_price']; ?></td>
      <td style="border-right: 1px dotted gray; text-align: right;padding: 3px;"><? echo $sps_data['work_count']; ?></td>
      <td style ="text-align: right;padding: 3px;"><? echo $sps_data['work_price']*$sps_data['work_count']; ?></td>
	  
    </tr>
    <? } ?>
    
    <tr style=""><td colspan="6" style="border-right: 1px dotted gray;padding: 3px; border-top: 1px dotted black; "></td><td colspan="3" style="border-right: 1px dotted gray;padding: 3px; border-top: 1px dotted black; ">Итог: <b style="float: right;"><? echo $amount_order; ?>  руб.</b> </td></tr>
    
  </tbody>
</table>
			<button onclick="location.href = '?action=redact&order_manager=<? echo $row['order_manager']; ?>&order_number=<? echo $row['order_number']; ?>'">Редактировать</button>
</div>
<?/////////////////////////////////
//////////ДЕТАЛИ ЗАКАЗА КОНЕЦ//////
/////////////////////////////////?>
			</details>
    	</div>
   		
    	
    	
    	
	  <? } ?>
		<? ////////////////////////////////?>
	  </div>	