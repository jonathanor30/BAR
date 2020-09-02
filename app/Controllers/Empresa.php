<?php

/**
 * Empresa
 * (IN) The Empresa controller is in charge of managing
 * all the logic and functionalities related to the
 * business profile.
 * 
 * (ES) El controlador Empresa se encarga de gestionar
 * toda la lógica y funcionalidades relacionados con el
 * perfil de negocio.
 * 
 * @package   Controllers
 * @author    Team Bar70
 */
class Empresa extends Controller
{
    public $nombrePlugin;
    public function __construct()
    {
        //Esto debe ir acá en el constructor si quieres proteger el acceso al mismo
        $this->sessionValidator(); //Validar sesión

        $this->nombrePlugin  = __CLASS__;
        $this->empresaModelo = $this->modelo('Perfil');
        //Creación de directorio para cargar archivos
        $this->folderCreator($this->nombrePlugin);

        //Directorio de imagenes del plugin
        $this->imgFolder = RUTA_UPLOAD . $this->nombrePlugin . SEPARATOR . 'img' . SEPARATOR;
    }

    /**
     * 
     * index
     * (IN) Method for deafault
     * (ES) Método por defecto
     * @access public
     */
    public function index()
    {
        //Protección de acceso para administradores
        $this->adminProtector();
        $empresa = $this->empresaModelo->obtenerPerfil(); //Información de la empresa

        //Comprobador 404
        $this->pagina404($empresa);
        //retorna vista del método por defecto
        return $this->vista('Empresa/Perfil',  array(
            'titulo'  => $this->nombrePlugin,
            'icon'    => 'fas fa-user-lock',
            'empresa' => $empresa,
        ), 'false', 'formatter');
    }
    /**
     * 
     * editarPerfil
     * (IN) This method is used to update the company profile.
     * (ES) Este método se usa para actualizar el perfil de la empresa.
     * @access public
     */
    public function editarPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /*Inicia validacion del lado del servidor*/
            if ($this->formValidator($_POST)) {
                //Color empresarial
                $_POST['moneda'] = $_POST['favcolor'];
                unset($_POST['favcolor']);
                //Ejecución de actualización
                $base = new Base;
                switch ($base->Update($_POST, 'perfil', 'id_perfil', 1)) {
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
     * logoEmpresa
     * (IN) (IN) This method is used to update the company brand picture .
     * (ES) Este método es usado para cargar y actualizar el logo de la empresa.
     * @access public
     */
    public function logoEmpresa()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_FILES["imagefile"])) {
                //$target_dir    = RUTA_PLUGINS . $this->nombrePlugin . SEPARATOR . "assets" . SEPARATOR . "img" . SEPARATOR;
                $target_dir    = $this->imgFolder;
                $image_name    = time() . "_" . basename($_FILES["imagefile"]["name"]);
                $target_file   = $target_dir . $image_name;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                $imageFileZise = trim($_FILES["imagefile"]["size"]);
                //$image         = $_POST['imagefile'];

                /* Inicio Validacion*/
                // Allow certain file formats
                if (($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") and $imageFileZise > 0) {
                    echo "Lo sentimos, sólo se permiten archivos JPG , JPEG, PNG y GIF.";
                    //1048576 byte=1MB
                    exit();
                } else if ($imageFileZise > 1048576) {

                    echo "Lo sentimos, pero el archivo es demasiado grande. Selecciona una imagen de menos de 1MB.";
                    exit();
                } else {
                    //Aca se hace el query para almacenar la la url de la imagen

                    ///* Fin Validacion*/
                    if ($imageFileZise > 0) {
                        move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file);
                        $foto_update = "Empresa/img/$image_name";
                    } else {
                        $foto_update = "";
                    }

                    $datos = [
                        'foto_update' => $foto_update,
                    ];
                    switch ($this->empresaModelo->subirImagen($datos)) {
                        case 1:
                            echo '<img class="img-fluid" src="' . RUTA_URL . '/Empresa/files?img=' . $foto_update . '" alt="Logo"><script>cargado();</script>';
                            break;

                        case 0:
                            //Cambiar
                            echo "Hubo un error al guardar la imagen";
                            break;
                    }
                }
            }
        } else {
            redireccionar('');
        }
    }

    //Método para cargar licencia del conductor
    public function firmaImagen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES["image_firma"])) {
                $target_dir    = $this->imgFolder;
                $image_name    = time() . "_" . basename($_FILES["image_firma"]["name"]);
                $target_file   = $target_dir . $image_name; //ruta y nombre
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                $imageFileZise = $_FILES["image_firma"]["size"];

                /* Inicio Validacion*/
                // Allow certain file formats
                if (($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") and $imageFileZise > 0) {
                    echo "<p>Lo sentimos, sólo se permiten archivos JPG , JPEG, PNG.</p>";
                } else if ($imageFileZise > 1048576) {
                    //1048576 byte=1MB
                    echo "<p>Lo sentimos, pero el archivo es demasiado grande. Selecciona imagen de menos de 1MB</p>";
                } else {

                    /* Fin Validacion*/
                    if ($imageFileZise > 0) {
                        $this->fotoActual = $empresa = $this->empresaModelo->obtenerPerfil();
                        //Eliminar foto anterior
                        if ($this->fotoActual->firma != "") {
                            if (file_exists(RUTA_UPLOAD . $this->fotoActual->firma)) {
                                unlink(RUTA_UPLOAD . $this->fotoActual->firma);
                            }
                        }
                        //cargar foto nueva
                        move_uploaded_file($_FILES["image_firma"]["tmp_name"], $target_file);
                        $foto_update = "Empresa/img/$image_name";
                    } else {
                        $foto_update = "";
                    }

                    if (file_exists($this->imgFolder . $image_name)) {
                        $datos = [
                            'foto' => $foto_update,
                        ];
                        switch ($this->empresaModelo->firma($datos)) {
                            case true:
                                echo '<a href="#" data-toggle="modal" data-target="#ModalFirma">
                        <img style="height:48px; width: 150px;" class="img-fluid" src="' . RUTA_URL . '/Empresa/files?img=' . $foto_update . '"  alt="Foto">
                        </a>
                        <h4>Firma representante</h4>
                        <small>alto 223px, ancho 700px;</small>
                        <!-- Modal Imagen firma -->
                        <div class="modal fade" id="ModalFirma" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h4 class="modal-title">Firma</h4>
                                    <button type="button" class="btn close" data-dismiss="modal">&times;</button>
                                 </div>
                                 <div class="modal-body">
                                    <img class="img-fluid" src="' . RUTA_URL . '/Empresa/files?img=' . $foto_update . '">
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-rojo-claro" data-dismiss="modal">Cerrar</button>
                                 </div>
                              </div>
                           </div>
                        </div><script>cargado();</script>';
                                break;
                            case false:
                                echo "Hubo en error al guardar la imagen.";
                                break;
                        }
                    } else {
                    }
                }
            }
        }
    }


    /**
     * files
     * (IN) This method is used to handle private system files.
     * (ES) Este método se usa para manejar los archivos privados del sistema
     * @access public
     */
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
                return $this->filesGTEP($this->nombrePlugin, $_GET['js'], 'js');
            }
            if (isset($_GET['css'])) {
                return $this->filesGTEP($this->nombrePlugin, $_GET['css'], 'css');
            }
        } else {
            $this->pagina404(false);
        }
    }

    //Método para cambiar modo de pantalla
    public function modeView()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            switch ($id) {
                case '1':
                    $_SESSION['modeView'] = true;
                    echo "Modo noche";
                    break;
                case '0':
                    unset($_SESSION['modeView']);
                    echo "true";
                    break;
            }
        }
        exit();
    }

    public function infoSystem()
    {
        $rows = $this->empresaModelo->infoDB();
        $size = 0;
        foreach ($rows as $key => $value) {
            $size += $value["Data_length"] + $value["Index_length"];
        }

        $decimals   = 2;
        $database   = $this->sizeFormat($size);
        $memoryUsed = $this->sizeFormat(memory_get_usage());
        $patch      = dirname(dirname(__FILE__));
        $directory  = explode("/app", $patch);

        $sizeApp = $this->sizeFormat($this->folderSize($directory[0]));

        echo $database . "-" . $sizeApp . "-" . $memoryUsed;
    }

    public function folderSize($dir)
    {
        $size = 0;
        foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }
        return $size;
    }

    public function sizeFormat($bytes)
    {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;

        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes . ' B';
        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return ceil($bytes / $kb) . ' KB';
        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return ceil($bytes / $mb) . ' MB';
        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return ceil($bytes / $gb) . ' GB';
        } elseif ($bytes >= $tb) {
            return ceil($bytes / $tb) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
    public function configEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->formValidator($_POST)) {

                $datos = [
                    'server'   => $_POST['server'],
                    'usuario'  => $_POST['usuario'],
                    'password' => $_POST['password'],
                ];

                switch ($this->empresaModelo->configEmail($datos)) {
                    case true:
                        echo "true";
                        break;
                    case false:
                        echo "error";
                        break;
                }
                exit();
            } else {
                exit();
            }
        } else {
            redireccionar('');
        }
    }

    public function test()
    {
        $token = Auth::SignIn([
            'id' => 1,
            'name' => 'Eduardo'
        ]);


        echo Auth::GetData($token)->id;
    }


    //Método para manejar recursos de aplicacion
    public function Assets()
    {
        if (isset($_GET['img']) || isset($_GET['js']) || isset($_GET['css']) || isset($_GET['pdf'])) {
            if (isset($_GET['img'])) {
                return $this->filesGTEP($_GET['img'], false, 'img');
            }
            if (isset($_GET['pdf'])) {
                return $this->filesGTEP($_GET['pdf'], false, 'pdf');
            }
            if (isset($_GET['js'])) {
                //Personalizado
                return $this->filesGTEP('Assets' . SEPARATOR, $_GET['js'], 'js', 'Assets');
            }
            if (isset($_GET['css'])) {
                return $this->filesGTEP($this->nombrePlugin, $_GET['css'], 'css');
            }
        } else {
            $this->pagina404(false);
        }
    }
}
