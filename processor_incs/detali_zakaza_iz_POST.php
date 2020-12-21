<?
$zakazchik			=$_POST['zakazchik'];
$current_manager	=$_POST['current_manager'];
$name   			=$_POST['nomer_blanka'];
$timetoend		=$_POST['timetoend'];
$datetoend		=$_POST['datetoend'];
$base_description = $_POST['base_description'];
$preprint = $_POST['preprint'];
$handing = $_POST['handing'];
$paymethod = $_POST['paymethod'];
$paystatus = $_POST['paystatus'];
$vneseno = $_POST['vneseno'];
$date_of_end = $_POST['date_of_end'];
$vremya_sdachi = $_POST['datetoend'].$_POST['timetoend'];
$date_in = date("YmdHi");
$vremya_sdachi = str_replace("-", '', $vremya_sdachi);
$vremya_sdachi = str_replace(":", '', $vremya_sdachi);
?>