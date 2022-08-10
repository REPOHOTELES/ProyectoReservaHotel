<?php
    /**
    * Archivo que contiene la información pertinente a los detalles reserva 
    * @package   clientes.detalles
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
        $id=$_GET['id'];
        $person=new Person();
        $person->setId($id);
    }
    
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Detalles del cliente | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../../res/img/famicon.png" />
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../../css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../../css/main.css">
        <link rel="stylesheet" type="text/css" href="../../css/form.css">
        <link rel="stylesheet" type="text/css" href="../../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../../css/modal.css">
        <link rel="stylesheet" type="text/css" href="../../css/table.css">
        <script type="text/javascript" src="../../js/moment.js"></script>
        <script type="text/javascript" src="../../js/dynamic.js"></script>
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/user.js"></script>
    </head>

    <!--Construcción de la vista-->
    <body onload ="getDays();">
    
        <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu2.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "control-diario"
            */
            setCurrentPage("control-diario");
        </script>
        
        <!--El bloque contiene la información correspondiente a los detalles de control de una habitación en una fecha especificada-->
        <div class="content col-12 padd">
            <div class="wrap-main wrap-main-big col-10 wrap-10 padd">
                <div class="content-header">
                    <h2 class="title-form">DETALLES DEL CLIENTE</h2>
                </div>

                <div class="sub-menu col-12 padd">
                    <button id="back-btn" class="btn" <?php if(isset($person)):?>style="float: left;"<?php endif;?> onclick="window.history.back();">Volver</button>
                    <?php if(isset($person)):?>
                    <div class="sub-menu-right">
                        <button id="edit-btn" class="btn" onclick="window.location.href='../editar?id='+<?php echo $id;?>">Editar</button>
                        <button id="delete-btn" class="btn btn-red" onclick="showModal('confirm-delete')">Eliminar</button>
                    </div>
                    <?php endif;?>
                </div>
                <?php if(isset($person)):?>
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
                                            <label class="form-control-label">Nombres*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Nombres" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" maxlength="60" minlength="2" disabled value="<?php echo $person->getName();?>">
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-6 padd">
                                            <label class="form-control-label">Apellidos*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Apellidos" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" minlength="2" maxlength="60"  disabled value="<?php echo $person->getLastName();?>">
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
                                                <select id="doc-type" class="form-control" disabled>
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
                                                 <input class="form-control" type="text" placeholder="Número de documento" minlength="6" maxlength="15" disabled value="<?php echo $person->getNumberDocument();?>">
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

                                                <select id="exp-country" class="form-control" onchange="updateCities(this);"  disabled>
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

                                                <select id="exp-city" class="form-control" disabled>
                                                    <?php $consult->getList('city','1'); ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">Telefono*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <input class="form-control phone-mask" type="text" placeholder="Telefono" maxlength="15" minlength="7" onkeydown="$(this).mask('000 000 0000');" disabled value="<?php echo $person->getPhone();?>">
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-8 padd">
                                            <label class="form-control-label">Correo</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                                 <input class="form-control" type="email" placeholder="Correo electrónico" disabled value="<?php echo $person->getEmail();?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="form-group in-row col-3 padd">
                                            <label class="form-control-label">Genero*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-intersex"></i>
                                                </div>

                                                <select id="gender" class="form-control" disabled>
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
                                                <input class="form-control" type="date" disabled value="<?php echo $person->getBirthDate();?>">
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-5 padd">
                                            <label class="form-control-label">Tipo de sangre*</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-heartbeat"></i>
                                                </div>

                                                <select id="blood" class="form-control col-3 padd" disabled>
                                                    <option value="O">O</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="AB">AB</option>
                                                </select>

                                                 <select id="rh" class="form-control col-9 padd" disabled>
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

                                               <select id="profession" class="form-control" disabled>
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

                                                <select id="exp-nat" class="form-control" onchange="updateCities(this);"  disabled>
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
                                var sign = document.getElementsByTagName("select")[5];
                                sign.selectedIndex = <?php echo $person->getidSignRh();?>;
                                var blood = document.getElementsByTagName("select")[4];
                                blood.selectedIndex = <?php echo $person->getIdBlood();?>;
                                document.getElementById("profession").value=("<?php echo $person->getProfession();?>"==""?"NULL":"<?php echo $person->getProfession();?>");
                            </script>
                        </div>
                    </div>
                </div>
                <?php else:?>
                <div>
                    No se ha seleccionado ningun cliente.
                </div>
                <?php endif;?>
            </div>
        </div>
        
        <script type="text/javascript">
            function deleteBooking(id){
                $.ajax({
                    type:'post',
                    url:'../../includes/update.php',
                    data:'action=deleteBooking&id='+id
                }).then(function(ans){
                    var data=ans.split(";");
                    showAlert(data[0],data[1]);
                    setTimeout(function(){
                        location.href='../../clientes';
                    }, 2000);
                });
            }
        </script>
        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/alerts2.php"; 
            include "../../objects/footer2.php"; 
        ?>

        <div id="confirm-delete" class="modal hideable" onclick="touchOutside(this);">
            <div class="modal-content col-3 wrap-3">
                 <div class="modal-header">
                    <span onclick="hideModal('confirm-delete');" class="close">&times;</span>
                    <h2>Confirmar eliminación</h2>
                </div>

                <div class="modal-body">
                    <div>
                        <div class="card-body">
                            <div style="margin-top: 10px;">
                                Por favor, confirme si desea eliminar este cliente.
                                
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-block btn-register" onclick="deleteUser(<?php echo $id;?>);">
                        <i class="fa fa-check"></i>
                        <span>Confirmar</span>
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
