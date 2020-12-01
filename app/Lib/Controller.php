<?php

/**

 */


class Controller extends Core
{
    public $typeDevice;
    private $modeloUsuario;
    public $counter;
    public $modelo;
    public function __construct()
    {
    }
    /**
     * Metodo para cargar modelos
     * @access public
     * @param $modelo
     * @param $pluginName
     * @return vista
     */
    public function modelo($modelo, $pluginName = null)
    {
        //Chequear si el modelo existe
        if (file_exists('../app/Models/' . $modelo . '.php')) {
            //Carga modelo
            require_once '../app/Models/' . $modelo . '.php';
            //Instanciar el modelo
            return new $modelo();
        } else {
            //Chequear si el modelo existe en Plugins
            if (file_exists('../app/Plugins/' . $pluginName . '/Models/' . $modelo . '.php')) {
                //Carga modelo
                require_once '../app/Plugins/' . $pluginName . '/Models/' . $modelo . '.php';
                //Instanciar el modelo
                return new $modelo();
            } else {
                die("El modelo no existe");
            }
        }
    }
    /**
     * Metodo de vistas
     * @access public
     * @param = $vista
     * Ruta del archivo de vista
     * @param = $datos
     * Datos de la vista
     * @param = $pluginName
     * Si la vista esta en la carpeta plugin
     * @param = $ofuscar
     * Formatear
     * @param = $validar
     * Validar vista
     * @return vista
     */
    public function vista($vista, $datos = [], $pluginName = null, $ofuscar = null, $validar = null)
    {
        echo "<!-- \n Bar70 \n View generator: " . date('Y-m-d') . "\n-->\n";
        $this->mantMode();
        //Chequear si el archivo vista existe
        if (file_exists('../app/Views/' . $vista . '.php')) {
            if (!empty($ofuscar)) {
                require_once '../app/Views/' . $vista . '.php';
            } else {
                ob_start('comprimir_pagina');
                require_once '../app/Views/' . $vista . '.php';
                ob_end_flush();
            }
        } else {
            //Chequear si el archivo vista existe en Plugins
            if (file_exists('../app/Plugins/' . $pluginName . '/Views/' . $vista . '.php')) {
                if (!$validar) :
                    //validar estado de módulo
                    $this->pluginValidator($pluginName);
                endif;

                if (!empty($ofuscar)) {
                    require_once '../app/Plugins/' . $pluginName . '/Views/' . $vista . '.php';
                } else {
                    ob_start('comprimir_pagina');
                    require_once '../app/Plugins/' . $pluginName . '/Views/' . $vista . '.php';
                    ob_end_flush();
                }
            } else {
                //Si el archivo de la vista no existe
                die('La vista no existe');
            }
        }
    }
    public function filesGTEP($ruta, $nombre = false, $type, $assets = false)
    {
        switch ($type) {
            case 'img':
                if ($nombre != false) {
                    header('Content-Type: image/jpg');
                    readfile(RUTA_PLUGINS . SEPARATOR . $ruta . SEPARATOR . $nombre);
                } else {
                    header('Content-Type: image/jpg');
                    readfile(RUTA_UPLOAD . SEPARATOR . $ruta);
                }
                break;
            case 'pdf':
                header('Content-type: application/pdf');
                readfile(RUTA_UPLOAD . SEPARATOR . $ruta);
                break;
            case 'js':
                if ($assets != false) {
                    header('Content-Type: application/javascript');
                    ob_start('comprimir_js');
                    readfile(RUTA_APP . SEPARATOR . $ruta . SEPARATOR . $nombre);
                    ob_end_flush();
                } else {
                    header('Content-Type: application/javascript');
                    ob_start('comprimir_js');
                    readfile(RUTA_PLUGINS . SEPARATOR . $ruta . SEPARATOR . $nombre);
                    ob_end_flush();
                }
                break;
            case 'json':
                header('Content-Type: application/json');
                readfile(RUTA_PLUGINS . SEPARATOR . $ruta . SEPARATOR . $nombre);
                break;
            case 'css':
                header("Content-type: text/css");
                ob_start('comprimir_css');
                readfile(RUTA_PLUGINS . SEPARATOR . $ruta . SEPARATOR . $nombre);
                ob_end_flush();
                break;
        }
        exit();
    }

