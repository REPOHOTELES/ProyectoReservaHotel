<?php
    require '../vendor/autoload.php';
    require '../../includes/database.php';
    require '../../includes/reportSpreadsheet.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\RichText\RichText;
    use PhpOffice\PhpSpreadsheet\Style\Color;
    use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
    use PhpOffice\PhpSpreadsheet\Shared\Date;
    use PhpOffice\PhpSpreadsheet\Calculation\DateTime;
    use PhpOffice\PhpSpreadsheet\Style\Border;

    
    if (isset($_POST['dateReport'])) {
        $timestamp = strtotime($_POST['dateReport']); 
        $desiredMonth=date('m',$timestamp);
        $desiredYear=date('Y',$timestamp);
   }
    
    $rs = new ReportSpreadsheet();

    //Numero de días de la fecha que se quiere averiguar
    $cantDays = cal_days_in_month(CAL_GREGORIAN, $desiredMonth, $desiredYear);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $database = new Database();

    $spreadsheet->getDefaultStyle()
        ->getFont()
        ->setName('Arial')
        ->setSize(11);

 
    // Se le da borde delgado a las tablas que lo requieran   
    $rs->createBorder('A1:S35', $spreadsheet);
    $rs->createBorder('U2:Z3', $spreadsheet);
    $rs->createBorder('U6:X9', $spreadsheet);
    $rs->createBorder('U11:AF13', $spreadsheet);
    $rs->createBorder('U15:AF17', $spreadsheet);
    $rs->createBorder('U19:AB21', $spreadsheet);
    $rs->createBorder('U23:X25', $spreadsheet);

    //Se asigna un color de fondo al rango de celdas correspondientes
    $rs->setBackgroundColor('U6:X6', '9bc2e6', $spreadsheet);
    $rs->setBackgroundColor('U7:X7', '00ff00', $spreadsheet);
    $rs->setBackgroundColor('U8:X8', 'ffc000', $spreadsheet);
    $rs->setBackgroundColor('U9:X9', 'ff33cc', $spreadsheet);

       

    //Alinear contenido de celda
    $spreadsheet->getActiveSheet()->getStyle('A1:AF100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('A1:AF100')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


    $spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
    $richText = new RichText();
    $payable = $richText->createTextRun('HOTEL ARISTO');
    $payable->getFont()->setBold(true);
    $payable->getFont()->setSize(20);
    $payable->getFont()->setName('Arial');
    $payable->getFont()->setColor( new Color(Color::COLOR_BLUE));
    $spreadsheet->getActiveSheet()->getCell('A1')->setValue($richText);

    
    
    $spreadsheet->getActiveSheet()
        ->getCell('A1')
        ->getHyperlink()
        ->setUrl('../../login')
        ->setTooltip('Ir a página web');

    //Unir celdas
    $spreadsheet->getActiveSheet()->mergeCells("A1:S1");

    //Agregar estilo al fondo
    $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
    
    
    //Ancho de celda
    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
    $spreadsheet->getActiveSheet()->getRowDimension(2)->setRowHeight(48);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);


    $box = ord('C');
    for ($i = 1; $i <= 17; $i++) {
        $spreadsheet->getActiveSheet()->getColumnDimension(chr($box))->setWidth(12);
        $box++;
    }

    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(14);
    $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(12);
    $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(14);
    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(14);
    
    $box = ord('A');
    for ($i = 1; $i <= 6; $i++) {
        $spreadsheet->getActiveSheet()->getColumnDimension('A'.chr($box))->setWidth(12);
        $box++;
    }

    
    //Ajustar texto en todas las columnas utilizadas
    $spreadsheet->getActiveSheet()->getStyle('A1:AF100')->getAlignment()->setWrapText(true);
    
    // Texto de encabezado
    $spreadsheet->getActiveSheet()->getStyle('A2:Z2')->getFont()->setBold(true);
    $spreadsheet->getActiveSheet()->setCellValue('A2', "Venta por día");
    $spreadsheet->getActiveSheet()->setCellValue('B2', "Días");
    
    
    $rs->fullRoom('C', 2, 201, 17, $spreadsheet);
    
    $rs->changeDollarFormat('X6:X9', $spreadsheet);
    $spreadsheet->getActiveSheet()->setCellValue('X6', $rs->getTotalPaymentMethod('E', $desiredMonth, $desiredYear, $spreadsheet));
    $spreadsheet->getActiveSheet()->setCellValue('X7', $rs->getTotalPaymentMethod('T', $desiredMonth, $desiredYear, $spreadsheet));
    $spreadsheet->getActiveSheet()->setCellValue('X8', $rs->getTotalPaymentMethod('C', $desiredMonth, $desiredYear, $spreadsheet));
    $spreadsheet->getActiveSheet()->setCellValue('X9', $rs->getTotalPaymentMethod('CC', $desiredMonth, $desiredYear, $spreadsheet));

    $spreadsheet->getActiveSheet()->setCellValue('U2', "Venta Total de Hospedaje");
    $spreadsheet->getActiveSheet()->setCellValue('V2', "Venta Promedio por Habitación");
    $spreadsheet->getActiveSheet()->setCellValue('W2', "Venta Promedio por Día");
    $spreadsheet->getActiveSheet()->setCellValue('X2', "Total Ocupación");
    $spreadsheet->getActiveSheet()->setCellValue('Y2', "Ocupación Promedio por Habitación");
    $spreadsheet->getActiveSheet()->setCellValue('Z2', "Ocupación Promedio por Día");
    
    $rs->activeBoldCell($spreadsheet, 'U6:V25');
    $rs->activeBoldCell($spreadsheet, 'W11:AF12');
    $rs->activeBoldCell($spreadsheet, 'W15:AF16');
    $rs->activeBoldCell($spreadsheet, 'W19:AF20');
    $rs->activeBoldCell($spreadsheet, 'W23:AF24');
    $rs->activeBoldCell($spreadsheet, 'B3:B33');
    $rs->activeBoldCell($spreadsheet, 'A34:S35');
   
    

    $spreadsheet->getActiveSheet()->mergeCells("U6:V6");
    $spreadsheet->getActiveSheet()->setCellValue('U6', "Pago en Efectivo");
    $spreadsheet->getActiveSheet()->mergeCells("U7:V7");
    $spreadsheet->getActiveSheet()->setCellValue('U7', "Pago por Datáfono");
    $spreadsheet->getActiveSheet()->mergeCells("U8:V8");
    $spreadsheet->getActiveSheet()->setCellValue('U8', "Pago por Consignación");
    $spreadsheet->getActiveSheet()->mergeCells("U9:V9");
    $spreadsheet->getActiveSheet()->setCellValue('U9', "Cuentas por Cobrar");

    
    $spreadsheet->getActiveSheet()->mergeCells("U11:V13");
    $spreadsheet->getActiveSheet()->setCellValue('U11', "Habitación Sencilla");
    $spreadsheet->getActiveSheet()->mergeCells("W11:X11");
    $spreadsheet->getActiveSheet()
        ->getStyle('W11:AF11')
        ->getNumberFormat()
        ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
    $spreadsheet->getActiveSheet()->setCellValue('W11', "85000");
    $spreadsheet->getActiveSheet()->mergeCells("Y11:Z11");
    $spreadsheet->getActiveSheet()->setCellValue('Y11', "80000");
    $spreadsheet->getActiveSheet()->mergeCells("AA11:AB11");
    $spreadsheet->getActiveSheet()->setCellValue('AA11', "75000");
    $spreadsheet->getActiveSheet()->mergeCells("AC11:AD11");
    $spreadsheet->getActiveSheet()->setCellValue('AC11', "70000");
    $spreadsheet->getActiveSheet()->mergeCells("AE11:AF11");
    $spreadsheet->getActiveSheet()->setCellValue('AE11', "TOTAL");

    
    $count = "Conteo";
    $sale = "Venta";
    
    $rs->getCountSale('W', '12', 10, $spreadsheet);

    $spreadsheet->getActiveSheet()->mergeCells("U15:V17");
    $spreadsheet->getActiveSheet()->setCellValue('U15', "Habitación Pareja");
    $spreadsheet->getActiveSheet()->mergeCells("W15:X15");
    $spreadsheet->getActiveSheet()
        ->getStyle('W15:AF15')
        ->getNumberFormat()
        ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
    $spreadsheet->getActiveSheet()->setCellValue('W15', "115000");
    $spreadsheet->getActiveSheet()->mergeCells("Y15:Z15");
    $spreadsheet->getActiveSheet()->setCellValue('Y15', "110000");
    $spreadsheet->getActiveSheet()->mergeCells("AA15:AB15");
    $spreadsheet->getActiveSheet()->setCellValue('AA15', "105000");
    $spreadsheet->getActiveSheet()->mergeCells("AC15:AD15");
    $spreadsheet->getActiveSheet()->setCellValue('AC15', "100000");
    $spreadsheet->getActiveSheet()->mergeCells("AE15:AF15");
    $spreadsheet->getActiveSheet()->setCellValue('AE15', "TOTAL");
    
    
    $rs->getCountSale('W', '16', 10, $spreadsheet);


    $spreadsheet->getActiveSheet()->mergeCells("U19:V21");
    $spreadsheet->getActiveSheet()->setCellValue('U19', "Habitación Doble");
    $spreadsheet->getActiveSheet()->mergeCells("W19:X19");
    $spreadsheet->getActiveSheet()
        ->getStyle('W19:AF19')
        ->getNumberFormat()
        ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
    $spreadsheet->getActiveSheet()->setCellValue('W19', "125000");
    $spreadsheet->getActiveSheet()->mergeCells("Y19:Z19");
    $spreadsheet->getActiveSheet()->setCellValue('Y19', "120000");
    $spreadsheet->getActiveSheet()->mergeCells("AA19:AB19");
    $spreadsheet->getActiveSheet()->setCellValue('AA19', "TOTAL");

    $rs->getCountSale('W', '20', 6, $spreadsheet);


    $spreadsheet->getActiveSheet()->mergeCells("U23:V25");
    $spreadsheet->getActiveSheet()->setCellValue('U23', "Habitación Triple");
    $spreadsheet->getActiveSheet()->mergeCells("W23:X23");
    $spreadsheet->getActiveSheet()->setCellValue('W23', "< $130,000");

    $rs->getCountSale('W', '24', 2, $spreadsheet);



    $spreadsheet->getActiveSheet()->mergeCells("A34:B34");
    $spreadsheet->getActiveSheet()->mergeCells("A35:B35");
    $spreadsheet->getActiveSheet()->getStyle('A34')->getFont()->setSize(9);
    $spreadsheet->getActiveSheet()->setCellValue('A34', "Venta Total por Habitación");
    $spreadsheet->getActiveSheet()->getStyle('A35')->getFont()->setSize(9);
    $spreadsheet->getActiveSheet()->setCellValue('A35', "Conteo Total por Habitación");

    
    $spreadsheet->getActiveSheet()
        ->getStyle('C3:S34')
        ->getNumberFormat()
        ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
    


    // Se llenan los valores con todos los días del mes especificado  
    $rs->getDateMonth($desiredMonth, $desiredYear, $spreadsheet);

    // Se encarga de llenar todos los valores de las reservas de acuerdo a la fecha especificada
    $rs->fullAllRooms('C', $desiredMonth, $desiredYear, $spreadsheet);
    $rs->getValueTotalPerRoom('C', 17, $spreadsheet);
    $rs->getTotalCountPerRoom('C', 17, $spreadsheet);
    
    $rs->changeDollarFormat('A3:A33', $spreadsheet);
    $rs->getSalePerDay('A', $cantDays, $spreadsheet);


    $spreadsheet->getActiveSheet()
        ->getStyle('U3:W3')
        ->getNumberFormat()
        ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
    
    //Venta total de hospedaje
    $spreadsheet->getActiveSheet()->setCellValue('U3', "=SUM(C34:S34)");

    //Venta promedio por habitación
    $spreadsheet->getActiveSheet()->setCellValue('V3', "=U3/17");

    //Venta promedio por día
    $spreadsheet->getActiveSheet()->setCellValue('V3', "=U3/17");
    
    //Venta promedio por día
    $spreadsheet->getActiveSheet()->setCellValue('W3', "=U3/".$cantDays);

    //Total Ocupación
    $spreadsheet->getActiveSheet()->setCellValue('X3', "=SUM(C35:S35)");

    //Ocupación Promedio por habitación
    $spreadsheet->getActiveSheet()->setCellValue('Y3', '=TEXT(X3/17,"0.0")');

    //Ocupación Promedio por día
    $spreadsheet->getActiveSheet()->setCellValue('Z3', '=TEXT(X3/'.$cantDays.',"0.0")');


    $rs->changeDollarFormat('X13', $spreadsheet);
    $rs->changeDollarFormat('Z13', $spreadsheet);
    $rs->changeDollarFormat('AB13', $spreadsheet);
    $rs->changeDollarFormat('AD13', $spreadsheet);
    $rs->changeDollarFormat('AF13', $spreadsheet);

    $rs->changeDollarFormat('X17', $spreadsheet);
    $rs->changeDollarFormat('Z17', $spreadsheet);
    $rs->changeDollarFormat('AB17', $spreadsheet);
    $rs->changeDollarFormat('AD17', $spreadsheet);
    $rs->changeDollarFormat('AF17', $spreadsheet);

    $rs->changeDollarFormat('X21', $spreadsheet);
    $rs->changeDollarFormat('Z21', $spreadsheet);
    $rs->changeDollarFormat('AB21', $spreadsheet);

    $rs->changeDollarFormat('X25', $spreadsheet);


    //Venta ($85.000)
    $spreadsheet->getActiveSheet()->setCellValue('X13', '=SUMIFS(C3:S33,C3:S33,85000)');

    //Conteo ($85.000)
    $spreadsheet->getActiveSheet()->setCellValue('W13', '=X13/W11');

    //Venta ($80.000)
    $spreadsheet->getActiveSheet()->setCellValue('Z13', '=SUMIFS(C3:S33,C3:S33,80000)');

    //Conteo ($80.000)
    $spreadsheet->getActiveSheet()->setCellValue('Y13', '=Z13/Y11');

    //Venta ($75.000)
    $spreadsheet->getActiveSheet()->setCellValue('AB13', '=SUMIFS(C3:S33,C3:S33,75000)');

    //Conteo ($75.000)
    $spreadsheet->getActiveSheet()->setCellValue('AA13', '=AB13/AA11');

    //Venta ($70.000)
    $spreadsheet->getActiveSheet()->setCellValue('AD13', '=SUMIFS(C3:S33,C3:S33,70000)');

    //Conteo ($70.000)
    $spreadsheet->getActiveSheet()->setCellValue('AC13', '=AD13/AC11');

    //Total Habitacion sencilla
    $spreadsheet->getActiveSheet()->setCellValue('AF13', '=X13+Z13+AB13+AD13');

    //Conteo Total Habitacion sencilla
    $spreadsheet->getActiveSheet()->setCellValue('AE13', '=W13+Y13+AA13+AC13');

    //Venta ($115.000)
    $spreadsheet->getActiveSheet()->setCellValue('X17', '=SUMIFS(C3:S33,C3:S33,115000)');

    //Conteo ($115.000)
    $spreadsheet->getActiveSheet()->setCellValue('W17', '=X17/W15');

    //Venta ($110.000)
    $spreadsheet->getActiveSheet()->setCellValue('Z17', '=SUMIFS(C3:S33,C3:S33,110000)');

    //Conteo ($110.000)
    $spreadsheet->getActiveSheet()->setCellValue('Y17', '=Z17/Y15');

    //Venta ($105.000)
    $spreadsheet->getActiveSheet()->setCellValue('AB17', '=SUMIFS(C3:S33,C3:S33,105000)');

    //Conteo($105.000)
    $spreadsheet->getActiveSheet()->setCellValue('AA17', '=AB17/AA15');

    //Venta ($100.000)
    $spreadsheet->getActiveSheet()->setCellValue('AD17', '=SUMIFS(C3:S33,C3:S33,100000)');

    //Conteo ($100.000)
    $spreadsheet->getActiveSheet()->setCellValue('AC17', '=AD17/AC15');

    //Total Habitacion pareja
    $spreadsheet->getActiveSheet()->setCellValue('AF17', '=X17+Z17+AB17+AD17');

    //Conteo Total Habitacion pareja
    $spreadsheet->getActiveSheet()->setCellValue('AE17', '=W17+Y17+AA17+AC17');

    //Venta ($125.000)
    $spreadsheet->getActiveSheet()->setCellValue('X21', '=SUMIFS(C3:S33,C3:S33,125000)');

    //Conteo ($125.000)
    $spreadsheet->getActiveSheet()->setCellValue('W21', '=X21/W19');

    //Venta ($120.000)
    $spreadsheet->getActiveSheet()->setCellValue('Z21', '=SUMIFS(C3:S33,C3:S33,120000)');

    //Conteo ($120.000)
    $spreadsheet->getActiveSheet()->setCellValue('Y21', '=Z21/Y19');

    //Total Habitacion doble
    $spreadsheet->getActiveSheet()->setCellValue('AB21', '=X21+Z21');

    //Conteo Total Habitacion doble
    $spreadsheet->getActiveSheet()->setCellValue('AA21', '=W21+Y21');

    //Venta (>$130.000)
    $spreadsheet->getActiveSheet()->setCellValue('X25', '=SUMIFS(C3:S33,C3:S33,">130000")');

    //Conteo (>$130.000)
    $spreadsheet->getActiveSheet()->setCellValue('W25', '=COUNTIFS(C3:S33,">130000")');

    header('Content-Disposition: attachment;filename="REPORTE ESTADISTICAS '.$desiredMonth.'-'.$desiredYear.'.xlsx"');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    
?>
