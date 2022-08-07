<?php
    /**
    * Archivo que contiene la información pertinente a la edición de los clientes almacenados en la base de datos
    * @package   clientes.editar
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
        $id = $_GET['id'];
        $person = new Person();
        $person->setId($id);        
    }
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Clientes | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../../css/main.css">
        <link rel="stylesheet" type="text/css" href="../../css/form.css">
        <link rel="stylesheet" type="text/css" href="../../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../../css/font-awesome.min.css">
        <script type="text/javascript" src="../..js/moment.js"></script>
        <script type="text/javascript" src="../../js/dynamic.js"></script>
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/cliente.js"></script>
    </head>
    
    <!--Construcción de la vista-->
    <body onload="<?php echo 'defineUpdate('.$id.','.$person->getidSignRh().','.$person->getIdBlood().')';?>">
        <?php 
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu.php"; 
        ?>
        
        <!--El bloque de información personal presenta bloques con los datos correspondientes al cliente que se desea editar -->
       <div class="content col-12 padd">
            <div class="wrap-main wrap-main-big col-10 wrap-10 padd">
                <div class="content-header">
                    <h2 class="title-form">EDITAR CLIENTE</h2>
                </div>
                
                <div class="sub-menu col-12 padd">
                    <button id="back-btn" class="btn" onclick="window.history.back();">Volver</button>
                </div>

                <div class="row-simple">
                    <div class="col-12 padd">
                        <form onsubmit="updateCustomer(); return false;">
                        <div class="card card-client">
                            <div class="card-header">
                                <i class="fa fa-user"></i>
                                <strong class="card-title">Información personal</strong>
                            </div>

                            <div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group in-row col-6 padd">
                                            <label class="form-control-label">Nombres*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Nombres" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" maxlength="60" minlength="2" value="<?php echo $person->getName();?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-6 padd">
                                            <label class="form-control-label">Apellidos*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Apellidos" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" minlength="2" maxlength="60" value="<?php echo $person->getLastName();?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row row-flag" state="hide">
                                        <div class="form-group in-row col-5 padd">
                                            <label class="form-control-label">Tipo de documento*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-id-card"></i>
                                                </div>
                                                <select id="doc-type" class="form-control" required>
                                                    <option value="CC">Cédula de ciudadania</option>
                                                    <option value="RC">Registro civil</option>
                                                    <option value="TI">Tarjeta de identidad</option>
                                                    <option value="CE">Cedula de extranjeria</option>
                                                    <option value="PS">Pasaporte</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-7 padd">
                                            <label class="form-control-label">Número de documento*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-id-card"></i>
                                                </div>
                                                 <input class="form-control" type="text" placeholder="Número de documento" minlength="6" maxlength="15" value="<?php echo $person->getNumberDocument();?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group in-row col-7 padd">
                                            <label class="form-control-label">Pais (Expedición)*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>

                                                <select id="exp-country" class="form-control" onchange="updateCities(this);" required>
                                                    <?php $consult->getList('country',''); ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group in-row col-5 padd">
                                            <label class="form-control-label">Ciudad (Expedición)*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>

                                                <select id="exp-city" class="form-control" required>
                                                    <?php $consult->getList('city','1'); ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">TelÉfono*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <input class="form-control phone-mask" type="text" placeholder="Telefono" maxlength="15" minlength="7" onkeydown="$(this).mask('000 000 0000');" value="<?php echo $person->getPhone();?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-8 padd">
                                            <label class="form-control-label">Correo electrónico</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                                 <input class="form-control" type="email" placeholder="Correo electrónico" value="<?php echo $person->getEmail();?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="form-group in-row col-3 padd">
                                            <label class="form-control-label">Género*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-intersex"></i>
                                                </div>

                                                <select id="gender" class="form-control" required>
                                                    <option value="M">Hombre</option>
                                                    <option value="F">Mujer</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">Fecha de nacimiento*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input class="form-control" type="date" value="<?php echo $person->getBirthDate();?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-5 padd">
                                            <label class="form-control-label">Tipo de sangre*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-heartbeat"></i>
                                                </div>

                                                <select id="blood" class="form-control col-3 padd" required>
                                                    <option value="O">O</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="AB">AB</option>
                                                </select>

                                                 <select id="rh" class="form-control col-9 padd" required>
                                                    <option value="+">+ (Positivo)</option>
                                                    <option value="-">- (Negativo)</option>
                                                </select>
                                             </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">Profesión</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-bank"></i>
                                                </div>

                                               <select id="profession" class="form-control">
                                                    <option value="NULL">Ninguna</option>
                                                    <?php $consult->getList('profession',''); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class=" form-group in-row col-8 padd">
                                            <label class="form-control-label">Nacionalidad*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>

                                                <select id="exp-nat" class="form-control" onchange="updateCities(this);" required>
                                                    <?php $consult->getList('country',''); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script type="text/javascript">
                                document.getElementById("doc-type").value="<?php echo $person->getTypeDocument();?>";
                                document.getElementById("exp-country").value="<?php echo 1;?>";
                                document.getElementById("exp-city").value="<?php echo $person->getPlaceExpedition();?>";
                                document.getElementById("gender").value="<?php echo $person->getGender();?>";
                                var bloodRh="<?php echo $person->getTypeRH();?>";
                                document.getElementById("blood").value=bloodRh.length==2?bloodRh.substring(0,1):bloodRh.substring(0,2);
                                document.getElementById("rh").value=bloodRh.substring(bloodRh.length-1);
                                document.getElementById("profession").value=("<?php echo $person->getProfession();?>"==""?"NULL":"<?php echo $person->getProfession();?>");
                            </script>
                        </div>
                        <div>
                            <!-- Botón que se encarga de enviar los datos ingresados en los campos del formulario para su posterior edicion en la base de datos -->
                           <button class="btn btn-block btn-register">
                               <i class="fa fa-check"></i>
                               <span>Editar cliente</span>
                           </button>
				        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Presenta el botón correspondiente a la actualización de los datos del cliente -->

        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/footer.php";
            include "../../objects/alerts.php";
        ?>

        <div style="display: none;">
            <div id="room-group" class="room-group col-12">
                <div class="col-12 padd row-simple">
                    <?php 
                        include "../../objects/input-room.php";
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
