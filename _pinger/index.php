<?
$count_of_pings = 15;
$ip =   "192.168.1.142";
exec("chcp 437 && ping $ip -n $count_of_pings -w 100", $output, $status);
    //cho '<pre>';
    //ar_dump($output);
    //cho '</pre>';
$string = $output[$count_of_pings+5];
//echo $string."<br>";
//echo strripos($string,'Received = ');
//echo stripos($string,'Lost');

$start = strripos($string,'Received = ')+11;
$end = strripos($string,', Lost = ');
echo "Отправлено: ".$count_of_pings.", получено :".substr($string,$start,$end-$start);
//echo str_replace(', Lost','',substr($string,stripos($string,'Received = ')+10,10));
?>