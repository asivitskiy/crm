<? $start = microtime(true); ?>
<? include '../dbconnect.php'; ?>
<? session_start(); ?>
<? include '../inc/global_functions.php'; ?>
<? include '../inc/cfg.php'; ?>
<? $action = $_GET['action']; ?>
<!doctype html>
<html>
<head>
<SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
<SCRIPT type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></SCRIPT>
<link rel="stylesheet" href="http://192.168.1.221/jquery-ui.css">
<link rel="stylesheet" href="http://192.168.1.221/_workrow.css">
<link rel="stylesheet" type="text/css" href="truestyle.css" />
<meta charset="utf-8">
<title>Шаблон Imaths</title>
</head>
<body>

<form action="../_new_order_processor.php" method="POST" id="mainform">
<table>
		<tr>
			<td>Название</td>
			<td>Описание</td>
			<td>Количество</td>
			<td>Цена</td>
			<td>Сумма</td>
			
		</tr>
		
		<? 
	$template_name = $_GET['fr'];
	$template_work_name_sql = "SELECT * FROM `$template_name`";
	$template_work_name_query = mysql_query($template_work_name_sql);
	while ($template_work_data = mysql_fetch_array($template_work_name_query)) {	
	?>

		<tr>
			<td><? echo $template_work_data['name']; ?></td>
			<td><? echo $template_work_data['description']; ?></td>
			<td><input type="text"></td>
			<td><? echo $template_work_data['price']; ?></td>
			<td>Сумма</td>
		</tr>
	<? } ?>	
		
	</table>
</form>
</body>
</html>
