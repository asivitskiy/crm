    <?
    //TEMP - строковые поиски
    //PERMANENT - логические поиски
    //массив кнопок (название, статусы, отображение)
    $button_default['noready'] = '0';    $button_type['noready'] = 'permanent'; $button_placeholder['noready'] = 'Отображать завершенные';
    $button_default['myorder'] = '1';    $button_type['myorder'] = 'permanent'; $button_placeholder['myorder'] = 'Только мои';
    $button_default['searchstring'] = '';$button_type['searchstring'] = 'temp'; $button_placeholder['searchstring'] = 'Текст поиска: ';
    $button_default['clientstring'] = '';$button_type['clientstring'] = 'temp'; $button_placeholder['clientstring'] = 'Клиент: ';


    //генератор ссылок, которые отменяют фильтр, который включается по этой ссылке
    foreach($button_type as $key_out => $value_out){
        $this_a_href = '';
        if	(($key_out == 'showlist')) { continue; }

        foreach($_GET as $key => $value){
            if	(($key_out == $key)) { 	if ($button_type[$key] == 'temp') { continue;}
                switch ($value) {
                    case 0: $value = 1; break;
                    case 1: $value = 0; break; }
            }
            $this_a_href = $this_a_href.'&'.$key;
            $this_a_href = $this_a_href.'='.$value;
        }
        $activeflag = '';
        $button_text = '';

        if (($_GET[$key_out]<>'') and ($button_type[$key_out]=='temp')) {
            $activeflag = ' active';
            if ($key_out == 'clientstring') {
                /*echo $_GET[$key_out].'asdasdsd';*/
                $attr1 = $_GET[$key_out];
                $butt_sql_data = mysql_fetch_array(mysql_query("SELECT * FROM `contragents` WHERE `id`='$attr1' LIMIT 1"));
                $button_text = "<b>".$butt_sql_data['name']."</b>";
            } else {
                $button_text = "<b>".$_GET[$key_out]."</b>"; }
        }

        if (($_GET[$key_out]<>1) and ($button_type[$key_out]=='permanent')) {$activeflag = ' active';}
        echo "<a href=?";echo $this_a_href;
        echo " type=button class='btn btn-sm btn-outline-secondary mr-1 ".$activeflag."'>"; echo $button_placeholder[$key_out].$button_text; echo "</a>";
    }

    if ($_GET['filter'] == 'contragent') {$contragent=' active';$contragent_value = $_GET['argument'];} ?>



        <?
        //----------------------------конструктор запросов
        //------------------------------------------------


        //общая часть запроса, то что всегда одинаковое (тут перечислены поля, которые выбираются и таблицы которые джойнятся
        $common_part_sql = "
                    SELECT order.order_number, order.order_manager, order.contragent, order.order_description, order.date_in, order.deleted,
                    works.work_price, works.work_count, SUM( works.work_price * works.work_count ) amount_order,
                    contragents.name,contragents.id contragent_id
                    FROM `order`
                    LEFT JOIN `contragents` ON order.contragent = contragents.id
                    LEFT JOIN `works` ON order.order_number = works.work_order_number";

        //завершающая часть запроса - группировкасортировка
        $end_part_of_sql = "GROUP BY order.order_number ORDER BY order.date_in DESC";

        //фильтрующая часть запроса (тут собираются условия выборки в одно большое условие
        $filter = $_GET['argument'];


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
											(contragents.notification_number LIKE '%$searchstring%') 
												or 
											(contragents.contacts LIKE '%$searchstring%')";


        }
        if (($_GET['noready'])==1) {$where_and=$where_and." and (`deleted` <> 1)";}
        if (($_GET['myorder'])<>1) {$where_and=$where_and." and (order.order_manager = '$current_manager')";}


        //проверка на пустые значения where_or&where_end и вставка туда заведомо выполнимых условий
        if (strlen($where_or) == 0) {$where_or="order.id>0";}
        if (strlen($where_and) == 0) {$where_and="and (order.id>0)";}
        //конец проверки на пустоту переменных


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////сборка услвий в одну кучу/////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $dynamic_query_string = $common_part_sql." WHERE "."((".$where_or.")".$where_and." )"." ".$end_part_of_sql;
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////



        $data_row_array = mysql_query($dynamic_query_string);
        while ($data_row_data = mysql_fetch_array($data_row_array)) {

            if (dig_to_d($data_row_data['date_in']) <> dig_to_d($prev)) {$prev = $data_row_data['date_in'];	?>
                <tr style="border-bottom: 0px solid black; font-weight: bold; margin-left: -100px; background-color:#ECECEC">
                    <td colspan="6">
                        <? echo (dig_to_d($data_row_data['date_in'])); ?>.<? echo (dig_to_m($data_row_data['date_in'])); ?>.<? echo (dig_to_y($data_row_data['date_in'])); ?>
                    </td>
                </tr>
            <? } ?>
            <div class="sss">
                <tr class="read-more <? if ($data_row_data['deleted'] == '1') { ?>alert-light<? } ?>" data-id=<? echo $data_row_data['order_number']; ?>>
                    <td style=""><? echo $data_row_data['order_manager']; ?>-<? echo $data_row_data['order_number']; ?></td>
                    <td class="" style="overflow: hidden;"><b><div class="text-nowrap pr-1" style="width:250px;"><? echo $data_row_data['name']; ?></div></b></td>
                    <td class="text-nowrap"><? echo $data_row_data['order_description']; ?></td>
                    <td><div class="workrow_summary" style="white-space: nowrap;">
                            <div class="workrow_box">выст</div>
                            <div class="workrow_box">выст</div>
                            <div class="workrow_box">выст</div>
                            <div class="workrow_box">выст</div>
                            <div class="workrow_box">выст</div>
                            <div class="workrow_box">выст</div>
                            <div class="workrow_box">выст</div>

                        </div></td>
                    <td class="text-right text-nowrap"><? echo number_format($data_row_data['amount_order'], 2, ',', ' ');?></td>

                </tr>


                <tr style="padding: 0px; background: none;" class="details_bottom<? echo $data_row_data['order_number']; ?>">
                    <td colspan="6" id="order-content<? echo $data_row_data['order_number']; ?>" style="padding: 0px;"></td>
                </tr>
            </div>

        <? } ?>



        </tbody>
    </table>
</div>