<?
include("dbconnect.php");
include ("../../inc/global_functions.php");
// Если запрос не AJAX или не передано действие, выходим
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' || empty($_REQUEST['action'])) {exit();}
$action = $_REQUEST['action'];
switch ($action) {
    case 'getContent':
        // Если не передан id страницы, тоже выходим
        $id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
        if (empty($id)) {
            exit();
        };
}
$order_number = $id;

$order_data_sql = "    SELECT *,contragents.id as cid FROM `order`
                       LEFT JOIN `contragents` ON contragents.id = order.contragent
                       WHERE order.order_number = '$order_number'";
$order_data_data = mysql_fetch_array(mysql_query($order_data_sql));
?>
<div class="details-ajax">
    <div class="details-ajax__header ajax-header">
        <h1 class="ajax-header__ordernumber"><? echo $order_data_data['order_manager'].'-'.$order_data_data['order_number']; ?></h1>
        <h2 class="ajax-header__contragent"><? echo $order_data_data['name']; ?></h2>
        <h2 class="ajax-header__contragent"><? echo $order_data_data['contacts']; ?></h2>
    </div>

    <div class="details-ajax__header ajax-buttons">

        <a target="_blank" class="a_orderrow" href = "?action=redact&order_number=<? echo $order_data_data['order_number']; ?>">редактировать</a>
        <a target="_blank" class="a_orderrow" href = "index.php?action=delete&order_manager=<? echo $order_data_data['order_manager']; ?>&order_number=<? echo $order_data_data['order_number']; ?>">удалить заказ</a>
        <a target="_blank" class="a_orderrow" href = "printform.php?manager=<? echo $order_data_data['order_manager']; ?>&number=<? echo $order_data_data['order_number']; ?>">Старый бланк</a>
        <a target="_blank" class="a_orderrow" href = "?&myorder=1&noready=0&showlist=&delivery=1&clientstring=<? echo($order_data_data['id']); ?>">карточка клиента</a>
        <a target="_blank" class="a_orderrow" href="./_pdf_engine/filemaker.php?order_number=<? echo $order_data_data['order_number']; ?>" target="_blank">PDF</a>
        <a target="_blank" class="a_orderrow" href="./_pdf_engine/?order_number=<? echo $order_data_data['order_number']; ?>" target="_blank">Печать</a>
        <a target="_blank" class="a_orderrow" style="margin-left: 100px;" href="_new_order_statuscheck.php?order_number=<? echo $order_data_data['order_number']; ?>&paystatus=paystatuschange" target="_blank">Запросить счет</a>
        <a class="a_orderrow" target="_blank" href="https://wamm.chat/home/to/<? echo $order_data_data['notification_number'];?>#list-msg-end" style="line-height:20px;">Открыть Whatsapp</a>
        <? if (strlen($order_data_data['notification_status']) <> 12) {?>
            <a target="_blank" class="a_orderrow" style="margin-left: 100px;" href="_new_order_statuscheck.php?order_number=<? echo $order_data_data['order_number']; ?>&send_notification=sendmessage" target="_blank">Сообщение</a>
        <!--<a target="_blank" class="a_orderrow" href="./_pdf_engine/?order_number=<?/* echo $order_data_data['order_number']; */?>" target="_blank">Прямая печать</a>-->
        <? } ?>
    </div>

    <div class="details-ajax__orderdesc">
        <h1><? echo $order_data_data['order_description']; ?></h1>
    </div>

    <div class="details-ajax__orderdesc">
        Дата/время приема - <? echo (dig_to_d($order_data_data['date_in'])); ?>.<? echo (dig_to_m($order_data_data['date_in'])); ?>.<? echo (dig_to_y($order_data_data['date_in'])); ?>(<? echo (dig_to_h($order_data_data['date_in'])); ?>:<? echo (dig_to_minute($order_data_data['date_in'])); ?>)<br>
        Дата/время сдачи &nbsp;&nbsp;&nbsp;- <? echo (dig_to_d($order_data_data['datetoend'])); ?>.<? echo (dig_to_m($order_data_data['datetoend'])); ?>.<? echo (dig_to_y($order_data_data['datetoend'])); ?>(<? echo (dig_to_h($order_data_data['datetoend'])); ?>:<? echo (dig_to_minute($order_data_data['datetoend'])); ?>)
    </div>

    <div class="ajax-table">
        <table class="resp-tab">
            <thead>
            <tr>
                <th>Название</th>
                <th>Техника</th>
                <th>Шир</th>
                <th>Выс</th>
                <th>Цвет</th>
                <th>Материал</th>
                <th>Постпечать</th>
                <th>Цена</th>
                <th>Кол</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?
            $sps_redact = "SELECT * FROM `works` WHERE (`work_order_number` = '$order_number')";
            $sps_array = mysql_query($sps_redact);
            while($sps_data = mysql_fetch_array($sps_array))
            {
                $amount = $amount + $sps_data['work_price']*$sps_data['work_count'];
            ?>
            <tr>
                <td ><b><? echo $sps_data['work_name']; ?></b><p><? echo $sps_data['work_description']; ?></p></td>
                <td style="text-align: center" ><? echo $sps_data['work_tech']; ?></td>
                <td style="text-align: center" ><? echo $sps_data['work_shir']; ?></td>
                <td style="text-align: center" ><? echo $sps_data['work_vis']; ?></td>
                <td style="text-align: center" ><? echo $sps_data['work_color']; ?></td>
                <td style="text-align: center" ><? echo $sps_data['work_media']; ?></td>
                <td style="text-align: center" ><? echo $sps_data['work_postprint']; ?></td>
                <td style="text-align: right" ><? echo number_format($sps_data['work_price']*1,2,',',''); ?></td>
                <td style="text-align: center" ><? echo number_format($sps_data['work_count']*1,0,',',''); ?></td>
                <td style="text-align: right" ><? echo number_format($sps_data['work_price']*$sps_data['work_count'],2,',',''); ?></td>
            </tr>
            <? } ?>
            <tr>
                <td colspan="7" style="text-align: right">Сумма</td>
                <td colspan="3" style="text-align: right"><b><? echo number_format($amount,2,',',''); ?></b></td>
            </tr>
            </tbody>
