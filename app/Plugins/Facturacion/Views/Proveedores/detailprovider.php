<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Proveedores/detailprovider.js"></script>
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-2">
         <div class="btn-group">
            <a href="<?php echo RUTA_URL; ?>/Facturacion/page/Providers" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Proveedores</a>
         </div>
      </div>
      <div class="col-sm" style="text-align:center">
         <strong>
            <h3>Editar Proveedor &nbsp;<?php echo $datos['datos']->codproveedor ?><h3>
                  <input hidden type="number" name="id_proveedor" id="id_proveedor"id_proveedor <?php echo $datos['datos']->codproveedor ?>>

         </strong>
      </div>
   </div>
   <br>
   <div class="row">
      <div class="col-sm-2">
         <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Datos generales</a>
            <a class="nav-link" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="false">Cuenta Bancaria</a>
            <a class="nav-link" id="v-pills-address-tab" data-toggle="pill" href="#v-pills-address" role="tab" aria-controls="v-pills-address" aria-selected="false">Dirección</a>
            <a class="nav-link" id="v-pills-docs-tab" data-toggle="pill" href="#v-pills-docs" role="tab" aria-controls="v-pills-docs" aria-selected="false">Documentos</a>
            <a class="nav-link" id="v-pills-facturas-tab" data-toggle="pill" href="#v-pills-facturas" role="tab" aria-controls="v-pills-facturas" aria-selected="false">Facturas</a>

         </div>
      </div>
      <div class="col-sm-10">
         <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
               <div class="card card-primary border-primary">
                  <div class="card-header bg-primary  mb-3">
                     <h5 class="card-title" style="color:white">Datos generales</h5>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm">
                           <form action="" method="POST" id="editprov" name="editprov" autocomplete="off">
                              <input type="number" hidden name="codprov" id="codprov" value="<?php echo $datos['datos']->codproveedor ?>">
                              <label>Nombre o Razon Social <a style="color:red">*</a></label>
                              <input required oninvalid="this.setCustomValidity('Este campo es Obligatorio si desea guardar los otros campos')" oninput="this.setCustomValidity('')" type="text" class="form-control form-control-sm" id="provname" name="provname" value="<?php echo $datos['datos']->nombre ?>">
                              <input type="checkbox" id="personafisica" name="personafisica" <?php if ($datos['datos']->personafisica == 1) {
                                                                                                echo "value='true' checked";
                                                                                             } else {
                                                                                                echo "value='false'";
                                                                                             }  ?>>&nbsp;&nbsp;Persona fisica <a style="color:red">*</a>
                        </div>
                        <div class="col-sm">
                           <label>Tipo Doc <a style="color:red">*</a></label>
                           <select id="type_id" name="type_id" value="" class="form-control form-control-sm">
                              <?php switch ($datos['datos']->type_id) {
                                 case '1':
                                    echo '<option value="" disabled>Selecciona</option>
                               <option selected value="1">NIT</option>
                               <option value="2">CC</option>
                               <option value="3">CE</option>';
                                    break;
                                 case '2':
                                    echo '<option value="" disabled>Selecciona</option>
                                   <option  value="1">NIT</option>
                                   <option selected value="2">CC</option>
                                   <option value="3">CE</option>';
                                    break;
                                 case '3':
                                    echo '<option value="" disabled>Selecciona</option>
                                       <option  value="1">NIT</option>
                                       <option value="2">CC</option>
                                       <option selected value="3">CE</option>';
                                    break;
                              } ?>
                           </select>
                        </div>
                        <div class="col-sm">
                           <label>NIT/CC <a style="color:red">*</a></label>
                           <input type="text" class="form-control form-control-sm" id="provcifnif" name="provcifnif" value="<?php echo $datos['datos']->cifnif ?>">
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
                     </div>
                     &nbsp;
                     <div class="row">
                        <div class="col-sm">
                           <label>Forma de pago:</label>
                           <select required id="fp" name="fp" value="" class="form-control form-control-sm">
                              <?php
                              if ($datos['datos']->fp != "") {
                                 switch ($datos['datos']->fp) {
                                    case '0':
                                       echo '<option value="" selected disabled>Selecciona</option>
                                <option  value="1">Transferencia bancaria</option>
                                <option value="2">Al contado</option>
                                <option value="3">Cheque</option>';
                                       break;
                                    case '1':
                                       echo '<option value="" disabled>Selecciona</option>
                                <option selected value="1">Transferencia bancaria</option>
                                <option value="2">Al contado</option>
                                <option value="3">Cheque</option>';
                                       break;
                                    case '2':
                                       echo '<option value="" disabled>Selecciona</option>
                                    <option  value="1">Transferencia bancaria</option>
                                    <option selected value="2">Al contado</option>
                                    <option value="3">Cheque</option>';
                                       break;
                                    case '3':
                                       echo '<option value="" disabled>Selecciona</option>
                                        <option  value="1">Transferencia bancaria</option>
                                        <option value="2">Al contado</option>
                                        <option selected value="3">Cheque</option>';
                                       break;
                                 }
                              } else {
                                 echo '<option value="" selected disabled>Selecciona</option>
                                        <option  value="1">Transferencia bancaria</option>
                                        <option value="2">Al contado</option>
                                        <option  value="3">Cheque</option>';
                              } ?>
                           </select>
                        </div>
                        <div class="col-sm">
                           <label>Divisa</label>
                           <select class="form-control form-control-sm" id="divisa" name="divisa">
                              <?php foreach ($datos['div'] as $key => $value) : ?>
                                 <?php if ($value->coddivisa == $datos['datos']->divisa) : ?>
                                    <option selected value="<?php echo $value->coddivisa ?>">
                                       <?php echo $value->descripcion ?></option>
                                 <?php else : ?>
                                    <?php if ($value->coddivisa == 'COP') : ?>
                                       <option selected value="<?php echo $value->coddivisa ?>"><?php echo $value->descripcion ?></option>
                                    <?php else : ?>
                                       <option value="<?php echo $value->coddivisa ?>"><?php echo $value->descripcion ?></option>
                                    <?php endif; ?>

                                 <?php endif; ?>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <br>
                        <div class="col-sm">
                           <label>Régimen IVA</label>
                           <select required id="riva" name="riva" class="form-control form-control-sm">
                              <?php switch ($datos['datos']->riva) {
                                 case '0':
                                    echo '<option value="" selected disabled>Selecciona</option>
                            <option value="1">Común</option>
                        <option value="2">Simplificado</option>
                        <option value="3">Simple</option>';
                                    break;
                                 case '1':
                                    echo '<option value="" disabled>Selecciona</option>
                            <option selected value="1">Común</option>
                        <option value="2">Simplificado</option>
                        <option value="3">Simple</option>
                            ';
                                    break;
                                 case '2':
                                    echo '<option value="" disabled>Selecciona</option>
                            <option value="1">Común</option>
                            <option selected value="2">Simplificado</option>
                            <option value="3">Simple</option>';
                                    break;
                                 case '3':
                                    echo '<option value="" disabled>Selecciona</option>
                               <option value="1">Común</option>
                               <option value="2">Simplificado</option>
                               <option selected value="3">Simple</option>';
                                    break;
                                 default:
                                    echo '<option value="" selected disabled>Selecciona</option>
                        <option value="1">Común</option>
                        <option value="2">Simplificado</option>
                        <option value="3">Simple</option>';
                              } ?>
                           </select>
                        </div>
                     </div>
                     <br>
                     <div class="row">
                        <div class="col-sm">
                           <textarea id="obs" name="obs" placeholder="Observaciones..." class="form-control form-control-sm"><?php echo $datos['datos']->observaciones ?></textarea>
                           <p><a style="color:red">*</a><strong>Datos obligatorios</strong></p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm">
                           <label>Estado</label>
                           <select class="form-control form-control-sm " style="width: 200px" id="estado" name="estado">
                              <?php switch ($datos['datos']->estado):
                                 case 0: ?>
                                    <option selected value="0">Inactivo</option>
                                    <option value="1">Activo</option>
                                    <?php break; ?>
                                 <?php
                                 case 1: ?>
                                    <option value="0">Inactivo</option>
                                    <option selected value="1">Activo</option>
                                    <?php break; ?>
                              <?php endswitch; ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer">
                     <button type="submit" id="btneditprov" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>
                  </div>
                  </form>
               </div>
            </div>
            <div class="tab-pane fade" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
               <div class="card card-primary border-primary">
                  <div class="card-header bg-primary  mb-3">
                     <h5 class="card-title" style="color:white">Cuenta Bancaria</h5>
                  </div>
                  <div class="card-body">
                     <form action="" id="editaccount" name="editaccount" method="POST" autocomplete="off">
                        <input type="number" hidden name="accprov" id="accprov" value="<?php echo $datos['datos']->codproveedor ?>">
                        <div class="row">
                           <div class="col-sm-4">
                              <label>Nombre de banco <a style="color:red">*</a></label>
                              <input required oninvalid="this.setCustomValidity('Este campo es Obligatorio si desea guardar los datos')" oninput="this.setCustomValidity('')" class="form-control form-control-sm" id="bancname" name="bancname" value="<?php echo $datos['datos']->bancname ?>">
                           </div>
                           <div class="col-sm-4">
                              <label>Tipo de Cuenta</label>
                              <select required class="form-control form-control-sm" id="banctype" name="banctype">
                                 <?php switch ($datos['datos']->banctype) {
                                    case 1:
                                       echo "<option selected value='" . $datos['datos']->banctype . "'>Ahorros</option><option  value='2'>Corriente</option>";
                                       break;
                                    case 2:
                                       echo "<option value='1'>Ahorros</option><option selected  value='" . $datos['datos']->banctype . "'>Corriente</option>";
                                       break;

                                    default:
                                       echo "<option selected disabled value=''>Selecciona</option><option value='1'>Ahorros</option><option  value='2'>Corriente</option>";
                                       break;
                                 } ?>
                              </select>
                           </div>
                           <div class="col-sm-4">
                              <label>Numero de Cuenta</label>
                              <input class="form-control form-control-sm" id="bancnumber" name="bancnumber" value="<?php echo $datos['datos']->no_cuenta ?>">
                           </div>
                        </div>
                        <p><a style="color:red">*</a><strong>Datos obligatorios</strong></p>
                  </div>
                  <div class="card-footer">
                     <button type="submit" id="btneditaccount" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>
                  </div>
                  </form>
               </div>
            </div>
            <div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab">
               <div class="card card-primary border-primary">
                  <div class="card-header bg-primary  mb-3">
                     <h5 class="card-title" style="color:white">Dirección</h5>
                  </div>
                  <div class="card-body">
                     <form action="" id="editaddress" name="editaddress" method="POST" autocomplete="off">
                        <input type="number" hidden name="addrprov" id="addrprov" value="<?php echo $datos['datos']->codproveedor ?>">
                        <div class="row">
                           <div class="col-sm">
                              <label>País</label>
                              <select required class="form-control form-control-sm" id="country" name="country">
                                 <?php foreach ($datos['country'] as $key => $value) : ?>
                                    <?php if ($value->codpais == $datos['datos']->country) : ?>
                                       <option selected value="<?php echo $value->codpais ?>">
                                          <?php echo $value->nombre ?>
                                       </option>
                                    <?php else : ?>
                                       <option value="<?php echo $value->codpais ?>"><?php echo $value->nombre ?>
                                       </option>
                                    <?php endif; ?>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                           <div class="col-sm">
                              <label>Departamento <a style="color:red">*</a></label>
                              <input class="form-control form-control-sm" id="deptoprov" name="deptoprov" value="<?php echo $datos['datos']->deptoprov ?>">
                           </div>
                           <div class="col-sm">
                              <label>Ciudad <a style="color:red">*</a></label>
                              <input class="form-control form-control-sm" id="cityprov" name="cityprov" value="<?php echo $datos['datos']->cityprov ?>">
                           </div>
                           <div class="col-sm">
                              <label>Codigo Postal</label>
                              <input class="form-control form-control-sm" id="codpprov" name="codpprov" value="<?php echo $datos['datos']->codpprov ?>">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-sm">
                              <label>Dirección <a style="color:red">*</a></label>
                              <textarea required oninvalid="this.setCustomValidity('Este campo es Obligatorio si desea guardar los datos')" oninput="this.setCustomValidity('')" class="form-control form-control-sm" id="addressprov" name="addressprov"><?php echo $datos['datos']->direccion ?></textarea>
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
            <div class="tab-pane fade" id="v-pills-docs" role="tabpanel" aria-labelledby="v-pills-docs-tab">
               <div class="card card-primary border-primary">
                  <div class="card-header bg-primary  mb-3">
                     <h5 class="card-title" style="color:white">Documentos</h5>
                  </div>
                  <div class="card-body">
                     <p>En esta sección podrá adjuntar archivo en formato PDF el cuál llevará el RUT y el documento de identidad del tercero/proveedor</p>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label class="col-form-label">Adjunto:</label>
                              <div class="custom-file" id="customFile">
                                 <form id="adj_doc" method="POST" enctype="multipart/form-data" action="">
                                    <input accept=".pdf" type="file" class="custom-file-input" name="adjunto_pdf" onchange="upload_adj()" id="adjunto_pdf" aria-describedby="fileHelp">
                                    <label class="custom-file-label" for="exampleInputFile"> <i class="fas fa-upload"></i> Seleccionar Archivo </label>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <?php if ($datos['datos']->adjunto_pdf != null &&  $datos['datos']->adjunto_pdf != '') : ?>
                           <div class="col-md-3" id="load_doc_pdf"> <a href="<?php echo RUTA_URL ?>/facturacion/files?pdf=Upload/Facturacion/pdf/<?php echo $datos['datos']->adjunto_pdf ?>" title="Documento"> <i class="fas fa-file-pdf"></i>
                                 <h4>Documento</h4>
                              </a> <small>pdf max 1MB</small> </div>
                        <?php else : ?>
                           <div class="col-md-3" id="load_doc_pdf"></div>
                        <?php endif; ?>
                     </div>

                  </div>
                  <div class="card-footer">
                     <button type="submit" id="btneditaddress" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>
                  </div>
                  </form>
               </div>
            </div>

            <div class="tab-pane fade" id="v-pills-facturas" role="tabpanel" aria-labelledby="v-pills-facturas-tab">
               <input type="text" hidden id="cifnif" name="cifnif" value="<?php echo $datos['datos']->cifnif ?>">
               <div class="table table-responsive ">
                  <table id="invoicesprov" style="width:100%">
                     <thead>
                        <tr>
                           <th style="width:20px">Número</th>
                           <th>Descuentos</th>
                           <th>IVA</th>
                           <th>Total</th>
                           <th>Observaciones</th>
                           <th>Estado</th>
                           <th>Acciones </th>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<br>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>