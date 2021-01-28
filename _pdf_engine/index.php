<?

set_include_path(get_include_path() . PATH_SEPARATOR . "./dompdf/");

require_once "dompdf_config.inc.php";

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

file_put_contents('./_toprint/'.$order_number.'-'.date("YmdHi").'-'.rand(111, 999).'.pdf', $output);
file_put_contents('//192.168.1.112/server_1/_reserved/_pdf-storage/'.$order_number.'-'.date("YmdHi").'-'.rand(111, 999).'.pdf', $output);

?>
<script>window.close()</script>
