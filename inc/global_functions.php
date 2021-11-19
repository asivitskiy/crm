<?
function hist_writer ($hist_type,$hist_order,$hist_contragent,$hist_manager,$hist_order_amount) {
	$works_count_data =  mysql_fetch_array(mysql_query("SELECT COUNT(id) as `cid` FROM `works` WHERE `work_order_number` = '$hist_order'"));
	$works_count = $works_count_data['cid'];
	$current_date = date("YmdHi");
	switch ($hist_type) {
		case "order_add":
			$message = "Менеджер: ".$hist_manager." добавил заказ ".$hist_order.". Сумма заказа - ".$hist_order_amount.", количество работ ".$works_count;
			break;
		case "order_change":
			$message = "Менеджер: ".$hist_manager." изменил заказ ".$hist_order.". Сумма заказа - ".$hist_order_amount.", количество работ ".$works_count;
			break;
		case "order_delete":
			$message = "Менеджер: ".$hist_manager." удалил заказ ".$hist_order;
			break;
	}
	mysql_query("INSERT INTO `admix`.`hist` (
		`hist_date_in`,
		`hist_order_owner`,
		`hist_contragent_owner`,
		`hist_manager_owner`,
		`hist_message`,
		`hist_type`,
		`hist_order_summ`
	) VALUES (
		'$current_date',
		'$hist_order',
		'$hist_contragent',
		'$hist_manager',
		'$message',
		'$hist_type',
		'$hist_order_amount'
	)");
}

function ghost_history_writer ($type_of_object,$content_of_object) {

}
function add_history_message ($type_of_message,$text_of_message,$cur_manager,$cur_order_number) {
    $cur_date = date('YmdHi');
    mysql_query("INSERT INTO `admix`.`action_history` (
                                `history_type` ,
                                `history_text` ,
                                `history_order_manager` ,
                                `history_order_number` ,
                                `history_date`
                                )
                                VALUES (
                                '$type_of_message', 
                                '$text_of_message', 
                                '$cur_manager', 
                                '$cur_order_number', 
                                '$cur_date'
                                );");
}
function send_file($filename)
{
    if (file_exists($filename)) {
// чтобы избежать переполнение буфера
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filename));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit;
    }
}

function dig_to_y($digdig)
    {	if(!isset($digdig))
            return false;
        // вырезаем кусочек даты
        $result = substr($digdig,0,4);
        return $result;    }


function dig_to_m($digdig)
    {	if(!isset($digdig))
            return false;
        // вырезаем кусочек даты
        $result = substr($digdig,4,2);
        return $result;    }


function dig_to_d($digdig)
    {	if(!isset($digdig))
            return false;
        // вырезаем кусочек даты
        $result = substr($digdig,6,2);
        return $result;    }


function dig_to_h($digdig)
    {	if(!isset($digdig))
            return false;
        // вырезаем кусочек даты
        $result = substr($digdig,8,2);
        return $result;    }


function dig_to_minute($digdig)
    {	if(!isset($digdig))
            return false;
        // вырезаем кусочек даты
        $result = substr($digdig,10,2);
        return $result;    }

function name_cutter($digdig)
    {	if(!isset($digdig))
            return false;
        // вырезаем кусочек даты
        ///$digdig = str_replace("\\n","",$digdig);
	 		$f_sql = "SELECT * FROM `contragents` WHERE `id` = '$digdig'";
	 		$f_res = mysql_query($f_sql);
	 		$f_arr = mysql_fetch_array($f_res);
	 		$digdig = $f_arr['contragent_shortcut'];
	 	$str_start = stripos($digdig,"<Заказчик>") + 18;
	 	$str_end = stripos($digdig,"<Контакты>"); 
	 	
	 	$str_div = $str_end - $str_start;
        $result = substr($digdig,$str_start,$str_div);
	 
	 	return $result;    }

