<? require_once  'dbconnect.php'; ?>
<? session_start(); ?>
<? require_once  './inc/global_functions.php'; ?>
<? require_once  './_oborot_functions.php'; ?>
<? require_once  './inc/cfg.php'; ?>
<? require_once  './inc/config_reader.php'; ?>
<? $action = $_GET['action']; ?>
<? $current_manager = $_SESSION['manager']; ?>
<!doctype html>
<? //массив ссылок для левых кнопок ( чтоб запустить циклом их чтоб подсветка меню адекватно работала)
        include 'inc/_menu_array.php'; ?>
<html>
<head>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
<SCRIPT type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></SCRIPT>
<link rel="stylesheet" href="jquery-ui.css">
<link rel="stylesheet" href="_workrow.css?<? echo rand();?>">
<link rel="stylesheet" type="text/css" href="truestyle.css?<? echo rand();?>" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;700&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./inc/jquery.timepicker.css" />
<SCRIPT type="text/javascript" src="./inc/jquery.timepicker.js"></SCRIPT>

        <!--стили и шрифты от final_design листа заказов-->
        <link rel="stylesheet" href="final_design/web_inc/__css.css?<? echo rand();?>>">
        <script language="javascript" src="final_design/web_inc/__scripts.js"></script>

    <!--<meta name = "viewport" content = "width=1200">-->
    <!--<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">-->
    <meta name="viewport" content="initial-scale=0.63, width=device-width">
<meta charset="utf-8">
    <!--JS autocomplete для странички с формированием заказа + еще какой то, непонять зачем -->
    <? include 'inc/_js_in_php.php'; ?>

<title><?
	for	($i = 0; $i <= 12; $i++) {
		if	(
			($_SERVER['REQUEST_URI'] == $hrefs[$i][0])
				or
			(((strpos($_SERVER['REQUEST_URI'],"showlist")) > 0) and ($i==2))
			) { /*echo $hrefs[$i][2];*/
		        echo "Список";}
								}
		if (isset($_GET['order_number'])) {echo $_GET['order_number'].' - РЕДАКТИРОВАНИЕ';}
?></title>
</head>



<body>

<div class="header" style=" <?
						   if (isset($_SESSION['manager'])) { echo 'display:none;';} ?> ">
<!--	<div style="margin-top: 5px;">
		<h2>admix </h2>
		<h3 style="font-size: 10px; color:rgba(0,56,123,1.00);">C</h3>
		<h3 style="font-size: 10px;color:rgba(65,0,65,1.00)">R</h3>
		<h3 style="font-size: 10px; color: rgba(44,50,0,1.00)">M</h3>
	</div>-->
		<? if (!isset($_SESSION['manager'])) {?>
		<div class="auth">
			<form action="login.php" method="post"><input type="text" name="login"><input type="password" name="password"><input type="submit"></form>
		</div>
		<? } else { echo("<a style='float:right; margin-right:30px; display:inline-block;' href=login.php?quit=1>выход</a>");}?>
