<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bar70 | Recuperar contraseña
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
                <h4><br>
                    <b>Recuperar contraseña</b>
                </h4>
            </div>
            <input hidden type="text" id="ruta" value="<?php echo RUTA_URL; ?>">
            <!-- Icon -->
            <div>
                <img src="<?php echo RUTA_URL; ?>/public/img/email.png" id="icon" alt="User Icon" />
            </div>
            <!-- Login Form -->
            <form action="" id="guardar_pass" method="POST">
                <input type="email" id="txtCorreoElectronico" name="txtCorreoElectronico"  placeholder="Correo Electrónico">
                <div class="loginButton">
                    <input type="submit" id="guardar_datos" value="Enviar Contraseña">
                </div>
            </form>
            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="<?php echo RUTA_URL; ?>/Login/home">Volver a iniciar sesión</a>
            </div>
        </div>
    </div>
    <script>
        var url = "<?php echo RUTA_URL; ?>";
    </script>
    <script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/pass.js"></script>
    <script src="<?php echo RUTA_URL; ?>login_libs/jquery.min.js"></script>
    <script src="<?php echo RUTA_URL; ?>login_libs/bootstrap.min.js"></script>
</body>

</html>