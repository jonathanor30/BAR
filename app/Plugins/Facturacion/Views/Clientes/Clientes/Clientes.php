<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Clientes/Cliente.js"></script>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group">
                <select class="btn btn-secondary btn-sm" onchange="cambiar()" id="festado" name="festado">
                    <option value="" selected>Filtrar</option>
                    <option value="0">Inactivo</option>
                    <option value="1">Activo</option>
                </select>
                &nbsp;&nbsp;
                <a id="btn_nuevo_proveedor" class="btn btn-success btn-sm " data-toggle="modal" data-target="#addprov"><i class="fa fa-plus" style="color:white"></i>&nbsp; <strong style="color:white">Nuevo</strong></a>
                <button id="import" title="Importar excel" data-toggle="modal" data-target="#addfile" class="btn btn-secundary btn-sm">
                    <span class="fas fa-file-import"></span>
                </button>
                <form method="post" action="<?php echo RUTA_URL ?>/Facturacion/page/FicheroCliente">
                    <button type="submit" title="Descargar plantilla para subir datos" class="btn btn-secundary btn-sm">
                        <span class="fas fa-file-download"></span>
                    </button>
                </form>
                <form method="post" action="<?php echo RUTA_URL ?>/Facturacion/page/glosarioC">
                    <button type="submit" title="Descargar glosario" class="btn btn-secundary btn-sm">
                        <span class="fab fa-gofore"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <br>
    <br><br>
    <div class="table table-responsive ">
        <table id="clientes" style="width:100%">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>NIT/CC</th>
                    <th>email</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal" id="addprov" tabindex="-1" role="dialog" aria-labelledby="Modalprov" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Modalprov">Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newclient" method="post" action="" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Nombre:</label>
                        </div>
                        <div class="col">
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-2">
                            <label>NIT/CC:</label>
                        </div>
                        <div class="col-sm-4">
                            <select required id="tipoidfiscal" name="tipoidfiscal" class="form-control form-control-sm">
                                <option value="" selected disabled>Selecciona</option>
                                <option value="NIT">NIT</option>
                                <option value="CC">CC</option>
                                <option value="CE">CE</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" id="cifnif" name="cifnif" class="form-control form-control-sm">
                            <input type="checkbox" id="personafisica" name="personafisica" value="true">Persona Física
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Telefono</label>
                        </div>
                        <div class="col">
                            <input type="text" id="telefono1" name="telefono1" class="form-control form-control-sm">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-2">
                            <label><a href="#">Pais</a></label>
                        </div>
                        <div class="col-sm">
                            <select required class="form-control form-control-sm" id="pais" name="pais">
                                <?php foreach ($datos['datos'] as $key => $value) : ?>
                                    <?php if ($value->codiso == 'CO') : ?>
                                        <option selected value="<?php echo $value->codiso ?>"><?php echo $value->nombre ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $value->codiso ?>"><?php echo $value->nombre ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Departamento:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="departamento" name="departamento" class="form-control form-control-sm ">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Ciudad:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="ciudad" name="ciudad" class="form-control form-control-sm ">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Código Postal:</label>
                        </div>
                        <div class="col-sm">
                            <input type="number" id="codpostal" name="codpostal" class="form-control form-control-sm ">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Dirección:</label>
                        </div>
                        <div class="col-sm">
                            <input type="text" id="direccion" name="direccion" class="form-control form-control-sm ">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btnaddclient" class="btn btn-sm btn-primary btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal file -->
<div class="modal fade" id="addfile" tabindex="1" role="dialog" aria-labelledby="Modalagenda" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Modalfile">Importar archivo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmimp" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label> Seleccione el <strong>EXCEL</strong> para importar
                                <input class="form-control-file" required type="file" accept=".xlsx,.xls" name="carga" id="carga" /></label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btnimportar" class="btn btn-success">Importar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>