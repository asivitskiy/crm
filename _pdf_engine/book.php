<?php
set_include_path(get_include_path() . PATH_SEPARATOR . "./dompdf/");

require_once "dompdf_config.inc.php";

$dompdf = new DOMPDF();

/*$html = <<<'ENDHTML'
.file_get_contents("http://www.example.com/").
ENDHTML;*/
$content = file_get_contents("http://192.168.2.239/printform_pdf.php?manager=Ю&number=5041");
$dompdf->load_html($content);

$dompdf->render();

$dompdf->stream("hello.pdf");
?>