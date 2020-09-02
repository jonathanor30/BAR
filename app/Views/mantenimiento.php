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
    <link rel="stylesheet" type="text/css" href="<?php echo RUTA_URL; ?>/public/css/mantenimiento.scss">
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
        <strong>Mantenimiento!</strong> <?php echo (isset($datos['Name']) ? $datos['Name'] : NOMBRE_APP) ?> en este momento se encuentra <?php echo $datos["problema"] ?>.
    </div>
    <div class="container" style="max-height:643px">
        <div class="row">
            <div class="col-sm-12">
                <div class="jumbotron">
                    <div class="spinny-cogs">
                        <i class="fa fa-cog fa-spin-one" aria-hidden="true"></i>
                        <i class="fa fa-5x fa-cog fa-spin" aria-hidden="true"></i>
                        <i class="fa fa-3x fa-cog fa-spin-two" aria-hidden="true"></i>
                    </div>
                    <h2 style="text-align: center">
                        <?php echo $datos["mensaje"] ?>
                    </h2>
                    <hr class="my-4">
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto" style="color:black">
                <span>&copy; Copyright 2017 - <?php echo date("Y"); ?> | myGTEP Negocio, reescrito por software.</span>
            </div>
        </div>
    </footer>
    <!-- End of Main Content -->

    <!-- Acá termina la envoltura de página -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>

</html>
<?php exit();
die(); ?>