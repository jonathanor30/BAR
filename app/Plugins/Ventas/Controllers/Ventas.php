<?php

class Ventas extends Controller
{

    public $model;
    public  $PluginName;
    public function __construct()
    {
        $this->sessionValidator(); //Validamos sesion
        $this->model = $this->modelo('Venta', 'Ventas');
        $this->PluginName = 'Ventas';
    }

    public function index()
    {
        $dataTables = dataTables();
        $datos =  array(
            'titulo' => 'Listado Ventas',
            'icon'   => 'fas fa-boxes',
            'dataTables' => $dataTables

        );
        $this->vista('ListadoVenta', $datos, 'Ventas', true);
    }

    public function CrearVenta()
    {

        $datos =  array(
            'titulo' => 'Crear Venta',
            'icon'   => 'fas fa-boxes',

 
        );
        $this->vista('CrearVenta', $datos, 'Ventas', true);
    }

    public function VerProducto($id = null)
    {
        $this->pagina404($id);
        $datos =  array(
            'titulo' => 'ventas',
            'ventas' => $this->model->ObtenerUno("IdVenta", $id),
        );
        $this->vista('VerVenta', $datos, 'Ventas');
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
            $table = 'venta';

            //Llave primaria de la tabla
            $primaryKey = 'IdVenta';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'user_id', 'dt' => 'user_id'),
                array('db' => 'IdCliente', 'dt' => 'IdCliente'),
                array('db' => 'Fecha', 'dt' => 'Fecha'),
                array('db' => 'observaciones', 'dt' => 'observaciones'),
                array('db' => 'hora', 'dt' => 'hora'),
                array('db' => 'IdEstadoventa', 'dt' => 'IdEstadoVenta'),

                array('db' => 'IdVenta', 'dt' => 'IdVenta'),

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
    public function actualizar()
    {
        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $venta = $this->model->obtenerdatos($_POST['id']);


            foreach ($venta as $key) {
               
                $datos = array(
                                    
                    'IdProducto'  => $key->IdProducto,
                    'cantidad'        => $key->cantidad,
                );
            }
            //Instancia del moldelo

            $probar = $this->model->actualizarproductoinventario($datos);
            if($probar == 1){
            switch ($this->model->actualizarVenta($_POST['id'])) {
                case 1:
                    echo "true";
                    break;
                case 2:
                    echo "false";
                    break;
            }
        }else{echo "else";}
        } else {
            redireccionar('/Ventas');
        }
    }
   
    public function ObtenerClientes()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->model->ObtenerClientes(), JSON_PRETTY_PRINT);
        endif;
    }

    public function ObtenerPrecios($producto)
    {
        $this->db->query("SELECT CodigoProducto,PrecioSugerido,Nombre,NombreProducto FROM producto p INNER JOIN marca m on p.IdMarca = m.IdMarca WHERE CodigoProducto=:producto");
        $this->db->bind(':producto', $producto);     
        return $this->db->registros();
    }

   
    
   
    public function ObtenerDocumento()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD'] && $_POST['cliente'] != "") {
            header('Content-Type: application/json');
            echo json_encode($this->model->ObtenerDocumento($_POST['cliente']), JSON_PRETTY_PRINT);
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
                        'IdCliente'  => $_POST['IdCliente'],
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

    
    public function Last($tabla, $campo = null)
    {
        if ($campo == null) {
            echo false;
        } else {
            $this->db->query("SELECT * FROM $tabla ORDER BY  $campo DESC LIMIT 0,1");
            if ($this->db->registro() != "") {
                $this->result = $this->db->registro();
                return $this->result;
            } else {
                echo false;
            }
        }
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
    public function cancelar()
    {
        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            switch ($this->model->CancelarVenta($_POST['id'])) {
                case 1:
                    echo "true";
                    break;
                case 2:
                    echo "false";
                    break;
            }
        } else {
            redireccionar('/Ventas');
        }
    }

    public function VerVenta($id)
    {

        $venta = $this->model->pruebaxd($id);
            //Comprobador 404

            
            $this->pagina404($venta);

            $total = $this->model->obtenertotal($id);

            $datoventa = $this->model->obtenerventa($id);
               
            $datos = array(
                'titulo' => 'Detalle De la venta',              
                'venta'  => $venta,
                'total'  => $total,
                'datoventa' => $datoventa,
            );
            $this->vista('VerVenta', $datos, 'Ventas', true);
             
    }
}
