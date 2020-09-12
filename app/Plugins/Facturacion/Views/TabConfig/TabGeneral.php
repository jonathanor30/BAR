<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <br>
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    Certificado digital para firma y envio <i class="fas fa-medal"></i>
                </div>
                <div class="card-body">
                    <div id="certificadoConfig">
                        <?php if ($datos['configFE']->certificado != null) : ?>
                            <h5>Ya se encuentra instalado un certificado</h5>
                            <button class="btn btn-sm btn-success" type="button" onclick="updateCertifique()">Actualizar certificado</button>
                        <?php else : ?>
                            <form id="UploadCerticate">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">NIT:</label>
                                    <input type="text" class="form-control form-control-sm" id="nitemisor" name="nitemisor" placeholder="Ingrese el NIT" onchange="eliminaEspacio();">
                                    <small class="form-text text-danger">Por favor ingrese el NIT sin digito de verificación</small>
                                </div>
                                <div class="form-group">
                                    <label>Archivo:</label>
                                    <div class="custom-file" id="customFile"> <input type="file" accept=".pfx, .p12" class="custom-file-input form-control form-control-sm" id="fileToUpload" name="fileToUpload" onchange="upload_file();" aria-describedby="fileHelp"> <label class="custom-file-label" for="exampleInputFile"> <i class="fas fa-upload"></i> Seleccionar Archivo </label> </div>
                                    <small class="form-text text-danger">La extensión de archivo debe ser <b>.pfx</b> o <b>.p12</b></small>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <div class="upload-msg"></div>
                        <!--Para mostrar la respuesta del archivo llamado via ajax -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    Compatibilidad Facturación Electrónica <i class="fas fa-server"></i>
                </div>
                <div class="card-body">
                    <div class="compatibility-msg"></div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    Activación funcionalidad facturación electrónica
                </div>
                <div class="card-body">
                    <div id="system-enable">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="enable-system" onchange="enablesystem(this)" <?php echo ($datos['configFE']->enabled == 2 ? "" : "checked") ?>>
                            <label class="custom-control-label" for="enable-system">Activación del sistema</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    Configuración general | facturación Electrónica <i class="fas fa-tasks"></i>
                </div>
                <div class="card-body">
                    <form id="configuracionesFE" method="post" autocomplete="off">
                        <fieldset id="myFieldset" disabled="disabled">
                            <div class="row">
                                <div class="col-sm">
                                    <label>Idioma:</label>
                                    <input type="text" class="form-control form-control-sm" id="idioma" name="idioma" placeholder="ES..." value="<?php echo $datos['configFE']->idioma; ?>">
                                    <small>Debe indicar la sigla del idioma, para español: <b>ES</b>, para ingles: <b>EN</b></small>
                                </div>
                                <div class="col-sm">
                                    <label>Código de país:</label>
                                    <input type="text" class="form-control form-control-sm" id="codigo_pais" name="codigo_pais" placeholder="COL..." value="<?php echo $datos['configFE']->codigo_pais; ?>">
                                </div>
                                <div class="col-sm">
                                    <label>Código de documento:</label>
                                    <input type="text" class="form-control form-control-sm" id="codigo_documento" name="codigo_documento" placeholder="..." value="<?php echo $datos['configFE']->codigo_documento; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <label>Tipo de empresa:</label>
                                    <input type="text" class="form-control form-control-sm" id="tipo_empresa" name="tipo_empresa" placeholder="Ingrese aquí el tipo de empresa..." value="<?php echo $datos['configFE']->tipo_empresa; ?>">
                                </div>
                                <div class="col-sm">
                                    <label>Tipo de régimen:</label>
                                    <input type="text" class="form-control form-control-sm" id="tipo_regimen" name="tipo_regimen" placeholder="Ingrese aquí el tipo de régimen..." value="<?php echo $datos['configFE']->tipo_regimen; ?>">
                                </div>
                                <div class="col-sm">
                                    <label>Número de matrícula mercantíl:</label>
                                    <input type="text" class="form-control form-control-sm" id="no_matricula" name="no_matricula" placeholder="Ingrese número de matrícula..." value="<?php echo $datos['configFE']->no_matricula; ?>">
                                </div>
                                <div class="col-sm">
                                    <label>Responsabilidades:</label>
                                    <select class="form-control form-control-sm" id="liabilities">
                                        <option value="" selected disabled>Selecciona</option>
                                        <?php foreach ($datos['liabilities'] as $key => $value) : ?>
                                            <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm">
                                    <label class="form-label">Seleccionadas:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend" id="remove-liabilities">
                                            <div class="input-group-text">x</div>
                                        </div>
                                        <input readonly="" type="text" name="responsabilidades" id="responsabilidades" class="form-control form-control-sm" value="<?php echo $datos['configFE']->responsabilidades ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <label>Código de municipio:</label>
                                    <input type="text" class="form-control form-control-sm" id="codigo_municipio" name="codigo_municipio" placeholder="Ingrese código de municipio DANE..." value="<?php echo $datos['configFE']->codigo_municipio; ?>">
                                </div>
                                <div class="col-sm">
                                    <label>ID Software:</label>
                                    <input type="text" class="form-control form-control-sm" id="id_software" name="id_software" placeholder="..." value="<?php echo $datos['configFE']->id_software; ?>">
                                </div>
                                <div class="col-sm">
                                    <label>PIN del Software:</label>
                                    <input type="text" class="form-control form-control-sm" id="pin_software" name="pin_software" placeholder="..." value="<?php echo $datos['configFE']->pin_software; ?>">
                                </div>
                                <?php if($datos['configFE']->tipo_ambiente == 2): ?>
                                    <div class="col-sm">
                                    <label>Set de pruebas:</label>
                                    <input type="text" class="form-control form-control-sm" id="testsid" name="testsid" placeholder="..." value="<?php echo $datos['configFE']->testsid; ?>">
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <label>Clave del certificado:</label>
                                    <input type="password" class="form-control form-control-sm" id="clave_certificado" name="clave_certificado" placeholder="********" value="<?php echo $datos['configFE']->clave_certificado; ?>">
                                </div>
                                <div class="col-sm">
                                    <label>Confirme la clave certificado:</label>
                                    <input type="password" class="form-control form-control-sm" id="clave_certificado_confirm" name="clave_certificado_confirm" placeholder="********" onkeyup="validatePass('clave_certificado')" value="<?php echo $datos['configFE']->clave_certificado; ?>">
                                </div>
                                <div class="col-sm">
                                    <label>Vigencia del certificado:</label>
                                    <input type="date" class="form-control form-control-sm" id="vigencia_certificado" name="vigencia_certificado" value="<?php echo $datos['configFE']->vigencia_certificado; ?>">
                                </div>
                                <div class="col-sm">
                                    <label>Tipo de ambiente:</label>
                                    <select  class="form-control form-control-sm" name="tipo_ambiente" id="tipo_ambiente">
                                        <option value="1">Producción</option>
                                        <option value="2">Desarrollo</option>
                                    </select>
                                    <script>
                                        document.getElementById("tipo_ambiente").value = <?php echo $datos['configFE']->tipo_ambiente ?>;
                                    </script>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto" id="resultEdit">
                                <button type="button" onclick="enabledConfig();" id="enableConfig" class="btn btn-sm btn-secondary">Editar <i class="fas fa-edit"></i></button>
                            </div>
                            <div class="col-sm-auto">
                                <!-- Button trigger modal -->
                                <button type="button" title="Configuración de correo electronico para envio de alertas y documentos." class="btn btn-sm btn-primary" data-toggle="modal" data-target="#CorreoModal">
                                    <i class="fas fa-server fa-fw" aria-hidden="true"></i> Servidor de correo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="CorreoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Configuración de correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Servidor</label>
                    <input type="text" class="form-control form-control-sm form-control form-control-sm-sm" id="hostEmail" name="hostEmail" value="<?php echo $datos['configFE']->hostEmail ?>" placeholder="mail.tudominio.com">
                    <small id="emailHelp" class="form-text text-muted">Solo para correo corporativo</small>
                </div>
                <div class="form-group">
                    <label>Cuenta de correo</label>
                    <input type="email" class="form-control form-control-sm form-control form-control-sm-sm" id="userEmail" name="userEmail" value="<?php echo $datos['configFE']->userEmail ?>" placeholder="gtep@tudominio.com">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" class="form-control form-control-sm form-control form-control-sm-sm" id="passwordEmail" name="passwordEmail" placeholder="*********">
                </div>
                <div class="form-group">
                    <label>Repetir Contraseña</label>
                    <input type="password" class="form-control form-control-sm form-control form-control-sm-sm" id="repassword" name="repassword" placeholder="*********">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="btnEmail" onclick="configEmail();">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>