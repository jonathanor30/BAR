<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<br>
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

<!-- Modal -->

<script src="<?php echo RUTA_URL; ?>/Productos/files?js=recursos/js/Productos.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>