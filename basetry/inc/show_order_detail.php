<? $start = microtime(true); ?>
<table class="simple-little-table-2" cellspacing='0' style="">
	
	
	<tr>
		<th>Название</th>
		<th>Размер</th>
		<th>Материал</th>
		<th>Техника</th>
		<th>Цена</th>
		<th>Количество</th>
		<th>Сумма</th>
	</tr>
    
	<?
 	$oreder_id_1 = $_POST['orderid'];
	$oreder_manager_1 = $_POST['ordermanager'];
	echo($oreder_manager_1);
	$query11 = "SELECT * FROM `order` WHERE ((`id`='$oreder_id_1')&(`manager`='$oreder_manager_1'))";
	$res11 = mysql_query($query11);
	
	while($row11 = mysql_fetch_array($res11))
				{
				$amount_order *= 0;
    			$order_name_2 = $row11['manager'].'-'.$row11['name'];
				$query_works_2 = "SELECT * FROM `works` WHERE ((`order_id`='$order_name_2') AND (`deleted` <> 1))";
				$res_works_2 = mysql_query($query_works_2);
				
				while($row_works_2 = mysql_fetch_array($res_works_2))
					{ 
						?> <tr> <?
					$amount_order = $amount_order+(($row_works_2['price'])*($row_works_2['count'])); 
						?>
	
						<td><? echo $row_works_2['name']; ?></div></td>
						<td><? echo $row_works_2['format']; ?></div></td>
						<td><? echo $row_works_2['media']; ?></div></td>
	    				<td><? echo $row_works_2['tech']; ?></div></td>
	    				<td><? echo $row_works_2['price']; ?></div></td>
	    				<td><? echo $row_works_2['count']; ?></div></td>
	    				<td><? echo (($row_works_2['count'])*($row_works_2['price'])); ?></td>
						  </tr>
						  
							  
						<?
					}
		
					?>
					<tr>
						<td colspan="5"></td>
					
						<td><br><br><b>Общая сумма:</b><br>&nbsp;</td>
	    				<td><br><br><b><? echo $amount_order; ?></b><br>&nbsp;</td>	
					</tr>
					
				<? } ?>
		
		
		
		

</table>

<a href="response.php?type=redact_order&order_id=<? echo $oreder_id_1; ?>">РЕДАКТИРОВАТЬ</a>

<? $time = microtime(true) - $start;  echo $time;?>