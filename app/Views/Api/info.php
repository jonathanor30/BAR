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

    <style>
        pre {
            counter-reset: line-numbering;
            background: #2c3e50;
            padding: 12px 0px 14px 0;
            width: 100%;
            color: #ecf0f1;
            line-height: 100%;
        }

        pre .line::before {
            content: counter(line-numbering);
            counter-increment: line-numbering;
            padding-right: 1em;
            /* space after numbers */
            padding-left: 8px;
            width: 1.5em;
            text-align: right;
            opacity: 0.5;
            color: white;
        }
    </style>
</head>

<body>

    <div class="jumbotron">
        <p class="text-right"><span class="badge badge-success">Versión <?php echo VERSION ?></span></p>
        <h2 class="display-5">Documentación <?php echo $datos['titulo'] ?></h2>
        <p class="lead">La API de myGTEP nos ofrece una forma sencilla de comunicar con los recursos disponibles, mediante unos métodos concretos y simples a los que podemos denominar en su conjunto como CRUD, por su acrónimo en inglés:</p>
        <ul>
            <li>POST: Crear (Create) un elemento nuevo.</li>
            <li>GET: Leer (Read) una lista de elementos o un elemento.</li>
            <li>PUT: Actualizar (Update) un elemento concreto.</li>
            <li>DELETE: Eliminar (Delete) un elemento concreto.</li>
        </ul>
        <h3>¿Cómo usarla?</h3>
        <p>Para acceder a la API de myGTEP, añade /api al final de la url donde tengas tu instalación licenciada.
            <p>Esta API es un servicio controlado por la empresa propietaria de la licencia, por lo cual es importante que sea la misma empresa la que proporcione las credenciales.</p>
            <h3>API Endpoints</h3>
            <p>En términos simples, un punto final API es el punto de entrada en un canal de comunicación cuando dos sistemas están interactuando. Se refiere a los puntos de contacto de la comunicación entre una API y un servidor. El punto final puede verse como el medio desde el cual la API puede acceder a los recursos que necesita desde un servidor para realizar su tarea. Un punto final de API es básicamente una palabra elegante para una URL de un servidor o servicio.</p>
            <h3>Endpoint API myGTEP</h3>
            <p>Las APIs normalmente tienen Endpoints definidos de manera estática, en este caso myGTEP es un software modular con continuos desarrollos a la medida de diferentes clientes, lo cual haría una tarea difícil y poco escalable hacer un endpoint por cada funcionalidad del módulo, por lo tanto myGTEP ha definido una estructura de API REST dinámica que permite llamar cada endpoint como un recurso que existe en el sistema, por eso la API responderá solo a los recursos que existen en la base de datos.</p>
            <p>Ejemplo: Si vas ha gestionar la tabla vehículos el endpoint seria <b><?php echo RUTA_URL ?>/api/vehiculos</b> realizando la petición con el método ha utilizar.</p>
            <p>las respuesta de la API seran en formato JSON RFC 8259</p>
            <hr class="my-4">
            <div class="row">
                <div class="form-group">
                    <label for="server">Servers</label>
                    <select class="form-control " id="server">
                        <option value="<?php echo RUTA_URL ?>/api"><?php echo RUTA_URL ?>/api</option>
                    </select>
                </div>
            </div>

    </div>
    <div class="container">
        <h3>Métodos y jemplo de uso</h3>
        <hr>
        <div class="border border-primary">
            <div class="border border-primary alert-primary text-dark">
                <span class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#GET" aria-expanded="false" aria-controls="GET">
                    GET
                </span>
                <b>/api/vehiculos</b>
            </div>
            <div class="collapse" id="GET">
                <div class="card card-body">
                    <p>El endpoint <b>api/vehiculos</b> corresponde al recurso de la tabla vehículos en myGTEP, en este caso la petición GET retornará el listado de todos los vehículos registrados en esa tabla.</p>

                    <pre>
                        <code id="getResult"></code>
                    </pre>

                </div>
            </div>
        </div>
        <br>
        <div class="border border-primary">
            <div class="border border-primary alert-primary text-dark">
                <span class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#GETid" aria-expanded="false" aria-controls="GETid">
                    GET
                </span>
                <b>/api/vehiculos/{id}</b>
            </div>
            <div class="collapse" id="GETid">
                <div class="card card-body">
                    <p>Solicitando un registro en específico al mismo endpoint <b>api/vehiculos/2</b> consultará y mostrará solo un registro.</p>

                    <pre>
                        <code id="getIdResult"></code>
                    </pre>

                </div>
            </div>
        </div>
        <br>
        <div class="border border-success">
            <div class="border border-success alert-success text-dark">
                <span class="btn btn-sm btn-success" type="button" data-toggle="collapse" data-target="#POST" aria-expanded="false" aria-controls="POST">
                    POST
                </span>
                <b>/api/vehiculos/</b>
            </div>
            <div class="collapse" id="POST">
                <div class="card card-body">
                    <p>Si desea conocer los campos minimos para crear un registro, debe hacer una petición al endpoint con la siguiente estructura <b>/api/required/{nombre_de_la_tabla}</b> <br>ejemplo: <b>/api/required/vehiculos</b></p>
                    <pre>
                        <code id="requiredResult"></code>
                    </pre>
                    <p>Creando un registro con el método POST, es importante que el cliente del API envié los datos en una cabecera: application/x-www-form-urlencoded, si la transacción es exitosa recibirá en las cabeceras de respuesta el código 200.</p>
                    <pre>
                        <code>200</code>
                    </pre>

                </div>
            </div>
        </div>
        <br>
        <div class="border border-warning">
            <div class="border border-warning alert-warning text-dark">
                <span class="btn btn-sm btn-warning" type="button" data-toggle="collapse" data-target="#PUT" aria-expanded="false" aria-controls="PUT">
                    PUT
                </span>
                <b>/api/vehiculos/{id}</b>
            </div>
            <div class="collapse" id="PUT">
                <div class="card card-body">
                    <p>Editando un registro con el método PUT, es importante que el cliente del API envié los datos en una cabecera: application/x-www-form-urlencoded, si la transacción es exitosa recibirá en las cabeceras de respuesta el código 201.</p>
                    <pre>
                        <code id="putResult">201</code>
                    </pre>

                </div>
            </div>
        </div>
        <br>
        <div class="border border-danger">
            <div class="border border-danger alert-danger text-dark">
                <span class="btn btn-sm btn-danger" type="button" data-toggle="collapse" data-target="#DELETE" aria-expanded="false" aria-controls="DELETE">
                    DELETE
                </span>
                <b>/api/vehiculos/{id}</b>
            </div>
            <div class="collapse" id="DELETE">
                <div class="card card-body">
                    <p>Eliminado un registro con el método DELETE, es importante que el cliente del API envié los datos en una cabecera: application/x-www-form-urlencoded, si la transacción es exitosa recibirá en las cabeceras de respuesta el código 200.</p>
                    <pre>
                        <code id="putResult">200</code>
                    </pre>

                </div>
            </div>
        </div>
        <br>
        <hr>
        <p> Si requiere soporte contacte al distribuidor encargado.</p>

        <br><br>
        <!-- End of Main Content -->
        <footer class="bg-white">
            <div class="container my-auto">
                <div class="copyright text-dark text-center my-auto">
                    <span>&copy; Copyright 2017 - <?php echo date("Y"); ?> | myGTEP Negocio, reescrito por software.</span>
                </div>
            </div>
        </footer>
        <script>
            var get_result = '[{"id_vehiculo":1,"placa_vehiculo":"ESQ50E","usuario_asignado":"admin","user_id":1,"chasis_vehiculo":"9AGA4G4A6G48SD4","numero_motor":"9512357","combustible_vehiculo":"DIESEL","capacidad_vehiculo":"18","modelo_vehiculo":"2019","marca_vehiculo":"RENAULT","linea_vehiculo":"NUEVO MASTER","clase_vehiculo":"BUS","numerointerno_vehiculo":"9426","cilindraje_vehiculo":"2295","tarjetaoperacion_vehiculo":"19930526","tarjetaoperacion_fechaEx":"2018-11-27","tarjetaoperacion_fechaVe":"9999-12-31","soat_fechaEx":"2019-11-10","soat_fechaVe":"2022-11-10","tecnomecanica_Ex":"2018-11-10","tecnomecanica_Ve":"2020-11-10","tecnomecanicaBi_Ex":"2019-11-10","tecnomecanicaBi_Ve":"2022-11-01","status_vehiculo":"1","propietario_vehiculo":"Juan Bautista","cc_propietario_vehiculo":"75216982","servicio":"PUBLICO","date_added":"2019-10-27 11:10:18"},{"id_vehiculo":2,"placa_vehiculo":"TTQ589","usuario_asignado":"admin","user_id":1,"chasis_vehiculo":"8FG8FDGASG8ASDG8","numero_motor":"2SF54AFS45ASDF","combustible_vehiculo":"DIESEL","capacidad_vehiculo":"4","modelo_vehiculo":"2013","marca_vehiculo":"TOYOTA","linea_vehiculo":"HILUX","clase_vehiculo":"CAMIONETA","numerointerno_vehiculo":"65","cilindraje_vehiculo":"2494","tarjetaoperacion_vehiculo":"41157","tarjetaoperacion_fechaEx":"0219-04-21","tarjetaoperacion_fechaVe":"2021-04-21","soat_fechaEx":"2019-06-04","soat_fechaVe":"2020-06-04","tecnomecanica_Ex":"2019-06-20","tecnomecanica_Ve":"2020-06-20","tecnomecanicaBi_Ex":"2019-10-19","tecnomecanicaBi_Ve":"2020-01-01","status_vehiculo":1,"propietario_vehiculo":"Juan Bautista","cc_propietario_vehiculo":"75216982","servicio":"PUBLICO","date_added":"2018-09-06 17:24:29"},{"id_vehiculo":3,"placa_vehiculo":"ESO989","usuario_asignado":"1","user_id":"1","chasis_vehiculo":"93YMAF4CEJJ161071","numero_motor":"M9TC678C029475","combustible_vehiculo":"DIESEL","capacidad_vehiculo":"19","modelo_vehiculo":"2018","marca_vehiculo":"RENAULT","linea_vehiculo":"MASTER","clase_vehiculo":"MICROBUS","numerointerno_vehiculo":"020","cilindraje_vehiculo":"2299","tarjetaoperacion_vehiculo":"75849","tarjetaoperacion_fechaEx":"2019-06-14","tarjetaoperacion_fechaVe":"2021-06-14","soat_fechaEx":"2019-01-30","soat_fechaVe":"2020-01-30","tecnomecanica_Ex":"2018-02-01","tecnomecanica_Ve":"2020-02-01","tecnomecanicaBi_Ex":"2019-11-21","tecnomecanicaBi_Ve":"2020-01-22","status_vehiculo":1,"propietario_vehiculo":"Juan Bautista","cc_propietario_vehiculo":"75216982","servicio":"PUBLICO","date_added":"2018-09-07 12:01:15"}]';
            var get_tmpData = JSON.parse(get_result);
            var get_formattedData = JSON.stringify(get_tmpData, null, '\t');
            $('#getResult').text(get_formattedData);

            var getId_result = '[{"id_vehiculo":2,"placa_vehiculo":"TTQ589","usuario_asignado":"admin","user_id":1,"chasis_vehiculo":"8FG8FDGASG8ASDG8","numero_motor":"2SF54AFS45ASDF","combustible_vehiculo":"DIESEL","capacidad_vehiculo":"4","modelo_vehiculo":"2013","marca_vehiculo":"TOYOTA","linea_vehiculo":"HILUX","clase_vehiculo":"CAMIONETA","numerointerno_vehiculo":"65","cilindraje_vehiculo":"2494","tarjetaoperacion_vehiculo":"41157","tarjetaoperacion_fechaEx":"0219-04-21","tarjetaoperacion_fechaVe":"2021-04-21","soat_fechaEx":"2019-06-04","soat_fechaVe":"2020-06-04","tecnomecanica_Ex":"2019-06-20","tecnomecanica_Ve":"2020-06-20","tecnomecanicaBi_Ex":"2019-10-19","tecnomecanicaBi_Ve":"2020-01-01","status_vehiculo":1,"propietario_vehiculo":"Juan Bautista","cc_propietario_vehiculo":"75216982","servicio":"PUBLICO","date_added":"2018-09-06 17:24:29"}]';
            var getId_tmpData = JSON.parse(getId_result);
            var getId_formattedData = JSON.stringify(getId_tmpData, null, '\t');
            $('#getIdResult').text(getId_formattedData);

            var requiredResult = '{"required":["placa_vehiculo","modelo_vehiculo","marca_vehiculo","clase_vehiculo","numerointerno_vehiculo","tarjetaoperacion_vehiculo","status_vehiculo","date_added"]}';
            var required_tmpData = JSON.parse(requiredResult);
            var required_formattedData = JSON.stringify(required_tmpData, null, '\t');
            $('#requiredResult').text(required_formattedData);
        </script>
</body>

</html>