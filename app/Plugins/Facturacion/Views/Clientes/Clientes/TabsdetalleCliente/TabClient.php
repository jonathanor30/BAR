<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Datos generales</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <form action="" method="POST" id="editar_cliente" autocomplete="off">
                        <input type="number" hidden name="id_cliente" id="id_cliente" value="<?php echo $datos['datos']->id_cliente ?>">
                        <label>Nombre o Razon Social <a style="color:red">*</a></label>
                        <input required oninvalid="this.setCustomValidity('Este campo es Obligatorio si desea guardar los otros campos')" oninput="this.setCustomValidity('')" type="text" class="form-control form-control-sm" id="nombre" name="nombre" value="<?php echo $datos['datos']->nombre ?>">
                        <input type="checkbox" id="personafisica" name="personafisica" <?php echo ($datos['datos']->personafisica == 1 ? "checked" : "") ?>>&nbsp;&nbsp;Persona física <a style="color:red">*</a>
                </div>
                <div class="col-sm">
                    <label>Tipo Doc <a style="color:red">*</a></label>
                    <select id="tipoidfiscal" name="tipoidfiscal" class="form-control form-control-sm">
                        <option value="" selected disabled>Selecciona</option>
                        <option value="NIT">NIT</option>
                        <option value="CC">CC</option>
                        <option value="CE">CE</option>
                    </select>
                </div>
                <div class="col-sm">
                    <label>NIT/CC <a style="color:red">*</a></label>
                    <input type="text" class="form-control form-control-sm" id="cifnif" name="cifnif" value="<?php echo $datos['datos']->cifnif ?>" required>
                </div>
                <div class="col-sm">
                    <label>Digito de verificación<a style="color:red">*</a></label>
                    <input type="number" class="form-control form-control-sm" maxlength="1" id="cifnif_dv" name="cifnif_dv" value="<?php echo $datos['datos']->cifnif_dv ?>" required>
                </div>
                <div class="col-sm">
                    <label>Responsabilidades:</label>
                    <select class="form-control form-control-sm" id="liabilities">
                        <option value="" selected disabled>Selecciona</option>
                        <?php foreach ($datos['liabilities'] as $key => $value) : ?>
                            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm">
                    <label class="form-label">Seleccionadas:</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend" id="remove-liabilities">
                            <div class="input-group-text">x</div>
                        </div>
                        <input readonly="" type="text" name="responsabilidades" id="responsabilidades" class="form-control form-control-sm" value="<?php echo $datos['datos']->responsabilidades ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label>Teléfono 1</label>
                    <input type="text" class="form-control form-control-sm" id="telefono1" name="telefono1" value="<?php echo $datos['datos']->telefono1 ?>">
                </div>
                <div class="col-sm">
                    <label>Teléfono 2</label>
                    <input type="text" class="form-control form-control-sm" id="telefono2" name="telefono2" value="<?php echo $datos['datos']->telefono2 ?>">
                </div>
                <div class="col-sm">
                    <label>E-mail</label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email" value="<?php echo $datos['datos']->email ?>">
                </div>
                <div class="col-sm">
                    <label>Registro mercantil</label>
                    <input type="text" class="form-control form-control-sm" id="mercant_register" name="mercant_register" value="<?php echo $datos['datos']->mercant_register ?>">
                </div>
            </div>
            &nbsp;
            <div class="row">
                <div class="col-sm">
                    <label>Forma de pago:</label>
                    <select id="codpago" name="codpago" value="" class="form-control form-control-sm" onload="this.value = <?php $datos['datos']->codpago ?>" required>
                        <option value="" selected disabled>Selecciona</option>
                        <option value="1">Al contado</option>
                        <option value="2">Crédito</option>
                    </select>
                </div>
                <div class="col-sm">
                    <label>Medio de pago:</label>
                    <select class="form-control form-control-sm" id="medio_pago" name="medio_pago">
                        <option value="" selected disabled>Selecciona</option>
                        <?php foreach ($datos['payment'] as $key => $value) : ?>
                            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm">
                    <label>Divisa</label>
                    <select class="form-control form-control-sm" id="divisa" name="coddivisa">
                        <?php foreach ($datos['div']->toArray() as $key => $value) : ?>
                            <?php if ($value['coddivisa'] == ($datos['datos']->coddivisa ?? 'COP')) : ?>
                                <option selected value="<?php echo $value['coddivisa'] ?>"><?php echo $value['descripcion'] ?></option>
                            <?php else : ?>
                                <option value="<?php echo $value['coddivisa'] ?>"><?php echo $value['descripcion'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br>
                <div class="col-sm">
                    <label>Régimen IVA</label>
                    <select required id="regimeniva" name="regimeniva" class="form-control form-control-sm" onload="this.value = <?php echo $datos['datos']->regimeniva ?>">
                        <option value="" selected disabled>Selecciona</option>
                        <option value="1">Común</option>
                        <option value="2">Simplificado</option>
                        <option value="3">Simple</option>
                    </select>
                </div>
                <div class="col-sm">
                    <label>Tipo de organización</label>
                    <select required id="tipo_organizacion" name="tipo_organizacion" class="form-control form-control-sm">
                        <option value="" selected disabled>Selecciona</option>
                        <option value="1">Persona Juríca</option>
                        <option value="2">Persona Natural</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm">
                    <textarea id="obs" name="observaciones" placeholder="Observaciones..." class="form-control form-control-sm"><?php echo $datos['datos']->observaciones ?></textarea>
                    <p><a style="color:red">*</a><strong>Datos obligatorios</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label>Estado</label>
                    <select class="form-control form-control-sm " style="width: 200px" id="estado" name="estado">
                        <option value="0">Inactivo</option>
                        <option value="1">Activo</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" id="btneditclie" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>

        </div>
        </form>
    </div>
</div>