<? session_start();
include "dbconnect.php"; ?>
<!--новый алгоритм вывода списка заказов (основной список) с использование JOIN-->
<!--SELECT *, SUM(money.summ) as temp_sum, CONCAT_WS('<br>',order_messages.message) as allmessages FROM `order` 
			 LEFT JOIN `works` ON works.work_order_number = order.order_number
			 LEFT JOIN `money` ON order.order_number = money.parent_order_number
			 LEFT JOIN `contragents` ON order.contragent = contragents.id
			 LEFT JOIN `order_messages` ON order.order_number = order_messages.order_number
			 GROUP BY works.id
			 *, SUM(money.summ) as temp_sum 
			 LEFT JOIN `contragents` ON order.contragent = contragents.id
			 -->


<?
$m[1] = 'А';
$m[2] = 'Н';
$m[3] = 'Ю';


for ($i = 1; $i <= 3; $i++) {

$mng = $m[$i];
$main_sql = "

		SELECT *,SUM(money.summ) as temp_sum, order.deleted as dlt FROM `order`
 		LEFT JOIN `works` ON works.work_order_number = order.order_number
 		LEFT JOIN `money` ON order.order_number = money.parent_order_number
 		LEFT JOIN `work_types` ON works.work_tech = work_types.name
 		WHERE ((order.order_manager = '$mng'))
 		GROUP BY works.id ORDER by order.order_number
		
		";

$main_array = mysql_query($main_sql);
$prev_order = 0;

$ready_inner_summ = 0;
$waiting_inner_summ = 0;
$ready_outer_summ = 0;
$waiting_outer_summ = 0;
$outer_rashod = 0;
$ready_digital_summ = 0;
$waiting_digital_summ = 0;
$ready_books_summ = 0;
$waiting_books_summ = 0;
$ready_design_summ = 0;
$waiting_design_summ = 0;
$ready_own_design_summ = 0;
//цикл перебора зазазов определенного менеджера
while ($main_data = mysql_fetch_array($main_array)) {
			
						
		// проверка косяков (невписанных счетов расхода и суммы расхода)
			if ($main_data['group'] == 'outer') {
				// все внешние заказы (все готовые перезаказы)
				if (($main_data['dlt'] == '1') and ($main_data['work_rashod_list'] <> '') and ($main_data['work_rashod'] > 0)) {
					$ready_outer_summ = $ready_outer_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					$outer_rashod = $outer_rashod + $main_data['work_rashod'];
					}
			
				if ($main_data['dlt'] <> '1') {
					$waiting_outer_summ = $waiting_outer_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					}
			}
			
			
			if ($main_data['group'] == 'digital') {
				// все внешние заказы (все готовые перезаказы)
				if (($main_data['dlt'] == '1')) {
					$ready_digital_summ = $ready_digital_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					}
			
				if ($main_data['dlt'] <> '1') {
					$waiting_digital_summ = $waiting_digital_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					}
			}
			
			if ($main_data['group'] == 'books') {
				// все внешние заказы (все готовые перезаказы)
				if (($main_data['dlt'] == '1')) {
					$ready_books_summ = $ready_books_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					}
			
				if ($main_data['dlt'] <> '1') {
					$waiting_books_summ = $waiting_books_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					}
			}
			
			if ($main_data['work_tech'] == 'Дизайн') {
				// все внешние заказы (все готовые перезаказы)
				if (($main_data['dlt'] == '1')) {
					$ready_design_summ = $ready_design_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					}
			
				if ($main_data['dlt'] <> '1') {
					$waiting_design_summ = $waiting_design_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					}
			}
			
			if ($main_data['work_tech'] == 'менеджер') {
				// все внешние заказы (все готовые перезаказы)
				if (($main_data['dlt'] == '1')) {
					$ready_own_design_summ = $ready_own_design_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					}
			
				if ($main_data['dlt'] <> '1') {
					$waiting_own_design_summ = $waiting_own_design_summ + ($main_data['work_price']*1)*($main_data['work_count']);
					}
			}
			
			


}
echo $mng.'<br>';
echo ($ready_digital_summ.' готовые Внутренние <br>');
/*echo ($waiting_digital_summ.' неготовые Внутренние <br>');*/
echo ($ready_books_summ.' готовые Тетради <br>');
/*echo ($waiting_books_summ.' неготовые Тетради <br>');*/
echo ($ready_design_summ.' готовый Дизайн <br>');
echo ($ready_own_design_summ.' свой дизайн <br>');
/*echo ($waiting_design_summ.' неготовый Дизайн <br>');*/
echo ($ready_outer_summ.' готовые перезаказы <br>');
echo ($outer_rashod.' расход по перезаказам <br>');
/*echo ($waiting_outer_summ.' неготовые перезаказы <br>');*/
$zp = $ready_digital_summ*0.06  +  $ready_books_summ*0.05  +  $ready_design_summ*0.1  +  ($ready_outer_summ-$outer_rashod)*0.25 + $ready_own_design_summ*0.5;
echo 'Расчитанная зп (процентная часть): '.$zp.'<br><br>';


}


