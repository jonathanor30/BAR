<?php

/**
 * This file is part of Bar70
 * 
 *
 */

/**
 * Login controller
 *
 * @author
 * @package Controllers
 */
class Login extends Controller
{
    public $errors   = array();
    public $messages = array();
    private $modeloUsuario;
    public  $writeLog;
    public $defaultModule = 'Productos';
    public function __construct()
    {
        //Así instanciamos los modelos al controlador
        $this->loginModelo   = $this->modelo('Sesion');
        $this->modeloUsuario = $this->modelo('Usuario');
    }

    /**
     * Método index() método por defecto del cotrolador
     * se encarga de mostrar la vista de inicio de sesión.
     * @access public
     * @param array $datos
     */
    public function index()
    {
        session_start();
        if (isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1) {
            redireccionar('/'.$this->defaultModule);
        } else {
            $datos = [
                'titulo' => 'Bar70',
            ];
            //Acá instancio la vista del controlador Login
            $this->vista("Login/Login", $datos, null, true);
        }
    }

    /**
     * Método login()
     * se encarga de gestionar el inicio de sesión en el sistema
     * @access public
     * @param array $datos
     */
    public function login()
    {
        //Si existe datos enviados por el método post
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_name']) && !empty($_POST['user_name']) && isset($_POST['user_password']) && !empty($_POST['user_password'])) {

            //Comprobar campos vacios
            if ($this->valores = $this->formValidator($_POST)) {

                //preparamos los datos en un array en la variable datos.
                $datos = [
                    'titulo'     => 'Login',
                    'usuario'    => trim($_POST["user_name"]),
                    'contrasena' => trim($_POST["user_password"]),
                ];

                //Estructura de control, para iniciar sesión
                switch ($this->loginModelo->loginData($datos)) {
                    case 1:

                        //Traemos datos del usuario
                        $usuario = $this->loginModelo->obtenerUsuario($_POST['user_name']);
                        if (isset($usuario->vigencia) && $usuario->vigencia != "") {
                            if ($usuario->vigencia < date('Y-m-d')) {
                                $this->loginModelo->LockUser($usuario->user_id);
                                $data = array(
                                    'titulo'   => 'Upps!',
                                    'mensaje'  => 'Tu cuenta está suspendida, para seguir disfrutando de Bar70 contáctanos.',
                                    'problema' => 'su usuario'
                                );
                                exit($this->vista('directiva', $data));
                            } else {
                                //Iniciamos la sesión

                                session_start();
                                //Declaramos las variables de sesión
                                $_SESSION['user_id']           = $usuario->user_id;
                                $_SESSION['user_name']         = $usuario->user_name;
                                $_SESSION['user_email']        = $usuario->user_email;
                                $_SESSION['user_login_status'] = 1;
                                $_SESSION['user_type']         = $usuario->user_type;
                                $_SESSION['modulos']           = $this->modeloUsuario->obtenerModulos($usuario->user_id) ?? 'Productos';

                                //Log inicio de sesión
                                $this->writeLog = new LogManager(array(
                                    'tipo'    => 'INFO',
                                    'mensaje' => 'Ha iniciado sesion el usuario ' . $_SESSION['user_name'],
                                ));
                                //Por ultimo redireccionamos a plugins

                                if ($_SESSION['user_type'] != 1) {
                                    if ($_SESSION['modulos'] != false || $_SESSION['modulos'] != null) {
                                        redireccionar('/' . $_SESSION['modulos'][0]->nombre_modulo);
                                    } else {
                                        redireccionar('/Productos');
                                    }
                                } else if ($_SESSION['user_type'] == 1) {
                                    redireccionar('/Productos');
                                }
                            }
                        }

                        break;
                    case 2:
                        //Log inicio de sesión
                        $this->writeLog = new LogManager(array(
                            'tipo'    => 'ERROR',
                            'mensaje' => 'Se ha intentado iniciar sesion con un usuario que no existe (' . $_POST["user_name"] . ')',
                        ));
                        //Redireccionamos de nuevo al formulario y enviamos valor por GET no existe el usuario
                        redireccionar('?no_user');
                        break;
                    case 3:
                        //Log inicio de sesión
                        $this->writeLog = new LogManager(array(
                            'tipo'    => 'ERROR',
                            'mensaje' => 'Se ha intentado iniciar sesion con una contraseña incorrecta',
                        ));
                        //Redireccionamos de nuevo al formulario y enviamos valor por GET la contraseña o el usuario son incorrectos
                        redireccionar('?bad_password');
                        break;
                }
            }
        } else {
            redireccionar('');
        }
    }

    /**
     * Método doLogout()
     * se encarga de cerrar la sesión de usuario en el sistema
     * @access public
     * @param array $_SESSION
     */
    public function doLogout()
    {
        session_start();
        //Log inicio de sesión
        $this->writeLog = new LogManager(array(
            'tipo'    => 'INFO',
            'mensaje' => 'Ha cerrado sesion el usuario ' . $_SESSION['user_name'],
        ));
        // delete the session of the user
        session_unset(); //Una belleza de Php 7.2
        $_SESSION = [];  //empty array. 
        if (session_destroy()) {
            // return a little feeedback message
            redireccionar('?logout');
        }
    }

    /**
     * Método isUserLoggedIn
     * simplemente devuelve el estado actual de inicio de sesión del usuario
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
    /**
     * Método para autentificar ususario en 2 pasos por telegram
     * @access public
     * @return string
     */
    public function Autenticate()
    {
        //Solo entra por POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //si el nombre de usuario y session está definida
            if (isset($_POST['user_name']) &&  isset($_SESSION)) {
                if ($_SESSION['pass' . $_POST['user_name']]) {
                    //si esta definido con mobre unico define variable pasword
                    $password = $_SESSION['pass' . $_POST['user_name']];
                }
            } else if (isset($_POST['user_name']) && !isset($_SESSION)) {
                //De lo contrario crea la variable session con nombre unico
                session_start();
                $_SESSION = array();
                $_SESSION['pass' . $_POST['user_name']] = random_int(100000, 999999);
                $password                     = $_SESSION['pass' . $_POST['user_name']];
            }
            if (isset($_POST['pass'])) {
                //la contraseña viene del segundo ajax
                session_start();
                if (intval($_POST['pass']) == $_SESSION['pass' . $_POST['user']]) {
                    //si la contraseña es correcta
                    echo true;
                    unset($_SESSION['pass' . $_POST['user']]);
                    session_destroy();
                } else {
                    //de lo contrario
                    echo 'Clave dinámica incorrecta';
                    unset($_SESSION['pass' . $_POST['user']]);
                    session_destroy();
                }
            } else {
                //para verificar si el usuario tiene habilitadas las verificaciones
                if (isset($_POST['user_name']) && !empty($_POST['user_name'])) {
                    $datos = [
                        'titulo'     => 'Login',
                        'usuario'    => trim($_POST["user_name"]),
                        'contrasena' => trim($_POST["user_password"]),
                    ];
                    require_once RUTA_APP . SEPARATOR . 'Controllers' . SEPARATOR . 'Email.php';
                    $email = new Email;
                    //validamos que exista ususario
                    if ($this->loginModelo->loginData($datos) == 1) {
                        //si existe verificamos que tenga la clave dinamica habilitada
                        $user = $this->modeloUsuario->obtenerUsuario($_POST['user_name'], 'user_name');
                        if (is_object($user)) {
                            if ($user->telegram_verification == 1) {
                                //mandamos clave a telegram
                                $email->telegramAlert($user->telegram_id, NOMBRE_APP . ' le informa su clave dinámica: ' . $password);
                                echo true . '-verification';
                            } else if ($user->email_verification == 1) {
                                echo true . '-verification';
                                $email->emailVerification($user->user_email, $password, 1);
                            } else {
                                echo true . '-no_verification';
                            }
                        } else {
                            echo 'No es un usuario válido';
                        }
                    } else {
                        echo "Usuario o contraseña incorrectos";
                    }
                }
            }
        } else {
            redireccionar('');
        }
    }
}
