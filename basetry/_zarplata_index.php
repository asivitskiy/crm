<?
session_start();
include "dbconnect.php";
?>


<!--Формирование таблицы оборотов-->
<?

$main_sql = "SELECT * FROM `order`";
$main_array = mysql_query($main_sql);
while ($main_data = mysql_fetch_array($main_array)) {

	if ($main_data['order_manager'] == 'Ю') {
		
		 if ($main_data['deleted'] == '1'){
			
			$manager  = $main_data['order_manager'];
			$number   = $main_data['order_number'];
			$w_manager_jul_sql = "SELECT * FROM `works` WHERE ((`work_order_manager` = '$manager') and (`work_order_number` = '$number'))";
			$w_manager_jul_array = mysql_query($w_manager_jul_sql);
			
			while ($w_manager_jul_data = mysql_fetch_array($w_manager_jul_array)) {
				$ready_jul = $ready_jul + ($w_manager_jul_data['work_price']*1)*($w_manager_jul_data['work_count']*1);
			}
		}
		
		if ($main_data['deleted'] <> '1'){
			
			$manager  = $main_data['order_manager'];
			$number   = $main_data['order_number'];
			$w_manager_jul_sql = "SELECT * FROM `works` WHERE ((`work_order_manager` = '$manager') and (`work_order_number` = '$number'))";
			$w_manager_jul_array = mysql_query($w_manager_jul_sql);
			
			while ($w_manager_jul_data = mysql_fetch_array($w_manager_jul_array)) {
				$amount_jul = $amount_jul + ($w_manager_jul_data['work_price']*1)*($w_manager_jul_data['work_count']*1);
			}
		}
	
	}

	if ($main_data['order_manager'] == 'Н') {
		
		 if ($main_data['deleted'] == '1'){
			
			/*$manager = '';*/ $manager  = $main_data['order_manager'];
			/*$number  = '';*/ $number   = $main_data['order_number'];
			$w_manager_jul_sql = "SELECT * FROM `works` WHERE ((`work_order_manager` = '$manager') and (`work_order_number` = '$number'))";
			$w_manager_jul_array = mysql_query($w_manager_jul_sql);
			
			while ($w_manager_jul_data = mysql_fetch_array($w_manager_jul_array)) {
				$ready_nat = $ready_nat + ($w_manager_jul_data['work_price']*1)*($w_manager_jul_data['work_count']*1);
			}
		}
		
		if ($main_data['deleted'] <> '1'){
			
			$manager  = $main_data['order_manager'];
			$number   = $main_data['order_number'];
			$w_manager_jul_sql = "SELECT * FROM `works` WHERE ((`work_order_manager` = '$manager') and (`work_order_number` = '$number'))";
			$w_manager_jul_array = mysql_query($w_manager_jul_sql);
			
			while ($w_manager_jul_data = mysql_fetch_array($w_manager_jul_array)) {
				$amount_nat = $amount_nat + ($w_manager_jul_data['work_price']*1)*($w_manager_jul_data['work_count']*1);
			}
		}
	
	}

	if ($main_data['order_manager'] == 'А') {
		
		 if ($main_data['deleted'] == '1'){
			
			$manager  = $main_data['order_manager'];
			$number   = $main_data['order_number'];
			$w_manager_jul_sql = "SELECT * FROM `works` WHERE ((`work_order_manager` = '$manager') and (`work_order_number` = '$number'))";
			$w_manager_jul_array = mysql_query($w_manager_jul_sql);
			
			while ($w_manager_jul_data = mysql_fetch_array($w_manager_jul_array)) {
				$ready_ann = $ready_ann + ($w_manager_jul_data['work_price']*1)*($w_manager_jul_data['work_count']*1);
			}
		}
		
		if ($main_data['deleted'] <> '1'){
			
			$manager  = $main_data['order_manager'];
			$number   = $main_data['order_number'];
			$w_manager_jul_sql = "SELECT * FROM `works` WHERE ((`work_order_manager` = '$manager') and (`work_order_number` = '$number'))";
			$w_manager_jul_array = mysql_query($w_manager_jul_sql);
			
			while ($w_manager_jul_data = mysql_fetch_array($w_manager_jul_array)) {
				$amount_ann = $amount_ann + ($w_manager_jul_data['work_price']*1)*($w_manager_jul_data['work_count']*1);
			}
		}
	
	}



/*$ready_jul=
$ready_nat=
$ready_ann=

$amount_jul=
$amount_nat=
$amound_ann=*/


}
echo 'Юля, готовых заказов:<br>';
echo $ready_jul;
echo '<br>Юля, незавершенных заказов:<br>';
echo $amount_jul;
echo '<br>Юля, оборот:<br>';
echo $amount_jul+$ready_jul;
echo '<br>';
echo '<br>Наташа, готовых заказов:<br>';
echo $ready_nat;
echo '<br>Наташа, незавершенных заказов:<br>';
echo $amount_nat;
echo '<br>Наташа, оборот:<br>';
echo $amount_nat+$ready_nat;
echo '<br>';
echo '<br>';
echo $ready_ann;
echo '<br>';
echo $amount_ann;
echo '<br>';
echo $amount_ann+$ready_ann;

?>