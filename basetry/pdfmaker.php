<?

require_once( "fpdf/fpdf.php" ); 


// Начало конфигурации

$textColour = array( 0, 0, 0 );
$headerColour = array( 100, 100, 100 );
$tableHeaderTopTextColour = array( 255, 255, 255 );
$tableHeaderTopFillColour = array( 125, 152, 179 );
$tableHeaderTopProductTextColour = array( 0, 0, 0 );
$tableHeaderTopProductFillColour = array( 143, 173, 204 );
$tableHeaderLeftTextColour = array( 99, 42, 57 );
$tableHeaderLeftFillColour = array( 184, 207, 229 );
$tableBorderColour = array( 50, 50, 50 );
$tableRowFillColour = array( 213, 170, 170 );
$reportName = "2009 gggggg Report";
$reportNameYPos = 160;
$logoFile = "background28.jpg";
$logoXPos = 50;
$logoYPos = 108;
$logoWidth = 110;
$columnLabels = array( "Q1", "Q2", "Q3", "Q4" );
$rowLabels = array( "SupaWidget", "WonderWidget", "MegaWidget", "HyperWidget" );
$chartXPos = 20;
$chartYPos = 250;
$chartWidth = 160;
$chartHeight = 80;
$chartXLabel = "Product";
$chartYLabel = "2009 Sales";
$chartYStep = 20000;

$chartColours = array(
                  array( 255, 100, 100 ),
                  array( 100, 255, 100 ),
                  array( 100, 100, 255 ),
                  array( 255, 255, 100 ),
                );

$data = array(
          array( 9940, 10100, 9490, 11730 ),
          array( 19310, 21140, 20560, 22590 ),
          array( 25110, 26260, 25210, 28370 ),
          array( 27650, 24550, 30040, 31980 ),
        );

// Конец конфигурации

/**
  Создаем титульную страницу
**/

$pdf = new FPDF( 'P', 'mm', 'A4' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
//$pdf->AddPage();

// Логотип
//$pdf->Image( $logoFile, $logoXPos, $logoYPos, $logoWidth );

// Название отчета
//$pdf->SetFont( 'Arial', 'B', 24 );

//$pdf->Ln( $reportNameYPos );

//$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
//cell ()
$pdf->AddPage();
$pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
$pdf->SetFont( 'Arial', '', 14 );
$pdf->Cell( 0, 15, ('ЛАЛАЛАЛА'), 1, 0, 'L' );

$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'Arial', '', 20 );
$pdf->Write( 19, "sfdsfsfавыавыаыва" );

$pdf->Ln( 16 );
$pdf->SetFont( 'Arial', '', 12 );
$pdf->Write( 6, "Despite the economic downturn, WidgetCo had a strong year. Sales of the HyperWidget in particular exceeded expectations. The fourth quarter was generally the best performing; this was most likely due to our increased ad spend in Q3." );
$pdf->Ln( 12 );
$pdf->Write( 6, "2010 is expected to see increased sales growth as we expand into other countries." );

$pdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );
$pdf->Ln( 15 );

// Создаем строку заголовков таблицы
$pdf->SetFont( 'Arial', 'B', 15 );

// Ячейка "PRODUCT"
$pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
$pdf->Cell( 46, 12, " PRODUCT", 1, 0, 'L', true );

// Остальные ячейки заголовков
$pdf->SetTextColor( $tableHeaderTopTextColour[0], $tableHeaderTopTextColour[1], $tableHeaderTopTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopFillColour[0], $tableHeaderTopFillColour[1], $tableHeaderTopFillColour[2] );

for ( $i=0; $i<count($columnLabels); $i++ ) {
  $pdf->Cell( 36, 12, $columnLabels[$i], 1, 0, 'C', true );
}

$pdf->Ln( 12 );


// Создаем строки с данными

$fill = false;
$row = 0;

foreach ( $data as $dataRow ) {

  // Создаем левую ячейку с заголовком строки
  $pdf->SetFont( 'Arial', 'B', 15 );
  $pdf->SetTextColor( $tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2] );
  $pdf->SetFillColor( $tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2] );
  $pdf->Cell( 46, 12, " " . $rowLabels[$row], 1, 0, 'L', $fill );

  // Создаем ячейки с данными
  $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
  $pdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
  $pdf->SetFont( 'Arial', '', 15 );

  for ( $i=0; $i<count($columnLabels); $i++ ) {
    $pdf->Cell( 36, 12, ( '$' . number_format( $dataRow[$i] ) ), 1, 0, 'C', $fill );
  }

  $row++;
  $fill = !$fill;
  $pdf->Ln( 12 );
}

/***
  Выводим PDF
***/
//unlink("wreport.pdf");
//usleep(10000);
$pdf->Output( "wreport2.pdf", "F" );

?>
</body>
</html>