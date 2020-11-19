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
    
       
            <div class="card">
                <div class="card-header">
                    <h3> Detalle De La venta #<?php echo $datos['datoventa']->IdVenta;?></h3>
                    <input hidden type="number" id="count_recibos" name="count_recibos" value="">
                </div>
                <div class="card-body">
                    <h4> Datos del proveedor</h4>
                    <br>
                    
                    
                        <div class="form-group row">
                        
                        <div class="col-sm">
                            <label>Nombre</label>       
                            <input type="text" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" readonly="" required="" value="<?php echo $datos['datoventa']->Nombre;?>">
                            </div>
                            <div class="col-sm">
                            <label>Numero de documento</label>       
                            <input type="text" class="form-control form-control-sm" id="ClieTelefono" name="ClieTelefono" readonly="" required="" value="<?php echo $datos['datoventa']->Numero_Documento;?>">
                            </div>
                        </div>
                        <hr>
                        <h4> Datos De La venta</h4>
                        <br>
                        <div class="row">
                            <div class="col-sm">
                            <label>Fecha</label>       
                                    <input class="form-control form-control-sm" readonly id="fecha" placeholder="" type="date" value="<?php echo $datos['datoventa']->fecha;?>" name="FacFecha" required="">
                              
                            </div>
                            <div class="col-sm">
                            <label>Hora</label>
                                    <input class="form-control form-control-sm" readonly id="ref" placeholder="" type="text" value="<?php echo $datos['datoventa']->hora; ?>" name="FacRef">
            
                            </div>                               
                        </div>
                        <hr>
                        <div class="table-responsive">
                <table class="table table-bordered border-primary table-hover" id="Recibos" style="width: 100%">
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
                        foreach($datos['venta'] as $key){?>
                        <tr>
                            <td><?php echo $key->NombreProducto;?></td>
                            <td><?php echo $key->Nombre;?></td>
                            <td><?php echo $key->PrecioSugerido;?></td>
                            <td><?php echo $key->cantidad;?></td>
                            <td><?php echo $key->iva;?></td>
                            <td><?php echo $key->total;?></td>
                        </tr> 
                    <?php } ?>
                        </thead>
                        </table>



                        </div>
                        <div class="table-responsive-sm">
     
                            <div class="form-group text-right">
                                <div class="col">
                                    <label class="control-label"><span class="badge badge-primary">Total:</span></label>
                                    <?php foreach ($datos['total'] as $key) {
                                     ?>
                                    <input id="sumViewTotal" class="form-control " style="border:none;outline: none;cursor:none; font-size: 25px;" type="" value="<?php echo "$".$key->suma;?>" readonly />
                                  <?php } ?>  <input type="hidden" id="sumAll" type="" value="" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Observaciones</label>
                                <textarea class="form-control" readonly name="FacObservacion"><?php echo $datos['datoventa']->observaciones; ?></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            
                            
                        </div>
                   
                </div>
            </div>
        
    
</div>




</div>
<!--Aca termina-->
<br>
</div>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>