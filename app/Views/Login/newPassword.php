<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bar70 | cambiar contraseña
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?php echo RUTA_URL; ?>/public/bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="<?php echo RUTA_URL; ?>/public/css/login.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/css/alertify.min.css" />
    <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/alertify.min.js"></script>

</head>
<body>

    <div class="wrapper">
        <div id="formContent">
            <!-- Tabs Titles -->

            <div>
                <h4>
                    <b>Cambiar contraseña</b>
                </h4>
            </div>

            <!-- Icon -->
            <div>
            <img src="<?php echo RUTA_URL; ?>/public/img/lock.png" id="icon" alt="User Icon" />
            </div>
            <input hidden type="text" id="ruta" value="<?php echo RUTA_URL; ?>">

            <!-- Login Form -->
            <form action="" id="guardar_new" method="POST">
                <input type="hidden" id="token" name="token" value="<?php echo $_GET['token']; ?>">
                <input type="password" id="txtContrasena" name="txtContrasena" placeholder="Nueva Contraseña">
                <input type="password" id="txtRepetirContrasena"  name="txtRepetirContrasena" placeholder="Repetir Contraseña">
                
                <div class="loginButton">
                    <input  id="guardar_datos" name="btnGuardar" type="submit" value="Cambiar Contraseña">
                </div>
            </form>
            <!-- Remind Passowrd -->
            <div id="formFooter">
            <a class="underlineHover" href="<?php echo RUTA_URL; ?>/Login/home">Volver a iniciar sesión</a>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/pass2.js"></script>


    <?php if(isset($mensaje)){ ?>

        <script>
            
            window.onload = function(){
                alert('<?php echo $mensaje; ?>');
            }

        </script>

    <?php } ?>

</body>

</html>