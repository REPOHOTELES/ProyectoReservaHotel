<?php 
    /**
    * Archivo que muestra los detalles de una habitación en una fecha establecida
    * @package   habitaciones.detalles
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    require_once '../../includes/classes.php';

    $consult=new Consult();
    $user = new User();
    $userSession = new UserSession();
    
    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
    }else{
        header('location: ../../login');
    }

    $id="";
    if(isset($_GET['id'])){
        $id = $_GET['id'];      
    }
?>

<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Historial de la habitación <?php echo $id;?> | Hotel Aristo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../../css/main.css">
        <link rel="stylesheet" type="text/css" href="../../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../../css/table.css">
        <script type="text/javascript" src="../../js/moment.js"></script>
        <script type="text/javascript" src="../../js/dynamic.js"></script>
    </head>

    <!--Construcción de la vista-->
    <body onload ="getDate('control-date',0);">
        <?php 
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "control-diario"
            */
            setCurrentPage("control-diario");
        </script>

        <!--Bloque que muestra los detalles generales de una habitación en una fecha establecida-->
        <div id="content" class="col-12">
            <div class="marco nearly-page">
                <h4>INFORMACIÓN GENERAL</h4>
                <div class="general-info">
                    <div class="region">
                        <label><b>Fecha: &ensp;</b></label>
                        <label>22/11/2019</label>
                    </div>
                    <div class="region">
                        <label><b>Hora: &ensp;</b></label>
                        <label>14:00</label>
                    </div>
                    <div class="region">
                        <label><b>Habitación: &ensp;</b></label>
                        <label>201</label>
                    </div>
                    <div class="region">
                        <label><b>Actividad: &ensp; </b></label>
                        <label>Check in</label>
                    </div>
                    <div class="region">
                        <label><b>Valor total de consumo ($): &ensp;</b></label>
                        <label>75.000</label>
                    </div>

                </div>
                </br>
                <div class="specific-info">
                    <div>
                        <h4><b>HUÉSPEDES</b></h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Número de Documento</th>
                                    <th>Tipo de sangre</th>
                                    <th>Empresa</th>
                                    <th>Nacionalidad</th>
                                    <th>Profesión</th>
                                    <th>Teléfono</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Pom Guilizzoni</td>
                                <td>1034543</td>
                                <td>B+</td>
                                <td>Falabella</td>
                                <td>Italia</td>
                                <td>Médico</td>
                                <td>3125435432</td>
                            </tr>
                            <tr>
                                <td>Anu Guilizzoni</td>
                                <td>1035443</td>
                                <td>O+</td>
                                <td>Falabella</td>
                                <td>Italia</td>
                                <td>Contador</td>
                                <td>3143214323</td>
                            </tr>
                            <tr>
                                <td>Loe Guilizzoni</td>
                                <td>1035443</td>
                                <td>B+</td>
                                <td>Falabella</td>
                                <td>Italia</td>
                                <td>Estudiante</td>
                                <td>3103213198</td>
                            </tr>
                        </table>
                        <br>
                    </div>
                </div>
            </div>

            <div class="button-return">
                <a href="../../habitaciones">Regresar</a>
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
