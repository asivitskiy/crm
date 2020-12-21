<div class="details_of_order">
  									----------------------------------------------------------------------------------------------
   									<br><b>Контакты:</b><br> <? echo str_replace("\n","<br>",contact_cutter($row['contragent'])); ?>
   									----------------------------------------------------------------------------------------------
   									<br><b>Адрес доставки:</b><br> <? echo str_replace("\n","<br>",delivery_cutter($row['contragent'])); ?>
   									----------------------------------------------------------------------------------------------
   									
   									
   									
   									<br>Список работ:
    								<table class="master_content_table" bordercolor="black" cellspacing="3" cellpadding="3" style="border: 1px; font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'; font-size: 14px; border: dotted 1px black; width: 1000px;">
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
    
    <tr style=""><td colspan="6" style="border-right: 1px dotted gray;padding: 3px; border-top: 1px dotted black; "></td><td colspan="3" style="border-right: 1px dotted gray;padding: 3px; border-top: 1px dotted black; ">Итог: <b style="float: right;"><? echo $amount_order; ?>  руб.</b> </td></tr>
    
  </tbody>
</table>
			<button onclick="location.href = '?page=blank_zakaz&changeorder=1&changeorder_manager=<? echo $row['manager']; ?>&changeorder_number=<? echo $row['name']; ?>'">Редактировать</button>
</div>