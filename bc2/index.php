<?php
require_once('barcode.inc.php'); 
$code_number = '17999';
#new barCodeGenrator($code_number,0,'hello.gif'); 
new barCodeGenrator($code_number,0,'hello.gif', 90, 35, false);
?> 