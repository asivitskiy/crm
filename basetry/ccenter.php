<? $start = microtime(true); ?>
<? include 'dbconnect.php'; ?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Система учёта копицентра</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" href="spisok1.css" />
<link rel="stylesheet" type="text/css" href="spisok2.css" />
</head>

<body style="font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'; font-size: 20px; font-weight: bold;">
<body style="font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'; font-size: 20px; font-weight: bold;">
	
<div style="width: 1000px; float: left;">
	<form action="ccenter_processor.php" method="POST">
	<table>
		<tr>
			<td>_безнал</td>
			<td>_наличные</td>
			<td></td>
		</tr>
		
		<tr>
			<td style="width: 250px;">
				<input name="bnal" type="text" autocomplete="off" style="font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'; font-size: 30px; font-weight: bold; width: 150px; height: 75px; padding: 10px">
			</td>
			<td>
				<input name="nal" autocomplete="off" type="text" style="font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'; font-size: 30px; font-weight: bold; width: 150px; height: 75px; padding: 10px">
			</td>
			<input type="hidden" name="flag_cc" value="ok">			
			<td><button title="141313" type="submit" style="width: 150px; height: 75px; font-size: 25px;" >Оплачено</button>
		</tr>
		
		
	</table>
	</form>
	
<? include('ccenter_list.php'); ?>
	

</div>
<div style="width: 400px;float: left;">
	Цифры:
	<? include("ccenter_stats.php"); ?>
</div>
</body>
</html
