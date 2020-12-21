
   

	
				<?
			$prev_m = "12";
			$query_cclist_1 = "SELECT * FROM `ccenter` ORDER BY `date_m` DESC";
			$res_cclist_1 = mysql_query($query_cclist_1);
			while($row_cclist_1 = mysql_fetch_array($res_cclist_1))
				{ 
					
				  if (($row_cclist_1['date_m'])*1<($prev_m*1)) {
					  echo("<br> месяц -> ".$prev_m);
					  echo("<br>bnal ->".$sum_bnal2."<br>");
					  echo("nal ->".$sum_nal2."<br>");
					  echo("ОБЩ ->".($sum_nal2+$sum_bnal2)."<br>");
					  $prev_m = $row_cclist_1['date_m'];
					 
					  $sum_bnal2 = 0;
					  $sum_nal2 = 0;
				  		}
					
							if (($row_cclist_1['type']) == 'bnal') 
								{
									$sum_bnal2 = $sum_bnal2 + $row_cclist_1['sum'];
								}	
			
							if (($row_cclist_1['type']) == 'nal') 
								{
										$sum_nal2 = $sum_nal2 + $row_cclist_1['sum'];
								}	
			
					

				}

?>
			