</div>
<? if (isset($_SESSION['manager'])) {?>

<div class="left_container">
<?
for	($i = 0; $i <= 8; $i++) {

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

    <div align="center" class="" style="position: absolute; bottom: 20px; color: white; text-align: center; display: block; width: 100%;">
    <?
    $sql = "SELECT SUM(`contragent_dolg`) as smm FROM `contragents`";
    $arr = mysql_query($sql);
    $ddt = mysql_fetch_array($arr);

    $sql2 = "SELECT COUNT(1) as cnt FROM `order` WHERE `deleted`<>1";
    $arr2 = mysql_query($sql2);
    $ddt2 = mysql_fetch_array($arr2);
    ?>
        Общий долг:<br>
        <? echo $ddt['smm']; ?> <br><br>
        Не закрыто:<br>
        <? echo $ddt2['cnt']; ?> <br>

    </div>

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
/*    if (($_GET['action']<>'redact') and ($_GET['action']<>'new')) {*/
    if (isset($_GET['showlist']) or ($_GET['action'] == 'showlist')) {
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
		   include "final_design/index.php";?>
        <!--<div class="history_block" style="" id="historyBlock" onmouseenter="handlerOver();" onmouseleave = "handlerOut();">!-->
            <?
		} ?>
		<? if ($action == 'administrating') { include "adminpanel.php"; } ?>
		<? if ($action == 'rashodka') { include "_rashodka_forma.php"; } ?>
		<? if ($action == 'delete') { include "deleter.php"; } ?>
		<? if ($action == 'paydemands2') { include "paydemands.php"; } ?>
		<? if ($action == 'paydemands') { include "_new_paydemands.php"; } ?>
		<? if ($action == 'messages') { include "_message_list.php"; } ?>
        <? if ($action == 'calc') { include "_calc.php"; } ?>
		<? if ($action == 'cashbox') { include "cashbox.php"; } ?>
		<? if ($action == 'client_list') { include "_main_client_list.php"; } ?>
		<? if ($action == 'zarplata') { include "_money_list.php"; } ?>
		<? if ((($action == 'new') or ($action == 'redact')) and !isset($_GET['wrtest'])) { include "_workrow.php"; } ?>
        <? if ((($action == 'new') or ($action == 'redact')) and isset($_GET['wrtest'])) { include "_workrow_rebuild.php"; } ?>
        <? if (($action == 'qr_checker')) { include "_qr_checker.php"; } ?>

		<? //if ($page == 'main_list') { include "main_list.php"; } ?>
		<? } ?>
		<?// if ($_SESSION['type'] == 'printer') {include "print_workplace.php"; } ?>


		<!--Переадресация в рабочую зону печатника-->
		<?
		if ($_SESSION['type'] == 'printer') {echo 'Привет, олкоголек';
			include "_printer_workplace.php";
		}
		?>

<?/* $time = microtime(true) - $start; echo $time;
 ?&myorder=0&noready=1&showlist=&delivery=1
 !isset($_GET) or
 */
/*if (isset($_GET)) {echo "321321321"; } */
?>

	</div>
</div>






<? }?>

<!--    <div class="history_element" style="">
        Ю-10111: готов
    </div>
    <div class="history_element" style="">
        Ю-10111: оплачен
    </div>
    <div class="history_element" style="">
        Ю-10111: счет выставлен
    </div>-->
</div>
<!-- <script type="text/javascript">
    function handlerOver() {
        /*document.getElementById('historyBlock').style.width="500px";*/
    }

    function handlerOut() {
       /* document.getElementById('historyBlock').style.width="250px";*/
    }
</script>-->
<script>
    $('.timeselect').timepicker({
        timeFormat: 'HH:mm',
        interval: 30,
        minTime: '10',
        maxTime: '7:00pm',
/*        defaultTime: '10',*/
        startTime: '10:00',
        dynamic: true,
        dropdown: true,
        scrollbar: true
    });
</script>
<!--<script>
    function historyLoader() {
     $('#historyBlock').load('./_history_loader.php'); }
    console.log('pre');
    historyLoader();
    setInterval(historyLoader,3000);
    console.log('post');
/*
    console.log(contentPart);
    $("#historyBlock").prepend(contentPart);*/
/*function histLoader() {
    $.ajax({
        type: 'POST', //метод отправки запроса на сервер, пусть POST пофиг
        url: './_history_loader.php', //собственно как файл на сервере будет исполнен. в общем файл где есть функция my();
        data: {},//данные которые будут на сервер передаваться, в нашем случаи никаких, если нужно выполнить тупо еще раз функцию my без параметров.
        success: function (data) {//собственно тут и надо разруливать данные присланные с сервера. функция будет вызываться при успешном ответе сервера. У ней есть параметр - data. В общем это те данные что пришли с сервера. В нашем случаи пришел хтмл код типа ((<div id="my" name="my">hello world<input type="button" value="Go" onClick="onChange_(this)"/></div>)). осталось только вставить его в нужно место на странице и все. я пустой блок с id="inner_block", в него и засунем то что пришло с сервера.
            //$('#inner_block').append(data) // $('#inner_block') - находит на странице элемент с id=inner_block. append(data) - в конец этого элемента дописывает нашу data(данные пришедшие с сервера)

            /!*console.log(data);*!/
            $('#historyBlock').prepend(data);
        }
    });
}
setInterval(histLoader,2000);*/

</script>
!-->
<? //echo creataPathForApp("13420","Ю",$_SERVER['REMOTE_ADDR']);?>
</body>
</html>
