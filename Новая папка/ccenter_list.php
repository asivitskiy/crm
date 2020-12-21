		
<? $today_day = date("d"); ?>
   

		<div style="float: left;; display: inline;">
				
			
				<table class="simple-little-table">
				<?
			$query_cclist_1 = "SELECT * FROM `ccenter` WHERE `type` LIKE 'bnal' ORDER BY `id` DESC LIMIT 0,30";
			$res_cclist_1 = mysql_query($query_cclist_1);
			while($row_cclist_1 = mysql_fetch_array($res_cclist_1))
				{ 
					
				?>
			
				<tr >
					<td><font style="font-size: 12px;"><?	echo $row_cclist_1['date_hour'].':'.$row_cclist_1['date_minute']; ?></font></td>
					<td align="right" style="text-align: right"><?	echo $row_cclist_1['sum'].'<br>'; }	?></td>
				</tr>
				</table>
				

		</div>

		

		<div style="margin-left: 250px;">
				
				<table class="simple-little-table">
				<?
			$query_cclist_2 = "SELECT * FROM `ccenter` WHERE `type` LIKE 'nal' ORDER BY `id` DESC LIMIT 0,30";
			$res_cclist_2 = mysql_query($query_cclist_2);
			while($row_cclist_2 = mysql_fetch_array($res_cclist_2))
				{ 
					
				?>
			
				<tr>
					<td><font style="font-size: 12px;"><?	echo $row_cclist_2['date_hour'].':'.$row_cclist_2['date_minute']; ?></font></td>
					<td align="right" style="text-align: right"><? echo $row_cclist_2['sum'].'<br>'; } ?></td>
				</tr>
				</table>

		</div>
		