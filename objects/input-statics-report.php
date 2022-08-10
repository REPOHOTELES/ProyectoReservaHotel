<form action="../reportes/excel/plantilla.php" method="post">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">REPORTE DE ESTADISTICAS POR MES</strong>
        </div>

         <div class="card-body">
            <div class="form-group in-row">
                <label class="form-control-label">Fecha para reporte</label>
                <div class="input-group">
                    <div class="input-group-icon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input id="doc-date" class="form-control" type="month" min="2017-01" max="<?php echo date("Y-m");?>" value="<?php echo date("Y-m", strtotime(date("Y-m")."- 1 month"));?>" name="dateReport">
                </div>
                <small class="form-text text-muted">ej. noviembre de 2022</small>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-block btn-register">
        <i class="fa fa-file-excel-o"></i>
        <span>Imprimir reporte</span>
    </button>
</form>
