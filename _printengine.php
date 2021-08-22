<?
include_once './dbconnect.php';
//этот файл принимает команду печати от всех кнопок в бланках и решает что делать дальше. в параметрах только номер бланка. вся логика куда что печатать - как раз в этом файле
$order_number = $_GET['order_number'];
if ($_GET['addtoquery'] == '1') {
    mysql_query("INSERT INTO `print_order` (`print_order_number`,`printed`) VALUES ('$order_number','0')");
}
echo $order_number;
$aa = file_get_contents('http://192.168.1.221/_pdf_engine/index.php?order_number='.$order_number);
$aa = file_get_contents('http://192.168.1.221/_pdf_engine_check/index.php?order_number='.$order_number);
?>