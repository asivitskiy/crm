<? include "./inc/dbconnect.php";

if (isset($_GET['readyorder'])) {
    
    //проставление готовности заказа
            $order_number = $_GET['readyorder'];
            $order_pre_check_sql = "  SELECT * FROM `order` 
            LEFT JOIN `contragents` ON contragents.id = order.contragent
            WHERE `order_number` = '$order_number'
            LIMIT 1";
            $order_pre_check_array = mysql_query($order_pre_check_sql);
            $order_pre_check_data = mysql_fetch_array($order_pre_check_array);

        $notofocation_of_end = '';
        if ((strlen($order_pre_check_data['date_of_end'])) == 12) {$curenttimerd = '';$notofocation_of_end='';} else {$curenttimerd = date("YmdHi");$notofocation_of_end='1';}
        
        $readyquery = "UPDATE `order` SET `date_of_end` = '$curenttimerd' WHERE (`order_number` = '$order_number')";
        mysql_query($readyquery);

        if ($order_pre_check_data['notification_number'] == '') {$notofocation_of_end = '';}
        $readyquery = "UPDATE `order` SET `notification_of_end_status` = '$notofocation_of_end' WHERE (`order_number` = '$order_number')";
        mysql_query($readyquery);

    


    header('Location: http://'.$_SERVER['SERVER_NAME'].'/_order_closer.php?success='.$_GET['readyorder']);
}
if (isset($_GET['success'])) {
    $numb = $_GET['success'];
    echo "Всё ок =), переход обратно";
    $order_sql = "  SELECT * FROM `order` 
                            LEFT JOIN `contragents` ON contragents.id = order.contragent
                            WHERE `order_number` = '$numb'
                            LIMIT 1";
            $order_array = mysql_query($order_sql);
            $order_data = mysql_fetch_array($order_array);

            if ($order_data['notification_number'] <> "") {
                ?>
                <img src="./img/wa.png" width="400" height="400">
                <?
            } else {
                ?>
                <img src="./img/nowa.png" width="400" height="400">
                <?
            }
    ?>
        <script>
            
            setTimeout('location.replace("_order_closer.php")', 2000);
        </script>
    <?
}
?>
<html>
    <head>
        <style>
            * {
                font-family: "Arial Black";
                font-size: 25px;
            }
            .mainform input{
                height: 120px;
                width: 300px;
                font-size: 80px;
            }
            .closeButton {
                width: 300px;
                height: 200px;
                font-size: 40px;
                border-radius: 20px;
            }
            .closeButton:active{
                padding: calc(.25em + 5px) .5em calc(.25em - 5px);
                background-color: rgba(154,154,154,0.59)!important;
                outline: 2px solid black;

            }
            .leftCol {
                padding-top:20px;
                vertical-align: top;
                display: inline-block;
                width: 520px;
                font-size: 24px;
            }
            .rightCol {
                display: inline-block;
                width: 320px;
            }
        </style>
    </head>
<?
if (isset($_GET['order_number'])) {
    $order_number = $_GET['order_number'];
    echo "<h1>Заказ ".$_GET['order_number']."</h1>";
    ?>
    <div>
        <div class="leftCol">
        <?
            $order_sql = "  SELECT * FROM `order` 
                            LEFT JOIN `contragents` ON contragents.id = order.contragent
                            WHERE `order_number` = '$order_number'
                            LIMIT 1";
            $order_array = mysql_query($order_sql);
            $order_data = mysql_fetch_array($order_array);
            echo $order_data['name']."<BR>";
            echo  "<br>";
            echo $order_data['order_description']."<BR>";
            echo  "<br>";
            $works_sql = "  SELECT * FROM `works` 
                            WHERE `work_order_number` = '$order_number'";
            $works_array = mysql_query($works_sql);
            while ($works_data = mysql_fetch_array($works_array)) {
                echo $works_data['work_name']." - ";
                //echo $works_data['work_description']." - ";
                echo $works_data['work_price']."р. - ";
                echo $works_data['work_count']."шт - ";
                echo $works_data['work_price'] * $works_data['work_count']."руб.";
                echo  "<br>";
            }
        ?>
        </div>
        <div class="rightCol">
            <?
            if ((strlen($order_data['date_of_end']) <> 12) and (strlen($order_data['handing']) <> 12)) {
            ?>

            <form action="" method="get">
                <input type="hidden" name="readyorder" value="<? echo $order_number; ?>">
                <button class="closeButton">ГОТОВ</button><br>

            </form>
            <? } ?>


            <?
            if ((strlen($order_data['date_of_end']) == 12) and (strlen($order_data['handing']) <> 12)) {
                ?>

                <form action="_button_processor.php" method="get">
                    <input type="hidden" name="setHanding">
                    <input type="hidden" name="needback" value="_order_closer.php">
                    <input type="hidden" name="order_number" value="<? echo $order_number; ?>">
                    <button class="closeButton">ВЫДАТЬ >></button><br>

                </form>
            <?
            }
            ?>
            <form action="_order_closer.php">
                <button class="closeButton" style="background-color: rgba(154,83,87,0.59)">ОТМЕНА</button>

            </form>
    </div>
    </div>
        
    <?
} else if (!isset($_GET['success'])){


?>

<form action="" method="get" class="mainform">
    <input type="text" name="order_number" autofocus>
</form>
<? } ?>

</html>