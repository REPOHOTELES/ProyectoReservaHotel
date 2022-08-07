<?php
    /**
    * Archivo que contiene la información pertinente al control diario del hotel
    * @package   control_diario
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
    */
    require_once '../includes/classes.php';

    $user = new User();
    $userSession = new UserSession();
    
    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
    }else{
        header('location: ../login');
    }
    
    $date="";

    if(isset($_GET['date'])){
        $date = $_GET['date'];      
    }

    $consult=new Consult($user);
?>


<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Control diario | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <link rel="stylesheet" type="text/css" href="../css/modal.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <script type="text/javascript" src="../js/moment.js"></script>
        <script type="text/javascript" src="../js/dynamic.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/hotel-db.js"></script>
    </head>
    
    <!--Construcción de la vista-->
    <body onload ="checkColors();" >
        <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../objects/menu.php"; 
        ?>

        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "control-diario"
            */
            setCurrentPage("control-diario");
        </script>
        
        <!--Bloque que contiene una tabla  con el control de habitaciones de acuerdo a una fecha seleccionada por el usuario-->
        <div class="content col-12">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header padd">
                    <h2 class="title-form col-12">CONTROL DE HABITACIONES</h2>
                </div>
                    <div class="form-group col-3">
                        <label class="form-control-label">Fecha de control</label>
                        <div class="input-group">
                            <button onclick="window.location.href='../control_diario/?date='+calculateDate(document.getElementById('control-date').value,-1)">&lt;</button>
                            <div class="input-group-icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input id="control-date" class="form-control" onchange="window.location.href='/control_diario/?date='+calculateDate(document.getElementById('control-date').value,0)" type="date" value="<?php echo $date; ?>">
                            <button onclick="window.location.href='../control_diario/?date='+calculateDate(document.getElementById('control-date').value,1)">&gt;</button>
                        </div>
                        <small class="form-text text-muted">ej. 10/11/2022</small>
                    </div>

                <div class="scroll-block">
                    <table>
                        <thead>
                            <tr>
                                <th>T</th>
                                <th>Habitación</th>
                                <th>Nombre huésped(es)</th>
                                <th>Fecha ingreso</th>
                                <th>Conteo diario</th>
                                <th>Total ($)</th>
                                <th>Check up</th>
                                <th>Check out</th>
                                <?php if($user->getRole()!=4):?>
                                <th></th>
                                <?php endif;?>
                            </tr>
                        </thead>
                        
                        <?php
                        /**
                        * Invoca al método getTable('room', $date) que se encarga de obtener de la base de datos el control que se ha llevado a cabo * de las habitaciones en la fecha prevista
                        */
                            $consult->getTable('room', $date);
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
         <div id="confirm-check-out" class="modal hideable" onclick="touchOutside(this);">
            <div class="modal-content col-3 wrap-3">
                 <div class="modal-header">
                    <span onclick="hideModal('confirm-check-out');" class="close">&times;</span>
                    <h2>Confirmar Check out</h2>
                </div>

                <div class="modal-body">
                    <div>
                        <div class="card-body">
                            <div style="margin-top: 10px;">
                                Usted está a punto de dar por terminada la reserva <label></label>.
                                <br>
                                Recuerde que la reserva no podrá ser modificada.
                            </div>

                           <div id="checkout-message" class="message">
                               
                           </div>
                        </div>
                    </div>

                    <button class="btn btn-block btn-register">
                        <i class="fa fa-check"></i>
                        <span>Confirmar</span>
                    </button>
                </div>
            </div>
        </div>

        <div id="confirm-check-up" class="modal hideable" onclick="touchOutside(this);">
            <div class="modal-content col-5 wrap-5">
                 <div class="modal-header">
                    <span onclick="hideModal('confirm-check-up');" class="close">&times;</span>
                    <h2>Confirmar Check up</h2>
                </div>

                <div class="modal-body">
                    <div>
                        <div class="card-body">
                            <div style="margin-top: 10px;">
                                Check up de la reserva <label></label>.<br>
                                Por favor, verifique cuales huespedes salen del hotel. 
                                <br>
                                Recuerde que este estado se mantendrá hasta que realice este mismo procedimiento.
                            </div>
                             <table>
                                <tr>
                                    <th>Huesped</th>
                                    <th>Check up<br>
                                        <label class="switch switch-table">
                                            <input id="main-switch-check-up" type="checkbox" onchange="setAllCheckUp(this);">
                                            <span class="slider slider-gray round green"></span>
                                        </label>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <button class="btn btn-block btn-register">
                        <i class="fa fa-check"></i>
                        <span>Confirmar</span>
                    </button>
                </div>
            </div>
        </div>
        <div style="display: none;">
            <table>
                <td id="table-base-switch">
                    <label class="switch switch-table">
                        <input type="checkbox">
                        <span class="slider slider-gray round green"></span>
                    </label>
                </td>
            </table>
        </div>
    </body>
</html>
