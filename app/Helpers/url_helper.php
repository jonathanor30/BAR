<?php

/**
 * This file is part of myGTEP
 * Copyright (C) 2018-2019 Juan Bautista <soyjuanbautista0@gmail.com>

 * Main Functions for MVC framework
 *
 * @author Juan Bautista <soyjuanbautista0@gmail.com>
 */

//Para redireccionar pagina
function redireccionar($pagina)
{
    header("location: " . RUTA_URL . $pagina);
}
//Add DataTables JS library
function dataTables()
{
    $dataTables = '<link rel="stylesheet" href="' . RUTA_URL . '/public/css/dataTables.bootstrap4.min.css"/>
      <script type="text/javascript" src="' . RUTA_URL . '/public/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="' . RUTA_URL . '/public/js/dataTables.bootstrap4.min.js"></script>';
    return $dataTables;
}
//Add VueJS library
function vueJS()
{
    //Include Vuejs local mode
    $vueJS = '<script src="' . RUTA_URL . '/public/js/vue.js"></script>';
    //Include Vuejs external mode witd CDN
    $cdn   = '<script src="https://cdn.jsdelivr.net/npm/vue"></script>';
    if (file_exists('../public/js/vue.js')) {
        return $vueJS;
    } else {
        return $cdn;
    }
}

function getExistingPlugins($ruta)
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

//Minify HTML code
function comprimir_pagina($html)
{
    $busca     = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
    $reemplaza = array('>', '<', '\\1');
    return preg_replace($busca, $reemplaza, $html);
}
function comprimir_css($css)
{
    $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css); // negative look ahead
    $css = preg_replace('/\s{2,}/', ' ', $css);
    $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
    $css = preg_replace('/;}/', '}', $css);
    return $css;
}
function comprimir_js($javascript)
{
    return preg_replace(array("/\s+\n/", "/\n\s+/", "/ +/"), array("\n", "\n ", " "), $javascript);
}
