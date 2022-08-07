<?php
    /**
    * Archivo que contiene el formulario correspondiente para el registro de un nuevo cliente
    * @package   usuarios.editar
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

    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $user2=new User();
        $user2->setId($id);
    }
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
	<head>
		<link rel="shortcut icon" href="../../res/img/famicon.png" />
		<title>Editar Usuario | Hotel</title>
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
        <script type="text/javascript" src="../../js/jquerymask.js"></script>
		<script type="text/javascript" src="../../js/dynamic.js"></script>
		<script type="text/javascript" src="../../js/hotel-db.js"></script>
        <script type="text/javascript" src="../../js/user.js"></script>
	</head>

    <!--Construcción de la vista-->
	<body onload="<?php echo 'defineUpdate('.$user2->getRole().','.$id.')';?>">
      <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "editar"
            */
            setCurrentPage("editar");
        </script>
        <!-- Bloque que contiene el formulario con los campos correspondientes para el proceso de registro de un cliente-->
		 <div class="content col-12 padd">
            <div class="wrap-main wrap-main-big col-10 wrap-10 padd">
                <form onsubmit="updateUser(); return false;">
                <div class="content-header">
                    <h2 class="title-form">EDITAR USUARIO</h2>
                </div>
                <div v class="sub-menu col-12 padd">
                    <button id="back-btn" class="btn" onclick="window.history.back();">Volver</button>
                </div>

                <div class="row-simple">
                    <div class="col-12 padd">
                        <div class="card card-client">
                            <div class="card-header">
                                <i class="fa fa-user"></i>
                                <strong class="card-title">Información personal</strong>
                            </div>

                            <div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="form-group in-row col-6 padd">
                                            <label class="form-control-label">Nombres</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Nombres" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" maxlength="60" minlength="2" value="<?php echo $user2->getName();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. PEDRO LUIS</small>
                                        </div>

                                        <div class="form-group in-row col-6 padd">
                                            <label class="form-control-label">Apellidos</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Apellidos" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);"  minlength="2" maxlength="60" value="<?php echo $user2->getLastName();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. LOPEZ LOPEZ</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group in-row col-3 padd">
                                            <label class="form-control-label">Tipo de documento</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-id-card"></i>
                                                </div>

                                                <select class="form-control">
                                                    <option value="CC">Cédula de ciudadanía</option>
                                                    <option value="RC">Registro civil</option>
                                                    <option value="TI">Tarjeta de identidad</option>
                                                    <option value="CE">Cedula de extranjería</option>
                                                    <option value="PS">Pasaporte</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">Número de documento</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-id-card"></i>
                                                </div>
                                                 <input class="form-control" type="text" placeholder="Número de documento"  minlength="6" maxlength="15" onkeydown="$(this).mask('000000000000000');" value="<?php echo $user2->getNumberDocument();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. 123456789</small>
                                        </div>
                                        
                                        <div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">Teléfono</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <input class="form-control phone-mask" type="text" placeholder="Telefono" maxlength="15" minlength="7" onkeydown="$(this).mask('000 000 0000');" value="<?php echo $user2->getPhone();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. 3123334466</small>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">Cargo</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>

                                                <select class="form-control">
                                                    <?php $consult->getList('role');?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group in-row col-6 padd">
                                            <label class="form-control-label">Correo</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                                 <input class="form-control" type="email" placeholder="Correo electrónico" value="<?php echo $user2->getEmail();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. pedro.lopez@mail.com</small>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
										<div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">Nombre de usuario</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Nombre de usuario" maxlength="50" minlength="3" value="<?php echo $user2->getUserName();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. pedro.lopez</small>
                                        </div>

										<div class="form-group in-row col-4 padd">
											<label class="form-control-label">Contraseña*</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-lock"></i>
												</div>
												<input class="form-control" type="password" placeholder="Contraseña" minlength="8" maxlength="60" required>
											</div>
										</div>
                                        
                                        <div class="form-group in-row col-4 padd">
											<label class="form-control-label">Repetir contraseña*</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-lock"></i>
												</div>
												<input class="form-control" type="password" placeholder="Repetir Contraseña" minlength="8" maxlength="60" required>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <!-- Botón que se encarga de enviar los datos ingresados en los campos del formulario para su posterior edicion en la base de datos -->
                           <button class="btn btn-block btn-register">
                               <i class="fa fa-check"></i>
                               <span>Editar Usuario</span>
                           </button>
				        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        
		<?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/footer.php";
            include "../../objects/alerts.php";
        ?>

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