function contact_cutter($digdig)
    {	if(!isset($digdig))
            return false;
        // вырезаем кусочек даты
        ///$digdig = str_replace("\\n","",$digdig);
	 		$f_sql = "SELECT * FROM `contragents` WHERE `id` = '$digdig'";
	 		$f_res = mysql_query($f_sql);
	 		$f_arr = mysql_fetch_array($f_res);
	 		$digdig = $f_arr['contragent_shortcut'];
	 	$str_start = stripos($digdig,"<Контакты>") + 18;
	 	$str_end = stripos($digdig,"<Адрес доставки>"); 
	 	
	 	$str_div = $str_end - $str_start;
        $result = substr($digdig,$str_start,$str_div);
	 
	 	return $result;    }

function req_cutter($digdig)
    {	if(!isset($digdig))
            return false;
        // вырезаем кусочек даты
        ///$digdig = str_replace("\\n","",$digdig);
	 		$f_sql = "SELECT * FROM `contragents` WHERE `id` = '$digdig'";
	 		$f_res = mysql_query($f_sql);
	 		$f_arr = mysql_fetch_array($f_res);
	 		$digdig = $f_arr['contragent_shortcut'];
	 	$str_start = stripos($digdig,"<Реквизиты>") + 20;
	 	$str_end = strlen($digdig); 
	 	
	 	$str_div = $str_end - $str_start;
        $result = substr($digdig,$str_start,$str_div);
	 
	 	return $result;    }

function delivery_cutter($digdig)
    {	if(!isset($digdig))
            return false;
        // вырезаем кусочек даты
        ///$digdig = str_replace("\\n","",$digdig);
	 		$f_sql = "SELECT * FROM `contragents` WHERE `id` = '$digdig'";
	 		$f_res = mysql_query($f_sql);
	 		$f_arr = mysql_fetch_array($f_res);
	 		$digdig = $f_arr['contragent_shortcut'];
	 	$str_start = stripos($digdig,"<Адрес доставки>") + 29;
	 	$str_end = stripos($digdig,"<Реквизиты>"); 
	 	
	 	$str_div = $str_end - $str_start;
        $result = substr($digdig,$str_start,$str_div);
	 
	 	return $result;    }

/*echo date('YmdHi', strtotime('Mon this week')) . '—' . date('Ymd'.'9999', strtotime('Sun this week')) . '<br>';
echo date('YmdHi', strtotime('Mon next week')) . '—' . date('Ymd'.'9999', strtotime('Sun next week')) . '<br>'; */

function this_week_start() {
	$result = date('YmdHi', strtotime('Mon this week'));
return($result);
}

function this_week_end() {
	$result = date('Ymd'.'9999', strtotime('Sun this week'));
return($result);
}


function mail_body($nomerblanka) { ?>
<? ob_start(); ?>
<? ?>
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<style id="00100_Styles">
	body {
		font-family: Tahoma;
		font-weight: 800;
	}
	.c {
		font-family: Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", "monospace";
		height: 18px;
		
		margin-top: -5px;
    border: 1px solid #333; /* Рамка */
    display: inline-block;
		padding-top: 0px 0px 0px 0px;
    text-decoration: none; /* Убираем подчёркивание */
    color: #000; /* Цвет текста */
  }
   .c:hover {
    box-shadow: 0 0 5px rgba(0,0,0,0.3); /* Тень */
    background: linear-gradient(to bottom, #fcfff4, #e9e9ce); /* Градиент */
    color: #a00;
   }<!--table
	{mso-displayed-decimal-separator:"\,";
	mso-displayed-thousand-separator:" ";}
.xl656347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl666347
	{/*padding-top:1px;
	padding-right:1px;
	padding-left:1px;*/
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl676347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl686347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl696347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl706347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl716347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl726347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl736347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl746347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl756347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"dd\/mm\/yy\\ h\:mm\;\@";
	text-align:left;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl766347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl776347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"h\:mm\;\@";
	text-align:right;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl786347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"\[$-419\]dd\\ mmm\\ yy\;\@";
	text-align:center;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl796347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl806347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:0%;
	text-align:left;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl816347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	background:silver;
	mso-pattern:black none;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl826347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl836347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl846347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl856347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl866347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl876347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:red;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:Standard;
	text-align:right;
	vertical-align:middle;
	border:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl886347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:6.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:normal;}
.xl896347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl906347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl916347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl926347
	{/*padding-top:1px;
	padding-right:1px;
	padding-left:1px;*/
		padding-left: 5px;
		padding-top: 8px;
		padding-bottom: 8px;
	mso-ignore:padding;
	color:blue;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl936347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:Standard;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#CCFFCC;
	mso-pattern:black none;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl946347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:Standard;
	text-align:general;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#CCFFCC;
	mso-pattern:black none;
	white-space:normal;}
.xl956347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:Standard;
	text-align:general;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#CCFFCC;
	mso-pattern:black none;
	white-space:normal;}
.xl966347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl976347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl986347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:Standard;
	text-align:general;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:white;
	mso-pattern:black none;
	white-space:normal;}