<?
$current_contragent = $order_data_data['cid'];
$cmountorders = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cnt FROM `order` WHERE `contragent` = '$current_contragent' LIMIT 1"));?>
        </table>
        <div class="dopinfo">
            <div class="dopinfo__block dopinfo__block--count">Всего заказов: <? echo number_format($cmountorders['cnt'],0,',',''); ?></div>
            <div class="dopinfo__block dopinfo__block--amount">Общий оборот: <? echo number_format(($order_data_data['contragent_inwork']*1+$order_data_data['contragent_completed']),2,',',''); ?></div>
            <div class="dopinfo__block dopinfo__block--dolg">Сумарный долг:  <? echo number_format($order_data_data['contragent_dolg']*1,2,',',''); ?></div>
        </div>
    </div>
    <div class="details-ajax__fullinfo ajax-fullinfo">
        <div class="ajax-fullinfo__req">
            <details>
                <summary>Реквизиты</summary>
                <?  if ($order_data_data['fullinfo'] <> '') {
                    echo nl2br($order_data_data['fullinfo']);} else echo ("Платежные реквизиты не указаны"); ?>
            </details>

        </div>
        <div class="ajax-fullinfo__req">
            <details>
                <summary>Адрес</summary>
                <?  if ($order_data_data['address'] <> '') {
                    echo nl2br($order_data_data['address']);} else echo ("Адрес не указан"); ?>
            </details>

        </div>
        <div class="ajax-fullinfo__req">
            <details>
                <summary>Контакты</summary>
                <?  if ($order_data_data['contacts'] <> '') {
                    echo nl2br($order_data_data['contacts']);} else echo ("Контакты не заполнены"); ?>
            </details>

        </div>
    </div>

</div>
