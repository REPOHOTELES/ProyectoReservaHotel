<div class="card card-client col-12">
    <div class="card-header">
        <i class="fa fa-user"></i>
        <strong class="card-title">Información personal</strong>
        <label></label>
        <button type="button" onclick="showAllInputs(0);" class="btn-check-in btn">Check in</button>
    </div>

    <div class="card-search">
        <div class="row">
            <div class="form-group in-row">
                <label class="form-control-label">Busqueda por número de documento</label>
                <div class="input-group">
                    <div class="input-group-icon">
                        <i class="fa fa-search"></i>
                    </div>
                    <input class="form-control" type="text" placeholder="Documento" maxlength="15" onkeypress="searchEvent(event,this,'person');" onkeydown="$(this).mask('000000000000');">
                    <button type="button" onclick="searchPerson(this.previousElementSibling);"><i class="fa fa-search"></i></button>
                </div>
                <small class="form-text text-muted">ej. 102055214</small>
            </div>
        </div>
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
                    <small class="form-text text-muted">ej. WILLIAM JULIAN</small>
                </div>

                <div class="form-group in-row col-6 padd">
                    <label class="form-control-label">Apellidos*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-user-o"></i>
                        </div>
                        <input class="form-control" type="text" placeholder="Apellidos" onkeyup="this.value=this.value.toUpperCase();" onkeydown="checkInputOnlyLetters(event,this);" minlength="2" maxlength="60" required>
                    </div>
                    <small class="form-text text-muted">ej. HERANDEZ FERNANDEZ</small>
                </div>
            </div>

            <div class="hideable row row-flag" state="hide">
                <div class="form-group in-row col-4 padd">
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

                <div class="form-group in-row col-8 padd">
                    <label class="form-control-label">Número de documento*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-id-card"></i>
                        </div>
                         <input class="form-control" type="text" placeholder="Número de documento" minlength="6" maxlength="15" onkeydown="$(this).mask('000000000000000');">
                    </div>
                    <small class="form-text text-muted">ej. 123456789</small>
                </div>
            </div>

            <div class="row hideable">
                <div class="form-group in-row col-7 padd">
                    <label class="form-control-label">Pais (Expedición)*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>

                        <select class="form-control" onchange="updateCities(this);">
                            <?php $consult->getList('country',''); ?>
                           </select>
                    </div>
                </div>
                <div class="form-group in-row col-5 padd">
                    <label class="form-control-label">Ciudad (Expedición)*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>

                        <select class="form-control">
                            <?php $consult->getList('city','1'); ?>
                           </select>
                    </div>
                </div>
            </div>

            <div class="row">
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

                <div class="form-group in-row col-8 padd">
                    <label class="form-control-label">Correo electrónico</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                         <input class="form-control" type="email" placeholder="Correo electrónico">
                    </div>
                    <small class="form-text text-muted">ej. arturo.lopez@mail.com</small>
                </div>
            </div>

            <div class="row hideable">
                <div class="form-group in-row col-3 padd">
                    <label class="form-control-label">Género*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-intersex"></i>
                        </div>

                        <select class="form-control">
                            <option value="M">Hombre</option>
                            <option value="F">Mujer</option>
                        </select>
                    </div>
                </div>

                <div class="form-group in-row col-4 padd">
                    <label class="form-control-label">Fecha de nacimiento*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control" type="date" onchange="validateDateC(this);">
                    </div>
                    <small class="form-text text-muted">ej. 22/09/1985</small>
                </div>

                <div class="form-group in-row col-5 padd">
                    <label class="form-control-label">Tipo de sangre*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-heartbeat"></i>
                        </div>

                        <select class="form-control col-3 padd">
                            <option value="O">O</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                        </select>

                         <select class="form-control col-9 padd">
                            <option value="+">+ (Positivo)</option>
                            <option value="-">- (Negativo)</option>
                            </select>
                        </div>
                </div>
            </div>

            <div class="row">
                <div class="hideable form-group in-row col-3 padd">
                    <label class="form-control-label">Profesión</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-bank"></i>
                        </div>

                       <select class="form-control">
                            <option value="NULL">Ninguna</option>
                            <?php $consult->getList('profession',''); ?>
                        </select>
                        <button type="button" onclick="showModal('add-prof');" class="btn-circle"><i class="fa fa-plus"></i></button>
                    </div>
                </div>

                <div class="hideable form-group in-row col-6 padd">
                    <label class="form-control-label">Nacionalidad*</label>
                    <div class="input-group">
                        <div class="input-group-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>

                        <select class="form-control" required>
                            <?php $consult->getList('country',''); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
