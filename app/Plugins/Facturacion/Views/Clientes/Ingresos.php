<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Clientes/Ingresos.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
            <div class="btn-group">
                <select class="btn btn-secondary btn-sm" onchange="cambiar()" id="est" name="est">
                    <option value="" selected>Filtrar</option>
                    <option value="0">Emitido</option>
                    <option value="1">Pagado</option>
                </select>
                &nbsp;
                <!--
                <a id="btn_new_in" class="btn btn-success btn-sm " data-toggle="modal" data-target="#addin"><i class="fa fa-plus" style="color:white"></i>&nbsp; <strong style="color:white">Nuevo</strong></a>
-->
            </div>
        </div>


    </div>
    <br>
    <div class="table-responsive">
        <table class="table bordered" id="ingresos" style="width: 100%">
            <thead>
                <th style="width: 10%">Número</th>
                <th style="width: 10%">Factura asociada</th>
                <th style="width: 20%">Cliente</th>
                <th>Divisa</th>
                <th>Importe</th>
                <th>Forma de pago</th>
                <th>Estado</th>
                <th>Acciones</th>
            </thead>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal" id="addin" tabindex="-1" role="dialog" aria-labelledby="Modalprov" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Modalprov">Nuevo Ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newin" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-sm">
                            <label>Cliente</label>
                            <input class="form-control form-control-sm" readonly id="prov" name="prov" placeholder="Sólo se crea asociando una factura existente.">
                            <input type="text" hidden id="codprov" name="codprov" value="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm">
                            <label>Factura asociada</label>
                            <input class="form-control form-control-sm"  id="invoice" name="invoice" placeholder="Factura asociada por numero...">
                            <input type="number" hidden id="idf" name="idf" value="">
                            <input type="number" step="any" hidden id="tot_recibos" name="tot_recibos" value="">
                            <input type="number" step="any" hidden id="fp_recibo" name="fp_recibo" value="1">
                            <input type="text"  hidden id="concepto" name="concepto" value="null">

                        </div>
                        <div class="col-sm">
                            <label>Importe</label>
                            <input type="number" step="any" class="form-control form-control-sm" id="importe" name="importe" placeholder="Importe...">
                        </div>
                        
                    </div>
                    <br>
                   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btnaddin" class="btn btn-sm btn-primary btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button>

            </div>
            </form>
        </div>
    </div>
</div>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>