<? 	$start = microtime(true);
require_once  'dbconnect.php'; ?>
<? session_start(); ?>
<? require_once  './inc/global_functions.php'; ?>
<? require_once  './_oborot_functions.php'; ?>
<? require_once  './inc/cfg.php'; ?>
<? $action = $_GET['action']; ?>
<? $current_manager = $_SESSION['manager'];
/*
	$ip_sender_array = mysql_query("SELECT * FROM `ip_sender` LIMIT 1");
	$ip_sender_data = mysql_fetch_array($ip_sender_array);
		if (((date("YmdHi")*1) - ($ip_sender_data['last_try']*1)) >= 1) {
			$ip = file_get_contents('https://api.ipify.org');
			echo $ip;
			echo $ip_sender_data['ip'];
			$last_try = date("YmdHi");
			mysql_query("UPDATE `ip_sender` SET `ip`='$ip',`last_try`='$last_try' WHERE (`id`=1)");
			if ($ip <> $ip_sender_data['ip']) { 
				
				
					$to  = $ip_sender_data['mailed'] ;
					$subject = "Обновление IP адреса";
					$message = "Текущий IP-адрес:".$ip."<br>Ссылка для доступа в базу: <a href=http://".$ip.":3030>База</a>";
					$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
					$headers .= "From: AdmixCRM <admixcrm@gmail.com>\r\n";
					mail($to, $subject, $message, $headers);

			
			
			}
		}
			
*/

?>


<!doctype html>
<? //массив ссылок для левых кнопок ( чтоб запустить циклом их чтоб подсветка меню адекватно работала)
	$hrefs[0][0] = "/?action=new";	
	$hrefs[0][1] = "img/icons/file, data, document, interface, paper.png";	
	$hrefs[0][2] = "Новый заказ";	
	
	$hrefs[1][0] = "/?action=showlist";	
	$hrefs[1][1] = "img/icons/newspaper, article, headline, journal, news.png";	
	$hrefs[1][2] = "Все заказы";	
	
	$hrefs[2][0] = "/?action=showlist&filter=manager&argument=".$_SESSION['manager'];	
	$hrefs[2][1] = "img/icons/menu, more, detail, list, interface.png";	
	$hrefs[2][2] = "Мои заказы";	
	
	$hrefs[3][0] = "/?action=cashbox&date=".date("Y")."-".date("m")."-".(date("d"));	
	$hrefs[3][1] = "img/icons/money, dollar, cash, finance, payment.png";	
	$hrefs[3][2] = "Касса";	
	
	$hrefs[4][0] = "/?action=client_list";	
	$hrefs[4][1] = "img/icons/user, account, profile, avatar, person.png";	
	$hrefs[4][2] = "Клиенты";	
	
	$hrefs[5][0] = "/?action=showlist&filter=archive";	
	$hrefs[5][1] = "img/icons/drawer, archive, files, documents, office.png";	
	$hrefs[5][2] = "Мой архив";	
	
	$hrefs[6][0] = "/?action=showlist&filter=archiveoverall";	
	$hrefs[6][1] = "img/icons/database, server, storage, data center, hosting.png";	
	$hrefs[6][2] = "Весь архив";	
	
	$hrefs[7][0] = "/?action=templates";	
	$hrefs[7][1] = "img/icons/code, coding, html, css, programming.png";	
	$hrefs[7][2] = "Шаблоны";
	
	$hrefs[10][0] = "/?action=administrating&filter=startscreen";	
	$hrefs[10][1] = "img/icons/bug, virus, insect, malware, pest.png";	
	$hrefs[10][2] = "Админка";

	$hrefs[8][0] = "/?action=paydemands";	
	$hrefs[8][1] = "img/icons/refresh, reload, repeat, sync, rotate.png";	
	$hrefs[8][2] = "Поставщики";

	$hrefs[9][0] = "/?action=showlist&filter=delivery";	
	$hrefs[9][1] = "img/icons/send, paper plane, sent, interface, message.png";	
	$hrefs[9][2] = "Доставка";	

	$hrefs[11][0] = "/?action=showlist&filter=fulllist";	
	$hrefs[11][1] = "img/icons/computer, screen, display, monitor, desktop.png";	
	$hrefs[11][2] = "Полный список";	
	
	
	/*echo $current_manager;*/
	$message_query = "SELECT * FROM `messages_chains` WHERE (
																(
																	(`responders` LIKE '%$current_manager%') or (`responders` = 'all')
																) 
																
																and 
																
																(`flag_of_chain_close` = 0)
															)";
	$message_array = mysql_query($message_query);
	$a = mysql_num_rows($message_array);
	$newmessage_flag_sql = "SELECT * FROM `messages_chains` 
							LEFT JOIN `users` ON users.word='$current_manager'
							
							WHERE users.last_visit_messages<messages_chains.date_of_chain_update";
	$newmessage_flag_array = mysql_query($newmessage_flag_sql);
	
