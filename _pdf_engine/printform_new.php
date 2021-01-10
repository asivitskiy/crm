<? $start = microtime(true); ?>
<? include '../dbconnect.php'; ?>
<? session_start(); ?>

<? include '../inc/global_functions.php'; ?>
<? include '../inc/cfg.php'; ?>
<? $action = $_GET['action']; ?>
<html>
<head>
    <style>
        body {
            font-family: dompdf_tahoma;
            margin: 10px;
        }
        @page { margin: 10px; }

        .works {
            /*line-height: 13px;*/
            width: 100%;
            /*border-collapse: collapse;*/
            border-spacing: 0px 0px;
            padding: 0;
            margin: 0 auto;
        }

        .works__cell {
            font-size: 14px;
            font-weight: 300;
            text-align: center;
            overflow: hidden;
            margin: 0px auto;
            overflow: visible;
            padding: 0px;
            padding-left: 3px;
            padding-right: 3px;
            border: 1px solid gray;

        }
        .works__row {
            margin: 0px auto;
            padding: 0;

            outline: 1px solid gray;
        }

        .works__cell--name {
            text-align: left;
            width: 240px;
        }
        .works__cell--size {
            width: 30px;
        }
        .works-header {
            font-size: 12px;
            background-color: #ededed;
        }
        .works__cell--size {
            width: 40px;
            font-size: 12px;
        }
        .works__cell--amount {
            text-align: right;
        }
        .works__cell--media {
            width: 190px;
        }
        .works__cell--postprint {
            text-align: left;

        }
        .works__cell--tech {
            font-size: 12px;
        }
    </style>
</head>
<body>

<?
//достаём данные заказа по менеджеру и номеру бланка

$number = $_GET['number'];
$order_sql = "SELECT * FROM `order` WHERE ((`order_number` = '$number')) LIMIT 1";

$order_query = mysql_query($order_sql);
$order_data = mysql_fetch_array($order_query);
$datetoend = $order_data['datetoend'];
$datein = $order_data['date_in'];
//используем номер айди клиента для получения его данных
$contragent_id = $order_data['contragent'];
$contragent_sql = "SELECT * FROM `contragents` WHERE ((`id`='$contragent_id')) LIMIT 1";
$contragent_query = mysql_query($contragent_sql);
$contragent_data = mysql_fetch_array($contragent_query);
//делаем запрос к базе работ по заказу, но не разбираем его, разбирать будем уже конкретно в таблице
$works_sql = "SELECT * FROM `works` WHERE ((`work_order_number`='$number'))";
$works_query  = mysql_query($works_sql);

?>

<? echo $order_data['order_number']; ?><br>
<? echo(dig_to_d($datein)); ?>.<? echo(dig_to_m($datein)); ?>.<? echo(dig_to_y($datein)); ?> <? echo(dig_to_h($datein)); ?>:<? echo(dig_to_minute($datein)); ?><br>
<? echo(dig_to_d($datetoend)); ?>.<? echo(dig_to_m($datetoend)); ?>.<? echo(dig_to_y($datetoend)); ?> <? echo(dig_to_h($datetoend)); ?>:<? echo(dig_to_minute($datetoend)); ?><br>
<? echo($contragent_data['name']); ?> / <? echo($contragent_data['contacts']); ?><br>
<? echo($order_data['paymethod']); ?> <? echo($order_data['paylist']); ?><br>


<table class="works">

    <tr class="works__row works-header">
        <td class="works__cell works__cell--name"      >Наименование</td>
        <td class="works__cell works__cell--size"      >Форм</td>
        <td class="works__cell works__cell--tech"      >Техника</td>
        <td class="works__cell works__cell--color"     >Цвет</td>
        <td class="works__cell works__cell--media"     >Матераиал</td>
        <td class="works__cell works__cell--price"     >Цена</td>
        <td class="works__cell works__cell--count"     >Кол</td>
        <td class="works__cell works__cell--amount"    >Сумма</td>
    </tr>
    <?
    $order_summ = 0;
    while ($works_data = mysql_fetch_array($works_query)) {
        //ищем синоним изготовления, чтобы не палить его в бланке<br>
        $ssss = $works_data['work_tech'];
        $work_type_alias_data = mysql_fetch_array(mysql_query("SELECT `alias` FROM `work_types` WHERE `name` = '$ssss'"));
        $work_tech = $work_type_alias_data['alias'];
        $order_summ = $order_summ + $works_data['work_count']*$works_data['work_price'];
?>


        <tr class="pdf_spacer" style="height: 0px; width: 100%; background-color: gray;"><td colspan="8"></td></tr>
        <tr class="works__row">
            <td rowspan="2" class="works__cell works__cell--name"      >
                <div style="font-size: 15px; ">
                    <? echo $works_data['work_name']; ?>
                </div>
                <font size="1">
                <? echo $works_data['work_description']; ?>
            </td>

            <td rowspan="2" class="works__cell works__cell--size"      >
                <? echo $works_data['work_shir']; ?>*<? echo $works_data['work_vis'].'<br>';
                if (stripos($works_data['work_rasklad'],"34320") === false) {
                    echo str_replace(' ', '', $works_data['work_rasklad']);
                }
                ?>
            </td>

            <td class="works__cell works__cell--tech"      ><? echo $work_tech; ?></td>
            <td class="works__cell works__cell--color"     ><? echo $works_data['work_color']; ?></td>
            <td class="works__cell works__cell--media"     ><? echo $works_data['work_media']; ?></td>
            <td rowspan="2" class="works__cell works__cell--price"     ><? echo number_format(($works_data['work_price'])*1,2,',',''); ?></td>
            <td rowspan="2" class="works__cell works__cell--count"     ><? echo number_format(($works_data['work_count'])*1,0,',',''); ?></td>
            <td rowspan="2" class="works__cell works__cell--amount"    ><? echo number_format(($works_data['work_count']*$works_data['work_price']),2,',',''); ?></td>
        </tr>
        <tr class="works__row">
            <td class="works__cell works__cell--postprint"  colspan="3">&nbsp;<b style="font-size: 11px"><? echo $works_data['work_postprint']; ?></b></td>

        </tr>




<?
    }
    echo number_format(($order_summ),2,',',''); ?>
</table>
</body>
</html>