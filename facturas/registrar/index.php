<?php
    /**
    * Archivo que contiene la información pertinente a la factura de servicios
    * @package   factura
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2020.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
    */
    require_once '../../includes/classes.php';
    $user = new User();
    $userSession = new UserSession();
    $database = new Database();
    $consult = new Consult();
    
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
        <title>Factura | Hotel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../../res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="../../css/main.css">
        <link rel="stylesheet" type="text/css" href="../../css/modal.css">
        <link rel="stylesheet" type="text/css" href="../../css/reporte_factura.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../../css/factura.css">
        <link rel="stylesheet" type="text/css" href="../../css/alerts.css">
        <link rel="stylesheet" type="text/css" href="../../css/table.css">
        <link rel="stylesheet" type="text/css" href="../../css/form.css">
        <script type="text/javascript" src="../../js/moment.js"></script>
        <script type="text/javascript" src="../../js/dynamic.js"></script>
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/jquerymask.js"></script>
        <script type="text/javascript" src="bill-register.js"></script>

    </head>

    <body>
        <?php 
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu.php"; 
        ?>

        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "facturas"
            */
            setCurrentPage("facturas");
        </script>

        <!--Bloque encargado de mostrar los detalles correspondientes a la factura de una reserva-->
        <div class="col-12 content">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header col-12">
                    <div class="row col-12">
                        <h2 class="title-form col-12">FACTURACIÓN</h2>
                    </div>
                </div>
                
                
                <div class="series">
                    <?php if(isset($_GET['serie'])):?>
                        <select name="typeBill" id="selectType" disabled onchange="return changeSelect();">
                            <option value="Factura de Venta" selected>Factura de Venta</option>
                            <option value="Orden de Servicio">Orden de Servicio</option>
                        </select>
                        <p>No&nbsp;&nbsp; <strong id="serieBill"><?php echo $_GET['serie']; ?></strong><strong id="serieOrder" hidden><?php echo $consult->getNextSerieOrder(); ?></strong></p>
                    <?php else:?>
                        <select name="typeBill" id="selectType" onchange="return changeSelect();">
                            <option value="Factura de Venta" selected>Factura de Venta</option>
                            <option value="Orden de Servicio">Orden de Servicio</option>
                        </select>
                        <p>No&nbsp;&nbsp; <strong id="serieBill"><?php echo $consult->getNextSerieBill(); ?></strong><strong id="serieOrder" hidden><?php echo $consult->getNextSerieOrder(); ?></strong></p>
                    <?php endif;?>
                    
                </div>
                
                <div class="card-search">
                    <div class="infos">
                        <?php if(!isset($_GET['id'])):?>
                        <div class="row">
                            <div class="form-group in-row">
                                <label class="form-control-label"><b>Tipo de identificación del titular</b></label>
                                <div class="input-group">
                                    <label>Documento de Idenditad&nbsp;&nbsp;</label>
                                    <input type="radio" name="typeId" value="CC" checked onclick="changeToPerson()">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>NIT&nbsp;&nbsp;</label>
                                    <input type="radio" name="typeId" value="NIT" onclick="changeToEnterprise()">
                                </div>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="form-group in-row">
                                <label class="form-control-label"><b>Número de Identificación</b></label>
                                <div class="input-group">
                                    <div class="input-group-icon">
                                        <i class="fa fa-search"></i>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Documento" maxlength="10" minlength="7"  onkeypress="return validateNumericValue(event);">
                                    <button type="button" onclick="searchTitular(this.previousElementSibling, 0, -1, -1);"><i class="fa fa-search"></i></button>
                                </div>
                                <small class="form-text text-muted">ej. 102055214</small>
                            </div>
                        </div>
                        <?php else:?>
                            <?php if(isset($_GET['serie'])):?>
                                <script type="text/javascript">
                                    var typeTitular = '<?php echo $consult->getTypeTitular($_GET['id'])?>';
                                    var idTitular = '<?php echo $consult->getIdTitular($_GET['id'])?>';
                                    searchTitular(idTitular, 1, typeTitular, '<?php echo $_GET['id']?>'); 
                                </script>
                            <?php elseif(isset($_GET['co'])):?>
                                <script type="text/javascript">
                                    var typeTitular = '<?php echo $consult->getTypeTitular($_GET['id'])?>';
                                    var idTitular = '<?php echo $consult->getIdTitular($_GET['id'])?>';
                                    searchTitular(idTitular, 3, typeTitular, '<?php echo $_GET['id']?>'); 
                                </script>
                            <?php else:?>
                                <script type="text/javascript">
                                    var typeTitular = '<?php echo $consult->getTypeTitular($_GET['id'])?>';
                                    var idTitular = '<?php echo $consult->getIdTitular($_GET['id'])?>';
                                    searchTitular(idTitular, 2, typeTitular, '<?php echo $_GET['id']?>'); 
                                </script>
                            <?php endif;?>
                            
                        <?php endif;?>
                        <p><b id="namePerson">Nombre: </b><label></label></p>
                        <p><b>Teléfono: </b><label></label></p>
                        <p><b id="numberId">Número de Documento: </b><label></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>Habitación (es):</b> <label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>Fecha Entrada: </b><label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>Fecha Salida: </b><label></label></p>
                        <p id="key" class="hideable"></p>
                    </div>
                    
                    <div class="col-12">
                        <table>
                            <tr>
                                <th class="long_cols">Descripción</th>
                                <th>Cantidad</th>
                                <th>Valor Unitario ($)</th>
                                <th class="long_values">Valor Total ($)</th>
                            </tr>
                            <tbody id="myTable"></tbody>
                        </table>
                    </div>


                    <div class="table_totals col-12">
                        <table>
                            <tr class="long_letters">
                                <td class="long_totals"></td>
                                <td><b>VALOR ABONADO ($)</b></td>
                                <td class="long_values" id="paidValue"><b></b></td>
                            </tr>
                        </table>
                        <table>
                            <tr class="long_letters">
                                <td class="long_totals"></td>
                                <td><b>VALOR A PAGAR ($)</b></td>
                                <td class="long_values" id="valueTotal"><b></b></td>
                            </tr>
                        </table>
                        <table>
                            <tr class="long_letters">
                                <td class="long_totals"></td>
                                <td><b style="font-size: 16px;">VALOR TOTAL DE RESERVA ($)</b></td>
                                <td class="long_values"><b id="totalRes" style="font-size: 16px;"></b></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <input id="currentUser" value="<?php echo  $user->getId()?>" hidden></input>
                 

                
            <?php if(isset($_GET['serie'])):?>
                <div>
                    <a target = "_blank" href = "/reportes/facturas?id=<?php echo $_GET['id']?>&typeBill=0&serie=<?php echo $_GET['serie']?>" class="col-10" style="float: center;"><img src="/res/img/pdf-icon.png" style="cursor:pointer;" width="60"/></a>
                </div>
            <?php else:?>
                <div class="option_bill">
                    <form action="">
                        <button formtarget="_blank" id="generateBill" class="button-add-book col-2">
                            <span>GUARDAR FACTURA</span>
                        </button>
                    </form>
                </div>
            <?php endif;?>
                
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
</html>
