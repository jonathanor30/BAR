<?php



class Usuarios extends Controller
{
    public $nombrePlugin;
    public $comprobator; //variable para comprobar sesiones

    public function __construct()
    {
        //Esto debe ir acá en el constructor si quieres proteger el acceso al mismo
        $this->sessionValidator();
        $this->adminProtector(); //Protección
        //Así definimos el nombre del plugin en el controlador
        $this->nombrePlugin = __CLASS__;

        //Así instanciamos los modelos al controlador
        $this->usuarioModelo = $this->modelo('Usuario', $this->nombrePlugin);
    }



    /**
     * Método index() método por defecto del cotrolador
     * se encarga de mostrar la vista del listado de usuarios.
     * @access public
     * @param array $datos
     */
    public function index()
    {
        //Así se instancia un metodo del modelo que ha sido instanciado previamente en el constructor
        //Obtener los usuarios
        $usuarios = $this->usuarioModelo->obtenerUsuarios();

        //Obtener recuros para visualizar registros en DataTables
        $dataTables = dataTables();

        //Para paasar o mostrar datos a la vista, usa la variable $datos, que es de tipo array
        //para cuando definas la vista tambien pasese los datos involucrados en la variable $datos
        //Ejmplo: $this->vista("Paginas/usuarios", $datos);
        $datos = [
            'titulo'     => 'Usuarios',       //Titulo de la pagina
            'usuarios'   => $usuarios,        //Aśi pasamos datos del controlador a la vista
            'icon'       => "fas fa-users",
            'dataTables' => $dataTables,

        ];

        //Así cargamos la vista del controlador presente
        $this->vista("Usuarios/ListUsuarios", $datos, $this->nombrePlugin);
    }


    public function Perfilactual($id = null)
    {
        
        $this->pagina404($id);
        $perfil = $this->usuarioModelo->obtenerperfil("user_id", $id);
        $datos =  array(
            'titulo' => 'Perfil',
            'icon'       => "fas fa-users",
            'perfil' => $perfil,
        );

        $this->vista("Configuracion/Perfil", $datos, null, true); 
    }

