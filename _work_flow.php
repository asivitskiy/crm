<?
include "./dbconnect.php";
include "./inc/global_functions.php";
$dayarray = array("","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскрескенье");
function elemMaker($man,$num) {
    ?>
                    <div class="graphElement"">
                        <div class="_n_blank" onclick="clicker(this)"><? echo $man."-".$num;?></div><br>
                        <div class="_n_redact" onclick="window.open('./?action=redact&order_number=<? echo $num;?>','_blank')">Ред.</div><br><br>
                        <div class="_n_ready" onclick="location.href='_work_flow_readymaker.php?order_number=<? echo $num;?>'">Готов</div><br>
                        <!--<div class="closerButton" onclick="closeElem(this)">закрыть</div>-->
                        <br>
                    </div><?
}
function dateChecker()
{   $hz = date("Ymd");
    while (count($dates)<4) {
        //проверка на наличие заказов в проверяемом дне

        $checkarray = mysql_query("SELECT COUNT(1) FROM `order` WHERE order.datetoend LIKE '%$hz%'");
        $aaa = mysql_fetch_array($checkarray);

        if (((date("w", strtotime(date($hz))) <> 6) and (date("w", strtotime(date($hz))) <> 0)) or ($aaa[0]>0)) {
            $dates[] = $hz;
            $hz = date('Ymd', strtotime($hz .' +1 day'));
            //если не выходной - пропустится
        } else {$hz = date('Ymd', strtotime($hz .' +1 day'));}
}
    return $dates;
}
$k = dateChecker();
$today_start = ($k[0]."0000")*1;
$today_dinner = ($k[0]."1200")*1;
$today_evening = ($k[0]."1600")*1;
$today_end   = ($k[0]."2359")*1;

$tomorrow_start = ($k[1]."0000")*1;
$tomorrow_dinner = ($k[1]."1200")*1;
$tomorrow_evening = ($k[1]."1600")*1;
$tomorrow_end   = ($k[1]."2359")*1;

$aftertomorrow_start = ($k[2]."0000")*1;
$aftertomorrow_dinner = ($k[2]."1200")*1;
$aftertomorrow_evening = ($k[2]."1600")*1;
$aftertomorrow_end   = ($k[2]."2359")*1;

$past_sql = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend<'$today_start') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$past_array = mysql_query($past_sql);

$now_sql_p1  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>'$today_start') and (order.datetoend<='$today_dinner') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$now_array_p1 = mysql_query($now_sql_p1);
$now_sql_p2  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>'$today_dinner') and (order.datetoend<='$today_evening') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$now_array_p2 = mysql_query($now_sql_p2);
$now_sql_p3  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>'$today_evening') and (order.datetoend<='$today_end') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$now_array_p3 = mysql_query($now_sql_p3);

$tomorrow_sql_p1  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>'$tomorrow_start') and (order.datetoend<='$tomorrow_dinner') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$tomorrow_array_p1 = mysql_query($tomorrow_sql_p1);
$tomorrow_sql_p2  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>'$tomorrow_dinner') and (order.datetoend<='$tomorrow_evening') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$tomorrow_array_p2 = mysql_query($tomorrow_sql_p2);
$tomorrow_sql_p3  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>'$tomorrow_evening') and (order.datetoend<='$tomorrow_end') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$tomorrow_array_p3 = mysql_query($tomorrow_sql_p3);

$aftertomorrow_sql_p1  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>'$aftertomorrow_start') and (order.datetoend<='$aftertomorrow_dinner') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$aftertomorrow_array_p1 = mysql_query($aftertomorrow_sql_p1);
$aftertomorrow_sql_p2  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>'$aftertomorrow_dinner') and (order.datetoend<='$aftertomorrow_evening') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$aftertomorrow_array_p2 = mysql_query($aftertomorrow_sql_p2);
$aftertomorrow_sql_p3  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>'$aftertomorrow_evening') and (order.datetoend<='$aftertomorrow_end') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$aftertomorrow_array_p3 = mysql_query($aftertomorrow_sql_p3);

$late_sql  = "SELECT * FROM `order` WHERE ( (order.order_has_digital = 1) and (order.datetoend>='$aftertomorrow_end') and (order.deleted<>1) and (order.handing=0) and (order.soglas<>0) and (order.order_ready_digital<10))";
$late_array = mysql_query($late_sql);



/*$tomorrow_sql  = "SELECT * FROM `order` WHERE ((order.order_has_digital = 1) and (order.datetoend>'$tomorrow_start') and (order.datetoend<'$tomorrow_end') and (order.deleted<>1))";
$tomorrow_array = mysql_query($tomorrow_sql);

$aftertomorrow_sql  = "SELECT * FROM `order` WHERE ((order.order_has_digital = 1) and (order.datetoend>'$aftertomorrow_start') and (order.datetoend<'$aftertomorrow_end') and (order.deleted<>1))";
    $aftertomorrow_array = mysql_query($aftertomorrow_sql);

$late_sql  = "SELECT * FROM `order` WHERE ((order.order_has_digital = 1) and (order.datetoend>'$aftertomorrow_end') and (order.deleted<>1))";
    $late_array = mysql_query($late_sql);*/

