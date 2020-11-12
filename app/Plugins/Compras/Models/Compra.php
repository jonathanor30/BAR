<?php

class Compra
{
    /**
     * @var object
     * Instancia de la conexión
     */
    private $db;
    /**
     * @var mixed
     * Puede ser lo que queramos ;)
     */
    public $resultado;

    public function __construct()
    {
        //Instancia de la conexión con base de datos
        $this->db = new Base;
    }
    public function horaMYSQL()
    {
        $hoy  = getdate();
        $hora = $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];

        return $hora;
    }

    public function ObtenerTodos(string $ordenar = '')
    {
        $this->db->query("SELECT * FROM compra");
        return $this->db->registrosrow();
    }

    public function ObtenerUno(string $campo = '', $id = null)
    {
        $this->db->query("SELECT * FROM compra WHERE {$campo}=:id");
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }

    public function ObtenerRegistro(string $campo = '', string $tabla, $id = null)
    {
        $this->db->query("SELECT * FROM {$tabla} WHERE {$campo}=:id");
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }


    public function ObtenerPrecios($producto)
    {
        $this->db->query("SELECT CodigoProducto,PrecioSugerido,Nombre,NombreProducto FROM producto p INNER JOIN marca m on p.IdMarca = m.IdMarca WHERE CodigoProducto=:producto");
        $this->db->bind(':producto', $producto);
        return $this->db->registros();
    }
    public function Obtenerproveedores()
    {

        $this->db->query("SELECT * FROM proveedor");
        return $this->db->registros();
    }

    public function observacion($dat)
    {
        if (isset($dat['FacObservacion'])) {
            $this->db->query("INSERT INTO compra(IdProveedor,fecha,observaciones,hora) VALUES (:idproveedor,:fecha,:FacObservacion,:hora)");
            $this->db->bind(':idproveedor', $dat['idproveedor']);
            $this->db->bind(':FacObservacion', $dat['FacObservacion']);
            $this->db->bind(':fecha', date('Y-m-d'));
            $this->db->bind(':hora', $this->horaMYSQL());
            if ($this->db->execute()) {
                return false;
            } else {
                return true;
            }
        }
    }
    public function SaveInvProv($datos)
    {
        if (isset($datos['IdTipoProducto'])) {
            $last = $this->Last('compra', 'IdCompra');
            $this->db->query("INSERT INTO detalle_compra(IdProducto,IdCompra,cantidad,iva,total) VALUES (:IdTipoProducto,:IdCompra,:cantidad,:iva,:total)");
            $this->db->bind(':IdTipoProducto', $datos['IdTipoProducto']);
            $this->db->bind(':IdCompra', $last->IdCompra);
            $this->db->bind(':cantidad', $datos['cantidad']);
            $this->db->bind(':iva', $datos['iva']);
            $this->db->bind(':total', $datos['total']);
            if ($this->db->execute()) {

                return false;
            } else {
                $this->db->query('UPDATE producto SET Existencias = Existencias+:cantidad WHERE IdProducto=:IdTipoProducto');
                $this->db->bind(':cantidad', $datos['cantidad']);
                $this->db->bind(':IdTipoProducto', $datos['IdTipoProducto']);
                $this->db->execute();
                return true;
            }
        }
    }

    public function Last($tabla, $campo = null)
    {
        if ($campo == null) {
            echo false;
        } else {
            $this->db->query("SELECT * FROM $tabla ORDER BY  $campo DESC LIMIT 0,1");
            if ($this->db->registro() != "") {
                $this->result = $this->db->registro();
                return $this->result;
            } else {
                echo false;
            }
        }
    }

    /**
     * Metodo para autocompletar facturas
     * @access public
     * @param array $datos
     * Termino e indice a buscar
     * @return object
     */
    public function AutoCompletarProducto($datos)
    {
        $this->db->query("SELECT * FROM producto p INNER JOIN marca m on p.IdMarca = m.IdMarca WHERE p.Estado_P=1 AND " . $datos['key'] . " LIKE '%" . $datos['term'] . "%' LIMIT 0 ,50");
        $this->db->execute();
        //Retornamos valor
        return $this->db->registrosrow();
    }
}
