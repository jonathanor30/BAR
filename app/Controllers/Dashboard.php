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
 * Dashboard controller of the Elephant framework-
 *
 * @author Juan Bautista <soyjuanbautista0@gmail.com>
 *
 */
class Dashboard extends Controller
{

    public function __construct()
    {
        //Esto debe ir acá en el constructor si quieres proteger el acceso al mismo
        $this->sessionValidator();
        $this->adminProtector(); //Protección admin
        $this->dashboardModelo = $this->modelo('ModelDashboard'); //Instancia del modelo

    }

    public function index()
    {

        $vehiculosActivos = array();
        //Graficas
        $servicios          = $this->dashboardModelo->obtenerServicios();
        $vehiculosActivos   = $this->dashboardModelo->disponibilidad('id_vehiculo', '1', 'vehiculos');
        $vehiculosInactivos = $this->dashboardModelo->disponibilidad('id_vehiculo', '0', 'vehiculos');
        $vehiculosDesvin    = $this->dashboardModelo->disponibilidad('id_vehiculo', '2', 'vehiculos');
        //set

        //contador de registros
        $total = (object) [
            'vehiculos'   => $this->totalElementos('vehiculos'),
            'conductores' => $this->totalElementos('conductores'),
            'contratos'   => $this->totalElementos('contratos'),
            'extractos'   => $this->totalElementos('extractos'),
            'servicios'   => $this->totalElementos('servicios'),
        ];

        //datos que se envian a la vista
        $datos = [
            'titulo'              => 'Dashboard',
            'total'               => $total,
            'servicios'           => $servicios,
            'vehiculos_activos'   => implode("','", $vehiculosActivos[0]),
            'vehiculos_inactivos' => implode("','", $vehiculosInactivos[0]),
            'vehiculos_desvin'    => implode("','", $vehiculosDesvin[0]),
        ];

        //Acá se difine la vista del método index
        $this->vista('Dashboard/Dashboard', $datos, false, 'formatter');
    }

    //Método para ver el total de registros en una tabla
    public function totalElementos($tabla)
    {
        return $this->dashboardModelo->totalRegistros($tabla);
    }
}
