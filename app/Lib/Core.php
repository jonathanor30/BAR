<?php
/**

 */
class Core
{
    protected $controladorActual = "login"; //Este es el controlador por defecto
    protected $metodoActual      = "index";
    protected $parametros        = [];
    //Constructor
    public function __construct()
    {

        $url = (array)$this->getUrl();
        $url[0] = (isset($url) && $url != NULL)? $url[0]: $this->controladorActual;

        //Buscar en Conttroladores si el controlador llamado existe
        if (file_exists('../app/Controllers/' . ucwords($url[0]) . '.php')) {
            //Si el controlador existe se setea como controlador por defecto
            $this->controladorActual = ucwords($url[0]);
            //Unset indice
            unset($url[0]);
        } else {
            //Buscar en Conttroladores si el controlador llamado existe en Plugins
            if (file_exists('../app/Plugins/' . ucwords($url[0]) . '/Controllers/' . ucwords($url[0]) . '.php')) {
                //Si el controlador existe se setea como controlador por defecto
                $this->controladorActual = ucwords($url[0]);
                //Unset Indice
                unset($url[0]);
            }
        }
        if (file_exists('../app/Controllers/' . ucwords($this->controladorActual) . '.php')) {
            // Requerir el controlador
            require_once '../app/Controllers/' . ucwords($this->controladorActual) . '.php';
            $this->controladorActual = new $this->controladorActual;
        } else {
            // Requerir el controlador
            require_once '../app/Plugins/' . ucwords($this->controladorActual) . '/Controllers/' . ucwords($this->controladorActual) . '.php';
            $this->controladorActual = new $this->controladorActual;

        }
        //Chequera la segunda parte de la url, el método la acción
        if (isset($url[1])) {
            if (method_exists($this->controladorActual, $url[1])) {
                //Chequeamos el método
                $this->metodoActual = $url[1];
                unset($url[1]);
            }
        }
        //Para probar traer método
        //echo $this->metodoActual;
        //Obtener parametros
        $this->parametros = $url ? array_values($url) : [];
        //llamar Callback con parametros Array
        call_user_func_array([$this->controladorActual, $this->metodoActual], $this->parametros);
    }
    //Función para gestionar las Url,s
    public function getUrl()
    {
        //echo $_GET['url'];
        if (isset($_GET['url'])) {
            //Limpiamos los espacios que estan a la derecha de la url
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return (array)$url;
        }
    }
}
