<!DOCTYPE html>
<html lang="<?php echo LANG; ?>">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="id=edge">
   <meta name="generator" content="<?php echo NOMBRE_APP; ?>" />
   <meta name="description" content="Bar70 App" />
   <meta name="theme-color" content="#33333" />
   <title><?php echo $datos['titulo']; ?></title>
   <link rel="shortcut icon" href="<?php echo RUTA_URL; ?>/public/img/icon.ico" />
   <link rel="apple-touch-icon" sizes="150x150" href="<?php echo RUTA_URL; ?>/public/img/icon.png" />
   <?php if (isset($_SESSION['modeView'])) : ?>
      <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/bootstrap/css/dark.min.css" id="linkestilo1" />
      <link rel="stylesheet" type="text/css" href="<?php echo RUTA_URL; ?>/public/css/styles_dark.css" id="linkestilo2">
   <?php else : ?>
      <link rel="stylesheet" type="text/css" href="<?php echo RUTA_URL; ?>/public/css/styles.css" id="linkestilo1">
      <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/bootstrap/css/sb-admin-2.min.css" id="linkestilo2" />
   <?php endif ?>
   <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/fontawesome/css/all.min.css" />
   <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/css/alertify.min.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo RUTA_URL ?>/public/css/login.min.css">
   <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/jquery/jquery.min.js"></script>
   <script type="text/javascript" src="<?php echo RUTA_URL; ?>/public/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?php echo RUTA_URL ?>/public/js/main.js"></script>
   <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/alertify.min.js"></script>
   <?php if (isset($datos['dataTables'])) {
      echo $datos['dataTables'];
   } ?>
</head>

<body>
   <div class="container">
      <input hidden type="text" id="ruta" value="<?php echo RUTA_URL; ?>">
      <div class="row">
         <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
               <div class="card-body">
                  <div align="center">
                     <img class="img-fluid" id="logo" src="<?php echo RUTA_URL; ?>/public/img/logo.jpeg"><br><br>
                  </div>
                  <?php
                  // show potential errors / feedback (from login object)
                  if (isset($_GET['no_user'])) {
                  ?>
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error <i class="fas fa-exclamation-circle"></i></strong> El usuario no existe.
                     </div>
                  <?php } ?>
                  <?php
                  // show potential errors / feedback (from login object)
                  if (isset($_GET['bad_password'])) {
                  ?>
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error <i class="fas fa-exclamation-circle"></i></strong> La contraseña es incorrecta.
                     </div>
                  <?php } ?>
                  <?php
                  // show potential errors / feedback (from login object)
                  if (isset($_GET['logout'])) {
                  ?>
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Aviso <i class="fas fa-exclamation-circle"></i></strong> Has sido desconectado.
                     </div>
                  <?php } ?>
                  <form id="login" class="form-signin bg-white" action="<?php echo RUTA_URL; ?>/login/login" method="POST">
                     <div class="form-label-group">
                        <input type="text" id="inputEmail" class="form-control" name="user_name" placeholder="Usuario" required autofocus autocomplete="off">
                        <label for="inputEmail"><i class="fas fa-user icon"></i> Usuario </label>
                     </div>
                     <div class="form-label-group">
                        <input type="password" id="inputPassword" class="form-control" name="user_password" placeholder="Contraseña" required autocomplete="off">
                        <label for="inputPassword"><i class="fas fa-key icon"></i> Contraseña</label>
                     </div>
                     <button id="start" class="btn btn-lg btn-login btn-block" onclick="Search()" type="button">Login</button>
                     <hr class="my-4">
                     <p class="text-center"><small><?php echo " &copy  2019 - " . date("Y") . " " . NOMBRE_APP; ?><br></small></p>
               </div>
               </form>

            </div>
         </div>
      </div>
      <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/login.js"></script>
      <footer class="bd-footer text-muted footer">
         <div class="container-fluid p-3 p-md-5">
            &nbsp;
         </div>
      </footer>
   </div>
</body>

</html>