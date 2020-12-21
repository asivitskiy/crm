<? include 'dbconnect.php'; ?>
<?
$cur_date_y = date("Y");
$cur_date_m = date("m");
$cur_date_d = date("d");
$cur_date_hour = date("H");
$cur_date_minute = date("i");
$cur_type = 0;
if (($_POST['bnal']) > ($_POST['nal'])) { $cur_price = $_POST['bnal']; $cur_type = 'bnal'; }
if (($_POST['bnal']) < ($_POST['nal'])) { $cur_price = $_POST['nal']; $cur_type = 'nal'; }

$cur_price = str_replace(',','.',$cur_price);
//echo($cur_price);
$sql = "INSERT INTO `ccenter` (sum,date_y,date_m,date_d,date_hour,date_minute,type) VALUES ($cur_price,$cur_date_y,$cur_date_m,$cur_date_d,$cur_date_hour,$cur_date_minute,'$cur_type')";
mysql_query($sql);

header("Location: ".$_SERVER["HTTP_REFERER"]);


?>