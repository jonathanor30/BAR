<?php

/**
 * 
 * 
 * @author PlenusServices
 */

use Models\Configs\Resolutions\Resolutions;

//Requerimos los otros controladores
require_once 'Facturacion.php';
require_once 'Clientes.php';
class Proveedores extends Controller
{
    /** 
     * variable de instancia al modelo
     * @var = $ModelProv
     * @access public
     */
    public $ModelProv;
    /**
     * variable Maestra
     * @var = $Proveedores
     * @access public
     */
    public $Proveedores;
    /**
     * Variable Clase SSP para dataTables     
     * @var = $ssp
     *  @access public
     */
    public $ssp;
    /**
     * Variables de carpetas
     * @access public
     * @var $folderImg
     * @var $folderPdf
     */
    public $folderImg;
    public $folderPdf;
    /**
     * Creamos constructor
     * @access public
     * @return none
     */
    public function __construct()
    {

        $this->Proveedores = __CLASS__;                                                    //Definimos  
        $this->ModelProv   = $this->modelo('ModelProv', 'Facturacion');                    //instancia al modelo
        $this->ssp         = new SSP;                                                      //instancio clase SSP para datatables
        $this->folderImg   = RUTA_UPLOAD . 'Facturacion' . SEPARATOR . 'img' . SEPARATOR;
        $this->folderPdf   = RUTA_UPLOAD . 'Facturacion' . SEPARATOR . 'pdf' . SEPARATOR;
        $this->Excel       = new PHPExcel;
        $this->modelPerfil  = $this->modelo('Perfil');
        $this->modelPerfil  = $this->modelo('Perfil');
    }
    //---------------------------------------------------------------------Vistas

    /**
     * Metodo providers a la vista proveedores
     * @access public
     * @param = null
     * @return  vista_Proveedores
     * Vista proveedores
     */
    public function Providers()
    {
        $countries = $this->ModelProv->countries();
        $data      = [
            'titulo'     => 'Proveedores',
            'icon'       => 'fas fa-users',
            'dataTables' => dataTables(),
            'datos'      => $countries
        ];
        $this->vista('Proveedores/providers', $data, 'Facturacion');
    }
    //

    /**
     * Metodo proveedor Detallado
     * @access public
     * @param = $id
     * Id de proveedor a mirar detalladamente
     * @return  vista
     * Vista detalle proveedor
     */
    public function Provdetail($id)
    {
        $reg = $this->ModelProv->Prov($id);
        $this->pagina404($reg);
        if ($reg != "" || $reg != false) {

            $div       = $this->ModelProv->Divisas();
            $countries = $this->ModelProv->countries();
            $data      = [
                'titulo'     => 'Proveedores',
                'icon'       => 'fas fa-users',
                'dataTables' => dataTables(),
                'datos'      => $reg,
                'div'        => $div,
                'country'    => $countries
            ];
            $this->vista('Proveedores/detailprovider', $data, 'Facturacion');
        } else {
        }
    }
    /**
     * Metodo a vista facturas
     * @access public
     * @param = null
     * @return vista
     * Vista facturas proveedor
     */
    public  function InvoicesProv()
    {

        $datos = array(
            'titulo'     => 'Facturas Proveedores',
            'icon'       => 'fas fa-file-invoice-dollar',
            'dataTables' => dataTables(),
        );
        $this->vista('Proveedores/Invoicesprov', $datos, 'Facturacion');
    }

    /**
     * Metodo vista a nueva factura proveedor
     * @access public
     * @param = null
     * @return vista
     * Vista Nueva factura
     */
    public function FacturaProveedor()
    {
        $datos = [
            'titulo' => 'Nueva factura',
            'icon'   => 'fas fa-file-invoice-dollar',
        ];
        $this->vista('Proveedores/Newinvprov', $datos, 'Facturacion');
    }
    /**
     * Metodo factura detallada
     * @access public 
     * @param = $id_factura
     * Id factura asociada a proveedor
     * @return 
     * Vista factura detallada
     */
    public function ProvFactDetail($id_factura)
    {
        $factura = $this->ModelProv->Inv($id_factura);
        $this->pagina404($factura);
        $proveedor = $this->ModelProv->Prov($factura[0]->codproveedor);
        $this->pagina404($proveedor);
        $datos = array(
            'titulo'     => 'Editar Factura',
            'icon'       => 'fas fa-file-invoice-dollar',
            'datos'      => $this->ModelProv->Inv($id_factura),
            'recibo'     => $this->ModelProv->Recibo($id_factura, 'idfactura'),
            'proveedor'  => $proveedor,
            'dataTables' => dataTables(),
        );
        $this->vista('Proveedores/EditInvoiceProv', $datos, 'Facturacion');
    }
    /**
     * Metodo recibos
     * @access public
     * @param = null
     * @return vista
     * Vista de egresos
     */
    public function Outprov()
    {
        $datos = array(
            'titulo'     => 'Egresos',
            'icon'       => 'fas fa-file-invoice-dollar',
            'dataTables' => dataTables(),
            'div'        => $this->ModelProv->Divisas()
        );
        $this->vista('Proveedores/Outs', $datos, 'Facturacion');
    }
    /**
     * Metodo para ver recibos detalladamente
     * @access public
     * @param = $id_recibo
     * Id de recibo a ver datalladamente
     * @return vista
     * Vista recibo detallado 
     */
    public function detailOut($id_recibo)
    {
        $recibo = $this->ModelProv->Recibo($id_recibo, 'id_recibo');
        $this->pagina404($recibo);
        $factura = $this->ModelProv->Inv($recibo[0]->idfactura);
        $data    = array(
            'titulo'  => 'Recibo detallado',
            'icon'    => 'fas fa-file-invoice-dollar',
            'last'    => $recibo,
            'invoice' => $factura,
            'divisas' => $this->ModelProv->Divisas()
        );
        $this->vista('Proveedores/detailOutprov', $data, 'Facturacion');
    }
    //---------------------------------------------------------------------/Vistas
    //---------------------------------------------------------------------CRUD Provedores

