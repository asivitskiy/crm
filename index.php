<?
    require_once  'dbconnect.php'; ?>
<? session_start(); ?>
<?  // 't' - указывает взять последний день
    /*$last_day_this_month  = date('t',strtotime('2020-02-17'));
    echo $first_day_this_month;print'<->';echo $last_day_this_month;*/
?>
<? require_once  './inc/global_functions.php'; ?>
<? require_once  './_oborot_functions.php'; ?>
<? require_once  './inc/cfg.php'; ?>
<? $action = $_GET['action']; ?>
<? $current_manager = $_SESSION['manager']; ?>
<!doctype html>
<? //массив ссылок для левых кнопок ( чтоб запустить циклом их чтоб подсветка меню адекватно работала)
        include 'inc/_menu_array.php'; ?>
<html>
<head>


<SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
<SCRIPT type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></SCRIPT>
<SCRIPT type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></SCRIPT>
<link rel="stylesheet" href="jquery-ui.css">
<link rel="stylesheet" href="_workrow.css">
<link rel="stylesheet" type="text/css" href="truestyle.css" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;700&display=swap" rel="stylesheet">

        <!--стили и шрифты от final_design листа заказов-->
        <link rel="stylesheet" href="final_design/web_inc/__css.css">
        <script language="javascript" src="final_design/web_inc/__scripts.js"></script>


<meta charset="utf-8">
    <!--JS autocomplete для странички с формированием заказа + еще какой то, непонять зачем -->
    <? include 'inc/_js_in_php.php'; ?>

<title><?
	for	($i = 0; $i <= 12; $i++) {
		if	(
			($_SERVER['REQUEST_URI'] == $hrefs[$i][0])
				or
			(((strpos($_SERVER['REQUEST_URI'],"ction=showlist&filter=manager")) > 0) and ($i==2))
			) { echo $hrefs[$i][2];}
								}
		if (isset($_GET['order_number'])) {echo $_GET['order_number'].' - РЕДАКТИРОВАНИЕ';}
?></title>
</head>



<body>

<div class="header" style=" <?
						   if (isset($_SESSION['manager'])) { echo 'display:none;';} ?> ">
	<div style="margin-top: 5px;">
		<h2>admix </h2>
		<h3 style="font-size: 10px; color:rgba(0,56,123,1.00);">C</h3>
		<h3 style="font-size: 10px;color:rgba(65,0,65,1.00)">R</h3>
		<h3 style="font-size: 10px; color: rgba(44,50,0,1.00)">M</h3>
	</div>
		<? if (!isset($_SESSION['manager'])) {?>
		<div class="auth">
			<form action="login.php" method="post"><input type="text" name="login"><input type="password" name="password"><input type="submit"></form>
		</div>
		<? } else { echo("<a style='float:right; margin-right:30px; display:inline-block;' href=login.php?quit=1>выход</a>");}?>
