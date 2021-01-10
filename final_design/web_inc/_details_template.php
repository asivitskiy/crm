<?
include("dbconnect.php");
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

$order_data_sql = "    SELECT * FROM `order`
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
        <a target="_blank" class="a_orderrow" href = "printform.php?manager=<? echo $order_data_data['order_manager']; ?>&number=<? echo $order_data_data['order_number']; ?>">печатный бланк</a>
        <a target="_blank" class="a_orderrow" href = "?&myorder=1&noready=0&showlist=&clientstring=<? echo($order_data_data['id']); ?>">карточка клиента</a>
        <a target="_blank" class="a_orderrow" href="./_pdf_engine/?order_number=<? echo $order_data_data['order_number']; ?>" target="_blank">PDF</a>
    </div>

    <div class="details-ajax__orderdesc">
        <h1><? echo $order_data_data['order_description']; ?></h1>
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
            ?>
            <tr>
                <td ><b><? echo $sps_data['work_name']; ?></b><p><? echo $sps_data['work_description']; ?></p></td>
                <td ><? echo $sps_data['work_tech']; ?></td>
                <td ><? echo $sps_data['work_shir']; ?></td>
                <td ><? echo $sps_data['work_vis']; ?></td>
                <td ><? echo $sps_data['work_color']; ?></td>
                <td ><? echo $sps_data['work_media']; ?></td>
                <td ><? echo $sps_data['work_postprint']; ?></td>
                <td ><? echo $sps_data['work_price']; ?></td>
                <td ><? echo $sps_data['work_count']; ?></td>
                <td ><? echo $sps_data['work_price']*$sps_data['work_count']; ?></td>
            </tr>
            <? } ?>
            <tr>
                <td colspan="7" style="text-align: right">Сумма</td>
                <td colspan="3" style="text-align: right">5555,55</td>
            </tr>
            </tbody>

        </table>
        <div class="dopinfo">
            <div class="dopinfo__block dopinfo__block--count">Всего заказов: ХЗ (в процессе)</div>
            <div class="dopinfo__block dopinfo__block--amount">Общий оборот: ХЗ (в процессе)</div>
            <div class="dopinfo__block dopinfo__block--dolg">Сумарный долг:  ХЗ (в процессе)</div>
        </div>
    </div>
    <div class="details-ajax__fullinfo ajax-fullinfo">
        <div class="ajax-fullinfo__req">
            <?  if ($order_data_data['fullinfo'] <> '') {
                echo nl2br($order_data_data['fullinfo']);} else echo ("Платежные реквизиты не указаны"); ?>
        </div>
    </div>

</div>
