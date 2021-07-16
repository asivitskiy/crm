<?
$config_sql = "SELECT * FROM `admix_config`";
while ($config_data = mysql_fetch_array($config_sql)) {
    $cfg_mail = $config_data['mailer'];
    $cfg_whatsapp = $config_data['whatsapp'];
    $cfg_adminmail = $config_data['admin_mail'];
    $cfg_ownermail = $config_data['owner_mail'];
    
}
?>