<?
/* $ip = file_get_contents('https://api.ipify.org'); */
$ip = file_get_contents('http://ip-api.com/php/?fields=query');
$pos = strripos($ip,':"');
$string = substr($ip,$pos+2);
$pos2 = strripos($string,'";}');
$string2 = substr($string,0,$pos2);
echo $string.'<br>';
echo $string2.'<br>';
?>