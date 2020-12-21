<? $connection = mysql_connect('127.0.0.1','root',''); ?>
<? mysql_select_db('admix', $connection) ?><!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="mainmenu ">asd</div>
<div class="first-column columns-common-options">
    <?
    $rez_sql = mysql_query("
SELECT * FROM `order` 
LEFT JOIN `contragents` ON contragents.id = order.contragent
LEFT JOIN `works` ON works.work_order_number = order.order_number
WHERE `deleted`<>'1'
ORDER BY order.date_in DESC");
    while ($rez = mysql_fetch_array($rez_sql)) {
    ?>


    <div class="content-row-wrapper">
        <div class="content-row-blocks word"><? echo $rez['order_manager']; ?></div>
        <div class="content-row-blocks" style="padding: 1px;">-</div>
        <div class="content-row-blocks number"><? echo $rez['order_number']; ?></div>
        <div class="content-row-blocks contragent"><? echo $rez['name']; ?></div>
        <div class="content-row-blocks description"><? echo $rez['order_description']; ?></div>
        <!--светофор-->
        <div class="content-row-blocks trafficlights trafficlights-green">раб</div>
        <div class="content-row-blocks trafficlights trafficlights-yellow">диз</div>
        <div class="content-row-blocks trafficlights trafficlights-green" style="text-transform: none; width: 37px">Алиса</div>
        <div class="content-row-blocks trafficlights trafficlights-reed">гот</div>
        <div class="content-row-blocks trafficlights trafficlights-reed">выст</div>
        <div class="content-row-blocks trafficlights trafficlights-reed">дост</div>
        <div class="content-row-blocks trafficlights trafficlights-reed">док</div>
        <!--конец светофора-->
        <div class="content-row-blocks money"><? echo $rez['work_price']*$rez['work_count']; ?></div>



    </div>

<? } ?>

</div>
<div class="second-column columns-common-options">

</div>
<!--<div class="third-column ">adasad</div>-->
</body>
</html>