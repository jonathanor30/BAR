<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<br>
<div id="ResultadoAjax" class="container"></div>
<div class="container-fluid d-print-none">
   <div class="row">
      <div class="col-md-7">
         <div class="btn-group">
            <a class="btn btn-sm btn-outline-secondary" href="">
               <i class="fas fa-sync" aria-hidden="true"></i>
            </a>
            <a class="btn btn-sm btn-outline-secondary" href="">
               <i class="fas fa-bookmark" aria-hidden="true"></i>
            </a>
         </div>
         <div class="btn-group">
            <div class="dropdown">
               <select class="btn btn-secondary" id="filter" onchange="reloadTable();">
                  <option value="" selected="" data-icon="fas fa-filter">Filtrar</option>
                  <option value="1">Activos</option>
                  <option value="3">Inactivos</option>
               </select>
               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Nuevo</button>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="">
                     <i class="fas fa-cubes fa-fw" aria-hidden="true"></i> Products
                  </a>
                  <a class="dropdown-item" href="">
                     <i class="fas fa-code-branch fa-fw" aria-hidden="true"></i> Variants
                  </a>
                  <a class="dropdown-item" href="">
                     <i class="fas fa-tasks fa-fw" aria-hidden="true"></i> Stock
                  </a>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-5 text-right">
         <h1 class="h3 d-none d-md-inline-block">
            <?php echo $datos["titulo"] . " <i class='" . $datos["icon"] . "'></i>"; ?>
         </h1>
         <br class="d-md-none">
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="table-responsive">
      <table style="font-size: 12px;" id="Productos" class="table table-hover">
         <thead>
            <tr>
               <th class="text-left">Nombre</th>
               <th class="text-left">imagen</th>
               <th class="text-left">Código</th>
               <th class="text-left">Precio sugerido</th>
               <th class="text-left">Existencia</th>
               <th class="text-left">Estado</th>
               <th class="text-left">Acciones</th>
            </tr>
         </thead>
      </table>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Nuevo Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" action="" id="guardar_usuario" method="POST" autocomplete="off">
               <div class="row">
                  <div class="col-sm">
                     <label for="CodigoProducto" class="col-form-label">Código<b style="color:gray;">*</b></label>
                     <input type="text" class="form-control form-control-sm" id="CodigoProducto" name="CodigoProducto" placeholder="Código" required="">
                  </div>
                  <div class="col-sm">
                     <label for="NombreProducto" class="col-form-label">Nombre producto<b style="color:gray;">*</b></label>
                     <input type="text" class="form-control form-control-sm" id="NombreProducto" name="NombreProducto" placeholder="Nombre producto" required="">
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm">
                  <label for="IdTipoProducto" class="col-form-label">Tipo producto<b style="color:gray;">*</b></label>
                     <select class="form-control form-control-sm" name="IdTipoProducto" required="">
                        <option disabled="" selected="">Selecciona tipo de producto</option>
                        <option value="1">licor</option>
                        <option value="2">mecato</option>
                        <option value="3">cigarrillos</option>
                     </select>
                  </div>
                  <div class="col-sm">
                  <label for="IdPresentacion" class="col-form-label">Presentacion<b style="color:gray;">*</b></label>
                     <select class="form-control form-control-sm" name="IdPresentacion" required="">
                        <option disabled="" selected="">Selecciona tipo de presentacion</option>
                        <option value="1">caja</option>
                        <option value="2">botella vidrio</option>
                        <option value="3">lata</option>
                     </select>
                  </div>
               </div>   
               <div class="row">
                  <div class="col-sm">
                  <label for="IdMarca" class="col-form-label">Marca<b style="color:gray;">*</b></label>
                     <select class="form-control form-control-sm" name="IdMarca" required="">
                        <option disabled="" selected="">Selecciona el tipo de marca</option>
                        <option value="1">postobon</option>
                        <option value="2">aguardiente medellin</option>
                        <option value="3">ron 8 años</option>
                     </select>
                  </div>
                  <div class="col-sm">
                     <label for="Contenido" class="col-form-label">Medida<b style="color:gray;">*</b></label>
                     <input type="text" class="form-control form-control-sm" id="Contenido" name="Contenido" autocomplete="on" placeholder="Medida" required="">
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm">
                  <label for="mod_type_user" class="col-form-label">Unidad medida<b style="color:gray;">*</b></label>
                     <select class="form-control form-control-sm" name="user_type" required="">
                        <option disabled="" selected="">Selecciona el tipo de unidad medida</option>
                        <option value="1">litros</option>
                        <option value="2">unidad</option>
                        <option value="3">mililitros</option>
                     </select>
                  </div>
                  <div class="col-sm">
                     <label for="Existencias" class="col-form-label">Existencia<b style="color:gray;">*</b></label>
                     <input type="number" class="form-control form-control-sm" id="Existencias" name="Existencias" placeholder="Existencia" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required="">
                  </div>
               </div> 
               <div class="row">  
                  <div class="col-sm">
                     <label for="PrecioSugerido" class="col-form-label">Precio<b style="color:gray;">*</b></label>
                     <input type="number" class="form-control form-control-sm" id="PrecioSugerido"  name="PrecioSugerido" placeholder="Precio" pattern=".{6,}" required="">
                  </div>
                  <div class="col-sm">
                     <label for="StockMinimo" class="col-form-label">Sctok minimo<b style="color:gray;">*</b></label>
                     <input type="" class="form-control form-control-sm" id="StockMaximo"  name="StockMinimo" placeholder="Stock minimo" required="">
                  </div>
               </div>
               <div class="row">  
                  <div class="col-sm-6">
                     <label for="StockMaximo" class="col-form-label">Sctok máximo<b style="color:gray;">*</b></label>
                     <input type="" class="form-control form-control-sm" id="StockMaximo" name="StockMaximo" placeholder="Stock máximo"  required="">
                  </div>
                  <div class="col-sm">
                     <label for="ImagenProducto" class="col-form-label">Imagen producto<b style="color:gray;">*</b></label> 
							<input  id="fileUpload" name="ImagenProducto" type="file" onchange="upload_image();" accept=".jpg,.png,.jpeg">
							<div class="contenedorImagen">
                        <div class="imagen" id="image-holder"></div>
                     </div>   
               </div>
               <div id="vigencia_usuario2"></div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary btn-sm" id="guardar_datos">Guardar datos</button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->

<script src="<?php echo RUTA_URL; ?>/Productos/files?js=recursos/js/Productos.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>