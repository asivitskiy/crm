<?php
include "./dbconnect.php";
include "./inc/global_functions.php";

$current_work_id = $_GET['work_id'];

$cur_date = date('YmdHi');
mysql_query("UPDATE `works`
SET `work_roland_status` = '$cur_date'
WHERE `id` ='$current_work_id'");

//переадресация обратно
header('Location: http://'.$_SERVER['SERVER_NAME'].'/_roland_workplace.php');
?>
