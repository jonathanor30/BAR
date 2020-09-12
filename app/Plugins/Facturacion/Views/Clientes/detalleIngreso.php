<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Clientes/DetalleIngreso.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-6">
            <div class="btn-group">
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/Ingresos" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-lg-inline-block">Ingresos</span>
                </a>
            </div>
        </div>
    </div>
    <br>
    <div class="card card-primary border-primary">
        <div class="card-header bg-primary  mb-3">
            <h5 class="card-title" style="color:white">Ingreso No <?php echo $datos['last'][0]->numero ?></h5>
        </div>
        <div class="card-body">
            <form id="editing" autocomplete="off">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Número</label>
                        <input class="form-control form-control-sm" readonly type="number" id="number" name="numero" value="<?php echo $datos['last'][0]->numero ?>">
                        <input hidden id="id_ingreso" name="id_ingreso" value="<?php echo $datos['last'][0]->id_ingreso ?>">
                    </div>
                    <div class="col-sm-2">
                        <label>Factura asociada</label>
                        <?php if ($datos['last'][0]->idfactura != null && $datos['last'][0]->idfactura != 0) { ?>
                            <a href="<?php echo RUTA_URL ?>/Facturacion/page/detalleFactura/<?php echo $datos['last'][0]->idfactura ?>" class="form-control form-control-sm" readonly type="number" id="id_factura"><?php echo $datos['invoice'][0]->numero ?></a>
                            <input hidden type="number" id="idfactura" name="idfactura" value="<?php echo $datos['last'][0]->idfactura ?>">
                        <?php } else { ?>
                            <input class="form-control form-control-sm" type="number" id="idfactura" name="idfactura">
                        <?php } ?>
                    </div>
                    <div class="col-sm-6">
                        <label>Cliente</label>
                        <?php if ($datos['last'][0]->cliente != null && $datos['last'][0]->cliente != "") { ?>
                            <input onclick="location.href='<?php echo RUTA_URL ?>/Facturacion/page/detailClient/<?php echo $datos['last'][0]->id_cliente ?>'" class="form-control form-control-sm" readonly type="text" name="cliente" value="<?php echo $datos['last'][0]->cliente ?>">
                        <?php } else { ?>
                            <input readonly class="form-control form-control-sm" readonly type="text" id="cliente" name="cliente" value="<?php echo $datos['last'][0]->cliente ?>">
                        <?php } ?>
                        <input hidden type="number" id="id_cliente" name="id_cliente" value="<?php echo $datos['last'][0]->id_cliente ?>">

                    </div>
                    <div class="col-sm-2">
                        <label>Emitido</label>
                        <input class="form-control form-control-sm" readonly type="date" id="emitido" name="date_added" value="<?php echo $datos['last'][0]->date_added ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <label>Divisa</label>
                        <select class="form-control form-control-sm" id="divisa" name="divisa">
                            <?php foreach ($datos['divisas'] as $key => $value) : ?>
                                <?php if ($value->coddivisa ==  $datos['last'][0]->divisa) : ?>
                                    <option selected value="<?php echo $value->coddivisa ?>"><?php echo $value->descripcion ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $value->coddivisa ?>"><?php echo $value->descripcion ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label>Importe</label>
                        <input class="form-control form-control-sm border-primary" type="number" id="importe" name="importe" value="<?php echo $datos['last'][0]->importe ?>">
                    </div>
                    <div class="col-sm">
                        <label>Forma de pago</label>
                        <select class="form-control form-control-sm" id="fp" name="fp">
                            <?php switch ($datos['last'][0]->fp):
                                case 1: ?>
                                    <option selected value="1">Contado</option>
                                    <option value="2">Crédito</option>

                                    <?php break; ?>
                                <?php
                                case 2: ?>
                                    <option value="1">Contado</option>
                                    <option selected value="2">Crédito</option>
                                    <?php break; ?>
                            <?php endswitch; ?>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label>Estado</label>
                        <select class="form-control form-control-sm" name="estado_ingreso" id="estado">
                            <?php switch ($datos['last'][0]->estado_ingreso):
                                case 0: ?>
                                    <option selected value="0">Emitido</option>
                                    <option value="1">Pagado</option>

                                    <?php break; ?>
                                <?php
                                case 1: ?>
                                    <option value="0">Emitido</option>
                                    <option selected value="1">Pagado</option>
                                    <?php break; ?>
                            <?php endswitch; ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                    <textarea class="form-control form-control-sm" id="concepto" name="concepto" placeholder="Observaciones..."><?php echo $datos['last'][0]->concepto ?></textarea>
                    </div>
                    <div class="col-sm">
                        <textarea class="form-control form-control-sm" id="observaciones" name="observaciones" placeholder="Observaciones..."><?php echo $datos['last'][0]->observaciones ?></textarea>
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <button type="submit" id="btneditin" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>
        </div>
        </form>
    </div>

</div>

<?php require RUTA_APP . '/Views/inc/footer.php'; ?>