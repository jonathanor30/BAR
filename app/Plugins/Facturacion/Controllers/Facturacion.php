<?php

use Illuminate\Database\Capsule\Manager as DB;
use Models\Configs\itemClasificator\itemClasificator;
use Models\FacturaCliente\FacturaCliente;

if (file_exists(dirname(dirname(__FILE__)) . "/vendor/autoload.php")) {
    require dirname(dirname(__FILE__)) . "/vendor/autoload.php";
}
require_once 'Proveedores.php';
require_once 'Clientes.php';
require_once 'Fe.php'; //Importante;
/**
 * @author PlenusServices
 */
class Facturacion extends Controller
{
    //Declaracion de variables a utilizar
    public $cron;
    public $PluginName;
    public $ModelFact;
    public $folderImg;
    public $folderPdf;
    public $Proveedores;
    public $Clientes;
    public $modelClient;
    public $modelFe;
    public $facturacion_electronica;
    public $config;

    //Iniciamos el constructor
    public function __construct()
    {
        $this->cron = true; //cron modulo
        $this->PluginName = __CLASS__; //def nombre plugin
        //$this->ModuleMant($this->PluginName);
        $this->sessionValidator(); //Validamos sesion
        $this->BOOTORM();
        $this->ModelFact = $this->modelo('ModelFact', $this->PluginName); //instanciamos modelo
        $this->ModelProv = $this->modelo('ModelProv', $this->PluginName); //instanciamos modelo
        $this->ModelClient = $this->modelo('ModelClient', $this->PluginName);
        $this->modelFe = $this->modelo('ModelFE', $this->PluginName);
        $this->folderCreator($this->PluginName); //iniciamos y defniimos carpetas a usar
        $this->folderImg = RUTA_UPLOAD . $this->PluginName . SEPARATOR . 'img' . SEPARATOR;
        $this->folderPdf = RUTA_UPLOAD . $this->PluginName . SEPARATOR . 'pdf' . SEPARATOR;
        $this->code_install = '$2y$10$LPijeao/M9lZHWk5rFytVus/.8pnxyCK6JS4oml2XXpkySrYRtfYu';
        $this->AutoloaderModules(RUTA_PLUGINS . $this->PluginName . DIRECTORY_SEPARATOR);
    }

    //index
    public function index()
    {
       
        $data = [
            'titulo'      => 'Facturación',
            'icon'        => 'fas fa-file-invoice-dollar',
            'countinv'    => $this->ModelProv->Count('facturasprov'),
            'countprov'   => $this->ModelProv->Count('proveedores'),
            'countouts'   => $this->ModelProv->Count('recibos_proveedor'),
            'countinvcli' => $this->ModelProv->Count('facturascli'),
            'countcli'    => $this->ModelProv->Count('clientes'),
            'configFE'    => $this->modelFe->getConfig(),
            'countins'    => $this->ModelProv->Count('ingresos_clientes'),
            'Name'        => $this->PluginName,
            'liabilities' => $this->ModelClient->GetAll('type_liabilities'),
            'dataTables' => dataTables(),
        ];
       
       $this->vista('index', $data, $this->PluginName);
    }

    //Metodo page que busca los metodos en los controladores
    public function page($pag = null, $param1 = null, $param2 = null)
    {
        if ($pag != null) {
            if (!method_exists($this->PluginName, $pag)) {
                $this->Proveedores = new Proveedores();
                $this->Clientes = new Clientes();
                if (method_exists($this->Proveedores, $pag)) {
                    return $this->Proveedores->$pag($param1, $param2);
                } elseif (method_exists($this->Clientes, $pag)) {
                    return $this->Clientes->$pag($param1, $param2);
                } else {
                    return $this->vista('404') . exit();
                }
            }
        } else {
            redireccionar('/Facturacion');
        }
    }

    //Notas de despliegue
    //Comprobar que la base de datos mysql sea sensible a mayusculas y minusculas
    public function install($code_install = false)
    {
        if ($code_install != false && password_verify($code_install, $this->code_install)) {
            $tablas           = $this->ModelFact->showTables();

            $tablas_existentes = array();
            $tablas_instalador = array(
                'divisas',
                'facturacion_electronica',
                'facturascli',
                'facturasprov',
                'notas_dian',
                'paises',
                'proveedores',
                'recibos_proveedor',
                'lineasfacturascli',
                'lineasfacturasprov',
                'ingresos_clientes',
                'clientes',
            );


            foreach ($tablas as $key => $value) {
                array_push($tablas_existentes, $value['Tables_in_' . DB_NAME]);
            }
            $contador = 0;
            foreach ($tablas_existentes as $key1 => $value1) {
                foreach ($tablas_instalador as $key2 => $value2) {
                    if ($value1 == $value2) :
                        $contador++;
                    endif;
                }
            }
            if ($contador == 0) {
                if (file_exists(RUTA_PLUGINS . $this->PluginName . SEPARATOR . 'Controllers' . SEPARATOR . 'Install.php')) {
                    require_once 'Install.php';
                    $installer          = new Install;
                    $this->modelInstall = $this->modelo('Installer', $this->PluginName);
                    if ($this->modelInstall->deployment($installer->create_tables())) {
                        $datos = [
                            'titulo' => 'Instalación Plugin ' . $this->PluginName,
                        ];
                        return $this->vista(
                            'Install',
                            $datos,
                            $this->PluginName,
                            'formatter'
                        ) . exit();
                    } else {
                    }
                } elseif ($contador >= 1 && $contador <= 11) {
                    return $this->vista('directiva', array(
                        'titulo'   => 'ERROR FATAL',
                        'mensaje'  => 'Contacte a soporte técnico',
                        'problema' => 'con el proceso de instalación y/o verificación de tablas',
                    )) . exit();
                }
            } else {
            }
        } else {
        }
    }