//зарплата допечатников:
$designed_ann = 0;
$designed_als = 0;
$preprint_zp_sql = "SELECT * FROM `order` 
					LEFT JOIN `works` ON works.work_order_number = order.order_number
					LEFT JOIN `work_types` ON works.work_tech = work_types.name			
					WHERE ((order.deleted = 1))
					GROUP by works.id";
					
$preprint_zp_array = mysql_query($preprint_zp_sql);
while ($preprint_zp_data = mysql_fetch_array($preprint_zp_array)) {
	/*echo $preprint_zp_data['order_number'];*/
	$order_amount = 0;
	$order_amount = $preprint_zp_data['work_price'] * $preprint_zp_data['work_count'] - $preprint_zp_data['work_rashod']*1;
		
	if ($preprint_zp_data['work_tech'] == 'Дизайн') {
		if ($preprint_zp_data['preprinter'] == 'Аня') {
			$designed_ann = $designed_ann + $order_amount;
		}
		if ($preprint_zp_data['preprinter'] == 'Алиса') {
			$designed_als = $designed_als + $order_amount;
		}
	}
/*	if ($preprint_zp_data['work_tech'] == 'менеджер') {
			
	}*/
	
		if ($preprint_zp_data['group'] <> 'outer') {
			//подготовленное алисой - идет в общую сумму алисе, ани - ане
			if ($preprint_zp_data['preprinter'] == 'Аня') {$preprinted_ann = $preprinted_ann + $order_amount; }
			if ($preprint_zp_data['preprinter'] == 'Алиса') {$preprinted_als = $preprinted_als + $order_amount; }
			/*if (($preprint_zp_data['preprinter'] <> 'Аня') and ($preprint_zp_data['preprinter'] <> 'Алиса')) {$preprinted_no = $preprinted_no + $order_amount; }*/
		}
		
		if ($preprint_zp_data['group'] == 'outer') {
			//подготовленное алисой - идет в общую сумму алисе, ани - ане
			if ($preprint_zp_data['preprinter'] == 'Аня') {$preprinted_reorder_ann = $preprinted_reorder_ann + $order_amount; }
			if ($preprint_zp_data['preprinter'] == 'Алиса') {$preprinted_reorder_als = $preprinted_reorder_als + $order_amount; }
			/*if (($preprint_zp_data['preprinter'] <> 'Аня') and ($preprint_zp_data['preprinter'] <> 'Алиса')) {$preprinted_no = $preprinted_no + $order_amount; }*/
		}
		
}
echo 'Аня допечать: '.(($preprinted_ann*0.02) + ($preprinted_reorder_ann*0.05)).'<br>';
echo 'Аня дизайн: '.(($designed_ann*0.5)).'<br>';
echo 'Алиса допечать: '.(($preprinted_als*0.02) + ($preprinted_reorder_als*0.05)).'<br>';
echo 'Алиса Дизайн: '.(($designed_als*0.5)).'<br>';



echo '<br> Общий оборот (по готовым и неготовым)<br>';
$full_sql = "SELECT `order_number`,`deleted` FROM `order`";
$full_array = mysql_query($full_sql);
while ($full_data = mysql_fetch_array($full_array)) {
	$con = $full_data['order_number'];
	$status = '';
	$status = $full_data['deleted'];
	$full_work_sql = "SELECT * FROM `works` WHERE `work_order_number` = '$con'";
	$full_work_array = mysql_query($full_work_sql);
	while ($full_work_data = mysql_fetch_array($full_work_array)) {
		if ($status == '1') {
			$ready_amount = $ready_amount + $full_work_data['work_price']*1*$full_work_data['work_count'];
		} else {
			$not_ready_amount = $not_ready_amount + $full_work_data['work_price']*1*$full_work_data['work_count'];
		}
			
	}
}

