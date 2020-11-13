<?php

class Configuracion extends Controller
{
    private $Modelo;
    public $PluginName;
    public function __construct()
    {
        //Esto debe ir acá en el constructor si quieres proteger el acceso al mismo
        $this->sessionValidator(); //Validar sesión
        $this->Modelo = $this->modelo('Configuracion1');
        $this->PluginName  = 'Configuracion';
        $this->folderCreator($this->PluginName);
        $this->imgFolder = RUTA_UPLOAD .  $this->PluginName . SEPARATOR . 'img' . SEPARATOR;
        //Creación de directorio para cargar archivos


    }
    /**
     * 
     * index
     * (IN) Method for deafault
     * (ES) Método por defecto
     * @access public
     */
    

    public function index($id = 1)
    {
        $this->pagina404($id);
        $dataTables = dataTables();
        $home = $this->Modelo->ObtenerUno("IdHome", $id);
        $datos =  array(
            
            
            'titulo' => 'Configuracion',
            'icon'   => 'fas fa-boxes',
            'home' => $home,
            'dataTables' => $dataTables
        );
        
        $this->vista("Configuracion/tablas", $datos, null, true); 
    }


    public function vertipoproducto($id = null)
    {
        
        $this->pagina404($id);
        $home = $this->Modelo->ObtenerUnoTipoProducto("IdTipoProducto", $id);
        $datos =  array(
            'titulo' => $home->Nombre,
            'home' => $home,
        );

        $this->vista("Configuracion/EditarTipoProducto", $datos, null, true); 
    }

    public function VerUnidadMedida($id = null)
    {
        
        $this->pagina404($id);
        $home = $this->Modelo->ObtenerUnidadMedida("IdUnidadMedida", $id);
        $datos =  array(
            'titulo' => $home->NombreUnidad,
            'home' => $home,
        );

        $this->vista("Configuracion/EditarUnidadMedida", $datos, null, true); 
    }
    public function VerMarca($id = null)
    {
        
        $this->pagina404($id);
        $home = $this->Modelo->ObtenerMarca("IdMarca", $id);
        $datos =  array(
            'titulo' => $home->Nombre,
            'home' => $home,
        );

        $this->vista("Configuracion/EditarMarca", $datos, null, true); 
    }

    public function VerPresentacion($id = null)
    {
        
        $this->pagina404($id);
        $home = $this->Modelo->ObtenerPresentacion("IdPresentacion", $id);
        $datos =  array(
            'titulo' => $home->Nombre,
            'home' => $home,
        );

        $this->vista("Configuracion/EditarPresentacion", $datos, null, true); 
    }
    
    public function VerTipoDocumento($id = null)
    {
        
        $this->pagina404($id);
        $home = $this->Modelo->ObtenerTipoDocumento("IdTipoDocumento", $id);
        $datos =  array(
            'titulo' => $home->Nombre_Documento,
            'home' => $home,
        );

        $this->vista("Configuracion/EditarTipoDocumento", $datos, null, true); 
    }

     /**
     * Editar
     * (ES) Este método se encarga de editar un producto
     * @access public
     * @return void
     */
    public function EditarTipoProducto()
    {
        //Validar que el método sea accedido mediante POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' &&   $this->formValidator($_POST)) :
            //Ingresa y guarda
            if ($this->Modelo->db->Update($_POST, 'tipo_producto', 'IdTipoProducto', intval($_POST['IdTipoProducto']))) {
                echo "true";
            } else {
                echo "false";
            }
        else :
            redireccionar("/");
        endif;
    }

