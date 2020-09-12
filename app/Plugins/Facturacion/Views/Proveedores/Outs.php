<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Proveedores/Egresos.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-1">
            <a id="btn_nuevo_proveedor" class="btn btn-success btn-sm " data-toggle="modal" data-target="#addout"><i class="fa fa-plus" style="color:white"></i>&nbsp; <strong style="color:white">Nuevo</strong></a>
        </div>
        <div class="col-sm-1">
            <select class="btn btn-secondary btn-sm" onchange="cambiar()" id="est" name="est">
                <option value="" selected>Filtrar</option>
                <option value="0">Emitido</option>
                <option value="1">Pagado</option>
            </select>
        </div>

    </div>
    <br><br>
    <br><br>
    <div class="table-responsive">
        <table class="table bordered" id="recibos" style="width: 100%">
            <thead>
                <th>Número</th>
                <th>Factura asociada</th>
                <th>Proveedor</th>
                <th>Emitido</th>
                <th>Divisa</th>
                <th>Importe</th>
                <th>Forma de pago</th>
                <th>Vencimiento</th>
                <th>Estado</th>
                <th>Acciones</th>
            </thead>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal" id="addout" tabindex="-1" role="dialog" aria-labelledby="Modalprov" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Modalprov">Nuevo recibo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newout" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-sm">
                            <label>Proveedor</label>
                            <input class="form-control form-control-sm" id="prov" name="prov" placeholder="Añade proveedor por nombre">
                            <input type="text" hidden id="idprov" name="idprov" value="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm">
                            <label>Factura asociada</label>
                            <input class="form-control form-control-sm" id="invoice" name="invoice" placeholder="Factura asociada por numero...">
                            <input type="number" hidden id="id_factura" name="id_factura" value="">
                            <input type="text" hidden id="total" name="total" value="">
                        </div>
                        <div class="col-sm">
                            <label>Importe</label>
                            <input type="number" class="form-control form-control-sm" id="importe" name="importe" placeholder="Importe...">
                        </div>
                        <div class="col-sm">
                            <label>Fecha de emitido</label>
                            <input type="date" class="form-control form-control-sm" id="emitido" name="emitido" value="<?php echo date('Y-m-d') ?>">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm">
                            <textarea class="form-control form-control-sm" id="obs" name="obs" placeholder="Concepto..." required=""></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btnaddout" class="btn btn-sm btn-primary btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button>

            </div>
            </form>
        </div>
    </div>
</div>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>