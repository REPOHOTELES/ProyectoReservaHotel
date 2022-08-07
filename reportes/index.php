<?php
    /**
    * Archivo que contiene la información de reporte
    * @package   reportes
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
        <title>Reportes | Hotel Aristo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <link rel="stylesheet" type="text/css" href="../css/modal.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
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
            setCurrentPage("consultar");
        </script>

        <!--Bloque que contiene una tabla encargada de mostrar la información de las habitaciones presentes en el hotel, y su estado dependiendo de una fecha establecida-->
        <div class="col-12 content">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header">
                    <h2 class="title-form col-12">VISUALIZACIÓN DE REPORTES</h2>
                </div>
                
                <div class="history-room">
                    <div class="view-date-history">
                        <label><b>Elija el reporte que desea generar</b></label>
                        <br><br>
                        <div class="row">
                            <div class="form-group in-row">
                                <button type="button" onclick="showModal('stadistics');" class="button-add-book col-12">
                                    <span>ESTADISTICAS MENSUALES DEL VALOR DEL HOSPEDAJE</span>
                                </button>
                                <button type="button" onclick="location.href = '../reportes/empresas';" class="button-add-book col-12">
                                    <span>EMPRESAS REGISTRADAS EN LA BASE DE DATOS</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!----FIN DE LA PAGINA PRINCIPAL---->
        
        <div id="stadistics" class="modal hideable" onclick="touchOutside(this);">
			<div class="modal-content col-6 wrap-6">
                <div class="modal-header">
                    <span onclick="hideModal('stadistics');" class="close">&times;</span>
                    <h2>ESTADISTICAS MENSUALES DE HOSPEDAJE</h2>
                </div>

                <div class="modal-body">
                	<?php include "../objects/input-statics-report.php"; ?>
                </div>
            </div>
		</div>
        
        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../objects/footer.php"; 
        ?>
        
        
        <div style="display: none;">
        	<div id="room-group" class="room-group col-12">
        		<div class="col-12 padd row-simple">
        			<?php 
        				include "../objects/input-statics-report.php";
        			?>
        		</div>

        		<div class="col-12 padd row-simple client-cards">
        			<?php 
        				include "../objects/input-client.php";
        			?>
        		</div>
        	</div>
        	
        	<div id="form-group" class="form-group in-row">
        		<label class="form-control-label"></label>
        		<div class="input-group">
        			<div class="input-group-icon">
        				<i class="fa"></i>
        			</div>
        		<label class="form-control"></label>
        		</div>
        	</div>
        </div>
        
    </body>
</html>
