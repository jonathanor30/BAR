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
                    <a href="<?php echo RUTA_URL; ?>/Clientes" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-lg-inline-block">Atras</span>
                    </a>
                    <a href="<?php echo RUTA_URL; ?>/usuarios/editar/<?php echo $datos['perfil']->user_id; ?>" class="btn btn-sm btn-outline-secondary">
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
switch ($datos['perfil']->user_type) {

    case 1:
        $tipo_usuario = "<span class='badge badge-warning'>Empleado</span>";
        break;

    case 2:
        $tipo_usuario = "<span class='badge badge-primary'>Administrador</span>";
        break;
}
//Estado usurio
switch ($datos['perfil']->estado_usuario) {
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
            <b><?php echo ucwords($datos['perfil']->user_name); ?></b>
        </div>

        <div class="card-body">
            <form method="POST" id="edit-form">
                <div class="row">
                    <div class="col-sm">
                        <label for="exampleInputPassword1">Nombres</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Nombres" name="firstname" value="<?php echo $datos['perfil']->firstname; ?>" required>
                        <input type="hidden" id="id" value="<?php echo $datos['perfil']->user_id; ?>">
                    </div>
                    <div class="col-sm">
                        <label for="exampleInputPassword1">Apellidos</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Apellidos" name="lastname" value="<?php echo $datos['perfil']->lastname; ?>" required>
                    </div>
                    <div class="col-sm">
                        <label for="exampleInputPassword1">Usuario</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Usuario" name="user_name" value="<?php echo $datos['perfil']->user_name; ?>" required>
                    </div>
                    <div class="col-sm">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Email" name="user_email" id="user_email" value="<?php echo $datos['perfil']->user_email; ?>" required>
                        <!--
                  <?php if ($datos['perfil']->email_verification == 1) : ?>
                     
                  <label>Verificación en 2 pasos?</label>
                     <input type="checkbox" checked onchange="Validity();" id="2-step-email" name="2-step-email">
                  <?php else : ?>
                     <input type="checkbox" onchange="Validity();" id="2-step-email" name="2-step-email">
                  <?php endif; ?> -->
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm" hidden>
                        <label for="IdTipoDocumento">Tipo documento</label>
                        <select class="form-control form-control-sm" name="IdTipoDocumento" value="<?php echo $datos['perfil']->IdTipoDocumento; ?>" required="">
                            <option disabled="" selected="">Selecciona tipo de documento</option>
                            <option value="1" <?php if ($datos['perfil']->IdTipoDocumento == 1) {
                                                    echo "selected";
                                                } ?>>Cedula</option>
                            <option value="2" <?php if ($datos['perfil']->IdTipoDocumento == 2) {
                                                    echo "selected";
                                                } ?>>Cedula extrajera</option>
                        </select>
                    </div>
                    <div class="col-sm" hidden>
                        <label for="Numero_Documento">Número documento</label>
                        <input type="text" class="form-control form-control-sm" id="Numero_Documento" name="Numero_Documento" placeholder="Número documento" value="<?php echo $datos['perfil']->Numero_Documento; ?>" required="">
                    </div>


                    <div class="col-sm">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" id="password" class="form-control form-control-sm" placeholder="*****" name="user_password_new" autocomplete="off" required="">
                    </div>
                    <div class="col-sm">
                        <label for="exampleInputPassword1"><b>Confirmar contraseña</b></label>
                        <input type="password" id="repassword" class="form-control form-control-sm" placeholder="*****" name="user_password_repeat" onkeyup="validityPassword()" autocomplete="off" required="">
                    </div>
                    <div class="col-sm" hidden>
                        <label for="exampleInputPassword1">Tipo de usuario</label>
                        <select class="form-control form-control-sm" id="user_type" <?php echo ($datos['perfil']->user_type == 99 ? "disabled" : "") ?> name="user_type">
                            <option disabled="" selected="">Selecciona el tipo de usuario</option>
                            <option value="1" <?php if ($datos['perfil']->user_type == 1) {
                                                    echo "selected";
                                                } ?>>Empleado</option>
                            <option value="2" <?php if ($datos['perfil']->user_type == 2) {
                                                    echo "selected";
                                                } ?>>Administrador</option>
                        </select>
                    </div>


                </div>

                <div>

                    <input type="hidden" class="form-control form-control-sm" id="telegram_id" name="telegram_id" value="<?php echo $datos['perfil']->telegram_id; ?>">
                </div>


                <div class="row">
                    <div class="col-sm-2" hidden>
                        <label for="exampleInputPassword1">Estado</label>
                        <select class="form-control form-control-sm" id="estado" name="estado" required="">
                            <option disabled="" selected="">Selecciona el tipo de usuario</option>
                            <option value="1" <?php if ($datos['perfil']->estado_usuario == 1) {
                                                    echo "selected";
                                                } ?>>Activo</option>
                            <option value="2" <?php if ($datos['perfil']->estado_usuario == 2) {
                                                    echo "selected";
                                                } ?>>Inactivo</option>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <br>
                        <?php if ($datos['perfil']->user_type == 99 && $_SESSION['user_type'] == 1) : ?>
                        <?php elseif ($datos['perfil']->user_type == 99 && $_SESSION['user_type'] == 99) : ?>
                            <button type="button" id="guardar_datos" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar</button>
                        <?php else : ?>
                            <button type="button" id="guardar_datos" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar</button>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-2">
                        <input type="hidden" class="form-control form-control-sm" placeholder="" name="vigencia" value="<?php echo $datos['perfil']->vigencia; ?>">
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