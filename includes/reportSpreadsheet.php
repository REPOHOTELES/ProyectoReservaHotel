<?php
    use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
    use PhpOffice\PhpSpreadsheet\Shared\Date;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill; 

    class ReportSpreadsheet extends Database{
        
        function createBorder($rangeCell, $spreadsheet){
            $spreadsheet->getActiveSheet()->getStyle($rangeCell)->getBorders()->getAllBorders()->applyFromArray( array( 'borderStyle' => Border::BORDER_THIN, 'color' => array( 'rgb' => '000000' ) ) );
        }
        
        
        function setBackgroundColor($rangeCell, $color, $spreadsheet){
            $spreadsheet->getActiveSheet()->getStyle($rangeCell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($color);
        }
        
        
        function fullRoom($numberCol, $numberRow, $firstRoom, $cantRooms, $spreadsheet){
            $box = ord($numberCol);
            $room = $firstRoom;
    
            for ($i = 0; $i < $cantRooms; $i++) {
                $spreadsheet->getActiveSheet()->setCellValue(chr($box).$numberRow, $room);
                if($room==202){
                    $room=301;
                }else if(($room==304)||($room==404)||($room==504)){
                    $room+=97;
                }else{
                    $room++;    
                }
                
                $box++;
            }
        }
        
        
        function getCountSale($col, $row, $iterations, $spreadsheet){
            $box = ord($col);
            $aux = '';
            for($i=0;$i<$iterations;$i++){
                if($i%2==0)
                    $spreadsheet->getActiveSheet()->setCellValue($aux.chr($box).$row, 'Conteo');
                else
                    $spreadsheet->getActiveSheet()->setCellValue($aux.chr($box).$row, 'Venta');

                if($box==ord('Z')){
                    $box = ord('@');
                    $aux = 'A';
                }
                $box++;
            }
        }
        
        
        function getSalePerRoom($firstCol, $row, $month, $year, $spreadsheet){
            $query = $this->connect()->prepare('SELECT numero_habitacion, SUM(valor_ocupacion*(DATE_FORMAT(fecha_salida, "%d-%m-%y")-DATE_FORMAT(fecha_ingreso, "%d-%m-%y")+1)) AS value 
            FROM tarifas t INNER JOIN registros_habitacion rh ON t.id_tarifa=rh.id_tarifa
            INNER JOIN reservas r ON r.id_reserva=rh.id_reserva
            INNER JOIN habitaciones h ON h.id_habitacion=rh.id_habitacion
            WHERE MONTH(fecha_ingreso) = :month
            AND YEAR(fecha_ingreso) = :year
            GROUP BY numero_habitacion
            ORDER BY numero_habitacion;');
            $query->execute(['month'=>$month, 'year'=>$year]);
            $numberCol = ord($firstCol);

            foreach ($query as $current) {
                $spreadsheet->getActiveSheet()->setCellValue(chr($numberCol).$row, $current['value']);
                $numberCol++;
            }
        }
        
        
        function getDateMonth($month, $year, $spreadsheet){
            $numberDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $row = 3;
            $day = 1;
            
            for($i=0;$i<$numberDays;$i++){
                $dateTimeNow = strtotime((string)($day).'-'.$month.'-'.$year.'+ 1 days');
                $spreadsheet->getActiveSheet()->getStyle('B'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->setCellValue('B'.$row, Date::PHPToExcel($dateTimeNow)); 
                $day++;
                $row++;
            }  
        }
        
        
        function getSalePerDay($col, $cantDays, $spreadsheet){
            $row = 3;
            for($i=0;$i<$cantDays;$i++){
                $spreadsheet->getActiveSheet()->setCellValue($col.$row, '=SUM(C'.$row.':S'.$row.')');
                $row++;
            }
        }
        
        
        function setColorBgToValue($paymentMethod){
            $color = 'ffffff';
            switch ($paymentMethod) {
                case 'E':
                    $color = '9bc2e6';
                break;

                case 'T':
                    $color = '00ff00';
                break;

                case 'C':
                    $color = 'ffc000';
                break;

                case 'CC':
                    $color = 'ff33cc';
                break;

            }
            return $color;
        }
        
        
        public function fullValuesPerRoom2($room, $col, $month, $year, $spreadsheet){
            
            $row = 3;
            $colExcelDate = 2;
            $rowExcelDate = 3;
            
            $query = $this->connect()->prepare('SELECT valor_ocupacion, DAY (fecha_ingreso) AS dia_ingreso, SUM(DATE_FORMAT(fecha_salida, "%d-%m-%y")-DATE_FORMAT(fecha_ingreso, "%d-%m-%y")+1) AS cantidad_dias, medio_pago 
            FROM tarifas t INNER JOIN registros_habitacion rh ON t.id_tarifa=rh.id_tarifa
            INNER JOIN reservas r ON r.id_reserva=rh.id_reserva
            INNER JOIN habitaciones h ON h.id_habitacion=rh.id_habitacion
            WHERE h.numero_habitacion = :room
            AND MONTH (r.fecha_ingreso) = :enterMonth
            AND YEAR (r.fecha_ingreso) = :enterYear
            GROUP BY 1, 2
            ORDER BY fecha_ingreso');
            $query->execute(['room'=>$room, 'enterMonth'=>$month, 'enterYear'=>$year]);
            

            foreach ($query as $current) {
                $entryDay = $current['dia_ingreso'];
                $diferenceDates = $current['cantidad_dias'];
                $valueRaservation = $current['valor_ocupacion'];
                $color = $this->setColorBgToValue($current['medio_pago']);
                
                for($i=0;$i<$diferenceDates;$i++){
                    $this->setBackgroundColor($col.($entryDay+2), $color, $spreadsheet);
                    $spreadsheet->getActiveSheet()->setCellValue($col.($entryDay+2), $valueRaservation);
                    $entryDay++;
                }
                
            }
        }
        
        
        function getTotalPaymentMethod($paymentMethod, $month, $year, $spreadsheet){
            $totalPaymentMethod = 0;
            $query = $this->connect()->prepare('SELECT SUM(valor_ocupacion*(DATE_FORMAT(fecha_salida, "%d-%m-%y")-DATE_FORMAT(fecha_ingreso, "%d-%m-%y")+1)) AS total
            FROM tarifas t INNER JOIN registros_habitacion rh ON t.id_tarifa=rh.id_tarifa
            INNER JOIN reservas r ON r.id_reserva=rh.id_reserva
            WHERE r.medio_pago = :medio
            AND MONTH (r.fecha_ingreso) = :enterMonth
            AND YEAR (r.fecha_ingreso) = :enterYear');
            $query->execute(['medio'=>$paymentMethod, 'enterMonth'=>$month, 'enterYear'=>$year]);
            foreach ($query as $current) {
                $totalPaymentMethod += $current['total'];
            }
            return $totalPaymentMethod;
        }
        
        
        function getValueTotalPerRoom($initCol, $cantRooms, $spreadsheet){
            $colAux = ord($initCol);
            for($i=0;$i<$cantRooms;$i++){
                $spreadsheet->getActivesheet()->setCellValue(chr($colAux).'34', '=SUM('.chr($colAux).'3:'.chr($colAux).'33)');  
                $colAux++;
            }
        }
        
        
        function getTotalCountPerRoom($initCol, $cantRooms, $spreadsheet){
            $colAux = ord($initCol);
            for($i=0;$i<$cantRooms;$i++){
                $spreadsheet->getActivesheet()->setCellValue(chr($colAux).'35', '=COUNT('.chr($colAux).'3:'.chr($colAux).'33)');  
                $colAux++;
            }
        }
        
        
        
        function fullAllRooms($numberCol, $month, $year, $spreadsheet){
            $box = ord($numberCol);
            $room = 201;
    
            for ($i = 0; $i < 17; $i++) {
                $this->fullValuesPerRoom2($room, chr($box), $month, $year, $spreadsheet);
                if($room==202){
                    $room=301;
                }else if(($room==304)||($room==404)||($room==504)){
                    $room+=97;
                }else{
                    $room++;    
                }
                
                $box++;
            }
        }
        
        
        function changeDollarFormat($cell, $spreadsheet){
            $spreadsheet->getActiveSheet()
            ->getStyle($cell)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        }
        
        
        function extractDateFromExcel($numberColExtract, $numberRowExtract, $spreadsheet){
            $val = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($numberColExtract, $numberRowExtract)->getValue();
            $aux = Date::excelToTimestamp($val); //formato unix timestamp
        }
        
        
        
        function activeBoldCell($spreadsheet, $range){
            $spreadsheet->getActiveSheet()->getStyle($range)->getFont()->setBold(true);
        }
    }
    
?>
