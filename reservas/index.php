<?php
    /**
    * Archivo que contiene la información pertinente a las reservas almacenadas en la base de datos
    * @package   reservas
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
    */
    require_once '../includes/classes.php';
    $consult=new Consult();
    $user = new User();
    $userSession = new UserSession();
    
    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
    }else{
        header('location: ../login');
    }
?>

<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Reservas | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../res/img/famicon.png">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <link rel="stylesheet" type="text/css" href="../css/modal.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <script type="text/javascript" src="../js/moment.js"></script>
        <script type="text/javascript" src="../js/dynamic.js"></script>
        <script type="text/javascript" src="../js/hotel-db.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquerymask.js"></script>
        <script type="text/javascript" src="registrar/book-register.js"></script>
    </head>
    
    <!--Construcción de la vista-->
    <body>
        <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../objects/menu.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "consultar"
            */
            setCurrentPage("consultar");
        </script>

        <!--Bloque cuyo contenido se basa en una tabla que presenta la información más relevante de las empresas registradas en la base de datos-->

        <div class="col-12 content">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header col-12">
                    <div class="row-simple col-12">
                        <h2 class="title-form col-10">RESERVAS DE HUÉSPEDES</h2>
                        <a class="button-add-book col-2" href="registrar">Registrar reserva</a>
                    </div>
                </div>

                <div class="scroll-block col-12">
                    <table>
                        <tr>
                          <th>N°</th>
                          <th>Check in</th>
                          <th>Check on</th>
                          <th>Titular</th>
                          <th>Telefono</th>
                          <th>Fecha de llegada</th>
                          <th>Cantidad de noches</th>
                          <th>Huespedes</th>
                          <th></th>
                        </tr>
                         <?php
                            /**
                            * Invoca al método getTable('reservation', '') que se encarga de obtener de la base de datos los datos de las *reservaciones efectuadas
                            */
                            $consult->getTable('reservation','');
                          ?>
                    </table>
                </div>
            </div>
        </div>
        
        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../objects/footer.php"; 
            include "../objects/alerts.php"; 
        ?>

        <div id="confirm-check-on" class="modal hideable" onclick="touchOutside(this);">
            <div class="modal-content col-3 wrap-3">
                 <div class="modal-header">
                    <span onclick="hideModal('confirm-check-on');" class="close">&times;</span>
                    <h2>Confirmar Check on</h2>
                </div>

                <div class="modal-body">
                    <form onsubmit="return false;">
                        <div>
                            <div class="card-body">
                                <div style="margin-top: 10px;">
                                    Por favor, confirme si el/los huespedes de la reserva <label></label> ya llegaron al hotel.
                                    <br>
                                    Recuerde que la reserva pasará a <strong>control diario.</strong>
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
                                            <input type="text" id="input-paid" class="form-control" onkeydown="$(this).mask('000.000.000.000.000', {reverse: true});" placeholder="Monto a pagar">
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
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
