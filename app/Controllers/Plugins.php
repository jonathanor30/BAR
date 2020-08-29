<?php

/**
 * This file is part of Elephant Framework
 * Copyright (C) 2018-2019 Juan Bautista <soyjuanbautista0@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Plugins controller of the Elephant framework-
 *
 * @author Juan Bautista <soyjuanbautista0@gmail.com>
 *
 */
class Plugins extends Controller
{
    public $plugins;
    public $lista;
    public $exec;
    public $smarty;

    public function __construct()
    {
        $this->sessionValidator();

        $this->adminProtector(); //Protección

    }

    /**
     * Método index() método por defecto del cotrolador
     * se encarga de mostrar la vista del listado de plugins.
     * @access public
     * @param array $datos
     */
    public function index()
    {
        //Listado de plugins
        $this->plugins = $this->getExistingPlugins(RUTA_PLUGINS);

        //Instancia de dataTables
        $dataTables = dataTables();

        $datos = [
            'titulo'     => 'Plugins',
            'icon'       => 'fas fa-plug',
            'listado'    => $this->plugins,
            'dataTables' => $dataTables,
        ];

        //Vista del método index, pasamos valores de vista y datos.
        $this->vista('Plugins' . SEPARATOR . 'ListPlugins', $datos, false);
    }

    /**
     * Método agregar()
     * se encarga de  cargar Plugins al sistema.
     * @access public
     * @param array $datos
     */
    public function agregar()
    {
        //Comprobamos que se acceda solo si existe el método post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Comprobamos el archivo exista
            if (isset($_FILES["zip_file"]["name"])) {
                $plugins = getExistingPlugins(RUTA_PLUGINS);

                //Instancia de dataTables
                $dataTables = dataTables();

                //Variable datos, con toda la información que se enviará a la vista
                $datos = [
                    'titulo'       => 'Plugins',
                    'icon'         => 'fas fa-plug',
                    'listado'      => $plugins,
                    'dataTables'   => $dataTables,
                    'nombrePlugin' => trim($_FILES["zip_file"]["name"]),
                    'ruta'         => trim($_FILES["zip_file"]["tmp_name"]),
                    'tipo'         => trim($_FILES["zip_file"]["type"]),
                ];

                //Setear valores
                $nombre = $datos['nombrePlugin'];
                $ruta   = $datos['ruta'];
                $tipo   = $datos['tipo'];

                //Instanciamos el objeto plugin manager
                $cargar = new PluginManager;

                //Ejecutamos mediante la variable exec la carga del plugin
                $this->exec = $cargar->uploadPlugin($nombre, $ruta, $tipo);
                if ($this->exec == true) {
                    //Si fue éxitosa la carga del plugin redirigimos al listado
                    redireccionar('/plugins?yes');
                }
            } else {
                //De lo contrario redirigimos al listado tambien
                redireccionar('/plugins');
            }
        } else {
            //Si no existe POST redirecionamos al listadio
            redireccionar('/plugins');
        }
        //Vista
        $this->vista('Plugins/ListPlugins', $datos);
    }

    /**
     * Método borrar()
     * se encarga de  eliminar Plugins del sistema.
     * @access public
     * @param  $plugin
     */
    public function borrar()
    {
        //Comprobamos si existe el método post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //rescatamos el nombre identificador del plugin
            $plugin = $_POST['id'];

            //Instanciamos el Objeto PluginManager
            $pluginSystem = new PluginManager;

            //Ejecutamos con la variable exec la instancia y el llamado al método deletePlugin.
            $this->exec = $pluginSystem->deletePlugin(RUTA_PLUGINS . $plugin);
            if ($this->exec == true) {
                //Si el plugin fue eliminado retornamos
                echo "true";
            } else {
                //De lo contario
                echo "false";
            }
        } else {
            redireccionar('/Plugins');
        }
    }

    //Método para obtener los
    public function getExistingPlugins($ruta)
    {
        $folder = opendir($ruta);
        $i      = 0;
        while ($file = readdir($folder)) {
            if ($file != "." && $file != ".." && !is_dir($file) && $file != ".htaccess" && $file != "Login.php" && $file != "Api.php" && $file != "Email.php" && $file != "Cron.php") {
                $plugs[$i++] = str_replace($ruta, "", $file);
            }
            if ($i == 0) {
                //Aun no hay plugins cargados en el sistema
                $plugs = [];
            }
        }

        return $plugs;
    }

    //Método deshabiliar Plugin
    public function setPlugin()
    {
        //Comprobamos si existe el método post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //rescatamos el nombre identificador del plugin
            $plugin = $_POST['id'];
            $config = parse_ini_file(RUTA_PLUGINS . $plugin . SEPARATOR . 'info.ini', true);

            //Comprobar el estado actual del plugin
            if ($config["detalles"]["estado"] != "activo") {
                //Si esta inactivo, su nuevo estado es activo.
                $config["detalles"]["estado"] = "activo";
            } else {
                //De lo contratio sera inactivo
                $config["detalles"]["estado"] = "inactivo";
            }

            // write ini file
            if ($this->write_ini_file(RUTA_PLUGINS . $plugin . SEPARATOR . 'info.ini', $config)) {
                echo "true";
            } else {
                echo "Hubo un error al realizar el cambio.";
            }
        } else {
            //redireccionar('/Plugins');
        }
    }

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
                //Personalizado
                return $this->filesGTEP('Assets' . SEPARATOR . __CLASS__, $_GET['js'], 'js', 'Assets');
            }
            if (isset($_GET['css'])) {
                return $this->filesGTEP($this->nombrePlugin, $_GET['css'], 'css');
            }
        } else {
            $this->pagina404(false);
        }
    }

    public function tableViews()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = array(
                'data' => array(),
            );

            foreach ($this->getExistingPlugins(RUTA_PLUGINS) as $plugin) {
                $info = parse_ini_file(RUTA_PLUGINS . $plugin . SEPARATOR . 'info.ini', true);

                $datosPlugin = array(
                    'nombre'      => $info["detalles"]["nombre"],
                    'descripcion' => $info["detalles"]["desc"],
                    'version'     => $info["detalles"]["version"],
                    'autor'       => $info["detalles"]["autor"],
                    'estado'      => $info["detalles"]["estado"],
                    'id'          => $info["detalles"]["nombre"],
                );

                array_push($data['data'], $datosPlugin);
            }
            header("Content-type: application/json; charset=utf-8");
            echo json_encode($data, JSON_PRETTY_PRINT);
        } else {
            redireccionar('/');
        }
    }

    public function listadoPlugin()
    {

        $plugins = array();

        foreach ($this->getExistingPlugins(RUTA_PLUGINS) as $plugin) {
            $info = parse_ini_file(RUTA_PLUGINS . $plugin . SEPARATOR . 'info.ini', true);
            array_push($plugins, array("nombre" => $info["detalles"]["nombre"], "icon" => $info["detalles"]["icon"], "estado" => $info["detalles"]["estado"]));
        }

        header("Content-type: application/json; charset=utf-8");
        echo json_encode($plugins, JSON_PRETTY_PRINT);
    }
}
