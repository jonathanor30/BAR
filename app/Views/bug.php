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
    <style type="text/css">
        pre {
            counter-reset: line-numbering;
            background: silver;
            padding: 12px 0 14px 0;
            width: auto;
            color: #000;
            line-height: 140%
        }
    </style>

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
                    <h3>
                        <i class="fas fa-bug"></i> Manejador de errores:
                    </h3>
                    <pre>
                      <strong>Ubicación: </strong> Controlador = <?php echo $this->getUrl()[0] ?>, Método = <?php echo $this->getUrl()[1] ?><br>
                      <strong>Error: </strong><?php echo $datos["mensaje"] ?>
                    </pre>
                    <hr class="my-4">
                    <br><br>
                    <a href="<?php echo RUTA_URL . SEPARATOR; ?>" class="btn btn-warning">
                        <i class="fas fa-home fa-fw" aria-hidden="true"></i> Inicio
                    </a>
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