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
               <!-- se redireccion a crear una compra-->
               <a href="<?php echo RUTA_URL ?>/Compras/test1"><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Nuevo</button></a>
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
      <table style="font-size: 12px;" id="Compras" class="table table-hover">
         <thead>
            <tr>
               <th class="text-left">IdProveedor</th>
               <th class="text-left">fecha</th>
               <th class="text-left">hora</th>
               <th class="text-left">observaciones</th>
               <th class="text-left">Acciones</th>
            </tr>
         </thead>
      </table>
   </div>
</div>
<!-- Modal -->

<!-- Modal -->

<script src="<?php echo RUTA_URL; ?>/Compras/files?js=recursos/js/Compras.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>