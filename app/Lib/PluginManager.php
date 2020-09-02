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
 * Class Plugin Manager of the Elephant framework
 *
 * @author Juan Bautista <soyjuanbautista0@gmail.com>
 */
class PluginManager
{
    const pluginListFolder = RUTA_PLUGINS;
    const extensionPlugin  = ".php";

    private static $_yo;
    protected $_string;
    protected $_url;
    protected $_pluginName;
    protected $_icon;
    protected $_autor;
    protected $_description;

    public function getPluginUrl()
    {
        return $this->_url;
    }
    public function getPluginName()
    {
        return $this->_pluginName;
    }
    public function getPluginIcon()
    {
        return $this->_icon;
    }
    /**************************************
     * Patrón singleton
     * ************************************ */

    public static function getPluginLoader()
    {
        if (self::$_yo === null) {
            self::$_yo = new self;
        }
        return self::$_yo;
    }

    /**
     * Para que no se clone
     */
    private function __clone()
    {
    }

    public static function load($class)
    {
        $file = self::pluginListFolder . $class . self::extensionPlugin;
        if (!file_exists($file)) {
            throw new Exception('El fichero ' . $file . ' que debe contener la clase o interfaz ' . $class . ' no se ha encontrado.');
        }
        require $file;
        if (!class_exists($class, false) && !interface_exists($class, false)) {
            throw new Exception('La clase o interfaz ' . $class . ' no se ha encontrado.');
        }
    }

    public static function load_once($class)
    {
        $file = self::pluginListFolder . $class . self::extensionPlugin;
        if (!file_exists($file)) {
            throw new Exception('El fichero ' . $file . ' que debe contener la clase o interfaz ' . $class . ' no se ha encontrado.');
        }
        require_once $file;
        if (!class_exists($class, false) && !interface_exists($class, false)) {
            throw new Exception('La clase o interfaz ' . $class . ' no se ha encontrado.');
        }
    }

    /**********************************************
     * Comprueba que ficheros plugin hay en la carpeta de plugins
     */

    public static function getExistingPlugins()
    {
        $folder = opendir(self::pluginListFolder);
        $i      = 0;
        while ($file = readdir($folder)) {
            if ($file != "." && $file != ".." && !is_dir($file) && $file != ".htaccess") {
                $plugs[$i++] = str_replace(self::extensionPlugin, "", $file);
            }
            if ($i == 0) {
                //Aun no hay plugins cargados en el sistema
                $plugs = [];
            }
        }

        return $plugs;
    }
    //Función para cargar plugin al sistema
    public function uploadPlugin($nombre, $ruta, $tipo)
    {
        $zip = new ZipArchive;
        //en la función open se le pasa la ruta de nuestro archivo (alojada en carpeta temporal)
        if ($zip->open($ruta) === true) {
            //función para extraer el ZIP, le pasamos la ruta donde queremos que nos descomprima
            $file_      = explode('.', $nombre);
            $file_route = RUTA_PLUGINS . $file_[0];
            if (file_exists($file_route)) {
                echo "No se puede cargar el plugin, por que ya existe";
            } else {
                if (mkdir($file_route, 0777, true)) {
                    echo "Plugin " . $file_[0] . " añadido correctamente. ";
                    $zip->extractTo(RUTA_PLUGINS);
                    $zip->close();
                }
            }
        }

        //creamos un array para guardar el nombre de los archivos que contiene el ZIP
        $nombresFichZIP = array();
        $zip            = new ZipArchive;

        if ($zip->open($ruta) === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                //obtenemos ruta que tendrán los documentos cuando los descomprimamos
                $nombresFichZIP['tmp_name'][$i] = RUTA_PLUGINS . $zip->getNameIndex($i);
                //obtenemos nombre del fichero
                $nombresFichZIP['name'][$i] = $zip->getNameIndex($i);
            }

            //descomprimimos zip
            $zip->extractTo(RUTA_PLUGINS);
            $zip->close();
        }

        return true;
    }

    //Función para eliminar plugin
    public static function deletePlugin($path)
    {
        if (!is_dir($path)) {
            throw new InvalidArgumentException("$path is not a directory");
        }
        if (substr($path, strlen($path) - 1, 1) != '/') {
            $path .= '/';
        }
        $dotfiles = glob($path . '.*', GLOB_MARK);
        $files    = glob($path . '*', GLOB_MARK);
        $files    = array_merge($files, $dotfiles);
        foreach ($files as $file) {
            if (basename($file) == '.' || basename($file) == '..') {
                continue;
            } else if (is_dir($file)) {
                self::deletePlugin($file);
            } else {
                unlink($file);
            }
        }
        if (rmdir($path)) {
            return true;
        }
    }
}
