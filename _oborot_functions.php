<?
//всего принято
function obsh_oborot($period_start,$period_end) {
    $sql = "SELECT *,SUM(works.work_price*works.work_count) as ordersum FROM `order` 
            LEFT JOIN `works` ON order.order_number = works.work_order_number

            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end'))";
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
            LEFT JOIN `work_types` ON works.work_tech = work_types.name
            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') and ((work_types.group = 'digital')or(work_types.group = 'books')or(work_types.group = 'design')))";
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
            LEFT JOIN `work_types` ON works.work_tech = work_types.name
            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') and ((work_types.group = 'outer')))";
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
            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') and ((works.work_tech = '')))";
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
            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') )";
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

            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') and (order.deleted = 1))";
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

            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') and (order.deleted <> 1))";
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
            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end'))";
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
            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') and (order.order_manager IN ($manager2)))";
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

            WHERE ((order.date_in > '$period_start') and (order.date_in < '$period_end') and (order.order_manager IN ($manager2)))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $amount = $amount + $data['ordersum'];
    }


    $result = number_format($amount, 2, '.', '');$amount;
    return $result;
}

?>