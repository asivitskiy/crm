<?

set_include_path(get_include_path() . PATH_SEPARATOR . "./dompdf/");

require_once "dompdf_config.inc.php";
require '../dbconnect.php';
require '../inc/config_reader.php';

$dompdf = new DOMPDF();
$order_number = $_GET['order_number'].'';
$page = "http://".$_SERVER['HTTP_HOST']."/_pdf_engine_check/"."printform_new.php?manager=Ю&number=".$order_number;
$content = file_get_contents($page);
$dompdf->load_html($content);
$customPaper = array(0,0,220,2500);
$dompdf->set_paper($customPaper);
$dompdf->render();

$output = $dompdf->output();

file_put_contents("./_toprint/".$order_number.'-'.date("YmdHi").'-'.rand(111, 999).'.pdf', $output);
file_put_contents($cfg['pdf_arch_path'].$order_number.'-'.date("YmdHi").'-'.rand(111, 999).'.pdf', $output);

?>
<script>window.close(); </script>
