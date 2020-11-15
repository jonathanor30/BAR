<?php



class LogManager
{
    /*
    new LogManager(array(
    'tipo'    => 'DB-QUERY',
    'mensaje' => 'Este será el mensaje del Log',
    ));
     */
    public function __construct($info = [])
    {
        //Manejador de errores
        try {
            if (!empty($info)) {
                //Comprobador de tipo de log
                switch ($info['tipo']) {
                    case 'ERROR':
                        $this->writeLog(array(
                            'tipo'    => $info['tipo'],
                            'mensaje' => $info['mensaje'],
                        ));
                        break;
                    case 'WARNING':
                        $this->writeLog(array(
                            'tipo'    => $info['tipo'],
                            'mensaje' => $info['mensaje'],
                        ));
                        break;
                    case 'DANGER':
                        $this->writeLog(array(
                            'tipo'    => $info['tipo'],
                            'mensaje' => $info['mensaje'],
                        ));
                        break;
                    case 'INFO':
                        $this->writeLog(array(
                            'tipo'    => $info['tipo'],
                            'mensaje' => $info['mensaje'],
                        ));
                        break;
                    case 'DB-QUERY':
                        $this->writeLog(array(
                            'tipo'    => $info['tipo'],
                            'mensaje' => $info['mensaje'],
                        ));
                        break;
                }
            } else {
                throw new Exception("Debe indicar el tipo de evento a registrar en LogManager.");
            }
            // continue execution of the bootstrapping phase
        } catch (Exception $e) {
            echo "<div style='color:#856404;background-color:#fff3cd;border-color:#ffeeba;'>" . $e->getMessage() . "</div>";
        }
    }

    //Metodo para escribir Logs
    public function writeLog($datos = [])
    {
        if (LOGS_MANAGER) {
            //chmod(RUTA_LOGS, 0777);
            @chmod(RUTA_LOGS, 0777);
            # Zona horaria
            date_default_timezone_set("America/Bogota");

            # Crear carpeta si no existe
            if (!file_exists(RUTA_LOGS) && !file_exists(RUTA_LOGS . 'Log.json')) {
                mkdir(RUTA_LOGS, '766', true);
                $file = RUTA_LOGS . 'Log.json';
                $fp   = fopen($file, 'w+');
                $jsonVECTOR = array(
                    'data' => array(),
                );

                $logData =
                    array(
                        "tipo" => $datos["tipo"],
                        "mensaje" => $datos["mensaje"],
                        "usuario" => $_SESSION['user_name'] ?? 'my',
                        "IP" => $this->getRealIP(),
                        "fecha" => date("Y-m-d H:i:s")

                    );

                array_push($jsonVECTOR['data'], $logData);

                $file = RUTA_LOGS . 'Log.json';
                $fp   = fopen($file, 'a+');
                fwrite($fp, json_encode($jsonVECTOR, JSON_UNESCAPED_UNICODE));
                fclose($fp);
            } else {
                $fileLog = file_get_contents(RUTA_APP . SEPARATOR . "Logs" . SEPARATOR . "Log.json");
                $decode_logs = json_decode($fileLog, TRUE);

                $dataLog = array(
                    "tipo" => $datos["tipo"],
                    "mensaje" => $datos["mensaje"],
                    "usuario" => $_SESSION['user_name'] ?? 'api',
                    "IP" => $this->getRealIP(),
                    "fecha" => date("Y-m-d H:i:s")

                );

                array_push($decode_logs['data'], $dataLog);

                $file = RUTA_LOGS . 'Log.json';
                $fp   = fopen($file, 'w+');
                fwrite($fp, json_encode($decode_logs, JSON_UNESCAPED_UNICODE));
                fclose($fp);
            }
        }
    }

    //Método para obtener IP del cliente
    public function getRealIP()
    {

        if (isset($_SERVER["HTTP_CLIENT_IP"])) {

            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {

            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {

            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {

            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {

            return $_SERVER["HTTP_FORWARDED"];
        } else {

            return $_SERVER["REMOTE_ADDR"];
        }
    }
}
