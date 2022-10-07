<?
include "./inc/dbconnect.php";


$sql = "SELECT `id`,`contacts`,`fullinfo` FROM `contragents`";
$array = mysql_query($sql);
while ($aa = mysql_fetch_array($array)) {
    $idd = $aa['id'];
    echo $idd."<br>";

    $bbb = str_replace("\\r\\n",PHP_EOL,$aa['fullinfo']);
    $ccc = str_replace("\\r\\n",PHP_EOL,$aa['contacts']);

    mysql_query("UPDATE `admix`.`contragents` SET `fullinfo` = '$bbb' WHERE `contragents`.`id` ='$idd'");
    mysql_query("UPDATE `admix`.`contragents` SET `contacts` = '$ccc' WHERE `contragents`.`id` ='$idd'");
}

//$bbb = str_replace("\\r\\n",PHP_EOL,$aa['fullinfo']);

//mysql_query("UPDATE `admix`.`contragents` SET `fullinfo` = '$bbb' WHERE `contragents`.`id` =60");
?>
