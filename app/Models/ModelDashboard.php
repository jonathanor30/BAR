<?php

/**
 *
 */
class ModelDashboard
{
    private $db; //Manejador de la base de datos
    public function __construct()
    {
        $this->db = new Base; //Instancia de conexión a la base de datos

    }

    //Método para obtener el total de registro en una tabla
    public function totalRegistros($tabla)
    {

        //Preparamos la consulta SQL
        $this->db->query('SELECT COUNT(*) FROM ' . $tabla);

        $total = $this->db->fetchColumn();

        return $total;
    }
    //Método para obtener servicios de vehiculos
    public function obtenerServicios()
    {
        $this->db->query('SELECT * FROM servicios');
        return $this->db->registrosrow();
    }

    public function disponibilidad($id, $status, $tabla)
    {
        //Preparamos consulta
        $this->db->query('SELECT COUNT(:id)  FROM ' . $tabla . ' WHERE status_vehiculo=:status');

        //Vinculamos valores
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);

        //$this->db->registrosrow();

        return  $this->db->registrosrow();
    }
}
