<?
//всего принято
function obsh_oborot($period_start,$period_end) {
    $sql = "SELECT *,SUM(works.work_price*works.work_count) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number

            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') and (order.soglas<>0))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');$amount;
    return $result;
}

//всего принято (вложенный запрос для перевроверки
function obsh_oborot2($period_start,$period_end) {
    $sql = "SELECT *,(select SUM(works.work_price * works.work_count) from `works` where works.work_order_number=order.order_number) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number

            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') and (order.soglas<>0))
             GROUP BY order.order_number";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');$amount;
    return $result;
}

//оборот цифра (книги+цифра+дизайн
function obsh_cifra($period_start,$period_end) {
    $sql = "SELECT *,SUM(works.work_price*works.work_count) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number
            LEFT JOIN `outcontragent` ON works.work_tech = outcontragent.outcontragent_fullname
            WHERE ((order.date_in > '$period_start') and (order.soglas<>0) and (order.date_in < '$period_end') and ((outcontragent.outcontragent_group = 'digital')or(outcontragent.outcontragent_group = 'books')or(outcontragent.outcontragent_group = 'design')))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');$amount;
    return $result;
}

//всего перезаказов
function obsh_perezakaz($period_start,$period_end) {
    $sql = "SELECT *,SUM(works.work_price*works.work_count) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number
            LEFT JOIN `outcontragent` ON works.work_tech = outcontragent.outcontragent_fullname
            WHERE ((order.date_in > '$period_start') and (order.soglas<>0) and (order.date_in < '$period_end') and ((outcontragent.outcontragent_group = 'outer')))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');$amount;
    return $result;
}

//работы без изготовителя
function obsh_mistakes($period_start,$period_end) {
    $sql = "SELECT *,SUM(works.work_price*works.work_count) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number
            WHERE ((order.date_in > '$period_start') and (order.soglas<>0)  and (order.date_in < '$period_end') and ((works.work_tech = '')))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');$amount;
    return $result;
}

//работы на роланд
function obsh_roland($period_start,$period_end) {
    $sql = "SELECT *,SUM(works.work_price*works.work_count) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number
            WHERE ((order.date_in > '$period_start') and (order.soglas<>0) and (order.date_in < '$period_end') and ((works.work_tech = 'ROLAND')))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');$amount;
    return $result;
}



//всего расходов в заказах текущего месяца без привязки к оплатам
function obsh_perezakaz_rashod($period_start,$period_end) {
    $sql = "SELECT * FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number
            WHERE ((order.date_in > '$period_start') and (order.soglas<>0) and (order.date_in < '$period_end') )";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['work_rashod'];
    }


    $result = number_format($amount, 2, '.', '');$amount;
    return $result;
}



//всего принято
function obsh_completed($period_start,$period_end) {
    $sql = "SELECT *,SUM(works.work_price*works.work_count) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number

            WHERE ((order.date_in > '$period_start') and (order.soglas<>0) and (order.date_in < '$period_end') and (order.deleted = 1))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');
    return $result;
}


//в работе (незакрытые)
function obsh_inwork($period_start,$period_end) {
    $sql = "SELECT *,SUM(works.work_price*works.work_count) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number

            WHERE ((order.date_in > '$period_start') and (order.soglas<>0) and (order.date_in < '$period_end') and (order.deleted <> 1))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');
    return $result;
}



//Оплаты по деньгам (сколько пришло за заказы месяца всего за всё время
function obsh_paid($period_start,$period_end) {
    $sql = "SELECT order.id,money.summ as summa FROM `order` 
            LEFT JOIN `money` ON order.order_number = money.parent_order_number
            WHERE ((order.date_in > '$period_start') and (order.soglas<>0) and (order.date_in < '$period_end'))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['summa'];
    }


    $result = number_format($amount, 2, '.', '');
    return $result;
}


//МЕНЕДЖЕР !! Оплаты по деньгам (сколько пришло за заказы месяца всего за всё время
function obsh_paid_manager($period_start,$period_end,$manager) {
    $manager1 = explode(',',$manager);
    $manager2 = "'".implode("','",$manager1)."'";
    $sql = "SELECT order.id,money.summ as summa FROM `order` 
            LEFT JOIN `money` ON order.order_number = money.parent_order_number
            WHERE ((order.date_in > '$period_start') and (order.soglas<>0) and (order.date_in < '$period_end') and (order.order_manager IN ($manager2)))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['summa'];
    }


    $result = number_format($amount, 2, '.', '');
    return $result;
}

//МЕНЕДЖЕР !! всего принято
function obsh_oborot_manager($period_start,$period_end,$manager) {
    $manager1 = explode(',',$manager);
    $manager2 = "'".implode("','",$manager1)."'";
    $sql = "SELECT *,SUM(works.work_price*works.work_count) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number

            WHERE ((order.date_in > '$period_start') and (order.soglas<>0) and (order.date_in < '$period_end') and (order.order_manager IN ($manager2)))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');$amount;
    return $result;
}

?>