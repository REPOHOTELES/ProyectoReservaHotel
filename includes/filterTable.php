<?php
    include 'database.php';

    switch ($_POST['entity']) {
        case 'enterprise':
            getConsultEnterprise();
            break;
        case 'user':
            getConsultUser();
        break;
        case 'customer':
            getConsultCustomer();
        break;
        case 'bill':
            getConsultBill();
        break;
        default:
            break;
    }

    function getConsultEnterprise(){
        $database = new Database();

        $idEnterprise = $_POST['id'];

        $output = "";
        $query = "SELECT id_empresa, nit_empresa, UPPER(nombre_empresa) AS nombre_empresa, telefono_empresa, retefuente, ica FROM empresas";

        if(!empty($idEnterprise)){
            $query.= " WHERE nit_empresa LIKE '%$idEnterprise%' OR UPPER(nombre_empresa) LIKE UPPER('%$idEnterprise%')"; 
        }

        $query.= " ORDER BY nombre_empresa";
        $result = $database->connect()->prepare($query);
        $result->execute();

        if($result->rowCount()>0){
            $output.="<table>
            <thead>
                <tr>
                    <th>NIT</th>
                    <th>NOMBRE</th>
                    <th>TELEFONO</th>
                    <th>RETEFUENTE <br/>(3,5 %)</br></th>
                    <th>ICA</br></th>
                </tr>
            </thead>
            <tbody>";

            foreach ($result as $current) {
                $output.='<tr>
                            <td>'.$current['nit_empresa'].'</td>
                            <td style = "text-align: left; padding: 10px;"><a href="../empresas/detalles?id='.$current['id_empresa'].'">'.$current['nombre_empresa'].'</a></td>
                            <td>'.$current['telefono_empresa'].'</td>
                            <td>'.$current['retefuente'].'</td>
                            <td>'.$current['ica'].'</td>
                        </tr>';
            }
            $output.="</tbody></table>";
        }else{
            $output.="LA BÚSQUEDA NO COINCIDE CON NINGÚN REGISTRO DE LA BASE DE DATOS";
        }
        echo $output;
    }


    function getConsultUser(){
        $database = new Database();

        $idUser = $_POST['id'];

        $output = "";
        $query = "SELECT id_persona, UPPER(CONCAT_WS(' ', nombres_persona, apellidos_persona)) AS nombres, telefono_persona, correo_persona, UPPER(nombre_cargo) AS nombre_cargo FROM personas p INNER JOIN cargos c ON p.id_cargo = c.id_cargo WHERE p.id_cargo != 5";

        if(!empty($idUser)){
            $query.= " AND numero_documento LIKE '%$idUser%' OR UPPER(CONCAT_WS(' ', nombres_persona, apellidos_persona)) LIKE UPPER('%$idUser%')"; 
        }

        $query.= " ORDER BY nombres_persona";
        $result = $database->connect()->prepare($query);
        $result->execute();

        if($result->rowCount()>0){
            $output.="<table>
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>TELÉFONO</th>
                    <th>CORREO ELECTRÓNICO</th>
                    <th>CARGO</th>
                </tr>
            </thead>
            <tbody>";

            foreach ($result as $current) {
                $output.='<tr>
                            <td style = "text-align: left; padding: 10px;"><a href="../usuarios/detalles?id='.$current['id_persona'].'">'.$current['nombres'].'</a></td>
                            <td>'.$current['telefono_persona'].'</td>
                            <td>'.$current['correo_persona'].'</td>
                            <td>'.$current['nombre_cargo'].'</td>
                        </tr>';
            }
            $output.="</tbody></table>";
        }else{
            $output.="LA BÚSQUEDA NO COINCIDE CON NINGÚN REGISTRO DE LA BASE DE DATOS";
        }
        echo $output;
    }

    function getConsultCustomer(){
        $database = new Database();

        $idCustomer = $_POST['id'];

        $output = "";
        $query = "SELECT id_persona, numero_documento, UPPER(CONCAT_WS(' ', nombres_persona, apellidos_persona)) AS nombres, telefono_persona FROM personas WHERE tipo_persona = 'C'";

        if(!empty($idCustomer)){
            $query.= " AND numero_documento LIKE '%$idCustomer%' OR UPPER(CONCAT_WS(' ', nombres_persona, apellidos_persona)) LIKE UPPER('%$idCustomer%')"; 
        }

        $query.= " ORDER BY nombres_persona ASC";
        $result = $database->connect()->prepare($query);
        $result->execute();

        if($result->rowCount()>0){
            $output.="<table>
            <thead>
                <tr>
                    <th>NÚMERO DE DOCUMENTO</th>
                    <th>NOMBRE</th>
                    <th>TELÉFONO</th>
                </tr>
            </thead>
            <tbody>";

            foreach ($result as $current) {
                $output.='<tr>
                            <td>'.$current['numero_documento'].'</td>
                            <td style = "text-align: left; padding: 10px;"><a href="../clientes/detalles?id='.$current['id_persona'].'">'.$current['nombres'].'</a></td>
                            <td>'.$current['telefono_persona'].'</td>
                        </tr>';
            }
            $output.="</tbody></table>";
        }else{
            $output.="LA BÚSQUEDA NO COINCIDE CON NINGÚN REGISTRO DE LA BASE DE DATOS";
        }
        echo $output;
    }

    function getConsultBill(){
        $database = new Database();

        $idBill = $_POST['id'];

        $output = "";
        $query = "SELECT id_factura, UPPER(serie_factura) AS serie_factura, r.id_reserva, CASE WHEN r.id_titular IS NOT NULL THEN UPPER(CONCAT_WS(' ',pt.nombres_persona, pt.apellidos_persona)) ELSE UPPER(e.nombre_empresa) END AS titular, UPPER(CONCAT_WS(' ',pr.nombres_persona, pr.apellidos_persona)) AS responsable, total_factura, DATE_FORMAT(fecha_factura, '%d/%m/%Y') AS fecha_factura, CASE WHEN f.tipo_factura='N' THEN 0 ELSE 1 END AS tipo
        FROM facturas f INNER JOIN reservas r ON f.id_reserva=r.id_reserva
        LEFT JOIN personas pr ON f.id_responsable = pr.id_persona
        LEFT JOIN personas pt ON r.id_titular=pt.id_persona
        LEFT JOIN empresas e ON r.id_empresa=e.id_empresa
        WHERE tipo_factura = 'N'";

        if(!empty($idBill)){
            $query.= " AND serie_factura LIKE '%$idBill%' OR UPPER(CONCAT_WS(' ', pt.nombres_persona, pt.apellidos_persona)) LIKE UPPER('%$idBill%') OR UPPER(e.nombre_empresa) LIKE UPPER('%$idBill%')"; 
        }

        $query.= " ORDER by f.fecha_factura, f.serie_factura";
        $result = $database->connect()->prepare($query);
        $result->execute();

        if($result->rowCount()>0){
            $output.="<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TITULAR</th>
                    <th>VALOR FACTURADO($)</th>
                    <th>FECHA DE FACTURACIÓN </th>
                    <th>RESPONSABLE</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>";

            foreach ($result as $current) {
                $output.='<tr>
                            <td>'.$current['serie_factura'].'</td>
                            <td>'.$current['titular'].'</td>
                            <td>'.'$ '.number_format($current['total_factura'], 0, '.', '.').'</td>
                            <td>'.$current['fecha_factura'].'</td>
                            <td>'.$current['responsable'].'</td>
                            <td><a href = "../facturas/registrar?id='.$current['id_reserva'].'&serie='.$current['serie_factura'].'"class="button-more-info" class="col-10">Ver Detalles</a></td>
                            <td><a target = "_blank" href = "../reportes/facturas?id='.$current['id_reserva'].'&typeBill='.$current['tipo'].'&serie='.$current['serie_factura'].'" class="col-10"><img src="../res/img/pdf-icon.png" style="cursor:pointer;" width="60"/></a></td>
                        </tr>';
            }
            $output.="</tbody></table>";
        }else{
            $output.="LA BÚSQUEDA NO COINCIDE CON NINGÚN REGISTRO DE LA BASE DE DATOS";
        }
        echo $output;
    }
?>
