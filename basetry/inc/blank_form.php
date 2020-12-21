<? 
//if (($flag_changeorder <> 1) or !isset($flag_changeorder)) {$blank_number='xxx';}
$first_row = 1;
$w_redact = "SELECT * FROM `works` WHERE ((`order_id` = '$blank_number') AND (`deleted` <> '1'))";
$w_array = mysql_query($w_redact);

while(($w_data = mysql_fetch_array($w_array)) or ($first_row == 1))
	    { $first_row = 0;
?>
          <tr class="work_row" style="border-color: black;">
           
            <td class="hidden_ru"><input class="item_ids" name="item_ids[]" value="<? echo($w_data['work_id']); ?>" type="hidden" style="">
            </td>
            <td class="item_ru" style="width: 400px;"> 	
 <textarea class="autocomplete_deals ac_input tags2" type="text" name="item_names[]" autocomplete="" id="tags2" style="width: 400px; height: 25px; font-weight: 800; font-size: 16px;"><? echo($w_data['name']); ?></textarea>
            											<br>
            											<textarea  name="item_descriptions[]" style="width: 400px; height: 55px;" placeholder="описание работы"><? echo($w_data['work_description']); ?></textarea>	<br><br>		
            </td>
            <td style=" display: block; width: 400px;" colspan="3" valign="top">
           		<table border="0" bordercolor=#CCCCCC cellpadding="0" cellspacing="0">
           			<tr>
           				<td>
           					<select  name="tehnika[]" style="height: 30px"><option <? if ($w_data['tech'] == 'XEROX') {echo('selected');} ?> value="XEROX">XEROX</option>
      								<option <? if ($w_data['tech'] == 'Latex') {echo('selected');} ?> value="Latex">Latex</option>
									<option <? if ($w_data['tech'] == 'Офсет') {echo('selected');} ?> value="Офсет">Офсет</option>
									<option <? if ($w_data['tech'] == 'Сольвент') {echo('selected');} ?> value="Сольвент">Сольвент</option>
									<option <? if ($w_data['tech'] == 'Дизайн') {echo('selected');} ?> value="Дизайн">Дизайн</option>
									<option <? if ($w_data['tech'] == 'Другое') {echo('selected');} ?> value="Другое">Другое</option>
									
							</select>
           				</td>
           				<td>
           					<select  name="item_color[]" style="height: 30px">
    								<option <? if ($w_data['color'] == '4+0') {echo('selected');} ?> value="4+0">4+0</option>
      								<option <? if ($w_data['color'] == '4+4') {echo('selected');} ?> value="4+4">4+4</option>
									<option <? if ($w_data['color'] == '4+1') {echo('selected');} ?> value="4+1">4+1</option>
									<option <? if ($w_data['color'] == '1+1') {echo('selected');} ?> value="1+1">1+1</option>
									<option <? if ($w_data['color'] == '1+0') {echo('selected');} ?> value="1+0">1+0</option>
							</select>
          				</td>
           				<td>
           					<textarea style="width: 80px; height: 30px; margin: 0px; padding: 0px;" name="item_format[]" placeholder="формат"><? echo($w_data['format']); ?></textarea>	
           				</td>
           				<td>
           					<textarea style="width: 189px; height: 30px; margin: 0px; padding: 0px;" name="item_media[]" placeholder="материал"><? echo($w_data['media']); ?></textarea>	
           				</td>
           			</tr>
           			<tr>
           				<td colspan="4">
           					<textarea style="width: 400px; height: 55px; margin: 0px; margin-top: 1px; padding: 0px;" name="item_postprint[]" placeholder="поспечатная обработка"><? echo($w_data['postprint']); ?></textarea>
           				</td>
           			
           			</tr>
           			
           		</table>
           		
            	
            			
            </td>
            <td colspan="3" valign="top">
            	<table border="0">
            		<tr>
            			<td><input style="width: 80px;" class="item_prices number recountDeal" onkeyup="checkRow2(this)"  type="text" value="<? echo($w_data['price']); ?>" name="item_prices[]" id="item_price" placeholder="цена за ед"></td>
            			<td><input style="width: 80px;" class="item_quantities number recountDeal" onkeyup="checkRow(this)"  type="text" value="<? echo($w_data['count']); ?>" name="item_counts[]" id="item_count" placeholder="количество"></td>
            			<td><input style="width: 80px;" class="item_amounts number recountDeal" type="text" value="" name="result[]" readonly></td>
            		</tr>
            		<tr>
            			<td colspan="2"><input style="width: 80px;"  type="text" value="<? echo($w_data['rashod']); ?>" name="item_rashod[]"> <---- Расход</td>
            			<td>
       
            		</tr>
            		
            	</table>
            	 <? if ($flag_changeorder == 1) { ?>
           			<div class="del_butt" style="margin:  5px auto; cursor: pointer; display: inline-block; border: 1px #8B8B8B solid; border-radius: 3px; padding: 3px; background-color: <? echo $main_red; ?>" onclick = " location.href = 'button_processor.php?parent=blank_zakaz&manager=<? echo $current_manager; ?>&number=<? echo $current_number; ?>&change_factor=work&field=deleted&data=1&id=<? echo($w_data['work_id']); ?>'"> удалить </div>&nbsp;&nbsp;&nbsp;
           			<div class="" style="margin: 5px auto; display: inline-block;cursor: pointer; border: 1px #8B8B8B solid; border-radius: 3px; padding: 3px; background-color: <? if ($w_data['gotov'] > 0) {echo $main_green;} else { echo $main_red;} ?>" onclick = " location.href = 'button_processor.php?parent=blank_zakaz&manager=<? echo $current_manager; ?>&number=<? echo $current_number; ?>&change_factor=work&field=gotov&data=<? if ($w_data['gotov'] == 1) { echo('0');} else { echo('1');}?>&id=<? echo($w_data['work_id']); ?>'"> ГОТОВО! </div>
           			</td>
            		<? } ?>	
            </td>
			
        </tr>
        <? } 
