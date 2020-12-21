<? //include('./dbconnect.php'); ?>
<? //session_start(); ?>
<?// include('./inc/global_functions.php'); ?>
<?
$contragent_id = $_POST['id'];
$contragent_name = $_POST['name'];
$contragent_address = $_POST['address'];
$contragent_fullinfo = $_POST['fullinfo'];	
$contragent_contacts = $_POST['contacts'];

$contragent_update_sql = "UPDATE `contragents` SET `name`='$contragent_name',`address`='$contragent_address',`fullinfo` ='$contragent_fullinfo',`contacts`='$contragent_contacts' WHERE (`id`='$contragent_id')";
mysql_query($contragent_update_sql);

//header('Location: http://192.168.1.221/index.php?action=client_list&red_num='.$contragent_id);

?>