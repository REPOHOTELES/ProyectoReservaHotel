<?php 
    require_once '../../includes/classes.php';
    $consult=new Consult();
    $user = new User();
    $userSession = new UserSession();
    
    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
    }else{
        header('location: ../../login');
    }
?>


<!DOCTYPE html>
<html>

<head>
	<title>Facturación Manual | Hotel</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../../res/img/famicon.png" />
	<link rel="stylesheet" type="text/css" href="../../css/main.css">
    <link rel="stylesheet" type="text/css" href="../../css/modal.css">
    <link rel="stylesheet" type="text/css" href="../../css/reporte_factura.css">
    <link rel="stylesheet" type="text/css" href="../../css/factura2.css">
    <link rel="stylesheet" type="text/css" href="../../css/alerts.css">
    <script type="text/javascript" src="../../js/moment.js"></script>
    <script type="text/javascript" src="../../js/dynamic.js"></script>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquerymask.js"></script>
    <script type="text/javascript" src="manualBill.js"></script>
</head>

<body onload = "clearAllFields();">
    <?php
        /**
        * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
        */
        include "../../objects/menu2.php"; 
    ?>

    <script type="text/javascript">
        /**
        * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "facturas"
        */
        setCurrentPage("facturas");
    </script>


    <div class="border">
            <div class="borderUp"></div>
            <div class="borderDown"></div>
    </div>
    
    <div class="marco nearly-page">
        <h1>FACTURACIÓN - HOTEL</h1>
            <div class="series">
                <label id="titleBill">Factura de Venta</label>
                <!-- <select name="typeBill">
                    <option value="Factura de Venta" selected>Factura de Venta</option>
                    <option value="Orden de Servicio">Orden de Servicio</option>
                </select> -->
                <p><b>No</b>&nbsp;&nbsp;&nbsp;&nbsp; 
                    <label class="code_bill" name="idBill" id="idBill"><?php echo $consult->getNextSerieBill();?></label>
                </p>
            </div>
            <div class="infos">
                <b>Nombre:</b>
                <input type="text" name="name" id="nameTitular">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b>Empresa:</b>
               <input type="text" name="enterprise" id="nameEnterprise"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                
                </br></br>
                <label><b>Identificación:</b></label>
                <!-- <input type="radio" name="id" checked value="NIT"><b>NIT</b></input>
                <input type="radio" name="id" value="C.C."><b>C.C.</b></input> -->
                <input type="number" name="typeId" id="document">  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b>Habitación (es): </b>
                <input type="text" name="rooms" id=rooms>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>Check in: 
                    </b><input type="date" name="dateGetIn" id="dateGetIn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </br></br>
                    <b>Check out: </b>
                    <input type="date" value="<?php echo date("Y-m-d");?>" name="dateGetOut" id="dateGetOut">
            </div>

            <div class="tables">
                <table id="tableAlign">    
                    <tr>
                        <th class="long_cols">Descripción</th>
                        <th>Cantidad</th>
                        <th>Valor Unitario ($)</th>
                        <th class="long_values">Valor Total ($)</th>
                    </tr>
                    <tr>
                        <td name="desc1"><input type="text" class="desc" name="desc1" id="desc1"></td>
                        <td><input type="number" min="0" max="100" value="1" name="cant1" id="cant1" onkeyup="calcValues()" onchange="calcValues()"></td>
                        <td><input type="number" min="0" class="data" value="0" name="unit1" id="unit1" onkeyup="calcValues()" onchange="calcValues()"></td>
                        <td><input type="text" class="data" value="0" name="vTotal1" id="vTotal1" onkeyup="calcValues()" readonly></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="desc" name="desc2" id="desc2"></td>
                        <td><input type="number" min="0" max="100" value="0" name="cant2" id="cant2" onkeyup="calcValues()" onchange="calcValues()"></td>
                        <td><input type="number" min="0" class="data" value="0" name="unit2" id="unit2" onkeyup="calcValues()" onchange="calcValues()"></td>
                        <td><input type="text" class="data" value="0" name="vTotal2" id="vTotal2" onkeyup="calcValues()" readonly></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="desc" name="desc3" id="desc3"></td>
                        <td><input type="number" min="0" max="100" value="0" name="cant3" id="cant3" onkeyup="calcValues()" onchange="calcValues()"></td>
                        <td><input type="number" min="0" class="data" value="0" name="unit3" id="unit3" onkeyup="calcValues()" onchange="calcValues()"></td>
                        <td><input type="text" class="data" value="0" name="vTotal3" id="vTotal3" onkeyup="calcValues()" readonly></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="desc" name="desc4" id="desc4"></td>
                        <td><input type="number" min="0" max="100" value="0" name="cant4" id="cant4" onkeyup="calcValues()" onchange="calcValues()"></td>
                        <td><input type="number" min="0" class="data" value="0" name="unit4" id="unit4" onkeyup="calcValues()" onchange="calcValues()"></td>
                        <td><input type="text" class="data" value="0" name="vTotal4" id="vTotal4" onkeyup="calcValues()" readonly></td>
                    </tr>
                    
                </table>
            </div>

            <div class="table_totals">
                <table>
                    <tr class="long_letters">
                        <td class="long_totals"></td>
                        <td><b>TOTAL ($)</b></td>
                        <td class="long_values"><input type="text" class="vTotal" value="0" id="valueTotal" name="valueTotal" readonly></td>
                    </tr>
                </table>
            </div>
            <b>Responsable: </b>
            <label id="responsible"><?php echo $user->getName().' '.$user->getLastName()?></label>
            <!-- <div class="option_bill">
                <input class="but" type="submit" value="Imprimir factura" name="crear"/> 
            </div> -->
            <!-- <form> -->
                <div class="option_bill">
                    <a onclick="example()" target = "_blank" id="generateManualBill" class="button-add-book col-2">
                        <!-- <span>GUARDAR FACTURA</span> -->
                        GUARDAR FACTURA
                    </a>
                </div>
            <!-- </form> -->
    </div>
    
    
	<?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/footer2.php"; 
        ?>

</body>
</html>
