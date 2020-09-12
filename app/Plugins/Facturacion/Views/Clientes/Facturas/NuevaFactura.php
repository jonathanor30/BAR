<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Clientes/NuevaFactura.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-6">
            <div class="btn-group">
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/FacturasCliente" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-lg-inline-block">Facturas clientes</span>
                </a>
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/nuevaFactura" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <h3>Factura de venta</h3>
        </div>
        <div class="card-body">
            <h4> Datos del cliente</h4>
            <br>
            <form class="form-horizontal" role="form" id="datos_factura" method="POST" autocomplete="on">
                <div class="form-group row">
                    <label class="col-md-1 control-label">Nombre</label>
                    <div class="col-sm">
                        <input type="text" class="form-control form-control-sm" id="nombre" name="nombrecliente" required="">
                    </div>
                    <label for="mail" class="col-md-1 control-label">NIT/CC</label>
                    <div class="col-sm">
                        <input type="text" class="form-control form-control-sm" id="cifnif" name="cifnif"  required="">
                        <input type="hidden" id="id_cliente" name="id_cliente" value="">
                    </div>
                    <label for="tel1" class="col-md-1 control-label">Teléfono</label>
                    <div class="col-sm">
                        <input type="text" class="form-control form-control-sm" id="telefono" name="telefono"   required="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre_cliente" class="col-md-1 control-label">Email</label>
                    <div class="col-sm">
                        <input type="text" class="form-control form-control-sm ui-autocomplete-input" id="email"  required="" autocomplete="off" required="">
                    </div>
                    <label for="mail" class="col-md-1 control-label">Dirección</label>
                    <div class="col-sm">
                        <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" placeholder=""  required="">
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
                        <input class="form-control form-control-sm" id="ref" placeholder="" type="text" placeholder="Referencia..." name="referenciaInv">
                    </div>
                    <div class="col-sm">
                        <label>Fecha</label>
                        <input class="form-control form-control-sm" id="fecha" placeholder="" type="date" value="<?php echo date("Y-m-d"); ?>" name="fecha" required="">
                    </div>
                    <div class="col-sm">
                        <label>Vencimiento</label>
                        <input class="form-control form-control-sm" id="venc" placeholder="" type="date" name="vencimiento" value="<?php echo date("Y-m-d"); ?>" required="">
                    </div>
                    <div class="col-sm">
                        <label>FP</label>
                        <select class="form-control form-control-sm" id="FacFormaPago" name="codpago">
                            <option value="1">Contado</option>
                            <option value="2">Crédito</option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label>Estado de factura</label>
                        <select class="form-control form-control-sm" required id="FacEstado" name="pagada">
                            <option selected disabled value="">Seleccione estado</option>
                            <option value="1">Pagada</option>
                            <option value="0">Pendiente</option>
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
                        <label class="control-label">Artículo / Servicio</label>
                        <textarea class="form-control form-control-sm" id="ProdNombre" placeholder="Escriba el nombre del producto o servicio a facturar..."></textarea>
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
                        <input max="100" class="form-control form-control-sm" type="number" id="Dto" placeholder="Escriba el descuento en %">
                    </div>
                    <div class="col-sm-auto">
                        <label class="control-label">Recargos %</label>
                        <input max="100" class="form-control form-control-sm" type="number" id="recargo" placeholder="Escriba el recargo en %">
                    </div>
                    <div class="col-sm-auto">
                        <label class="control-label">RE %</label>
                        <input min="0" max="20" class="form-control form-control-sm" step="any" type="number" id="RE" placeholder="Retenciones">
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
                                <th>Recargos</th>
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
                            <input type="hidden" id="sumAll" type="" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Observaciones</label>
                        <textarea class="form-control" name="observaciones"></textarea>
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