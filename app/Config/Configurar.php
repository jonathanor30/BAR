<?php

/**
 
 */

//Configuración de acceso a la base de datos

//Servidor de base de datos
define('DB_HOST', 'localhost'); //Tambien puede usar: 127.0.0.1
//Usuario de base de datos
define('DB_USER', 'root');
//Contraseña de base de datos
define('DB_PASS', '');
//Nombre de base de datos
define('DB_NAME', 'bar70'); //fr
//Driver o motor de base de datos
define('DB_DRIVER', 'mysql'); //Dependiendo de su gestor de base de datos use:
//mssql  = Microsoft Sql Server
//sybase = Sybase con PDO_DBLIB
//sqlite = SQLite
//mysql  = Mysql
//pgsql  = Postgres sql

//Ruta de la aplicación
define('RUTA_APP', dirname(dirname(__FILE__)));
define('LOGS_MANAGER', true);
//Ruta Logs
define("RUTA_LOGS", RUTA_APP . DIRECTORY_SEPARATOR . 'Logs' . DIRECTORY_SEPARATOR);
//Ruta URL ejmplo: http://localhost/Bar70
define('RUTA_URL', 'http://localhost/Bar70');
//Modo de errores
define('DEBUG_MODE', true);
//Separador de directorio
define('SEPARATOR', DIRECTORY_SEPARATOR);
//Ruta de directorio para la carga de archivos
define('RUTA_UPLOAD', RUTA_APP . SEPARATOR . 'Upload' . SEPARATOR);
//Ruta Plugins
define('RUTA_PLUGINS', RUTA_APP . SEPARATOR . 'Plugins' . SEPARATOR);
//Ruta motor de plantillas
define('SMARTY_DIR', RUTA_APP . SEPARATOR . 'Vendor' . SEPARATOR);
define('MANT_MODE', false);

//zona horaria
define('TIME_ZONE', 'America/Bogota');

//Nombre de la Aplicación
define('NOMBRE_APP', 'Bar70');
//Versión
define('VERSION', '0.1');
//Lenguaje predeterminado
define('LANG', 'es'); //(Español = es),(Ingles = eng)
///////////////////////////////////////////////////////

define('__SECRET_KEY__', 'asdawdsd8ws.6@');
/* Autenticacion: session|db|token */
define('__AUTH__', 'session');
