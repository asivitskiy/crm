<div>
    <? //массив названий работ для поиска из странички поставщиков
    $worktypes_sql = "SELECT * FROM `work_types`";
    $worktypes_array = mysql_query($worktypes_sql);
    while ($worktypes_data = mysql_fetch_array($worktypes_array)) {
        $cur_id = $worktypes_data['id'];
        $cur_name = $worktypes_data['name'];
        $work_types[$cur_id] = $cur_name;
    }

    ?>
      <? if (isset($_GET['paylist_demand_owner']) or isset($_GET['paylist_demand'])) { $a=1;}
      $joiner_join = $joiner_join." LEFT JOIN `order_vars` ON order.order_number = `order_vars`.`order_vars-order_id`";
      $joiner_fields = $joiner_fields." `order_vars`.`order_vars-design_flag`,`order_vars`.`order_vars-reorder_flag`,`order_vars`.`order_vars-error`, ";
        //----------------------------конструктор запросов
        //------------------------------------------------
        $common_part_sql = "
	SELECT order.notification_status,contragents.notification_number,order.paymethod,order.preprint,order.preprinter,order.soglas,order.date_of_end,order.datetoend,order.order_number, order.order_manager, order.contragent, order.order_description, order.date_in, order.deleted,
	works.work_price, works.work_count, (select SUM(works.work_price * works.work_count) from `works` where works.work_order_number=order.order_number) as amount_order,
	contragents.name,contragents.id contragent_id,order.paystatus,order.delivery,order.paylist,order.preprint,
    ".$joiner_fields."	
	(select SUM(money.summ) from `money` where money.parent_order_number = order.order_number) as amount_money
	FROM `order`
    ".$joiner_join."
	LEFT JOIN `contragents` ON order.contragent = contragents.id
	LEFT JOIN `works` ON order.order_number = works.work_order_number";
        $end_part_of_sql = "GROUP BY order.order_number ORDER BY order.date_in DESC";

        $filter = $_GET['argument'];

        /*		switch ($_GET['filter'])	{
                        case 'contragent':
                            if (strlen($where_and)>0) {$where_and=$where_and." or ";}
                            $where_and=$where_and." and (`contragent`='$filter')";
                            break;*/
        if (isset($_GET['clientstring']) and (strlen($_GET['clientstring'])>0))	{
            $clientstring = $_GET['clientstring'];
            $where_and=$where_and." and (`contragent`='$clientstring')";
        }
        if (isset($_GET['searchstring']) and (strlen($_GET['searchstring'])>0)) {
            $searchstring = $_GET['searchstring'];
            $where_or = $where_or."(contragents.name LIKE '%$searchstring%')
												or
											  (order.order_description LIKE '%$searchstring%')
												or
                                              (order.paylist LIKE '%$searchstring%')
  												or
  										      (order.order_number LIKE '%$searchstring%')
												or
											  (contragents.fullinfo LIKE '%$searchstring%')
												or
											  (contragents.contacts LIKE '%$searchstring%')";


        }
        if (($_GET['noready'])==1) {$where_and=$where_and." and (`deleted` <> 1)";}
        if (($_GET['myorder'])<>1) {$where_and=$where_and." and (order.order_manager = '$current_manager')";}
        if (($_GET['delivery'])<>1) {$where_and = $where_and." and (`delivery` = 1)";}

        //формирование списка бланков, в которых есть поставщик, либо номер счета
          if ($_GET['paylist_demand_owner'] <> '') {
              $reorder_id = $_GET['paylist_demand_owner'];
              $reorder_name = $work_types[$reorder_id];
              $works_reorder_sql = "SELECT DISTINCT `work_order_number` FROM `works` WHERE `work_tech` = '$reorder_name'";
              $works_reorder_array = mysql_query($works_reorder_sql);
              while ($works_reorder_data = mysql_fetch_array($works_reorder_array)) {
                  $workstring_array[] = $works_reorder_data['work_order_number'];
              }
              $workstring = implode(',',$workstring_array);
              //вот в этой строчке список бланков, в которых есть перезаказ от поставщика с номером $_GET['paylist_demand_owner']
              $where_and = $where_and." and (order.order_number IN ($workstring))";
          }
          if ($_GET['paylist_demand'] <> '') {
              $reorder_name = $_GET['paylist_demand'];
              $works_reorder_sql = "SELECT DISTINCT `work_order_number` FROM `works` WHERE `work_rashod_list` = '$reorder_name'";
              $works_reorder_array = mysql_query($works_reorder_sql);
              while ($works_reorder_data = mysql_fetch_array($works_reorder_array)) {
                  $workstring_array[] = $works_reorder_data['work_order_number'];
              }
              $workstring = implode(',',$workstring_array);
              //вот в этой строчке список бланков, в которых есть перезаказ от поставщика с номером $_GET['paylist_demand_owner']
              $where_and = $where_and." and (order.order_number IN ($workstring))";
          }



        //проверка на пустые значения where_or&where_end и вставка туда тупеньких условий
        if (strlen($where_or) == 0) {$where_or="order.id>0";}
        if (strlen($where_and) == 0) {$where_and="and (order.id>0)";}
        //конец проверки на пустоту переменных
        $dynamic_query_string = $common_part_sql." WHERE "."((".$where_or.")".$where_and." )"." ".$end_part_of_sql."";

        /*echo $dynamic_query_string;*/
        $data_row_array = mysql_query($dynamic_query_string);

        ?><div class="maintable"><?
        /*echo $dynamic_query_string;*/
        while ($data_row_data = mysql_fetch_array($data_row_array)) {

            if (dig_to_d($data_row_data['date_in']) <> dig_to_d($prev)) {$prev = $data_row_data['date_in'];	?>

                <div  class=" maintable-row-wrapper-date ">
                        <? echo (dig_to_d($data_row_data['date_in'])); ?> / <? echo (dig_to_m($data_row_data['date_in'])); ?> / <? echo (dig_to_y($data_row_data['date_in'])); ?>
                </div>

            <? }
            if ($data_row_data['deleted'] == '1') {
                $row_corrector_1 = 'maintable-row-wrapper-ready'; } else {$row_corrector_1 = '';}

            ?>
            <?
            $iii++;
            if(($iii % 2) == 0){$row_corrector_1 = $row_corrector_1." stroka";}
            ?>
            <div class="maintable-row-wrapper <? echo $row_corrector_1; ?> read-more " data-id="<? echo $data_row_data['order_number']; ?>" data-contragent="<? echo $data_row_data['contragent']; ?>">


                <div class="maintable-row-block maintable-row-block-word">
                    <? echo $data_row_data['order_manager']; ?>
                </div>
                <div class="maintable-row-block maintable-row-block-dash">-</div>
                <div class="maintable-row-block maintable-row-block-number">
                    <? echo $data_row_data['order_number']; ?>
                </div>

                <div class="maintable-row-block maintable-row-block-contragent">
                    <? echo $data_row_data['name']; ?>
                </div>


                <div class="maintable-row-block maintable-row-block-description">
                    <? echo $data_row_data['order_description']; ?>
                </div>

                <div class="maintable-row-block maintable-row-block-date">
                    <? echo dig_to_d($data_row_data['date_in']).".".dig_to_m($data_row_data['date_in']); ?>
                    <? echo "> ".dig_to_d($data_row_data['datetoend']).".".dig_to_m($data_row_data['datetoend']); ?>
                </div>
                <div class="maintable-row-block trafficlights-spacer" style="width: 5px;">&nbsp;</div>
                <!--светофор-->
                <!--<div class="trafficlights-wrapper">-->
                    <?
                    switch (true) {
                        case ($data_row_data['soglas'] > 0):
                            $add = "trafficlights-green";
                            break;
                        case ($data_row_data['soglas'] == 0):
                            $add = "trafficlights-red";
                            break;
                    } ?>
                <div class="maintable-row-block trafficlights trafficlights-work trafficlights-green <? echo $add; ?>">раб</div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                    <?
                    if (($data_row_data['notification_status']) == ''){
                        if (strlen($data_row_data['notification_number']) == 11) {$add = "trafficlights-yellow";}
                        if (strlen($data_row_data['notification_number']) <> 11) {$add = "trafficlights-gray";}
                    } else {$add = "trafficlights-green";}
                    ?>

                <div class="maintable-row-block trafficlights trafficlights-work trafficlights-green <? echo $add; ?>">W</div>
                <div class="maintable-row-block trafficlights-spacer"></div>

                    <?
                    if ($data_row_data['order_vars-design_flag'] == 2)
                        {$add = "trafficlights-green";}
                    else if ($data_row_data['order_vars-design_flag'] == 1)
                            {$add = "trafficlights-yellow";} else {$add = "trafficlights-gray";}
                    ?>
                <div class="maintable-row-block trafficlights  <? echo $add; ?>">диз</div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                    <?
                    switch(true) {
                        case (($data_row_data['preprint'] == 'Аня') or ($data_row_data['preprint'] == "Алиса")):
                            $add = "trafficlights-red";
                            break;
                        case ((strlen($data_row_data['preprint']) == 12) or ($data_row_data['preprint'] = "Нет")):
                            $add = "trafficlights-green";
                            break;
                    }
                    ?>
                <div class="maintable-row-block trafficlights trafficlights-green <? echo $add; ?>" style="text-transform: none"><? echo $data_row_data['preprinter']; ?></div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                    <?
                    if (((strlen($data_row_data['date_of_end'])) <> 12)) {
                        $add = "trafficlights-red";	} else { $add = "trafficlights-green";} ?>
                <div class="maintable-row-block trafficlights <? echo $add; ?>">гот</div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                    <?
                    switch(true) {
                        case (((strlen($data_row_data['paystatus'])) == 12) and ($data_row_data['paylist'] <> '')):
                            $add = "trafficlights-green";
                            break;
                        case (((strlen($data_row_data['paystatus'])) == 12) and ($data_row_data['paylist'] == '')):
                            $add = "trafficlights-yellow";
                            break;
                        case ((strlen($data_row_data['paystatus'])) <> 12):
                            $add = "trafficlights-gray";
                            break;

                    } ?>
                <div class="maintable-row-block trafficlights <? echo $add; ?>">
                    <?  if ($data_row_data['paymethod'] == "ООО") { echo "ООО";} 
                        else if ($data_row_data['paymethod'] == "ИП") { echo "ИП";} 
                        else { echo "Выст";} 
                        ?> <!-- выставлен не выставлен и с каких реквизитов -->
                </div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                    <?
                    switch(true) {
                        case ($data_row_data['delivery'] == 1):
                            $add = "trafficlights-red";
                            break;
                        case ($data_row_data['delivery'] > 1):
                            $add = "trafficlights-green";
                            break;
                        case ($data_row_data['delivery'] == 0):
                        case ($data_row_data['delivery'] == 0):
                            $add = "trafficlights-gray";
                            break;
                    } ?>
                <div class="maintable-row-block trafficlights <? echo $add; ?>">дост</div>
                <!--<div class="maintable-row-block trafficlights-spacer"></div>
                <div class="maintable-row-block trafficlights trafficlights-red">док</div>-->
                <!--конец светофора-->
                <div class="maintable-row-block trafficlights-spacer"></div>
                    <? $add2 = '';
                    if ($data_row_data['amount_money'] == 0) {$add2 = "trafficlights-red";} else
                    if (abs($data_row_data['amount_order']*1 - $data_row_data['amount_money']*1) < 1) {$add2 = "trafficlights-green";} else {$add2 = "trafficlights-yellow";}

                    ?>
                <div class="maintable-row-block maintable-row-block-summ <? echo $add2; ?>">
                    <? echo number_format($data_row_data['amount_order'], 2, ',', ' ');?>
                </div>
                    <div class="maintable-row-block trafficlights-spacer"></div>
                    <?
                    $add = '';
                    switch(true) {
                        case ($data_row_data['order_vars-reorder_flag'] == 1):
                            $add = "trafficlights-yellow";
                            break;
                        case ($data_row_data['order_vars-reorder_flag'] == 0):
                            $add = "noscreen";
                            break;
                    } ?>
                   <!-- <div class="maintable-row-block trafficlights trafficlights-roud"></div>-->
                    <div class="maintable-row-block trafficlights-spacer"></div>

                    <div class="maintable-row-block trafficlights-pzk trafficlights trafficlights-roud <? echo $add; ?>">ПЗК</div>
                    <div class="maintable-row-block trafficlights-spacer"></div>
                    <?
                    $add = '';
                    switch(true) {
                        case ($data_row_data['order_vars-error'] == 1):
                            $add = "trafficlights-red";
                            break;
                        case ($data_row_data['order_vars-error'] == 0):
                            $add = "noscreen";
                            break;
                    } ?>

                    <div class="maintable-row-block trafficlights trafficlights-osh trafficlights-roud <? echo $add; ?>">ОШБ</div>

                <!--</div>-->
            </div>

 <div class="maintable-row-details" id="order-content<? echo $data_row_data['order_number']; ?>">

 </div>




<? ob_flush(); ?>

        <? } ?>
    </div>
</div>
