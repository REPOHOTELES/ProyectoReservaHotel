<?php
ob_start();
/**
    * Archivo que contiene el reporte de las facturas manuales
    * @package   reportes
    * @author    Grupo3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    include '../../includes/classes.php';
    include '../../includes/cifrasEnLetras.php';
    include '../report.php';
    
    
    $user = new User();
    $userSession = new UserSession();

    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
    }else{
        header('location: ../../login');
    }

    /**
    * Declaración de objetos que permiten  realizar consultas desde la base de datos
    **/
    $db = new Database();
    $consult = new Consult();
    $inLetter = new CifrasEnLetras();

    /**
    * Declaración de consultas y parámetros necesarios
    **/
    $idBill = $_GET['idBill'];
    $serieBill;
    $dateBill;
    $responsible;
    $nameTitular;
    $enterprise;
    $documentTitular;
    $rooms;
    $checkIn;
    $checkOut;
    $desc1;
    $desc2;
    $desc3;
    $desc4;
    $cant1;
    $cant2;
    $cant3;
    $cant4;
    $unit1;
    $unit2;
    $unit3;
    $unit4;
    $vTotal1;
    $vTotal2;
    $vTotal3;
    $vTotal4;
    $valueTotal;
    
    
     // Declaración de la consulta - datos personales
     $queryManualBill = $db->connect()->prepare('SELECT serie_factura_prov, DATE_FORMAT(fecha_factura, "%d/%m/%Y") AS fecha_factura, responsable, name, enterprise, documentTitular, rooms, DATE_FORMAT(checkIn, "%d/%m/%Y") AS checkIn, DATE_FORMAT(checkOut, "%d/%m/%Y") AS checkOut, desc1, desc2, desc3, desc4, cant1, cant2, cant3, cant4, unit1, unit2, unit3, unit4, vTotal1, vTotal2, vTotal3, vTotal4, valueTotal 
     FROM factura_prov
     WHERE serie_factura_prov =:idBill');
    $queryManualBill->execute(['idBill'=>$idBill]);


    foreach($queryManualBill  as $current){
        $serieBill = $current['serie_factura_prov'];
        $dateBill = $current['fecha_factura'];
        $responsible = $current['responsable'];
        $nameTitular = $current['name'];
        $enterprise = $current['enterprise'];
        $documentTitular = $current['documentTitular'];
        $rooms = $current['rooms'];
        $checkIn = $current['checkIn'];
        $checkOut = $current['checkOut'];
        $desc1 = $current['desc1'];
        $desc2 = $current['desc2'];
        $desc3 = $current['desc3'];
        $desc4 = $current['desc4'];
        $cant1 = $current['cant1'];
        $cant2 = $current['cant2'];
        $cant3 = $current['cant3'];
        $cant4 = $current['cant4'];
        $unit1 = $current['unit1'];
        $unit2 = $current['unit2'];
        $unit3 = $current['unit3'];
        $unit4 = $current['unit4'];
        $vTotal1 = $current['vTotal1'];
        $vTotal2 = $current['vTotal2'];
        $vTotal3 = $current['vTotal3'];
        $vTotal4 = $current['vTotal4'];
        $valueTotal = $current['valueTotal'];
    } 
    
    /**
    * Asignación del tamaño y márgenes de la hoja
    **/
    $orientation = "P";
    $pageSize = array(216, 279);

    $pdf = new Report($orientation,'mm',$pageSize);
    $pdf->SetAutoPageBreak(true,2); 
    
    // Cabecera del reporte
    $pdf->AddPage();
    $pdf->Header('');
    $pdf->SetFont('Arial','B',11);

    $pdf->Image('../../res/img/map.png',70,40,80);
    $pdf->setDrawColor(24, 52, 125);
    $pdf->RoundedRect(155, 35, 50, 14, 3);
    $pdf->Cell(145);
    $pdf->setXY(155,35);
    $pdf->MultiCell(50, 7, utf8_decode("    FACTURA DE VENTA    ".' NO.         '), '', 'C', 0);

    setlocale(LC_ALL,"es_CO");
    date_default_timezone_set('America/Bogota');

    $pdf->SetTextColor(255,0,0);
    $pdf->setXY(180,43);
    $pdf->Cell(20, 5, $serieBill, 0, 1, 'L', 0);
    
    $pdf->SetTextColor(24, 52, 125);

    $pdf->SetFont('Arial','B',9);
    $pdf->setXY(9,40);
    $pdf->Cell(20, 5, 'NOMBRE: ', 0, 1, 'L', 0);
    
    if ($enterprise != Null) {
        $pdf->setXY(90,40);
        $pdf->Cell(20, 5, 'EMPRESA: ', 0, 1, 'L', 0);
        
        $pdf->SetFont('Arial');
        $pdf->setXY(109, 40);
        $pdf->Cell(100, 5, utf8_decode($enterprise), 0, 1, 'L', 0);
    }

    $pdf->setXY(26, 40);
    $pdf->SetFont('Arial');
    $pdf->Cell(100, 5, utf8_decode($nameTitular), 0, 1, 'L', 0);
    $pdf->setXY(37, 48);
    $pdf->Cell(30, 5, '12345', 0, 1, 'L', 0);
    
    $pdf->SetFont('Arial','B',9);
    $pdf->setXY(9, 48);
    $pdf->Cell(28, 5, utf8_decode("IDENTIFICACIÓN"), 0, 1, 'L', 0);
    $pdf->setXY(9, 55);
    $pdf->Cell(28, 5, utf8_decode('HABITACIÓN(ES): '), 0, 1, 'L', 0);
    $pdf->setXY(115, 55);
    $pdf->Cell(28, 5, utf8_decode('CHECK IN: '), 0, 1, 'L', 0);
    $pdf->setXY(166, 55);
    $pdf->Cell(28, 5, utf8_decode('CHECK OUT: '), 0, 1, 'L', 0);
    

    $pdf->SetFont('Arial');
    $pdf->setXY(38, 55);
    $pdf->Cell(25, 5, $rooms, 0, 1, 'L', 0);
    $pdf->setXY(135, 55);
    $pdf->Cell(25, 5, $checkIn, 0, 1, 'L', 0);
    $pdf->setXY(188, 55);
    $pdf->Cell(25, 5, $checkOut, 0, 1, 'L', 0);

    $pdf->setXY(10, 63);
    $pdf->SetFont('Arial','B',9);
    $pdf->SetLineWidth(.5);
    $pdf->Cell(194.6, 0, '', 'TR', 1, 'C', 0);
    $pdf->SetLineWidth(.3);
    $pdf->Cell(100,6,utf8_decode('DESCRIPCIÓN'), 1, 0, 'C', 0);
    
    $pdf->Cell(25,6,'CANTIDAD', 'TLB', 0, 'C', 0);
    $pdf->Cell(35,6,'VALOR UNITARIO', 'TLB', 0, 'C', 0);
    $pdf->Cell(35,6,utf8_decode('VALOR TOTAL'), 1, 1, 'C', 0);



    // Formato y agregación del contenido del reporte
    $pdf->SetFont('Arial','',9);

    $pdf->setX(10);
    $pdf->Cell(100, 6, utf8_decode($desc1), 'LR', 0, 'C', 0);
    $pdf->Cell(25, 6, utf8_decode($cant1), 0, 0, 'C', 0);
    $pdf->Cell(35, 6, utf8_decode('$'.number_format($unit1, 0, '.', '.')), 'L', 0, 'C', 0);
    $pdf->Cell(35, 6, utf8_decode('$'.number_format($vTotal1, 0, '.', '.')), 'LR', 1, 'C', 0);

    if($cant2 != Null){
        $pdf->setX(10);
        $pdf->Cell(100, 6, utf8_decode($desc2), 'LR', 0, 'C', 0);
        $pdf->Cell(25, 6, utf8_decode($cant2), 0, 0, 'C', 0);
        $pdf->Cell(35, 6, utf8_decode('$'.number_format($unit2, 0, '.', '.')), 'L', 0, 'C', 0);
        $pdf->Cell(35, 6, utf8_decode('$'.number_format($vTotal2, 0, '.', '.')), 'LR', 1, 'C', 0);
    }

    if($cant3 != Null){
        $pdf->setX(10);
        $pdf->Cell(100, 6, utf8_decode($desc3), 'LR', 0, 'C', 0);
        $pdf->Cell(25, 6, utf8_decode($cant3), 0, 0, 'C', 0);
        $pdf->Cell(35, 6, utf8_decode('$'.number_format($unit3, 0, '.', '.')), 'L', 0, 'C', 0);
        $pdf->Cell(35, 6, utf8_decode('$'.number_format($vTotal3, 0, '.', '.')), 'LR', 1, 'C', 0);
    }

    if($cant4 != Null){
        $pdf->setX(10);
        $pdf->Cell(100, 6, utf8_decode($desc4), 'LR', 0, 'C', 0);
        $pdf->Cell(25, 6, utf8_decode($cant4), 0, 0, 'C', 0);
        $pdf->Cell(35, 6, utf8_decode('$'.number_format($unit4, 0, '.', '.')), 'LB', 0, 'C', 0);
        $pdf->Cell(35, 6, utf8_decode('$'.number_format($vTotal4, 0, '.', '.')), 'LBR', 1, 'C', 0);
    }


    $pdf->setX(10);
    $pdf->SetFont('Arial','B',8);
    
    $pdf->Cell(10, 10, " SON: ", 'TLB', 0, 'L', 0);
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(115, 10, utf8_decode(strtoupper($inLetter->convertirCifrasEnLetras($valueTotal)." PESOS M/CTE")), 'TBR', 0, 'L', 0);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(35, 10, utf8_decode("VALOR TOTAL"), 'TB', 0, 'C', 0);
    $pdf->Cell(35, 10, '$'.number_format($valueTotal, 0, '.', '.'), 'TLR', 1, 'C', 0);

    $pdf->SetLineWidth(.5);
    $pdf->Cell(194.6, 0, '', 'TR', 1, 'C', 0);
    $pdf->SetLineWidth(.3);
    
    $pdf->SetFont('Arial','',8);
    
    $pdf->setX(6);  
    $pdf->Cell(199, 4, utf8_decode('Esta factura se asimila en todos sus efectos legales a una Letra de Cambio según el Art. 774 del Código de Comercio'), 0, 1, 'C', 0);

    $pdf->ln(10); 
    $pdf->setXY(10, 130); 

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(15, 4, utf8_decode('CLIENTE'), 0, 0, 'L', 0);
    $pdf->Cell(64, 3, '', 'B', 0, 'L', 0);    
    $pdf->Cell(45, 4, utf8_decode('RESPONSABLE: '), 0, 0, 'R', 0);
    
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(80, 4, utf8_decode($responsible), 0, 0, 'L', 0);
    
    // Generación del reporte
    $pdf->Output();
    ob_end_flush(); 
?>
