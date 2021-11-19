<? require_once  'dbconnect.php'; ?>
<? session_start(); ?>
<? require_once  './inc/global_functions.php'; ?>
<? require_once  './_oborot_functions.php'; ?>
<? require_once  './inc/cfg.php'; ?>
<? require_once  './inc/config_reader.php'; ?>
<? $action = $_GET['action']; ?>
<? $current_manager = $_SESSION['manager']; ?>
<?
$mess_sql = "SELECT * FROM `action_history` WHERE `history_order_manager` = '$current_manager' ORDER BY action_history.id DESC LIMIT 75";
$mess_array = mysql_query($mess_sql);
while ($mess_data = mysql_fetch_array($mess_array)) {
    $dt = $mess_data['history_date'];
    $date_in_text = dig_to_h($dt).':'.dig_to_minute($dt).' ('.dig_to_d($dt).'/'.dig_to_m($dt).')';
?>
    <div class="history_element" data-id="<? echo $mess_data['id']?>" style="">
        <div class="history_element__order"><? echo $mess_data['history_order_manager'].'-'.$mess_data['history_order_number']; ?></div>
        <div class="history_element__date"><? echo $date_in_text; ?> </div>
        <div class="history_element__message"><? echo $mess_data['history_text']?></div>
    </div>
<?php } ?>