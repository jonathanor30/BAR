<?php

class Compras extends Controller
{

    private $model;
    public  $PluginName;
    public function __construct()
    {
        $this->sessionValidator(); //Validamos sesion
        $this->model = $this->modelo('Compra', 'Compras');
        $this->PluginName = 'Compras';
    }

    public function index()
    {
        $dataTables = dataTables();
        $datos =  array(
            'titulo' => 'Listado Compras',
            'icon'   => 'fas fa-shopping-bag',
            'dataTables' => $dataTables

        );
        $this->vista('ListadoCompras', $datos, 'Compras', true);
    }
    public function test2()
    {
        $dataTables = dataTables();
        $this->vista('CrearCompra', array(
            'titulo' => 'Crear Compra',
            'icon'   => 'fas fa-shopping-bag',
            'dataTables' => $dataTables
        ), $this->PluginName);
    }

    public function test1()
    {
        $dataTables = dataTables();
        $datos =  array(
            'titulo' => 'Crear Compra',
            'icon'   => 'fas fa-shopping-bag',
            'dataTables' => $dataTables

        );
        $this->vista('CrearCompra', $datos, 'Compras', true);
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
            $table = 'compra';

            //Llave primaria de la tabla
            $primaryKey = 'IdCompra';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'IdProveedor', 'dt' => 'IdProveedor'),
                array('db' => 'fecha', 'dt' => 'fecha'),
                array('db' => 'hora', 'dt' => 'hora'),
                array('db' => 'observaciones', 'dt' => 'observaciones'),
                array('db' => 'IdCompra', 'dt' => 'IdCompra'),

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

    public function ObtenerTiposDeProducto()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->model->ObtenerTiposDeProducto(), JSON_PRETTY_PRINT);
        endif;
    }
    public function Obtenerproveedores()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->model->Obtenerproveedores(), JSON_PRETTY_PRINT);
        endif;
    }
    public function ObtenerPrecios()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD'] && $_POST['producto'] != "") {
            header('Content-Type: application/json');
            echo json_encode($this->model->ObtenerPrecios($_POST['producto']), JSON_PRETTY_PRINT);
        } else {
            echo "false";
        }
    }

    public function SaveInvProv()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exc = array('FacObservacion');
            if (is_array($this->formValidator($_POST, $exc))) {
                if (isset($_POST['numero_item'])) {
                    //se define el id de la compra
                    $cont  = 0;
                    $iva = 0;
                    $total = 0;
                    $datos = array(
                        'idproveedor'  => $_POST['idproveedor'],
                        'FacObservacion' => $_POST['FacObservacion']
                    );
                    $this->model->observacion($datos);

                    foreach ($_POST['numero_item'] as $key => $value) {
                        $dat = array(

                            'IdTipoProducto'  => $_POST['IdTipoProducto'][$key],
                            'cantidad'        => $_POST['cantidad'][$key],
                            'precio' => $_POST['precio'][$key],
                            'iva'             => $_POST['iva'][$key],
                            'total'           => $_POST['total'][$key]
                        );




                        if ($this->model->SaveInvProv($dat)) {

                            $cont++;
                            $total = $total + $dat['total'];
                            $iva = $iva + $dat['iva'];
                        } else {
                            echo false;
                        }
                    }
                    //echo $cont."--".count($_POST['numero_item']);

                } else {
                    echo 'No se pueden guardar facturas sin lineas';
                }
            } else {
                echo "Te faltan Campos por llenar";
            }
        }
        $_POST = array();
    }

    /**
     * AutoCompletarProducto
     * @access public
     * @param string $key
     * @return void
     */
    public function AutoCompletarProducto(string $key1 = "")
    {
        //validar que exista una llave de busqueda
        if ($key1 != "") :
            if (isset($_GET['term'])) {
                $dato = array();
                $rows = $this->model->AutoCompletarProducto([
                    'key' => $key1,
                    'term' => $_GET['term'] ?? ""
                ]);
                foreach ($rows as $key => $value) {

                    $dato[] = array(
                        'value'         => $value[$key1] ." ". $value['Nombre'],
                        'IdProducto'    => $value['IdProducto'],
                        'NombreProducto'=> $value['NombreProducto'],
                        'PrecioSugerido'=> $value['PrecioSugerido'],
                        'Marca'         => $value['Nombre']


                    );
                }
                echo json_encode($dato);
            }

        endif;
    }

    /**
     * validarstocks
     * @access public
     * @return void
     */
    public function validarstocks():void
    {
        if($_SERVER['REQUEST_METHOD'] == true && !empty($_GET)){
            $producto = $this->model->ObtenerRegistro('IdProducto', 'producto', $_GET['IdProducto']);
            if(intval($_GET['cantidad']) < $producto->StockMaximo){
                 echo "true";
            }else{
                echo "false";
            }
        }
    }
}
