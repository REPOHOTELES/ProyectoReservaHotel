<?php
    /**
    * Archivo que contiene la información pertinente a los detalles de control de una habitación en una fecha especificada
    * @package   control_diario.detalles
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
        $room=new Room();
        $room->setId($_GET['id']);
    }

    if(isset($_GET['res'])){
        $reservation=new Reservation();
        $reservation->setId($_GET['res']);
        $reservation->setRoom($_GET['id']);

        if($_GET['res']=="")
            $reservation=false;
    }
    
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
	<head>
		<title>Control por habitación <?php echo $room->getNumber(); ?> | Hotel</title>
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
            <div class="wrap-main wrap-main-big col-10 wrap-10 padd">
                <div class="content-header">
                    <h2 class="title-form">DETALLES DE LA HABITACIÓN <?php echo $room->getNumber();?></h2>
                </div>

                <div class="sub-menu col-12 padd">
                    <button id="back-btn" class="btn" onclick="window.history.back();">Volver</button>
     
                </div>
                <?php if($reservation): ?>
                <div class="row-simple">
                    <div class="col-3 padd">
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
                            </div>
                        </div>
                    </div>

                    <div class="col-9 padd">
                        <div class="marco col-12">
                           <div class="card-header">
                                <strong>Huéspedes en la habitación</strong>
                            </div>
                            <div id="confirm-check-up" class="scroll-block">
                                <table>
                                    <tr>
                                        <th>Huésped</th>
                                        <th>No. documento</th>
                                        <th>Teléfono</th>
                                        <th>Check up<br>
                                            <label class="switch switch-table">
                                                <input id="main-switch-check-up" type="checkbox" onchange="setAllCheckUp(this);">
                                                <span class="slider slider-gray round green"></span>
                                            </label>
                                        </th>
                                    </tr>
                                    <?php 
                                        $consult->getRoomTable($room->getId(),$reservation->getId()); 
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-6 padd" id="product-block">
                        <div class="card">
                            <div class="card-header">
                                <strong>Consumo de minibar</strong>
                            </div>

                            <div class="marco col-12">
                                <div class="scroll-block">
                                     <table>
                                        <?php $consult->getProducts($reservation->getRoom());?>
                                    </table>
                                </div>
                            </div>
                            <form onsubmit="showConfirm('product'); return false;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group in-row col-7 padd">
                                            <label class="form-control-label">Producto</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>

                                                <select class="form-control">
                                                    <?php $consult->getProductList();?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-5 padd">
                                            <label class="form-control-label">Cantidad</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-id-card"></i>
                                                </div>
                                                <input class="form-control" type="number" value="1" min="1" max="30">
                                                <button class="btn-circle"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-6 padd" id="service-block">
                        <div class="card">
                            <div class="card-header">
                                <strong>Consumo de servicios</strong>
                            </div>

                            <div class="marco col-12">
                                <div class="scroll-block">
                                     <table>
                                    <?php $consult->getServices($reservation->getRoom());?>
                                    </table>
                                </div>
                            </div>

                            <form onsubmit="showConfirm('service'); return false;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group in-row col-7 padd">
                                            <label class="form-control-label">Servicio</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-user-o"></i>
                                                </div>

                                                <select class="form-control">
                                                    <?php $consult->getServiceList();?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group in-row col-5 padd">
                                            <label class="form-control-label">Cantidad</label>
                                            <div class="input-group">
                                                <div class="input-group-icon">
                                                    <i class="fa fa-id-card"></i>
                                                </div>
                                                <input class="form-control" type="number" value="1" min="1" max="30">
                                                <button class="btn-circle"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 padd">
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
                <?php else:?>
                    <div>Esta habitación no tiene nada asignado aun</div>
                <?php endif;?>
                </div>
            </div>
        </div>

        <div id="confirm-payment" class="modal hideable" onclick="touchOutside(this);">
            <div class="modal-content col-3 wrap-3">
                <div id="type" class="hideable"></div>
                 <div class="modal-header">
                    <span onclick="hideModal('confirm-payment');" class="close">&times;</span>
                    <h2></h2>
                </div>

                <div class="modal-body">
                <form id="request-form">
                    <div>
                        <div class="card-body">
                            <div id="confirm-msg" style="margin-top: 10px;">
                            </div>

                            <div id="in-place-form">
                                <br>
                                <div class="switch-group">
                                    <label class="switch switch-container">
                                        <input id="payment-check" type="checkbox" onchange="showPayments(this);">
                                        <span class="slider slider-gray round green"></span>
                                    </label>
                                    <label class="switch-label">Efectuar pago en este momento.</label>
                                </div>

                                <div id="payment-methods" class="form-group hideable">
                                    <br>
                                    <label class="form-control-label">Medio de pago</label>
                                    <div class="input-group">
                                        <div class="input-group-icon">
                                            <i class="fa fa-dollar"></i>
                                        </div>

                                        <select id="payment-method" onchange="showInputPaid(this);" class="form-control">
                                            <option value="E">EFECTIVO</option>
                                            <option value="T">TARJETA</option>
                                            <option value="C">CONSIGNACIÓN</option>
                                            <option value="CC">CUENTAS POR COBRAR</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="input-paid-group" class="form-group hideable">
                                    <br>
                                    <label class="form-control-label">Monto a pagar</label>
                                    <div class="input-group">
                                        <div class="input-group-icon">
                                            <i class="fa fa-dollar"></i>
                                        </div>
                                        <input type="number" id="input-paid" class="form-control" placeholder="Monto a pagar">
                                    </div>
                                    <small class="form-text text-muted">ej. 85000</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-block btn-register">
                        <i class="fa fa-check"></i>
                        <span>Confirmar</span>
                    </button>
                </div>
            </form>
            </div>
        </div>
        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/alerts.php"; 
            include "../../objects/footer.php"; 
        ?>
    </body>
    <script type="text/javascript">
        function showConfirm(type){
            var modal=document.getElementById("confirm-payment");
            var typeR=document.getElementById("type");
            var msg=document.getElementById("confirm-msg");
            var form=document.getElementById("request-form");
            var title;

            if(type=='product'){
                title="Confirmar venta";
                typeR.innerHTML="p";
                msg.innerHTML="Por favor, confirme que el producto ha sido entregado e indique si el pago se efectua en este momento.";
            }else{
                title="Confirmar servicio";
                typeR.innerHTML="s";
                msg.innerHTML="Por favor, confirme que el servicio se ha hecho e indique si el pago se efectua en este momento.";
            }
            form.onsubmit=function(){insertItem(type); return false;};
            modal.getElementsByTagName("h2")[0].innerHTML=title;

            showModal("confirm-payment");
        }

        function showPayments(input){
            var p=document.getElementById("payment-methods");
            var pi=document.getElementById("input-paid-group");

            if(input.checked){
                p.style.display="block";
                pi.style.display="block";
            }else{
                p.style.display="none";
                pi.style.display="none";
            }
        }

        function insertItem(type){
            var block=document.getElementById(type+"-block");

             $.ajax({
                type:'post',
                url:'insert.php',
                data:'entity='+type+'&idReg='+"<?php echo $reservation->getRoom();?>"
                +"&petition="+block.getElementsByTagName("select")[0].value
                +"&quantity="+block.getElementsByTagName("input")[0].value
            }).then(function(ans){
                console.log(ans);
                location.reload();
            });
        }
    </script>
</html>
