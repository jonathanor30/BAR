<!DOCTYPE html>
<html lang="<?php echo LANG; ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=big5">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="id=edge">
    <meta name="generator" content="<?php echo NOMBRE_APP; ?>" />
    <meta name="description" content="" />
    <title><?php echo $datos["titulo"] ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo RUTA_URL; ?>/public/css/styles.css">
    <link rel="shortcut icon" href="<?php echo RUTA_URL; ?>/public/img/icon.ico" />
    <link rel="apple-touch-icon" sizes="150x150" href="<?php echo RUTA_URL; ?>/public/img/icon.png" />
    <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/fontawesome/css/all.min.css" />
    <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo RUTA_URL; ?>/public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/main.js"></script>

<body>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">x</span>
        </button>
        <strong>Ups!</strong> GTEP encontró un problema con <?php echo $datos["problema"] ?>.
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <br><br>
                <div class="jumbotron">
                    <h2>
                        <i class="fas fa-lock"></i> <?php echo $datos["mensaje"] ?>
                    </h2>
                    <hr class="my-4">
                    <br><br>
                    <?php if($_SESSION['user_type'] != 1 && count($_SESSION['modulos']) != 0){ ?>
                    <a href="<?php echo RUTA_URL.SEPARATOR.$_SESSION['modulos'][0]->nombre_modulo  ?>" class="btn btn-primary">
                        <i class="fas fa-home fa-fw" aria-hidden="true"></i> Portada
                    </a>
                    <?php }else{ ?>
                        <a href="<?php echo RUTA_URL ?>" class="btn btn-primary">
                        <i class="fas fa-home fa-fw" aria-hidden="true"></i> Portada
                    </a>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->
    <footer class="bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>&copy; Copyright 2017 - <?php echo date("Y"); ?> | myGTEP Negocio, reescrito por software.</span>
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