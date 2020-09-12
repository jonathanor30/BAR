<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Proveedores/newinvoiceprov.js"></script>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-6">
            <div class="btn-group">
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/InvoicesProv" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-lg-inline-block">Facturas Proveedor</span>
                </a>
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/FacturaProveedor" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <h3>Factura de compra</h3>
        </div>
        <div class="card-body">
            <h4> Datos del proveedor</h4>
            <br>
            <form class="form-horizontal" role="form" id="datos_factura" method="POST" autocomplete="on">
                <div class="form-group row">
                    <label for="mail" class="col-md-1 control-label">NIT/CC</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" id="ClieNit" name="ClieNit" required="">
                        <input hidden type="number" id="codproveedor" name="codproveedor" value="">
                    </div>
                    <label for="mail" class="col-md-1 control-label">Nombre</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" required="">
                    </div>
                    <label for="tel1" class="col-md-1 control-label">Teléfono</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control form-control-sm" id="ClieTelefono" name="ClieTelefono" readonly="" required="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre_cliente" class="col-md-1 control-label">Email</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm ui-autocomplete-input" id="ClieEmail" name="ClieEmail" required="" autocomplete="off" readonly="" required="">
                    </div>
                    <label for="mail" class="col-md-1 control-label">Dirección</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" id="ClieDireccion" name="ClieDireccion" placeholder="" readonly="" required="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Referencia</label>
                        <input class="form-control form-control-sm" id="ref" placeholder="Referencia..." type="text" value="" name="FacRef">
                    </div>
                    <div class="col-sm">
                        <label>Fecha</label>
                        <input class="form-control form-control-sm" id="fecha" placeholder="" type="date" value="<?php echo date("Y-m-d"); ?>" name="FacFecha" required="">
                    </div>
                    <div class="col-sm">
                        <label>FP</label>
                        <select class="form-control form-control-sm" id="FacFormaPago" name="FacFormaPago">
                            <option value="1">Transferencia bancaria</option>
                            <option value="2">Efectivo</option>
                            <option value="3">Cheque</option>
                            <option value="4">Crédito</option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label>Estado de factura</label>
                        <select class="form-control form-control-sm" required id="FacEstado" name="FacEstado">
                            <option selected disabled value="">Seleccione estado</option>
                            <option value="1">Pagada</option>
                            <option value="0">Pendiente</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label class="control-label">Producto / Servicio</label>
                        <textarea class="form-control form-control-sm" type="text" id="ProdNombre" placeholder="Escriba el nombre del producto o servicio a facturar..."></textarea>
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
                        <a class="btn btn-sm btn-success text-light" style="float:right" onclick="agregaritem();" role="button"><i class="fas fa-plus"></i></a>
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
                        </tbody>
                    </table>
                    <div class="form-group text-right">
                        <div class="col">
                            <label class="control-label"><span class="badge badge-primary">Total:</span></label>
                            <input id="sumViewTotal" class="form-control " style="border:none;outline: none;cursor:none; font-size: 25px;" type="" value="" readonly />
                            <input id="sumAll" type="hidden" value="" /> </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Observaciones</label>
                        <textarea class="form-control" name="FacObservacion"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="btnsaveinvprov" class="btn btn-sm btn-primary btn-sm" style="float:right"><i class="fas fa-save"></i>&nbsp;Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require RUTA_APP . '/Views/inc/footer.php'; ?>