     /**
     * Editar
     * (ES) Este método se encarga de editar un producto
     * @access public
     * @return void
     */
    public function EditarUnidadMedida()
    {
        //Validar que el método sea accedido mediante POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' &&   $this->formValidator($_POST)) :
            //Ingresa y guarda
            if ($this->Modelo->db->Update($_POST, 'unidad_medida', 'IdUnidadMedida', intval($_POST['IdUnidadMedida']))) {
                echo "true";
            } else {
                echo "false";
            }
        else :
            redireccionar("/");
        endif;
    }
      /**
     * Editar
     * (ES) Este método se encarga de editar un producto
     * @access public
     * @return void
     */
    public function EditarMarca()
    {
        //Validar que el método sea accedido mediante POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' &&   $this->formValidator($_POST)) :
            //Ingresa y guarda
            if ($this->Modelo->db->Update($_POST, 'marca', 'IdMarca', intval($_POST['IdMarca']))) {
                echo "true";
            } else {
                echo "false";
            }
        else :
            redireccionar("/");
        endif;
    }
      /**
     * Editar
     * (ES) Este método se encarga de editar un producto
     * @access public
     * @return void
     */
    public function EditarPresentacion()
    {
        //Validar que el método sea accedido mediante POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' &&   $this->formValidator($_POST)) :
            //Ingresa y guarda
            if ($this->Modelo->db->Update($_POST, 'presentacion', 'IdPresentacion', intval($_POST['IdPresentacion']))) {
                echo "true";
            } else {
                echo "false";
            }
        else :
            redireccionar("/");
        endif;
    }
       /**
     * Editar
     * (ES) Este método se encarga de editar un producto
     * @access public
     * @return void
     */
    public function EditarTipoDocumento()
    {
        //Validar que el método sea accedido mediante POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' &&   $this->formValidator($_POST)) :
            //Ingresa y guarda
            if ($this->Modelo->db->Update($_POST, 'tipo_documento', 'IdTipoDocumento', intval($_POST['IdTipoDocumento']))) {
                echo "true";
            } else {
                echo "false";
            }
        else :
            redireccionar("/");
        endif;
    }


    
    /**
     * Editar
     * (ES) Este método se encarga de editar un producto
     * @access public
     * @return void
     */
    public function editarHome()


     
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /*Inicia validacion del lado del servidor*/
            if ($this->formValidator($_POST)) {

                //Ejecución de actualización
                $base = new Base;
                switch ($base->Update($_POST, 'home', 'IdHome', 1)) {
                    case true:
                        $_POST = array();
                        echo "true";
                        break;
                    case false:
                        echo "Hubo un error al intentar editar, vuelva a intenta.";
                        break;
                }
            }
        } else {
            //Si el método no es accedido por POST, será redireccinado al inicio
            redireccionar('');
        }
    }
