<br>
<br>
<a class="a_orderrow" href="?action=cashbox">Назад в кассу</a><br>
<table class="cashbox_table qr_checker" border="1" cellspacing="0">
    <tr class="" style="height: 40px;  background-color:#aaaaaa">
                <td style="width:70px;">Бланк</td>
                <td style="width:100px;">Заказчик</td>
                <td style="width:100px;text-align:right;">Сумма в коде</td>
                <td style="width:150px;text-align:right;">Дата отправки</td>
                
                <td style="width:150px;text-align:right;">Действия</td>
                <td style="width:150px;text-align:right;">Чек</td>
                <td style="width:150px;text-align:right;">Состояние оплаты заказа<br>Оплачено/общая сумма</td>
                
               
	</tr>
<?
    //тело для авторизованого пользователя


    $qr_main_list_sql = "   SELECT * FROM `qr_pay` 
                            LEFT JOIN `order` ON order.order_number = qr_pay.qr_pay_order_number
                            LEFT JOIN `contragents` ON order.contragent = contragents.id
                            ORDER by `qr_pay_id` DESC
                            LIMIT 50";
    $qr_main_list_array = mysql_query($qr_main_list_sql);
    while ($qr_main_list_data = mysql_fetch_array($qr_main_list_array)) {
        //ОСНОВНОЙ ЦИКЛ ПЕРЕБОРА ЗАПРОСОВ НА КУРКОД
            
            //идентификатор куркода
            $qr_pay_id = $qr_main_list_data['qr_pay_id'];
            
            //БЛАНК
            $qr_pay_order_number = $qr_main_list_data['qr_pay_order_number'];
            
            //СУММА УКАЗАННАЯ В КУРКОДЕ
            $qr_pay_summ = $qr_main_list_data['qr_pay_summ'];
            if ($qr_pay_summ == 0) {
                $qr_pay_summ = "<b> Б/С </b>";
            }
            //ДАТА ОТПРАВКИ КУРКОДА
            $qr_sended = $qr_main_list_data['qr_sended'];

            $qr_contragnet_name = $qr_main_list_data['name'];

            $qr_contragnet_manager = $qr_main_list_data['order_manager'];

            /////////////////////////////////////////////
            //ТЕЛО ЦИКЛА ПЕРЕБОРА
            /////////////////////////////////////////////
                    //сумма остатка по заказу
                    $works_sql = "SELECT SUM( works.work_price * works.work_count ) as `summa` FROM `works` WHERE `work_order_number` ='$qr_pay_order_number'";
                    $works_darray = mysql_query($works_sql);
                    $works_data = mysql_fetch_array($works_darray);
                    $work_amount = $works_data['summa'];

                    $money_sql = "SELECT SUM(money.summ) as `summa` FROM `money` WHERE `parent_order_number` ='$qr_pay_order_number'";
                    $money_darray = mysql_query($money_sql);
                    $money_data = mysql_fetch_array($money_darray);
                    $money_amount = $money_data['summa']*1;

                    if (abs($money_amount*1 - $work_amount*1) < 0.1) {
                            $style_summ = "style=text-align:right;background-color:#CDFAB5;";
                    } else {
                            $style_summ = "style=text-align:right;background-color:#FAF5AB;";
                    }
                    if ($money_amount == 0) { $style_summ = "style=text-align:right;";}

                    $checker_text_result = '';
                    if ($qr_main_list_data['qr_checked'] == 0) {
                        $style_check = "style=background-color:#FAF5AB;text-align:right;";
                        $checker_text_result = "<a class=a_orderrow href=_qr_checker_processor.php?qr_id=".$qr_pay_id."&action=check>Выбить чек</a>";
                        $check_condition = "Чек не выбит";
                    } else {
                        $style_check = "style=background-color:#CDFAB5;text-align:right;";
                        $checker_text_result = "<a class=a_orderrow href=_qr_checker_processor.php?qr_id=".$qr_pay_id."&action=uncheck>Отменить чек</a>";
                        $check_condition = "Чек выбит";
                    }



            ?>
                <tr class="">
                    <td><a target="_blank" class="a_orderrow" href="?action=redact&order_number=<? echo $qr_pay_order_number; ?>"><? echo $qr_contragnet_manager."-".$qr_pay_order_number; ?></a></td>
                    <td style="text-align:left;"><? echo $qr_contragnet_name;  ?></td>
                    <td style="text-align:right;"><? echo  $qr_pay_summ; ?></td>
                    <td style="text-align:right;"><? echo dig_to_d($qr_sended)." / ".dig_to_m($qr_sended)." / ".dig_to_y($qr_sended); ?></td>
                    
                    <td> 
                        <? echo $checker_text_result; ?>
                        <a class=a_orderrow href=_qr_checker_processor.php?qr_id=<? echo $qr_pay_id; ?>&action=delete>Удалить</a>
                    </td>
                    <td <? echo $style_check; ?>> <? echo  $check_condition;?></td>
                    <td <? echo $style_summ; ?>><? echo number_format($money_amount,2,'.','')." / ".number_format($work_amount,2,'.','');?></td>
                    
                </tr>
	 	   
            <?
    }





?>