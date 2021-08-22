<?
    include_once 'dbconnect.php';        
    include_once './inc/global_functions.php'; 
    include_once './inc/config_reader.php';

if ($_GET['setonline'] == 1) {
$printer_sql = "SELECT * FROM `printer_status`";
$printer_array = mysql_query($printer_sql);
while ($printer_data = mysql_fetch_array($printer_array)) {
unset($output);    
$count_of_pings = 15;
$ip =   $printer_data['printer_ip'];
exec("chcp 437 && ping $ip -n $count_of_pings -w 100", $output, $status);
$string = $output[$count_of_pings+5];
$start = strripos($string,'Received = ')+11;
$end = strripos($string,', Lost = ');
$coutnt_of_success = substr($string,$start,$end-$start)*1;
if (($count_of_pings - $coutnt_of_success) <= 1) 
        {
            $current_printer = $printer_data['id'];
            mysql_query("UPDATE `printer_status` SET `printer_status` = 'online' WHERE (`id` = '$current_printer')");
                if ($printer_data['printer_status'] == 'offline') 
                { 
                    mysql_query("UPDATE `printer_status` SET `printer_set_online` = '1' WHERE (`id` = '$current_printer')");
                }
            echo $printer_data['printer_name'].' online   ||||   ';
            
        } 
    else 
        {
            $current_printer = $printer_data['id'];
            mysql_query("UPDATE `printer_status` SET `printer_status` = 'offline' WHERE (`id` = '$current_printer')");
            echo $printer_data['printer_name'].' offline   ||||   ';
        }

exec("exit");
}
echo '<br>';
}

if ($_GET['setoffline'] == 1) {
    $printer_sql = "SELECT * FROM `printer_status`";
    $printer_array = mysql_query($printer_sql);
    while ($printer_data = mysql_fetch_array($printer_array)) {
    unset($output);    
    $count_of_pings = 3;
    $ip =   $printer_data['printer_ip'];
    exec("chcp 437 && ping $ip -n $count_of_pings -w 100", $output, $status);
    $string = $output[$count_of_pings+5];
    $start = strripos($string,'Received = ')+11;
    $end = strripos($string,', Lost = ');
    $coutnt_of_success = substr($string,$start,$end-$start)*1;
    if (($count_of_pings - $coutnt_of_success) >=1) 
            {
                $current_printer = $printer_data['id'];
                mysql_query("UPDATE `printer_status` SET `printer_status` = 'offline' WHERE (`id` = '$current_printer')");
                echo $printer_data['printer_name'].' offline   ||||   ';
            } 
    
    exec("exit");
    }
    echo '<br>';
    }










echo "printerstatus ... ok || time - ".dig_to_d(date('YmdHi'))."/".dig_to_m(date('YmdHi'))." (".dig_to_h(date('YmdHi')).":".dig_to_minute(date('YmdHi')).")";
?>
