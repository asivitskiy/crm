<?
$current_manager = 'Ю';
require_once ('../inc/dbconnect.php');
require_once ('../inc/global_functions.php');
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Время экспериментов</title>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>


<link rel="stylesheet" href="__css.css">
<script language="javascript" src="__scripts.js"></script>
</head>

<body>


<div class="searchResults">

</div>
<?
    include("top_control_panel.php");

?>


<? 		if (isset($_GET['showlist'])) {
			include("new_main_list_template_grid.php");
		}
?>
<!--ПОЛЕ ПОД КОНТЕНТ-->


</body>


</body>
</html>