/*	echo mysql_num_rows($message_array);*/
	if (mysql_num_rows($newmessage_flag_array)==0) {
	$hrefs[12][0] = "/?action=messages&step=start_page";	
	$hrefs[12][1] = "img/icons/chat, comment, message, talk, speak.png";	
	$hrefs[12][2] = "Сообщения(".$a.")";	
	}

	if (mysql_num_rows($newmessage_flag_array)>0) {
	$hrefs[12][0] = "/?action=messages&step=start_page";	
	$hrefs[12][1] = "img/icons/active_message.png";	
	$hrefs[12][2] = "Сообщения(".$a.")";	
	}
	
	
?>
<html>
<head>


<SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
<SCRIPT type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></SCRIPT>
<link rel="stylesheet" href="jquery-ui.css">
<link rel="stylesheet" href="_workrow.css">
<link rel="stylesheet" type="text/css" href="truestyle.css" />

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;700&display=swap" rel="stylesheet">


<meta charset="utf-8">
<script> 
//$( 
function autocompleteRun() { 
var availableTags = [ 
<? 
$query_4 = "SELECT `workname` FROM `worknames`"; 
$res_4 = mysql_query($query_4); 
while($row_4 = mysql_fetch_array($res_4)) 
{?> "<? echo mb_ereg_replace('[\n]', '\n', $row_4['workname']);?>", 
<? } ?> ""]; 
$( ".tags2" ).autocomplete({ 
source: availableTags 
}); 
} 
$(document).ready(function(){ 
autocompleteRun(); 
}); 
</script>
<script>
    function disp(form) {
        if (form.style.display == "none") {
            form.style.display = "";
        } else {
            form.style.display = "none";
        }
    }
    </script>
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
for	($i = 0; $i <= 12; $i++) { 
	
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
		
		
		<? //неизвестно че это, скорее всего вывод сообщения о обновлении заказа, которое нафиг по факту не нужно ?>
		<? //if (($_SESSION['changeorder_complete']) == 2) 
						//{ ?> 
						<!--<div style="background-color: #9BD892; text-align: center; padding: 0px auto; font-size: 16px; font-weight: 650; display: inline-block; width: 200px; height: 30px; border-radius: 4px;">Заказ обновлён!</div>
		!-->
			
						  			  <?// }$_SESSION['changeorder_complete'] = 0;?>
	

	
	
	
		<!--<div class="top_nav_block">
			<? //include "_order_sorter_buttons.php"; ?>
		</div>!-->
	
	<div class="main_content_block">
	<?
	$dolg_opl_data = mysql_fetch_array(mysql_query("SELECT SUM(money.summ) `opl` FROM `money`"));
	$dolg_neopl_data = mysql_fetch_array(mysql_query("SELECT SUM(works.work_price * works.work_count) `neopl` FROM `works`"));
	$dolg = $dolg_neopl_data['neopl'] - $dolg_opl_data['opl'];
	/*echo "<font size=2>Сумарная задолжность: ".$dolg."</font>";	*/


////////////////////////////////////////////////////////////////////////////////////////////////////
/// //ДОЛГИ
////////////////////////////////////////////////////////////////////////////////////////////////////
//                echo '<table class="dolg-table">';
//               echo '<tr>';
//                    echo '<td>';
//                    echo 'Долги >>  ';
//                    echo '</td>';
//                    echo '<td>';
//                    echo '</td>';
//                    for ($i = 01; $i <= 12; $i++) {
//                        echo '<td>';
//                            if ($current_manager == 'Марина') {$mngs = 'Ю,Н,А';} else {$mngs = $current_manager;}
//                        echo '<a target=_blank href=index.php?action=showlist&filter=dolg&mnth='.$i.'&mng='.$mngs.'>';
//                        echo ''; echo month_name_short($i); echo '>';
//                        $month_formatted_start =  str_pad($i,2,'0', STR_PAD_LEFT);
//                        $month_formatted_end =  str_pad($i+1,2,'0', STR_PAD_LEFT);
//                        $period_start =  '2020'.$month_formatted_start.'000000';
//                        $period_end =  '2020'.$month_formatted_end.'000000';
//
//                           $obsh_paid_manager[$i] = obsh_paid_manager($period_start,$period_end,$mngs);
//                           $obsh_oborot_manager[$i] = obsh_oborot_manager($period_start,$period_end,$mngs);
//                           echo number_format(($obsh_oborot_manager[$i] - $obsh_paid_manager[$i]), 2, '.', ' ');
//                        echo '</a>';
//                        echo '</td>';
//                    }
//                echo '</tr>';
//                echo '</table>';
//    ?>
		<!--<a href="http://192.168.1.221/dynamic_load/">Новая база</a><br>-->

		<?//Тут, вероятно будет ограничение доступа работать (хотя не факт) ?>
	
		<? if (($_SESSION['type'] == 'manager') or ($_SESSION['type'] == 'preprinter') or ($_SESSION['type'] == 'admin')) { ?>
		<? ////////////////////////////////?>
		<? if ($action == 'showlist') { 
			/*include "page_sorter.php";*/
			include "main_list.php";
		/*   include "final_design/index.php";*/
		} ?>
		<? if ($action == 'administrating') { include "adminpanel.php"; } ?>
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
