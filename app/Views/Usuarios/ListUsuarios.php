<?php require(RUTA_APP . '/Views/inc/header.php'); ?>
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
      <table style="font-size: 12px;" id="<?php echo $datos['titulo']; ?>" class="table table-hover">
         <thead>
            <tr>
               <th class="text-left">Nombres</th>
               <th class="text-left">Usuario</th>
               <th class="text-left">Email</th>
               <th class="text-left">Tipo</th>
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
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Nuevo usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" action="" id="guardar_usuario" method="POST" autocomplete="off">
               <div class="row">
                  <div class="col-sm">
                     <label for="firstname" class="col-form-label">Nombres</label>
                     <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" placeholder="Nombres" required="">
                  </div>
                  <div class="col-sm">
                     <label for="lastname" class="col-form-label">Apellidos</label>
                     <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" placeholder="Apellidos" required="">
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm">
                     <label for="user_name" class="col-form-label">Usuario</label>
                     <input type="text" class="form-control form-control-sm" id="user_name" name="user_name" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)" required="">
                  </div>
                  <div class="col-sm">
                     <label for="user_email" class="col-form-label">Email</label>
                     <input type="email" class="form-control form-control-sm" id="user_email" name="user_email" autocomplete="on" placeholder="Correo electrónico" required="">
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm">
                     <label for="user_password_new" class="col-form-label">Contraseña</label>
                     <input type="password" class="form-control form-control-sm" id="user_password_new" name="user_password_new" placeholder="Contraseña" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required="">
                  </div>
                  <div class="col-sm">
                     <label for="user_password_repeat" class="col-form-label">Repite contraseña</label>
                     <input type="password" class="form-control form-control-sm" id="user_password_repeat" onkeyup="validityPassword()" name="user_password_repeat" placeholder="Repite contraseña" pattern=".{6,}" required="">
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm">
                  <label for="mod_type_user" class="col-form-label">Tipo usuario</label>
                     <select class="form-control form-control-sm" name="user_type" required="">
                        <option disabled="" selected="">Selecciona el tipo de usuario</option>
                        <option value="1">root</option>
                        <option value="2">admin</option>
                        <option value="3">operador</option>
                     </select>
                  </div>
                  <div class="col-sm">
                     <label for="mod_estado" class="col-form-label">Estado</label>
                     <select class="form-control form-control-sm" id="estado" name="estado" required="">
                        <option value="">-- Selecciona estado --</option>
                        <option value="1" selected="">Activo</option>
                        <option value="0">Inactivo</option>
                     </select>
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
<div class="modal fade" id="asignar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Asginar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
         </div>
      </div>
   </div>
</div>
<script src="<?php echo RUTA_URL ?>/Usuarios/files?js=js/Usuarios.js"></script>
<?php require(RUTA_APP . '/Views/inc/footer.php'); ?>