    /**
     * Método ajaxFE()
     * se encarga de gestionar las peticiones asincronas del objeto de facturacion electronica.
     *
     * @param $metodo
     */
    public function ajaxFE($metodo = false, $param1 = false)
    {
        //comprobar integridad del argumento $metodo
        if (isset($metodo) && $metodo != '' && $metodo != false) {
            $this->facturacion_electronica = new Fe();
            //Comprobación que exista el método que se esta mandando a llamar
            if (method_exists($this->facturacion_electronica, $metodo)) {
                $this->facturacion_electronica->$metodo($param1);
            } else {
                //De lo contratrario y no existe el método se imprimi el siguiente mensaje
                echo json_encode('El metodo ' . $metodo . ' no existe', JSON_PRETTY_PRINT);
            }
        } else {
            echo json_encode('Debe indicar el metodo que necesita', JSON_PRETTY_PRINT);
        }
    }

    /**
     * Método dinamic password
     * Se utiliza para confirmar cambios a nivel administrador del módulo.
     */
    public function dinamicPass()
    {
        $tiempo = getdate();
        $hora = $tiempo['hours'];
        $minutos = $tiempo['minutes'];
        $dia = $tiempo['mday'];

        $password = $minutos . '-' . $hora . '-' . $dia;
        //contraseña es igual a: minutos-hora-dia;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['password']) && !empty($_POST['password']) && $_POST['password'] === $password) {
                $_SESSION['dinamic_password'] = true;
                echo true;
            } else {
                echo false;
            }
        }
    }

    /**
     * Método cron
     * Se encarga de gestionar las tareas programadas para el módulo
     * Facturacion
     * @access public
     */
    public function cron()
    {
        $this->config = $this->modelFe->getConfig();
        echo "ejecutando cron " . $this->PluginName . " " . date("Y-m-d H:m:s");
        $dias        = 10; //Días de anticipación para la alerta
        $hoy         = date("Y-m-d");

        //Comprobar vencimiento de certificado de firma digital
        if (date_create($this->config->vigencia_certificado) <= date_create("now +{$dias} day")) {
            //Enviar alerta de alerta de Licencia de conducción
            $this->emailQuery(array(
                'documento' => 'Vigencia de firma digital',
                'tipo'      => 'parámetros de Facturación',
                'id'        => 'Certificado de firma digital',
                'fecha'     => $this->config->vigencia_certificado,
            ));
        }

        //Comprobar vencimiento de certificado de firma digital
        if (date_create($this->config->vigencia_resolucion) <= date_create("now +{$dias} day")) {
            //Enviar alerta de alerta de Licencia de conducción
            $this->emailQuery(array(
                'documento' => 'Autorización numeración de facturación',
                'tipo'      => 'parámetros de Facturación',
                'id'        => 'Resolución de facturación',
                'fecha'     => $this->config->vigencia_resolucion,
            ));
        }
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

    public function EnableSystem()
    {
        if ($_SERVER['REQUEST_METHOD']) {
            if ($this->ModelFact->Enablesystem($_POST)) {
                echo true;
            } else {
                echo false;
            }
        } else {
            redireccionar("/" . $this->PluginName);
        }
    }

    public function Test()
    {
        $model = new FacturaCliente;
        //print_debug($model);
    }

    /**
     * Metodo utilizado para datatable de facturas proveedor
     * @access public
     * @param = filters
     * @return  json
     * @method ajax
     */

    public function dataTableResoluciones()
    {

        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //Tabla a usar
            $table = 'resolutions';

            //Llave primaria de la tabla
            $primaryKey = 'id';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.
            $columns = array(

                array('db' => 'id', 'dt' => 'id'),
                array('db' => 'number', 'dt' => 'number'),
                array('db' => 'prefix', 'dt' => 'prefix'),
                array('db' => 'resolution', 'dt' => 'resolution'),
                array('db' => 'resolution_date', 'dt' => 'resolution_date'),
                array('db' => 'technical_key', 'dt' => 'technical_key'),
                array('db' => 'from_number', 'dt' => 'from'),
                array('db' => 'to_number', 'dt' => 'to'),
                array('db' => 'date_from', 'dt' => 'date_from'),
                array('db' => 'date_to', 'dt' => 'date_to'),
                array('db' => 'type', 'dt' => 'type'),
                array('db' => 'status', 'dt' => 'status'),
            );

            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            header('Content-type: application/json; charset=utf-8');
            if (isset($_POST['year']) && $_POST['year'] != '') {
                //Retornamos los valores consultados con filtro
                $where = "YEAR(resolution_date) = {$_POST['year']}" . (isset($_POST['status']) && !empty($_POST['status']) ? " AND status={$_POST['status']}" : "");
                echo json_encode(
                    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } elseif (isset($_POST['cifnif']) && $_POST['cifnif'] != '') {
                //Retornamos los valores consultados con filtro
                $where = "codcliente = {$_POST['cifnif']}";
                echo json_encode(
                    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } else {
                //Retornamos los valores consultados sin filtro
                echo json_encode(
                    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns),
                    JSON_PRETTY_PRINT
                );
            }
        } else {
            $this->vista('404') . exit();
        }
    }

    public function DeleteResolution()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $invoices = FacturaCliente::where("resolution_id", $_POST['id'])->get();
            if($invoices->count() == 0){
                if (DB::table($_POST['table'])->where($_POST['key'], $_POST['id'])->delete()) {
                    $this->writeLog = new LogManager(array(
                        'tipo'    => 'DANGER',
                        'mensaje' => 'El usuario ' . $_SESSION['user_name'] . ' ha eliminado el registro de la tabla ' . $_POST['table'] . ' con id ' . $_POST['id'],
                    ));
    
                    echo true;
                } else {
                    echo false;
                }
            }else{
                echo "Esta resolución posee facturas asociadas, no se puede eliminar";
            }
            
        } else {
            redireccionar("");
        }
    }

    public function GetResolution()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            echo json_encode(\Models\Configs\Resolutions\Resolutions::where("id", $_POST['id'])->first(), JSON_PRETTY_PRINT);
        } else {
            redireccionar("");
        }
    }

    public function SaveResolution()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                if (\Models\Configs\Resolutions\Resolutions::where("id", $_POST['id'])->update($_POST)) {
                    echo true;
                } else {
                    echo false;
                }
            } else {
                $_POST['number'] = (\Models\Configs\Resolutions\Resolutions::where("type", $_POST['type'])->get()->last() != null ? \Models\Configs\Resolutions\Resolutions::where("type", $_POST['type'])->get()->last()->number + 1:1);
                if ($_POST['status'] == 1) {
                    \Models\Configs\Resolutions\Resolutions::where("type", $_POST['type'])->update(["status" => 2]);
                }
                if (\Models\Configs\Resolutions\Resolutions::create($_POST)) {
                    echo true;
                } else {
                    echo false;
                }
            }
        } else {
            redireccionar("");
        }
    }
    public function AutoloaderModules(string $path)
    {

        try {

            spl_autoload_register(function ($className) use ($path) {
                //Instantiated by the new statement 
                if (file_exists($path . str_replace('\\', '/', $className) .  '.php')) :
                    require_once $path . str_replace('\\', '/', $className) .  '.php';
                else :
                    //Instance by namespace
                    if ($className != 'int') :
                        $class = explode('\\', $className);
                        if (file_exists($path . str_replace('\\', '/',  join("\\", array_unique($class))) .  '.php')) :
                            require_once  $path . str_replace('\\', '/',  join("\\", array_unique($class))) .  '.php';
                        endif;
                    endif;
                endif;
            });
        } catch (\Exception $th) {
            throw $th;
        }
    }
    public function BOOTORM()
    {
        $capsule = new DB;
        $capsule->addConnection([
            'driver'    => DB_DRIVER,
            'host'      => DB_HOST,
            'database'  => DB_NAME,
            'username'  => DB_USER,
            'password'  => DB_PASS,
            'charset'   => "utf8",
            'collation' => "utf8_unicode_ci",
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
    public function EditFeProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (\Models\Configs\Company\Company::where("id_config", 1)->update($_POST)) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            redireccionar("");
        }
    }

    /**
     * Metodo autocompletar Cliente
     * @access public
     * @return array JSON
     */

    public function autoCompletarCodigo($campo)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['term'])) {
                $dato = array();
                $rows = \Models\Producto\Producto::where($campo, "LIKE", "%" . $_GET['term'] . "%")->get()->toArray();
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

    public function test12()
    {
        $linea = 0;
        //Abrimos nuestro archivo
        $archivo = fopen($this->folderPdf . "itemClasif.csv", "r");
        //Lo recorremos
        $datosEL = [];
        while (($datos = fgetcsv($archivo, ",")) == true) {
            $data = [];
            $num = count($datos);
            $linea++;
            //Recorremos las columnas de esa linea
            for ($columna = 0; $columna < $num; $columna++) {
                array_push($data, $datos[$columna]);
            }
            array_push($datosEL, $data);
        }
        foreach ($datosEL as $key => $value) {
            $dat = new itemClasificator;
            $dat->parent_code = $value[0];
            $dat->parent_name = $value[1];
            $dat->family_code = $value[2];
            $dat->family_name = $value[3];
            $dat->class_code = $value[4];
            $dat->class_name = $value[5];
            $dat->product_code = $value[6];
            $dat->product_name = $value[7];
            $dat->save();
        }
        //print_r($datosEL);
        //Cerramos el archivo
        fclose($archivo);
    }
}
