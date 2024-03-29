<?php
    /**
    * Archivo que contiene un formulario para el registro de una nueva reserva
    * @package   reservas.editar
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2020.
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
        $p = new Person();
        $p->setId($id);        
    }
?>

<html>
    <!--Importación de librerias css y javascript -->
	<head>
		<link rel="shortcut icon" href="../../res/img/famicon.png" />
		<title>Editar reserva | Hotel</title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../../css/main.css">
		<link rel="stylesheet" type="text/css" href="../../css/form.css">
		<link rel="stylesheet" type="text/css" href="../../css/alerts.css">
		<link rel="stylesheet" type="text/css" href="../../css/modal.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
		<script type="text/javascript" src="../../js/moment.js"></script>
		<script type="text/javascript" src="../../js/jquery.js"></script>
		<script type="text/javascript" src="../../js/dynamic.js"></script>
		<script type="text/javascript" src="../../js/jquerymask.js"></script>
		<script type="text/javascript" src="../../js/hotel-db2.js"></script>
		<script type="text/javascript" src="book-editer.js"></script>
		<script type="text/javascript" src="../registrar/book-register.js"></script>
	</head>

    <!--Construcción de la vista-->
	<body onload ="loadBooking(<?php echo $id; ?>);">

      <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu2.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "editar"
            */
            setCurrentPage("editar");
        </script>
        
        <!--Contiene el formulario de registro correspondiente para una empresa-->
		<div class="content col-12 padd">
			<div class="wrap-main wrap-main-big col-10 wrap-10 padd">
				<div class="content-header">
                    <h2 class="title-form">EDITAR RESERVA</h2>
                </div>

                <form onsubmit="setUpdatePreviewBook(); showModal('confirm-modal'); return false;">
					<div id="main-row" class="row">
						<div class="col-12 padd row-simple">
							<div class="card card-prime col-12">
								<div class="card-header">
									<strong class="card-title">Información primaria</strong>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="form-group in-row">
											<label class="form-control-label">Fecha de llegada</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-calendar"></i>
												</div>
												<input id="start-date" type="date" class="form-control" onchange="validateDateA(this); getDays();" name="start-date" required>
											</div>
											<small class="form-text text-muted">ej. 01/09/2022</small>
										</div>

										<div class="form-group in-row">
											<label class="form-control-label">Fecha de salida</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-calendar"></i>
												</div>
												<input id="finish-date" type="date" class="form-control" onchange="validateDateA(this); getDays();" name="finish-date" autofocus required>
											</div>
											<small class="form-text text-muted">ej. 02/09/2022</small>
										</div>

										<div class="form-group in-row">
											<label class="form-control-label">Cantidad de noches</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-moon-o"></i>
												</div>
												<input id="count-nights" type="number" class="form-control" min="1" value="1" name="count-nights" required>
											</div>
											<small class="form-text text-muted">ej. 1</small>
										</div>

										<div class="form-group in-row">
											<label class="form-control-label">Cantidad de habitaciones</label>
											<div class="input-group">
												<div class="input-group-icon">
													<i class="fa fa-bed"></i>
												</div>
												<input id="rooms-quantity" type="number" class="form-control rooms-quantity" min="1" max="10" value="1" onchange="updateRoom(this);" name="rooms-quantity" required>
											</div>
											<small class="form-text text-muted">ej. 1</small>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div>
						<button class="btn btn-block btn-register">
							<i class="fa fa-check"></i>
							<span>Actualizar reserva</span>
						</button>
					</div>
				</form>
			</div>
		</div>

		<!----FIN DE LA PAGINA PRINCIPAL---->

		<div id="add-bizz" class="modal hideable" onclick="touchOutside(this);">
			<div class="modal-content col-8 wrap-8">
                <div class="modal-header">
                    <span onclick="hideModal('add-bizz');" class="close">&times;</span>
                    <h2>Agregar empresa</h2>
                </div>

                <div class="modal-body">
                	<?php include "../../objects/input-enterprise.php"; ?>
                	<div>
						<button class="btn btn-block btn-register"  onclick="updateEnterprise();">
							<i class="fa fa-check"></i>
							<span>Registrar empresa</span>
						</button>
					</div>
                </div>
            </div>
		</div>

		<div id="add-prof" class="modal hideable" onclick="touchOutside(this);">
			<div class="modal-content col-4 wrap-4">
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

		<div id="ajax-loading" class="modal ajax-loading hideable" >
			<div class="modal-content col-3 wrap-3">
				<div class="modal-body">
					<div class="card">
						<div class="card-header">
							<strong class="card-title">Por favor espere...</strong>
						</div>
						<div class="card-body">
							<label>Insertando en la base de datos</label><br>
							<label></label>
						</div>
					</div>
				</div>
            </div>
		</div>

		<div id="confirm-modal" class="modal hideable" onclick="touchOutside(this);">
			<div class="modal-content col-8 wrap-8">
				<div class="modal-header">
                    <span onclick="hideModal('confirm-modal');" class="close">&times;</span>
                    <h2>Revisar reserva</h2>
                </div>
                <div class="modal-body scroll-block">
	                <form onsubmit="updateReservation(<?php echo $user->getId();?>,<?php echo $id;?>); return false;">
	                	<div class="card">
						    <div class="card-header">
						        <strong class="card-title">Resumen de la reserva</strong>
						    </div>
						    <div class="card-body">
						    </div>
						</div>

						<div class="card">
	                		<div class="card-body">
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
						<input type="checkbox" name="" class="hideable" checked id="checkon-check">
	                	<div>
							<button class="btn btn-block btn-register" onclick="">
								<i class="fa fa-check"></i>
								<span>Confirmar actualización de reserva</span>
							</button>
						</div>
					</form>
                </div>
            </div>
		</div>


		<?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/footer2.php";
            include "../../objects/alerts2.php"; 
        ?>

        <div style="display: none;">
        	<div id="room-group" class="room-group col-12">
        		<div class="col-12 padd row-simple">
        			<?php 
        				include "../../objects/input-room.php";
        			?>
        		</div>

        		<div class="col-12 padd row-simple client-cards">
        			<?php 
        				include "../../objects/input-client.php";
        			?>
        		</div>
        	</div>
        	
        	<div id="form-group" class="form-group in-row">
        		<label class="form-control-label"></label>
        		<div class="input-group">
        			<div class="input-group-icon">
        				<i class="fa"></i>
        			</div>
        		<label class="form-control"></label>
        		</div>
        	</div>

        	<div id="select-holder" class="col-12">
        		<button type="button" class="col-6 btn btn-header btn-header-selected" onclick="showPersonHolder(this);">Persona natural</button>
        		<button type="button" class="col-6 btn btn-header" onclick="showEnterpriseHolder(this);">Empresa</button>
        	</div>

        	<div id="enterprise-holder" class="card-body hideable">
        		<div class="row">
        			<div class="form-group in-row col-12 padd">
        				<label class="form-control-label">Empresa</label>
						<div class="input-group">
							<div class="input-group-icon">
								<i class="fa fa-bank"></i>
							</div>
							<select class="form-control">
								<?php $consult->getList('enterprise',''); ?>
							</select>
							<button type="button" onclick="showModal('add-bizz');" class="btn-circle"><i class="fa fa-plus"></i></button>
						</div>
					</div>
        		</div>
        	</div>
        </div>
	</body>
</html>
