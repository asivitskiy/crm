<?  include 'dbconnect.php';
include './inc/global_functions.php';
set_time_limit(0);

$check_sql = "SELECT `order_number`,`preprint` FROM `order` WHERE `order_status-check` = 0";
$check_array = mysql_query($check_sql);

while ($check_data = mysql_fetch_array($check_array)) {
    $current_order_number = $check_data['order_number'];
    $work_check_array = mysql_query("    SELECT * FROM `works`
                                               LEFT JOIN `work_types` ON works.work_tech = work_types.name 
                                               WHERE `work_order_number` = '$current_order_number'");

    $dis_flag = 0;
    $error_flag = 0;
    $reorder_flag = 0;

    while ($work_check_data = mysql_fetch_array($work_check_array)) {
        if ($work_check_data['group'] == 'outer') {$reorder_flag = 1;}
        if ($work_check_data['group'] == 'design') {$dis_flag = 1;}
        if (($work_check_data['group'] == 'design') and (strlen($check_data['preprint']) == 12)) {$dis_flag = 2;}
        if (($work_check_data['group'] == 'design') and ($check_data['preprint'] == 'Нет')) {$dis_flag = 2;}
        if ($work_check_data['work_tech'] == '') {$error_flag = 1;}
        if (
           ($work_check_data['group'] == 'outer')
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
