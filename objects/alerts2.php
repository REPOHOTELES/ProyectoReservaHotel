<!--Contiene el bloque correspondiente a las alertas emitidas por el sistema luego de presentarse algún evento ya sea inesperado o controlado por el usuario-->

<link rel="stylesheet" type="text/css" href="../../css/alerts.css">
<div id="alerts" class="col-3">

    <div>
        <div id="alert-d" class="alert danger">
            <span onclick="hideAlert(this);" class="closebtn">&times;</span>  
            <strong>¡Error!</strong> 
            <p></p>
        </div>
        <div id="alert-s" class="alert success">
            <span onclick="hideAlert(this);" class="closebtn">&times;</span>  
            <strong>¡Procedimiento exitoso!</strong> 
            <p></p>
        </div>
        <div id="alert-i" class="alert info">
            <span onclick="hideAlert(this);" class="closebtn">&times;</span>  
            <strong>Información!</strong> 
            <p></p>
        </div>
    
        <div id="alert-w" class="alert warning">
            <span onclick="hideAlert(this);" class="closebtn">&times;</span>  
            <strong>¡Precaución!</strong> 
            <p><p>
        </div>
    </div>
</div>