/**
     * ImagenProducto
     * (ES) Este método se encarga de subir la imagen/foto de un producto
     * @access public
     * @return void
     */
    public function ImagenPrincipal($id)
    {
        //validación para cargar una imagen
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["ImagenPrincipal"]) && !empty($_FILES["ImagenPrincipal"])) {
            if (isset($_FILES["ImagenPrincipal"])) {
                //$target_dir    = RUTA_PLUGINS .  $this->PluginName . SEPARATOR . "assets" . SEPARATOR . "img" . SEPARATOR;
                $target_dir    = $this->imgFolder;
                $image_name    = time() . "_" . basename($_FILES["ImagenPrincipal"]["name"]);
                $target_file   = $target_dir . $image_name;
                $ImagenProductoType = pathinfo($target_file, PATHINFO_EXTENSION);
                $ImagenProductoZise = trim($_FILES["ImagenPrincipal"]["size"]);
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
                        move_uploaded_file($_FILES["ImagenPrincipal"]["tmp_name"], $target_file);
                        $foto_updated = "Configuracion/img/{$image_name}";
                    } else {
                        $foto_updated = "";
                    }

                    $datos = [
                        'ImagenPrincipal' => $foto_updated,
                    ];

                    $home = $this->Modelo->ObtenerUno("IdHome", $id);
                    //validar si existe una imagen que será actualizada
                    if ($home->ImagenPrincipal != "" || $home->ImagenPrincipal != NULL) {
                        //Si es así, elimino la que esta actualmente
                        unlink(RUTA_UPLOAD . SEPARATOR . $home->ImagenPrincipal);
                    }

                    //Actualizar campo de la imagen del producto en la base de datos
                    switch ($this->Modelo->db->Update($datos, 'home', 'IdHome', intval($id))) {
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
    /**
     * ImagenProducto
     * (ES) Este método se encarga de subir la imagen/foto de un producto
     * @access public
     * @return void
     */
    public function ImagenMision($id)
    {
        //validación para cargar una imagen
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["ImagenMision"]) && !empty($_FILES["ImagenMision"])) {
            if (isset($_FILES["ImagenMision"])) {
                //$target_dir    = RUTA_PLUGINS .  $this->PluginName . SEPARATOR . "assets" . SEPARATOR . "img" . SEPARATOR;
                $target_dir    = $this->imgFolder;
                $image_name    = time() . "_" . basename($_FILES["ImagenMision"]["name"]);
                $target_file   = $target_dir . $image_name;
                $ImagenProductoType = pathinfo($target_file, PATHINFO_EXTENSION);
                $ImagenProductoZise = trim($_FILES["ImagenMision"]["size"]);
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
                        move_uploaded_file($_FILES["ImagenMision"]["tmp_name"], $target_file);
                        $foto_updated = "Configuracion/img/{$image_name}";
                    } else {
                        $foto_updated = "";
                    }

                    $datos = [
                        'ImagenMision' => $foto_updated,
                    ];

                    $home = $this->Modelo->ObtenerUno("IdHome", $id);
                    //validar si existe una imagen que será actualizada
                    if ($home->ImagenMision != "" || $home->ImagenMision != NULL) {
                        //Si es así, elimino la que esta actualmente
                        unlink(RUTA_UPLOAD . SEPARATOR . $home->ImagenMision);
                    }

                    //Actualizar campo de la imagen del producto en la base de datos
                    switch ($this->Modelo->db->Update($datos, 'home', 'IdHome', intval($id))) {
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

    /**
     * ImagenProducto
     * (ES) Este método se encarga de subir la imagen/foto de un producto
     * @access public
     * @return void
     */
    public function ImagenVision($id)
    {
        //validación para cargar una imagen
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["ImagenVision"]) && !empty($_FILES["ImagenVision"])) {
            if (isset($_FILES["ImagenVision"])) {
                //$target_dir    = RUTA_PLUGINS .  $this->PluginName . SEPARATOR . "assets" . SEPARATOR . "img" . SEPARATOR;
                $target_dir    = $this->imgFolder;
                $image_name    = time() . "_" . basename($_FILES["ImagenVision"]["name"]);
                $target_file   = $target_dir . $image_name;
                $ImagenProductoType = pathinfo($target_file, PATHINFO_EXTENSION);
                $ImagenProductoZise = trim($_FILES["ImagenVision"]["size"]);
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
                        move_uploaded_file($_FILES["ImagenVision"]["tmp_name"], $target_file);
                        $foto_updated = "Configuracion/img/{$image_name}";
                    } else {
                        $foto_updated = "";
                    }

                    $datos = [
                        'ImagenVision' => $foto_updated,
                    ];

                    $home = $this->Modelo->ObtenerUno("IdHome", $id);
                    //validar si existe una imagen que será actualizada
                    if ($home->ImagenVision != "" || $home->ImagenVision != NULL) {
                        //Si es así, elimino la que esta actualmente
                        unlink(RUTA_UPLOAD . SEPARATOR . $home->ImagenVision);
                    }

                    //Actualizar campo de la imagen del producto en la base de datos
                    switch ($this->Modelo->db->Update($datos, 'home', 'IdHome', intval($id))) {
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

    public function Obtenerdatos()
    {
        //Validar datos recibido mediante POST
        //Validar datos recibido mediante POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            header('Content-Type: application/json');
            echo json_encode($this->Modelo->Obtenerdatos(), JSON_PRETTY_PRINT);
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

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->Modelo->agregarTipo($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intenter";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "El tipo producto que quiere registrar ya existe";
                        break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/Configuracion');
        }
    }

    public function agregarNovedad()
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
                    'Nombre_Novedad' => $_POST["Nombre_Novedad"],

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->Modelo->agregarNovedad($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intenter";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "El tipo novedad que quiere registrar ya existe";
                        break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/Configuracion');
        }
    }

    public function agregarDocumento()
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
                    'Nombre_Documento' => $_POST["Nombre_Documento"],

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->Modelo->agregarDocumento($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intenter";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "El tipo documento que quiere registrar ya existe";
                        break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/Configuracion');
        }
    }

    public function agregarUnidad()
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
                    'NombreUnidad' => $_POST["NombreUnidad"],

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->Modelo->agregarUnidad($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intenter";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "La unidad medida que quiere registrar ya existe";
                        break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/Configuracion');
        }
    }

    public function agregarPresentacion()
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

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->Modelo->agregarPresentacion($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intenter";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "la presentacion que quiere registrar ya existe";
                        break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/Configuracion');
        }
    }

    public function agregarMarca()
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

                ];
                //Estructura de control, para evaluar el query de agregar usuario
                switch ($this->Modelo->agregarMarca($datos)) {
                    case 1:
                        echo true;
                        break;
                    case 2:
                        //Redireccionamos de nuevo al formulario
                        echo "Hubo un error al guardar el registro, por favor vuelva a intenter";
                        break;
                    case 3:
                        //Redireccionamos a usuarios
                        echo "La marca que quiere registrar ya existe";
                        break;
                }

                exit();
            } else {
                echo "Faltan datos por completar";
            }
        } else {

            redireccionar('/Configuracion');
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
            $table = 'tipo_producto';

            //Llave primaria de la tabla
            $primaryKey = 'IdTipoProducto';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'Nombre', 'dt' => 'Nombre'),
                array('db' => 'IdTipoProducto', 'dt' => 'IdTipoProducto'),

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

    public function tableViewsNovedades()
    {
        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'tipo_novedad';

            //Llave primaria de la tabla
            $primaryKey = 'IdTipoNovedad';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'Nombre_Novedad', 'dt' => 'Nombre_Novedad'),
                array('db' => 'IdTipoNovedad', 'dt' => 'IdTipoNovedad'),

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

    public function tableViewsMarca()
    {
        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'marca';

            //Llave primaria de la tabla
            $primaryKey = 'IdMarca';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'Nombre', 'dt' => 'Nombre'),
                array('db' => 'IdMarca', 'dt' => 'IdMarca'),

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


    public function tableViewsPresentacion()
    {
        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'presentacion';

            //Llave primaria de la tabla
            $primaryKey = 'IdPresentacion';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'Nombre', 'dt' => 'Nombre'),
                array('db' => 'IdPresentacion', 'dt' => 'IdPresentacion'),

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

    public function tableViewsdocumento()
    {
        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'tipo_documento';

            //Llave primaria de la tabla
            $primaryKey = 'IdTipoDocumento';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'Nombre_Documento', 'dt' => 'Nombre_Documento'),
                array('db' => 'IdTipoDocumento', 'dt' => 'IdTipoDocumento'),

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

    public function tableViewsUnidad()
    {
        //Si existe una petición de tipo post a este método se ejecuta el siguiente script
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tabla a usar
            $table = 'unidad_medida';

            //Llave primaria de la tabla
            $primaryKey = 'IdUnidadMedida';

            // Conjunto de columnas de la base de datos que se deben leer y enviar a DataTables.
            // El parámetro `db` representa el nombre de la columna en la base de datos, mientras que el parámetro` dt` representa el identificador de la columna DataTables. En este caso, el parámetro objeto.

            $columns = array(
                array('db' => 'NombreUnidad', 'dt' => 'NombreUnidad'),
                array('db' => 'IdUnidadMedida', 'dt' => 'IdUnidadMedida'),

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

    public function borrar()
    {
        //Validamos si los datos fueron enviados por el metodo POST de php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $plugin = $_POST['id'];
            $datos  = [
                'IdTipoProducto' => $plugin,
            ];
            //Instancia del moldelo
            if (intval($_POST['type']) != 99) {
                switch ($this->Modelo->borrar($datos)) {
                    case 1:
                        echo "true";
                        break;
                    case 2:
                        echo "false";
                        break;
                }
            } else {
                echo "Este tipo de usuario no se puede eliminar";
            }
        } else {
            redireccionar('/Usuarios');
        }
    }
}
