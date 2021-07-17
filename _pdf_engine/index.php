<?

set_include_path(get_include_path() . PATH_SEPARATOR . "./dompdf/");

require_once "dompdf_config.inc.php";
require '../dbconnect.php';
require '../inc/config_reader.php';
print_r($cfg);
$dompdf = new DOMPDF();

/*$html = <<<'ENDHTML'
.file_get_contents("http://www.example.com/").
ENDHTML;*/
$order_number = $_GET['order_number'].'';

$page = "http://".$_SERVER['HTTP_HOST']."/_pdf_engine/"."printform_new.php?manager=Ю&number=".$order_number;
/*echo $page;*/
/*echo $page;*/
$content = file_get_contents($page);
$dompdf->load_html($content);

$dompdf->render();


$output = $dompdf->output();
/*$dompdf->stream($order_number.'-'.date("YmdHi").'.pdf',array("Attachment" => false));*/

file_put_contents($cfg['pdf_print_path'].$order_number.'-'.date("YmdHi").'-'.rand(111, 999).'.pdf', $output);
file_put_contents($cfg['pdf_arch_path'].$order_number.'-'.date("YmdHi").'-'.rand(111, 999).'.pdf', $output);

?>
<script>window.close()</script>
