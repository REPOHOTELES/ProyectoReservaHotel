<?php
    /**
    * Archivo que contiene la información de reporte
    * @package   reportes.excel
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */
    
    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
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
    $date="";
    if(isset($_GET['date'])){
        $date = $_GET['date'];      
    }
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Reportes | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../../css/main.css">
        <link rel="stylesheet" type="text/css" href="../../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../../css/form.css">
        <link rel="stylesheet" type="text/css" href="../../css/table.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
        <script type="text/javascript" src="../../js/moment.js"></script>
        <script type="text/javascript" src="../../js/dynamic.js"></script>
        <script type="text/javascript" src="../../js/jquery.js"></script>
    </head>
    
    <!--Construcción de la vista-->
    <body onload ="getDate('control-date-prev',-1); getDate('control-date-last',0);">  
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
            setCurrentPage("consultar");
        </script>

        <!--Bloque que contiene una tabla encargada de mostrar la información de las habitaciones presentes en el hotel, y su estado dependiendo de una fecha establecida-->
        <div class="col-12 content">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header">
                    <h2 class="title-form col-12">REPORTE DE ESTADISTICAS POR MES</h2>
                </div>
                
                <div class="history-room">
                    <div class="view-date-history">
                        <label><b>Elija la fecha del reporte</b></label>
                        <br><br>
                        <div class="row">
                            <form action="plantilla.php" method="post">
                                <div class="form-group in-row">
                                    <label class="form-control-label">Fecha para reporte</label>
                                    
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input id="doc-date" class="form-control" type="month" min="2017-01" max="<?php echo date("Y-m");?>" value="<?php echo date("Y-m", strtotime(date("Y-m")."- 1 month"));?>" name="dateReport">
                                        </div>
                                
                                    <small class="form-text text-muted">ej. abril de 2022</small>
                                </div>
                                <div class="form-group in-row">
                                    <button type="submit" class="btn btn-block btn-register">
                                        <i class="fa fa-file-excel-o"></i>
                                        <span>Imprimir reporte</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
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
