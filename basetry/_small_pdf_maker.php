<?php
include 'dbconnect.php';
include './inc/global_functions.php';
$order_number = $_GET['order'];

$order_sql = "SELECT * FROM `order` WHERE (`order_number` = '$order_number') LIMIT 1";	
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
$works_sql = "SELECT * FROM `works` WHERE (`work_order_number`='$order_number')";	
$works_query  = mysql_query($works_sql);
// Optionally define the filesystem path to your system fonts
// otherwise tFPDF will use [path to tFPDF]/font/unifont/ directory
// define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");

require('tfpdf/tfpdf.php');

$pdf = new tFPDF( 'P', 'mm', 'A4' );
$pdf->SetMargins(5,5,5);
$pdf->AddPage();

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('DejaVuBold','','DejaVuSansCondensed-Bold.ttf',true);

//Load a UTF-8 string from a file and print it
//$txt = ('здарова ёпта adad dadadada das das dasda da da d');
//$pdf->Write(5,'здарова ёпта adad dadadada das das dasda da da d');
//$pdf->ln();
//$pdf->SetFillColor();
$pdf->SetFont('DejaVuBold','',14);
$pdf->SetFillColor(0,0,0);

//Номер бланка в черном прямоуголнике белым текстом
$pdf->SetTextColor(255,255,255);
$pdf->Cell(25,10,($order_data['order_manager'].'-'.$order_data['order_number']),1,0,'C',1);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('DejaVu','',10);
//дата приёма заказа
$pdf->Cell(15,10,(''),0,0,'L');
/*$pdf->Cell(50,10,($order_data['paymethod'].' : '.$order_data['paylist']),1,0,'C');*/
$pdf->Cell(50,10,($order_data['paymethod']),1,0,'C');
$pdf->Cell(5,10,(''),0,0,'L');
$txt_date_in = dig_to_d($datein).'.'.dig_to_m($datein).'.'.dig_to_y($datein).' '.dig_to_h($datein).':'.dig_to_minute($datein);
$pdf->Cell(50,10,$txt_date_in,1,0,'C');
//дата сдачи заказа
$pdf->Cell(5,10,(''),0,0,'L');
$txt_date_end = dig_to_d($datetoend).'.'.dig_to_m($datetoend).'.'.dig_to_y($datetoend).' '.dig_to_h($datetoend).':'.dig_to_minute($datetoend);
$pdf->Cell(50,10,$txt_date_end,1,0,'C');
$pdf->Ln();
$pdf->Ln(2);

//информация по клиенту
$pdf->SetFont('DejaVuBold','',12);
$pdf->Cell(30,7,('Клиент:'),0,0,'L');
$pdf->SetFont('DejaVu','',12);
$pdf->Cell(170,7,(' '.$contragent_data['name'].'  '),1,0,'L');
$pdf->Ln();
$pdf->SetFont('DejaVuBold','',12);
$pdf->Cell(30,7,('Допечать:'),0,0,'L');
$pdf->SetFont('DejaVu','',12);
$pdf->Cell(170,7,(' '.$order_data['preprinter']),1,0,'L');
$pdf->Ln();
$pdf->Ln(4);

