<?  require_once  'dbconnect.php';

session_start(); 
require_once  './inc/global_functions.php'; 
require_once  './_oborot_functions.php'; 
require_once  './inc/cfg.php'; 
require_once  './inc/config_reader.php';
if ($_GET['action'] == 'getready') {
    $current_order_number = $_GET['order_number'];
    $current_date = date("YmdHi");
    mysql_query("UPDATE `order` SET `order_ready_digital` = '$current_date' WHERE `order_number` = '$current_order_number'");
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/_postprint_checker.php?action=showlist');
}
$action = $_GET['action']; 
$current_manager = $_SESSION['manager'];  ?>
<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        a {
            text-decoration: none;
        }
        a:hover {
            cursor: pointer;
        }
        .order_card {
            background-color:#efefef;
            border:1px solid gray;
            border-radius: 4px;
            width: 180px;
            height: 60px;
            padding: 3px;
            display: inline-block;
            line-height: 60px;
            text-align: center;
            margin: 3px 3px 3px 3px;
            color: black;
            font-weight: 600;
            font-size: 20px;
        }

        .bigbutton {
            background-color:#efefef;
            border:1px solid gray;
            border-radius: 4px;
            width: 130px;
            height: 50px;
            padding: 3px;
            display: inline-block;
            line-height: 50px;
            text-align: center;
            margin: 3px 3px 3px 3px;
            color: black;
            font-weight: 600;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?
function render_postprint_list() {
    $arr = mysql_query("SELECT *,LENGTH(order.preprint) as lenn FROM `order` WHERE ((order.order_has_digital = 1) and (order.order_ready_digital = 0) and (order.deleted <> 1) and (order.soglas <> 0)) ORDER BY order.order_number DESC");
    while ($dat = mysql_fetch_array($arr)) { ?>

        <a href="_postprint_checker.php?action=showdetails&order_number=<? echo $dat['order_number'];?>">
        <div class="order_card"><? echo $dat['order_manager']."-".$dat['order_number'];?></div>
        </a>
<?  } 
} 

function render_postprint_details($ordernumber) {
    $i = 0;
    $sql = "SELECT * FROM `order` 
            LEFT JOIN `works` ON works.work_order_number = order.order_number
            LEFT JOIN `contragents` ON contragents.id = order.contragent
            WHERE order.order_number = '$ordernumber'
            ";
    $arr = mysql_query($sql);
    while ($dat = mysql_fetch_array($arr)) { 
        if ($i == 0) {
            
            echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||<br>";
            echo "<b>".$dat['order_manager']."-".$dat['order_number']."</b><br>";
            echo $dat['name']."<br>";
            echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||<br>";
            echo $dat['order_description']."<br>";
            echo "<br>";
            echo "******************************************************<br>";
            
        }
        
        echo $dat['work_name']." - <b>".$dat['work_count']."шт.</b><br>";
        echo "- - - - - - - - - - - - - - - - - - - - - - - - - -<br>";
        echo $dat['work_description']."<br>";
        echo "******************************************************<br>";
        

        
    $i++;
    $cur_order_number = $dat['order_number'];
} 
echo "<br>";
echo "<a href=_postprint_checker.php?action=showlist class=bigbutton><<<назад</div>";

echo "<a href=_postprint_checker.php?action=getready&order_number=".$cur_order_number." class=bigbutton style=margin-left:75px;>готов</div>";

} 



 
if (($_GET['action'] == 'showlist')or(!isset($_GET['action']))) {
    render_postprint_list();
}

if ($_GET['action'] == 'showdetails') {
    render_postprint_details($_GET['order_number']);
}


?>
</body>