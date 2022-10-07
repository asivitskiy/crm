<? $connection = mysql_connect('127.0.0.1','root',''); ?>
<? mysql_select_db('admix', $connection) ?>
<?php
if (isset($_POST['cur_order']))
    {
        $number = $_POST['cur_order'];
    }
else {
    if ($number == 0) {
        $dat = mysql_fetch_array(mysql_query("SELECT MAX(`order_number`) AS `maxorder` FROM `order`"));
        $number = $dat['maxorder'];
    }
}

$sql = "SELECT * FROM `order` WHERE ((order.order_number <= '$number')) ORDER by order.order_number DESC LIMIT 150";
$array = mysql_query($sql);
while ($data = mysql_fetch_array($array)) {
    echo $data['order_manager'].'-'.$data['order_number'];
    $c_ord = $data['order_number'];
}




$data = mysql_fetch_array($array);
echo 'curorderstart'. $c_ord.'curorderend';



?>
