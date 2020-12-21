<?php
$connect = mysqli_connect('h010445205.mysql','h010445205_mysql','6mD:PFjS','h010445205_db');
mysqli_query($connect,'SET NAMES utf8');
/*INSERT INTO `shop1_items`  VALUES ;*/
$sql_query_firestpart = "INSERT INTO `shop1_items` ( 
                                                    `item_name`, 
                                                    `item_article`, 
                                                    `item_group`, 
                                                    `item_input_price`, 
                                                    `item_out_price`
                                                    ";
/*$sql_query_secondpart = ",`S`";*/
$item_name = $_POST['item_name'];
$group_id = $_POST['group_id'];
$item_article = $_POST['item_article'];
$item_input_price = $_POST['item_input_price'];
$sql_query_thirdpart = ") VALUES ('".$item_name."','".$item_article."','".$group_id."','".$item_input_price."',"; //название, группа товаров, входная цена

$grpups_query = mysqli_query($connect,"SELECT * FROM `item_group` WHERE `id` = $group_id LIMIT 1");
$grpups_data = mysqli_fetch_array($grpups_query);
$multiplier = (100 + $grpups_data['group_priceup']) / 100;
/*echo $multiplier;*/
$outprice = $item_input_price*$multiplier;
$sql_query_fourthpart = $outprice.","; //вот это ццена выхода
/*$sql_query_fivespart = ",3)"; //вот это флаг размера*/
$sql_query_sixpart = ")";
/*echo '<br>';*/






if (!empty($_POST['c-xs'])) {
    $sql_query_secondpart = ",`item_size`";
    $sql_query_fivespart = "'xs'";
    $sql = $sql_query_firestpart.$sql_query_secondpart.$sql_query_thirdpart.$sql_query_fourthpart.$sql_query_fivespart.$sql_query_sixpart;
    mysqli_query($connect,$sql);
/*    echo $sql;*/
}
if (!empty($_POST['c-s'])) {
    $sql_query_secondpart = ",`item_size`";
    $sql_query_fivespart = "'s'";
    $sql = $sql_query_firestpart.$sql_query_secondpart.$sql_query_thirdpart.$sql_query_fourthpart.$sql_query_fivespart.$sql_query_sixpart;
    mysqli_query($connect,$sql);
}
if (!empty($_POST['c-m'])) {
    $sql_query_secondpart = ",`item_size`";
    $sql_query_fivespart = "'m'";
    $sql = $sql_query_firestpart.$sql_query_secondpart.$sql_query_thirdpart.$sql_query_fourthpart.$sql_query_fivespart.$sql_query_sixpart;
    mysqli_query($connect,$sql);
}
if (!empty($_POST['c-l'])) {
    $sql_query_secondpart = ",`item_size`";
    $sql_query_fivespart = "'l'";
    $sql = $sql_query_firestpart.$sql_query_secondpart.$sql_query_thirdpart.$sql_query_fourthpart.$sql_query_fivespart.$sql_query_sixpart;
    mysqli_query($connect,$sql);
}
if (!empty($_POST['c-xl'])) {
    $sql_query_secondpart = ",`item_size`";
    $sql_query_fivespart = "'xl'";
    $sql = $sql_query_firestpart.$sql_query_secondpart.$sql_query_thirdpart.$sql_query_fourthpart.$sql_query_fivespart.$sql_query_sixpart;
    mysqli_query($connect,$sql);
}
if (!empty($_POST['c-xxl'])) {
    $sql_query_secondpart = ",`item_size`";
    $sql_query_fivespart = "'xxl'";
    $sql = $sql_query_firestpart.$sql_query_secondpart.$sql_query_thirdpart.$sql_query_fourthpart.$sql_query_fivespart.$sql_query_sixpart;
    mysqli_query($connect,$sql);
}
if (!empty($_POST['c-over'])) {
    $sql_query_secondpart = ",`item_size`";
    $sql_query_fivespart = "'over'";
    $sql = $sql_query_firestpart.$sql_query_secondpart.$sql_query_thirdpart.$sql_query_fourthpart.$sql_query_fivespart.$sql_query_sixpart;
    mysqli_query($connect,$sql);
}


/*$sql = $sql_query_firestpart.$sql_query_secondpart.$sql_query_thirdpart.$sql_query_fourthpart.$sql_query_fivespart.$sql_query_sixpart;
echo $sql;
mysqli_query($connect,$sql);*/

header("Location: http://sivitskiy.pro/shop?last=".$item_article); /* Перенаправление браузера */

/* Убедиться, что код ниже не выполнится после перенаправления .*/
exit;

?>