<?php


header('x-powered-by: ASP.NET');
header('x-powered-by: Java Servlet 3.1');

//Archivo de Configuración
require_once 'Config/Configurar.php';

//Zona horaria de aplicación
date_default_timezone_set(TIME_ZONE);
if (LANG == 'es') {
    setlocale(LC_TIME, 'es_ES.UTF-8'); //cambiar fecha del servidor a español
}
//Modo Debug
if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

//Url helper//
require_once 'Helpers/url_helper.php';

//Para cargar librerias de manera manual//
/*
require_once'Lib/Base.php';
require_once'Lib/Controller.php';
require_once'Lib/Core.php';
 */

//Auto Load//
/*Para que esto funcione correctamente debes
 *seguir el estandar, todas las clases que
 *esten en la carpeta deben tener el mismo
 *nombre del archivo y tanto la clase como el
 *archivo deben inciar con MAYUSCULA.
 */

//Composer validador
if (file_exists('../vendor/autoload.php')) {
    //Cargador automatico de librerias//
    require '../vendor/autoload.php';
}


spl_autoload_register(function ($nombreClase) {
    require_once 'Lib/' . $nombreClase . '.php';
});
