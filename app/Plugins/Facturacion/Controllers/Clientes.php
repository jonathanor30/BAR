<?php

/**
 *
 *
 * @author PlenusServices
 */

use Illuminate\Database\Capsule\Manager as DB;
use Models\Clientes\Clientes as ModelClient;
use Models\Clientes\Clientes as ModelCliente;
use Models\Configs\Company\Company;
use Models\Configs\Resolutions\Resolutions;
use Models\FacturaCliente\FacturaCliente;
use Models\FacturaClienteLines\FacturaClienteLines;
use Models\FacturasNotes\FacturasNotes;
use Models\FacturasNotesLines\FacturasNotesLines;
use Models\Ingreso\Ingreso;
use Models\Ingresos\Ingresos;

//Requiero los otros controladores
require_once 'Proveedores.php';
require_once 'Facturacion.php';

class Clientes extends Controller
{
    //def variables a usar
    public $ClientsName;
    public $ModelClient;
    public $cliente;
    public $serie;
    public $linea;
    public $modelFe;
    public $PluginName;
    //constructor

    public function __construct()
    {
        $this->ClientsName = __CLASS__;
        $this->PluginName = "Facturacion";
        $this->ModelClient = new ModelClient;
        //instancia a modelo
        $this->ssp         = new SSP;
        $this->serie       = 'A';
        $this->Excel       = new PHPExcel;
        $this->folderImg   = RUTA_UPLOAD . 'Facturacion' . SEPARATOR . 'img' . SEPARATOR;
        $this->folderPdf   = RUTA_UPLOAD . 'Facturacion' . SEPARATOR . 'pdf' . SEPARATOR;
        $this->modelPerfil = $this->modelo('Perfil');
        $this->modelFe = $this->modelo('ModelFE', 'Facturacion');

        //instancio clase SSP para datatables
    }
    /**
     * Metodo providers a la vista clientes
     * @access public
     * @param = null
     * @return  vista
     * Vista clientes
     */

    public function Clientes()
    {
        $data      = [
            'titulo'     => 'Clientes',
            'icon'       => 'fas fa-users',
            'dataTables' => dataTables(),
            'datos'      => \Models\Configs\Country\Country::all(),
        ];
        $this->vista('Clientes/Clientes/Clientes', $data, 'Facturacion');
    }
    /**
     * Metodo cliente Detallado
     * @access public
     * @param = $id
     * Id de cliente a mirar detalladamente
     * @return  vista
     * Vista detalle cliente
     */

    public function detailClient($id)
    {
        $reg = $this->ModelClient->where("id_cliente", $id)->first();
        $this->pagina404($reg);
        if ($reg != '' || $reg != false) {
            $data      = [
                'titulo'      => 'Cliente',
                'Name'        => $this->PluginName,
                'icon'        => 'fas fa-users',
                'dataTables'  => dataTables(),
                'datos'       => $reg,
                'div'         => \Models\Configs\Divisas\Divisas::all(),
                'country'     => \Models\Configs\Country\Country::all(),
                'liabilities' => \Models\Configs\Liabilities\Liabilities::all(),
                'payment'     => \Models\Configs\PaymentM\PaymentM::all(),
            ];
            $this->vista('Clientes/Clientes/detalleCliente', $data, $this->PluginName);
        } else {
        }
    }
    //---------------------------------------------------------------------------------------Facturas
    /**
     * Metodo a vista facturas
     * @access public
     * @param = null
     * @return vista
     * Vista facturas clientes
     */
    public function FacturasCliente()
    {
        $datos = array(
            'titulo'     => 'Facturas Clientes',
            'icon'       => 'fas fa-file-invoice-dollar',
            'configFE'   => Company::where("id_config", 1)->first(),
            'dataTables' => dataTables(),
        );
        $this->vista('Clientes/Facturas/Facturas', $datos, 'Facturacion');
    }

    /**
     * Metodo factura detallada
     * @access public
     * @param = $id_factura
     * Id factura asociada a cliente
     * @return
     * Vista factura detallada
     */

    public function detalleFactura(int $id_factura)
    {
        $factura = \Models\FacturaCliente\FacturaCliente::with("Lines")->where("idfactura", $id_factura)->first();
        if (is_object($factura)) {
            if ($factura->estado == 2) {
                $NC = null; // \Models\FacturasNotes\FacturasNotes::where("idfactura", $id_factura)->get();
            } else {
                $NC = null;
            }
            $datos   = array(
                'titulo'     => 'Editar Factura',
                'icon'       => 'fas fa-file-invoice-dollar',
                'datos'      => [$factura],
                'cliente'    => $this->ModelClient->where("id_cliente", $factura->codcliente)->first(),
                "recibo"     => Ingreso::where("idfactura", $id_factura)->get(),
                'dataTables' => dataTables(),
                'CreditNote' => $NC,
                'configFE'   => Company::where("id_config", 1)->first(),
                'payment'    => \Models\Configs\PaymentM\PaymentM::all(),
                'ingresos'   => \Models\Ingreso\Ingreso::where("idfactura", $id_factura)->get(),
            );
            $this->vista('Clientes/Facturas/EditarFactura', $datos, 'Facturacion');
        } else {
            redireccionar('/Facturacion');
        }
    }

    //--------------------------------------------------------------------------------------Facturas
    //-------------------------------------------------------------------------------------Ingresos
    /**
     * Metodo a vista ingresos
     * @access public 
     * @param null
     * @return vista
     * Vista ingresos
     */
    public function Ingresos()
    {
        $datos = array(
            'titulo'     => 'Ingresos',
            'icon'       => 'fas fa-file-invoice-dollar',
            'dataTables' => dataTables(),
        );
        $this->vista('Clientes/Ingresos', $datos, 'Facturacion');
    }
    /**
     * Metodo a vista detalle ingreso
     * @access public
     * @param int $id_ingreso
     * @return null vista
     */
    public function detalleIngreso(int $id_ingreso)
    {
        $ing = [Ingreso::where("id_ingreso", $id_ingreso)->first()];
        if (is_array($ing) && count($ing) != 0) {
            $this->pagina404($ing);
            $factura = [FacturaCliente::where("idfactura", $ing[0]->idfactura)->first()];

            $dat = array(
                'titulo'  => 'Ingreso detallado',
                'icon'    => 'fas fa-file-invoice-dollar',
                'last'    => $ing,
                'invoice' => $factura,
                'divisas' =>  \Models\Configs\Divisas\Divisas::all(),
            );
            $this->vista('Clientes/detalleIngreso', $dat, 'Facturacion');
        } else {
            redireccionar('/Facturacion');
        }
    }
    //-------------------------------------------------------------------------------------/Ingresos
    //--------------------------------------------------------------------------------------CRUD Cliente
    /**
     * Metodo para guardar clientes
     * @access public
     * @return  bool
     */

