<?php
    /**
    * Archivo que contiene la información pertinente a los detalles reserva 
    * @package   control_diario.detalles
    * @author    Grupo 3 SW 2
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

    $id="";

    if(isset($_GET['id']))
        $id=$_GET['id'];
    $reservation=new Reservation();
    $reservation->setId($id);
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
	<head>
		<title>Control por habitación | Hotel</title>
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
	</head>

	<!--Construcción de la vista-->
	<body onload ="getDays();">
	
        <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "control-diario"
            */
            setCurrentPage("control-diario");
        </script>
        
        <!--El bloque contiene la información correspondiente a los detalles de control de una habitación en una fecha especificada-->
        <div class="content col-12 padd">
            <div class="wrap-main wrap-main-big col-11 wrap-11 padd">
                <div class="content-header">
                    <h2 class="title-form">DETALLES DE LA RESERVA</h2>
                </div>

                <div class="sub-menu col-12 padd">
                    <button id="back-btn" class="btn" style="float: left;" onclick="window.history.back();">Volver</button>
                    <div class="sub-menu-right">
                        <button id="edit-btn" class="btn" onclick="window.location.href='../editar?id='+<?php echo $id;?>">Editar</button>
                        <button id="delete-btn" class="btn btn-red" onclick="showModal('confirm-delete')">Eliminar</button>
                    </div>
                </div>

                <div class="row-simple">
                    <div class="col-4 padd">
                        <div class="card">
                            <div class="card-header">
                                <strong>Información primaria</strong>
                            </div>

                            <div class="card-body">
                                <div class="form-group in-row">
                                    <label class="form-control-label">Fecha de llegada</label>
                                    <div class="input-group">
                                        <div class="input-group-icon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input id="start-date" type="date" class="form-control" value="<?php echo $reservation->getStartDate();?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group in-row">
                                    <label class="form-control-label">Fecha de salida</label>
                                    <div class="input-group">
                                        <div class="input-group-icon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input id="finish-date" type="date" class="form-control" value="<?php echo $reservation->getFinishDate();?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group in-row">
                                    <label class="form-control-label">Cantidad de noches</label>
                                    <div class="input-group">
                                        <div class="input-group-icon">
                                            <i class="fa fa-moon-o"></i>
                                        </div>
                                        <input id="count-nights" type="text" class="form-control"  disabled>
                                    </div>
                                </div>

                                <div class="form-group in-row">
                                    <label class="form-control-label">Cantidad de habitaciones</label>
                                    <div class="input-group">
                                        <div class="input-group-icon">
                                            <i class="fa fa-bed"></i>
                                        </div>
                                        <input id="rooms" type="text" value="<?php echo $reservation->getRoomsQuantity();?>" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-8 padd">
                        <div class="card">
                            <div class="card-header">
                                <strong>Titular</strong>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group in-row col-6 padd">
                                        <label class="form-control-label">Nombre</label>
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-user-o"></i>
                                            </div>
                                            <input class="form-control" type="text"  onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" maxlength="60" minlength="2" value="<?php echo $reservation->getTitular()->getName();?>" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group in-row col-6 padd">
                                        <label class="form-control-label">Documento</label>
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-id-card"></i>
                                            </div>
                                            <input class="form-control" type="text" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" minlength="2" maxlength="60" value="<?php echo $reservation->getTitular()->getIdentification();?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group in-row col-6 padd">
                                        <label class="form-control-label">Telefono</label>
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input class="form-control" type="text" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" maxlength="60" value="<?php echo $reservation->getTitular()->getPhone();?>" minlength="2" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group in-row col-6 padd">
                                        <label class="form-control-label">Correo</label>
                                        <div class="input-group">
                                            <div class="input-group-icon">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                            <input class="form-control" type="text" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" minlength="2" maxlength="60" value="<?php echo $reservation->getTitular()->getEmail();?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="marco col-12">
                        <div class="scroll-block">
                            <table>
                                <tr>
                                    <th>Habitación</th>
                                    <th>Huesped</th>
                                </tr>
                                <?php $consult->getBookingTable($id); ?>
                            </table>
                        </div>
                    </div>
                </div>
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
                        location.href='../../reservas';
                    }, 2000);
                });
            }
        </script>
        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/alerts.php"; 
            include "../../objects/footer.php"; 
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
                                Por favor, confirme si desea eliminar esta reserva.
                                <br>
                                Recuerde que los clientes agregados no serán borrados con esta acción.<br>
                                Para borrarlos se recomienda ir a <a href="/clientes">Consultar clientes</a> para esta acción.
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-block btn-register" onclick="deleteBooking(<?php echo $id;?>);">
                        <i class="fa fa-check"></i>
                        <span>Confirmar</span>
                    </button>
                </div>
            </div>
        </div>

        <?php
            /**
            * Incluye la implementación de la clase FOOTER, archivo que crea el footer superior de la aplicación web
            */
            include "../../objects/footer.php"; 
        ?>
    </body>
</html>
