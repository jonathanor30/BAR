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
        $this->folderCreator($this->PluginName);
        //Directorio de imagenes del plugin
        $this->imgFolder = RUTA_UPLOAD .  $this->PluginName . SEPARATOR . 'img' . SEPARATOR;
    }

    public function index()
    {
        $dataTables = dataTables();
        $datos =  array(
            'titulo' => 'Listado Productos',
            'icon'   => 'fas fa-boxes',
            'dataTables' => $dataTables

        );
        $this->vista('ListadoProductos', $datos, 'Productos', true);
    }
    public function test($id = 2)
    {
        $this->pagina404($id);
        $producto = $this->model->ObtenerUno("IdProducto", $id);
        $datos =  array(
            'titulo' => $producto->NombreProducto,
            'producto' => $producto,
        );

        $this->vista('test', $datos, 'Productos');
    }


    public function detalleProducto($id = null)
    {

        $this->pagina404($id);
        $producto = $this->model->ObtenerUno("IdProducto", $id);
        $datos =  array(
            'titulo' => $producto->NombreProducto,
            'producto' => $producto,
        );

        $this->vista('detalleProducto', $datos, 'Productos');
    }

    public function VerProducto($id = null)
    {

        $this->pagina404($id);
        $producto = $this->model->ObtenerUno("IdProducto", $id);
        $datos =  array(
            'titulo' => $producto->NombreProducto,
            'producto' => $producto,
        );

        $this->vista('VerProducto', $datos, 'Productos');
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
                array('db' => 'ImagenProducto', 'dt' => 'ImagenProducto'),
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

    /**
     * ImagenProducto
     * (ES) Este método se encarga de subir la imagen/foto de un producto
     * @access public
     * @return void
     */
    public function ImagenProducto($id)
    {
        //validación para cargar una imagen
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["ImagenProducto"]) && !empty($_FILES["ImagenProducto"])) {
            if (isset($_FILES["ImagenProducto"])) {
                //$target_dir    = RUTA_PLUGINS .  $this->PluginName . SEPARATOR . "assets" . SEPARATOR . "img" . SEPARATOR;
                $target_dir    = $this->imgFolder;
                $image_name    = time() . "_" . basename($_FILES["ImagenProducto"]["name"]);
                $target_file   = $target_dir . $image_name;
                $ImagenProductoType = pathinfo($target_file, PATHINFO_EXTENSION);
                $ImagenProductoZise = trim($_FILES["ImagenProducto"]["size"]);
                //$image         = $_POST['ImagenProducto'];

                /* Inicio Validacion*/
                // Allow certain file formats
                $extensiones_permitidas = [
                    'jpg',
                    'png',
                    'jpeg'
                ];
                //validar formato y tamaño de imagen
                if (!in_array($ImagenProductoType, $extensiones_permitidas) && $ImagenProductoZise == 0) {
                    echo "Lo sentimos, sólo se permiten archivos JPG , JPEG, PNG.";
                    //1048576 byte=1MB
                    exit();
                } else if ($ImagenProductoZise > 1048576) {
                    echo "Lo sentimos, pero el archivo es demasiado grande. Selecciona una imagen de menos de 1MB.";
                    exit();
                } else {
                    //Aca se hace el query para almacenar la la url de la imagen

                    ///* Fin Validacion*/
                    if ($ImagenProductoZise > 0) {
                        move_uploaded_file($_FILES["ImagenProducto"]["tmp_name"], $target_file);
                        $foto_updated = "Productos/img/{$image_name}";
                    } else {
                        $foto_updated = "";
                    }

                    $datos = [
                        'ImagenProducto' => $foto_updated,
                    ];

                    $producto = $this->model->ObtenerUno("IdProducto", $id);
                    //validar si existe una imagen que será actualizada
                    if ($producto->ImagenProducto != "" || $producto->ImagenProducto != NULL) {
                        //Si es así, elimino la que esta actualmente
                        unlink(RUTA_UPLOAD . SEPARATOR . $producto->ImagenProducto);
                    }

                    //Actualizar campo de la imagen del producto en la base de datos
                    switch ($this->model->db->Update($datos, 'producto', 'IdProducto', intval($id))) {
                        case true:
                            echo  $foto_updated;
                            break;
                        case false:
                            //Cambiar
                            echo false;
                            break;
                    }
                }
            }
        } else {
            redireccionar('/Productos');
        }
    }

    public function ObtenerTiposDeProductos()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->model->ObtenerTiposDeProductos(), JSON_PRETTY_PRINT);
        endif;
    }

    public function ObtenerPresentacion()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->model->ObtenerPresentacion(), JSON_PRETTY_PRINT);
        endif;
    }

    public function ObtenerMarca()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->model->ObtenerMarca(), JSON_PRETTY_PRINT);
        endif;
    }

    public function ObtenerUnidadMedida()
    {
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD']) :
            header('Content-Type: application/json');
            echo json_encode($this->model->ObtenerUnidadMedida(), JSON_PRETTY_PRINT);
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
                    'CodigoProducto' => $_POST["CodigoProducto"],
                    'NombreProducto' => $_POST["NombreProducto"],
                    'IdTipoProducto' => $_POST["IdTipoProducto"],
                    'IdPresentacion' => $_POST["IdPresentacion"],
                    'IdMarca'        => $_POST["IdMarca"],
                    'Contenido'      => $_POST["Contenido"],
                    'IdUnidadMedida' => $_POST["IdUnidadMedida"],
                    'Existencias'    => $_POST["Existencias"],
                    'PrecioSugerido' => $_POST["PrecioSugerido"],
                    'StockMinimo'    => $_POST["StockMinimo"],
                    'StockMaximo'    => $_POST["StockMaximo"],




                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->model->agregarProducto($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intenter";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "El producto que quiere registrar ya existe";
                        break;
                    case 4:
                        echo "Digite el nombre sin numeros, ni caracteres especiales";
                        break;
                    case 5:
                        echo "No digite numeros negativos en precio sugerido";
                        break;
                    case 6:
                        echo "No digite numeros negativos en stock maximo";
                        break;
                    case 7:
                        echo "No digite numeros negativos en stock minimo";
                        break;
                    case 8:
                        echo "No digite numeros negativos en existencias";
                        break;
                    case 9:
                        echo "No digite numeros negativos en la medida";
                        break;
                    case 10:
                        echo "el stock minimo debe ser mayor a 5";
                        break;
                    case 11:
                        echo "el stock maximo debe ser menor a 60";
                        break;
                }


                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/Productos');
        }
    }
}
