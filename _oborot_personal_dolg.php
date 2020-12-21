<?php
include 'inc/dbconnect.php';
include 'inc/global_functions.php';

function dolg_string($month_number,$manager) {

    $startof = '2020'.str_pad($month_number,2,'0', STR_PAD_LEFT).'000000';
    $endof = '2020'.str_pad($month_number+1,2,'0', STR_PAD_LEFT).'000000';

$sql = "SELECT order.order_number FROM `order` WHERE ((`date_in`>'$startof') and (`date_in`<'$endof') and (`order_manager` = '$manager'))";
$array = mysql_query($sql);
while ($data = mysql_fetch_array($array)) {
    $dyn_order = $data['order_number'];
    $works_sql = mysql_query(" SELECT SUM(works.work_price*works.work_count) as worksum FROM `works` WHERE `work_order_number` = '$dyn_order' ");
    $money_sql =  mysql_query(" SELECT SUM(money.summ) as moneysum FROM `money` WHERE `parent_order_number` = '$dyn_order' ");

    $works_data = mysql_fetch_array($works_sql);
    $money_data = mysql_fetch_array($money_sql);

    $delta = abs($works_data['worksum']*1-$money_data['moneysum']*1);

    if ($delta > 0.01) {
        echo $dyn_order.'- неоплачен - '.$works_data['worksum'].'<br>';
        $searchstring_dolg[] = $dyn_order;
    }

}
    if (count($searchstring_dolg) < 1) {$clear_searchstring_dolg = 'err';} else {
$clear_searchstring_dolg = implode(',',$searchstring_dolg);}

return $clear_searchstring_dolg;
}

echo dolg_string(7,'А');
?>