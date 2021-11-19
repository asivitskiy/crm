<?  //блок настроек
    include_once 'dbconnect.php';        
    include_once './inc/global_functions.php'; 
    include_once './inc/config_reader.php';     
    //include_once 'dbdump.php';
    
    
    $print_sql = "  SELECT printer_status.id, print_order.print_order_number, print_order.printer_name,printer_status.printer_status FROM `print_order` 
                    LEFT JOIN `printer_status` ON printer_status.id = print_order.printer_name
                    LEFT JOIN `order` ON order.order_number = print_order.print_order_number
                    WHERE ((`printed`='0'))";
    $print_array = mysql_query($print_sql);
    while ($print_data = mysql_fetch_array($print_array)) {
        $order_number = $print_data['print_order_number'];
        
        if (($print_data['printer_name'] == 1) and ($print_data['printer_status'] == 'online')) {
            mysql_query("UPDATE `print_order` SET `printed` = 1 WHERE `print_order_number` = '$order_number'");
            echo $order_number;
            $aa = file_get_contents('http://192.168.1.221/_pdf_engine/index.php?order_number='.$order_number);

        }
        if (($print_data['printer_name'] == 2)/* and ($print_data['printer_status'] == 'online')*/) {
            mysql_query("UPDATE `print_order` SET `printed` = 1 WHERE `print_order_number` = '$order_number'");
            echo $order_number;
            $aa = file_get_contents('http://192.168.1.221/_pdf_engine_check/index.php?order_number='.$order_number);

        }
        

    }
    ?>
