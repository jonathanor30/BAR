<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<div class="container-fluid">
    <br>
    <div class="card">
        <div class="card-header">
            <center><h3>Registrar Novedad</h3></center>
        </div>
        <div class="card-body">
            <br>
            <form class="form-horizontal" role="form" id="datos_factura" method="POST" autocomplete="on">
                <div class="row">
                    <div class="col-sm">
                        <label>Producto<b style="color:gray;">*</b></label>
                        <select class="form-control form-control-sm" name="IdTipoProducto" id="IdTipoProducto">
                            <option value=" " disable>--Selecione un Producto--</option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label>Fecha<b style="color:gray;">*</b></label>
                        <input class="form-control form-control-sm" id="fecha" placeholder="" type="date" value="<?php echo date("Y-m-d"); ?>" name="FacFecha" required="">
                    </div>
                    <div class="col-sm">
                        <label>Iva</label>
                        <input class="form-control form-control-sm iva" type="text"  id="iva" placeholder="...%">
                    </div>
                    <input hidden type="text" id="nombrep" name="nombrep" value="">
                    <input hidden type="text" id="marcap" name="marcap" value="">
                    <div class="col-sm">
                        <label>Precio</label>
                        <input type="text" class="form-control form-control-sm" id="precio" name="precio" readonly="" required="">
                    </div>
                    <div class="col-sm">
                        <label>Cantidad<b style="color:gray;">*</b></label>
                        <input class="form-control form-control-sm" type="number" min="1" id="Cantidad">
                    </div>
                    <div class="col-sm">
                        <label>Tipo de novedad<b style="color:gray;">*</b></label>
                        <select class="form-control form-control-sm" name="IdTipoProducto" id="IdTipoProducto">
                            <option value=" " disable>--Selecione un Producto--</option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <a class="btn btn-sm btn-success text-light" style="float:right; position: absolute;bottom: 2px;" onclick="agregaritem();" role="button"><i class="fas fa-plus"></i></a>
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

<script>

</script>
    <script src="<?php echo RUTA_URL; ?>/Novedades/files?js=recursos/js/Novedad.js"></script>

