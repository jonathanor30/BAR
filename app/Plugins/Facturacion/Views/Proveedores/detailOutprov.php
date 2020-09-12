<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Proveedores/detailOuts.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-6">
            <div class="btn-group">
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/OutProv" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-lg-inline-block">Egresos Proveedor</span>
                </a>


            </div>
        </div>
    </div>
    <br>
    <div class="card card-primary border-primary">
        <div class="card-header bg-primary  mb-3">
            <h5 class="card-title" style="color:white">Egreso No <?php echo $datos['last'][0]->numero ?></h5>
        </div>
        <div class="card-body">
            <form id="editrec" autocomplete="off">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Número</label>
                        <input class="form-control form-control-sm" readonly type="number" id="number" name="number" value="<?php echo $datos['last'][0]->numero ?>">
                        <input hidden id="recibo" name="recibo" value="<?php echo $datos['last'][0]->id_recibo ?>">
                    </div>
                    <div class="col-sm-2">
                        <label>Factura asociada</label>
                        <?php if ($datos['last'][0]->idfactura != null && $datos['last'][0]->idfactura != 0) { ?>
                            <input onclick="location.href='<?php echo RUTA_URL ?>/Facturacion/page/ProvFactDetail/<?php echo $datos['last'][0]->idfactura ?>'" class="form-control form-control-sm" readonly type="number" id="id_factura" name="id_factura" value="<?php echo ($datos['last'][0]->idfactura) ??  '' ?>">
                            <input type="number" hidden name="total" id="total" value="<?php echo ($datos['invoice'][0]->total) ?? '' ?>">
                        <?php } else { ?>
                            <input class="form-control form-control-sm" type="number" id="id_factura" name="id_factura">
                            <input type="number" hidden name="total" id="total" value="">
                        <?php } ?>
                    </div>
                    <div class="col-sm-6">
                        <label>Proveedor</label>
                        <?php if ($datos['last'][0]->proveedor != null && $datos['last'][0]->proveedor != "") { ?>
                            <input onclick="location.href='<?php echo RUTA_URL ?>/Facturacion/page/Provdetail/<?php echo $datos['last'][0]->codproveedor ?>'" class="form-control form-control-sm" readonly type="text" id="proveedor" name="proveedor" value="<?php echo $datos['last'][0]->proveedor ?>">
                        <?php } else { ?>
                            <input readonly class="form-control form-control-sm" readonly type="text" id="proveedor" name="proveedor" value="<?php echo $datos['last'][0]->proveedor ?>">
                        <?php } ?>
                        <input hidden type="number" id="codprov" name="codprov" value="<?php echo $datos['last'][0]->codproveedor ?>">

                    </div>
                    <div class="col-sm-2">
                        <label>Emitido</label>
                        <input class="form-control form-control-sm" readonly type="date" id="emitido" name="emitido" value="<?php echo $datos['last'][0]->emitido ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <label>Divisa</label>
                        <?php if ($datos['last'][0]->estado_recibo != 1) : ?>
                            <select class="form-control form-control-sm" id="divisa" name="divisa">
                                <?php foreach ($datos['divisas'] as $key => $value) : ?>
                                    <?php if ($value->coddivisa ==  $datos['last'][0]->divisa) : ?>
                                        <option selected value="<?php echo $value->coddivisa ?>"><?php echo $value->descripcion ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $value->coddivisa ?>"><?php echo $value->descripcion ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <select class="form-control form-control-sm" disabled id="divisa" name="divisa">
                                <?php foreach ($datos['divisas'] as $key => $value) : ?>
                                    <?php if ($value->coddivisa ==  $datos['last'][0]->divisa) : ?>
                                        <option selected value="<?php echo $value->coddivisa ?>"><?php echo $value->descripcion ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $value->coddivisa ?>"><?php echo $value->descripcion ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>

                    </div>
                    <div class="col-sm">
                        <label>Importe</label>
                        <?php if ($datos['last'][0]->estado_recibo != 1) : ?>
                            <input class="form-control form-control-sm border-primary" type="number" id="importe" name="importe" value="<?php echo $datos['last'][0]->importe ?>">
                        <?php else : ?>
                            <input class="form-control form-control-sm border-primary" readonly type="number" id="importe" name="importe" value="<?php echo $datos['last'][0]->importe ?>">
                        <?php endif; ?>
                    </div>
                    <div class="col-sm">
                        <label>Forma de pago</label>
                        <?php if ($datos['last'][0]->estado_recibo != 1) : ?>
                            <select class="form-control form-control-sm" id="fp" name="fp">
                                <?php switch ($datos['last'][0]->fp):
                                    case 1: ?>
                                        <option selected value="1">Efectivo</option>
                                        <option value="2">Cheque</option>
                                        <option value="3">Transferencia bancaria</option>
                                        <option value="4">Crédito</option>
                                        <?php break; ?>
                                    <?php
                                    case 2: ?>
                                        <option value="1">Efectivo</option>
                                        <option selected value="2">Cheque</option>
                                        <option value="3">Transferencia bancaria</option>
                                        <option value="4">Crédito</option>
                                        <?php break; ?>
                                    <?php
                                    case 3: ?>
                                        <option value="1">Efectivo</option>
                                        <option value="2">Cheque</option>
                                        <option selected value="3">Transferencia bancaria</option>
                                        <option value="4">Crédito</option>
                                        <?php break; ?>
                                    <?php
                                    case 4: ?>
                                        <option value="1">Efectivo</option>
                                        <option value="2">Cheque</option>
                                        <option value="3">Transferencia bancaria</option>
                                        <option selected value="4">Crédito</option>
                                        <?php break; ?>
                                    <?php
                                    case 0: ?>
                                        <option value="1">Efectivo</option>
                                        <option value="2">Cheque</option>
                                        <option value="3">Transferencia bancaria</option>
                                        <option value="4">Crédito</option>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </select> <?php else : ?>
                            <select class="form-control form-control-sm" disabled id="fp" name="fp">
                                <?php switch ($datos['last'][0]->fp):
                                            case 1: ?>
                                        <option selected value="1">Efectivo</option>
                                        <option value="2">Cheque</option>
                                        <option value="3">Transferencia bancaria</option>
                                        <option value="4">Crédito</option>
                                        <?php break; ?>
                                    <?php
                                            case 2: ?>
                                        <option value="1">Efectivo</option>
                                        <option selected value="2">Cheque</option>
                                        <option value="3">Transferencia bancaria</option>
                                        <option value="4">Crédito</option>
                                        <?php break; ?>
                                    <?php
                                            case 3: ?>
                                        <option value="1">Efectivo</option>
                                        <option value="2">Cheque</option>
                                        <option selected value="3">Transferencia bancaria</option>
                                        <option value="4">Crédito</option>
                                        <?php break; ?>
                                    <?php
                                            case 4: ?>
                                        <option value="1">Efectivo</option>
                                        <option value="2">Cheque</option>
                                        <option value="3">Transferencia bancaria</option>
                                        <option selected value="4">Crédito</option>
                                        <?php break; ?>
                                    <?php
                                            case 0: ?>
                                        <option value="1">Efectivo</option>
                                        <option value="2">Cheque</option>
                                        <option value="3">Transferencia bancaria</option>
                                        <option value="4">Crédito</option>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </select> <?php endif; ?>

                    </div>
                    <div class="col-sm">
                        <label>Vencimiento</label>
                        <?php if ($datos['last'][0]->estado_recibo != 1) : ?>
                            <input class="form-control form-control-sm" type="date" id="vence" name="vence" value="<?php echo $datos['last'][0]->vencimiento ?>">
                        <?php else : ?>
                            <input class="form-control form-control-sm" readonly type="date" id="vence" name="vence" value="<?php echo $datos['last'][0]->vencimiento ?>">
                        <?php endif; ?>
                    </div>
                    <div class="col-sm">
                        <label>Pagado</label>
                        <?php if ($datos['last'][0]->estado_recibo != 1) : ?>
                            <select class="form-control form-control-sm" id="pagado" name="pagado">
                                <?php switch ($datos['last'][0]->pagado) {
                                    case 'Si': ?>
                                        <option selected value="Si">Sí</option>
                                        <option value="No">No</option>
                                        <?php break; ?>
                                    <?php
                                    case 'No': ?>
                                        <option value="Si">Sí</option>
                                        <option selected value="No">No</option>
                                        <?php break; ?>
                                    <?php
                                    default: ?>
                                        <option value="Si">Sí</option>
                                        <option value="No">No</option>
                                        <?php break; ?>
                                <?php } ?>
                            </select> <?php else : ?>
                            <select class="form-control form-control-sm" disabled id="pagado" name="pagado">
                                <?php switch ($datos['last'][0]->pagado) {
                                            case 'Si': ?>
                                        <option selected value="Si">Sí</option>
                                        <option value="No">No</option>
                                        <?php break; ?>
                                    <?php
                                            case 'No': ?>
                                        <option value="Si">Sí</option>
                                        <option selected value="No">No</option>
                                        <?php break; ?>
                                    <?php
                                            default: ?>
                                        <option value="Si">Sí</option>
                                        <option value="No">No</option>
                                        <?php break; ?>
                                <?php } ?>
                            </select> <?php endif; ?>

                    </div>
                    <div class="col-sm">
                        <label>Notificado</label>
                        <?php if ($datos['last'][0]->estado_recibo != 1) : ?>
                            <select class="form-control form-control-sm" id="notificado" name="notificado">
                                <?php switch ($datos['last'][0]->notificado) {
                                    case 'Si': ?>
                                        <option selected value="Si">Sí</option>
                                        <option value="No">No</option>
                                        <?php break; ?>
                                    <?php
                                    case 'No': ?>
                                        <option value="Si">Sí</option>
                                        <option selected value="No">No</option>
                                        <?php break; ?>
                                    <?php
                                    default: ?>
                                        <option value="Si">Sí</option>
                                        <option value="No">No</option>
                                        <?php break; ?>

                                <?php } ?>
                            </select> <?php else : ?>
                            <select class="form-control form-control-sm" disabled id="notificado" name="notificado">
                                <?php switch ($datos['last'][0]->notificado) {
                                            case 'Si': ?>
                                        <option selected value="Si">Sí</option>
                                        <option value="No">No</option>
                                        <?php break; ?>
                                    <?php
                                            case 'No': ?>
                                        <option value="Si">Sí</option>
                                        <option selected value="No">No</option>
                                        <?php break; ?>
                                    <?php
                                            default: ?>
                                        <option value="Si">Sí</option>
                                        <option value="No">No</option>
                                        <?php break; ?>

                                <?php } ?>
                            </select> <?php endif; ?>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <?php if ($datos['last'][0]->estado_recibo != 1) : ?>
                            <textarea class="form-control form-control-sm" id="observaciones" name="observaciones" placeholder="Observaciones..."><?php echo $datos['last'][0]->observaciones ?></textarea>
                        <?php else : ?>
                            <textarea class="form-control form-control-sm" id="observaciones" readonly name="observaciones" placeholder="Observaciones..."><?php echo $datos['last'][0]->observaciones ?></textarea>
                        <?php endif; ?>
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <?php if ($datos['last'][0]->idfactura == null || $datos['last'][0]->idfactura == 0) { ?>
                <input type="checkbox" id="geninv" name="geninv" value="true">
                <label>Generar factura?</label>
            <?php } ?>
            <?php if ($datos['last'][0]->estado_recibo != 1) : ?>
                <button type="submit" id="btneditout" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>
            <?php endif; ?>
        </div>
        </form>
    </div>

</div>

<?php require RUTA_APP . '/Views/inc/footer.php'; ?>