    //Método para crear directorios de carga de arhcivo de los plugins
    public function folderCreator($pluginName)
    {
        if (!file_exists(RUTA_UPLOAD . $pluginName)) {
            //Crear directorio de archivos principal
            mkdir(RUTA_UPLOAD . $pluginName, 0777, true);
            //Crear directorios extras
            if (file_exists(RUTA_UPLOAD . $pluginName)) {
                //Crear directorio de archivos de tipo pdf
                mkdir(RUTA_UPLOAD . $pluginName . SEPARATOR . 'pdf', 0777, true);
                //Crear directorio de archivos de tipo imagenes
                mkdir(RUTA_UPLOAD . $pluginName . SEPARATOR . 'img', 0777, true);
            }
        }
    }
    //Métoo para error 404
    public function pagina404($parametro)
    {
        if ($parametro == false) {
            return $this->vista('404') . exit();
        }
    }

    //Métoo para error 408
    public function pagina408($parametro)
    {
        if ($parametro == false) {
            return $this->vista('408') . exit();
        }
    }
    //Métoo para error 412
    public function pagina412($parametro)
    {
        if ($parametro == false) {
            return $this->vista('412') . exit();
        }
    }

    //Método para validación de campos vacios de un formulario
    public function formValidator($array, $exceptions = [])
    {
        //Aplicar excepciones al arreglo, es decir se suprimin los indices indicados
        foreach ($exceptions as $i => $var) {
            unset($array[$var]);
        }
        //Verificación de campos
        $contador = 0;
        foreach ($array as $campo => $valor) {
            if (empty($valor)) {
                echo "El campo " . $campo . " esta vacio<br>";
                $contador++;
            }
        }
        if ($contador == 0) {
            return $array;
        } else {
            return false;
        }
    }

