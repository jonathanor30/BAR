<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Dirección</h5>
        </div>
        <div class="card-body">
            <form action="" id="editaddress" method="POST" autocomplete="off">
                <input type="hidden" name="id_cliente" value="<?php echo $datos['datos']->id_cliente ?>">
                <div class="row">
                    <div class="col-sm">
                        <label>País</label>
                        <select required class="form-control form-control-sm" id="pais" name="pais">
                            <?php foreach ($datos['country'] as $key => $value) : ?>
                                <?php if ($value->codiso == ($datos['datos']->pais != null ? $datos['datos']->pais : "CO")) : ?>
                                    <option selected value="<?php echo $value->codiso ?>"><?php echo $value->nombre ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $value->codiso ?>"><?php echo $value->nombre ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label>Departamento <a style="color:red">*</a></label>
                        <input class="form-control form-control-sm" id="departamento" name="departamento" value="<?php echo $datos['datos']->departamento; ?>">
                    </div>
                    <div class="col-sm">
                        <label>Ciudad <a style="color:red">*</a></label>
                        <input class="form-control form-control-sm" id="ciudad" name="ciudad" value="<?php echo $datos['datos']->ciudad ?>">
                    </div>
                    <div class="col-sm">
                        <label>Codigo Postal</label>
                        <input class="form-control form-control-sm" id="codpostal" name="codpostal" value="<?php echo $datos['datos']->codpostal ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Código de Departamento <a style="color:red">*</a></label>
                        <input class="form-control form-control-sm" autocomplete="off" id="codigo_departamento" name="codigo_departamento" value="<?php echo $datos['datos']->codigo_departamento; ?>">
                    </div>
                    <div class="col-sm">
                        <label>Código de Municipio <a style="color:red">*</a></label>
                        <input class="form-control form-control-sm" autocomplete="off" id="codigo_municipio" name="codigo_municipio" value="<?php echo $datos['datos']->codigo_municipio; ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <label>Dirección <a style="color:red">*</a></label>
                        <textarea required oninvalid="this.setCustomValidity('Este campo es Obligatorio si desea guardar los datos')" oninput="this.setCustomValidity('')" class="form-control form-control-sm" id="direccion" name="direccion"><?php echo $datos['datos']->direccion ?></textarea>
                    </div>
                </div>
                <p><a style="color:red">*</a><strong>Datos obligatorios</strong></p>
        </div>
        <div class="card-footer">
            <button type="submit" id="btneditaddress" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>

        </div>
        </form>
    </div>
</div>