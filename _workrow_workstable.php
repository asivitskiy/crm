<? 		$main_table_row = "SELECT * FROM `works` WHERE ((`work_order_manager`='$order_manager') AND (`work_order_number`='$order_number'))";
		$main_table_array = mysql_query($main_table_row);
		$workrowcount = mysql_num_rows($main_table_array);
		while ($main_table_data = mysql_fetch_array($main_table_array) or $workrowcount==0) { $workrowcount = $workrowcount + 1; ?>

    
    <div class="mainWrapper">    
    <input class="item_ids" name="work_id[]" value="<? ?>" type="hidden" style="">
    <input type="hidden" name="work_sheets[]">
        <div class="wrWrapper">
            <div class="rowWrapper firstRow">
                <div class="rowElement  workName"><textarea name="work_name[]" autocomplete="" id="tags2" ><? echo($main_table_data['work_name']); ?></textarea></div>
                <div class="rowElement  workTech">
                        <select name="work_tech[]">
                                            <option style=""></option>
     								            <? 	
										    $worktype_array  = mysql_query("SELECT * FROM `outcontragent` WHERE `outcontragent_blank_visible`=1 ORDER by `outcontragent_id`");
											while ($worktype_data = mysql_fetch_array($worktype_array)) {?>
							                <option <? if ($main_table_data['work_tech'] == $worktype_data['outcontragent_fullname']) {echo('selected');} ?> value="<? echo $worktype_data['outcontragent_fullname'];?>"><? echo $worktype_data['outcontragent_fullname'];?></option>
											<? } ?>
                        </select>
                </div>
                <div class="rowElement  workColor">
                    <select  name="work_color[]">
                                    <option style="display: none"></option>
     								<option <? if ($main_table_data['work_color'] == 'mix') {echo('selected');} ?> value="mix">mix</option>
      								<option <? if ($main_table_data['work_color'] == '4+0') {echo('selected');} ?> value="4+0">4+0</option>
      								<option <? if ($main_table_data['work_color'] == '4+4') {echo('selected');} ?> value="4+4">4+4</option>
									<option <? if ($main_table_data['work_color'] == '4+1') {echo('selected');} ?> value="4+1">4+1</option>
									<option <? if ($main_table_data['work_color'] == '1+1') {echo('selected');} ?> value="1+1">1+1</option>
									<option <? if ($main_table_data['work_color'] == '1+0') {echo('selected');} ?> value="1+0">1+0</option>
                    </select>
                </div>
                <div class="rowElement  workFormat">
                    <select name="work_format[]" onChange="matchformat(this)">
                                    <option value="none"></option>
                                    <option value="А1">А1</option>
                                    <option value="А2">А2</option>
                                    <option value="А3">А3</option>
                                    <option value="А4">А4</option>
                                    <option value="А5">А5</option>
                                    <option value="А6">А6</option>
                    </select>
                </div>
                <div class="rowElement  workWidth"><input data-column="recount"  name="work_shir[]"  onkeyup="raskladka(this)" onClick="raskladka(this)" placeholder="Ш" value="<? echo($main_table_data['work_shir']); ?>"></div>
                <div class="rowElement  workHeight"><input data-column="recount"  name="work_vis[]" onkeyup="raskladka(this)" onClick="raskladka(this)" placeholder="В" value="<? echo($main_table_data['work_vis']); ?>"></div>
                <div class="rowElement  workMedia">
                    <select name="work_media[]">
                        <option value=""></option>
	  			        <? 	$media_type_query  = mysql_query("SELECT * FROM `media_types` ORDER by `desc1`");
							while ($media_type_data = mysql_fetch_array($media_type_query)) {?>
							<option <? if ($main_table_data['work_media'] == $media_type_data['name']) {echo('selected');} ?> value="<? echo $media_type_data['name'];?>"><? echo $media_type_data['name'];?></option>
											<? } ?>                                
                    </select>
                </div>
                

            </div>
            
            <div class="rowWrapper spacer"></div>
            
            <div class="rowWrapper secondRow">
                <div class="rowElement  workDescription">
                    <textarea  name="work_description[]" placeholder="описание работы"><? echo($main_table_data['work_description']); ?></textarea>
                </div>
                <div class="rowElement  workPostprint">
                    <textarea name="work_postprint[]" placeholder="постпечатная обработка"><? echo($main_table_data['work_postprint']); ?></textarea>
                </div>
                <div class="rowElement  workRasklad">
                    <textarea  wrap="off" name="work_rasklad[]" onClick="raskladka(this)"><? echo($main_table_data['work_rasklad']); ?></textarea>
                </div>
                

            </div>
            
 
        </div>

        <div class="rWrapper">
            <div class="priceBlock priceBlock_firstrow">
                <div class="rowElement rowElement_priceblock priceBlock_firstrow">
                    <input  class="checkRow" onkeyup="checkRow(this)" onKeyUp="doublesumm()"  type="text" value="<? echo($main_table_data['work_price']); ?>" name="work_price[]" id="item_price" placeholder="цена">
                </div>
                <div class="rowElement rowElement_priceblock priceBlock_firstrow">
                    <input class="item_quantities number checkRow recountDeal" onkeyup="checkRow(this);raskladka(this)" onMouseMove="checkRow(this)" type="text" value="<? echo($main_table_data['work_count']); ?>" onClick="raskladka(this)" name="work_count[]" id="item_count" placeholder="кол.">
                </div>
                <div class="rowElement rowElement_priceblock priceBlock_firstrow">
                    <input  value="<? echo number_format($main_table_data['work_count']*$main_table_data['work_price'],2,'.',''); ?>" name="result[]" readonly>
                </div>
                <div class="rowElement rowElement_priceblock priceBlock_secondrow">
                    <input value="<? echo($main_table_data['work_rashod']); ?>" name="work_rashod[]" placeholder="расход">
                </div>
                <div class="rowElement rowElement_priceblock priceBlock_secondrow">
                    <select name="work_rashod_list[]">
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
							}
						
						
							}
							//LEGACY (тут список уже из новых счетов расхода. ту часть, что выше находится - удалить после выработки старых счетов)
							//ПОКА НЕ ВКЛЮЧЕНО! И СКОРЕЕ ВСЕГО И НЕ БУДЕТ ВКЛЮЧАТЬСЯ
							$new_demands_sql = "SELECT * FROM `outcontragent_demand`
												LEFT JOIN `outcontragent` ON outcontragent_demand.demand_outcontragent_id = outcontragent.outcontragent_id
												WHERE outcontragent.outcontragent_fullname = '$current_work_tech'";
							$new_demands_array = mysql_query($new_demands_sql);
							while ($new_demands_data = mysql_fetch_array($new_demands_array)) {
								//echo "<option>".$new_demands_data['demand_number']."</option>";	
							}
							?>
                    </select>
                </div>
            </div>
        </div>



    </div>  
    <? } ?>  
        <button class="click">Добавить</button>
        <button class="click2">Убавить</button>