    /**
     * Método index() método por defecto del cotrolador
     * se encarga de agregar un nuevo usuario a la base de datos
     * @access public
     * @param array $datos
     */
    public function agregar()
    {

        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Validacion de posible campo vacio: nombres
            $exc = array();
            $dat = $this->formValidator($_POST, $exc);
            if (is_array($dat)) {
                //Evaluamos si  el usuario a editar es de tipo 3 = afiliado, lo cual debe enviar el valor de vigencia capturado del formulario por metodo post
               
                $user_password = $_POST['user_password_new'];

                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
                //preparamos los datos en un array en la variable datos.
                $datos = [
                    'firstname'          => $_POST["firstname"],
                    'lastname'           => $_POST["lastname"],
                    'user_name'          => $_POST["user_name"],
                    'user_email'         => $_POST["user_email"],
                    'user_password_hash' => $user_password_hash,
                    'user_type'          => $_POST["user_type"],
                    'user_status'        => $_POST["estado"],
                    'date_added'         => date("Y-m-d H:i:s"),
                    'IdTipoDocumento'    => $_POST["IdTipoDocumento"],
                    'Numero_Documento'   => $_POST["Numero_Documento"],

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->usuarioModelo->agregarUsuario($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intentar";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "El usuario que quiere registrar ya existe";
                        break;
                    case 4:
                        echo "El correo que ingreso ya se encuentra vinculado a un usuario";
                        break;
                    case 5:
                        echo "El documento de identidad ingresado ya se encuentra vinculado a  un usuario";
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

    /**
     * Método index() método por defecto del cotrolador
     * se encarga de  editar usuario.
     * @access public
     * @param array $datos
     */
    public function editar($id = null)
    {
        if (!isset($id) && $id == null) {
            //Redireccionamos a usuarios
            exit(redireccionar('/usuarios'));
        }

        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exceptions = array('estado');

            //Validar campos del formulario
            if ($this->formValidator($_POST, $exceptions)) {

                //Evaluamos si  el usuario a editar es de tipo 3 = afiliado, lo cual debe enviar el valor de vigencia capturado del formulario por metodo post
              

                $user_password = $_POST['user_password_new'];

                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                $id_set = $id;
                //preparamos los datos en un array en la variable datos.
                $datos = [
                    'user_id'            => $id_set,
                    'firstname'          => $_POST["firstname"],
                    'lastname'           => $_POST["lastname"],
                    'user_name'          => $_POST["user_name"],
                    'user_email'         => $_POST["user_email"],
                    'user_password_hash' => $user_password_hash,
                    'user_type'          => $_POST["user_type"],
                    'user_status'        => $_POST["estado"], 
                    'Numero_Documento'   => $_POST["Numero_Documento"], 
                ];
                //Estructura de control, para evaluar el query de agregar usuarios
                switch ($this->usuarioModelo->editarUsuario($datos)) {
                    case 1:
                        //Usuario editado correctamente
                        echo "true";
                        //$_POST = array();

                        break;
                    case 2:
                        //error
                        echo "Hubo un error al guardar el registro, por favor vuelva a intentar";
                        break;
                        case 3:
                            //Redireccionamos a usuarios
                            echo "El usuario que quiere registrar ya existe";
                            break;
                        case 4:
                            echo "El correo que ingreso ya se encuentra vinculado a un usuario";
                            break;
                        case 5:
                            echo "El documento de identidad ingresado ya se encuentra vinculado a  un usuario";
                        break;
                        case 6:
                            echo "su contraseña debe tener minimo 1 letra mayuscula y 1 numero";
                        break;
                        case 7:
                            echo "su contraseña debe ser mayor o igual a 8 digitos";
                        break;
                        case 8:
                            echo "el nombre de usuario debe ser mayor o igual a 6 caracteres";
                        break;
                        case 9:
                            echo "no puede ingresar caracteres especiales";
                        break;
                }
            }
        } else {
            //Obtenemos usaurio
            $usuario = $this->usuarioModelo->obtenerUsuario($id);
            $modulos = $this->usuarioModelo->obtenerModulos($id);

            //Comprobador 404
            $this->pagina404($usuario);

            $datos = [
                'titulo'            => 'Editar Usuario',   //Titulo de la pagina
                'usuario'           => $usuario,           //Aśi pasamos datos del controlador a la vista
                'icon'              => "fas fa-users",
                'modulos_asignados' => $modulos,

            ];

            //Así cargamos la vista
            $this->vista('Usuarios/EditarUsuario', $datos);
        }
    }
    //Método para asignar Módulos a los usuarios
    public function asignarModulos($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->usuarioModelo->validarModulo(array(
                'nombre_modulo' => $_POST['id'],
                'user_id'       => $id
            ))) {
                echo "false";
            } else {
                if ($this->usuarioModelo->asignarModulo(array(
                    'nombre_modulo'     => $_POST['id'],
                    'user_id'           => $id,
                    'user_id_asignador' => $_SESSION['user_id'],

                ))) {
                    $_POST = array();
                    echo "true";
                }
            }
        } else {
            redireccionar('');
        }
    }

    //Métodos para deshabilitar Módulos a los usuarios
    public function quitarModulos($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->usuarioModelo->eliminarModulo(array(
                'nombre_modulo' => $_POST['id'],
                'user_id'       => $id,
            ))) {
                $_POST = array();
                //Eliminado correctamente
                echo "true";
            } else {
                //error al eliminar módulo
                echo "false";
            }
        } else {
            redireccionar('');
        }
    }

    /**
     * Método borrar()
     * se encarga de  eliminar usuario.
     * @access public
     * @param array $datos
     */
    public function borrar()
    {
        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $plugin = $_POST['id'];
            $datos  = [
                'user_id' => $plugin,
            ];
            //Instancia del moldelo
            if (intval($_POST['type']) != 99) {
                switch ($this->usuarioModelo->borrarUsuario($datos)) {
                    case 1:
                        echo "true";
                        break;
                    case 2:
                        echo "false";
                        break;
                }
            } else {
                echo "Este tipo de usuario no se puede eliminar";
            }
        } else {
            redireccionar('/Usuarios');
        }
    }

    public function autocompletarUsuario()
    {
        if (isset($_GET['term'])) {
            $dato  = array();
            $datos = [
                'term'      => $_GET['term'],
                'user_id'   => $_SESSION['user_id'],
                'user_type' => $_SESSION['user_type'],
            ];

            //Consultamos registros
            $rows = $this->usuarioModelo->autocompletarUsuarios($datos);
            /* Recuperar y almacenar en matriz los resultados de la consulta.*/
            foreach ($rows as $key => $value) {
                $dato[] = array(
                    'user_id'    => $value['user_id'],
                    'value'      => $value['user_name'],    //Busqueda
                    'user_type'  => $value['user_type'],
                    'firstname'  => $value['firstname'],
                    'lastname'   => $value['lastname'],
                    'user_name'  => $value['user_name'],
                    'user_email' => $value['user_email'],
                    'IdTipoDocumento'    => $_POST["IdTipoDocumento"],
                    'Numero_Documento'   => $_POST["Numero_Documento"],
                );
            }

            echo json_encode($dato);
        } else {
            redireccionar('');
        }
    }

    public function tableViews()
    {
        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'users';

            //Llave primaria de la tabla
            $primaryKey = 'user_id';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'user_name', 'dt' => 'user_name'),
                array('db' => 'firstname', 'dt' => 'firstname'),
                array('db' => 'user_email', 'dt' => 'user_email'),
                array('db' => 'user_type', 'dt' => 'user_type'),
                array('db' => 'estado_usuario', 'dt' => 'estado_usuario'),
                array('db' => 'user_id', 'dt' => 'user_id'),
                array('db' => 'IdTipoDocumento', 'dt' => 'IdTipoDocumento'),
                array('db' => 'Numero_Documento', 'dt' => 'Numero_Documento'),
               
            );

            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                switch ($_POST['id']) {
                    case 1:
                        $where = "estado_usuario ='1'";
                        break;
                    case 2:
                        $where = "estado_usuario ='2'";
                        break;
                    case 3:
                        $where = "estado_usuario ='0'";
                        break;
                }

                //Retornamos los valores consultados con filtro
                echo json_encode(
                    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where)
                );
            } else {

                //Retornamos los valores consultados si filtro
                echo json_encode(
                    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)
                );
            }
        } else {
            //De lo contrario será redireccionado
            redireccionar('');
        }
    }
    public function contratosAsignados()
    {
        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'contratos_asignados';

            //Llave primaria de la tabla
            $primaryKey = 'id_contrato_asignado';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.
            $columns = array(
                array('db' => 'numero_contrato', 'dt' => 'numero_contrato'),
                array('db' => 'fecha_inicial', 'dt' => 'fecha_inicial'),
                array('db' => 'fecha_final', 'dt' => 'fecha_final'),
                array('db' => 'objeto_contrato', 'dt' => 'objeto_contrato'),
                array('db' => 'contratante', 'dt' => 'contratante'),
                array('db' => 'nit_contratante', 'dt' => 'nit_contratante'),
                array('db' => 'responsable', 'dt' => 'responsable'),
                array('db' => 'nit_responsable', 'dt' => 'nit_responsable'),
                array('db' => 'telefono_responsable', 'dt' => 'telefono_responsable'),
                array('db' => 'estado_contrato', 'dt' => 'estado_contrato'),
                array('db' => 'id_contrato_asignado', 'dt' => 'id_contrato_asignado'),

            );

            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $where = "user_id={$_POST['id']}";

                //Retornamos los valores consultados con filtro
                echo json_encode(SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where));
            } else {

                //Retornamos los valores consultados si filtro
                echo json_encode(
                    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)
                );
            }
        } else {
            //De lo contrario será redireccionado
            redireccionar('');
        }
    }
    
    
    

    

    
    //Metodo disfuncional para asignar datos aun usuario
    /* public function datosUsuario($id)
    {
        if (isset($id) && !empty($id)) {

            //Usuario
            $usuario = $this->usuarioModelo->obtenerUsuario($id);
            //verificación de usuario
            $this->pagina404($usuario);

            //variable datos para la vista del presente método
            $datos = [
                'titulo'     => 'Datos ' . $usuario->user_name,
                'usuario'    => $usuario,
                'dataTables' => dataTables(),

            ];
            //Vista método datosUsuario
            $this->vista('Usuarios/DatosUsuario', $datos);

        } else {
            redireccionar('');
        }
    }*/

    //Método para manejar arhcivos
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
                //Personalizado
                return $this->filesGTEP('Assets' . SEPARATOR . $this->nombrePlugin, $_GET['js'], 'js', 'Assets');
            }
            if (isset($_GET['css'])) {
                return $this->filesGTEP($this->nombrePlugin, $_GET['css'], 'css');
            }
        } else {
            $this->pagina404(false);
        }
    }

    public function editar2($id = null)
    {
        if (!isset($id) && $id == null) {
            //Redireccionamos a usuarios
            exit(redireccionar('/usuarios'));
        }

        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exceptions = array('estado');

            //Validar campos del formulario
            if ($this->formValidator($_POST, $exceptions)) {

                //Evaluamos si  el usuario a editar es de tipo 3 = afiliado, lo cual debe enviar el valor de vigencia capturado del formulario por metodo post
              
                $id_set = $id;
                //preparamos los datos en un array en la variable datos.
                $datos = [
                    'user_id'            => $id_set,
                    'user_status'        => $_POST["estado"],   
                ];
                //Estructura de control, para evaluar el query de agregar usuarios
                switch ($this->usuarioModelo->editarUsuario2($datos)) {
                    case 1:
                        //Usuario editado correctamente
                        echo "true";
                        //$_POST = array();

                        break;
                    case 2:
                        //error
                        echo "Hubo un error al guardar el registro, por favor vuelva a intentar";
                        break;
                    case 3:
                        //error
                        echo "El usuario que quiere renombrar ya existe";
                        break;
                }
            }
        } else {
            //Obtenemos usaurio
            $usuario = $this->usuarioModelo->obtenerUsuario($id);
            $modulos = $this->usuarioModelo->obtenerModulos($id);

            //Comprobador 404
            $this->pagina404($usuario);

            $datos = [
                'titulo'            => 'Editar Usuario',   //Titulo de la pagina
                'usuario'           => $usuario,           //Aśi pasamos datos del controlador a la vista
                'icon'              => "fas fa-users",
                'modulos_asignados' => $modulos,

            ];

            //Así cargamos la vista
            $this->vista('Usuarios/EditarUsuario', $datos);
        }
    }
}
