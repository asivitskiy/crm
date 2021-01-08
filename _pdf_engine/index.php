<?php
set_include_path(get_include_path() . PATH_SEPARATOR . "./dompdf/");

require_once "dompdf_config.inc.php";

$dompdf = new DOMPDF();

/*$html = <<<'ENDHTML'
.file_get_contents("http://www.example.com/").
ENDHTML;*/
$page = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."printform_pdf.php?manager=Ю&number=5041";
/*echo $page;*/
$content = file_get_contents($page);
$dompdf->load_html($content);

$dompdf->render();

/*$dompdf->stream("hello.pdf");*/
$output = $dompdf->output();
file_put_contents('Brochure5.pdf', $output);

?>
<script>window.close()</script>