.xl996347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;

	background:#CCFFCC;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1006347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:0000;
	text-align:left;
	vertical-align:bottom;
	background:#CCFFCC;
	mso-pattern:black none;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl1016347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	background:#CCFFCC;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1026347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	background:#CCFFCC;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1036347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"h\:mm\;\@";
	text-align:right;
	vertical-align:bottom;
	background:#CCFFCC;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1046347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:red;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:0%;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:white;
	mso-pattern:black none;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl1056347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:red;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:0%;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:white;
	mso-pattern:black none;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl1066347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt hairline windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl1076347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt hairline windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl1086347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"Short Date";
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt hairline windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl1096347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"Short Date";
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt hairline windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl1106347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl1116347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Cyr";
	mso-generic-font-family:auto;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1126347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Cyr";
	mso-generic-font-family:auto;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1136347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1146347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1156347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1166347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"Short Date";
	text-align:center;
	vertical-align:middle;
	border-top:.5pt hairline windowtext;
	border-right:none;
	border-bottom:.5pt hairline windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl1176347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"Short Date";
	text-align:center;
	vertical-align:middle;
	border-top:.5pt hairline windowtext;
	border-right:none;
	border-bottom:.5pt hairline windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl1186347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:6.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt hairline windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:normal;}
.xl1196347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:6.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt hairline windowtext;
	border-bottom:none;
	border-left:.5pt hairline windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:normal;}
.xl1206347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:6.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:.5pt hairline windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:normal;}
.xl1216347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:0%;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:normal;}
.xl1226347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:0%;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl1236347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:0%;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl1246347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"\[$-419\]dd\\ mmm\\ yy\;\@";
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl1256347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:blue;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:"\[$-419\]dd\\ mmm\\ yy\;\@";
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl1266347
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:0;
	mso-number-format:"dd\/mm\/yy\\ h\:mm\;\@";
	text-align:left;
	vertical-align:bottom;
	background:#CCFFCC;
	mso-pattern:black none;
	mso-protection:unlocked visible;
	white-space:nowrap;}
.xl1276347
	{/*padding-top:1px;
	padding-right:1px;
	padding-left:1px;*/
	padding-left: 6px;
	padding-top: 3px;
	padding-bottom: 3px;
	mso-ignore:padding;
	color:blue;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:204;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:white;
	mso-pattern:black none;
	mso-protection:unlocked visible;
	white-space:normal;}
	
	td {
		
		
	}
	
	

</style>
</head>
<title></title>
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
	
	$ip_sender_array = mysql_query("SELECT * FROM `ip_sender` LIMIT 1");
	$ip_sender_data = mysql_fetch_array($ip_sender_array);
	$current_ip = $ip_sender_data['ip'];
	
$number = $nomerblanka;
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
<div id="00100" align=center x:publishsource="Excel">



