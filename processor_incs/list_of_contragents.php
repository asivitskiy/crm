<?
$contragent_shortcut = str_replace("\r", "",  $contragent_name);

$query_1 = "SELECT `contragent_shortcut` FROM `contragents` WHERE `contragent_shortcut` = '$contragent_shortcut'";
$res_1 = mysql_query($query_1);
$row_1 = mysql_fetch_array($res_1);
$iii = count($row_1['contragent_shortcut']);
if ($iii<1){
$contragent_shortcut = str_replace("\n", " \n", $contragent_shortcut);
$contragent_shortcut = str_replace("\"","",$contragent_shortcut);
$sq3 = "INSERT INTO `contragents` (contragent_shortcut) VALUES ('$contragent_shortcut')";
mysql_query($sq3);
}

$sql_zakazchik_query = "SELECT `id` FROM `contragents` WHERE `contragent_shortcut` = '$contragent_shortcut'";
$sql_zakazchik_result = mysql_query($sql_zakazchik_query);
$sql_zakazchik_array = mysql_fetch_array($sql_zakazchik_result);
$zakazchik = $sql_zakazchik_array['id'];echo mysql_error();
//echo($contragent_shortcut);echo($zakazchik);


?>