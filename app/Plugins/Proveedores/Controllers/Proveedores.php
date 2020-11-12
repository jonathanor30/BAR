<?php

class Proveedores extends Controller
{

    private $model;
    public  $PluginName;
    public function __construct()
    {
        $this->sessionValidator(); //Validamos sesion
        $this->ProveedorModelo = $this->modelo('Proveedor', 'Proveedores');
        $this->PluginName = 'Proveedores';
        $this->folderCreator($this->PluginName);
        //Directorio de imagenes del plugin
        $this->imgFolder = RUTA_UPLOAD .  $this->PluginName . SEPARATOR . 'img' . SEPARATOR;
    }

    public function index()
    {
        $dataTables = dataTables();
        $datos =  array(
            'titulo' => 'Listado Proveedores',
            'icon'   => 'fas fa-people-carry',
            'dataTables' => $dataTables

        );
        $this->vista('listadoProveedores', $datos, 'Proveedores', true);
    }

    public function VerClientes($id = null)
    {

        $this->pagina404($id);
        $cliente = $this->model->ObtenerUno("IdCliente", $id);
        $datos =  array(
            'titulo' => $cliente->Nombre,
            'Cliente' => $cliente,
        );

        $this->vista('VerClientes', $datos, 'Clientes');
    }

    /**
     * Método files() método para gestionar archivos propios del Plugin
     * se encarga de gestionar y servir archivos para el perfomance.
     */

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
                return $this->filesGTEP($this->PluginName, $_GET['js'], 'js');
            }
            if (isset($_GET['css'])) {
                return $this->filesGTEP($this->PluginName, $_GET['css'], 'css');
            }
        } else {
            $this->pagina404(false);
        }
    }

    public function tableViews()
    {
        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'proveedor';

            //Llave primaria de la tabla
            $primaryKey = 'IdProveedor';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'Nombre', 'dt' => 'Nombre'),
                array('db' => 'Telefono', 'dt' => 'Telefono'),
                array('db' => 'IdProveedor', 'dt' => 'IdProveedor'),

            );

            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
         
                //Retornamos los valores consultados con filtro
                echo json_encode(
                    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, null,)
                );
           
        } else {
            //De lo contrario será redireccionado
            redireccionar('');
        }
    }

    /**
     * Editar
     * (ES) Este método se encarga de editar un producto
     * @access public
     * @return void
     */
    public function Editar()
    {
        //Validar que el método sea accedido mediante POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' &&   $this->formValidator($_POST)) :
            //Ingresa y guarda
            if ($this->model->db->Update($_POST, 'producto', 'IdProducto', intval($_POST['IdProducto']))) {
                echo "true";
            } else {
                echo "false";
            }
        else :
            redireccionar("/");
        endif;
    }

    public function actualizar()
    {
        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $plugin = $_POST['id'];
            $plugin2 = $_POST['type'];
            $datos  = [
                'IdProducto' => $plugin,
                'Estado_P' => $plugin2,
            ];
            //Instancia del moldelo

            switch ($this->model->actualizarProducto($datos)) {
                case 1:
                    echo "true";
                    break;
                case 2:
                    echo "false";
                    break;
            }
        } else {
            redireccionar('/Productos');
        }
    }

    // pendiente
    public function ObtenerTiposDeDocumentos()
    {
         //Validar datos recibido mediante POST
         if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
          echo json_encode($this->model->ObtenerTiposDeProductos(), JSON_PRETTY_PRINT);
        endif;
    }

    public function eliminar()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && !empty($_POST['id'])) :
            if ($this->model->actualizarProducto([], 'update', 'Estado_P', 4, $_POST['id'])) {
                echo "true";
            } else {
                echo "false";
            }
        endif;
    }

    public function agregar()
    {

        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Validacion de posible campo vacio: nombres
            $exc = array();
            $dat = $this->formValidator($_POST, $exc);
            if (is_array($dat)) {
                //Evaluamos si  el usuario a editar es de tipo 3 = afiliado, lo cual debe enviar el valor de vigencia capturado del formulario por metodo post
              
            
                //preparamos los datos en un array en la variable datos.
                $datos = [
                    'Nombre' => $_POST["Nombre"],
                    'Telefono' => $_POST["Telefono"],
                    

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->ProveedorModelo->agregarProveedor($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intenter";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "El Proveedor que quiere registrar ya existe";
                        break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/Proveedores');
        }
    }
}
