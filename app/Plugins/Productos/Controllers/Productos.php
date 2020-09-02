<?php 

class Productos extends Controller
{

    private $model;
    public  $PluginName;
    public function __construct()
    {
        $this->sessionValidator(); //Validamos sesion
        $this->model = $this->modelo('Producto', 'Productos');
        $this->PluginName = 'Productos';
    }

    public function index()
    {
        $dataTables = dataTables(); 
        $datos =  array(
            'titulo' => 'Listado Productos',
            'icon'   => 'fas fa-boxes',
            'dataTables' => $dataTables
           
        );
       $this->vista('ListadoProductos',$datos, 'Productos', true);

    }

    public function VerProducto($id = null)
    {
        $this->pagina404($id);
        $datos =  array(
            'titulo' => 'Producto Garrafa de aguardiente',
            'producto'=> $this->model->ObtenerUno("IdProducto", $id),
        );
       $this->vista('VerProducto',$datos, 'Productos');
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
                return $this->filesGTEP($this->PluginName, $_GET['img'], 'img');
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
            $table = 'producto';

            //Llave primaria de la tabla
            $primaryKey = 'IdProducto';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'CodigoProducto', 'dt' => 'CodigoProducto'),
                array('db' => 'NombreProducto', 'dt' => 'NombreProducto'),
                array('db' => 'PrecioSugerido', 'dt' => 'PrecioSugerido'),
                array('db' => 'Estado_P', 'dt' => 'Estado_P'),
                array('db' => 'Existencias', 'dt' => 'Existencias'),
                array('db' => 'IdProducto', 'dt' => 'IdProducto'),

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
                        $where = "Estado_P ='1'";
                        break;
                    case 2:
                        $where = "Estado_P ='2'";
                        break;
                    case 3:
                        $where = "Estado_P ='0'";
                        break;
                }

                //Retornamos los valores consultados con filtro
                echo json_encode(
                    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where)
                );
            } else {
                $where = "Estado_P !='4'";
                //Retornamos los valores consultados si filtro
                /*echo json_encode(
                    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)
                );*/
                echo json_encode(
                    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where)
                );
            }
        } else {
            //De lo contrario será redireccionado
            redireccionar('');
        }
    }

    public function actualizar()
    {
        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $plugin = $_POST['id'];
            $plugin2= $_POST['type'];
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
    

    public function eliminar()
    {
        //Validar datos recibido mediante POST
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && !empty($_POST['id']) ):
           if($this->model->actualizarProducto([], 'update', 'Estado_P', 4, $_POST['id'])){
                   echo "true";
           }else{
                echo "false";
           }
        endif;
    }
}
