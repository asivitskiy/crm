<?php
sleep(5);
/*echo "qrGenerator started";*/
include_once 'dbconnect.php';
include_once './inc/global_functions.php';
include_once './inc/config_reader.php';
$qr_sql = "SELECT `order_number` FROM `order` WHERE `qr_status` = 1";
$qr_array = mysql_query($qr_sql);
while ($qr_data = mysql_fetch_array($qr_array)) {
    $current_order_number = $qr_data['order_number'];
    mysql_query("UPDATE `order` SET `qr_status` = 2 WHERE `order_number` = '$current_order_number'");
    /*header('content-type: image/png');*/
    $url = 'https://chart.apis.google.com/chart';
    $chd = 't:';
    for ($i = 0; $i < 150; ++$i) {
        $data = rand(0, 100000);
        $chd .= $data . ',';
    }
    $chd = substr($chd, 0, -1);
    // Add data, chart type, chart size, and scale to params.
    $chart = array(
        'cht' => 'qr',
        'chl' => 'http://192.168.1.221/_postprint_checker.php?action=showdetails&order_number='.$current_order_number,
        'chs' => '200x200',
        'chd' => $chd);

    // Send the request, and print out the returned bytes.
    $context = stream_context_create(
        array('http' => array(
            'method' => 'POST',
            'content' => http_build_query($chart))));
    //fpassthru(fopen($url, 'r', false, $context));
    $aaa = file_get_contents($url, 'r', $context);
    file_put_contents("./_qr/" . $current_order_number . ".png", $aaa);
    sleep(1);
    mysql_query("UPDATE `order` SET `qr_status` = 3 WHERE `order_number` = '$current_order_number'");
    unset($aaa,$chart,$context,$chd);
}

/*echo "qrGenerator end of script";*/

echo "qr:complete";
?>