<div class="card card-client">
    <div class="card-header">
        <i class="fa fa-user"></i>
        <strong class="card-title">Información personal</strong>
    </div>

    <div class="hideable id-container"></div>

    <div>
        <div class="card-body">
            <div class="row">
                <div class="form-group in-row col-6 padd">
                    <label class="form-control-label">Nombres*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-user-o"></i>
                        </div>
                        <input class="form-control" type="text" placeholder="Nombres" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" maxlength="60" minlength="2" required>
                    </div>
                    <small class="form-text text-muted">ej. BENITO ANDRES</small>
                </div>

                <div class="form-group in-row col-6 padd">
                    <label class="form-control-label">Apellidos*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-user-o"></i>
                        </div>
                        <input class="form-control" type="text" placeholder="Apellidos" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);"  minlength="2" maxlength="60" required>
                    </div>
                    <small class="form-text text-muted">ej. HERNANDEZ FERNANDEZ</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group in-row col-3 padd">
                    <label class="form-control-label">Tipo de documento*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-id-card"></i>
                        </div>

                        <select class="form-control">
                            <option value="CC">Cédula de ciudadanía</option>
                            <option value="RC">Registro civil</option>
                            <option value="TI">Tarjeta de identidad</option>
                            <option value="CE">Cedula de extranjería</option>
                            <option value="PS">Pasaporte</option>
                        </select>
                    </div>
                </div>

                <div class="form-group in-row col-4 padd">
                    <label class="form-control-label">Número de documento*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-id-card"></i>
                        </div>
                         <input class="form-control" type="text" placeholder="Número de documento"  minlength="6" maxlength="15" onkeydown="$(this).mask('000000000000000');">
                    </div>
                    <small class="form-text text-muted">ej. 123456789</small>
                </div>
                
                <div class="form-group in-row col-4 padd">
                    <label class="form-control-label">Teléfono*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <input class="form-control phone-mask" type="text" placeholder="Telefono" maxlength="15" minlength="7" onkeydown="$(this).mask('000 000 0000');" required>
                    </div>
                    <small class="form-text text-muted">ej. 3123334466</small>
                </div>
            </div>


            <div class="row">
                <div class="form-group in-row col-4 padd">
                    <label class="form-control-label">Cargo</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-user-o"></i>
                        </div>

                        <select class="form-control">
                            <?php $consult->getList('role');?>
                        </select>
                    </div>
                </div>
                <div class="form-group in-row col-6 padd">
                    <label class="form-control-label">Correo electrónico</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                         <input class="form-control" type="email" placeholder="Correo electrónico">
                    </div>
                    <small class="form-text text-muted">ej. benito.fernandez@mail.com</small>
                </div>
            </div>
            
            
            <div class="row">
                <div class="form-group in-row col-4 padd">
                    <label class="form-control-label">Nombre de usuario*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-user-o"></i>
                        </div>
                        <input class="form-control" type="text" placeholder="Nombre de usuario" maxlength="50" minlength="3" required>
                    </div>
                    <small class="form-text text-muted">ej. benito.andres</small>
                </div>

                <div class="form-group in-row col-4 padd">
                    <label class="form-control-label">Contraseña*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <input class="form-control" type="password" placeholder="Contraseña" minlength="8" maxlength="60" required>
                    </div>
                </div>
                
                <div class="form-group in-row col-4 padd">
                    <label class="form-control-label">Repetir contraseña*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <input class="form-control" type="password" placeholder="Repetir Contraseña" minlength="8" maxlength="60" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
