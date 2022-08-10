<?php
    /**
    * Archivo que contiene la información pertinente a los detalles de un usuario determinado 
    * @package   usuarios.detalles
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 20222.
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
        $user2=new User();
        $user2->setId($id);
    }
    
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Detalle usuario | Hotel</title>
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
    <body onload ="<?php echo 'defineDetailsUser('.$user2->getRole().')';?>">
    
        <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web del hotel
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
                    <h2 class="title-form">DETALLES DEL USUARIO</h2>
                </div>
                <div v class="sub-menu col-12 padd">
                    <button id="back-btn" class="btn" style="float: left;" onclick="window.history.back();">Volver</button>
                    <div class="sub-menu-right">
                        <button id="edit-btn" class="btn" onclick="window.location.href='../editar?id='+<?php echo $id;?>">Editar</button>
                        <button id="delete-btn" class="btn btn-red" onclick="showModal('confirm-delete')">Eliminar</button>
                    </div>
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
                                        <div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">Nombre de usuario</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Nombre de usuario" maxlength="50" minlength="3" disabled value="<?php echo $user2->getUserName();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. pedro.lopez</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group in-row col-6 padd">
                                            <label class="form-control-label">Nombres</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Nombres" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" maxlength="60" minlength="2" disabled value="<?php echo $user2->getName();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. PEDRO LUIS</small>
                                        </div>

                                        <div class="form-group in-row col-6 padd">
                                            <label class="form-control-label">Apellidos</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>
                                                <input class="form-control" type="text" placeholder="Apellidos" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);"  minlength="2" maxlength="60" disabled value="<?php echo $user2->getLastName();?>">
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

                                                <select class="form-control" disabled>
                                                    <option value="CC">Cédula de ciudadania</option>
                                                    <option value="RC">Registro civil</option>
                                                    <option value="TI">Tarjeta de identidad</option>
                                                    <option value="CE">Cedula de extranjeria</option>
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
                                                 <input class="form-control" type="text" placeholder="Número de documento"  minlength="6" maxlength="15" onkeydown="$(this).mask('000000000000000');" disabled value="<?php echo $user2->getNumberDocument();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. 123456789</small>
                                        </div>
                                        
                                        <div class="form-group in-row col-4 padd">
                                            <label class="form-control-label">Teléfono</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <input class="form-control phone-mask" type="text" placeholder="Telefono" maxlength="15" minlength="7" onkeydown="$(this).mask('000 000 0000');" disabled value="<?php echo $user2->getPhone();?>">
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

                                                <select class="form-control" disabled>
                                                    <?php $consult->getList('role');?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group in-row col-6 padd">
                                            <label class="form-control-label">Correo electrónico</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                                 <input class="form-control" type="email" placeholder="Correo electrónico" disabled value="<?php echo $user2->getEmail();?>">
                                            </div>
                                            <small class="form-text text-muted">ej. pedro.lopez@mail.com</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
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
                                POR FAVOR, CONFIRME SI DESEA ELIMINAR AL USUARIO <?php echo " ".$user2->getName()." ".$user2->getLastName();?>
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
