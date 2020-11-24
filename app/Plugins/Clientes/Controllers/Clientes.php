<?php

class Clientes extends Controller
{

    private $model;
    public  $PluginName;
    public function __construct()
    {
        $this->sessionValidator(); //Validamos sesion
        $this->model = $this->modelo('Cliente', 'Clientes');
        $this->PluginName = 'Clientes';
    }

    public function index()
    {
        $dataTables = dataTables();
        $datos =  array(
            'titulo' => 'Listado Clientes',
            'icon'   => 'fas fa-people-carry',
            'dataTables' => $dataTables

        );
        $this->vista('listadoClientes', $datos, 'Clientes', true);
    }

    public function detalleCliente()
    {
        $cliente = $this->model->ObtenerUno();
        $datos =  array(
            'titulo' => $cliente->Nombre,
            'cliente' => $cliente,
        );

        $this->vista('detalleCliente', $datos, 'Clientes');
    }
    public function pruebaxd($id = null)
    {
        $this->pagina404($id);
        $proveedor = $this->model->prueba($id);
        $datos =  array(
            'titulo' => $proveedor->Nombre,
            'proveedor' => $proveedor,
        );
       
    }

    public function Obtenerventas()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->model->Obtenerventas2(), JSON_PRETTY_PRINT);
        endif;
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
            $table = 'cliente';

            //Llave primaria de la tabla
            $primaryKey = 'IdCliente';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'IdTipoDocumento', 'dt' => 'IdTipoDocumento'),
                array('db' => 'Numero_Documento', 'dt' => 'Numero_Documento'),
                array('db' => 'Nombre', 'dt' => 'Nombre'),
                array('db' => 'IdCliente', 'dt' => 'IdCliente'),

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
                    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, null)
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
            if ($this->model->db->Update($_POST, 'cliente', 'IdCliente', intval($_POST['IdCliente']))) {
                echo "true";
            } else {
                echo "false";
            }
        else :
            redireccionar("/Clientes");
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
          echo json_encode($this->model->ObtenerTiposDeDocumentos(), JSON_PRETTY_PRINT);
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
                    'IdTipoDocumento'    => $_POST["IdTipoDocumento"],
                    'Numero_Documento'   => $_POST["Numero_Documento"],
                    'Nombre'             => $_POST["Nombre"],
                    

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->model->agregarCliente($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intenter";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "El cliente que quiere registrar ya existe";
                        break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/Clientes');
        }
    }

    public function ObtenerPrecios()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD'] && $_POST['venta'] != "") {
            header('Content-Type: application/json');
            echo json_encode($this->model->ObtenerPrecios($_POST['venta']), JSON_PRETTY_PRINT);
        } else {
            echo "false";
        }
    }

    public function actualizar2()
    {
        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cliente = $this->model->obtenerdatos($_POST['id']);
            foreach ($cliente as $key) {
               
                $datos = array(
                                    
                    'IdVenta'  => $key->IdProducto,
                    'total'        => $key->total,
                );
                
               
                
                 
            switch ($this->model->actualizarCliente($_POST['id'],$datos)) {
                case 1:
                    echo "true";
                    break;
                case 2:
                    echo "false";
                    break;
            }}
        } else {
            redireccionar('/Clientes');
        }
    }

    public function detalleClientes($id)
    {

        $cliente = $this->model->pruebaxd($id);
            //Comprobador 404
            $this->pagina404($cliente);

            $total = $this->model->obtenertotal($id);

            $datoventa = $this->model->Obtenerventa($id);
               
            $datoscli = $this->model->obtenerdatos($id);

            $datos = array(
                'titulo' => 'Detalle Del Cliente',              
                'cliente'  => $cliente,
                'total'  => $total,
                'datoventa' => $datoventa,
                'datoscli' => $datoscli,
            );
            $this->vista('detalleCliente', $datos, 'Clientes', true);
             
    }
    public function prueba2($id)
    {
        $probar =  $this->model->prueba2($id);
        print_r($probar);
    }
}
