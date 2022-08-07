<?php
    /**
    * Archivo que contiene la información pertinente a los usuarios almacenados en la base de datos
    * @package   usuarios
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
        if($user->getRole()!=1&&$user->getRole()!=5)
             header('location: ../login');
    }else{
        header('location: ../login');
    }

    if(isset($_GET['id']))
        $id=$_GET['id'];
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Usuarios | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <script type="text/javascript" src="../js/moment.js"></script>
        <script type="text/javascript" src="../js/dynamic.js"></script>
        <script type="text/javascript" src="../js/filterSearch.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
    </head>
    
    <!--Construcción de la vista-->
    <body onload = "return filterUser(event)">
        <?php 
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../objects/menu.php"; 
        ?>

        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "consultar"
            */
            setCurrentPage("consultar");
        </script>
        
        <!--Bloque cuyo contenido se basa en una tabla que presenta la información más relevante de los clientes registrados en la base de datos-->
        <div class="col-12 content">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header col-12">
                    <div class="row-simple col-12">
                        <h2 class="title-form col-10">USUARIOS REGISTRADOS</h2>
                        <a class="button-add-book col-2" href="registrar">Registrar usuario</a>
                        <div class="form-group in-row">
                            <label class="form-control-label"><b>Buscar usuario</b></label>
                            <div class="input-group">
                                <div class="input-group-icon">
                                    <i class="fa fa-search"></i>
                                </div>
                                <input id="inputUser" class="form-control" type="text" placeholder="Documento o nombre" onkeyup="return filterUser(event);">
                            </div>
                            <small class="form-text text-muted">ej. 1052345623 / PEDRO PEREZ</small>
                        </div>
                    </div>
                </div>
                <div class="scroll-block col-12" id="dataUser"></div>
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
