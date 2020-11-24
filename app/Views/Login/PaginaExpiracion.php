<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="id=edge">
      <meta name="generator" content="<?php echo NOMBRE_APP;?>"/>
      <meta name="description" content="Elephant es un marco de desarrollo de aplicaciones web fácil, ligero y moderno."/>
      <title>Upps!</title>
      <link rel="stylesheet" type="text/css" href="<?php echo RUTA_URL;?>/public/css/styles.css">
      <link rel="shortcut icon" href="<?php echo RUTA_URL;?>/public/img/icon.ico"/>
      <link rel="apple-touch-icon" sizes="150x150" href="<?php echo RUTA_URL;?>/public/img/icon.png"/>
      <link rel="stylesheet" href="<?php echo RUTA_URL;?>/public/bootstrap/css/bootstrap.min.css"/>
      <link rel="stylesheet" href="<?php echo RUTA_URL;?>/public/fontawesome/css/all.min.css"/>
      <script type="text/javascript" src="<?php echo RUTA_URL?>/public/jquery/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo RUTA_URL;?>/public/bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo RUTA_URL?>/public/js/main.js"></script>
  <body>
  	<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
        <strong>Ups!</strong> El link de restablecimiento de la contraseña a expirado en la base de datos. 
        </div>
<div class="container">
        <div class="row">
            <div class="col-sm-12">
                <br><br>
                <div class="jumbotron">
                    <h1>
                        <i class="fas fa-bug" aria-hidden="true"></i> Link expirado:
                    </h1>
                    <hr class="my-4">
                    <b>Vuelva hacer el proceso de restablecimiento de contraseña.</b>
                    <br><br>
                        <a href="<?php echo RUTA_URL; ?>/Login/Login"><button type="button" 
                        class="btn btn-primary">
                        <i class="fas fa-home fa-fw" aria-hidden="true"></i>Inicio</button></a>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Main Content -->
    <footer class="bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>&copy; Copyright 20199 - <?php echo date("Y"); ?> | Bar70 Negocio, reescrito por software.</span>
            </div>
        </div>
    </footer>
    <!-- Acá termina la envoltura de página -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>

</html>
