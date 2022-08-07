<?php
    /**
    * Archivo que contiene la información pertinente a las habitaciones almacenadas en la base de datos
    * @package   habitaciones
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */
    
    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
    */
    require_once '../includes/classes.php';
    $consult=new Consult();
    $user = new User();
    $userSession = new UserSession();
    
    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
    }else{
        header('location: ../login');
    }
    $date="";
    if(isset($_GET['date'])){
        $date = $_GET['date'];      
    }
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Habitaciones | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <script type="text/javascript" src="../js/moment.js"></script>
        <script type="text/javascript" src="../js/dynamic.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
    </head>
    
    <!--Construcción de la vista-->
    <body onload ="getDate('control-date-prev',-1); getDate('control-date-last',0);">  
        <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../objects/menu.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "control-diario"
            */
            setCurrentPage("control-diario");
        </script>

        <!--Bloque que contiene una tabla encargada de mostrar la información de las habitaciones presentes en el hotel, y su estado dependiendo de una fecha establecida-->
        <div class="col-12 content">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header">
                    <h2 class="title-form col-10">HISTORIAL DE HABITACIONES</h2>
                </div>
                
                <div class="history-room">
                    <div class="view-date-history">
                        <label><b>Fecha de visualización</b></label>
                        <br><br>
                        <div class="row">
                            <div class="form-group in-row">
                                <label class="form-control-label">Fecha inicial</label>
                                <div class="input-group">
                                    <div class="input-group-icon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="doc-date" class="form-control" type="date">
                                </div>
                                <small class="form-text text-muted">ej. 10/11/2019</small>
                            </div>
                            <div class="form-group in-row">
                                <label class="form-control-label">Fecha final</label>
                                <div class="input-group">
                                    <div class="input-group-icon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="doc-date" class="form-control" type="date">
                                </div>
                                <small class="form-text text-muted">ej. 12/11/2004</small>
                            </div>
                        </div>
                    </div>
            
                    <div>
                        <label><b>Habitación</b></label>
                        <select class="lista-habitaciones">
                            <option>201</option>
                            <option>202</option>
                            <option>301</option>
                            <option>302</option>
                            <option>303</option>
                            <option>304</option>
                            <option>401</option>
                            <option>402</option>
                            <option>403</option>
                            <option>404</option>
                            <option>501</option>
                            <option>502</option>
                            <option>503</option>
                            <option>504</option>
                            <option>601</option>
                            <option>602</option>
                            <option>603</option>
                        </select>
                    </div>
                </div>
                <div class="scroll-block">
                <table>
                    <thead>
                        <tr>
                            <th>Día</th>
                            <th>Hora</th>
                            <th>Huésped(es)</th>
                            <th>Valor consumo ($)</th>
                            <th>Actividad</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
        </div>
        
        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../objects/footer.php"; 
        ?>
    </body>
</html>