$main_work_row_sql = "SELECT * FROM `works` WHERE `work_order_number` = '$order_number'";
$main_work_row_array = mysql_query($main_work_row_sql);
$order_amount = 0;
while ($main_work_row_data = mysql_fetch_array($main_work_row_array)) {
	//РАБОТА
		//................................................................
		// 1 строка
	$pdf->SetTextColor(0,0,0);
	$workstart_x = $pdf->GetX();
	$workstart_y = $pdf->GetY();

		$pdf->SetFillColor(210,210,210);
		//$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('DejaVuBold','',11);
	$tmp = $main_work_row_data['work_name'];
	$pdf->Cell(50,7,$tmp,1,0,'L',1);
		$pdf->SetTextColor(0,0,0);

	$pdf->SetFont('DejaVuBold','',9);
	$tmp = $main_work_row_data['work_shir'].'*'.$main_work_row_data['work_vis'];
	$pdf->Cell(16,7,$tmp,1,0,'C',1);
	$tmp = $main_work_row_data['work_tech'];
		$alias_array = mysql_query("SELECT * FROM `work_types` WHERE `name` = '$tmp'");
		$alias_data = mysql_fetch_array($alias_array);
		$alias = $alias_data['alias'];
	$pdf->Cell(16,7,$alias,1,0,'C',1);
	$tmp = $main_work_row_data['work_color'];
	$pdf->Cell(10,7,$tmp,1,0,'C',1);
	$tmp = $main_work_row_data['work_media'];
	$pdf->Cell(54,7,$tmp,1,0,'C',1);
	//$pdf->Cell(13,7,'24/21',1,0,'C');
	//$pdf->Cell(14,7,'1202',1,0,'C');
	$tmp = $main_work_row_data['work_price'];
	$tmp = number_format($tmp*1,'2','.','');
	$pdf->Cell(20,7,$tmp,1,0,'R',1);
	$tmp = $main_work_row_data['work_count'];
	$pdf->Cell(14,7,$tmp,1,0,'R',1);
	$tmp = $main_work_row_data['work_count']*$main_work_row_data['work_price'];
	$order_amount = $order_amount*1 + $tmp*1;
	$order_amount = number_format($order_amount,'2','.','');
	$tmp = number_format($tmp,'2','.','');
	/*$tmp = $tmp.'';*/
	$pdf->Cell(20,7,$tmp,1,0,'R',1);
	$pdf->Ln();
		//................................................................
		// 2 строка
	$pdf->SetTextColor(20,20,20);
		$rowheight = 4.5;
	$pdf->SetFont('DejaVu','',8);
	$tmp = $main_work_row_data['work_postprint'];
	$tmp = str_replace(array("\r\n", "\r", "\n"), '', $tmp);
	$pdf->Cell(66,$rowheight,$tmp,1,0);
	$pdf->SetFont('DejaVu','',8);
	//$pdf->Cell(16,5,'90*50',1,0,'C');
	/*$pdf->Cell(42,$rowheight,'[440 / 290]   '.'   [44x10 / 17x17]',1,0,'C');*/
	/*$pdf->Cell(42,$rowheight,'',1,0,'C');*/
	$tmp = $main_work_row_data['work_description'];
	$tmp = str_replace(array("\r\n", "\r", "\n"), '', $tmp);
	$pdf->Cell(134,$rowheight,$tmp,1,0,'C');
	//$pdf->Cell(13,7,'24/21',1,0,'C');
	//$pdf->Cell(15,5,'12024',1,0,'C');
	/*$pdf->Cell(54,$rowheight,'950.00 по сч. 4442-ХЫХЫХЫХ',1,0,'C');*/
	/*$pdf->Cell(54,$rowheight,'',1,0,'C');*/
		$workend_x = $pdf->GetX();
	//обводка работы (4 линии по координатам)
	$pdf->Ln();$pdf->Ln(0);
	/*$tmp = $main_work_row_data['work_description'];
	$tmp = str_replace(array("\r\n", "\r", "\n"), '', $tmp);
	$pdf->MultiCell(200,$rowheight,$tmp,'LBR');
	*/$workend_y = $pdf->GetY();
	$pdf->Line($workstart_x+0.2,$workstart_y+0.2,$workend_x-0.2,$workstart_y+0.2);
	$pdf->Line($workend_x-0.2,$workstart_y+0.2,$workend_x-0.2,$workend_y-0.2);
	$pdf->Line($workstart_x+0.2,$workend_y-0.2,$workend_x-0.2,$workend_y-0.2);
	$pdf->Line($workstart_x+0.2,$workend_y-0.2,$workstart_x+0.2,$workstart_y+0.2);
	$pdf->Ln(3);
	//Работа
}




$pdf->Ln(10);
$pdf->Cell(110,7,'',0);$pdf->Cell(50,7,'Итого по заказу',1,0,'R');$pdf->Cell(40,7,$order_amount,1,0,'R');$pdf->Ln();
/*$pdf->Cell(110,7,'',0);$pdf->Cell(50,7,'Технический расход',1,0,'R');$pdf->Cell(40,7,'3000.00',1,0,'R');$pdf->Ln();*/
//$pdf->Cell(110,7,'',0);$pdf->Cell(50,7,'Наценка',1,0,'R');$pdf->Cell(40,7,'4550.00',1,0,'R');$pdf->Ln();

//$pdf->Write(15,'adsdd');
$pdf->Ln();$pdf->Ln();
$pdf->MultiCell(150,6,$contragent_data['fullinfo'],0);
$filename = $order_number.'.pdf';
$pdf->Output($filename,'I');
?>
