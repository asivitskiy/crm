<? $start = microtime(true); ?>
<? include 'dbconnect.php'; ?>
<? include './inc/global_functions.php'; ?>
<!doctype html>
<html>
<head>


<script src="js/jquery.min.js" type="text/javascript"></script>	
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="spisok1.css" />
<link rel="stylesheet" type="text/css" href="spisok2.css" />
	
<meta charset="utf-8">
<title>ГЛАВНАЯ СТРАНИЦА</title>
</head>

<body style="background-color: #dedede; background-position: left bottom; background-repeat: repeat;">
<table border="0">
	<tr>
		<td colspan="2">
			
		</td>
	</tr>
	<tr>
		<td style="width: 50px;">
		 	 
		</td>
		<td>
			<? include('./inc/master_content.php'); ?>
		</td>
		<td>
			
		</td>
	</tr>


</table>


	
<? $time = microtime(true) - $start;  echo $time;?>	
</body>
</html>
