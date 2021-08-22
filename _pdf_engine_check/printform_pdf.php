<? $start = microtime(true); ?>
<? include '../dbconnect.php'; ?>
<? session_start(); ?>

<? include '../inc/global_functions.php'; ?>
<? include '../inc/cfg.php'; ?>
<? $action = $_GET['action']; ?>

<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">

</head>

<title><? echo $_GET['number'].'  Печать'; ?></title>
<!--<link rel="stylesheet" href="printform_pdf.css">-->
<style>
    td {
        padding: 3px!important;
    }
    @page { margin: 10px; }
    body { margin: 10px; }
    <? include "./printform_pdf.css"; ?>
</style>
<body>

<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--Следующие сведения были подготовлены мастером публикации веб-страниц
Microsoft Excel.-->
<!--При повторной публикации этого документа из Excel все сведения между тегами
DIV будут заменены.-->
<!----------------------------->
<!--НАЧАЛО ФРАГМЕНТА ПУБЛИКАЦИИ МАСТЕРА ВЕБ-СТРАНИЦ EXCEL -->
<!----------------------------->
<? 
//достаём данные заказа по менеджеру и номеру бланка

$number = $_GET['number'];
$order_sql = "SELECT * FROM `order` WHERE ((`order_number` = '$number')) LIMIT 1";	

$order_query = mysql_query($order_sql);
$order_data = mysql_fetch_array($order_query);
$datetoend = $order_data['datetoend'];
$datein = $order_data['date_in'];
//используем номер айди клиента для получения его данных
$contragent_id = $order_data['contragent'];
$contragent_sql = "SELECT * FROM `contragents` WHERE ((`id`='$contragent_id')) LIMIT 1";	
$contragent_query = mysql_query($contragent_sql);
$contragent_data = mysql_fetch_array($contragent_query);
//делаем запрос к базе работ по заказу, но не разбираем его, разбирать будем уже конкретно в таблице
$works_sql = "SELECT * FROM `works` WHERE ((`work_order_number`='$number'))";	
$works_query  = mysql_query($works_sql);
	
	?>