//получаем массив из трёх рабочих дней, включая сегодняшний
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .workflow_table * {
            font-family: Tahoma;
            text-align: center;
        }
        .workflow_table {
            width: 1600px;
        }
        .graphic {
            width: 150px;
            vertical-align: top;
            /*height: 700px;*/
/*            display: flex;
            align-items: flex-start;*/
        }
        .timeline {
/*            border-bottom: 1px solid black;
            border-left: 1px solid black;*/
            height: 30px;
            width: 150px;
            box-sizing: border-box;
        }
        .graphicsContainer {
            width: 150px;
            display: flex;
            align-content: flex-start;
            flex-wrap: wrap;
        }
        .graphElement {
            /*cursor: pointer;*/
            margin: 2px 2px 2px 2px;
            border-radius: 3px;
            width: 65px;
            height: 22px;
            border: 1px dotted grey;
            white-space: nowrap;
            overflow: hidden;
        }
        .large {
            display: block;
            width: 136px;
            height: 130px;
        }
        .closerButton,._n_ready,._n_redact {
            font-size: 14px;
            display: inline-block;
            background-color: #ededed;
            color: black;
            font-weight: 600;
            text-align: center;
            padding: 6px;
            border-radius: 3px;
            margin-top: 3px;
        cursor: pointer;
        }
        ._n_blank {
        cursor: pointer;
        }
        ._n_blank:hover {
        font-weight: 900;
        }
         .closerButton:hover,._n_ready:hover,._n_redact:hover {
            box-shadow: 0 0 5px rgba(0,0,0,0.3);
    </style>
</head>
<body>
<table class="workflow_table" cellspacing="0" border="1">
    <tr>
        <td class="timeline">Просрочка</td>
        <td class="timeline" colspan="3"><? echo $dayarray[date("w",strtotime($k[0]))]; echo(" (".dig_to_d($k[0]."0000").".".dig_to_m($k[0]."0000").") - Сегодня");?></td>
        <td class="timeline" colspan="3"><? echo $dayarray[date("w",strtotime($k[1]))]; echo(" (".dig_to_d($k[1]."0000").".".dig_to_m($k[1]."0000").")");?></td>
        <td class="timeline" colspan="3"><? echo $dayarray[date("w",strtotime($k[2]))]; echo(" (".dig_to_d($k[2]."0000").".".dig_to_m($k[2]."0000").")");?></td>
        <td class="timeline" colspan="3"><? echo $dayarray[date("w",strtotime($k[3]))]; echo(" (".dig_to_d($k[3]."0000").".".dig_to_m($k[3]."0000").") ->>");?></td>
    </tr>
    <tr>
        <td class="timeline">Вчера и ранее</td>
        <td class="timeline">10:00 - 12:00</td>
        <td class="timeline">12:00 - 16:00</td>
        <td class="timeline">16:00 - 19:00</td>
        <td class="timeline">10:00 - 12:00</td>
        <td class="timeline">12:00 - 16:00</td>
        <td class="timeline">16:00 - 19:00</td>
        <td class="timeline">10:00 - 12:00</td>
        <td class="timeline">12:00 - 16:00</td>
        <td class="timeline">16:00 - 19:00</td>
        <td class="timeline">10:00 - 12:00</td>


    </tr>
    <tr>
        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($past_data = mysql_fetch_array($past_array)) {?>
                    <? $cur_num = $past_data['order_number']; ?>
                    <? $cur_man = $past_data['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>
        <!--Блок сегодня-->
        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($now_data_p1 = mysql_fetch_array($now_array_p1)) {?>
                     <? $cur_num = $now_data_p1['order_number']; ?>
                    <? $cur_man = $now_data_p1['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>

        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($now_data_p2 = mysql_fetch_array($now_array_p2)) {?>
                    <? $cur_num = $now_data_p2['order_number']; ?>
                    <? $cur_man = $now_data_p2['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>

        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($now_data_p3 = mysql_fetch_array($now_array_p3)) {?>
                    <? $cur_num = $now_data_p3['order_number']; ?>
                    <? $cur_man = $now_data_p3['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>

        <!--Блок завтра-->
        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($tomorrow_data_p1 = mysql_fetch_array($tomorrow_array_p1)) {?>
                    <? $cur_num = $tomorrow_data_p1['order_number']; ?>
                    <? $cur_man = $tomorrow_data_p1['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>

        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($tomorrow_data_p2 = mysql_fetch_array($tomorrow_array_p2)) {?>
                    <? $cur_num = $tomorrow_data_p2['order_number']; ?>
                    <? $cur_man = $tomorrow_data_p2['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>

        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($tomorrow_data_p3 = mysql_fetch_array($tomorrow_array_p3)) {?>
                    <? $cur_num = $tomorrow_data_p3['order_number']; ?>
                    <? $cur_man = $tomorrow_data_p3['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>

        <!--Блок послезавтра-->
        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($aftertomorrow_data_p1 = mysql_fetch_array($aftertomorrow_array_p1)) {?>
                    <? $cur_num = $aftertomorrow_data_p1['order_number']; ?>
                    <? $cur_man = $aftertomorrow_data_p1['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>

        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($aftertomorrow_data_p2 = mysql_fetch_array($aftertomorrow_array_p2)) {?>
                     <? $cur_num = $aftertomorrow_data_p2['order_number']; ?>
                    <? $cur_man = $aftertomorrow_data_p2['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>

        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($aftertomorrow_data_p3 = mysql_fetch_array($aftertomorrow_array_p3)) {?>
                    <? $cur_num = $aftertomorrow_data_p3['order_number']; ?>
                    <? $cur_man = $aftertomorrow_data_p3['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>

        <!--дальние заказы-->
        <td class="graphic">
            <div class="graphicsContainer">
                <? while ($late_data = mysql_fetch_array($late_array)) {?>
                    <? $cur_num = $late_data['order_number']; ?>
                    <? $cur_man = $late_data['order_manager']; ?>
                    <? elemMaker($cur_man,$cur_num);?>
                <? } ?>
            </div>
        </td>




    </tr>

</table>

<script>


    function clicker(e) {
        e.parentNode.classList.toggle("large");
    }
    function closeElem(e) {
        e.parentNode.classList.remove("large");
    }
</script>
</body>
</html>