<table border=0 cellpadding=0 cellspacing=0 width=714 class=xl656347
 style='border-collapse:collapse;table-layout:fixed;width:538pt'>
 <col class=xl696347 width=114 style='mso-width-source:userset;mso-width-alt:
 4169;width:86pt'>
 <col class=xl696347 width=69 style='mso-width-source:userset;mso-width-alt:
 2523;width:52pt'>
 <col class=xl696347 width=42 style='mso-width-source:userset;mso-width-alt:
 1536;width:32pt'>
 <col class=xl696347 width=61 style='mso-width-source:userset;mso-width-alt:
 2230;width:46pt'>
 <col class=xl696347 width=46 style='mso-width-source:userset;mso-width-alt:
 1682;width:35pt'>
 <col class=xl696347 width=37 style='mso-width-source:userset;mso-width-alt:
 1353;width:28pt'>
 <col class=xl696347 width=112 style='mso-width-source:userset;mso-width-alt:
 4096;width:127pt'>
 <col class=xl696347 width=56 style='mso-width-source:userset;mso-width-alt:
 2048;width:42pt'>
 <col class=xl696347 width=75 style='mso-width-source:userset;mso-width-alt:
 2742;width:40pt'>
 <col class=xl696347 width=102 style='mso-width-source:userset;mso-width-alt:
 3730;width:50pt'>
 <tr class=xl686347 height=52 style='mso-height-source:userset;height:39.0pt'>
  <td height=52 class=xl996347 width=114 style='height:39.0pt;width:86pt'><a
  href=http://<? echo $current_ip; ?>:3030/?action=redact&order_number=<? echo $order_data['order_number']; ?> name="RANGE!A1:J15">ЗАКАЗ № <? echo $order_data['order_manager']; ?></a></td>
  <td class=xl1006347 width=69 style='width:52pt'><a href=http://<? echo $current_ip; ?>:3030/?action=redact&order_number=<? echo $order_data['order_number']; ?>></a><? echo $order_data['order_number']; ?></a></td>
  <td class=xl1016347 width=42 style='width:32pt'>от</td>
  <td colspan=3 class=xl1266347 width=144 style='width:109pt'><? echo(dig_to_d($datein)); ?>.<? echo(dig_to_m($datein)); ?>.<? echo(dig_to_y($datein)); ?> <? echo(dig_to_h($datein)); ?>:<? echo(dig_to_minute($datein)); ?></td>
  <td class=xl1026347 width=112 style='width:84pt'>&nbsp;</td>
  <td colspan=3 class=xl1246347 width=177 style='border-right:1.0pt solid black;
  width:133pt'>К <? echo(dig_to_d($datetoend)); ?>.<? echo(dig_to_m($datetoend)); ?>.<? echo(dig_to_y($datetoend)); ?> <? echo(dig_to_h($datetoend)); ?>:<? echo(dig_to_minute($datetoend)); ?></td>
 </tr>
 <tr class=xl686347 height=13 style='mso-height-source:userset;height:9.95pt'>
  <td height=13 class=xl716347 style='height:9.95pt'>&nbsp;</td>
  <td class=xl736347>&nbsp;</td>
  <td class=xl746347>&nbsp;</td>
  <td class=xl756347>&nbsp;</td>
  <td class=xl756347>&nbsp;</td>
  <td class=xl756347>&nbsp;</td>
  <td class=xl766347>&nbsp;</td>
  <td class=xl776347>&nbsp;</td>
  <td class=xl786347>&nbsp;</td>
  <td class=xl786347>&nbsp;</td>
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
  <td height=13 class=xl726347 style='height:9.95pt'>&nbsp;</td>
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
  <td colspan=3 height=42 class=xl1186347 width=225 style='border-right:1.0pt solid black; height:31.5pt;width:170pt'>Изделие</td>
  <td class=xl886347  >Фор-мат</td>
  <td class=xl886347  >Техника</td>
  <td class=xl886347  >Цвет</td>
  <td class=xl886347  >Материал</td>
  <td class=xl886347  >Цена</td>
  <td class=xl886347  >Кол-во</td>
  <td class=xl886347  >Сумма</td>
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
  width:170pt'><b style="font-size: 14"><? echo $works_data['work_name']; ?></b><br><font size="1"><? echo $works_data['work_description']; ?></font></td>
  <td class=xl926347  ><? echo $works_data['work_shir']; ?>*<? echo $works_data['work_vis'].'<br>'; 
  	if ($works_data['work_rasklad'] <> '[34320 / 13800][220x156 / 138x100]') { echo $works_data['work_rasklad'];}
  														?></td>
  <td class=xl926347  ><? echo $work_tech; ?></td>
  <td class=xl926347  ><? echo $works_data['work_color']; ?></td>
  <td class=xl926347  ><? echo $works_data['work_media']; ?><br><b><? echo $works_data['work_postprint']; ?></b></td>
  <td class=xl936347  ><? echo number_format(($works_data['work_price'])*1,2,',',''); ?></td>
  <td class=xl966347  ><? echo number_format(($works_data['work_count'])*1,0,',',''); ?></td>
  <td class=xl986347 align=right width=102 style='width:77pt'><? echo number_format(($works_data['work_count']*$works_data['work_price']),2,',',''); ?></td>
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
<!----------------------------->
</body>