<table border=0 cellpadding=0 cellspacing=0 width=714 class=xl656347
 style='border-collapse:collapse;width:300px'>

 <tr class=xl686347 height=52 style='mso-height-source:userset;height:39.0pt'>
  <td height=52 class=xl996347 width=114 style='height:39.0pt;width:86pt'><a
  name="RANGE!A1:J15">ЗАКАЗ № <? echo $order_data['order_manager']; ?></a></td>
  <td class=xl1006347 width=69 style='width:52pt'><? echo $order_data['order_number']; ?></td>
  <td class=xl1016347 width=42 style='width:32pt'>от</td>
  <td colspan=3 class=xl1266347 width=144 style='width:109pt'><? echo(dig_to_d($datein)); ?>.<? echo(dig_to_m($datein)); ?>.<? echo(dig_to_y($datein)); ?> <? echo(dig_to_h($datein)); ?>:<? echo(dig_to_minute($datein)); ?></td>
  <td class=xl1026347 width=112 style='width:84pt'>&nbsp;</td>
  <td colspan=3 class=xl1246347 width=177 style='border-right:1.0pt solid black;
  width:133pt'>К <? echo(dig_to_d($datetoend)); ?>.<? echo(dig_to_m($datetoend)); ?>.<? echo(dig_to_y($datetoend)); ?> <? echo(dig_to_h($datetoend)); ?>:<? echo(dig_to_minute($datetoend)); ?></td>
 </tr>

 <tr class=xl676347 height=25 style='mso-height-source:userset;height:18.75pt'>
  <td height=25 class=xl726347 style='height:18.75pt'>Клиент</td>
  <td colspan=9 class=xl1216347 width=600 style='width:452pt'><? echo($contragent_data['name']); ?> / <? echo($contragent_data['contacts']); ?></td>
 </tr>
 <tr class=xl676347 height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl726347 style='height:18.0pt'>Форма расчета</td>
  <td colspan=9 class=xl1236347><? echo($order_data['paymethod']); ?> <? echo($order_data['paylist']); ?></td>
 </tr>
 <tr class=xl676347 height=13 style='mso-height-source:userset;height:9.95pt'>
     <td  colspan="8"><div style="display: inline-block; text-wrap: normal; width: 650px!important;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid culpa deleniti dolore doloremque eius facere itaque, iusto nam non obcaecati officiis pariatur perferendis provident quo ratione rerum vitae voluptate voluptatum?</div></td>
  <td class=xl806347>&nbsp;</td>
  <td class=xl806347>&nbsp;</td>
  <td class=xl806347>&nbsp;</td>
  <td class=xl806347>&nbsp;</td>
  <td class=xl806347>&nbsp;</td>
  <td class=xl796347>&nbsp;</td>
  <td class=xl816347>&nbsp;</td>
  <td class=xl816347>&nbsp;</td>
  <td class=xl796347>&nbsp;</td>
 </tr>
 <tr class=xl676347 height=42 style='mso-height-source:userset;height:31.5pt'>
  <td colspan=3 height=42 class=xl1186347  style="width: 50px">Изделие</td>
  <td class=xl886347 style="width: 50px">Формат</td>
  <td class=xl886347 style="width: 50px">Техника</td>
  <td class=xl886347 style="width: 50px">Цвет</td>
  <td class=xl886347 style="width: 50px">Материал</td>
  <td class=xl886347 style="width: 50px">Цена</td>
  <td class=xl886347 style="width: 50px">Кол-во</td>
  <td class=xl886347 style="width: 50px">Сумма</td>
 </tr>
 
 <!--
 <tr class=xl666347 height=92 style='mso-height-source:userset;height:69.0pt'>
  <td colspan=3 height=92 class=xl1276347 width=225 style='border-right:.5pt solid black;
  height:69.0pt;width:170pt'>Распечатка А4 ОДНОСТОРОННЯЯ (4 файла), не сшивать!</td>
  <td class=xl926347 width=61 style='border-left:none;width:46pt'>210*297</td>
  <td class=xl926347 width=46 style='border-left:none;width:35pt'>ксерокс</td>
  <td class=xl926347 width=37 style='border-left:none;width:28pt'>4+0</td>
  <td class=xl926347 width=112 style='border-left:none;width:84pt'>300гр, 80 гр</td>
  <td class=xl936347 width=56 style='border-left:none;width:42pt'>1 539,00</td>
  <td class=xl966347 width=75 style='border-left:none;width:56pt'>1</td>
  <td class=xl986347 align=right width=102 style='width:77pt'>1 539,00</td>
 </tr>
 !-->
