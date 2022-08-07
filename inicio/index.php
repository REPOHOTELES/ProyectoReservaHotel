<?php
    /**
    * Archivo que contiene el menú principal, visible para la parte administrativa de la aplicación web
    * @package   inicio
    * @author    grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Incluye la implementación de la clase denominada classes
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
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Inicio | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../res/img/famicon.png" />
        <link rel="manifest" href="../manifest.json">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <link rel="stylesheet" type="text/css" href="../css/inicio.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <script type="text/javascript" src="../js/moment.js"></script>
        <script type="text/javascript" src="../js/dynamic.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
    </head>
    <body>
        
        <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../objects/menu.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "inicio"
            */
            setCurrentPage("inicio");
        </script>
    
        <!--Bloque encargado de presentar el menú que contiene los módulos correspondientes al servicio que presta la aplicación web-->
        <div class="content col-12">
            <div class="wrap-main col-8 wrap-8 wrap-menu">
                <div class="title">
                    <p><strong>HOTEL</strong></p>
                </div>
                <?php if($user->getRole()!=4):?>
                    <a href="../reservas/" class="button">
                        <p>Reservas</p>
                        <img src="../res/img/book-icon-white.png">
                    </a>
                <?php endif;?>
                    <a onclick="window.location.href = '../control_diario?date='+getDate(0);" class="button">
                        <p>Control diario</p>
                        <img src="../res/img/control-icon-white.png">
                    </a>
                   
                    <?php if($user->getRole()==5||$user->getRole()==1):?>
                    <a href="../usuarios/" class="button">
                        <p>Usuarios</p>
                        <img src="../res/img/use-whiter.png">
                    </a>
                     <?php endif;
                     if($user->getRole()!=4):?>
                    <a href="../empresas/" class="button">
                        <p>Empresas</p>
                        <img src="../res/img/company-white.png">
                    </a>
                    <a href="../facturas/" class="button">
                        <p>Facturación</p>
                        <img src="../res/img/bill-icon-white.png">
                    </a>
                    <a href="../reportes/" class="button">
                        <p>Reportes</p>
                        <img src="../res/img/report-white.png">
                    </a>
                <?php endif;?>
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
