<table class="simple-little-table" cellspacing='0'>
	
	
	<tr>
		<th>Бланк </th>
		<th>Дата приёма</th>
		<th>Заказчик</th>
		<th>Продавец</th>
		<th>Статус оплаты</th>
		<th>Примечания</th>
	</tr><!-- Table Header -->
    
	<?	// Файл firstsql.php
 
	$query = "SELECT * FROM `order`";
	$res = mysql_query($query);
	while($row = mysql_fetch_array($res))
	{
	
	
	?>
	
	<tr>
	<?	
		
	$amount_order *= 0;
    echo($amoun_order);
	$order_name_1 = $row['manager'].'-'.$row['name'];
	$query_works_1 = "SELECT * FROM `works` WHERE ((`order_id` LIKE '$order_name_1') AND (`deleted` <> 1))";
	$res_works_1 = mysql_query($query_works_1);
	while($row_works_1 = mysql_fetch_array($res_works_1))
	    { 
		$amount_order = $amount_order+(($row_works_1['price'])*($row_works_1['count'])); 
	
		}
		
		
		?>
		
		
		
		
		<td><a href><? echo $row['manager'].'-'.$row['name']; ?></a></td>
		<td><a><? 
			echo(dig_to_d($row[date_in]).'.'.dig_to_m($row[date_in]).' ['.dig_to_h($row[date_in]).':'.dig_to_minute($row[date_in]).']');
				?></a></td>
		<td><a><? echo $row['contragent']; ?></a></td>
	    <td><a><? echo $row['pay_type']; ?></a></td>
	    <td><a><? echo $row['pay_status']; ?></a></td>
	    <td><a><? echo $row['notes']; ?></a></td>
	    <td><a><? echo $amount_order; ?></a></td>
	    <td><button name="show_details_button" class="<? echo $row[id] ?>">ДЕТАЛИ >>></button></td>
	    			<script language="javascript" type="text/javascript">
    					$('.<? echo $row[id] ?>').click( function() {
						$.ajax({
          				type: 'POST',
						url: 'response.php?action=show_details_button',
          				data: 'type=orderdetails&orderid=<? echo $row[id] ?>&ordermanager=<? echo $row[manager] ?>',
          				success: function(data){
            			$('.right-col').html(data);
          				}
        			});

			});
			</script>

	
		
		</tr><!-- Table Row -->
	<? } ?>

</table>