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
      <table style="font-size: 12px;" id="Proveedores" class="table table-hover">
         <thead>
            <tr>
               <th class="text-left">Nombre</th>
               <th class="text-left">Telefono</th>
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
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i>Nuevo Proveedor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" action="" id="guardar_Proveedor" method="POST" autocomplete="off">
            <div class="row">
                  <div class="col-sm">
                     <label for="Nombres" class="col-form-label">Nombres<b style="color:gray;">*</b></label>
                     <input type="text" class="form-control form-control-sm" id="Nombre" name="Nombre" placeholder="Nombre" required="">
                  </div>
                  <div class="col-sm">
                     <label for="Telefono" class="col-form-label">Telefono<b style="color:gray;">*</b></label>
                     <input type="text" class="form-control form-control-sm" id="Telefono" name="Telefono" placeholder="Telefono" required="">
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

<script src="<?php echo RUTA_URL; ?>/Proveedores/files?js=recursos/js/Proveedores.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>