</div>
<? if (isset($_SESSION['manager'])) {?>

<div class="left_container">
<?
for	($i = 0; $i <= 9; $i++) {

	?>
<a title="<? echo $hrefs[$i][2];  ?>" href="<? echo $hrefs[$i][0];  ?>">
<div align="center" class="left_menu_item<?
	//небольшое исключение будет, так как буква манагера русская - невозможно сравнить  строки, так что будет лишнее условие
	if(($_SERVER['REQUEST_URI'] == $hrefs[$i][0]) or (((strpos($_SERVER['REQUEST_URI'],"ction=showlist&filter=manager")) > 0) and $i==2)) { echo ('_hover');} ?>" style="vertical-align: middle; border-bottom: 1px dotted #666; ">

 		<img src="<? echo $hrefs[$i][1];  ?>"><? echo '<br>'.$hrefs[$i][2].'';  ?>

</div>
</a>

<? } ?>

<br><a style='float:right; margin-right:30px; display:inline-block;' href=login.php?quit=1>выход</a>


</div>

<? ////////////////////////////////?>
<div class="center_block">

	<div class="top_nav_block" style="display: none;">

		<!-- Вывод сообщения о неверном клиенте(незаполнен, либо дубль) !-->
		<? if (($_GET['double_contragent'] == 1) and (isset($_GET['double_contragent']))) { ?>
		<div style="background-color: #FF6366; text-align: center; padding: 0px auto; font-size: 16px; font-weight: 550; display: inline-block; width: 850px; height: 30px; border-radius: 4px;">Данные клиента не заполнены, либо клиент с таким именем уже есть в базе. Измените имя</div> <? } ?>

		<!-- Вывод сообщения о неверном клиенте(незаполнен, либо дубль) !-->
		<? if (($_GET['action'] == 'showlist') and ($_GET['filter'] == 'client')) { ?>
		<div style=" text-align: left; padding: 0px auto; font-size: 16px; font-weight: 550; display: inline-block; width: 850px;  border-radius: 4px;">Карточка клиента</div> <? } ?>

	</div>

    <?
    $dynamic_margin_top = '0';
    $dynamic_margin_left = '20';
    if (($_GET['action']<>'redact') and ($_GET['action']<>'new')) {
        $dynamic_margin_top = '55';
        $dynamic_margin_left = '0';
        include("final_design/web_inc/top_control_panel.php");
    } ?>

	<div class="main_content_block" style="margin-top: <? echo $dynamic_margin_top; ?>px; margin-left: <? echo $dynamic_margin_left; ?>px;">
	<?/*
	$dolg_opl_data = mysql_fetch_array(mysql_query("SELECT SUM(money.summ) `opl` FROM `money`"));
	$dolg_neopl_data = mysql_fetch_array(mysql_query("SELECT SUM(works.work_price * works.work_count) `neopl` FROM `works`"));
	$dolg = $dolg_neopl_data['neopl'] - $dolg_opl_data['opl'];
	echo "<font size=2>Сумарная задолжность: ".$dolg."</font>";	*/?>

<?
////////////////////////////////////////////////////////////////////////////////////////////////////
/// //ДОЛГИ
/*////////////////////////////////////////////////////////////////////////////////////////////////////*/?><!--
    <?/*   echo '<table class="dolg-table">'; */?>
            <?/* if (($action == 'cashbox')) { */?>    <script>
            $.get('try.php?m=<?/*echo $current_manager; */?>', function(req, data){
                $('.dolg-table').html(req);

            });
                </script>
                <?/*
            } */?>
    --><?/*    echo '</table>';  */?>


		<!--<a href="http://192.168.1.221/dynamic_load/">Новая база</a><br>-->

		<?//Тут, вероятно будет ограничение доступа работать (хотя не факт) ?>

		<? if (($_SESSION['type'] == 'manager') or ($_SESSION['type'] == 'preprinter') or ($_SESSION['type'] == 'admin')) { ?>
		<? ////////////////////////////////?>
		<? if (($action == 'showlist')or(isset($_GET['myorder']))or(isset($_GET['noready']))) {
			/*include "page_sorter.php";*/
			/*include "main_list.php";*/
		   include "final_design/index.php";
		} ?>
		<? if ($action == 'administrating') { include "adminpanel.php"; } ?>
		<? if ($action == 'rashodka') { include "_rashodka_forma.php"; } ?>
		<? if ($action == 'delete') { include "deleter.php"; } ?>
		<? if ($action == 'paydemands') { include "paydemands.php"; } ?>
		<? if ($action == 'messages') { include "_message_list.php"; } ?>
		<? if ($action == 'cashbox') { include "cashbox.php"; } ?>
		<? if ($action == 'client_list') { include "_main_client_list.php"; } ?>
		<? if ($action == 'zarplata') { include "_money_list.php"; } ?>
		<? if (($action == 'new') or ($action == 'redact')) { include "_workrow.php"; } ?>
		<? //if ($page == 'main_list') { include "main_list.php"; } ?>
		<? } ?>
		<?// if ($_SESSION['type'] == 'printer') {include "print_workplace.php"; } ?>


		<!--Переадресация в рабочую зону печатника-->
		<?
		if ($_SESSION['type'] == 'printer') {echo 'Привет, олкоголек';
			include "_printer_workplace.php";
		}
		?>

<?/* $time = microtime(true) - $start; echo $time; */?>

	</div>
</div>






<? }?>

</body>
</html>