    /**
     * Metodo para guardar proveedores
     * @access public
     * @param = null
     * @return  bool
     * @method ajax
     */
    public function AddProv()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $exc = array('telefono1', 'country', 'deptoprov', 'cityprov', 'codpprov', 'addrprov');
                $dat = $this->formValidator($_POST, $exc);
                if (!isset($_POST['personafisica'])) {
                    $_POST['personafisica'] = 0;
                } else {
                    $_POST['personafisica'] = 1;
                }
                foreach ($_POST as $key => $value) {
                    if ($key != 'email') {
                        $_POST[$key] = strtoupper($_POST[$key]);
                    }
                }
                if ($this->ModelProv->SaveProv($_POST)) {
                    $saved = $this->ModelProv->Last('proveedores', 'codproveedor');
                    echo true . "," . $saved->codproveedor;
                } else {
                    echo false;
                }
            } else {
                return $this->vista('directiva', array(
                    'titulo'   => 'Upps',
                    'mensaje'  => 'No deberías estar aquí',
                    'problema' => 'su solicitud, No es una página para acceder por URL'
                ));
            }
            $_POST = array();
        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Editar proveedor
     * @access public
     * @param = null
     * @return  bool
     * @method ajax
     */
    public function EditProv()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['provname'])) {
                $exc = array('obs', 'estado');
                $dat = $this->formValidator($_POST, $exc);
                if (!isset($_POST['personafisica'])) {
                    $_POST['personafisica'] = 0;
                } else {
                    $_POST['personafisica'] = 1;
                }
                foreach ($_POST as $key => $value) {
                    if ($key != 'email') {
                        $_POST[$key] = strtoupper($_POST[$key]);
                    }
                }
                if (is_array($dat)) {
                    if ($this->ModelProv->EditProv($_POST)) {
                        echo true;
                    } else {
                        echo false;
                    }
                }
            } else if (isset($_POST['bancname'])) {
                $exc = array();
                $dat = $this->formValidator($_POST, $exc);
                foreach ($_POST as $key => $value) {
                    if ($key != 'email') {
                        $_POST[$key] = strtoupper($_POST[$key]);
                    }
                }
                if (is_array($dat)) {
                    if ($this->ModelProv->EditProv($_POST)) {
                        echo true;
                    } else {
                        echo false;
                    }
                }
            } else if (isset($_POST['addressprov'])) {
                $exc = array('codpprov');
                $dat = $this->formValidator($_POST, $exc);
                foreach ($_POST as $key => $value) {
                    if ($key != 'email') {
                        $_POST[$key] = strtoupper($_POST[$key]);
                    }
                }
                if (is_array($dat)) {
                    if ($this->ModelProv->EditProv($_POST)) {
                        echo true;
                    } else {
                        echo false;
                    }
                }
            } else {
                echo 'ERROR, no hay datos a guardar';
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
    public function Delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id    = $_POST['id'];
            $table = $_POST['table'];
            $key   = $_POST['key'];
            if ($_SESSION['user_type'] == 1 && $table == 'facturasprov') {
                if ($this->ModelProv->Delete($id, $table, $key)) {
                    //Log inicio de sesión
                    if ($this->ModelProv->Delete($id, 'lineasfacturasprov', 'idfactura')) {
                        $this->writeLog = new LogManager(array(
                            'tipo'    => 'DANGER',
                            'mensaje' => 'El usuario ' . $_SESSION['user_name'] . ' ha eliminado el registro de la tabla ' . $table . ' con id ' . $id,
                        ));

                        echo true;
                    }
                } else {
                    echo false;
                }
            } else if ($_SESSION['user_type']  != 1 && $table == 'facturasprov') {
                echo "Usted no tiene los permisos necesarios para esta acción";
            } else if ($_SESSION['user_type'] == 1 && $table == 'proveedores') {
                $prov = $this->ModelProv->Prov($id);
                if ($prov->adjunto_pdf != null || $prov->adjunto_pdf != '') {
                    if (unlink($this->folderPdf . $prov->adjunto_pdf)) {
                        if ($this->ModelProv->Asociated($id) == 0) {
                            if ($this->ModelProv->Delete($id, $table, $key)) {
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
                    } else {
                        echo "Error al eliminar el adjunto";
                    }
                } else {
                    if ($this->ModelProv->Asociated($id) == 0) {
                        if ($this->ModelProv->Delete($id, $table, $key)) {
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
                }
            } else if ($_SESSION['user_type']  != 1 && $table == 'proveedores') {
                echo "Usted no tiene los permisos necesarios para esta acción";
            } else {
                if ($this->ModelProv->Delete($id, $table, $key)) {
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
    }
    //-----------------------------------------------------------------------------/CRUD Proveedores
    //------------------------------------------------------------------------------CRUD Facturas Proveedor
    /**
     * Metodo para guardar Facturas
     * @access public
     * @param = null
     * @return bool
     * @method  ajax
     */
    public function SaveInvProv()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exc = array('FacObservacion', 'FacEstado', 'FacRef');
            if (is_array($this->formValidator($_POST, $exc))) {
                if (isset($_POST['numero_item'])) {
                    $rec = array(
                        'ClieNit'        => $_POST['ClieNit'],
                        'codproveedor'   => $_POST['codproveedor'],
                        'ClieNombre'     => $_POST['ClieNombre'],
                        'ClieTelefono'   => $_POST['ClieTelefono'],
                        'ClieEmail'      => $_POST['ClieEmail'],
                        'ClieDireccion'  => $_POST['ClieDireccion'],
                        'FacFecha'       => $_POST['FacFecha'],
                        'FormaPago'      => $_POST['FacFormaPago'],
                        'FacEstado'      => $_POST['FacEstado'],
                        'numero_item'    => count($_POST['numero_item']),
                        'FacObservacion' => $_POST['FacObservacion'],
                        'numero'         => $this->ModelProv->Number('facturasprov', 'idfactura'),
                        'referencia'     => $_POST['FacRef'],
                    );
                    if ($this->ModelProv->SaveInvProv($rec)) {
                        $last  = $this->ModelProv->Last('facturasprov', 'idfactura');
                        $cont  = 0;
                        $dto = 0;
                        $iva = 0;
                        $total = 0;
                        $Ret = 0;
                        foreach ($_POST['numero_item'] as $key => $value) {
                            $dat = array(
                                'idfactura'       => $last->idfactura,
                                'No_linea'        => $cont + 1,
                                'ProdNombre'      => $_POST['ProdNombre'][$key],
                                'cantidad'        => $_POST['cantidad'][$key],
                                'ProdPrecioVenta' => $_POST['ProdPrecioVenta'][$key],
                                'dto'             => $_POST['dto'][$key],
                                'subtotal'        => $_POST['subtotal'][$key],
                                'RE'              => $_POST['RE'][$key],
                                'iva'             => $_POST['iva'][$key],
                                'total'           => $_POST['total'][$key],
                            );
                            if ($this->ModelProv->SaveInvProv($dat)) {
                              
                                $cont++;
                                $total = $total + $dat['total'];
                                $dto = $dto + $dat['dto'];
                                $iva = $iva + $dat['iva'];
                                $Ret = $Ret + $dat['RE'];
                            } else {
                                echo false;
                            }
                        }
                        //echo $cont."--".count($_POST['numero_item']);
                        if ($cont == count($_POST['numero_item'])) {
                            if ($this->ModelProv->SaveInvProv(array(
                                'total' => $total,
                                'id'    => $last->idfactura,
                                'iva'   => $iva,
                                'dto'   => $dto,
                                'RE'    => $Ret,
                            ))) {
                                if ($_POST['FacEstado'] == 1) {
                                    $pr  = $this->ModelProv->Prov($_POST['codproveedor']);
                                    $inf = array(
                                        'prov'          => $_POST['ClieNombre'],
                                        'idf'           => $last->idfactura,
                                        'importe'       => $total,
                                        'fecha_emitido' => date('Y-m-d'),
                                        'concepto'      => 'Recibo generado para la factura pagada numero ' . $last->numero,
                                        'codprov'       => $_POST['codproveedor'],
                                        'divisa'        => $pr->divisa,
                                        'fp_recibo'     => $_POST['FacFormaPago'],
                                        'vencimiento'   => date('Y-m-d'),
                                        'pagado'        => 'Si',
                                        'notificado'    => 'Si',
                                        'estado_recibo' => 1,
                                    );
                                    if ($this->ModelProv->AddRecibo($inf)) {
                                        echo true . "-" . $last->idfactura;
                                    }
                                } else {
                                    echo true . "-" . $last->idfactura;
                                }
                            }
                        } else {
                            echo false;
                        }
                    } else {
                        echo false;
                    }
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
     * Metodo para editar facturas proveedor
     * @access public
     * @param = null
     * @return bool
     * @method ajax
     */
    public function EditInvProv()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exc = array('FacObservacion', 'FacEstado', 'FacRef');
            if (is_array($this->formValidator($_POST, $exc))) {
                if (isset($_POST['numero_item']) && $_POST['FacEstado'] != 3) {
                    if ($_POST['FacEstado'] != 3) {
                        $rec = array(
                            'ClieNit'        => $_POST['ClieNit'],
                            'codproveedor'   => $_POST['codproveedor'],
                            'ClieNombre'     => $_POST['ClieNombre'],
                            'ClieTelefono'   => $_POST['ClieTelefono'],
                            'ClieEmail'      => $_POST['ClieEmail'],
                            'ClieDireccion'  => $_POST['ClieDireccion'],
                            'FacFecha'       => $_POST['FacFecha'],
                            'FormaPago'      => $_POST['FacFormaPago'],
                            'FacEstado'      => $_POST['FacEstado'],
                            'numero_item'    => count($_POST['numero_item']),
                            'FacObservacion' => $_POST['FacObservacion'],
                            'idfactura'      => $_POST['idfactura'],
                            'referencia'     => $_POST['FacRef'],
                        );
                        if ($this->ModelProv->EditInvProv($rec)) {
                            $cont  = 0;
                            $total = 0;
                            $dto = 0;
                            $iva = 0;
                            $total = 0;
                            $Ret = 0;
                            foreach ($_POST['numero_item'] as $key => $value) {
                                $dat = array(
                                    'idfactura'       => $rec['idfactura'],
                                    'No_linea'        => $cont + 1,
                                    'ProdNombre'      => $_POST['ProdNombre'][$key],
                                    'cantidad'        => $_POST['cantidad'][$key],
                                    'ProdPrecioVenta' => $_POST['ProdPrecioVenta'][$key],
                                    'dto'             => $_POST['dto'][$key],
                                    'subtotal'        => $_POST['subtotal'][$key],
                                    'RE'              => $_POST['RE'][$key],
                                    'iva'             => $_POST['iva'][$key],
                                    'total'           => $_POST['total'][$key],
                                );
                                if ($cont == 0) {
                                    $this->ModelProv->Delete($dat['idfactura'], 'lineasfacturasprov', 'idfactura');
                                }
                                if ($this->ModelProv->EditInvProv($dat)) {
                                    $cont++;
                                    $total = $total + $dat['total'];
                                    $dto = $dto + $dat['dto'];
                                    $iva = $iva + $dat['iva'];
                                    $Ret = $Ret + $dat['RE'];
                                } else {
                                    echo false;
                                }
                            }
                            if ($cont == count($_POST['numero_item'])) {
                                $this->ModelProv->EditInvProv(array(
                                    'total' => $total,
                                    'id' => $rec['idfactura'],
                                    'iva'   => $iva,
                                    'dto'   => $dto,
                                    'RE'    => $Ret,
                                ));
                                echo true . "-" . $rec['idfactura'];
                            } else {
                                echo false;
                            }
                        } else {
                            echo false;
                        }
                    } else {
                        $rec = array(
                            'ClieNit'        => $_POST['ClieNit'],
                            'codproveedor'   => $_POST['codproveedor'],
                            'ClieNombre'     => $_POST['ClieNombre'],
                            'ClieTelefono'   => $_POST['ClieTelefono'],
                            'ClieEmail'      => $_POST['ClieEmail'],
                            'ClieDireccion'  => $_POST['ClieDireccion'],
                            'FacFecha'       => $_POST['FacFecha'],
                            'FormaPago'      => $_POST['FacFormaPago'],
                            'FacEstado'      => $_POST['FacEstado'],
                            'numero_item'    => count($_POST['numero_item']),
                            'FacObservacion' => $_POST['FacObservacion'],
                            'idfactura'      => $_POST['idfactura']
                        );
                        if ($this->ModelProv->EditInvProv($rec)) {
                            $cont  = 0;
                            $total = 0;
                            foreach ($_POST['numero_item'] as $key => $value) {
                                $dat = array(
                                    'idfactura'       => $rec['idfactura'],
                                    'No_linea'        => $cont + 1,
                                    'ProdNombre'      => $_POST['ProdNombre'][$key],
                                    'cantidad'        => $_POST['cantidad'][$key],
                                    'ProdPrecioVenta' => $_POST['ProdPrecioVenta'][$key],
                                    'dto'             => $_POST['dto'][$key],
                                    'subtotal'        => $_POST['subtotal'][$key],
                                    'RE'              => $_POST['RE'][$key],
                                    'iva'             => $_POST['iva'][$key],
                                    'total'           => $_POST['total'][$key],
                                );
                                if ($cont == 0) {
                                    $this->ModelProv->Delete($dat['idfactura'], 'lineasfacturasprov', 'idfactura');
                                }
                                if ($this->ModelProv->EditInvProv($dat)) {
                                    $cont++;
                                    $total = $total + $dat['total'];
                                } else {
                                    echo false;
                                }
                            }
                            if ($cont == count($_POST['numero_item'])) {
                                $this->ModelProv->EditInvProv(array('total' => $total, 'id' => $rec['idfactura']));
                                if ($this->ModelProv->Armor($_POST['idfactura'])) {
                                    echo true . "-" . $rec['idfactura'];
                                } else {
                                    echo "Error al blindarr recibos";
                                }
                            } else {
                                echo false;
                            }
                        } else {
                            echo false;
                        }
                    }
                } else {
                    echo 'No se pueden editar facturas sin lineas, ni facturas completadas';
                }
            } else {
                echo "Te faltan Campos por llenar";
            }
        } else {
            $datos = array(
                'titulo'   => 'Upps!',
                'mensaje'  => 'No deberías estar aquí',
                'problema' => 'su solicitud, No es un metodo para acceder por URL'
            );
            $this->vista('directiva', $datos, 'Facturacion');
        }
        $_POST = array();
    }

    //------------------------------------------------------------------------------/CRUD Facturas Proveedor
    //------------------------------------------------------------------------------CRUD Recibos Proveedor
    /**
     * Metodo para añadir recibos 
     * @access public
     * @param = null
     * @return bool
     * @method ajax
     */
    public function AddOut()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exc = array('invoice', 'id_factura', 'obs', 'total');
            $dat = $this->formValidator($_POST, $exc);
            if (is_array($dat)) {
                if (floatval($_POST['total']) == null || floatval($_POST['total']) == 0) {
                    $_POST['numero'] = $this->ModelProv->Number('recibos_proveedor', 'id_recibo');
                    if ($this->ModelProv->AddOut($_POST)) {
                        $last = $this->ModelProv->Last('recibos_proveedor', 'id_recibo');
                        echo true . "-" . $last->id_recibo;
                    } else {
                        echo false;
                    }
                } else if ($_POST['importe'] <= floatval($_POST['total'])) {
                    $_POST['numero'] = $this->ModelProv->Number('recibos_proveedor', 'id_recibo');
                    if ($this->ModelProv->AddOut($_POST)) {
                        $last = $this->ModelProv->Last('recibos_proveedor', 'id_recibo');
                        echo true . "-" . $last->id_recibo;
                    } else {
                        echo false;
                    }
                } else {
                    echo "El valor de importe debe ser menor o igual al valor de la factura asociada ";
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
    public function EditOut()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exc = array('id_factura', 'observaciones', 'total');
            $dat = $this->formValidator($_POST, $exc);
            if (is_array($dat)) {
                if ($_POST['total'] == null || $_POST['total'] == 0) {
                    if ($this->ModelProv->EditOut($_POST)) {
                        if (isset($_POST['geninv']) && $_POST['geninv'] == 'true') {
                            if ($this->ModelProv->GenInv($_POST)) {
                                if ($this->ModelProv->GenLine($_POST)) {

                                    echo "true-" . $this->ModelProv->Last('facturasprov', 'idfactura')->idfactura;
                                } else {
                                    echo "Error al generar las lineas de factura";
                                }
                            } else {
                                echo 'Error al generar la factura';
                            }
                        } else {
                            if (isset($_POST['id_factura'])) {
                                $inv    = $this->ModelProv->Inv($_POST['id_factura']);
                                $recibo = $this->ModelProv->Recibo($_POST['id_factura'], 'idfactura');
                                $acum   = 0;
                                $pag = 0;
                                foreach ($recibo as $key => $value) {
                                    $acum = $acum + $value->importe;
                                    if ($value->pagado == 'Si') {
                                        $pag++;
                                    }
                                }
                                if (($inv[0]->total - $acum) <= ($inv[0]->total * 0.01) && count($recibo) == $pag) {
                                    if ($this->ModelProv->StateInv($_POST['id_factura']) && $this->ModelProv->StateOut($_POST['id_factura'])) {
                                        echo "true-reload";
                                    } else {
                                        echo 'Error al validar estado factura y recibos';
                                    }
                                } else {
                                    echo "true";
                                }
                            } else {
                                echo "true";
                            }
                        }
                    } else {
                        echo 'Error al editar el recibo';
                    }
                } else if ($_POST['importe'] <= $_POST['total']) {
                    if ($this->ModelProv->EditOut($_POST)) {
                        if (isset($_POST['geninv']) && $_POST['geninv'] == 'true') {
                            if ($this->ModelProv->GenInv($_POST)) {
                                if ($this->ModelProv->GenLine($_POST)) {
                                    echo "true-" . $this->ModelProv->Last('facturasprov', 'idfactura')->idfactura;
                                } else {
                                    echo "Error al generar las lineas de factura";
                                }
                            } else {
                                echo 'Error al generar la factura';
                            }
                        } else {
                            if (isset($_POST['id_factura'])) {
                                $inv    = $this->ModelProv->Inv($_POST['id_factura']);
                                $recibo = $this->ModelProv->Recibo($_POST['id_factura'], 'idfactura');
                                $acum   = 0;
                                $pag = 0;
                                foreach ($recibo as $key => $value) {
                                    $acum = $acum + $value->importe;
                                    if ($value->pagado == 'Si') {
                                        $pag++;
                                    }
                                }
                                if (($inv[0]->total - $acum) <= ($inv[0]->total * 0.01) && count($recibo) == $pag) {
                                    if ($this->ModelProv->StateInv($_POST['id_factura']) && $this->ModelProv->StateOut($_POST['id_factura'])) {
                                        echo "true-reload";
                                    } else {
                                        echo 'Error al validar estado factura y recibos';
                                    }
                                } else {
                                    echo "true";
                                }
                            } else {
                                echo "true";
                            }
                        }
                    } else {
                        echo 'Error al editar el recibo';
                    }
                } else {
                    echo 'El importe no puede ser mayor a el total de la factura asociada';
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
    public function AddRecibo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['state'] == 0) {
                $exc = array('estado_recibo', 'remain', 'outtot', 'state');
                if (is_array($this->formValidator($_POST, $exc))) {
                    if (floatval($_POST['importe']) <= floatval($_POST['tot']) - (floatval($_POST['outtot'])) ?? 0) {
                        if ($this->ModelProv->AddRecibo($_POST)) {
                            if (isset($_POST['idf'])) {
                                $inv    = $this->ModelProv->Inv($_POST['idf']);
                                $recibo = $this->ModelProv->Recibo($_POST['idf'], 'idfactura');
                                $acum   = 0;
                                $pag = 0;
                                foreach ($recibo as $key => $value) {
                                    $acum = $acum + $value->importe;
                                    if ($value->pagado == 'Si') {
                                        $pag++;
                                    }
                                }
                                if (($inv[0]->total - $acum) <= ($inv[0]->total * 0.01) && count($recibo) == $pag) {
                                    if ($this->ModelProv->StateInv($_POST['idf']) && $this->ModelProv->StateOut($_POST['idf'])) {
                                        echo true . '-reload';
                                    } else {
                                        echo 'Error al validar estado factura y recibos';
                                    }
                                } else {
                                    echo true . '-' . $_POST['idf'];
                                }
                            } else {
                                echo true . '-' . $_POST['idf'];
                            }
                        }
                    } else {
                        echo 'El importe no puede ser mayor al valor de la factura';
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
    //------------------------------------------------------------------------------/CRUD Recibos Proveedor
    //--------------------------------------------------------------Metodos personalizados
    //-----------------------------------------------------------------------------Importar Excel
    public function ImportarProveedor()
    {
        $ruta = $this->folderPdf;

        if (isset($_FILES)) {
            if ($_FILES['carga']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && $_FILES['carga']['name'] == 'Plantilla.xlsx') {
                $nombreArchivo   =   $_FILES['carga']['name'];
                $tmp_name   =     $_FILES['carga']['tmp_name'];
                $fileType   =     $_FILES['carga']['type'];
                if (isset($_FILES['carga']['tmp_name'])) {
                    if (!empty($nombreArchivo)) {
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                            if (file_exists($ruta)) {
                                if (move_uploaded_file($tmp_name, $ruta . $nombreArchivo)) {
                                    if ($this->guardarDatosExcel($nombreArchivo)) {
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
                                if ($this->guardarDatosExcel($nombreArchivo)) {
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

    public function guardarDatosExcel($name)
    {


        $nombre = $this->folderPdf . $name;
        $inputFileType = PHPExcel_IOFactory::identify($nombre);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($nombre);
        $highestRow = $objPHPExcel->getActiveSheet()->getHighestDataRow('Q');
        $sheet = $objPHPExcel->getSheet()->rangetoArray('A3:' . 'Q' . $highestRow, null, true, true, false);
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
        //print_r($values);
        $cont3 = 0;
        foreach ($values as $key => $value) {
            if ($this->ModelProv->Import($values[$key])) {
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

    public function FicheroProveedor()
    {

        $objPHPExcel = $this->Excel;
        $objPHPExcel->getProperties()
            ->setCreator("Plenus Services")
            ->setLastModifiedBy("Plenus Services")
            ->setTitle("Plantilla")
            ->setSubject("Plantilla")
            ->setDescription("Documento para usar como plantilla para subir proveedores a Base de datos")
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
        $objPHPExcel->getActiveSheet()->setTitle('Proveedores');
        $objPHPExcel->setActiveSheetIndex(0);
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Plantilla.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
    }

    public function glosario()
    {
        $filename = $this->folderPdf . 'Glosario.txt';
        $file = fopen($filename, 'w+');
        fwrite($file, "Glosario  \n
        Tipo doc: NIT/CC/CE= 1,2,3
        Forma Pago: Transf/Efectivo/Cheque=	1,2,3
        Divisa:	COP= COP
        Régimen IVA: Común, Simpl, Simple=	1,2,3
        Persona Física: Sí, No =	1, 0
        Tipo cuenta bancaria: Ahorros, corriente=1, 2
        ");
        fclose($file);
        header('Content-Type: application/octet-stream');
        header("Content-Length:" . filesize($filename) . "");
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        readfile($filename);
    }
    //-----------------------------------------------------------------------------Importar Excel

    /**
     * Metodo para cargar archivos de proveedor
     * @access public
     * @param null
     * @return bool
     */
    public function ProvData()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $prov        = $this->ModelProv->Prov($_POST['id']);
            $filename    = time() . str_replace(' ', '', $_FILES['adjunto_pdf']['name']);
            $filetmpname = $_FILES['adjunto_pdf']['tmp_name'];

            if ($prov->adjunto_pdf != '' && $prov->adjunto_pdf != null) {
                unlink($this->folderPdf . $prov->adjunto_pdf);
                if (move_uploaded_file($filetmpname, $this->folderPdf . $filename)) {
                    $dat = array(
                        'type'   => 1,
                        'nombre' => $filename,
                        'id'     => $_POST['id'],
                    );
                    if ($this->ModelProv->ProvData($dat)) {
                        $prov_s = $this->ModelProv->Prov($_POST['id']);
                        echo true . '-' . $prov_s->adjunto_pdf;
                    } else {
                        echo 'Error al intentar guardar el adjunto';
                    }
                }
            } else {
                if (move_uploaded_file($filetmpname, $this->folderPdf . $filename)) {
                    $dat = array(
                        'type'   => 1,
                        'nombre' => $filename,
                        'id'     => $_POST['id'],
                    );
                    if ($this->ModelProv->ProvData($dat)) {
                        $prov_s = $this->ModelProv->Prov($_POST['id']);
                        echo true . '-' . $prov_s->adjunto_pdf;
                    } else {
                        echo 'Error al intentar guardar el adjunto';
                    }
                }
            }
        } else {
            $data = array(
                'titulo'   => 'Upps!',
                'mensaje'  => 'No deberías estar aquí',
                'problema' => 'su solicitud, NO es un método para acceder por URL',
            );
            $this->vista('directiva', $data, 'Facturacion');
        }
    }
    /**
     * Metodo para cambiar estados proveedores
     * @access public
     * @param = null
     * @return  bool
     * @method ajax
     */
    public function State()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['idA'])) {
                if ($this->ModelProv->State($_POST['idA'], 1)) {
                    echo true;
                } else {
                    echo false;
                }
            }
            if (isset($_POST['idI'])) {
                if ($this->ModelProv->State($_POST['idI'], 0)) {
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
     * verFactura
     * Este método se encarga de mostrar la representación grafica de la factura de venta
     * @access public
     * @param  int $id_egreso
     */
    public function verEgreso($id_egreso)
    {
        $recibo  = $this->ModelProv->Recibo($id_egreso, 'id_recibo');
        $this->pagina404($recibo);
        if (count($recibo) == 1 && $recibo[0]->idfactura != "") {
            $factura = $this->ModelProv->Inv($recibo[0]->idfactura);
            $proveedor = $this->ModelProv->Prov($recibo[0]->codproveedor, 'codproveedor');
            $this->pagina404($proveedor);
        } 
        //Datos de la empresa
        $empresa = $this->modelPerfil->obtenerPerfil();
                       
        //Se comprueba si la factura es electrónica

        //Start output
        ob_start();
        require_once RUTA_PLUGINS . 'Facturacion' . SEPARATOR . 'Views' . SEPARATOR . 'FormatosPdf' . SEPARATOR . 'egreso.php';
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
            $html2pdf->pdf->SetTitle('Recibo de egreso');
            //display the full page
            $html2pdf->pdf->SetDisplayMode('fullpage');
            // convert
            $html2pdf->writeHTML($content);
            // send the PDF
            //$html2pdf->pdf->IncludeJS('print(TRUE)');
            $html2pdf->Output('Recibo de egreso No: ' . $recibo[0]->numero . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /**
     * Método para comprobar valores de factura y recibos factura
     * @access public
     * @param int $id_factura
     * @return  bool
     */
    public function CheckInvOut()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_factura    = $_POST['idf'];
            $inv           = $this->ModelProv->Inv($id_factura);
            $rec           = $this->ModelProv->Recibo($id_factura, 'idfactura');
            $total_factura = floatval($inv[0]->total);
            $total_recibos = 0;
            foreach ($rec as $key => $value) {
                $total_recibos = $total_recibos + $value->importe;
            }
            $dif = $total_factura - $total_recibos;
            if ($dif < $total_factura * 0.01) {
                echo true;
            } else {
                echo "Los valores de los recibos no coinciden, la diferencia es de: " . $dif;
            }
        } else {
            $dat = array(
                'titulo'   => 'Upps!',
                'mensaje'  => 'No deberías estar aquí!',
                'problema' => 'su solicitud, NO es un método para acceder por URL',
            );
            $this->vista('directiva', $dat, 'Facturacion');
        }
    }

    /**
     * Metodo autocompletar Proveedores
     * @access public
     * @param = null
     * @return json
     */
    public function autoCompleteProv($campo)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['term'])) {
                $dato = array();
                $rows = $this->ModelProv->autoCompleteProv($_GET['term'], $campo);
                foreach ($rows as $key => $value) {
                    $dato[] = array(
                        'type_id'       => $value['type_id'],
                        'value'         => $value[$campo],
                        'cifnif'        => $value['cifnif'],
                        'codproveedor'  => $value['codproveedor'],
                        'riva'          => $value['riva'],
                        'divisa'        => $value['divisa'],
                        'country'       => $value['country'],
                        'cityprov'      => $value['cityprov'],
                        'codpprov'      => $value['codpprov'],
                        'deptoprov'     => $value['deptoprov'],
                        'fp'            => $value['fp'],
                        'direccion'     => $value['direccion'],
                        'email'         => $value['email'],
                        'nombre'        => $value['nombre'],
                        'observaciones' => $value['observaciones'],
                        'bancname'      => $value['bancname'],
                        'banctype'      => $value['banctype'],
                        'no_cuenta'     => $value['no_cuenta'],
                        'telefono1'     => $value['telefono1'],
                        'telefono2'     => $value['telefono2'],
                        'personafisica' => $value['personafisica'],
                        'estado'        => $value['estado'],
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
     * Metodo autocompletar Proveedores
     * @access public
     * @param = null
     * @return json
     */
    public function autoCompleteProvName()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['term'])) {
                $dato = array();
                $rows = $this->ModelProv->autoCompleteProvName($_GET['term']);
                foreach ($rows as $key => $value) {
                    $dato[] = array(
                        'type_id'       => $value['type_id'],
                        'value'         => $value['nombre'],
                        'cifnif'        => $value['cifnif'],
                        'codproveedor'  => $value['codproveedor'],
                        'riva'          => $value['riva'],
                        'divisa'        => $value['divisa'],
                        'country'       => $value['country'],
                        'cityprov'      => $value['cityprov'],
                        'codpprov'      => $value['codpprov'],
                        'deptoprov'     => $value['deptoprov'],
                        'fp'            => $value['fp'],
                        'direccion'     => $value['direccion'],
                        'email'         => $value['email'],
                        'nombre'        => $value['nombre'],
                        'observaciones' => $value['observaciones'],
                        'bancname'      => $value['bancname'],
                        'banctype'      => $value['banctype'],
                        'no_cuenta'     => $value['no_cuenta'],
                        'telefono1'     => $value['telefono1'],
                        'telefono2'     => $value['telefono2'],
                        'personafisica' => $value['personafisica'],
                        'estado'        => $value['estado'],
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
     * Metodo autocompletar Proveedores
     * @access public
     * @param = null
     * @return json
     */
    public function autoCompleteInv()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['term'])) {
                $dato = array();
                $rows = $this->ModelProv->autoCompleteInv($_GET['term']);
                foreach ($rows as $key => $value) {
                    $dato[] = array(
                        'value'         => $value['numero'],
                        'ejercicio'     => $value['ejercicio'],
                        'cifnif'        => $value['cifnif'],
                        'RE'            => $value['RE'],
                        'coddivisa'     => $value['coddivisa'],
                        'codpago'       => $value['codpago'],
                        'codproveedor'  => $value['codproveedor'],
                        'codserie'      => $value['codserie'],
                        'deabono'       => $value['deabono'],
                        'fecha'         => $value['fecha'],
                        'hora'          => $value['hora'],
                        'idfactura'     => $value['idfactura'],
                        'lineasfactura' => $value['lineasfactura'],
                        'nombre'        => $value['nombre'],
                        'telefono'      => $value['telefono'],
                        'email'         => $value['email'],
                        'direccion'     => $value['direccion'],
                        'numero'        => $value['numero'],
                        'observaciones' => $value['observaciones'],
                        'fp'            => $value['fp'],
                        'total'         => $value['total'],
                        'totaldto'      => $value['totaldto'],
                        'totaliva'      => $value['totaliva'],
                        'totalrecargo'  => $value['totalrecargo'],
                        'estado'        => $value['estado'],
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
    //-------------------------------------------------------------/Metodos personalizados


    /**
     * Metodo utilizado para datatable en vista providers
     * @access public
     * @param = filters
     * @return  json
     * @method ajax
     */
    public function tableViewsProveedor()
    {

        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'proveedores';

            //Llave primaria de la tabla
            $primaryKey = 'codproveedor';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.
            $columns = array(

                array('db' => 'nombre', 'dt' => 'nombre'),
                array('db' => 'cifnif', 'dt' => 'cifnif'),
                array('db' => 'email', 'dt' => 'email'),
                array('db' => 'telefono1', 'dt' => 'telefono1'),
                array('db' => 'observaciones', 'dt' => 'observaciones'),
                array('db' => 'codproveedor', 'dt' => 'codproveedor'),
                array('db' => 'estado', 'dt' => 'estado'),
            );


            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            //header("Content-type: application/json; charset=utf-8");
            if (isset($_POST['id']) && $_POST['id'] != "") {
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
     * Metodo utilizado para datatable de facturas proveedor
     * @access public
     * @param = filters
     * @return  json
     * @method ajax
     */
    public function tableViewsFactProveedor()
    {

        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'facturasprov';

            //Llave primaria de la tabla
            $primaryKey = 'idfactura';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.
            $columns = array(

                array('db' => 'cifnif', 'dt' => 'cifnif'),
                array('db' => 'numero', 'dt' => 'numero'),
                array('db' => 'coddivisa', 'dt' => 'coddivisa'),
                array('db' => 'codpago', 'dt' => 'codpago'),
                array('db' => 'codproveedor', 'dt' => 'codproveedor'),
                array('db' => 'codserie', 'dt' => 'codserie'),
                array('db' => 'deabono', 'dt' => 'deabono'),
                array('db' => 'fecha', 'dt' => 'fecha'),
                array('db' => 'hora', 'dt' => 'hora'),
                array('db' => 'nombre', 'dt' => 'nombre'),
                array('db' => 'observaciones', 'dt' => 'observaciones'),
                array('db' => 'total', 'dt' => 'total'),
                array('db' => 'totaliva', 'dt' => 'totaliva'),
                array('db' => 'totaldto', 'dt' => 'totaldto'),
                array('db' => 'totalrecargo', 'dt' => 'totalrecargo'),
                array('db' => 'estado', 'dt' => 'estado'),
                array('db' => 'idfactura', 'dt' => 'idfactura'),


            );


            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            //header("Content-type: application/json; charset=utf-8");
            if (isset($_POST['id']) && $_POST['id'] != "") {
                //Retornamos los valores consultados con filtro
                $where = "estado = {$_POST['id']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } else if (isset($_POST['cifnif']) && $_POST['cifnif'] != "") {
                //Retornamos los valores consultados con filtro
                $where = "codproveedor = {$_POST['cifnif']}";
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
     * Método vista factura proveedor
     * @access public
     * @param int $id_factura
     */
    public function verFacturaProv($id_factura)
    {
        $factura = $this->ModelProv->Inv($id_factura);
        $this->pagina404($factura);
        $client = $this->ModelProv->Prov($factura[0]->codproveedor);
        $this->pagina404($client);
        $empresa            = $this->modelPerfil->obtenerPerfil(); //Datos de la empresa
        $resolution = Resolutions::where("type", "DS")->where("status", 1)->first() ?? null;

        ob_start();
        require_once RUTA_PLUGINS . 'Facturacion' . SEPARATOR . 'Views' . SEPARATOR . 'FormatosPdf' . SEPARATOR . 'factura_prov.php';
        $content = ob_get_clean();
        //End output

        try {
            // init HTML2PDF para generar PDF
            $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(
                0,
                0,
                0,
                0,
            ));
            //Titulo documento
            $html2pdf->pdf->SetTitle($factura[0]->numero);
            //display the full page
            $html2pdf->pdf->SetDisplayMode('fullpage');
            // convert
            $html2pdf->writeHTML($content);
            // send the PDF
            //$html2pdf->pdf->IncludeJS('print(TRUE)');
            $html2pdf->Output('Documento equivalente a factura ' . $factura[0]->numero . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /**
     * Metodo utilizado para datatable de recibos proveedor
     * @access public
     * @param = filters
     * @return  json
     * @method ajax
     */
    public function tableViewsOutsProveedor()
    {

        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'recibos_proveedor';

            //Llave primaria de la tabla
            $primaryKey = 'id_recibo';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.
            $columns = array(

                array('db' => 'id_recibo', 'dt' => 'id_recibo'),
                array('db' => 'idfactura', 'dt' => 'idfactura'),
                array('db' => 'linea', 'dt' => 'linea'),
                array('db' => 'numero', 'dt' => 'numero'),
                array('db' => 'proveedor', 'dt' => 'proveedor'),
                array('db' => 'emitido', 'dt' => 'emitido'),
                array('db' => 'divisa', 'dt' => 'divisa'),
                array('db' => 'importe', 'dt' => 'importe'),
                array('db' => 'fp', 'dt' => 'fp'),
                array('db' => 'vencimiento', 'dt' => 'vencimiento'),
                array('db' => 'pagado', 'dt' => 'pagado'),
                array('db' => 'notificado', 'dt' => 'notificado'),
                array('db' => 'observaciones', 'dt' => 'observaciones'),
                array('db' => 'codproveedor', 'dt' => 'codproveedor'),
                array('db' => 'estado_recibo', 'dt' => 'estado_recibo'),

            );
            //Información del servidor de base de datos
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASS,
                'db'   => DB_NAME,
                'host' => DB_HOST,
            );
            //header("Content-type: application/json; charset=utf-8");
            if (isset($_POST['id']) && $_POST['id'] != "") {
                //Retornamos los valores consultados con filtro
                $where = "estado_recibo = {$_POST['id']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where),
                    JSON_PRETTY_PRINT
                );
            } else if (isset($_POST['idf']) && $_POST['idf'] != "") {
                //Retornamos los valores consultados con filtro
                $where1 = "idfactura = {$_POST['idf']}";
                echo json_encode(
                    $this->ssp->complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where1),
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

   
}
