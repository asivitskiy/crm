<!--Файл - рассыльщик, стоит на автозапуске раз в пять минут -->

<?  //подключение к базе
    include 'dbconnect.php';        
    
    
    //всякие мелкие функции
	include './inc/global_functions.php'; 
    
    
    //чтение пользовательских нстроек в переменную $cfg[''];
    include './inc/config_reader.php';     

    
    // подключение отправки бэкапа на сервер и на почту
    include 'dbdump.php';
    
    
    //рассыльщик вацапа (всё касамо вацапа только тут)
    //wamm.chat
    if ($cfg['whatsapp'] == '1'){ include './_whatsapp.php'; }
    
    //wazzup24
    //if ($cfg['whatsapp'] == '1'){include './_wazzup/index.php'; }
   
    //ip_checker проверяет ip адрес и присылает его на ящик cfg['admin_mail'] и cfg['owner_mail]
    include './_mailer_inc_ip_checker.php';
	

    //письмо о регистрации счетов расхода
    include './_mailer_inc_demand_mailer.php';


    //письмо о запросе счета
    include './_mailer_inc_paylist_mailer.php';

    //проверка статуса разосланных сообщений + поиск неверных вацапинок
    include './_whatsapp_status.php';


//actualizer - статусы меняет заказам (работает по таблице ордеров)


$check_sql = "SELECT `order_number`,`preprint` FROM `order` WHERE `order_status-check` = 0";
$check_array = mysql_query($check_sql);

