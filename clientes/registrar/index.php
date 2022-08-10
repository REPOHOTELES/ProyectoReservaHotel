<?php
    /**
    * Archivo que contiene el formulario correspondiente para el registro de un nuevo cliente
    * @package   clientes.registrar
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
	$userSession = new UserSession();
    $user = new User();
    if(isset($_SESSION['user'])){
    	$user->updateDBUser($userSession->getSession());
    }else{
    	header('location: ../../login');
    }
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
	<head>
		<link rel="shortcut icon" href="../../res/img/famicon.png" />
		<title>Registrar cliente | Hotel</title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../../css/main.css">
		<link rel="stylesheet" type="text/css" href="../../css/form.css">
		<link rel="stylesheet" type="text/css" href="../../css/alerts.css">
		<link rel="stylesheet" type="text/css" href="../../css/modal.css">
		<link rel="stylesheet" type="text/css" href="../../css/font-awesome.min.css">
		<script type="text/javascript" src="../../js/moment.js"></script>
		<script type="text/javascript" src="../../js/jquery.js"></script>
		<script type="text/javascript" src="../../js/dynamic.js"></script>
		<script type="text/javascript" src="../../js/hotel-db.js"></script>
        <script type="text/javascript" src="../../js/user.js"></script>
	</head>

    <!--Construcción de la vista-->
	<body>
      <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu2.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "registrar"
            */
            setCurrentPage("registrar");
        </script>
        
        <!-- Bloque que contiene el formulario con los campos correspondientes para el proceso de registro de un cliente-->
		<div class="content col-12">
			<div class="wrap-main wrap-main-big col-10 wrap-10 padd">
				
                <form onsubmit="saveUser(); return false;">
                <div class="content-header">
                    <h2 class="title-form">REGISTRAR CLIENTE</h2>
                </div>
				<div class="row">
					<div class="col-12 padd">
						    <?php
						    /**
            				* Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
           					*/
            					include "../../objects/input-client.php";
        					?>
					</div>
				</div>
				<div>
                    <!-- Botón que se encarga de enviar los datos ingresados en los campos del formulario para su posterior almacenamiento en la base de datos -->
					<button class="btn btn-block btn-register">
						<i class="fa fa-check"></i>
						<span>Registrar cliente</span>
					</button>
				</div>
                </form>
			</div>
		</div>
        
		<?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/footer2.php";
            include "../../objects/alerts2.php";
        ?>

        <div id="add-prof" class="modal hideable" onclick="touchOutside(this);";>
            <div class="modal-content col-8 wrap-8">
                <div class="modal-header">
                    <span onclick="hideModal('add-prof');" class="close">&times;</span>
                    <h2>Agregar profesión</h2>
                </div>

                <div class="modal-body">
                    <?php include "../../objects/input-profession.php"; ?>
                    <div>
                        <button class="btn btn-block btn-register" onclick="updateProfession();">
                            <i class="fa fa-check"></i>
                            <span>Registrar profesión</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
	</body>

    <script type="text/javascript">
        function showAllInputs(value){
            var rows=document.getElementsByClassName("card-client")[value].getElementsByClassName("row");
            if(rows[1].style.display == "flex"){
                rows[1].style.display="none";
                rows[2].style.display="none";
                rows[4].style.display="none";
                rows[5].getElementsByClassName("form-group")[0].style.display="none";
                rows[5].getElementsByClassName("form-group")[2].style.display="none";
            }else{
                rows[1].style.display="flex";
                rows[2].style.display="flex";
                rows[4].style.display="flex";
                rows[5].getElementsByClassName("form-group")[0].style.display="initial";
                rows[5].getElementsByClassName("form-group")[2].style.display="initial";
            }
        }
    </script>
</html>
