<?
session_start();
include "dbconnect.php";
$digital_percent = 0.06;
$tetr_percent = 0.05;
$diz_percent = 0.06;
$reorder_percent = 0.3;
?>

<? /*Функция расчета общей суммы заказов печти (оплаченных)*/
	/*MNG - буква менеджера   PRC - процент по этому типа заказов  WORKTYPE - типа фильтруемых заказов*/
function zarplata($mng,$prc,$worktype) {
	/*Достаём номера заказов менеджера*/

		/*Достаём полные данные по конкретному заказу*/
		$w_sql = "	SELECT * FROM `order`
							INNER JOIN `works` ON works.work_order_number = order.order_number
							INNER JOIN `work_types` ON works.work_tech = work_types.name
							WHERE ((work_types.group = '$worktype') and (works.work_order_manager = '$mng') and (order.deleted = 1))";
		
		$w_array = mysql_query($w_sql);
		while ($w_data = mysql_fetch_array($w_array)) {

			$fsumm = $fsumm + ($w_data['work_price']*1)*($w_data['work_count']*1);
			
				if ($w_data['group'] == 'outer') {
					/*$fsumm = $fsumm*1 - $w_data['work_rashod']*1;*/
					$frashod = $frashod + $w_data['work_rashod']*1;
				}
			
		}
	
$zsumm = $fsumm*$prc;
return array($fsumm,$zsumm,$frashod) ;
}


?>


<table border="1">
	<tr>
		<td></td>
		<td>Юля (сумма/процент/зп)</td>
		<td>Наташа (сумма/процент/зп)</td>
		<td>Аня (сумма/процент/зп)</td>
		<td>Алиса (сумма/процент/зп)</td>
		
	</tr>
	<tr>
		<td>Оперативка</td>
		<td><? list ($f,$z) = zarplata('Ю',$digital_percent,'digital'); echo $f.' / '.$digital_percent.' / '.$z; ?></td>
		<td><? list ($f,$z) = zarplata('Н',$digital_percent,'digital'); echo $f.' / '.$digital_percent.' / '.$z; ?></td>
		<td><? list ($f,$z) = zarplata('А',$digital_percent,'digital'); echo $f.' / '.$digital_percent.' / '.$z; ?></td>
		<td></td>
		
	</tr>
	<tr>
		<td>Тетради</td>
		<td><? list ($f,$z) = zarplata('Ю',$tetr_percent,'books'); echo $f.' / '.$tetr_percent.' / '.$z; ?></td>
		<td><? list ($f,$z) = zarplata('Н',$tetr_percent,'books'); echo $f.' / '.$tetr_percent.' / '.$z; ?></td>
		<td><? list ($f,$z) = zarplata('А',$tetr_percent,'books'); echo $f.' / '.$tetr_percent.' / '.$z; ?></td>
		<td></td>
		
	</tr>
	<tr>
		<td>Дизайн</td>
		<td><? list ($f,$z) = zarplata('Ю',$diz_percent,'design'); echo $f.' / '.$diz_percent.' / '.$z; ?></td>
		<td><? list ($f,$z) = zarplata('Н',$diz_percent,'design'); echo $f.' / '.$diz_percent.' / '.$z; ?></td>
		<td><? list ($f,$z) = zarplata('А',$diz_percent,'design'); echo $f.' / '.$diz_percent.' / '.$z; ?></td>
		<td></td>
		
	</tr>
	<tr>
		<td>Перезаказ</td>
		<td><? list ($f,$z) = zarplata('Ю',$reorder_percent,'outer'); echo $f.' / '.$reorder_percent.' / '.$z; ?></td>
		<td><? list ($f,$z) = zarplata('Н',$reorder_percent,'outer'); echo $f.' / '.$reorder_percent.' / '.$z; ?></td>
		<td><? list ($f,$z) = zarplata('А',$reorder_percent,'outer'); echo $f.' / '.$reorder_percent.' / '.$z; ?></td>
		<td></td>
		
	</tr>
	<tr>
		<td>Подготовка</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		
	</tr>
	
</table>
<br><br><br>
