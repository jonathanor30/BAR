<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script>
    elements = [];
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-6">
            <div class="btn-group">
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/FacturasCliente" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-lg-inline-block">Factura Cliente</span>
                </a>
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/detalleFactura/<?php echo $datos['datos'][0]->idfactura ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <br>
    <!--Aca inicia  Navs-->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#facturas" role="tab" aria-controls="pills-home" aria-selected="true"><?php echo ($datos['datos'][0]->estado != 3 && $datos['datos'][0]->estado != 4 ? 'Editar Factura ' : ($datos['datos'][0]->estado == 4 ? 'Factura electrónica ' : 'Ver Factura ')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#recibos" role="tab" aria-controls="pills-profile" aria-selected="false">Ingresos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-notas-tab" data-toggle="pill" href="#notas" role="tab" aria-controls="pills-notas" aria-selected="false">Notas D/C</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="facturas" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="card">
                <div class="card-header">
                    <h3> <?php echo ($datos['datos'][0]->estado != 3 && $datos['datos'][0]->estado != 4 ? 'Editar Factura de Venta # ' . $datos['datos'][0]->numero : ($datos['datos'][0]->estado == 3 || $datos['datos'][0]->estado == 4 ? 'Factura electrónica # ' . $datos['datos'][0]->numero2 : 'Ver Factura de Venta # ' . $datos['datos'][0]->numero)) ?>
                        <?php if ($datos['datos'][0]->estado == 3 || $datos['datos'][0]->estado == 4) : ?>
                            <a href="<?php echo RUTA_URL; ?>/Facturacion/ajaxFE/descargarXml/<?php echo $datos['datos'][0]->nombrexml ?>?doc=fv" class="btn btn-sm btn-outline-secondary " style="float: right;"><i class="fab fa-xing"></i>&nbsp; <strong>Descargar XML</strong></a>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="card-body">
                    <h4> Datos del cliente</h4>
                    <br>
                    <form class="form-horizontal" role="form" id="datos_factura" method="POST" autocomplete="on">
                        <div class="form-group row">
                            <input hidden type="text" id="enabled" value="<?php echo $datos['configFE']->enabled ?>">
                            <label for="mail" class="col-md-1 control-label">NIT/CC</label>
                            <div class="col-sm">
                                <input type="text" class="form-control form-control-sm" id="ClieNit" name="cifnif" required="" value="<?php echo $datos['datos'][0]->cifnif ?>">
                                <input hidden type="number" id="id_cliente" name="codcliente" value="<?php echo $datos['cliente']->id_cliente ?>">
                                <input hidden type="number" name="idfactura" value="<?php echo $datos['datos'][0]->idfactura ?>">
                            </div>
                            <label for="mail" class="col-md-1 control-label">Nombre</label>
                            <div class="col-sm">
                                <input type="text" class="form-control form-control-sm" id="ClieNombre" name="nombrecliente" required="" value="<?php echo $datos['datos'][0]->nombrecliente ?>">
                            </div>
                            <label for="tel1" class="col-md-1 control-label">Teléfono</label>
                            <div class="col-sm">
                                <input type="text" class="form-control form-control-sm" id="ClieTelefono" readonly="" required="" value="<?php echo $datos['cliente']->telefono1 ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre_cliente" class="col-md-1 control-label">Email</label>
                            <div class="col-sm">
                                <input type="text" class="form-control form-control-sm ui-autocomplete-input" id="ClieEmail" " required="" autocomplete=" off" readonly="" required="" value="<?php echo $datos['cliente']->email ?>">
                            </div>
                            <label for="mail" class="col-md-1 control-label">Dirección</label>
                            <div class="col-sm">
                                <input type="text" class="form-control form-control-sm" id="ClieDireccion" placeholder="" readonly="" required="" value="<?php echo $datos['cliente']->direccion ?>">
                            </div>
                            <label>Medio de pago:</label>
                            <div class="col-sm">
                                <select class="form-control form-control-sm" id="medio_pago" name="medio_pago">
                                    <option value="" selected disabled>Selecciona</option>
                                    <?php foreach ($datos['payment'] as $key => $value) : ?>
                                        <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <label>Referencia</label>
                                <input class="form-control form-control-sm" id="ref" placeholder="" type="text" value="<?php echo $datos['datos'][0]->referencia ?>" name="referenciaInv">
                            </div>
                            <div class="col-sm">
                                <label>Fecha</label>
                                <input class="form-control form-control-sm" id="fecha" placeholder="" type="date" value="<?php echo $datos['datos'][0]->fecha ?>" name="fecha" required="">
                            </div>
                            <div class="col-sm">
                                <label>Vencimiento</label>
                                <input class="form-control form-control-sm" id="fecha_venc" placeholder="" type="date" value="<?php echo $datos['datos'][0]->vencimiento ?>" name="vencimiento" required="">
                            </div>
                            <div class="col-sm">
                                <label>FP</label>
                                <select class="form-control form-control-sm" id="FacFormaPago" name="fp">
                                    <option value="1">Contado</option>
                                    <option value="2">Crédito</option>
                                </select>
                            </div>
                            <div class="col-sm">
                                <label>Estado de factura</label>
                                <select class="form-control form-control-sm" id="FacEstado" name="estado">
                                    <?php switch ($datos['datos'][0]->estado):
                                        case 1: ?>
                                            <option disabled value="">Selecciona opción</option>
                                            <option selected value="1">Pagada</option>
                                            <option value="0">Pendiente</option>
                                            <option disabled value="3">Completada</option>
                                            <option disabled value="4">Firmada/Pagada</option>
                                            <?php break; ?>
                                        <?php
                                        case 2: ?>
                                            <option selected value="2">Generar Nota Crédito</option>
                                            <option value="5">Generar Nota Débito</option>
                                            <?php break; ?>
                                        <?php
                                        case 3: ?>
                                            <option selected value="2">Generar Nota Crédito</option>
                                            <option value="5">Generar Nota Débito</option>
                                            <option selected value="3">Firmada</option>
                                            <option value="4">Firmada/Pagada</option>
                                            <?php break; ?>
                                        <?php
                                        case 4: ?>
                                            <option selected value="4">Firmada/Pagada</option>
                                            <option value="5">Generar Nota Débito</option>
                                            <?php break; ?>
                                        <?php
                                        case 5: ?>
                                            <option value="2">Generar Nota Crédito</option>
                                            <option selected value="5">Generar Nota Débito</option>
                                            <?php break; ?>
                                        <?php
                                        case 6: ?>
                                            <option selected value="6">NCrédito/NDébito</option>
                                            <option value="2">Generar Nota Crédito</option>
                                            <option value="5">Generar Nota Débito</option>
                                            <?php break; ?>
                                        <?php
                                        default: ?>
                                            <option disabled value="">Selecciona opción</option>
                                            <option value="1">Pagada</option>
                                            <option selected value="0">Pendiente</option>
                                    <?php endswitch; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-auto">
                                <label class="control-label">Referencia</label>
                                <input class="form-control form-control-sm" type="text" id="line_reference">
                                <label class="control-label">Producto/servicio</label>
                                <input class="form-control form-control-sm input_code" type="text" id="line_code_name">
                                <input hidden type="text" id="line_code">

                            </div>
                            <div class="col-sm-auto">
                                <label class="control-label">Producto / Servicio</label>
                                <textarea class="form-control form-control-sm" type="text" id="ProdNombre" placeholder="Escriba el nombre del producto o servicio a facturar..."></textarea>
                            </div>
                            <div class="col-sm-auto">
                                <label class="control-label">Cantidad</label>
                                <input class="form-control form-control-sm" type="number" min="1" id="cantidad">
                            </div>
                            <div class="col-sm-auto">
                                <label class="control-label">Precio</label>
                                <input class="form-control form-control-sm" type="number" id="ProdPrecioVenta" placeholder="Escriba el precio de venta">
                            </div>
                            <div class="col-sm-auto">
                                <label class="control-label">Dto %</label>
                                <input maxlength="3" type="number" min="0" max="100" class="form-control form-control-sm" id="Dto" placeholder="Escriba el descuento en %">
                            </div>
                            <div class="col-sm-auto">
                                <label class="control-label">Recargo %</label>
                                <input maxlength="3" type="number" min="0" max="100" class="form-control form-control-sm" id="recargo" placeholder="Escriba el recargo en %">
                            </div>
                            <div class="col-sm-auto">
                                <label class="control-label">RE %</label>
                                <input maxlength="2" type="number" min="0" max="20" step="any" class="form-control form-control-sm" id="RE" placeholder="Retenciones">
                            </div>
                            <div class="col-sm-auto">
                                <label class="control-label"> IVA</label>
                                <select class="form-control form-control-sm iva" id="iva">
                                    <option value='19'>19%</option>
                                    <option value='5'>5%</option>
                                    <option value='0'>0%</option>
                                </select>
                            </div>
                            <div class="col-sm-auto">
                                <a class="btn btn-sm btn-success text-light" style="float:right" onclick="agregaritem();" role="button"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="center"></th>
                                        <th>Referencia</th>
                                        <th>Articulo</th>
                                        <th class="right">Cantidad</th>
                                        <th class="center">Precio</th>
                                        <th>Descuento</th>
                                        <th>Recargo</th>
                                        <th>Neto</th>
                                        <th>Retenciones</th>
                                        <th>IVA</th>
                                        <th class="right">Total</th>
                                        <th class="right">Quitar</th>
                                    </tr>
                                </thead>
                                <tbody id="TableBody">
                                    <?php foreach ($datos['datos'][0]->Lines()->get() as $key => $value) : ?>
                                        <tr id="<?php echo $value->no_linea ?>">
                                            <td><input hidden class='form-control input-sm numero_item' type='text' name='numero_item[]' readonly value='<?php echo $value->no_linea ?>' required></td>
                                            <td>
                                                <input class='form-control form-control-sm Reference' type='text' name='referencia[]' value='<?php echo $value->referencia ?>' readonly='' required='' title='<?php echo $value->referencia ?>'>
                                                <input hidden class='form-control form-control-sm input_code' type='text' name='codigo[]' value='<?php echo $value->codigo_estandar ?>' readonly='' required='' title='<?php echo $value->codigo_estandar ?>'>
                                            </td>
                                            <td><input class='form-control form-control-sm ProdNombre' type='text' name='ProdNombre[]' value='<?php echo $value->descripcion ?>' readonly='' required='' title='<?php echo $value->descripcion ?>'></td>
                                            <td><input class='form-control form-control-sm cantidad' name='cantidad[]' value='<?php echo $value->cantidad ?>' readonly='' required=''></td>
                                            <td><input class='form-control form-control-sm ProdPrecioVenta' name='ProdPrecioVenta[]' value='<?php echo number_format($value->pvpunitario, 2, '.', '') ?>' readonly='' required=''></td>
                                            <td><input class='form-control form-control-sm dto' name='dto[]' value='<?php echo number_format($value->dtopor, 2, '.', '') ?>' readonly='' required=''></td>
                                            <td><input class='form-control form-control-sm recargo' name='recargo[]' value='<?php echo number_format($value->recargo, 2, '.', '') ?>' readonly='' required=''></td>
                                            <td><input class='form-control form-control-sm subtotal' name='subtotal[]' value='<?php echo number_format($value->neto, 2, '.', '') ?>' readonly='' required=''></td>
                                            <td><input class='form-control form-control-sm RE' name='RE[]' value='<?php echo number_format($value->retencion, 2, '.', '') ?>' readonly='' required=''></td>
                                            <td><input class='form-control form-control-sm iva' name='iva[]' value='<?php echo number_format($value->iva, 2, '.', '') ?>' readonly='' required=''></td>
                                            <td><input class='form-control form-control-sm total' name='total[]' value='<?php echo number_format($value->pvptotal, 2, '.', '') ?>' readonly='' required=''></td>
                                            <td>
                                                <div class="btn-group"><button type="button" title="Editar linea" class="btn btn-warning btn-sm edit"><i class='fas fa-edit log'></i></button><button class='btn btn-danger btn-sm del' type='button' title='Delete' onclick='deleteRow(<?php echo $value->no_linea ?>, <?php echo round($value->pvptotal, 2) ?> );'><i class='fas fa-trash'></i></button></div>
                                            </td>

                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </tbody>
                            </table>
                            <div class="form-group text-right">
                                <div class="col">
                                    <label class="control-label"><span class="badge badge-primary">Total:</span></label>
                                    <input id="sumViewTotal" class="form-control " style="border:none;outline: none;cursor:none; font-size: 25px;" type="" value="" readonly />
                                    <input type="hidden" id="sumAll" type="" value="<?php echo $datos['datos'][0]->total ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Observaciones</label>
                                <textarea class="form-control" name="observaciones"><?php echo $datos['datos'][0]->observaciones ?></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?php if ($datos['datos'][0]->estado != 4) { ?>
                                <button type="submit" id="btnsaveinvprov" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="recibos" role="tabpanel" aria-labelledby="pills-profile-tab">
            <br>
            <a id="btn_nuevo_ingreso" class="btn btn-success btn-sm " data-toggle="modal" data-target="#addin"><i class="fa fa-plus" style="color:white"></i>&nbsp; <strong style="color:white">Nuevo</strong></a>
            <br><br><br>
            <?php $total = 0 ?>
            <?php foreach ($datos['recibo'] as $key => $value) {
                $total = $total + $value->importe;
            } ?>
            <div class="table-responsive">
                <table class="table table-bordered border-primary table-hover" id="Ingresos" style="width: 100%">
                    <thead>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Divisa</th>
                        <th>Importe</th>
                        <th>FP</th>
                        <th>Observaciones</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>

                </table>
            </div>
            <div id="restante">
                <br><textarea class="form-control form-control-sm" id="rest"></textarea>
            </div>
        </div>
        <div class="tab-pane fade" id="notas" role="tabpanel" aria-labelledby="pills-notas-tab">
            <br><br><br>
            <div class="table-responsive">
                <table class="table table-bordered border-primary table-hover" id="Notas" style="width: 100%">
                    <thead>
                        <th>Número</th>
                        <th>Prefijo</th>
                        <th>Número DIAN</th>
                        <th>Cliente</th>
                        <th>Divisa</th>
                        <th>Importe</th>
                        <th>Observaciones</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="addin" tabindex="-1" role="dialog" aria-labelledby="Modalprov" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Modalprov">Nuevo egreso</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body">
                <form id="newout" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-sm">
                            <label>Cliente</label>
                            <input readonly class="form-control form-control-sm ui-autocomplete-input" id="prov" name="cliente" placeholder="Añade proveedor por nombre" autocomplete="off" value="<?php echo $datos['datos'][0]->nombrecliente ?>">
                            <input type="hidden" id="codprov" name="id_cliente" value="<?php echo $datos['datos'][0]->codcliente ?>">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm">
                            <label>Factura asociada </label>
                            <input type="number" class="form-control form-control-sm" id="factura_asociada" readonly value="<?php echo $datos['datos'][0]->numero ?>">
                            <input type="hidden" id="idfactura" name="idfactura" value="<?php echo $datos['datos'][0]->idfactura ?>">
                            <input type="hidden" id="state" name="state" value="<?php echo $datos['datos'][0]->estado ?>">
                        </div>
                        <div class="col-sm">
                            <label>Importe </label>
                            <input type="text" required class="form-control form-control-sm" id="importe" name="importe">
                        </div>
                        <div class="col-sm">
                            <label>Fecha emisión </label>
                            <input type="date" class="form-control form-control-sm" id="fecha_emitido" name="date_added" value="<?php echo date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" id="divisa" name="divisa" value="<?php echo $datos['cliente']->coddivisa ?>">
                        <div class="col-sm">
                            <label>FP</label>
                            <select class="form-control form-control-sm" id="fp_recibo" name="fp">
                                <option value="1">Efectivo</option>
                                <option value="2">Credito</option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label>Estado</label>
                            <select class="form-control form-control-sm" id="estado_ingreso" name="estado_ingreso" required>
                                <option value="0">Emitido</option>
                                <option value="1">Pagado</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <label>Concepto</label>
                            <textarea required class="form-control form-control-sm" name="concepto" id="concepto">Ingreso generado para la factura No <?php echo $datos['datos'][0]->numero ?></textarea>
                        </div>
                    </div>

            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btnaddout" class="btn btn-sm btn-primary btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button> </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="NC" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Modal">Crear Nota Crédito</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body">
                <form id="creditnote" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-sm">
                            <input type="number" hidden id="idfac" name="idfac" value="<?php echo  $datos['datos'][0]->idfactura ?>">
                            <label>Código de corrección</label>
                            <select required class="form-control form-control-sm" onchange="auto()" name="ResponseCode" id="ResponseCode">
                                <option selected disabled value="">Selecciona opción</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm">
                            <textarea required readonly class="form-control form-control-sm" name="Description" id="Description" placeholder="Descripción motivo de corrección..."></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm">
                            <label>Contraseña</label>
                            <input required type="password" class="form-control form-control-sm" name="password1" id="password1" placeholder="Valide la contraseña...">
                        </div>
                    </div>

            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btn_nc" class="btn btn-sm btn-primary btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button> </div>
            </form>
        </div>
    </div>

    <!--Aca termina-->
    <br>
</div>
<script>
    elements[0] = {
        FacFormaPago: <?php echo $datos['datos'][0]->fp ?>
    };
    elements[1] = {
        medio_pago: <?php echo $datos['datos'][0]->medio_pago ?>
    };
</script>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Clientes/EditarFactura.js"></script>

<?php require RUTA_APP . '/Views/inc/footer.php'; ?>