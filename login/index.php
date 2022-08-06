<?php
    /**
    * Este archivo contiene el inicio de sesión
    * @package   login
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
    */
	require_once '../includes/classes.php';
	$userSession = new UserSession();
    $user = new User();
    $errorLogin='';
    try {
        if(isset($_SESSION['user'])){
            $user->updateDBUser($userSession->getSession());
            setHeader($user->getRole());
        }else if(isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            
            if($user->exists($username,$password)){
                $userSession->setSession($username);
                $user->updateDBUser($username);
                setHeader($user->getRole());
            }else{
                $errorLogin='Nombre de usuario o contraseña incorrecto';
            }
        }
    } catch (\Throwable $th) {
        $errorLogin='Hubo un problema con la conexión a la base de datos. Si el problema persiste contacte al administrador.';
    }


    /**
    * Asigna un valor a la cabecera dependiendo del rol pedido por parámetro
    * @param $role Rol del usuario que está intentando iniciar sesión
    */
    function setHeader($role){
    	switch ($role) {
    		case 5:
                header('location: ../inicio');
                break;
            case 4:
                header('location: ../control_diario?date='.date('Y-m-d'));
                break;
            case 1:
                header('location: ../inicio');
                break;
    	}
    	
    }
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Login | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/res/img/famicon.png" />
        <link rel="manifest" href="/manifest.json">
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/login.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/alerts.css">
        <script type="text/javascript" src="/js/moment.js"></script>
        <script type="text/javascript" src="/js/dynamic.js"></script>
    </head>
    
    <!--Construcción de la vista-->
    <body>
        <!--Contiene un formulario con la información mínima para ingresar al sistema-->
        <div class="aux-content col-12"></div>
	    <div class="content col-12">
            <div class="wrap-log marco wrap-main col-5 wrap-5 ">
                <div class=" form-log">
                    <h2 class="title-form">INICIAR SESIÓN</h2>
                    <br>
                    <form action="" method="POST">
                        <?php echo '<p>'.$errorLogin.'</p>'; ?>
                        <div class="input-block-login">
                            <label>Nombre de usuario: </label>
                            <br>
                            <input type="text" name="username" placeholder="nombre.apellido" required>
                        </div>
                        <br>
                        <div class="input-block-login">
                            <label>Contraseña: </label>
                            <br>
                            <input type="password" name="password" placeholder="Contraseña" required>
                        </div>
                        <button type="submit">Iniciar sesión</button>
                        <br>
                    </form>
                </div>
            </div>
        </div>
        
        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../objects/alerts.php"; 
            include "../objects/footer.php"; 
        ?>
        
    </body>
</html>
