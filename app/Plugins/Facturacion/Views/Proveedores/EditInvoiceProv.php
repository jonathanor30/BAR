<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Proveedores/EditInvoiceProv.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-6">
            <div class="btn-group">
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/InvoicesProv" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-lg-inline-block">Facturas Proveedor</span>
                </a>
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/Provfactdetail/<?php echo $datos['datos'][0]->idfactura ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <br>
    <!--Aca inicia  Navs-->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#facturas" role="tab" aria-controls="pills-home" aria-selected="true">Editar Factura</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#recibos" role="tab" aria-controls="pills-profile" aria-selected="false">Recibos</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="facturas" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="card">
                <div class="card-header">
                    <h3><?php echo ($datos['datos'][0]->estado != 3 ? 'Editar' : 'Ver') ?> Factura de compra # <?php echo $datos['datos'][0]->numero ?></h3>
                    <input hidden type="number" id="count_recibos" name="count_recibos" value="<?php echo count($datos['recibo']) ?>">
                </div>
                <div class="card-body">
                    <h4> Datos del proveedor</h4>
                    <br>
                    <form class="form-horizontal" role="form" id="datos_factura" method="POST" autocomplete="on">
                        <div class="form-group row">
                            <label for="mail" class="col-md-1 control-label">NIT/CC</label>
                            <div class="col-md-3">
                                <?php if ($datos['datos'][0]->estado != 1 && $datos['datos'][0]->estado != 3) : ?>
                                    <input type="text" class="form-control form-control-sm" id="ClieNit" name="ClieNit" required="" value="<?php echo $datos['datos'][0]->cifnif ?>">
                                <?php else : ?>
                                    <input type="text" readonly class="form-control form-control-sm" id="ClieNit" name="ClieNit" required="" value="<?php echo $datos['datos'][0]->cifnif ?>">
                                <?php endif; ?>
                                <input hidden type="number" id="codproveedor" name="codproveedor" value="<?php echo $datos['datos'][0]->codproveedor ?>">
                                <input hidden type="number" id="idfactura" name="idfactura" value="<?php echo $datos['datos'][0]->idfactura ?>">
                            </div>
                            <label for="mail" class="col-md-1 control-label">Nombre</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" readonly="" required="" value="<?php echo $datos['datos'][0]->nombre ?>">
                            </div>
                            <label for="tel1" class="col-md-1 control-label">Teléfono</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-sm" id="ClieTelefono" name="ClieTelefono" readonly="" required="" value="<?php echo $datos['datos'][0]->telefono ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre_cliente" class="col-md-1 control-label">Email</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm ui-autocomplete-input" id="ClieEmail" name="ClieEmail" required="" autocomplete="off" readonly="" required="" value="<?php echo $datos['datos'][0]->email ?>">
                            </div>
                            <label for="mail" class="col-md-1 control-label">Dirección</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" id="ClieDireccion" name="ClieDireccion" placeholder="" readonly="" required="" value="<?php echo $datos['datos'][0]->direccion ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <label>Referencia</label>
                                <?php if ($datos['datos'][0]->estado != 1 && $datos['datos'][0]->estado != 3) : ?>
                                    <input class="form-control form-control-sm" id="ref" placeholder="" type="text" value="<?php echo $datos['datos'][0]->referencia ?>" name="FacRef" >
                                <?php else : ?>
                                    <input class="form-control form-control-sm" readonly id="ref" placeholder="" type="text" value="<?php echo $datos['datos'][0]->referencia ?>" name="FacRef">
                                <?php endif; ?>
                            </div>
                            <div class="col-sm">
                                <label>Fecha</label>
                                <?php if ($datos['datos'][0]->estado != 1 && $datos['datos'][0]->estado != 3) : ?>
                                    <input class="form-control form-control-sm" id="fecha" placeholder="" type="date" value="<?php echo $datos['datos'][0]->fecha ?>" name="FacFecha" required="">
                                <?php else : ?>
                                    <input class="form-control form-control-sm" readonly id="fecha" placeholder="" type="date" value="<?php echo $datos['datos'][0]->fecha ?>" name="FacFecha" required="">
                                <?php endif; ?>
                            </div>
                            <div class="col-sm">
                                <label>FP</label>
                                <?php if ($datos['datos'][0]->estado != 3) : ?>
                                    <select class="form-control form-control-sm" id="FacFormaPago" name="FacFormaPago">
                                        <?php switch ($datos['datos'][0]->fp):
                                            case 1: ?>
                                                <option selected value="1">Transferencia bancaria</option>
                                                <option value="2">Efectivo</option>
                                                <option value="3">Cheque</option>
                                                <option value="4">Crédito</option>
                                                <?php break; ?>
                                            <?php
                                            case 2: ?>
                                                <option value="1">Transferencia bancaria</option>
                                                <option selected value="2">Efectivo</option>
                                                <option value="3">Cheque</option>
                                                <option value="4">Crédito</option>
                                                <?php break; ?>
                                            <?php
                                            case 3: ?>
                                                <option value="1">Transferencia bancaria</option>
                                                <option value="2">Efectivo</option>
                                                <option selected value="3">Cheque</option>
                                                <option value="4">Crédito</option>
                                                <?php break; ?>
                                            <?php
                                            case 4: ?>
                                                <option value="1">Transferencia bancaria</option>
                                                <option value="2">Efectivo</option>
                                                <option value="3">Cheque</option>
                                                <option selected value="4">Crédito</option>
                                                <?php break; ?>
                                            <?php
                                            default: ?>
                                                <option value="1">Transferencia bancaria</option>
                                                <option value="2">Efectivo</option>
                                                <option value="3">Cheque</option>
                                                <option value="4">Crédito</option>
                                        <?php endswitch; ?>
                                    </select> <?php else : ?>
                                    <select class="form-control form-control-sm" disabled id="FacFormaPago" name="FacFormaPago">
                                        <?php switch ($datos['datos'][0]->fp):
                                                    case 1: ?>
                                                <option selected value="1">Transferencia bancaria</option>
                                                <option value="2">Efectivo</option>
                                                <option value="3">Cheque</option>
                                                <option value="4">Crédito</option>
                                                <?php break; ?>
                                            <?php
                                                    case 2: ?>
                                                <option value="1">Transferencia bancaria</option>
                                                <option selected value="2">Efectivo</option>
                                                <option value="3">Cheque</option>
                                                <option value="4">Crédito</option>
                                                <?php break; ?>
                                            <?php
                                                    case 3: ?>
                                                <option value="1">Transferencia bancaria</option>
                                                <option value="2">Efectivo</option>
                                                <option selected value="3">Cheque</option>
                                                <option value="4">Crédito</option>
                                                <?php break; ?>
                                            <?php
                                                    case 4: ?>
                                                <option value="1">Transferencia bancaria</option>
                                                <option value="2">Efectivo</option>
                                                <option value="3">Cheque</option>
                                                <option selected value="4">Crédito</option>
                                                <?php break; ?>
                                            <?php
                                                    default: ?>
                                                <option value="1">Transferencia bancaria</option>
                                                <option value="2">Efectivo</option>
                                                <option value="3">Cheque</option>
                                                <option value="4">Crédito</option>
                                        <?php endswitch; ?>
                                    </select> <?php endif; ?>
                            </div>
                            <div class="col-sm">
                                <label>Estado de factura</label>
                                <?php if ($datos['datos'][0]->estado != 3) : ?>
                                    <select class="form-control form-control-sm" id="FacEstado" name="FacEstado">
                                        <?php switch ($datos['datos'][0]->estado):
                                            case 1: ?>
                                                <option selected value="1">Pagada</option>
                                                <option value="0">Pendiente</option>
                                                <option value="2">Anulada</option>
                                                <option value="3">Completada</option>
                                                <?php break; ?>
                                            <?php
                                            case 2: ?>
                                                <option value="1">Pagada</option>
                                                <option value="0">Pendiente</option>
                                                <option selected value="2">Anulada</option>
                                                <option value="3">Completada</option>
                                                <?php break; ?>
                                            <?php
                                            case 0: ?>
                                                <option value="1">Pagada</option>
                                                <option selected value="0">Pendiente</option>
                                                <option value="2">Anulada</option>
                                                <option value="3">Completada</option>
                                                <?php break; ?>
                                            <?php
                                            case 3: ?>
                                                <option value="1">Pagada</option>
                                                <option value="0">Pendiente</option>
                                                <option value="2">Anulada</option>
                                                <option selected value="3">Completada</option>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </select> <?php else : ?>
                                    <select class="form-control form-control-sm" disabled id="FacEstado" name="FacEstado">
                                        <?php switch ($datos['datos'][0]->estado):
                                                    case 1: ?>
                                                <option selected value="1">Pagada</option>
                                                <option value="0">Pendiente</option>
                                                <option value="2">Anulada</option>
                                                <option value="3">Completada</option>
                                                <?php break; ?>
                                            <?php
                                                    case 2: ?>
                                                <option value="1">Pagada</option>
                                                <option value="0">Pendiente</option>
                                                <option selected value="2">Anulada</option>
                                                <option value="3">Completada</option>
                                                <?php break; ?>
                                            <?php
                                                    case 0: ?>
                                                <option value="1">Pagada</option>
                                                <option selected value="0">Pendiente</option>
                                                <option value="2">Anulada</option>
                                                <option value="3">Completada</option>
                                                <?php break; ?>
                                            <?php
                                                    case 3: ?>
                                                <option value="1">Pagada</option>
                                                <option value="0">Pendiente</option>
                                                <option value="2">Anulada</option>
                                                <option selected value="3">Completada</option>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </select> <?php endif; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-5">
                                <label class="control-label">Producto / Servicio</label>
                                <input class="form-control form-control-sm" type="text" id="ProdNombre" placeholder="Escriba el nombre del producto o servicio a facturar...">
                            </div>
                            <div class="col-sm-1">
                                <label class="control-label">Cantidad</label>
                                <input class="form-control form-control-sm" type="number" min="1" id="cantidad">
                            </div>
                            <div class="col-sm">
                                <label class="control-label">Precio</label>
                                <input class="form-control form-control-sm" type="number" id="ProdPrecioVenta" placeholder="Escriba el precio de venta">
                            </div>
                            <div class="col-sm">
                                <label class="control-label">Dto %</label>
                                <input class="form-control form-control-sm" type="number" id="Dto" placeholder="Escriba el descuento en %">
                            </div>
                            <div class="col-sm">
                                <label class="control-label">RE %</label>
                                <input class="form-control form-control-sm" type="number" id="RE" placeholder="Retenciones">
                            </div>
                            <div class="col-sm">
                                <label class="control-label"> IVA</label>
                                <select class="form-control form-control-sm iva" id="iva">
                                    <option value='19'>19%</option>
                                    <option value='5'>5%</option>
                                    <option value='0'>0%</option>
                                </select>
                            </div>
                            <div class="col-sm">
                                <?php if ($datos['datos'][0]->estado != 1 && $datos['datos'][0]->estado != 3) : ?>
                                    <a class="btn btn-sm btn-success text-light" style="float:right" onclick="agregaritem();" role="button"><i class="fas fa-plus"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="center"></th>
                                        <th>Articulo</th>
                                        <th class="right">Cantidad</th>
                                        <th class="center">Precio</th>
                                        <th>Descuento</th>
                                        <th>Neto</th>
                                        <th>Retenciones</th>
                                        <th>IVA</th>
                                        <th class="right">Total</th>
                                        <th class="right">Quitar</th>
                                    </tr>
                                </thead>
                                <tbody id="TableBody">
                                    <?php $total = 0 ?>
                                    <?php foreach ($datos['datos'][1] as $key => $value) : ?>
                                        <tr id="<?php echo $datos['datos'][1][$key]->No_linea ?>">
                                            <td><input hidden class='form-control input-sm numero_item' type='text' name='numero_item[]' readonly value='<?php echo $datos['datos'][1][$key]->No_linea ?>' required></td>
                                            <td><input class='form-control form-control-sm ProdNombre' type='text' name='ProdNombre[]' value='<?php echo $datos['datos'][1][$key]->articulo ?>' readonly='' required='' title='<?php echo $datos['datos'][1][$key]->articulo ?>'></td>
                                            <td><input type="number" step="any" class='form-control form-control-sm cantidad' name='cantidad[]' value='<?php echo $datos['datos'][1][$key]->cantidad ?>' readonly='' required=''></td>
                                            <td><input type="number" step="any" class='form-control form-control-sm ProdPrecioVenta' name='ProdPrecioVenta[]' value='<?php echo round($datos['datos'][1][$key]->precio, 2) ?>' readonly='' required=''></td>
                                            <td><input type="number" step="any" class='form-control form-control-sm Dto' name='dto[]' value='<?php echo round($datos['datos'][1][$key]->dto, 2) ?>' readonly='' required=''></td>
                                            <td><input type="number" step="any" class='form-control form-control-sm subtotal' name='subtotal[]' value='<?php echo round($datos['datos'][1][$key]->neto, 2) ?>' readonly='' required=''></td>
                                            <td><input type="number" step="any" class='form-control form-control-sm RE' name='RE[]' value='<?php echo round($datos['datos'][1][$key]->retencion, 2) ?>' readonly='' required=''></td>
                                            <td><input type="number" step="any" class='form-control form-control-sm iva' name='iva[]' value='<?php echo round($datos['datos'][1][$key]->iva, 2) ?>' readonly='' required=''></td>
                                            <td><input type="number" step="any" class='form-control form-control-sm total' name='total[]' value='<?php echo round($datos['datos'][1][$key]->total, 2) ?>' readonly='' required=''></td>
                                            <?php if ($datos['datos'][0]->estado != 1 && $datos['datos'][0]->estado != 3) : ?>
                                                <td>
                                                    <div class="btn-group"><button type="button" title="Editar linea" class="btn btn-warning btn-sm edit"><i class='fas fa-edit log'></i></button><button class='btn btn-danger btn-sm del' type='button' title='Delete' onclick='deleteRow(<?php echo $datos["datos"][1][$key]->No_linea ?>, <?php echo round($datos["datos"][1][$key]->total, 2) ?> );'><i class='fas fa-trash'></i></button></div>
                                                </td>
                                            <?php else : ?>
                                                <td>No disponible</td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php $total = $total +  $datos["datos"][1][$key]->total;
                                    endforeach; ?>
                                </tbody>
                            </table>
                            <div class="form-group text-right">
                                <div class="col">
                                    <label class="control-label"><span class="badge badge-primary">Total:</span></label>
                                    <input id="sumViewTotal" class="form-control " style="border:none;outline: none;cursor:none; font-size: 25px;" type="" value="" readonly />
                                    <input type="hidden" id="sumAll" type="" value="<?php echo $total ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Observaciones</label>
                                <textarea class="form-control" name="FacObservacion"><?php echo $datos['datos'][0]->observaciones ?></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?php if ($datos['datos'][0]->estado != 3) : ?>
                                <button type="submit" id="btnsaveinvprov" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="recibos" role="tabpanel" aria-labelledby="pills-profile-tab">
            <br>
            <a id="btn_nuevo_recibo" class="btn btn-success btn-sm " data-toggle="modal" data-target="#addout"><i class="fa fa-plus" style="color:white"></i>&nbsp; <strong style="color:white">Nuevo</strong></a>
            <br><br><br>
            <?php $total = 0 ?>
            <?php foreach ($datos['recibo'] as $key => $value) {
                $total = $total + $value->importe;
            } ?>
            <div class="table-responsive">
                <table class="table table-bordered border-primary table-hover" id="Recibos" style="width: 100%">
                    <thead>
                        <th>Número</th>
                        <th>Proveedor</th>
                        <th>F. emitido</th>
                        <th>Divisa</th>
                        <th>Importe</th>
                        <th>FP</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>

                </table>
            </div>
            <div id="restante">
                <br><textarea class="form-control form-control-sm" id="rest"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="addout" tabindex="-1" role="dialog" aria-labelledby="Modalprov" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Modalprov">Nuevo egreso</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body">
                <form id="newout" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-sm">
                            <label>Proveedor</label>
                            <input readonly class="form-control form-control-sm ui-autocomplete-input" id="prov" name="prov" placeholder="Añade proveedor por nombre" autocomplete="off" value="<?php echo $datos['datos'][0]->nombre ?>">
                            <input type="hidden" id="codprov" name="codprov" value="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm">
                            <label>Factura asociada </label>
                            <input type="number" class="form-control form-control-sm" id="factura_asociada" name="factura_asociada" readonly value="<?php echo $datos['datos'][0]->numero ?>">
                            <input type="hidden" id="idf" name="idf" value="">
                            <input type="hidden" id="tot" name="tot" value="">
                            <input type="hidden" id="outtot" name="outtot" value="">
                            <input type="hidden" id="remain" name="remain" value="">
                            <input type="hidden" id="state" name="state" value="<?php echo $datos['datos'][0]->estado ?>">
                        </div>
                        <div class="col-sm">
                            <label>Importe </label>
                            <input type="text" required class="form-control form-control-sm" id="importe" name="importe">
                        </div>
                        <div class="col-sm">
                            <label>Fecha emisión </label>
                            <input type="date" class="form-control form-control-sm" id="fecha_emitido" name="fecha_emitido">
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" id="divisa" name="divisa" value="<?php echo $datos['proveedor']->divisa ?>">
                        <div class="col-sm">
                            <label>FP</label>
                            <select class="form-control form-control-sm" id="fp_recibo" name="fp_recibo">
                                <option value="1">Efectivo</option>
                                <option value="2">Cheque</option>
                                <option value="3">Transferencia bancaria</option>
                                <option value="4">Crédito</option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label>Vencimiento</label>
                            <input type="date" class="form-control form-control-sm" id="vencimiento" name="vencimiento">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <label>Pagado</label>
                            <select class="form-control form-control-sm" id="pagado" name="pagado">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label>Notificado</label>
                            <select class="form-control form-control-sm" id="notificado" name="notificado">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label>Estado</label>
                            <select class="form-control form-control-sm" id="estado_recibo" name="estado_recibo">
                                <option value="0">Emitido</option>
                                <option value="1">Pagado</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <label>Concepto</label>
                            <textarea required class="form-control form-control-sm" name="concepto" id="concepto"></textarea>
                        </div>
                    </div>

            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btnaddout" class="btn btn-sm btn-primary btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button> </div>
            </form>
        </div>
    </div>
</div>
</div>
<!--Aca termina-->
<br>
</div>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>