<?php
include "./inc/dbconnect.php";


//
//  Закрывалка заказов
//  Проверяет сумму и проставляет готовность и убирает в архив, если все условия соблюдены (кроме ошибок в заказе)
//
//

if (isset($_GET['setHanding'])) {
    $order_number = $_GET['order_number'];
    $today = date("YmdHi");
    mysql_query("UPDATE `order` SET `handing` = '$today' WHERE `order_number` = '$order_number'");
    //проставление готовности при условии наличия факта выдачи и факта оплаты
    
        $ready_checker_sql = "SELECT * FROM `order` WHERE `order_number` = '$order_number' LIMIT 1";
        $ready_checker_array = mysql_query($ready_checker_sql);
        $ready_checker_data = mysql_fetch_array($ready_checker_array);

        //данные о работах из этого заказа (суммирование)
        $amount_order = 0;
        $query_works_1 = "SELECT * FROM `works` WHERE ((`work_order_number`='$order_number'))";
        $res_works_1 = mysql_query($query_works_1);
		while($row_works_1 = mysql_fetch_array($res_works_1))
							{ $amount_order = $amount_order+(($row_works_1['work_price'])*($row_works_1['work_count'])); }

        //данные об оплате этого заказа (суммирование)
        $order_summ = 0;
        $ready_money_checker_sql = "SELECT * FROM `money` WHERE `parent_order_number` = '$order_number'";
        $ready_money_checker_array = mysql_query($ready_money_checker_sql);
        while ($ready_money_checker_data = mysql_fetch_array($ready_money_checker_array)) {$order_summ = $order_summ + $ready_money_checker_data['summ'];}


    if (((strlen($ready_checker_data['delivery'])==12) or (strlen($ready_checker_data['handing'])==12)) and (abs($amount_order - $order_summ)<0.1)) {
        $current_time = date('YmdHi');
        mysql_query("UPDATE `order` SET `date_of_end`='$current_time' WHERE `order_number` = '$order_number'");
        mysql_query("UPDATE `order` SET `preprint`='$current_time' WHERE `order_number` = '$order_number'");
        mysql_query("UPDATE `order` SET `deleted`='1' WHERE `order_number` = '$order_number'");
    }
}

if (isset($_GET['needback'])) {
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/'.$_GET['needback']);
}

if (isset($_GET['errorToManager'])) {
    $mess_from =        $_GET['author'];
    $mess_to =          $_GET['order_manager'];
    $order_number =     $_GET['order_number'];

    $err_sql = "SELECT * FROM `users` WHERE users.word = '$mess_to' LIMIT 1";
    $err_array = mysql_query($err_sql);
    $err_data = mysql_fetch_array($err_array);
    $phone_of_manager = $err_data['phone_number'];
   
    $message = urlencode($mess_from.": ошибка в бланке ".$order_number);

    $wa_string = "https://wamm.chat/api2/msg_to/f0sZ7BuL/?phone=".$phone_of_manager."&text=".$message;
    //echo $wa_string;
    file_get_contents($wa_string);

}
?>