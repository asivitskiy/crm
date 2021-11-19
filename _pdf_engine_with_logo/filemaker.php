<?

set_include_path(get_include_path() . PATH_SEPARATOR . "./dompdf/");

require_once "dompdf_config.inc.php";
require '../dbconnect.php';
require '../inc/config_reader.php';
include_once '../inc/global_functions.php';
$dompdf = new DOMPDF();

/*$html = <<<'ENDHTML'
.file_get_contents("http://www.example.com/").
ENDHTML;*/
$order_number = $_GET['order_number'].'';

$page = "http://".$_SERVER['HTTP_HOST']."/_pdf_engine_with_logo/"."printform_new.php?manager=Ю&number=".$order_number;
$content = file_get_contents($page);
$dompdf->load_html($content);

$dompdf->render();


$output = $dompdf->output();
$res_filename = $cfg['pdf_for_user'].$order_number.'-'.date("YmdHi").'-'.rand(111, 999).'.pdf';
file_put_contents($res_filename, $output);
send_file($res_filename);
?>
<script>window.close()</script>
