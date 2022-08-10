<?php
    require_once 'includes/classes.php';

    $consult=new Consult();
    $user = new User();
    $userSession = new UserSession();
    
    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
    }else{
        header('location: ./login');
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>No existe esta página</title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="res/img/famicon.png" />
        <link rel="manifest" href="manifest.json">
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/inicio.css">
        <script type="text/javascript" src="js/moment.js"></script>
        <script type="text/javascript" src="js/dynamic.js"></script>
	</head>

	<body>
		 <div class="content col-12">
            <div class="wrap-main col-8 wrap-8 wrap-vertical">
                <div class="title">
                    <p><strong>ESTA PAGINA NO EXISTE</strong></p>
                </div>
                    <a href="./inicio" class="button">
                        <p>Inicio</p>
                        <img src="../res/img/home-icon-white.png">
                    </a>
            </div>
        </div>
        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "objects/alerts.php"; 
            include "objects/footer.php"; 
        ?>
	</body>
</html>