<? 
$order_summ = 0;
while ($works_data = mysql_fetch_array($works_query)) {	
//ищем синоним изготовления, чтобы не палить его в бланке<br>
	$ssss = $works_data['work_tech'];
	$work_type_alias_data = mysql_fetch_array(mysql_query("SELECT `alias` FROM `work_types` WHERE `name` = '$ssss'"));
	$work_tech = $work_type_alias_data['alias'];
?> 

  <tr class=xl666347 >
  <td colspan=3 class=xl1276347 width=225 style='border-right:.5pt solid black;
  width:170pt'><b style="font-size: 14px"><? echo $works_data['work_name']; ?></b><br><font size="1"><? echo $works_data['work_description']; ?></font></td>
  <td class=xl926347  ><? echo $works_data['work_shir']; ?>*<? echo $works_data['work_vis'].'<br>'; 
  	if ($works_data['work_rasklad'] <> '[34320 / 13800][220x156 / 138x100]') { echo $works_data['work_rasklad'];}
  														?></td>
  <td class=xl926347  ><? echo $work_tech; ?></td>
  <td class=xl926347  ><? echo $works_data['work_color']; ?></td>
  <td class=xl926347  ><? echo $works_data['work_media']; ?><br><b><? echo $works_data['work_postprint']; ?></b></td>
  <td class=xl936347  ><? echo number_format(($works_data['work_price'])*1,2,',',''); ?></td>
  <td class=xl966347  ><? echo number_format(($works_data['work_count'])*1,0,',',''); ?></td>
  <td class=xl986347 style='width:25pt; text-align: right;'><? echo number_format(($works_data['work_count']*$works_data['work_price']),2,',',''); ?></td>
 </tr>
 
 <? $order_summ = $order_summ + $works_data['work_count']*$works_data['work_price']; ?>
 <? } ?>
 <tr class=xl706347 height=29 style='mso-height-source:userset;height:21.95pt'>
  <td height=29 class=xl896347 style='height:21.95pt'>&nbsp;</td>
  <td class=xl906347>СКИДКА</td>
  <td class=xl906347></td>
  <td colspan=2 class=xl1046347 style='border-right:1.0pt solid black'>&nbsp;</td>
  <td class=xl916347>&nbsp;</td>
  
  <td class=xl906347 colspan="2">ВСЕГО К ОПЛАТЕ</td>
  <td class=xl906347>&nbsp;</td>
  <td class=xl876347 width=102 style='border-top:none;width:77pt'><? echo number_format(($order_summ),2,',',''); ?></td>
 </tr>
 <tr height=0 style='display:none;mso-height-source:userset;mso-height-alt:
  285'>
  <td class=xl826347>&nbsp;</td>
  <td class=xl836347>&nbsp;</td>
  <td class=xl836347>&nbsp;</td>
  <td class=xl836347>&nbsp;</td>
  <td class=xl836347>&nbsp;</td>
  <td class=xl836347>&nbsp;</td>
  <td class=xl836347>&nbsp;</td>
  <td class=xl836347>&nbsp;</td>
  <td class=xl836347>&nbsp;</td>
  <td class=xl836347>&nbsp;</td>
 </tr>
 <tr height=0 style='display:none;mso-height-source:userset;mso-height-alt:
  480'>
  <td colspan=10 class=xl1086347 width=714 style='width:538pt'>&nbsp;</td>
 </tr>
 <tr height=0 style='display:none;mso-height-source:userset;mso-height-alt:
  480'>
  <td colspan=10 class=xl1166347 width=714 style='width:538pt'>&nbsp;</td>
 </tr>
 <tr height=0 style='display:none;mso-height-source:userset;mso-height-alt:
  480'>
  <td colspan=10 class=xl1066347 width=714 style='width:538pt'>&nbsp;</td>
 </tr>
 <tr class=xl706347 height=27 style='mso-height-source:userset;height:20.25pt'>
  <td height=27 class=xl846347 style='height:20.25pt'>Заказ выписал</td>
  <td colspan=3 class=xl1136347 style='border-right:.5pt solid black'>&nbsp;</td>
  <td class=xl856347></td>
  <td class=xl856347></td>
  <td class=xl856347 colspan="2">Подпись печатника</td>
  <td class=xl866347></td>
  <td class=xl976347>&nbsp;</td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=114 style='width:86pt'></td>
  <td width=69 style='width:52pt'></td>
  <td width=42 style='width:32pt'></td>
  <td width=61 style='width:46pt'></td>
  <td width=46 style='width:35pt'></td>
  <td width=37 style='width:28pt'></td>
  <td width=112 style='width:84pt'></td>
  <td width=56 style='width:42pt'></td>
  <td width=75 style='width:56pt'></td>
  <td width=102 style='width:77pt'></td>
 </tr>
 <![endif]>
 
 </table>
	<div style="width: 650px;">
<h3 align="left">Заметки к заказу</h3>	
	<div align="left" style="font-weight: 400; font-size: 12px;">
<?
$msg_sql = "SELECT * FROM `order_messages` WHERE ((`order_number`='$number')) ORDER BY `id` DESC";
$msg_array = mysql_query($msg_sql);
while ($msg_data = mysql_fetch_array($msg_array)) {
	echo "<b>".dig_to_d($msg_data['date_in_message'])."-".dig_to_m($msg_data['date_in_message'])."-".dig_to_y($msg_data['date_in_message'])."[".dig_to_h($msg_data['date_in_message']).":".dig_to_d($msg_data['date_in_message'])."]</b>";
	echo("<br>");
	echo($msg_data['message']."<br>");
	
	
} ?></div>
	</div>
</div>


<!----------------------------->
<!--КОНЕЦ ФРАГМЕНТА ПУБЛИКАЦИИ МАСТЕРА ВЕБ-СТРАНИЦ EXCEL-->
<!-----------------------------><?php
/*echo date("YmdHi");*/?>
</body>

</html>
