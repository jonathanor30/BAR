<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="card ">
        <div class="card-header">
            <h5 class="card-title">Cuenta Bancaria</h5>
        </div>
        <div class="card-body">
            <form action="" id="editaccount" method="POST" autocomplete="off">
                <input type="hidden" name="id_cliente" value="<?php echo $datos['datos']->id_cliente ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <label>Nombre de banco <a style="color:red">*</a></label>
                        <input required oninvalid="this.setCustomValidity('Este campo es Obligatorio si desea guardar los datos')" oninput="this.setCustomValidity('')" class="form-control form-control-sm" id="bancname" name="bancname" value="<?php echo $datos['datos']->bancname ?>">
                    </div>
                    <div class="col-sm-4">
                        <label>Tipo de Cuenta  <a style="color:red">*</a></label>
                        <select required class="form-control form-control-sm" id="banctype" name="banctype">
                            <option selected disabled value=''>Selecciona</option>
                            <option value='1'>Ahorros</option>
                            <option value='2'>Corriente</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label>Numero de Cuenta  <a style="color:red">*</a></label>
                        <input class="form-control form-control-sm" id="bancnumber" name="bancnumber" value="<?php echo $datos['datos']->bancnumber ?>">
                    </div>
                </div>
                <p><a style="color:red">*</a><strong> Datos obligatorios</strong></p>
        </div>
        <div class="card-footer">
            <button type="submit" id="btneditaccount" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>
        </div>
        </form>
    </div>
</div>