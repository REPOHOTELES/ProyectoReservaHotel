<?php 
    /**
    * Archivo que contiene la información acerca de los detalles de una empresa determinada, registrada en la base de datos
    * @package   empresas.detalles
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

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $e = new Enterprise();
        $e->setIdEnterprise($id);        
    }

?>

<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Detalles de Empresa | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../../css/main.css">
        <link rel="stylesheet" type="text/css" href="../../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../../css/table.css">
        <link rel="stylesheet" type="text/css" href="../../css/form.css">
        <script type="text/javascript" src="../../js/moment.js"></script>
        <script type="text/javascript" src="../../js/dynamic.js"></script>
        <script type="text/javascript" src="../../js/jquery.js"></script>
    </head>

    <!--Construcción de la vista-->
    <body onload ="getDate('control-date',0);">
        <?php 
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu2.php"; 
        ?>

        <script type="text/javascript">
             /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "consultar"
            */
            setCurrentPage("consultar");
        </script>

        <!--Bloque encargado de mostrar la información detallada de una empresa determinada-->
        <div class="content col-12">
            <div class="col-11 wrap-11 wrap-vertical padd">
                 <div class="content-header col-12">
                    <div class="row-simple col-12">
                        <h2 class="title-form ">DETALLES EMPRESA</h2>
                    </div>
                </div>

                 <div class="sub-menu col-12 padd">
                    <button id="back-btn" class="btn" onclick="window.history.back();">Volver</button>
                    <div class="sub-menu-right">
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <strong>Información general</strong>
                    </div>

                    <div class="card-body">
                            <label><b>NIT: &ensp;</b></label>
                            <label><?php echo $e->getNit();?></label>
                            <label><b>Nombre: &ensp;</b></label>
                            <label><?php echo $e->getName();?></label>
                            <label><b>Teléfono: &ensp;</b></label>
                            <label><?php echo $e->getPhone();?></label>
                            <label><b>Retefuente (3,5%): &ensp; </b></label>
                            <label><?php echo ($e->getSourceRetention() == 1) ? "Sí" : "No";?></label> 
                            <label><b>ICA ($): &ensp;</b></label>
                            <label> <?php echo ($e->getICA()==1 ? "Sí":"No"); ?></label>
                    </div>
                </div>

                <div class="col-12 marco">
                    <div class="card-header">
                        <strong>HUÉSPEDES AUTORIZADOS POR LA EMPRESA</strong>
                    </div>

                    <div class="scroll-block col-12">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Número de Documento</th>
                                    <th>Fecha de check-in</th>
                                    <th>Fecha de check-out</th>
                                </tr>
                            </thead>
                            <?php $consult->enterpriseCustomTable($id)?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/footer2.php"; 
        ?>
    </body>
</html>
