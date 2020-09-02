<?php require RUTA_APP . '/Views/inc/header.php';?>
<br>
<div class="container">
   <div id="resultados"></div>
</div>
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
               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#cargarPlugin"><i class="fas fa-plus"></i> Nuevo</button>
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
      <!-- Carga los datos ajax -->
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
   <table style="font-size: 12px;" id="<?php echo $datos['titulo'];?>" class="table table-hover">
         <thead>
            <tr>
               <th class="text-left">Nombre</th>
               <th style="width:35%;" class="text-left">Descripción</th>
               <th class="text-left">Versión</th>
               <th class="text-left">Autor</th>
               <th class="text-left">Estado</th>
               <th class="text-left">Acciones</th>
            </tr>
         </thead>
      </table>
</div>
<!-- Modal Cargar Plugin-->
<div class="modal fade" id="cargarPlugin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Instalar Plugin <i class="<?php echo $datos["icon"]; ?>"></i></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form enctype="multipart/form-data" method="POST" action="<?php echo RUTA_URL; ?>/plugins/agregar">
               <div class="form-group">
                  <label>Seleccione el archivo <b>zip</b> del Plugin: <input type="file" class="form-control-file" required name="zip_file" /></label>
                  <small class="form-text text-muted">This server support files up to 99 MB.</small>
                  <br/>
               </div>
         </div>
         <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
         <button type="submit" name="submit" class="btn btn-primary"> Continuar</button>
         </form>
         </div>
      </div>
   </div>
</div>
</div>
<script src="<?php echo RUTA_URL?>/Plugins/files?js=js/Plugins.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php';?>