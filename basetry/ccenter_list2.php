		
<? $today_day = date("d"); ?>
   

		<div style="float: left;; display: inline;">
				
			
				<table class="simple-little-table">
				<?
			$query_cclist_1 = "SELECT * FROM `ccenter` WHERE `type` LIKE 'bnal' ORDER BY `id` DESC";
			$res_cclist_1 = mysql_query($query_cclist_1);
			while($row_cclist_1 = mysql_fetch_array($res_cclist_1))
				{ 
					
				?>
			
				<tr >
					<td><font style="font-size: 12px;"><?	echo $row_cclist_1['date_hour'].':'.$row_cclist_1['date_minute']; ?></font></td>
					<td align="right" style="text-align: right"><?	echo $row_cclist_1['sum'].'<br>'; $sum_bnal = $sum_bnal + $row_cclist_1['sum'];}	?></td>
				</tr>
				</table>

				

		</div>

		

		<div style="margin-left: 250px;">
				
				<table class="simple-little-table">
				<?
			$query_cclist_2 = "SELECT * FROM `ccenter` WHERE `type` LIKE 'nal' ORDER BY `id` DESC";
			$res_cclist_2 = mysql_query($query_cclist_2);
			while($row_cclist_2 = mysql_fetch_array($res_cclist_2))
				{ 
					
				?>
			
				<tr>
					<td><font style="font-size: 12px;"><?	echo $row_cclist_2['date_hour'].':'.$row_cclist_2['date_minute']; ?></font></td>
					<td align="right" style="text-align: right"><? echo $row_cclist_2['sum'].'<br>';$sum_nal = $sum_nal + $row_cclist_2['sum']; } ?></td>
				</tr>
				</table>
		</div>
		<? echo("bnal->");echo $sum_bnal; ?>
<? echo("<br>nal->");echo $sum_nal;echo("<br>time->"); ?>
