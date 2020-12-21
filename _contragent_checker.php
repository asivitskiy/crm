<?
echo $contragent_id;
if ($contragent_id == "new") {
	$contragent_sql = "INSERT INTO `contragents` 
		(name,
		address,
		fullinfo,
		contacts) 
		
		VALUES 
		('$contragent_name',
		'$contragent_address',
		'$contragent_fullinfo',
		'$contragent_contacts',)";
} else {
	$contragent_sql = "INSERT INTO `contragents` 
		(id,
		name,
		address,
		fullinfo,
		contacts) 
		
		VALUES 
		('$contragent_id',
		'$contragent_name',
		'$contragent_address',
		'$contragent_fullinfo',
		'$contragent_contacts',)";
}
mysql_query($contragent_sql);
?>