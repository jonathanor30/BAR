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
    public $defaultModule = 'Clientes';
    public function __construct()
    {
        //Así instanciamos los modelos al controlador
        //Así instanciamos los modelos al controlador
        $this->loginModelo   = $this->modelo('Sesion');
        $this->modeloUsuario = $this->modelo('Usuario');
        $this->PluginName  = 'Login';
    }

    /**
     * Método index() método por defecto del cotrolador
     * se encarga de mostrar la vista de inicio de sesión.
     * @access public
     * @param array $datos
     */
    public function index($id = 1)
    {
        session_start();
        if (isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1) {
            redireccionar('/' . $this->defaultModule);
        } else {
            $home = $this->modeloUsuario->ObtenerUno("IdHome", $id);
            $datos =  array(
                'titulo' => 'home',
                'home' => $home,
            );
            //Acá instancio la vista del controlador Login
            $this->vista("Login/inicio", $datos, null, true);
        }
    }
    public function home()
    {
        $datos = [
            'titulo' => 'Bar70',
        ];
        $this->vista("Login/login", $datos, null, true);
    }
    public function Obtenerdatos()
    {
        //Validar datos recibido mediante POST
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            header('Content-Type: application/json');
            echo json_encode($this->Modelo->Obtenerdatos(), JSON_PRETTY_PRINT);
        endif;
    }

    public function files()
    {
        if (isset($_GET['img']) || isset($_GET['js']) || isset($_GET['css']) || isset($_GET['pdf'])) {
            if (isset($_GET['img'])) {
                return $this->filesGTEP($_GET['img'], false, 'img');
            }
            if (isset($_GET['pdf'])) {
                return $this->filesGTEP($_GET['pdf'], false, 'pdf');
            }
            if (isset($_GET['js'])) {
                return $this->filesGTEP($this->PluginName, $_GET['js'], 'js');
            }
            if (isset($_GET['css'])) {
                return $this->filesGTEP($this->PluginName, $_GET['css'], 'css');
            }
        } else {
            $this->pagina404(false);
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
                        if (isset($usuario->estado_usuario) && $usuario->estado_usuario != 2) {
                            if ($usuario->estado_usuario == 1) {
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
                                        redireccionar('/Clientes');
                                    }
                                } else if ($_SESSION['user_type'] == 1) {
                                    redireccionar('/Clientes');
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
                            if ($user->estado_usuario == 1) {
                                echo true . '-no_verification';
                            } else {
                                echo 'El usuario esta inhabilitado';
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

    public function recover()
    {
        $this->vista('Login/recover', 'Recuperar Contraseña', null, false);
    }

    public function Password()
    {
        $this->vista('Login/newPassword', 'Cambiar Contraseña', null, false);
    }

    public function template()
    {
        $this->vista('Login/template', '', null, false);
    }

    public function Expiracion()
    {
        $this->vista('Login/PaginaExpiracion', '', null, false);
    }

    public function sendRecoveryCode()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Validacion de posible campo vacio: nombres
   
            $dat = $this->formValidator($_POST);
            if (is_array($dat)) {
                //preparamos los datos en un array en la variable datos.
                $datos = [
                    
                    'txtCorreoElectronico' => $_POST["txtCorreoElectronico"],
                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->modeloUsuario->recuperarpass($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "El correo no existe";
                        break;
                    case 3:
                        echo "no funciono sorry";
                    break;
                    case 4:
                        echo "no esta vacio";
                    break;
                    case 5:
                        echo "si esta vacio";
                        case 6:
                            echo "si esta vacio 2";
                        break;
                            case 7:
                                echo "no esta vacio 2";
                            break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/usuarios');
        }
    }

    public function createRandomCode()
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;
    
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
    
        return time().$pass;
    }
 
    public function updatePasswordWithCode()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Validacion de posible campo vacio: nombres
   
            $dat = $this->formValidator($_POST);
            if (is_array($dat)) {
                //preparamos los datos en un array en la variable datos.
                $datos = [
                    'token' => $_POST["token"],
                    'txtContrasena' => $_POST["txtContrasena"],
                    'txtRepetirContrasena' => $_POST["txtRepetirContrasena"],

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->modeloUsuario->cambiarcontraseña($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "las contraseñas no coinciden";
                        break;
                    case 3:
                        echo "la contraseña debe contener 1 mayuscula y 1 numero";
                    break;
                    case 4:
                        echo "debe ser mayor o igual a 8 caracteres";
                    break;
                    case 5:
                        echo "hubo un error";
                    break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/usuarios');
        }
    }
    
    public function autovalidacion(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Validacion de posible campo vacio: nombres
   
           
                //preparamos los datos en un array en la variable datos.
               
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->modeloUsuario->autovalidacion($_POST['token'])) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                            echo "no funciono";
                    break;
                    case 3:
                        echo false;
                    break;
                
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } 
       
    

}
