<?php

class Novedades extends Controller
{

    private $modelnovedad;
    public  $PluginName;
    public function __construct()
    {
        $this->sessionValidator(); //Validamos sesion
        $this->modelnovedad = $this->modelo('Novedad', 'Novedades');
        $this->PluginName = 'Novedades';
        $this->folderCreator($this->PluginName);
        //Directorio de imagenes del plugin
        $this->imgFolder = RUTA_UPLOAD .  $this->PluginName . SEPARATOR . 'img' . SEPARATOR;
    }

    public function index()
    {
        $dataTables = dataTables();
        $datos =  array(
            'titulo' => 'Listado Novedades',
            'icon'   => 'fas fa-boxes',
            'dataTables' => $dataTables

        );
        $this->vista('ListadoNovedades', $datos, 'Novedades', true);
    }


    public function NewNovedad()
    {
     
        $datos =  array(
            'titulo' => 'NewNovedad',
            
        );

        $this->vista('NewNovedad', $datos, 'Novedades');
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
            $table = 'novedad';

            //Llave primaria de la tabla
            $primaryKey = 'IdNovedad';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'IdNovedad', 'dt' => 'IdNovedad'),
                array('db' => 'Cantidad', 'dt' => 'Cantidad'),
                array('db' => 'Descripcion', 'dt' => 'Descripcion'),
                array('db' => 'Fecha', 'dt' => 'Fecha'),
                array('db' => 'IdTipoNovedad', 'dt' => 'IdTipoNovedad'),
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
                        $where = "IdTipoNovedad ='1'";
                        break;
                    case 2:
                        $where = "IdTipoNovedad ='2'";
                        break;
                    case 3:
                        $where = "IdTipoNovedad ='0'";
                        break;
                }

                //Retornamos los valores consultados con filtro
                echo json_encode(
                    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns, null, $where)
                );
            } else {
                $where = "IdTipoNovedad !='4'";
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

    /**
     * Editar
     * (ES) Este método se encarga de editar un producto
     * @access public
     * @return void
     */


    /**
     * ImagenProducto
     * (ES) Este método se encarga de subir la imagen/foto de un producto
     * @access public
     * @return void
     */

    public function ObtenerTiposDeNovedades()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->modelnovedad->ObtenerTiposDeNovedades(), JSON_PRETTY_PRINT);
        endif;
    }

    public function ObtenerTiposDeProducto()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->modelnovedad->ObtenerTiposDeProducto(), JSON_PRETTY_PRINT);
        endif;
    }
    public function ObtenerPrecios()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD'] && $_POST['producto'] != "") { 
            header('Content-Type: application/json');
            echo json_encode($this->modelnovedad->ObtenerPrecios($_POST['producto']), JSON_PRETTY_PRINT);
         }else
         {
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
                    
                        foreach ($_POST['numero_item'] as $key => $value) {
                            $dat = array(
                                'IdTipoProducto'  => $_POST['IdTipoProducto'][$key],
                                'cantidad'        => $_POST['cantidad'][$key],
                                'precio' => $_POST['precio'][$key],            
                                'iva'             => $_POST['iva'][$key],
                                'total'           => $_POST['total'][$key],
                                'FacObservacion' => $_POST['FacObservacion'],
                            );
                            if ($this->modelnovedad->SaveInvProv($dat)) {
                              
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

}

