<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div id="logUpdate"></div>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="container-fluid d-print-none">
      <div class="row">
         <div class="col-md-12">
            <nav aria-label="breadcrumb">
               <h3><?php echo $datos['titulo'] . " <i class='" . $datos['icon'] . "'>"; ?></i></h3>
            </nav>
         </div>
      </div>
      <div class="row">
         <div class="col-md-4 col-6">
            <div class="btn-group">
               <a href="<?php echo RUTA_URL; ?>/usuarios" class="btn btn-sm btn-outline-secondary">
                  <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
                  <span class="d-none d-lg-inline-block">Usuarios</span>
               </a>
               <a href="<?php echo RUTA_URL; ?>/usuarios/editar/<?php echo $datos['usuario']->user_id; ?>" class="btn btn-sm btn-outline-secondary">
                  <i class="fas fa-sync" aria-hidden="true"></i>
               </a>
            </div>
         </div>
      </div>
   </div>
</div>
<br>
<?php
//Tipo de usaurio
switch ($datos['usuario']->user_type) {
   
   case 1:
      $tipo_usuario = "<span class='badge badge-warning'>Empleado</span>";
      break;
      
   case 2:
      $tipo_usuario = "<span class='badge badge-primary'>Administrador</span>";
      break;
}
//Estado usurio
switch ($datos['usuario']->estado_usuario) {
   case 1:
      $estado = "Activo";
      break;
   case 0:
      $estado = "Inactivo";
      break;
}
?>
<div class="container-fluid">
   <div class="card">
      <div class="card-header">
         <b><?php echo ucwords($datos['usuario']->user_name); ?></b>
      </div>
      <div class="card-body">
         <form method="POST" id="edit-form">
            <div class="row">
               <div class="col-sm">
                  <label for="exampleInputPassword1">Nombres</label>
                  <input type="text" class="form-control form-control-sm" placeholder="Nombres" name="firstname" value="<?php echo $datos['usuario']->firstname; ?>" required>
                  <input type="hidden" id="id" value="<?php echo $datos['usuario']->user_id; ?>">
               </div>
               <div class="col-sm">
                  <label for="exampleInputPassword1">Apellidos</label>
                  <input type="text" class="form-control form-control-sm" placeholder="Apellidos" name="lastname" value="<?php echo $datos['usuario']->lastname; ?>" required>
               </div>
               <div class="col-sm">
                  <label for="exampleInputPassword1">Usuario</label>
                  <input type="text" class="form-control form-control-sm" placeholder="Usuario" name="user_name" value="<?php echo $datos['usuario']->user_name; ?>" required>
               </div>
               <div class="col-sm">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" class="form-control form-control-sm" placeholder="Email" name="user_email" id="user_email" value="<?php echo $datos['usuario']->user_email; ?>" required>
                  <!--
                  <?php if ($datos['usuario']->email_verification == 1) : ?>
                     
                  <label>Verificación en 2 pasos?</label>
                     <input type="checkbox" checked onchange="Validity();" id="2-step-email" name="2-step-email">
                  <?php else : ?>
                     <input type="checkbox" onchange="Validity();" id="2-step-email" name="2-step-email">
                  <?php endif; ?> -->
               </div>
            </div>
            <div class="row">
               <div class="col-sm">
                  <label for="exampleInputPassword1">Contraseña</label>
                  <input type="password" id="password" class="form-control form-control-sm" placeholder="*****" name="user_password_new" autocomplete="off" required="">
               </div>
               <div class="col-sm">
                  <label for="exampleInputPassword1"><b>Confirmar contraseña</b></label>
                  <input type="password" id="repassword" class="form-control form-control-sm" placeholder="*****" name="user_password_repeat" onkeyup="validityPassword()" autocomplete="off" required="">
               </div>
               <div class="col-sm">
                  <label for="exampleInputPassword1">Tipo de usuario</label>
                  <select class="form-control form-control-sm" id="user_type" <?php echo ($datos['usuario']->user_type == 99 ? "disabled" : "") ?> name="user_type">
                     <option disabled="" selected="">Selecciona el tipo de usuario</option>
                     <option value="1" <?php   if($datos['usuario']->user_type ==1){echo "selected"; } ?>>Empleado</option>
                     <option value="2"  <?php if($datos['usuario']->user_type ==2){echo "selected"; }?>>Administrador</option>
                  </select>
               </div>
            </div>
            <br>
            <label>Telegram</label>
            <hr>
            <div class="row">
               <div class="col-sm-2">
                  <label>Id de telegram</label>
                  <input type="text" class="form-control form-control-sm" id="telegram_id" name="telegram_id" value="<?php echo $datos['usuario']->telegram_id; ?>">
                  <label>Verificación en 2 pasos?</label>
                  <?php if ($datos['usuario']->telegram_verification == 1) : ?>
                     <input type="checkbox" checked onchange="Validity();" id="2-step" name="2-step">
                  <?php else : ?>
                     <input type="checkbox" onchange="Validity();" id="2-step" name="2-step">
                  <?php endif; ?>
               </div>

            </div>
            <hr>
            <?php if ($datos['usuario']->user_type != 1 && $datos['usuario']->user_type != 99) : ?>
               <div class="row">
                  <div class="col-sm">
                     <i class="fas fa-cubes"></i> Asignar Módulos:
                     <?php $modulos = getExistingPlugins(RUTA_PLUGINS); ?>
                     <select id="modulos" class="form-control form-control-sm" style="width:300px" onchange="asignarModulos();">
                        <option selected="" disabled="">---Seleccione Módulos---</option>
                        <?php foreach ($modulos as $plugin) : ?>
                           <?php $i = parse_ini_file(RUTA_PLUGINS . $plugin . SEPARATOR . 'info.ini'); ?>
                           <?php if ($i["estado"] != "inactivo") : ?>
                              <option value="<?php echo $i["nombre"] ?>"><?php echo $i["nombre"] ?></option>
                           <?php endif ?>
                        <?php endforeach ?>
                     </select>
                  </div>
               </div>
               <hr>
               <div class="table-responsive-sm">
                  <table id="TableBody">
                     <?php foreach ($datos['modulos_asignados'] as $key => $value) : ?>
                        <?php echo '<tr id="' . $value->nombre_modulo . '"><td><input class="form-control form-control-sm-plaintext input-sm numero_item" type="hidden" name="nombre_plugin[]" readonly="" value="' . $value->nombre_modulo . '" required=""><span class="badge badge-pill badge-info">' . $value->nombre_modulo . '</span></td><td><button class="btn btn-sm badge badge-danger" type="button" title="Inhabilitar ' . $value->nombre_modulo . '" onclick="deleteRow(this, ' . "'" . $value->nombre_modulo . "'" . ');"><i class="fas fa-trash"></i></button></td></tr>'
                        ?>

                     <?php endforeach ?>
                  </table>
                  <hr>
               </div>
            <?php endif; ?>

            <div class="row">
               <div class="col-sm-2">
                  <label for="exampleInputPassword1">Estado</label>
                  <select class="form-control form-control-sm" id="estado" name="estado" required="">
                     <option selected="" value="<?php echo $datos['usuario']->estado_usuario; ?>"><?php echo $estado; ?></option>
                     <option value="1">Activo</option>
                     <option value="0">Inactivo</option>
                  </select>
               </div>
               <div class="col-sm-2">
                  <label for="exampleInputPassword1">Vigencia</label>
                  <input type="date" class="form-control form-control-sm" placeholder="" name="vigencia" value="<?php echo $datos['usuario']->vigencia; ?>">
               </div>
               <div class="col-sm-2">
                  <br>
                  <?php if ($datos['usuario']->user_type == 99 && $_SESSION['user_type'] == 1) : ?>
                  <?php elseif ($datos['usuario']->user_type == 99 && $_SESSION['user_type'] == 99) : ?>
                     <button type="button" id="guardar_datos" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar</button>
                  <?php else : ?>
                     <button type="button" id="guardar_datos" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar</button>
                  <?php endif; ?>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
</div>
</div>
<script src="<?php echo RUTA_URL ?>/Usuarios/files?js=js/Editar.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>