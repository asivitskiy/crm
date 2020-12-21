<?
			$action = $_GET['action'];
			$order_manager = $_GET['order_manager'];
			$order_number = $_GET['order_number'];
			//mysql_query("DELETE FROM `order` WHERE ((`order_manager` = '$order_manager') AND (`order_number` = '$order_number'))");
			//mysql_query("DELETE FROM `works` WHERE ((`work_order_manager` = '$order_manager') AND (`work_order_number` = '$order_number'))");
?>
<? if (isset($_GET['confirmed'])) {
		
			mysql_query("DELETE FROM `order` WHERE ((`order_manager` = '$order_manager') AND (`order_number` = '$order_number'))");
			mysql_query("DELETE FROM `works` WHERE ((`work_order_manager` = '$order_manager') AND (`work_order_number` = '$order_number'))"); 
			mysql_query("DELETE FROM `money` WHERE (`parent_order_number` = '$order_number')"); 
			mysql_query("DELETE FROM `order_messages` WHERE (`order_number` = '$order_number')"); 
			?>
Заказ <? echo($order_manager); ?> - <? echo($order_number); ?> удален. <br><br>
<? } else { ?> 
<a style="color: red" href="index.php?action=delete&order_manager=<? echo $order_manager; ?>&order_number=<? echo $order_number; ?>&confirmed"><h3>Удалить заказ <? echo($order_manager); ?> - <? echo($order_number); ?></h3></a> <? } ?>
<a href="?action=showlist">Возврат к списку заказов >>>></a>