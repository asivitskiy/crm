<?
include_once 'dbconnect.php';
include_once './inc/global_functions.php';
include_once './inc/config_reader.php';

$qr_id = $_GET['qr_id'];
$qr_action=$_GET['action'];

    if ($qr_action == 'check') {
        $current_date = date('YmdHi');
        mysql_query("UPDATE `admix`.`qr_pay` SET `qr_checked` = '$current_date' WHERE `qr_pay`.`qr_pay_id` ='$qr_id'");
    }

    if ($qr_action == 'uncheck') {
        //$current_date = date('YmdHi');
        mysql_query("UPDATE `admix`.`qr_pay` SET `qr_checked` = 0 WHERE `qr_pay`.`qr_pay_id` ='$qr_id'");
    }

    if ($qr_action == 'delete') {
        //$current_date = date('YmdHi');
        mysql_query("DELETE FROM `admix`.`qr_pay` WHERE `qr_pay`.`qr_pay_id` ='$qr_id'");
    }


header('Location: http://'.$_SERVER['SERVER_NAME'].'/?action=qr_checker');
?>