    //Método para escribir en archivos de extensión .ini
    public function write_ini_file($file, $array = [])
    {
        //comprobar si el primer argumento es una cadena
        if (!is_string($file)) {
            throw new \InvalidArgumentException('El primer argumento debe ser string');
        }
        //comprobar si el segundo argumento es un array
        if (!is_array($array)) {
            throw new \InvalidArgumentException('El segundo argumneto debe ser array');
        }
        //Procesar array
        $data = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $data[] = "[$key]";
                foreach ($val as $skey => $sval) {
                    if (is_array($sval)) {
                        foreach ($sval as $_skey => $_sval) {
                            if (is_numeric($_skey)) {
                                $data[] = $skey . '[] = ' . (is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"' . $_sval . '"'));
                            } else {
                                $data[] = $skey . '[' . $_skey . '] = ' . (is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"' . $_sval . '"'));
                            }
                        }
                    } else {
                        $data[] = $skey . ' = ' . (is_numeric($sval) ? $sval : (ctype_upper($sval) ? $sval : '"' . $sval . '"'));
                    }
                }
            } else {
                $data[] = $key . ' = ' . (is_numeric($val) ? $val : (ctype_upper($val) ? $val : '"' . $val . '"'));
            }
            // Linea vacia
            $data[] = null;
        }
        //puntero de archivo abierto, opciones de inicio de lote
        $fp          = fopen($file, 'w');
        $retries     = 0;
        $max_retries = 100;
        if (!$fp) {
            return false;
        }
        // bucle hasta obtener el bloqueo, o alcanzar el máximo de intentos
        do {
            if ($retries > 0) {
                usleep(rand(1, 5000));
            }
            $retries += 1;
        } while (!flock($fp, LOCK_EX) && $retries <= $max_retries);
        //no pude obtener la cerradura
        if ($retries == $max_retries) {
            return false;
        }
        // consiguió bloquear, escribir datos
        fwrite($fp, implode(PHP_EOL, $data) . PHP_EOL);
        // desbloqueo
        flock($fp, LOCK_UN);
        fclose($fp);
        return true;
    }
    //Método para validar sesión
    public function sessionValidator($exc = [])
    {
        //Validar si es una sesión del c
        if (isset($this->getUrl()[1]) && $this->getUrl()[1] == 'cron') {
            //runing crontab...

        } elseif (!empty($exc) && isset($this->getUrl()[1])) {

            foreach ($exc as $key => $value) {
                if ($this->getUrl()[1] == $value) {
                } else {
                    continue;
                }
            }
        } else {
            session_start();
            if (!isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] != 1) {
                redireccionar('');
            } else {
            }
        }
    }

    //Método para el envio de emails usando el controlador Email
    public function emailQuery($datos = [])
    {
        // abrimos la sesión cURL
        $ch = curl_init();
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL, RUTA_URL . SEPARATOR . 'email' . SEPARATOR . "emailAlerta?" . http_build_query($datos));
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        // definimos cada uno de los parámetros
        //curl_setopt($ch, CURLOPT_POSTFIELDS, "id=" . implode(",", $datos));
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        // cerramos la sesión cURL
        curl_close($ch);
        echo $remote_server_output;
    }
    //Protector de controladores principales
    public function adminProtector()
    {
        if (isset($_SESSION['user_type'])) {
            if ($_SESSION["user_type"] != 1 && $_SESSION["user_type"] != 2) {
                return $this->vista('directiva', array(
                    'titulo'   => 'Upps!',
                    'mensaje'  => ' No tiene privilegios suficientes para acceder a ésta funcionalidad.',
                    'problema' => 'su usuario',
                )) . exit();
            }
        }
    }


    //Método para validar acceso a Módulos/plugins
    public function modulesValidator($datos, $plugin = false)
    {
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != 1 &&  $_SESSION['user_type'] != 2) {
            $this->counter = 0;
            foreach ($datos as $key => $value) {
                if ($value->nombre_modulo == ucwords($this->getUrl()[0])) {
                    $this->counter++;
                }
            }
            if ($this->counter == 0)
                $this->vista('directiva', array(
                    'titulo'   => 'Upps!',
                    'mensaje'  => ' No tiene privilegios suficientes para acceder a ésta funcionalidad.',
                    'problema' => 'su usuario',
                )) . exit();
            //$this->adminProtector();
        }
    }
    //Método para verificar estado del plugin
    public function pluginValidator($plugin, bool $comprobar = false)
    {
        if (file_exists(RUTA_PLUGINS . $plugin)) {
            if ($comprobar) {
                $info = parse_ini_file(RUTA_PLUGINS . $plugin . SEPARATOR . 'info.ini', true);
                if ($info["detalles"]["estado"] == "activo") {
                    return true;
                } else {
                    return false;
                }
            } else {
                $info = parse_ini_file(RUTA_PLUGINS . $plugin . SEPARATOR . 'info.ini', true);
                if ($info["detalles"]["estado"] != "activo") {
                    $this->vista('directiva', array(
                        'titulo'   => 'Upps!',
                        'mensaje'  => 'Módulo Inactivo, contacte el administrador',
                        'problema' => 'su módulo ' . $plugin,
                    )) . exit();
                } elseif (isset($_SESSION['user_type'])) {
                    $this->modulesValidator($_SESSION['modulos']);
                }
            }
        } else {
            exit("El plugin que trata de validar no existe, por favor confirme.");
        }
    }
    //Modo mantenimiento
    public function mantMode()
    {
        //print_r($_SESSION);
        if (MANT_MODE) {
            error_reporting(0);
            if ($_SESSION['user_type'] == 99 || isset($_GET['dev']) && $_GET['dev'] == date("Y")) {
            } else {
                $datos = array(
                    'titulo'   => 'Modo mantenimiento',
                    'mensaje'  => NOMBRE_APP . ' se encuentra en mantenimiento',
                    'problema' => 'bajo mantenimiento '
                );
                die(require_once RUTA_APP . SEPARATOR . 'Views' . SEPARATOR . 'mantenimiento.php');
            }
        }
    }
    /**
     * Método que comprueba la existencia de un plugin o si está activo
     * @param string $pluginName
     * Nombre del plugin a buscar
     * @return bool
     */
    public function PluginComprobator($pluginName)
    {
        $plugins = getExistingPlugins(RUTA_PLUGINS);
        $cont = 0;
        foreach ($plugins as $key => $value) {
            if ($pluginName == $value) {
                $cont++;
            }
        }
        if ($cont == 1 && $this->pluginValidator($pluginName, true)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Método que determina si un plugin está en mantenimiento
     * @access public
     * @param string $pluginName
     * @return vista
     */
    public function ModuleMant(string $pluginName)
    {
        error_reporting(0);
        session_start();
        if ($_SESSION['user_type'] == 99 || isset($_GET['dev']) && $_GET['dev'] == date("Y")) {
        } else {
            $ini = parse_ini_file(RUTA_PLUGINS . $pluginName . SEPARATOR . 'info.ini', true);
            if (isset($ini['detalles']['mant_mode']) && $ini['detalles']['mant_mode'] == true) {
                $datos = array(
                    'titulo'   => 'Modo mantenimiento',
                    'mensaje'  => $pluginName . ' se encuentra en mantenimiento',
                    'problema' => 'bajo mantenimiento ',
                    "Name"     => $pluginName,
                );
                return $this->vista("mantenimiento", $datos);
                exit();
                die();
            }
        }
    }
}
