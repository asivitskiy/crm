<?php
include "./dbconnect.php";
$sql = "SELECT * FROM `order`
        LEFT JOIN `works` ON works.work_order_number = order.order_number
        LEFT JOIN `work_types` ON works.work_tech = work_types.name
        WHERE order.deleted <> 1
        ";
$array = mysql_query($sql);
while ($data = mysql_fetch_array($array)) {
    echo $data['order_number']."<br>";
        if (($data['group'] == "books") or ($data['alias'] == "XEROX")) {
            $curorder = $data['order_number'];
            echo $data['order_number']." имеет XEROX либо тетрадки"."<br>";
            mysql_query ("UPDATE `order` SET order.order_has_digital = '1' WHERE order.order_number = '$curorder'");

        }
        else {
            echo "нет цифры <br>";
        }
}

?>