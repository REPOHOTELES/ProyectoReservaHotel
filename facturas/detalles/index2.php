<?php
    /**
    * Archivo que contiene la información pertinente a la factura de servicios
    * @package   factura
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
    */
    require_once '../../includes/classes.php';
    $user = new User();
    $userSession = new UserSession();
    
    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
    }else{
        header('location: ../../login');
    }

    require __DIR__.'/vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;
    //Se extrae el archivo que contiene el contenido de la factura
    if(isset($_POST['crear'])){
        ob_start();
        require_once "print_view.php";
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
        $html2pdf->writeHTML($html);
        $html2pdf->output('factura.pdf');
    }
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Factura | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../../css/main.css">
        <link rel="stylesheet" type="text/css" href="../../css/modal.css">
        <link rel="stylesheet" type="text/css" href="../../css/reporte_factura.css">
        <link rel="stylesheet" type="text/css" href="../../css/factura.css">
        <link rel="stylesheet" type="text/css" href="../../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../../css/table.css">
        <script type="text/javascript" src="../../js/moment.js"></script>
        <script type="text/javascript" src="../../js/dynamic.js"></script>
        <script type="text/javascript" src="../../js/jquery.js"></script>
    </head>

    <body>
        <?php 
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu.php"; 
        ?>

        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "facturas"
            */
            setCurrentPage("facturas");
        </script>

        <!--Bloque encargado de mostrar los detalles correspondientes a la factura de una reserva-->
        <div class="col-11 content">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header col-12">
                    <div class="row col-12">
                        <h2 class="title-form col-12">FACTURACIÓN</h2>
                    </div>
                    
                </div>
                <div class="series">
                    <select name="typeBill">
                        <option value="Factura de Venta">Factura de Venta</option>
                        <option value="Orden de Servicio" selected>Orden de Servicio</option>
                    </select>
                    <p>No&nbsp;&nbsp;&nbsp;&nbsp; C 287</p>
                </div>
                <div class="infos">
                    <p><b>Nombre: </b>Juan Eduardo Rodriguez Tobos</p>
                    <p><b>Empresa: </b>Nutresa S.A.  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Teléfono: </b>7425643</p>
                    <p><b>NIT: </b>890.900.050 – 1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Habitación: </b>202 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Fecha Entrada: </b>20/11/2019 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Fecha Salida: </b>25/11/2019</p>
                </div>

                <div class="col-12">
                    <table>
                        <tr>
                            <th class="long_cols">Descripción</th>
                            <th>Cantidad</th>
                            <th>Valor Unitario</th>
                            <th class="long_values">Valor Total</th>
                        </tr>
                        <tr>
                            <td>Hospedaje habitación ejecutiva</td>
                            <td>2</td>
                            <td>$80.000</td>
                            <td>$160.000</td>
                        </tr>
                        <tr>
                            <td>Minibar</td>
                            <td>5</td>
                            <td>$8.000</td>
                            <td>$16.000</td>
                        </tr>
                        <tr>
                            <td>Servicio de lavandería</td>
                            <td>4</td>
                            <td>$3.000</td>
                            <td>$12.000</td>
                        </tr>
                    </table>
                </div>


                <div class="table_totals col-12">
                    <table>
                        <tr class="long_letters">
                            <td class="long_totals"></td>
                            <td><b>Total $</b></td>
                            <td class="long_values">$188.000</td>
                        </tr>
                    </table>
                </div>

                <div class="option_bill">
                    <a class="button-add-book col-2" href="../../reportes/facturas" target="_blank">Imprimir factura</a>
                </div>
            </div>
        </div>
        
        
        

        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/footer.php"; 
        ?>
    </body>
</html>