while ($check_data = mysql_fetch_array($check_array)) {
    $current_order_number = $check_data['order_number'];
    $work_check_array = mysql_query("   SELECT * FROM `works`
                                        LEFT JOIN `outcontragent` ON works.work_tech = outcontragent.outcontragent_fullname 
                                        WHERE `work_order_number` = '$current_order_number'");

    $dis_flag = 0;
    $error_flag = 0;
    $reorder_flag = 0;

    while ($work_check_data = mysql_fetch_array($work_check_array)) {
        if ($work_check_data['outcontragent_group'] == 'outer') {$reorder_flag = 1;}
        if ($work_check_data['outcontragent_group'] == 'design') {$dis_flag = 1;}
        if (($work_check_data['outcontragent_group'] == 'design') and (strlen($check_data['preprint']) == 12)) {$dis_flag = 2;}
        if (($work_check_data['outcontragent_group'] == 'design') and ($check_data['preprint'] == 'Нет')) {$dis_flag = 2;}
        if ($work_check_data['work_tech'] == '') {$error_flag = 1;}
        if (
            ($work_check_data['outcontragent_group'] == 'outer')
            and
            (($work_check_data['work_rashod_list'] == '' ) or ($work_check_data['work_rashod'] == 0))
        )
        {$error_flag = 1;}
        if (
            ( ($work_check_data['work_rashod_list'] == '')and($work_check_data['work_rashod']*1 > 0) )
            or
            ( ($work_check_data['work_rashod_list'] <> '')and($work_check_data['work_rashod']*1 == 0) )
        )
        {$error_flag = 1;}




    }


    mysql_query("UPDATE `order` SET `order_status-check`=1 WHERE `order_number` = '$current_order_number'");
    mysql_query("DELETE FROM `order_vars` WHERE `order_vars-order_id` = '$current_order_number'");
    mysql_query("INSERT INTO `order_vars` (`order_vars-order_id`,`order_vars-design_flag`,`order_vars-reorder_flag`,`order_vars-error`) VALUES ($current_order_number,$dis_flag,$reorder_flag,$error_flag)");




}

?>

<? //sorter - сортировку клиентов делает и сумму долгов / заказов обновляет (то есть работает по таблице контрагентов)
$contragent_sql = "SELECT * FROM `contragents`";
$contragent_array = mysql_query($contragent_sql);
while($contragent_data = mysql_fetch_array($contragent_array)) {
    $amount = 0;
    $dolg = 0;
    $ssss = $contragent_data['id'];
    $inwork = 0;
    $completed = 0;
    $allworks = 0;
    $allmoney = 0;
    /*echo 'asdasd'.$ssss;*/
    $order_counter_sql = mysql_query("SELECT * FROM `order` WHERE `contragent` = '$ssss'");

    while ($order_data = mysql_fetch_array($order_counter_sql)) {
        $cur_order = $order_data['order_number'];/*echo '['.$cur_order.']';*/

        if ($order_data['deleted'] == 0) {
            $works_sql_dolg = "SELECT SUM(works.work_count*works.work_price) as summm FROM `works` WHERE ((`work_order_number` = '$cur_order')) LIMIT 1";
            $works_array_dolg = mysql_query($works_sql_dolg);
            $works_data_dolg = mysql_fetch_array($works_array_dolg);
            $inwork = $inwork*1 + $works_data_dolg['summm']*1;}

        if ($order_data['deleted'] == 1) {
            $works_sql_amount = "SELECT SUM(works.work_count*works.work_price) as summm FROM `works` WHERE ((`work_order_number` = '$cur_order')) LIMIT 1";
            $works_array_amount = mysql_query($works_sql_amount);
            $works_data_amount = mysql_fetch_array($works_array_amount);
            $completed = $completed*1 + $works_data_amount['summm']*1;}

        $allworks_sql_amount = "SELECT SUM(works.work_count*works.work_price) as summm FROM `works` WHERE ((`work_order_number` = '$cur_order')) LIMIT 1";
        $allworks_array_amount = mysql_query($allworks_sql_amount);
        $allworks_data_amount = mysql_fetch_array($allworks_array_amount);
        $allworks = $allworks*1 + $allworks_data_amount['summm']*1;

        $allmoney_sql = "SELECT SUM(summ) as smmm FROM `money` WHERE `parent_contragent` = '$ssss'";
        $allmoney_array = mysql_query($allmoney_sql);
        $allmoney_data = mysql_fetch_array($allmoney_array);
        $allmoney = $allmoney_data['smmm'];


    }
    $amount_dolg = $allworks*1 - $allmoney*1;
    mysql_query("UPDATE `contragents` SET `contragent_completed` = '$completed' WHERE `id` = '$ssss'");
    mysql_query("UPDATE `contragents` SET `contragent_inwork` = '$inwork' WHERE `id` = '$ssss'");
    mysql_query("UPDATE `contragents` SET `contragent_amount` = '$allworks' WHERE `id` = '$ssss'");
    mysql_query("UPDATE `contragents` SET `contragent_dolg` = '$amount_dolg' WHERE `id` = '$ssss'");
    if (($inwork == 0) and (abs($allmoney - $allworks)>0.1)) {echo '<a href=index.php?action=showlist&filter=client&argument='.$ssss.'>(!) </a>';}
    echo $ssss.' - всего работ (';
    echo $allworks.')      всего закрыто (';
    echo $completed.')     всего денег (';
    echo $allmoney.')     всего в работе (';
    echo $inwork.')<br>';

}



/*phpinfo();*/
$sql = "SELECT * FROM `order`
        LEFT JOIN `works` ON works.work_order_number = order.order_number
        LEFT JOIN `outcontragent` ON works.work_tech = outcontragent.outcontragent_fullname
        WHERE order.deleted <> 1
        ";
$array = mysql_query($sql);
while ($data = mysql_fetch_array($array)) {
    echo $data['order_number']."<br>";
    if (($data['outcontragent_group'] == "books") or ($data['outcontragent_alias'] == "XEROX")) {
        $curorder = $data['order_number'];
        echo $data['order_number']." имеет XEROX либо тетрадки"."<br>";
        mysql_query ("UPDATE `order` SET order.order_has_digital = '1' WHERE order.order_number = '$curorder'");

    }
    else {
        echo "нет цифры <br>";
    }
}


?>
