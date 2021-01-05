<div>

      <?
        //----------------------------конструктор запросов
        //------------------------------------------------
        $common_part_sql = "
	SELECT order.order_number, order.order_manager, order.contragent, order.order_description, order.date_in, order.deleted,
	works.work_price, works.work_count, SUM( works.work_price * works.work_count ) amount_order,
	contragents.name,contragents.id contragent_id
	FROM `order`
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
											(order.order_number LIKE '%$searchstring%')
												or 
											(contragents.fullinfo LIKE '%$searchstring%') 
												or 
											(contragents.contacts LIKE '%$searchstring%')";


        }
        if (($_GET['noready'])==1) {$where_and=$where_and." and (`deleted` <> 1)";}
        if (($_GET['myorder'])<>1) {$where_and=$where_and." and (order.order_manager = '$current_manager')";}


        //проверка на пустые значения where_or&where_end и вставка туда тупеньких условий
        if (strlen($where_or) == 0) {$where_or="order.id>0";}
        if (strlen($where_and) == 0) {$where_and="and (order.id>0)";}
        //конец проверки на пустоту переменных
        $dynamic_query_string = $common_part_sql." WHERE "."((".$where_or.")".$where_and." )"." ".$end_part_of_sql."";

        /*echo $dynamic_query_string;*/
        $data_row_array = mysql_query($dynamic_query_string);

        ?><div class="maintable"><?
        while ($data_row_data = mysql_fetch_array($data_row_array)) {

            if (dig_to_d($data_row_data['date_in']) <> dig_to_d($prev)) {$prev = $data_row_data['date_in'];	?>

                <div  class="maintable-row-wrapper maintable-row-wrapper-date ">
                        <? echo (dig_to_d($data_row_data['date_in'])); ?> / <? echo (dig_to_m($data_row_data['date_in'])); ?> / <? echo (dig_to_y($data_row_data['date_in'])); ?>
                </div>
            <? }
            if ($data_row_data['deleted'] == '1') {
                $row_corrector_1 = 'maintable-row-wrapper-ready'; } else {$row_corrector_1 = '';}

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
                <!--светофор-->
                <div class="trafficlights-wrapper">
                <div class="maintable-row-block trafficlights trafficlights-green">раб</div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                <div class="maintable-row-block trafficlights trafficlights-yellow">диз</div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                <div class="maintable-row-block trafficlights trafficlights-green" style="text-transform: none;">Алиса</div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                <div class="maintable-row-block trafficlights trafficlights-red">гот</div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                <div class="maintable-row-block trafficlights trafficlights-red">выст</div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                <div class="maintable-row-block trafficlights trafficlights-red">дост</div>
                <div class="maintable-row-block trafficlights-spacer"></div>
                <div class="maintable-row-block trafficlights trafficlights-red">док</div>
                <!--конец светофора-->
                <div class="maintable-row-block trafficlights-spacer"></div>
                <div class="maintable-row-block maintable-row-block-summ trafficlights-red">
                    <? echo number_format($data_row_data['amount_order'], 2, ',', ' ');?>
                </div>
                </div>
            </div>

 <div class="maintable-row-details" id="order-content<? echo $data_row_data['order_number']; ?>">

 </div>






        <? } ?>
    </div>
</div>