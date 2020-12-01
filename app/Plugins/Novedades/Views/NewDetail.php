<?php require RUTA_APP . '/Views/inc/header.php' ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-6">
            <div class="btn-group">
                <a href="<?php echo RUTA_URL; ?>/Novedades/" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-lg-inline-block">Novedades</span>
                </a>
                <a href="<?php echo RUTA_URL; ?>/Novedades/NewDetail/<?php echo $datos['datosn']->IdNovedad ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <br>
    <!--Aca inicia  Navs-->


    <div class="card">
        <div class="card-header">
            <h3> Detalle De La Novedad #<?php  echo $datos['datosn']->IdNovedad ?></h3>
            <input hidden type="number" id="count_recibos" name="count_recibos" value="">
        </div>
        <div class="card-body">
            <h4> Datos de la Novedad</h4>
            <br>


            <div class="form-group row">

                <div class="col-sm-3">
                    <label>Tipo de la novedad</label>
                    <input type="text" class="form-control form-control-sm"  readonly="" required="" value="<?php echo $datos['datosn']->Nombre_Novedad ?>">
                </div>
              
        
                <div class="col-sm-3">
                    <label>Fecha</label>
                    <input class="form-control form-control-sm" readonly placeholder="" type="date" value="<?php echo $datos['datosn']->Fecha ?>">

                </div>
                <div class="col-sm-3">
                    <label>Hora</label>
                    <input class="form-control form-control-sm" readonly placeholder="" type="text" value="<?php echo $datos['datosn']->hora; ?>">

                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered border-primary table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-left">Producto</th>
                            <th class="text-left">Marca</th>
                            <th class="text-left">Precio</th>
                            <th class="text-left">cantidad</th>
                            <th class="text-left">iva</th>
                            <th class="text-left">total</th>
                        </tr>
                        <?php
                        foreach ($datos['datosd'] as $key) { ?>
                            <tr>
                                <td><?php echo $key->NombreProducto; ?></td>
                                <td><?php echo $key->Nombre; ?></td>
                                <td><?php echo $key->PrecioSugerido; ?></td>
                                <td><?php echo $key->cantidad; ?></td>
                                <td><?php echo $key->iva; ?></td>
                                <td><?php echo $key->total; ?></td>
                            </tr>
                        <?php } ?>
                    </thead>
                </table>



            </div>
            <div class="table-responsive-sm">

                <div class="form-group text-right">
                    <div class="col">
                        <label class="control-label"><span class="badge badge-primary">Total:</span></label>
                        
                        
                            <input class="form-control" id="suma" style="border:none;outline: none;cursor:none; font-size: 25px;" type="" value="" readonly />
                        <input id="total" type="hidden"  value="<?php  echo $datos['total']->total ?>" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Observaciones</label>
                    <textarea class="form-control" readonly ><?php  echo $datos['datosn']->Descripcion ?></textarea>
                </div>
            </div>
          

        </div>
    </div>


</div>




</div>
<!--Aca termina-->
<br>
</div>
<script src="<?php echo RUTA_URL; ?>/Novedades/files?js=recursos/js/Novedadd.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>