echo 'готовый - '.$ready_amount.'<br>';
echo 'неготов - '.$not_ready_amount.'<br>';




echo '<br>Калькулятор оборотов<br>';
//прошлый месяц
$interval_summ 		= 0;
$interval_rashod 	= 0;
$start_interval = date('YmdHi', mktime(0, 0, 0, date('m'), 1))*1;
$end_interval = date('YmdHi', mktime(0, 0, 0, date('m') - 1, 1))*1;
/*echo $end_interval; echo $start_interval;*/
$interval_order_sql = "SELECT `order_number` FROM `order` WHERE ((`date_in` < '$start_interval') and (`date_in` > '$end_interval'))";
$interval_order_array = mysql_query($interval_order_sql);
while ($interval_order_data = mysql_fetch_array($interval_order_array)) {
	$interval_works_number = $interval_order_data['order_number'];
	
	$interval_works_sql = "SELECT * FROM `works` WHERE `work_order_number` = '$interval_works_number'";
	$interval_works_array = mysql_query($interval_works_sql);
	while ($interval_works_data = mysql_fetch_array($interval_works_array)) {
		$interval_summ = $interval_summ + $interval_works_data['work_count']*$interval_works_data['work_price'];
		$interval_rashod = $interval_rashod + $interval_works_data['work_rashod'];
	}

}

echo 'Объем принятых заказов за прошлый месяц: '.$interval_summ.'<br>';
echo 'Объем расходов на перезаказы за прошлый месяц: '.$interval_rashod.'<br>';

?> <br><br><?
//текущий месяц
$interval_summ 		= 0;
$interval_rashod 	= 0;
$start_interval = date('YmdHi', mktime(0, 0, 0, date('m'), 1))*1;
$end_interval = date('YmdHi', mktime(0, 0, 0, date('m') - 1, 1))*1;
/*echo $end_interval; echo $start_interval;*/
$interval_order_sql = "SELECT `order_number` FROM `order` WHERE ((`date_in` > '$start_interval'))";
$interval_order_array = mysql_query($interval_order_sql);
while ($interval_order_data = mysql_fetch_array($interval_order_array)) {
	$interval_works_number = $interval_order_data['order_number'];
	
	$interval_works_sql = "SELECT * FROM `works` WHERE `work_order_number` = '$interval_works_number'";
	$interval_works_array = mysql_query($interval_works_sql);
	while ($interval_works_data = mysql_fetch_array($interval_works_array)) {
		$interval_summ = $interval_summ + $interval_works_data['work_count']*$interval_works_data['work_price'];
		$interval_rashod = $interval_rashod + $interval_works_data['work_rashod'];
	}

}

echo 'Объем принятых заказов за текущий месяц: '.$interval_summ.'<br>';
echo 'Объем расходов на перезаказы за текущий месяц: '.$interval_rashod.'<br>';

 
echo '<br> Обороты НАЛ/ТЕРМИНАЛ<br>';
$oborot_sql = "SELECT * FROM `money` WHERE ((`date_in` > 202008000000) and (`date_in` < 202009000000))";
$oborot_array = mysql_query($oborot_sql);
while ($oborot_data = mysql_fetch_array($oborot_array)) {
	if (($oborot_data['paymethod'] == 'Терм')) {
		$oborot_bnal = $oborot_bnal + $oborot_data['summ']*1;
		
	}
	if (($oborot_data['paymethod'] == 'Нал ЧЕК')) {
		$oborot_nal = $oborot_nal + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'Нал')) {
		$oborot_nal_b = $oborot_nal_b + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'ООО')) {
		$oborot_ooo = $oborot_ooo + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'ИП')) {
		$oborot_ip = $oborot_ip + $oborot_data['summ']*1;
		
	}
		if (($oborot_data['paymethod'] == 'СБОЛ')) {
		$oborot_sbol = $oborot_sbol + $oborot_data['summ']*1;
		
	}
	
}
echo('Терминал / '.$oborot_bnal);echo("<br>");
echo('Нал Чек  / '.$oborot_nal);echo("<br>");
echo('Нал      / '.$oborot_nal_b);echo("<br>");
echo('ООО      / '.$oborot_ooo);echo("<br>");
echo('ИП       / '.$oborot_ip);echo("<br>");
echo('СБОЛ     / '.$oborot_sbol);echo("<br>");


?>