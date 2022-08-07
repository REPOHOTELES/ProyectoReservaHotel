<div class="card card-profession">
    <div class="card-header">
        <strong class="card-title">Información de la profesión</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group in-row">
                <label class="form-control-label">Nombre de la profesión</label>
                <div class="input-group">
                    <div class="input-group-icon">
                        <i class="fa fa-tag"></i>
                    </div>
                    <input class="form-control" type="text" id="name" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" name="name" required>
                </div>
                <small class="form-text text-muted">ej. INGENIERO</small>
            </div>
        </div>
    </div>
</div>
