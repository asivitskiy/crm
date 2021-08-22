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
            margin: 0px auto;
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

        }
        .works__row td{
            border:0;
            outline: 1px solid gray;
        }

        .works__cell--name {
            text-align: left;
            width: 205px;
        }
        .works__cell--size {
           
        }
        .works-header {
            font-size: 13px;
            height: 40px;
        }
        .works__cell--size {
            width: 30px;
            font-size: 10px;
        }
        .works__cell--amount {
            text-align: right;
        }
        .works__cell--media {
            width: 190px;
            font-size: 10px;
        }
        .works__cell--postprint {
            text-align: left;

        }
        .works__cell--tech {
            font-size: 12px;
        }
        .blank-header {

        }
        .blank-header__cell {
            font-size: 12px;
            font-weight: 300;
            text-align: center;
            overflow: hidden;
            margin: 0px auto;
            overflow: visible;
            padding: 0px;
            padding-left: 3px;
            padding-right: 3px;

        }
        .blank-header__cell--order-number {
            text-align: left;
            width: 80px;
            padding: 5px;
            font-size: 22px;
            line-height: 16px;
            border:2px solid black;
        }
        .blank-header__cell--order-datein {
            font-size: 14px;
        }
        .blank-header__cell--order-datetoend{
            font-size: 14px;
            border:2px solid black;
        }
        .blank-header__cell--title {
            width: 30px;
            line-height: 16px;
            text-align: right;
            padding-right: 15px;
        }
        .blank-header__cell--spacer {
            height: 6px;
            /*background-color: #dbdbdb;*/
            border: none;
        }

        .blank-header__cell--contragent {
            text-align: left;
            font-size:10px;
            padding-left: 5px;
            padding-right: 5px;
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

?><div style="font-size: 120px; width:100%; text-align:center; line-height:120px;"><? echo $order_data['order_number'];?></div>
    <? $cur_date = date('YmdHi');
        $date = dig_to_h($cur_date).":".dig_to_minute($cur_date)."(".dig_to_y($cur_date)."/".dig_to_m($cur_date)."/".dig_to_d($cur_date).")";
    ?>
<div style="line-height:20px; width:100%;font-size:8px;"                       ><? echo $date; ?></div>
<div style="line-height:20px; width:100%; background-color:0f0f0f" >||||||||||||||||||||||||||||||||||||||||||||</div>
<div style="line-height:20px; width:100%; background-color:0f0f0f" ><font>|||||||||||||||||    ЗАКАЗ    ||||||||||||||||||</font></div>
<div style="line-height:20px; width:100%; background-color:0f0f0f" >||||||||||||||||||||||||||||||||||||||||||||</div>


<table class="works">
    <tr class="blank-header">
        <td class="blank-header__cell blank-header__cell--order-number"><? echo $order_data['order_manager']; ?>-<? echo $order_data['order_number']; ?></td>
        <td class="blank-header__cell blank-header__cell--order-datein"><? echo(dig_to_d($datein)); ?>.<? echo(dig_to_m($datein)); ?>.<? echo(dig_to_y($datein)); ?> <? echo(dig_to_h($datein)); ?>:<? echo(dig_to_minute($datein)); ?></td>
        <td class="blank-header__cell blank-header__cell--order-datetoend"><? echo(dig_to_d($datetoend)); ?>.<? echo(dig_to_m($datetoend)); ?>.<? echo(dig_to_y($datetoend)); ?> <? echo(dig_to_h($datetoend)); ?>:<? echo(dig_to_minute($datetoend)); ?></td>
    </tr>
</table>
<table class="works">
    <tr class="blank-header">
        <td class="blank-header__cell blank-header__cell--spacer"></td>
    </tr>
</table>
<table class="works">
    <tr class="blank-header">
        <td class="blank-header__cell blank-header__cell--title">Заказчик</td>
        <td class="blank-header__cell blank-header__cell--contragent" colspan="2"><? echo($contragent_data['name']); ?> / <? echo($contragent_data['contacts']); ?></td>
    </tr>
    <tr class="blank-header">
        <td class="blank-header__cell blank-header__cell--title">Описание:</td>
        <td class="blank-header__cell blank-header__cell--contragent" colspan="2"> <? echo($order_data['order_description']); ?> </td>
    </tr>
    <tr class="blank-header">
        <td class="blank-header__cell blank-header__cell--title">Доп.:</td>
        <td class="blank-header__cell blank-header__cell--contragent" colspan="2">Допечать: <? echo($order_data['preprinter']); ?> </td>
    </tr>
</table>
<table class="works">
    <tr class="blank-header">
        <td class="blank-header__cell blank-header__cell--spacer"></td>
    </tr>
</table>




    <?
    $order_summ = 0;
    while ($works_data = mysql_fetch_array($works_query)) {
        //ищем синоним изготовления, чтобы не палить его в бланке<br>
        $ssss = $works_data['work_tech'];
        $work_type_alias_data = mysql_fetch_array(mysql_query("SELECT `outcontragent_alias` FROM `outcontragent` WHERE `outcontragent_fullname` = '$ssss'"));
        $work_tech = $work_type_alias_data['outcontragent_alias'];
        $order_summ = $order_summ + $works_data['work_count']*$works_data['work_price'];
?>
    <div style="line-height:15px; width:100%; " >&nbsp;</div>
    <div style="line-height:0px; width:100%; background-color:gray; " >&nbsp;</div>
    <table class="works" style="border:0px solid black">
    
        
        
        <tr class="works__row">
            <td class="works__cell works__cell--name" colspan=4>
                <div style="font-size: 15px; ">
                    <? if ($works_data['work_name'] == '') {echo "<div style=font-size:10px>".$works_data['work_description']."</div>";} else {echo $works_data['work_name']; }?>
                </div>
               
            </td>
            <td style="width:40px; text-align:center;" colspan="2">
                <b><? echo number_format(($works_data['work_count'])*1,0,',',''); ?></b>
            </td>
        </tr>
        <? if ($works_data['work_name'] <> '') {?>
        <tr class="works__row">
            <td class="works__cell works__cell--postprint" style=""  colspan="6"><b style="font-size: 12px"><? echo $works_data['work_description']; ?></b></td>

        </tr>
        <? } ?>
        <tr class="works__row">
            <td class="works__cell works__cell--postprint" style="background-color:#cfcfcf"  colspan="6"><b style="font-size: 12px"><? echo $works_data['work_postprint']; ?></b></td>

        </tr>
        <tr class="works__row">
            <td class="works__cell works__cell--size; text-align:left" width=50>
                <? echo $works_data['work_shir']; ?>*<? echo $works_data['work_vis'].'<br>';?>
                
            </td>

            <td class="works__cell"     ><? echo $works_data['work_color']; ?></td>
            <td class="works__cell" colspan="1"><div style="font-size: 12px;"><? 
            $rasklad = str_replace('Infinity','X',$works_data['work_rasklad']);
            $rasklad = str_replace('34320','X',$rasklad);
            $rasklad = str_replace('налист','н/л',$rasklad);
            echo $rasklad; 
            ?></div></td>
            <td class="works__cell" colspan="3"><div style="font-size: 12px;"><? echo $works_data['work_media']; ?></div></td>

        </tr>
       

        </table>

<?
    }
     ?>


<table class="works">
    <tr>
        <td style="text-align: right; height: 50px; line-height: 15px" class="works__cell">
           Итого по заказу: <font style="font-size: 18px; display: inline;"><? echo number_format(($order_summ),2,',',''); ?></font>
        </td>
    </tr>
</table>
<div style="font-size: 12px;">
<?
$messages_sql = "SELECT * FROM `order_messages` WHERE order_messages.order_number = '$number' ORDER BY order_messages.date_in_message DESC";
$messages_array = mysql_query($messages_sql);
echo "Заметки к заказу:<br>";
while ($messages_data = mysql_fetch_array($messages_array)) {
echo $messages_data['message']."<Br>";
}

?>
<? if ($order_data['delivery'] <> 0) {?>
<br>
<br>
Полные контакты:<br>
<?
echo $contragent_data['contacts']."<br>Реквизиты:<br>";
echo $contragent_data['fullinfo']."<br>Адрес доставки:<br>";
echo $contragent_data['address']."<br>";
}
?>
</div>
</body>
</html>