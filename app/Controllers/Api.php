<?php

/**
 * Api class
 * 
 * Codificacion de mensajes segun RFC-822
 * Utiliza la especificacion mime
 * Permite enviar ficheros adjuntos utilizando
 * Permite el envio a multiples destinatarios
 * Formato JSON = RFC 8259
 *
 * @author Juan Bautista
 * @author http://mygtep.com
 *
 * @package @myGTEP
 */
class Api extends Controller
{

    public $info_api;
    public $rest;
    public $_allow = array();
    public $_content_type = "application/json; charset=utf-8";
    public $_request = array();
    public $requireds;

    private $_method = "";
    private $_code = 200;
    public  $apiModel;
    public  $result;
    public  $api_info;
    public  $api_ini;
    public  $scheme;
    public  $counter;
    public  $write_api;
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        $this->write_api = false;
        $this->counter = count($this->getUrl());
        $this->apiModel = $this->modelo('ApiModel');
        $this->inputs();
        //print_r($this->inputs());
        $this->api_info = $this->apiInfo();
        $this->scheme = $this->apiModel->scheme();
        array_push($this->scheme, 'required');
        $this->authentication();

        switch (intval($this->counter)) {
            case 3:
                $this->RequestWizard($this->getUrl()[1], $this->getUrl()[2]);
                break;
            case 2:
                $this->RequestWizard($this->getUrl()[1]);
                break;
        }
    }

    /**
     * Método por defecto del controlador API.
     */
    public function index()
    {
    }

    /**
     * Asistente de peticiones, se encarga de gestionar las solicitudes a la API.
     *
     * @return array en formato JSON
     * @param string $method método o recurso solicitado
     * @param string $param identificador del recurso
     */
    public function RequestWizard($method, $param = false)
    {
        switch ($this->get_request_method()) {
                //Solicitu por GET
            case 'GET':
                //Validar si existe el recurso
                if ($this->methodValidate($method)) {
                    //Validar si estan solicitando un registro en especifico
                    if ($param != false) {

                        if ($method == 'required') {
                            $data = $this->apiModel->getRequired(array(
                                'table' => $param
                            ));
                            $this->requireds = array('required' => array());
                            //Validación del resultado del query
                            if ($data) {
                                //Iteración para enriquecer el arreglo a retornar
                                foreach ($data as $key) {
                                    array_push($this->requireds['required'], $key);
                                }
                                //Resgistra de solicitud mediante API_LOG()
                                $this->API_LOGS('Solicitud de lectura de los campos requeridos de la tabla ' . $param . ' mediante API REST', 'INFO');
                                //Respuesta en en formato JSON y código de la transferencia
                                $this->response($this->json($this->requireds), 200);
                            } else {
                                //404
                                exit($this->response('', 404));
                            }
                        } else {
                            //Query con filtro por llave primaria
                            $data = $this->apiModel->GET_ALL(array(
                                "table" => $method,
                                "where" => "WHERE {$this->apiModel->getPrimaryKey($method)}='{$param}' "
                            ));
                            //Validación del resultado del query
                            if ($data) {
                                //Iteración para enriquecer el arreglo a retornar
                                foreach ($data as $key => $value) {
                                    $this->result[] = $data;
                                }
                                //Resgistra de solicitud mediante API_LOG()
                                $this->API_LOGS('Solicitud de lectura del id ' . $param . ' de la tabla ' . $method . ' mediante API REST', 'INFO');
                                //Respuesta en en formato JSON y código de la transferencia
                                $this->response($this->json($data), 200);
                            } else {
                                //404
                                exit($this->response('', 404));
                            }
                        }
                    } else {
                        if ($method != "required") {
                            //Query para trear todos los registros
                            $data = $this->apiModel->GET_ALL(array(
                                'table' => $method
                            ));
                            //Validar el resultado del query
                            if ($data) {
                                //Iteración para enriquecer el arreglo a retornar
                                foreach ($data as $key => $value) {
                                    $this->result[] = $data;
                                }
                                //Resgistra de solicitud mediante API_LOG()
                                $this->API_LOGS('Solicitud de lectura de la tabla ' . $method . ' mediante API REST', 'INFO');
                                //Respuesta en en formato JSON y código de la transferencia
                                $this->response($this->json($data), 200); // send user details
                            } else {
                                //404
                                exit($this->response('', 404));
                            }
                        } else {
                            //404
                            exit($this->response('', 404));
                        }
                    }
                } else {
                    //404
                    exit($this->response('', 404));
                }
                break;
                //Solicitud por POST
            case 'POST':
                //El tipo de cabecera que se debe usar el clientes para este caso es:
                //application/x-www-form-urlencoded
                if ($this->methodValidate($method)) {
                    //Se crear la  variable para identificar el recurso
                    $_POST['table'] = $method;
                    //Query para crear registro
                    $data =  $this->apiModel->POST($_POST);
                    //Validar el resultado del query
                    if ($data === "success") {
                        //Registro creado
                        exit($this->response('', 201));
                    } else {

                        //Error al crear el registro
                        $this->response($this->json($data), 406);
                    }
                } else {
                    //404
                    exit($this->response('', 404));
                }
                break;
                //Solicitud por PUT
            case 'PUT':
                //Manejador de errores

                //El tipo de cabecera que se debe usar el clientes para este caso es:
                //application/x-www-form-urlencoded
                parse_str(file_get_contents("php://input"), $_PUT);
                if ($this->methodValidate($method)) {
                    if ($param != false) {
                        //Se crear la  variable para identificar el recurso
                        $_PUT['table'] = $method;
                        //Query para crear registro
                        $data =  $this->apiModel->PUT($_PUT);
                        //Validar el resultado del query
                        if ($data === "success") {

                            //Registro editado
                            exit($this->response('', 201));
                        } else {

                            //Error al crear el registro
                            $this->response($this->json($data), 406);
                        }
                    } else {
                        $this->response($this->json(array('message' => 'Debe definir un parametro para ser gestionado')), 406);
                    }
                } else {
                    //404
                    exit($this->response('', 404));
                }


                break;
                //Solicitud por DELETE
            case 'DELETE':
                parse_str(file_get_contents("php://input"), $_DELETE);
                if ($this->methodValidate($method)) {
                    if ($param != false) {
                        //Se crear la  variable para identificar el recurso
                        $_DELETE['table'] = $method;
                        $_DELETE['id']    = $param;
                        //Query para eliminar registro
                        $data =  $this->apiModel->DELETE($_DELETE);
                        //Validar el resultado del query
                        if ($data == "success") {
                            //Registro editado
                            exit($this->response('', 200));
                        } else {
                            //Error al eliminar registro
                            $this->response($this->json($data), 406);
                        }
                    } else {
                        $this->response($this->json(array('message' => 'Debe definir un parametro para ser gestionado')), 406);
                    }
                } else {
                    //404
                    exit($this->response('', 404));
                }
                break;
        }
    }
    /**
     * Registra todos los eventos de solicitudes a la API, mediante
     * el LogManager de myGTEP.
     *
     * @param string $message contiene el mensaje a registrar
     * @param string $type define el tipo de registro almacenar
     */
    public function API_LOGS($message, $type)
    {
        if ($this->write_api != false) {
            //Escribir novedades en el LogManager
            $this->writeLog = new LogManager(array(
                'tipo'    => $type,
                'mensaje' => $message,
            ));
        }
    }

    /**
     * Muestra mensaje public con la información de estado de la API.
     *
     * @return array En formato JSON con la información y estado del servicio
     */
    public function info()
    {
        //Datos de la API
        /* $this->info_api = [

            'API-VERSION' => VERSION,
            'APP'         => NOMBRE_APP,
            'Status'      => strtoupper($this->ApiStatus()),

        ];
        header('Content-Type: application/json');
        //echo json_format($this->succes);
        echo json_encode($this->info_api, JSON_PRETTY_PRINT);*/
        $datos = [
            'titulo' => 'API ' . NOMBRE_APP,
            ''
        ];
        $this->vista('Api/info', $datos);
    }


    /**
     * Valida si el recurso solicitado existe en el esquema de la base de datos.
     *
     * @return boolean true si la direccion es correcta.
     * @param string $method nombre del recurso solicitado.
     */
    public function methodValidate($method)
    {
        $this->counter = 0;
        foreach ($this->scheme as $key => $value) {
            if ($value == $method) {
                $this->counter++;
            }
        }

        if ($this->counter > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Gestionar el proceso y método de autenticación a la API.
     */
    public function authentication()
    {
        switch ($this->get_request_method()) {
                //Autenticacion por GET
            case 'GET':
                if (isset($_GET['api_key'])) {
                    if ($this->keyValidate($_GET['api_key'])) {
                        //Permitido el flujo de ejecución
                    } else {
                        $this->API_LOGS('Autenticacion de API fallida, mediante GET', 'DANGER');
                        exit($this->response('', 406));
                    }
                } else {
                    if ($this->is_a_call_to_resource()) {
                        $this->info();
                    } else {
                        $this->API_LOGS('Solicitud sin autenticacion GET mediante API REST', 'DANGER');

                        exit($this->response($this->json(array('result' => 'No existe un valor para la llave de autenticacion')), 404));
                    }
                }
                break;
                //Autenticacion por POST
            case 'POST':
                if (isset($_POST['api_key'])) {
                    if ($this->keyValidate($_POST['api_key'])) {
                        //Permitido el flujo de ejecución 
                    } else {
                        $this->API_LOGS('Autenticacion de API fallida, mediante POST', 'DANGER');
                        exit($this->response('', 406));
                    }
                } else {
                    if ($this->is_a_call_to_resource()) {
                        $this->info();
                    } else {
                        $this->API_LOGS('Solicitud sin autenticacion POST mediante API REST', 'DANGER');
                        exit($this->response($this->json(array('result' => 'No existe un valor para la llave de autenticacion')), 404));
                    }
                }
                break;
                //Autenticacion por PUT
            case 'PUT':
                parse_str(file_get_contents("php://input"), $_PUT);

                if (isset($_PUT['api_key'])) {
                    if ($this->keyValidate($_PUT['api_key'])) {
                        //Permitido el flujo de ejecución
                    } else {
                        $this->API_LOGS('Solicitud sin autenticacion PUT mediante API REST', 'DANGER');
                        exit($this->response('', 406));
                    }
                } else {
                    if ($this->is_a_call_to_resource()) {
                        $this->info();
                    } else {
                        $this->API_LOGS('Solicitud sin autenticacion PUT mediante API REST', 'DANGER');
                        exit($this->response($this->json(array('result' => 'No existe un valor para la llave de autenticacion')), 404));
                    }
                }
                break;
                //Autenticacion por DELETE
            case 'DELETE':
                parse_str(file_get_contents("php://input"), $_DELETE);

                if (isset($_DELETE['api_key'])) {
                    if ($this->keyValidate($_DELETE['api_key'])) {
                        //Permitido el flujo de ejecución
                    } else {
                        if ($this->is_a_call_to_resource()) {
                            $this->info();
                        } else {
                            $this->API_LOGS('Solicitud sin autenticacion DELETE', 'DANGER');
                            exit($this->response($this->json(array('result' => 'No existe un valor para la llave de autenticacion')), 404));
                        }
                    }
                } else {
                    if ($this->is_a_call_to_resource()) {
                        $this->info();
                    } else {
                        $this->API_LOGS('Solicitud sin autenticacion DELETE', 'DANGER');
                        exit($this->response($this->json(array('result' => 'No existe un valor para la llave de autenticacion')), 404));
                    }
                }
                break;
        }
    }


    /**
     * Verifica si una direccion de correo es correcta o no.
     *
     * @return boolean true si la llave del API es autentica.
     * @param string $keyClient llave de la API.
     */
    public function keyValidate($keyClient)
    {
        if ($keyClient == $this->api_info['detalles']['apiKey']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permite visualizar los valores de las solicitudes personalizadas.
     *
     * @return array con los datos enviados en las cabeceras.
     */
    public function CUSTOM_REQUEST()
    {
        switch ($this->get_request_method()) {
                //Datos enviado por GET
            case 'GET':
                return $_GET;
                break;
                //Datos enviado por POST
            case 'POST':
                return $_POST;
                break;
                //Datos enviado por PUT
            case 'PUT':
                parse_str(file_get_contents("php://input"), $_PUT);
                return $_PUT;
                break;
                //Datos enviado por UPDATE
            case 'UPDATE':
                parse_str(file_get_contents("php://input"), $_UPDATE);
                return $_UPDATE;
                break;
                //Datos enviado por DELETE
            case 'DELETE':
                parse_str(file_get_contents("php://input"), $_DELETE);
                return $_DELETE;
                break;
        }
    }

    /**
     * Método para obtener informacion de la configuracion de la API.
     *
     * @return array con la información de la API.
     */
    public function apiInfo()
    {
        if (file_exists(RUTA_APP . SEPARATOR . 'Config' . SEPARATOR . 'Api.ini')) {
            $api_ini = parse_ini_file(RUTA_APP . SEPARATOR . 'Config' . SEPARATOR . 'Api.ini', true);
            return $api_ini;
        } else {

            exit($this->response('', 404));
        }
    }

    /**
     * Se encarga de consultar el estado de la API.
     *
     * @return string Con el estado de la API.
     */
    public function ApiStatus()
    {
        return $this->api_info['detalles']['estado'];
    }
    /**
     * Verificar si se esta mandando a llamar un recurso.
     *
     * @return boolean true si se esta mandando a llamar a un recurso.
     */
    public function is_a_call_to_resource()
    {
        if (count($this->getUrl()) == 1) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * obtiene la pagina o host que emplea el agente de usuario en la petición a la API.
     * @return string con la referencia de host.
     */
    public function get_referer()
    {
        return $_SERVER['HTTP_REFERER'];
    }
    /**
     * Se encarga de dar respuesta a cada solicitud que se hace a la API.
     * @param array $data Contiene la respuesta en una matriz JSON.
     * @param int   $status  El código de respuesta.
     */
    public function response($data, $status)
    {
        $this->_code = ($status) ? $status : 200;
        $this->set_headers();
        echo $data;
        exit;
    }
    /**
     * Obtiene el estado del mensaje.
     * @return int $status  El código de respuesta.
     */
    private function get_status_message()
    {
        $status = array(
            200 => 'OK',
            201 => 'Created',
            204 => 'No Content',
            404 => 'Not Found',
            406 => 'Not Acceptable'
        );
        return ($status[$this->_code]) ? $status[$this->_code] : $status[500];
    }

    /**
     * Obtiene el tipo de método empleado para la petición hacía la API.
     * @return string $_SERVER['REQUEST_METHOD'] El método usado por el cliente.
     */
    public function get_request_method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    /**
     * Obtiene las entradas.
     * @return string $_SERVER['REQUEST_METHOD'] El método usado por el cliente.
     */
    private function inputs()
    {
        switch ($this->get_request_method()) {
            case "POST":
                $this->_request = $this->cleanInputs($_POST);
                break;
            case "GET":
                break;
            case "DELETE":
                $this->_request = $this->cleanInputs($_GET);
                break;
            case "PUT":
                //parse_str(file_get_contents("php://input"), $_PUT);
                //$this->_request = $this->cleanInputs($_PUT);
                break;
            default:
                $this->response('', 406);
                break;
        }
    }

    /**
     * Limpia todas las entradas recibidas
     *
     * @return array vacio
     * @param array $data
     */
    private function cleanInputs($data)
    {
        $clean_input = array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->cleanInputs($v);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $clean_input = trim($data);
        }
        return $clean_input;
    }
    /**
     * Defini los valores de la cabecera para las respuestas de la API.
     */
    private function set_headers()
    {
        header("HTTP/1.1 " . $this->_code . " " . $this->get_status_message());
        header("Content-Type:" . $this->_content_type);
    }

    /** 
     *	Encode array into JSON
     */
    private function json($data)
    {
        if (is_array($data)) {
            header("Content-Type:" . $this->_content_type);
            return json_encode($data, JSON_PRETTY_PRINT);
        }
    }
}
