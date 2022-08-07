<?php
/**
    * Archivo que contiene el reporte con las empresas asociadas con el hotel
    * @package   reportes.empresas
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
    */
    include '../../includes/classes.php';
    include '../report.php';

    // Declaración de los objetos requeridos
    $db = new Database();
    $pdf = new Report('P','mm','letter');    

    // Declaración de la consulta
    $query = $db->connect()->prepare('SELECT nit_empresa, UPPER(nombre_empresa) AS nombre_empresa, correo_empresa, telefono_empresa FROM empresas ORDER BY nombre_empresa');
    $query->execute();

    // Cabecera del reporte
    $pdf->AddPage();
    $pdf->Header('REPORTE DE EMPRESAS');
    $pdf->SetFont('Arial','B',11);
    
    $pdf->setTextColor(0, 0, 0);
    $pdf->setXY(10, 40);
    $pdf->Cell(28,7,'NIT', 1, 0, 'C', 0);
    $pdf->Cell(75,7,'NOMBRE', 1, 0, 'C', 0);
    $pdf->Cell(70,7,'CORREO', 1, 0, 'C', 0);
    $pdf->Cell(25,7,utf8_decode('TELÉFONO'), 1, 1, 'C', 0);
    
    // Formato y agregación del contenido del reporte
    $pdf->SetFont('Arial','',9);
    $pdf->SetWidths(array(28,75,70,25));
    foreach ($query as $current) {
        $pdf->Row(array(utf8_decode($current['nit_empresa']), utf8_decode($current['nombre_empresa']), utf8_decode($current['correo_empresa']), utf8_decode($current['telefono_empresa'])));
        /*$pdf->MultiCell(28,7,utf8_decode($current['nit_empresa']), 1, 'C', 0);
        $pdf->MultiCell(70,7,utf8_decode($current['nombre_empresa']), 1, 'C', 0);
        $pdf->MultiCell(75,7,utf8_decode($current['correo_empresa']), 1, 'C', 0);
        $pdf->MultiCell(25,7,utf8_decode($current['telefono_empresa']), 1, 'C', 0);*/
    }

    // Generación del reporte
    $pdf->Output();
?>