</html>
	
	
<?

$output = ob_get_contents();ob_end_clean();
return($output);
}

//получение строки, состоящей из номеров бланков конкретного менеджера, по которым есть денежный долг по олате (не по готовности, а именно по деньгам)
function dolg_string($month_number,$manager) {

    $startof = '2020'.str_pad($month_number,2,'0', STR_PAD_LEFT).'000000';
    $endof = '2020'.str_pad($month_number+1,2,'0', STR_PAD_LEFT).'000000';
    $manager1 = explode(',',$manager);
    $manager2 = "'".implode("','",$manager1)."'";
    $sql = "SELECT order.order_number FROM `order` WHERE ((`date_in`>'$startof') and (`date_in`<'$endof') and (`order_manager` IN ($manager2)))";
    $array = mysql_query($sql);
    while ($data = mysql_fetch_array($array)) {
        $dyn_order = $data['order_number'];
        $works_sql = mysql_query(" SELECT SUM(works.work_price*works.work_count) as worksum FROM `works` WHERE `work_order_number` = '$dyn_order' ");
        $money_sql =  mysql_query(" SELECT SUM(money.summ) as moneysum FROM `money` WHERE `parent_order_number` = '$dyn_order' ");

        $works_data = mysql_fetch_array($works_sql);
        $money_data = mysql_fetch_array($money_sql);

        $delta = abs($works_data['worksum']*1-$money_data['moneysum']*1);

        if ($delta > 0.01) {
           /* echo $dyn_order.'- неоплачен - '.$works_data['worksum'].'<br>';*/
            $searchstring_dolg[] = $dyn_order;
        }

    }
    if (count($searchstring_dolg) < 1) {$clear_searchstring_dolg = 'err';} else {
        $clear_searchstring_dolg = implode(',',$searchstring_dolg);}

    return $clear_searchstring_dolg;
}

function month_name_full($month_number) {
    $names[1] = 'Январь';
    $names[2] = 'Февраль';
    $names[3] = 'Март';
    $names[4] = 'Апрель';
    $names[5] = 'Май';
    $names[6] = 'Июнь';
    $names[7] = 'Июль';
    $names[8] = 'Август';
    $names[9] = 'Сентябрь';
    $names[10] = 'Октябрь';
    $names[11] = 'Ноябрь';
    $names[12] = 'Декабрь';
    return $names[$month_number];
}
function month_name_short($month_number) {
    $names[1] = 'Янв';
    $names[2] = 'Фев';
    $names[3] = 'Мар';
    $names[4] = 'Апр';
    $names[5] = 'Май';
    $names[6] = 'Июн';
    $names[7] = 'Июл';
    $names[8] = 'Авг';
    $names[9] = 'Сен';
    $names[10] = 'Окт';
    $names[11] = 'Ноя';
    $names[12] = 'Дек';
    return $names[$month_number];
}
?>