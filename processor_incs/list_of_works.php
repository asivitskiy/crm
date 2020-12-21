<?
		$workname = str_replace("\r", "", str_replace("\n", "\\n", $a1));
			$query_2 = "SELECT `workname` FROM `worknames` WHERE `workname` = '$workname'";
			$res_2 = mysql_query($query_2);
			$row_2 = mysql_fetch_array($res_2);
			$iii2 = count($row_2['workname']);
			if ($iii2<1){
					$sq4 = "INSERT INTO `worknames` (workname) VALUES ('$workname')";
					mysql_query($sq4);
				}
?>