    public function AddClient()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($_POST as $key => $value) {
                if ($key != 'email') {
                    $_POST[$key] = strtoupper($_POST[$key]);
                }
            }
            if (!isset($_POST['personafisica'])) {
                $_POST['personafisica'] = 0;
            } else {
                $_POST['personafisica'] = 1;
            }

            $exc = array('personafisica', 'telefono1', 'departamento', 'ciudad', 'codpostal', 'direccion');
            if ($this->formValidator($_POST, $exc)) {
                $_POST['codcliente'] = ($this->ModelClient->get()->last()->codcliente != null ? $this->ModelClient->get()->last()->codcliente + 1 : 1);
                if ($this->ModelClient::create($_POST)) {
                    echo true . ',' . $this->ModelClient->get()->last()->id_cliente;
                } else {
                    echo false;
                }
            } else {
            }
        } else {
            return $this->vista('directiva', array(
                'titulo'   => 'Upps',
                'mensaje'  => 'No deberías estar aquí',
                'problema' => 'su solicitud, No es una página para acceder por URL'
            ));
        }
    }

    public function GetLiabilities()
    {
        echo json_encode(\Models\Configs\Liabilities\Liabilities::where("id", $_POST['id'])->first()->toArray());
    }

    /**
     * EditClient
     * Méto encargado de completar y actualizar información de clientes
     * @access public
     * @return bool
     */
    public function EditClient()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (is_array($this->formValidator($_POST, array('observaciones', 'estado', 'telefono2', 'regimeniva', 'responsabilidades')))) {
                if (!isset($_POST['personafisica'])) {
                    $_POST['personafisica'] = 0;
                } else {
                    $_POST['personafisica'] = 1;
                }
                if ($this->ModelClient->where("id_cliente", $_POST['id_cliente'])->update($_POST)) {
                    echo true;
                } else {
                    echo false;
                }
            }
            $_POST = array();
        } else {
            $this->vista('directiva', array(
                'titulo'   => 'Upps',
                'mensaje'  => 'No deberías estar aquí',
                'problema' => 'su soicitud, No es una página para acceder por URL '
            ));
        }
    }
    /**
     * Metodo para eliminar General
     * @access public
     * @param = null
     * @return  bool
     * @method ajax
     */

    public function InvoiceDelete()
    {
        try {
                   //Acá se valida que el método de acceso sea POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id    = $_POST['id'];
            $table = $_POST['table'];
            $key   = $_POST['key'];
            //Acá se valida que el usuario que desea eliminar la factura, se root
            if ($_SESSION['user_type'] == 1 && $table == 'facturascli') {
                //Aquí se obtienen la factura mediante un modelo
                $factura = \Models\FacturaClienteLines\FacturaClienteLines::where('idfactura', intval($_POST['id']))->get()->toArray();
            
                //Array acumulador de productos
                $codigos = array();
                $bandera = 0;
                //Acá se entriquece el acomulador
                foreach ($factura as $key => $value) {
                    //Enriquecer
                    array_push($codigos, [
                        'CodigoProducto' =>  $value['codigo_estandar'],
                        'cantidad'       =>  $value['cantidad']
                    ]);
                }
               $codigos = array_values($codigos);
                //Actualizar existencias, por motivo de eliminación de Factura
                foreach ($codigos as $key => $value) {
                    //Así se instacia un Modelo con WHERE
                    $producto = \Models\Producto\Producto::where('CodigoProducto', $value['CodigoProducto'])->first();
                   
                    //Actualizar existencias
                    if(\Models\Producto\Producto::where('CodigoProducto', $value['CodigoProducto'])->update(['Existencias' => $producto->Existencias + $value['cantidad']])){
                      $bandera++;
                    }
                }
              
                if (count($codigos) == $bandera) {
                    DB::table($table)->where('idfactura', $id)->delete();
                    $this->writeLog = new LogManager(array(
                        'tipo'    => 'DANGER',
                        'mensaje' => 'El usuario ' . $_SESSION['user_name'] . ' ha eliminado el registro de la tabla ' . $table . ' con id ' . $id,
                    ));
                    echo true;
                } else {
                    echo false;
                }
            } elseif ($_SESSION['user_type']  != 1 && $table == 'facturascli') {
                echo 'Usted no tiene los permisos necesarios para esta acción';
            } elseif ($_SESSION['user_type'] == 1 && $table == 'clientes') {
                if ($this->ModelClient->withCount("Invoices")->where($key, $id)->first()->invoices_count == 0) {
                    if ($this->ModelClient::where($key, $id)->delete()) {
                        $this->writeLog = new LogManager(array(
                            'tipo'    => 'DANGER',
                            'mensaje' => 'El usuario ' . $_SESSION['user_name'] . ' ha eliminado el registro de la tabla ' . $table . ' con id ' . $id,
                        ));
                        echo true;
                    } else {
                        echo false;
                    }
                } else {
                    echo "El cliente tiene facturas asociadas, NO se puede eliminar";
                }
            } elseif ($_SESSION['user_type']  != 1 && $table == 'clientes') {
                echo 'Usted no tiene los permisos necesarios para esta acción';
            } elseif ($_SESSION['user_type'] == 1 && $table == 'ingresos_clientes') {
                if (DB::table($table)->where($key, $id)->delete()) {
                    $this->writeLog = new LogManager(array(
                        'tipo'    => 'DANGER',
                        'mensaje' => 'El usuario ' . $_SESSION['user_name'] . ' ha eliminado el registro de la tabla ' . $table . ' con id ' . $id,
                    ));

                    echo true;
                } else {
                    echo false;
                }
            } elseif ($_SESSION['user_type']  != 1 && $table == 'ingresos_clientes') {
                echo 'Usted no tiene los permisos necesarios para esta acción';
            } else {
                if (DB::table($table)->where($key, $id)->delete()) {
                    $this->writeLog = new LogManager(array(
                        'tipo'    => 'DANGER',
                        'mensaje' => 'El usuario ' . $_SESSION['user_name'] . ' ha eliminado el registro de la tabla ' . $table . ' con id ' . $id,
                    ));

                    echo true;
                } else {
                    echo false;
                }
            }
        } else {
            $this->vista('404') . exit();
        }

        $_POST = array();
        } catch (\Throwable $th) {
          echo $th->getMessage();
        }
    }
    //--------------------------------------------------------------------------------------CRUD Cliente

    /**
     * Metodo utilizado para datatable en vista providers
     * @access public
     * @param = filters
     * @return  json
     * @method ajax
     */

    public function tableViewsClientes()
    {

        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'clientes';

            //Llave primaria de la tabla
            $primaryKey = 'id_cliente';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.
            $columns = array(
                array('db' => 'id_cliente', 'dt' => 'id_cliente'),
                array('db' => 'codcliente', 'dt' => 'codcliente'),
                array('db' => 'nombre', 'dt' => 'nombre'),
                array('db' => 'cifnif', 'dt' => 'cifnif'),
                array('db' => 'email', 'dt' => 'email'),
                array('db' => 'telefono1', 'dt' => 'telefono1'),
                array('db' => 'telefono2', 'dt' => 'telefono2'),
                array('db' => 'estado', 'dt' => 'estado'),
            );

            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            //header( 'Content-type: application/json; charset=utf-8' );
            if (isset($_POST['id']) && $_POST['id'] != '') {
                //Retornamos los valores consultados con filtro
                $where = "estado = {$_POST['id']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } else {
                //Retornamos los valores consultados sin filtro
                echo json_encode(
                    $this->ssp->simple($_POST, $sql_details, $table, $primaryKey, $columns),
                    JSON_PRETTY_PRINT
                );
            }
        } else {
            $this->vista('404') . exit();
        }
    }
    /**
     * Metodo para añadir ingresos
     * @access public
     * @param = null
     * @return bool
     */
    public function AddIn()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exc = array('invoice', 'idf', 'tot_recibos');
            $dat = $this->formValidator($_POST, $exc);
            if (is_array($dat)) {
                if (isset($_POST['idf']) && !empty($_POST['idf'])) {
                    $lastInv = $this->ModelClient->Inv($_POST['idf']);
                    if (($_POST['tot_recibos'] + $_POST['importe']) <= $lastInv[0]->total) {
                        if ($this->ModelClient->AddIn($_POST)) {
                            echo true . '-' . $this->ModelClient->Last('ingresos_clientes', 'id_ingreso')->id_ingreso;
                        } else {
                            echo 'Error al guardar ingreso';
                        }
                    } else {
                        echo 'El importe del ingreso no puede ser mayor a $ ' . ($lastInv[0]->total - $_POST['tot_recibos']);
                    }
                } else {
                    echo "Tiene que asociar una factura para generar un ingreso";
                }
            }
        } else {
            $this->vista('directiva', array(
                'titulo'   => 'Upps',
                'mensaje'  => 'No es un método para acceder por URL',
                'problema' => 'su solicitud'
            ));
        }
        $_POST = array();
    }

    /**
     * @access public
     * @param = null
     * @return bool
     * @method ajax
     */
    public function EditIn()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exc = array('id_factura', 'observaciones', 'total', "estado_ingreso");
            if (is_array($this->formValidator($_POST, $exc))) {
                $inv = FacturaCliente::where("idfactura", $_POST['idfactura'])->first();
                $ing = Ingreso::where("idfactura", $_POST['idfactura'])->get();
                $act = Ingreso::where("id_ingreso", $_POST['id_ingreso'])->first();
                $acum = 0;
                foreach ($ing as $key => $value) {
                    $acum = $acum + $value->importe;
                }
                $dif = $ing->sum("importe") - $act->importe;
                if ($_POST['importe'] <= ($inv->total - $dif)) {
                    if (Ingreso::where("id_ingreso", $_POST['id_ingreso'])->update($_POST)) {
                        echo true;
                    } else {
                        echo 'Error al guardar el ingreso';
                    }
                } else {
                    echo 'El importe no puede exceder el total de la factura menos los recibos: ' . ($inv->total - $ing->sum("importe"));
                }
            }
        } else {
            $this->vista('directiva', array(
                'titulo'   => 'Upps',
                'mensaje'  => 'No es un método para acceder por URL',
                'problema' => 'su solicitud'
            ));
        }
    }

    /**
     * Metodo para nuevo recibo desde factura
     * @access public
     * @param null
     * @return bool
     */
    public function AddIng()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lastInv = FacturaCliente::with("Prepaids")->where("idfactura", $_POST['idfactura'])->first();
            if (in_array($_POST['state'], [0, 3, 5, 6])) {
                $exc = array('estado_ingreso', 'remain', 'outtot', 'state');
                if (is_array($this->formValidator($_POST, $exc))) {
                    if (isset($_POST['idfactura']) && !empty($_POST['idfactura'])) {
                        if ((floatval(Ingreso::where("idfactura", $_POST['idfactura'])->get()->sum("importe")) < $lastInv->total && $_POST['importe'] <= ($lastInv->total - floatval(Ingreso::where("idfactura", $_POST['idfactura'])->get()->sum("importe"))))) {
                            $_POST['numero'] = (Ingreso::get()->last() != null ? Ingreso::get()->last()->numero + 1 : 1);
                            if (Ingreso::create($_POST)) {
                                if (Ingreso::where("idfactura", $_POST['idfactura'])->get()->sum("importe") == $lastInv->total) {
                                    switch ($lastInv->estado) {
                                        case 0:
                                            $update = array("estado" => 1);
                                            break;
                                        case 3:
                                            $update = array("estado" => 4);
                                            break;
                                    }
                                    FacturaCliente::where("idfactura", $_POST['idfactura'])->update($update);
                                }
                                echo true . '-reload';
                            } else {
                                echo 'Error al guardar el ingreso';
                            }
                        } else {
                            echo 'El importe del ingreso no puede ser mayor a $ ' . ($lastInv->total - floatval(Ingreso::where("idfactura", $_POST['idfactura'])->get()->sum("importe")));
                        }
                    } else {
                        echo "Error al asociar la factura";
                    }
                }
            } else {
                echo 'No se pueden agregar recibos a una factura pagada o anulada';
            }
        } else {
            $datos = array(
                'mensaje'  => 'No deberías estar aquí',
                'problema' => 'su solicitud, NO es un método para acceder por URL',
                'titulo'   => 'Upps!'
            );
            $this->vista('directiva', $datos, 'Facturacion');
        }
    }
    /**
     * Metodo utilizado para datatable de facturas proveedor
     * @access public
     * @param = filters
     * @return  json
     * @method ajax
     */

    public function tableViewsFactCliente()
    {

        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'facturascli';

            //Llave primaria de la tabla
            $primaryKey = 'idfactura';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.
            $columns = array(

                array('db' => 'cifnif', 'dt' => 'cifnif'),
                array('db' => 'numero', 'dt' => 'numero'),
                array('db' => 'numero2', 'dt' => 'numero2'),
                array('db' => 'coddivisa', 'dt' => 'coddivisa'),
                array('db' => 'codpago', 'dt' => 'codpago'),
                array('db' => 'codcliente', 'dt' => 'codcliente'),
                array('db' => 'codserie', 'dt' => 'codserie'),
                array('db' => 'deabono', 'dt' => 'deabono'),
                array('db' => 'fecha', 'dt' => 'fecha'),
                array('db' => 'hora', 'dt' => 'hora'),
                array('db' => 'nombrecliente', 'dt' => 'nombrecliente'),
                array('db' => 'observaciones', 'dt' => 'observaciones'),
                array('db' => 'total', 'dt' => 'total'),
                array('db' => 'totaliva', 'dt' => 'totaliva'),
                array('db' => 'totaldto', 'dt' => 'totaldto'),
                array('db' => 'totalrecargo', 'dt' => 'totalrecargo'),
                array('db' => 'estado', 'dt' => 'estado'),
                array('db' => 'idfactura', 'dt' => 'idfactura'),
                array('db' => 'estadodian2', 'dt' => 'estadodian2'),

            );

            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            //header( 'Content-type: application/json; charset=utf-8' );
            if (isset($_POST['id']) && $_POST['id'] != '') {
                //Retornamos los valores consultados con filtro
                $where = "estado = {$_POST['id']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } elseif (isset($_POST['cifnif']) && $_POST['cifnif'] != '') {
                //Retornamos los valores consultados con filtro
                $where = "codcliente = {$_POST['cifnif']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } else {
                //Retornamos los valores consultados sin filtro
                echo json_encode(
                    $this->ssp->simple($_POST, $sql_details, $table, $primaryKey, $columns),
                    JSON_PRETTY_PRINT
                );
            }
        } else {
            $this->vista('404') . exit();
        }
    }

    //-----------------------------------------------------------------------------Importar Excel
    public function ImportarCliente()
    {
        $ruta = $this->folderPdf;

        if (isset($_FILES)) {
            if ($_FILES['carga']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && $_FILES['carga']['name'] == 'PlantillaCliente.xlsx') {
                $nombreArchivo = $_FILES['carga']['name'];
                $tmp_name      = $_FILES['carga']['tmp_name'];
                $fileType      = $_FILES['carga']['type'];
                if (isset($_FILES['carga']['tmp_name'])) {
                    if (!empty($nombreArchivo)) {
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                            if (file_exists($ruta)) {
                                if (move_uploaded_file($tmp_name, $ruta . $nombreArchivo)) {
                                    if ($this->guardarDatosExcelCli($nombreArchivo)) {
                                        echo true;
                                    }
                                } else {
                                    echo "El archivo no se movio después de crear el directorio";
                                }
                            } else {
                                echo "El directorio no existe";
                            }
                        } else {
                            if (move_uploaded_file($tmp_name, $ruta . $nombreArchivo)) {
                                if ($this->guardarDatosExcelCli($nombreArchivo)) {
                                    echo true;
                                }
                            } else {
                                echo "El archivo no se movi´, aunque existe el directorio";
                            }
                        }
                    } else {
                        echo "Por favor carga un archivo";
                    }
                }
            } else {
                echo "Error general, <br> El archivo cargado no es un archivo de excel o no tiene el estilo correcto, si tiene dudas descargue la plantilla";
            }
        }
    }

    public function guardarDatosExcelCli($name)
    {


        $nombre        = $this->folderPdf . $name;
        $inputFileType = PHPExcel_IOFactory::identify($nombre);
        $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel   = $objReader->load($nombre);
        $highestRow    = $objPHPExcel->getActiveSheet()->getHighestDataRow('Q');
        $sheet         = $objPHPExcel->getSheet()->rangetoArray('A3:' . 'Q' . $highestRow, null, true, true, false);
        //$objPHPExcel->getSheet()->ToArray();
        $values = array();
        foreach ($sheet as $key => $value) {
            $cont = 0;
            $register[$key] = array();
            foreach ($sheet[$key] as $key1 => $value1) {
                if ($key1 == 1 || $key1 == 6 || $key1 == 7 || $key1 == 8 || $key1 == 9 || $key1 == 11) {
                    if (is_int(intval($value1)) && $value1 != null) {
                        array_push($register[$key], $value1);
                    } else {
                        $cont++;
                    }
                } else {
                    if ($value1 != null && $value1 != "") {
                        array_push($register[$key], strtoupper($value1));
                    } else {
                        $cont++;
                    }
                }
            }
            if ($cont == 0) {
                array_push($values, $register[$key]);
            } else {
                $register[$key] = array();
            }
        }
        $cont3 = 0;

        foreach ($values as $key => $value) {
            if ($this->ModelClient->Import($values[$key])) {
                $cont3++;
                if ($cont3 == count($values)) {
                    echo true;
                    unlink($nombre);
                }
            } else {
                echo "Error al importar el archivo de excel";
                unlink($nombre);
            }
        }
    }

    public function FicheroCliente()
    {

        $objPHPExcel = $this->Excel;
        $objPHPExcel->getProperties()
            ->setCreator("Plenus Services")
            ->setLastModifiedBy("Plenus Services")
            ->setTitle("Plantilla")
            ->setSubject("Plantilla")
            ->setDescription("Documento para usar como plantilla para subir clientes a Base de datos")
            ->setKeywords("Excel Office 2007 open XML PHP");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
        $objPHPExcel->getActiveSheet()->mergeCells('K1:Q1');
        $objPHPExcel->getActiveSheet()->mergeCells('S1:U1');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'GTEP | Modulo Facturación')
            ->setCellValue('K1', 'Desarrollado por Plenus Services')
            ->setCellValue('A2', 'Nombre')
            ->setCellValue('B2', 'Tipo de documento')
            ->setCellValue('C2', 'CC/NIT')
            ->setCellValue('D2', 'Telefono 1')
            ->setCellValue('E2', 'Telefono 2')
            ->setCellValue('F2', 'Email')
            ->setCellValue('G2', 'Forma de pago')
            ->setCellValue('H2', 'Divisa')
            ->setCellValue('I2', 'Régimen Iva')
            ->setCellValue('J2', 'Persona Física ?')
            ->setCellValue('K2', 'Nombre de banco')
            ->setCellValue('L2', 'Tipo de cuenta bancaria')
            ->setCellValue('M2', 'Número de cuenta bancaria')
            ->setCellValue('N2', 'Departamento')
            ->setCellValue('O2', 'Ciudad')
            ->setCellValue('P2', 'Código postal')
            ->setCellValue('Q2', 'Direccion');
        foreach (range('A', 'U') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->setTitle('Clientes');
        $objPHPExcel->setActiveSheetIndex(0);
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="PlantillaCliente.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
    }

    public function glosarioC()
    {
        $filename = $this->folderPdf . 'Glosario.txt';
        $file     = fopen($filename, 'w+');
        fwrite($file, "Glosario  \n
        Tipo    doc            : NIT/CC/CE
        Forma   Pago           : Transf/Efectivo/Cheque=	1, 2,           3
                Divisa         : COP= COP
        Régimen IVA            : Común,                     Simpl,       Simple=	1, 2, 3
        Persona Física         : Sí,                        No =	1,      0
        Tipo    cuenta bancaria: Ahorros,                   corriente=1, 2
        ");
        fclose($file);
        header('Content-Type: application/octet-stream');
        header("Content-Length:" . filesize($filename) . "");
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        readfile($filename);
    }
    //-----------------------------------------------------------------------------Importar Excel

    /**
     * Metodo utilizado para datatable de recibos de clientes
     * @access public
     * @param = filters
     * @return  json
     * @method ajax
     */

    public function tableViewsInsCliente()
    {

        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'ingresos_clientes';

            //Llave primaria de la tabla
            $primaryKey = 'id_ingreso';
            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.
            $columns = array(

                array('db' => 'id_ingreso', 'dt' => 'id_ingreso'),
                array('db' => 'idfactura', 'dt' => 'idfactura'),
                array('db' => 'linea', 'dt' => 'linea'),
                array('db' => 'numero', 'dt' => 'numero'),
                array('db' => 'cliente', 'dt' => 'cliente'),
                array('db' => 'id_cliente', 'dt' => 'id_cliente'),
                array('db' => 'divisa', 'dt' => 'divisa'),
                array('db' => 'importe', 'dt' => 'importe'),
                array('db' => 'fp', 'dt' => 'fp'),
                array('db' => 'concepto', 'dt' => 'concepto'),
                array('db' => 'observaciones', 'dt' => 'observaciones'),
                array('db' => 'estado_ingreso', 'dt' => 'estado_ingreso'),

            );

            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            //header( 'Content-type: application/json; charset=utf-8' );
            if (isset($_POST['idfa']) && $_POST['idfa'] != '') {

                //Retornamos los valores consultados con filtro
                $where = "estado_ingreso={$_POST['idfa']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } else if (isset($_POST['idf']) && $_POST['idf'] != '') {

                //Retornamos los valores consultados con filtro
                $where = "idfactura={$_POST['idf']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } else {
                // echo '<pre>';
                //Retornamos los valores consultados sin filtro
                echo json_encode(
                    $this->ssp->simple($_POST, $sql_details, $table, $primaryKey, $columns),
                    JSON_PRETTY_PRINT
                );
            }
        } else {
            $this->vista('404') . exit();
        }
    }

    /**
     * Metodo para cambiar estados de clientes
     * @access public
     * @param = null
     * @return  bool
     * @method ajax
     */

    public function StateClient()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['idA'])) {
                if ($this->ModelClient->State($_POST['idA'], 1)) {
                    echo true;
                } else {
                    echo false;
                }
            }
            if (isset($_POST['idI'])) {
                if ($this->ModelClient->State($_POST['idI'], 0)) {
                    echo true;
                } else {
                    echo false;
                }
            }
        } else {
            $this->vista('404') . exit();
        }
    }

    /**
     * Método files() método para gestionar archivos propios del Plugin
     * se encarga de gestionar y servir archivos para el perfomance
     * @access public
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
                echo 'El campo ' . $campo . ' esta vacio<br>';
                $contador++;
            }
        }
        if ($contador == 0) {
            return $array;
        } else {
            return false;
            exit('Intentando hackear? JAJAJAJAJA');
        }
    }

    /**
     * Metodo vista a nueva factura de cliente
     * @access public
     */

    public function NuevaFactura()
    {
        $datos = [
            'titulo'      => 'Nueva factura',
            'icon'        => 'fas fa-file-invoice-dollar',
            'liabilities' => \Models\Configs\Liabilities\Liabilities::all(),
            'payment'     => \Models\Configs\PaymentM\PaymentM::all(),
        ];
        $this->vista('Clientes/Facturas/NuevaFactura', $datos, $this->PluginName);
    }

    /**
     * Metodo para guardar Facturas de venta
     * @access public
     * @return bool
     */

    public function SaveInvClie()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $exc = array('observaciones', 'estado', 'referencia', 'pagada');
                if (is_array($this->formValidator($_POST, $exc))) {
                    if (isset($_POST['numero_item'])) {
                        $this->cliente = $this->ModelClient->where("id_cliente", $_POST['id_cliente'])->first();
                        $this->factura = new FacturaCliente;
                        unset($_POST['id_cliente']);
                        //enriqueciendo todo lo que viene por post
                        foreach ($_POST as $key => $value) {
                            if (!is_array($value)) {
                                $this->factura->$key = $value;
                            }
                        }
                        unset($this->factura->referenciaInv);
                        //valores por defecto que no tienen default en DB
                        $rec                         = array(
                            //Factura de cliente
                            'irpf'          => 0,
                            'netosindto'    => 0,
                            'neto'          => 0,
                            'anulada'       => 0,
                            'tasaconv'      => 1,
                            'total'         => 0,
                            'totaleuros'    => 0,
                            'totalirpf'     => 0,
                            'totaliva'      => 0,
                            'dtopor1'       => 0,
                        );
                        foreach ($rec as $key => $value) {
                            $this->factura->$key = $value;
                        }
                        $this->factura->codagente    = $_SESSION['user_id'] ?? '1';
                        $this->factura->codcliente   = $this->cliente->id_cliente;
                        $this->factura->coddivisa    = $this->cliente->coddivisa;
                        $this->factura->codejercicio = date("Y");
                        $this->factura->codigo       = ($this->factura->get()->last() != null ? $this->factura->get()->last()->numero + 1 : 1);
                        $this->factura->codpago      = $_POST['codpago'];
                        $this->factura->fp           = $_POST['codpago'];
                        $this->factura->codserie     = $this->serie;
                        $this->factura->hora         = date("H:i:s");
                        $this->factura->ciudad       = $this->cliente->ciudad;
                        $this->factura->numero       = ($this->factura->get()->last() != null ? $this->factura->get()->last()->numero + 1 : 1);
                        $this->factura->pagada       = $_POST['pagada'];
                        $this->factura->estado       = $_POST['pagada'];
                        $this->factura->referencia   = $_POST['referenciaInv'];
                        $this->factura->resolution_id = 1;
                        //Totales
                        $this->factura->neto = number_format(array_sum($_POST['subtotal']), 2, ".", "");
                        $this->factura->total = number_format(array_sum($_POST['total']), 2, ".", "");
                        $this->factura->totaldto = number_format(array_sum($_POST['dto']), 2, ".", "");
                        $this->factura->totalrecargo = number_format(array_sum($_POST['recargo']), 2, ".", "");
                        $this->factura->totaliva = number_format(array_sum($_POST['iva']), 2, ".", "");
                        $this->factura->totalretencion = number_format(array_sum($_POST['RE']), 2, ".", "");
                        //Acá se inserta la nueva factura con la información del cliente
                        if ($this->factura->save()) {
                            $cont    = 0;
                            for (
                                $i = 0;
                                $i < count($_POST['numero_item']);
                                $i++
                            ) {
                                $this->Nlinea                  = new FacturaClienteLines;
                                $this->Nlinea->referencia      = $_POST['referencia'][$i];
                                $this->Nlinea->cantidad        = $_POST['cantidad'][$i];
                                $this->Nlinea->descripcion     = $_POST['ProdNombre'][$i];
                                $this->Nlinea->dtopor          = $_POST['dto'][$i] ?? 0;
                                $this->Nlinea->idfactura       = $this->factura->idfactura;
                                $this->Nlinea->no_linea        = $cont + 1;
                                $this->Nlinea->recargo         = $_POST['recargo'][$i];
                                $this->Nlinea->iva             = $_POST['iva'][$i];
                                $this->Nlinea->neto            = $_POST['subtotal'][$i];
                                $this->Nlinea->pvpsindto       = $_POST['ProdPrecioVenta'][$i] * $_POST['cantidad'][$i];
                                $this->Nlinea->pvptotal        = $_POST['total'][$i];
                                $this->Nlinea->pvpunitario     = $_POST['ProdPrecioVenta'][$i];
                                $this->Nlinea->retencion       = $_POST['RE'][$i];
                                $this->Nlinea->codigo_estandar = $_POST['codigo'][$i];
    
                                if ($this->Nlinea->save()) {
                                    $producto = \Models\Producto\Producto::where('CodigoProducto',  $_POST['codigo'][$i])->first();
                                    \Models\Producto\Producto::where('CodigoProducto',  intval($_POST['codigo'][$i]))->update(['Existencias' => $producto->Existencias - intval($_POST['cantidad'][$i])]);
                                    $cont++;
                                } else {
                                    //acá vuelve a intentarlo
                                    $this->Nlinea->delete();
                                    $this->factura->delete();
                                    echo false;
                                }
                            }
                            //echo $cont.'--'.count( $_POST['numero_item'] );
                            //Si el contador es igual al numero de lineas, es porque el arreglo
                            //numero item ha sido recorrido por completo, por lo tanto se debe
                            //actualizar el total de la factura
                            if ($cont == count($_POST['numero_item'])) {
                                //guardó factura
                                echo true . "-" . $this->factura->idfactura;
    
    
                                // echo $total;
                            } else {
                                //Si no es exitoso el proceso de creación de la factura
                                //Se elimina la factura y las lineas alcanzadas
                                echo false;
                            }
                        } else {
                            //Error al crear la factura, no se pudo crear la factura
                            //intentar de nuevo
                            echo false;
                        }
                    } else {
                        echo "No se pueden guardar facturas sin lineas";
                    }
                } else {
                    echo 'Faltan Campos por llenar';
                }
            }
        } catch (\Throwable $th) {
           echo $th->getMessage();
        }
        $_POST = array();
    }

    /**
     * Metodo para editar facturas de venta
     * @access public
     * @param array $datos
     * @return bool
     */

    public function EditInvClient()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //solo para usuarios administrativos
            if ($_SESSION['user_type'] == 1) {
                $exc = array('observaciones', 'estado', 'referencia');
                if (is_array($this->formValidator($_POST, $exc))) {
                    //si la factura tiene lineas
                    if (isset($_POST['numero_item'])) {
                        //Se trae al cliente
                        $this->cliente = ModelClient::where("id_cliente", $_POST['codcliente'])->first();
                        //El numero de notas créditos
                        $lastNC = FacturasNotes::where("idfactura", $_POST['idfactura'])->where("prefijo", "NC")->get();
                        //El numero de ontas debito
                        $lastND = FacturasNotes::where("idfactura", $_POST['idfactura'])->where("prefijo", "ND")->get();
                        //Se trae la factura actual
                        $thisfactura = FacturaCliente::where("idfactura", $_POST['idfactura'])->first();
                        //Si el estado es anulado 
                        if (in_array($_POST['estado'], [2]) && ($thisfactura->total - $lastNC->sum("total") ?? 0) >= array_sum($_POST['total'])) {
                            $this->factura = new FacturasNotes;
                        } elseif (in_array($_POST['estado'], [5])) {
                            $this->factura = new FacturasNotes;
                        } else if (in_array($_POST['estado'], [0, 1, 4])) {
                            $this->factura =  FacturaCliente::where("idfactura", $_POST['idfactura'])->first();
                        } else {
                            echo "No se puede editar esta factura";
                            die;
                        }
                        $this->factura->lineasfactura = count($_POST['numero_item']);
                        $this->factura->referencia = $_POST['referenciaInv'];
                        unset($_POST['referenciaInv']);
                        foreach ($_POST as $key => $value) {
                            if (!is_array($value)) {
                                $this->factura->$key = $value;
                            }
                        }
                        if ($_POST['estado'] == 2 && ($thisfactura->total - $lastNC->sum("total") ?? 0) >= array_sum($_POST['total'])) {
                            foreach (FacturaCliente::where("idfactura", $_POST['idfactura'])->first()->toArray() as $key => $value) {
                                if ($key != "created_at" && $key != "updated_at") {
                                    $this->factura->$key = $value;
                                }
                            }
                            $this->factura->numero = ($lastNC->last() != null ? $lastNC->last()->numero + 1 : 1);
                            $this->factura->prefijo = "NC";
                            $this->factura->numero2 = null;
                            $this->factura->estado = 1;
                            $this->factura->estadodian2 = null;
                            $this->factura->observaciones = $_POST['observaciones'];
                            $this->factura->fecha = date("Y-m-d");
                        }
                        if ($_POST['estado'] == 5) {
                            foreach (FacturaCliente::where("idfactura", $_POST['idfactura'])->first()->toArray() as $key => $value) {
                                if ($key != "created_at" && $key != "updated_at") {
                                    $this->factura->$key = $value;
                                }
                            }
                            $this->factura->numero = ($lastND->last() != null ? $lastND->last()->numero + 1 : 1);
                            $this->factura->prefijo = "ND";
                            $this->factura->numero2 = null;
                            $this->factura->estado = 1;
                            $this->factura->estadodian2 = null;
                            $this->factura->observaciones = $_POST['observaciones'];
                            $this->factura->fecha = date("Y-m-d");
                        }
                        //Totaless
                        $this->factura->neto = number_format(array_sum($_POST['subtotal']), 2, ".", "");
                        $this->factura->total = number_format(array_sum($_POST['total']), 2, ".", "");
                        $this->factura->totaldto = number_format(array_sum($_POST['dto']), 2, ".", "");
                        $this->factura->totalrecargo = number_format(array_sum($_POST['recargo']), 2, ".", "");
                        $this->factura->totaliva = number_format(array_sum($_POST['iva']), 2, ".", "");
                        $this->factura->totalretencion = number_format(array_sum($_POST['RE']), 2, ".", "");
                        if ($this->factura->save()) {
                            $cont = 0;
                            if ($_POST['estado'] == 2 && ($thisfactura->total - $lastNC->sum("total") ?? 0) >= array_sum($_POST['total'])) {
                                $action = true;
                            } else if (in_array($_POST['estado'], [5])) {
                                $action = true;
                            } else {
                                $action =  FacturaClienteLines::where("idfactura", $this->factura->idfactura)->delete();
                            }
                            if ($action) {
                                foreach ($_POST['numero_item'] as $key => $value) {
                                    $dat = array(
                                        'no_linea'        => $cont + 1,
                                        'descripcion'     => $_POST['ProdNombre'][$key],
                                        'referencia'      => $_POST['referencia'][$key],
                                        'cantidad'        => $_POST['cantidad'][$key],
                                        'pvpunitario'     => $_POST['ProdPrecioVenta'][$key],
                                        'dtopor'          => $_POST['dto'][$key],
                                        'recargo'         => $_POST['recargo'][$key],
                                        'neto'            => $_POST['subtotal'][$key],
                                        'retencion'       => $_POST['RE'][$key],
                                        'iva'             => $_POST['iva'][$key],
                                        'pvptotal'        => $_POST['total'][$key],
                                        'pvpsindto'       => round($_POST['cantidad'][$key] * $_POST['ProdPrecioVenta'][$key], 2),
                                        'codigo_estandar' => $_POST['codigo'][$key],
                                    );
                                    if ($_POST['estado'] == 2 && ($thisfactura->total - $lastNC->sum("total") ?? 0) >= array_sum($_POST['total'])) {
                                        $dat['note_id'] = $this->factura->id;
                                        if (FacturasNotesLines::create($dat)) {
                                            $cont++;
                                        } else {
                                            echo false;
                                        }
                                    } else if (in_array($_POST['estado'], [5])) {
                                        $dat['note_id'] = $this->factura->id;
                                        if (FacturasNotesLines::create($dat)) {
                                            $cont++;
                                        } else {
                                            echo false;
                                        }
                                    } else {
                                        $dat['idfactura'] = $this->factura->idfactura;
                                        if (FacturaClienteLines::create($dat)) {
                                            $cont++;
                                        } else {
                                            echo false;
                                        }
                                    }
                                }
                                if ($cont == count($_POST['numero_item'])) {
                                    if ($_POST['estado'] == 1 || $_POST['estado'] == 4) {
                                        $ing = Ingreso::where("idfactura", $this->factura->idfactura);
                                        if ($this->factura->total > $ing->where("estado_ingreso", 1)->get()->sum("importe")) {
                                            $inf = array(
                                                'cliente'    => $this->cliente->nombre,
                                                'idfactura'  => $this->factura->idfactura,
                                                'importe'    => $this->factura->total - $ing->get()->sum("importe"),
                                                'date_added' => date('Y-m-d'),
                                                'concepto'   => 'Ingreso generado para la factura pagada numero ' . $this->factura->numero,
                                                'id_cliente' => $this->cliente->id_cliente,
                                                'divisa'     => $this->cliente->coddivisa,
                                                'fp'         => $_POST['fp'],
                                                'numero'     => (Ingreso::get()->last() != null ? Ingreso::get()->last()->numero + 1 : 1),
                                                "observaciones" => "Generado por: " . NOMBRE_APP,
                                                "estado_ingreso" => 1,
                                            );
                                            if (Ingreso::create($inf)) {
                                                echo true . "-" . $this->factura->idfactura;
                                            } else {
                                                echo "Factura editada pero ingreso no creado";
                                            }
                                        } else {
                                            echo true . '-' . $this->factura->idfactura;
                                        }
                                    } else {
                                        echo true . '-' . $this->factura->idfactura;
                                    }
                                } else {
                                    echo false;
                                }
                            } else {
                                echo "no se pueden reajustar las lineas";
                            }
                        } else {
                            echo "Error al guardar las lineas de factura";
                        }
                    } else {
                        echo 'No se pueden editar facturas sin lineas';
                    }
                } else {
                    echo 'Te faltan campos por llenar';
                }
            } else {
                echo 'Ud no cuenta con los privilegios para esta operación';
            }
        } else {
            $this->vista('directiva', array(
                'titulo'   => 'Upps',
                'mensaje'  => 'No debes estar aquí',
                'problema' => 'su solicitud, No es un método para acceder por URL'
            ), 'Facturacion');
        }
        $_POST = array();
    }
    /**
     * verIngreso
     * Este método se encarga de mostrar la representación grafica de la factura de venta
     * @access public
     * @param  int $id_ingreso
     */
    public function verIngreso(int $id_ingreso)
    {
        $ingreso = [Ingreso::where("id_ingreso", $id_ingreso)->first()];

        $this->pagina404($ingreso);
        if (count($ingreso) == 1) {
            $cliente = $this->ModelClient->where('id_cliente', $ingreso[0]->id_cliente)->first();
            $factura = [FacturaCliente::where("idfactura", $ingreso[0]->idfactura)->first()];
            $this->pagina404($cliente);
            $this->pagina404($factura);
        }

        $empresa = $this->modelPerfil->obtenerPerfil();  //Datos de la empresa
        //Se comprueba si la factura es electrónica

        //Start output
        ob_start();
        require_once RUTA_PLUGINS . 'Facturacion' . SEPARATOR . 'Views' . SEPARATOR . 'FormatosPdf' . SEPARATOR . 'Ingresos.php';
        $content = ob_get_clean();
        //End output

        try {
            // init HTML2PDF para generar PDF
            $html2pdf = new HTML2PDF('L', 'A5', 'es', true, 'UTF-8', array(
                0,
                0,
                0,
                0,
            ));
            //Titulo documento
            $html2pdf->pdf->SetTitle('Recibo de Ingreso');
            //display the full page
            $html2pdf->pdf->SetDisplayMode('fullpage');
            // convert
            $html2pdf->writeHTML($content);
            // send the PDF
            //$html2pdf->pdf->IncludeJS('print(TRUE)');
            $html2pdf->Output('Recibo de ingreso No: ' . $ingreso[0]->numero . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /**
     * Metodo autocompletar Cliente
     * @access public
     * @return array JSON
     */

    public function autoCompletarCliente($campo)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['term'])) {
                $dato = array();
                $rows = $this->ModelClient->where($campo, "LIKE", "%" . strtoupper($_GET['term']) . "%")->get()->toArray();
                foreach ($rows as $key => $value) {
                    $info = array();
                    foreach ($value as $key2 => $value2) {
                        $info[$key2] = $value2;
                    }
                    $info['value'] = $value[$campo];
                    array_push($dato, $info);
                }
                echo json_encode($dato);
            }
        } else {
            $this->vista('directiva', array(
                'titulo'   => 'Upps',
                'mensaje'  => 'No deberías estar aquí',
                'problema' => 'su soicitud, No es una página para acceder por URL '
            ));
        }
    }
    /**
     * Metodo autocompletar Cliente
     * @access public
     * @param = null
     * @return json
     */
    public function autoCompleteInvClient()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['term'])) {
                $dato = array();
                $rows = $this->ModelClient->autoCompleteInvClient($_GET['term']);

                foreach ($rows as $key => $value) {
                    $ing  = $this->ModelClient->Ingresos($value['idfactura'], 'idfactura');
                    $acum = 0;
                    foreach ($ing as $key1 => $value1) {
                        $acum = $acum + $value1->importe;
                    }
                    $dato[] = array(
                        'value'         => $value['numero'],
                        'ejercicio'     => $value['codejercicio'],
                        'cifnif'        => $value['cifnif'],
                        'coddivisa'     => $value['coddivisa'],
                        'codpago'       => $value['codpago'],
                        'codcliente'    => $value['codcliente'],
                        'codserie'      => $value['codserie'],
                        'deabono'       => $value['deabono'],
                        'fecha'         => $value['fecha'],
                        'hora'          => $value['hora'],
                        'idfactura'     => $value['idfactura'],
                        'lineasfactura' => $value['lineasfactura'],
                        'nombre'        => $value['nombrecliente'],
                        'telefono'      => $value['telefono'],
                        'direccion'     => $value['direccion'],
                        'numero'        => $value['numero'],
                        'observaciones' => $value['observaciones'],
                        'fp'            => $value['fp'],
                        'total'         => $value['total'],
                        'totaldto'      => $value['totaldto'],
                        'totaliva'      => $value['totaliva'],
                        'totalrecargo'  => $value['totalrecargo'],
                        'estado'        => $value['estado'],
                        'total_recibos' => ($acum  ?? 0),
                    );
                }
                echo json_encode($dato);
            }
        } else {
            $this->vista('directiva', array(
                'titulo'   => 'Upps',
                'mensaje'  => 'No deberías estar aquí',
                'problema' => 'su soicitud, No es una página para acceder por URL '
            ));
        }
    }
    /**
     * Metodo utilizado para datatable de recibos de clientes
     * @access public
     * @param = filters
     * @return  json
     * @method ajax
     */

    public function dataTableNotes()
    {

        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //Tabla a usar
            $table = 'facturasnotes';

            //Llave primaria de la tabla
            $primaryKey = 'idfactura';
            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.
            $columns = array(
                array('db' => 'cifnif', 'dt' => 'cifnif'),
                array('db' => 'numero', 'dt' => 'numero'),
                array('db' => 'numero2', 'dt' => 'numero2'),
                array('db' => 'prefijo', 'dt' => 'prefijo'),
                array('db' => 'coddivisa', 'dt' => 'coddivisa'),
                array('db' => 'codpago', 'dt' => 'codpago'),
                array('db' => 'codcliente', 'dt' => 'id_cliente'),
                array('db' => 'codserie', 'dt' => 'codserie'),
                array('db' => 'deabono', 'dt' => 'deabono'),
                array('db' => 'fecha', 'dt' => 'fecha'),
                array('db' => 'hora', 'dt' => 'hora'),
                array('db' => 'nombrecliente', 'dt' => 'nombrecliente'),
                array('db' => 'observaciones', 'dt' => 'observaciones'),
                array('db' => 'total', 'dt' => 'total'),
                array('db' => 'totaliva', 'dt' => 'totaliva'),
                array('db' => 'totaldto', 'dt' => 'totaldto'),
                array('db' => 'totalrecargo', 'dt' => 'totalrecargo'),
                array('db' => 'totalretencion', 'dt' => 'totalretencion'),
                array('db' => 'fecha_hora_dian', 'dt' => 'fecha_hora_dian'),
                array('db' => 'estado', 'dt' => 'estado'),
                array('db' => 'idfactura', 'dt' => 'idfactura'),
                array('db' => 'estadodian2', 'dt' => 'estadodian2'),
                array('db' => 'id', 'dt' => 'id'),
            );

            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            header('Content-type: application/json; charset=utf-8');
            if (isset($_POST['id']) && $_POST['id'] != '') {
                //Retornamos los valores consultados con filtro
                $where = "estado = {$_POST['id']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } else if (isset($_POST['idf']) && $_POST['idf'] != '') {
                //Retornamos los valores consultados con filtro
                $where = "idfactura = {$_POST['idf']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } else {
                //Retornamos los valores consultados sin filtro
                echo json_encode(
                    $this->ssp->simple($_POST, $sql_details, $table, $primaryKey, $columns),
                    JSON_PRETTY_PRINT
                );
            }
        } else {
            $this->vista('404') . exit();
        }
    }

    public function GenerarXls()
    {
        if (isset($_GET['from'], $_GET['to']) && !empty($_GET['from']) && !empty($_GET['to'])) {
            if (isset($_GET['client'])) {
                $client = $this->ModelClient->where("nombre", $_GET['client'])->first();
            } else {
                $client = null;
            }
            $facturas = FacturaCliente::with(['Client', 'Lines'])->select("idfactura", "fecha", "numero", "numero2", "referencia", "coddivisa", "neto", "totaliva", "totalretencion", "total", "codcliente")->where(function ($q) use ($client) {
                $q->where("fecha", ">=", $_GET['from'])->where("fecha", "<=", $_GET['to']);
                if ($client != null) {
                    $q->where("codcliente", $client->id_cliente);
                }
            })->get();
            $data = array();
            foreach ($facturas as $key => $value) {
                $facturas[$key]->cliente = $value->Client->nombre;
                $facturas[$key]->cifnif = $value->Client->cifnif . "-" . $value->Client->cifnif_dv;
                $facturas[$key]->descripcion = "";
                foreach ($facturas[$key]->Lines as $key2 => $value2) {
                    $facturas[$key]->descripcion .= $value2->descripcion . "\n";
                }
                $dat = $facturas[$key]->toArray();
                unset($dat['client']);
                unset($dat['coddivisa']);
                unset($dat['idfactura']);
                unset($dat['lines']);
                unset($dat['codcliente']);
                array_push($data, $dat);
            }
            //print_debug($data);
            error_reporting(0);
            return new Excel(array(
                'requirement' => 'list',
                'title'       => 'Invoices',
                'subject'     => 'Invoices LIST',
                'description' => 'Este arhivo fue generado por el modulo Facturacion',
                'keywords'    => 'Informes, listados',
                'category'    => 'Informes',
                'columns'     => array(
                    'FECHA',
                    'NUMERO PRE',
                    'NUMERO FE',
                    'REFERENCIA',
                    'NETO',
                    'TOTAL IMPUESTOS',
                    'TOTAL RETENCIÓN',
                    'TOTAL',
                    'CLIENTE',
                    'NIT',
                    'DESCRIPCION'
                ),
                'info'        => $data,
                'config_data' => 'array',
            ));
        } else {
            echo "Datos incorrectos";
        }
    }

    public function TestBar70()
    {
      
    }
}
