<? $start = microtime(true); ?>
<? include 'dbconnect.php'; ?>
<? session_start(); ?>

<? include './inc/global_functions.php'; ?>
<? include './inc/cfg.php'; ?>
<? $action = $_GET['action']; ?>
<?
?>
<body style="font-family: dompdf_tahoma, Tahoma">
<?
$contragent_sql = "SELECT * FROM `contragents`";
$contragent_array = mysql_query($contragent_sql);
while($contragent_data = mysql_fetch_array($contragent_array)) {
	$amount = 0;
	$dolg = 0;
	$ssss = $contragent_data['id'];
    $inwork = 0;
    $completed = 0;
    $allworks = 0;
    $allmoney = 0;
	/*echo 'asdasd'.$ssss;*/
	$order_counter_sql = mysql_query("SELECT * FROM `order` WHERE `contragent` = '$ssss'");

	    while ($order_data = mysql_fetch_array($order_counter_sql)) {
	        $cur_order = $order_data['order_number'];/*echo '['.$cur_order.']';*/

            if ($order_data['deleted'] == 0) {
                $works_sql_dolg = "SELECT SUM(works.work_count*works.work_price) as summm FROM `works` WHERE ((`work_order_number` = '$cur_order')) LIMIT 1";
                $works_array_dolg = mysql_query($works_sql_dolg);
                $works_data_dolg = mysql_fetch_array($works_array_dolg);
                $inwork = $inwork*1 + $works_data_dolg['summm']*1;}

            if ($order_data['deleted'] == 1) {
                $works_sql_amount = "SELECT SUM(works.work_count*works.work_price) as summm FROM `works` WHERE ((`work_order_number` = '$cur_order')) LIMIT 1";
                $works_array_amount = mysql_query($works_sql_amount);
                $works_data_amount = mysql_fetch_array($works_array_amount);
                $completed = $completed*1 + $works_data_amount['summm']*1;}

            $allworks_sql_amount = "SELECT SUM(works.work_count*works.work_price) as summm FROM `works` WHERE ((`work_order_number` = '$cur_order')) LIMIT 1";
            $allworks_array_amount = mysql_query($allworks_sql_amount);
            $allworks_data_amount = mysql_fetch_array($allworks_array_amount);
            $allworks = $allworks*1 + $allworks_data_amount['summm']*1;

            $allmoney_sql = "SELECT SUM(summ) as smmm FROM `money` WHERE `parent_contragent` = '$ssss'";
            $allmoney_array = mysql_query($allmoney_sql);
            $allmoney_data = mysql_fetch_array($allmoney_array);
            $allmoney = $allmoney_data['smmm'];


        }
        $amount_dolg = $allworks*1 - $allmoney*1;
	mysql_query("UPDATE `contragents` SET `contragent_completed` = '$completed' WHERE `id` = '$ssss'");
	mysql_query("UPDATE `contragents` SET `contragent_inwork` = '$inwork' WHERE `id` = '$ssss'");
	mysql_query("UPDATE `contragents` SET `contragent_amount` = '$allworks' WHERE `id` = '$ssss'");
	mysql_query("UPDATE `contragents` SET `contragent_dolg` = '$amount_dolg' WHERE `id` = '$ssss'");
    if (($inwork == 0) and (abs($allmoney - $allworks)>0.1)) {echo '<a href=index.php?action=showlist&filter=client&argument='.$ssss.'>(!) </a>';}
    echo $ssss.' - всего работ (';
    echo $allworks.')      всего закрыто (';
    echo $completed.')     всего денег (';
    echo $allmoney.')     всего в работе (';
    echo $inwork.')<br>';

}



/*phpinfo();*/


?>
</body>
