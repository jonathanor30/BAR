<?php

/**
 *
 */
class Cron extends Controller
{
    public $writeLog;
    public function __construct()
    {
    }

    public function index()
    {
        //Url de ejecucución: RUTA_URL/cron/cron
        $this->writeLog = new LogManager(array(
            'tipo'    => 'INFO',
            'mensaje' => 'Ejecucion de rutina Crontab',
        ));

        $modulos = getExistingPlugins(RUTA_PLUGINS);
        $list    = array('listado crontab' => array());
        foreach ($modulos as $plugin) {
            require_once '../app/Plugins/' . $plugin . '/' . 'Controllers' . '/' . $plugin . '.php';

            $inspector = new $plugin;

            if ($inspector->cron) {
                array_push($list['listado crontab'], $this->cronExec($plugin));
            }
        }
        // Respuesta en formato JSON
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($list, JSON_PRETTY_PRINT);
    }

    public function cronExec($plugin)
    {

        // abrimos la sesión cURL
        $ch = curl_init();
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL, RUTA_URL . SEPARATOR . $plugin . SEPARATOR . "cron");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        // definimos cada uno de los parámetros
        //curl_setopt($ch, CURLOPT_POSTFIELDS, "id=" . implode(",", $datos));
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        // cerramos la sesión cURL
        curl_close($ch);

        return $remote_server_output;
    }
}
