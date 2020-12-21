<?
include 'inc/dbconnect.php';
$a = str_replace('-','',$_POST['date_in']).'0000';
$date_in = $a*1;
$demant_contragent = $_POST['contragent'];
$demand_name = $_POST['demand_name'];
$demand_summ = $_POST['summ'];

$sql_demand = "INSERT INTO `rashod_items` ( `rashod_items_contragent_id` ,
                                            `rashod_items_date_in` ,
                                            `rashod_items_summ` ,
                                            `rashod_items_demand_name`)
                                VALUES ('$demant_contragent', 
                                        '$date_in', 
                                        '$demand_summ',
                                        '$demand_name')";
mysql_query($sql_demand);
/*
echo $demant_contragent.'-';
echo $date_in.'-';
echo $demand_summ.'-';
echo $demand_name.'-';*/
header('Location: http://192.168.1.221/?action=rashodka');
?>