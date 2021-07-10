<? require_once  'dbconnect.php'; ?>
<? session_start(); ?>
<?  // 't' - указывает взять последний день
    /*$last_day_this_month  = date('t',strtotime('2020-02-17'));
    echo $first_day_this_month;print'<->';echo $last_day_this_month;*/
?>
<? require_once  './inc/global_functions.php'; ?>
<? require_once  './_oborot_functions.php'; ?>
<? require_once  './inc/cfg.php'; ?>
<? $action = $_GET['action']; ?>
<? $current_manager = $_SESSION['manager']; ?>
<? if (strlen($current_manager) > 0 ) {  ?>
<?
//`outcontragent_demand`
$outcontragent_req_id = $_POST['outcontragent_req_id'];
$outcontragent_id = $_POST['outcontragent_id'];
$paylist_demand_number = $_POST['paylist_demand_number'];
$paylist_demand_summ = $_POST['paylist_demand_summ'];
$paylist_demand_date = $_POST['paylist_demand_date'];
$paylist_demand_date = str_replace("-", "", $paylist_demand_date)."0000";
//echo $outcontragent_req_id;
//echo "<br>";
//echo $outcontragent_id;
$sql = "
INSERT INTO `outcontragent_demand` (

    `demand_outcontragent_id` ,
    `demand_req_id` ,
    `demand_date_in` ,
    `demand_summ` ,
    `demand_manager` ,
    `demand_number`
    )
    VALUES (
        '$outcontragent_id', 
        '$outcontragent_req_id', 
        '$paylist_demand_date', 
        '$paylist_demand_summ',
        '$current_manager', 
        '$paylist_demand_number'
    )";
mysql_query($sql);

    }

//переадресация обратно
header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php?action=paydemands');

?>