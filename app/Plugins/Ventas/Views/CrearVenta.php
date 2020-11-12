<?php require RUTA_APP . '/Views/inc/header.php'; ?>

<div class="container-fluid">
    <br>
    <div class="card">
        <div class="card-header">
            <center>
                <h3>Registrar Venta</h3>
            </center>
        </div>
        <div class="card-body">
            <br>
            <form class="form-horizontal" role="form" id="datos_factura" method="POST" autocomplete="on">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label>Cliente</label>
                        <select class="form-control form-control-sm" name="IdCliente" id="IdCliente">
                            <option value=" " disable>--Selecione un Cliente--</option>
                        </select>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-sm">
                        <label>Producto</label>
                        <!--<select class="form-control form-control-sm" name="IdTipoProducto" id="IdTipoProducto">
                            <option value=" " disable>--Selecione un Producto--</option>
                        </select>-->
                        <input class="form-control form-control-sm" type="text" id="BuscaProducto" placeholder="Nombre de producto...">
                        <input hidden id="IdTipoProducto">
                        <input hidden type="text" id="nombrep" value="">
                        <input hidden type="text" id="marcap" value="">
                    </div>
                    <div class="col-sm">
                        <label>Iva</label>
                        <input class="form-control form-control-sm iva" type="text" id="iva" placeholder="...%">
                    </div>
                    <div class="col-sm">
                        <label>Precio</label>
                        <input type="text" class="form-control form-control-sm" id="precio" name="precio" readonly="" required="">
                    </div>
                    <div class="col-sm">
                        <label>Cantidad</label>
                        <input class="form-control form-control-sm" type="number" min="1" id="Cantidad">
                    </div>
                    <div class="col-sm-1">
                        <a class="btn btn-sm btn-success text-light" style="float:right; position: absolute;bottom: 2px;" onclick="validaritem();" role="button"><i class="fas fa-plus"></i></a>
                    </div>
                </div>

                <hr>


                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center"></th>
                                <th>identificador</th>
                                <th>Nombre</th>
                                <th class="right">Marca</th>
                                <th class="center">Cantidad</th>
                                <th>Precio</th>
                                <th>Neto</th>
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

    <script src="<?php echo RUTA_URL; ?>/Ventas/files?js=recursos/js/crearventa.js"></script>

    <?php require RUTA_APP . '/Views/inc/footer.php'; ?>