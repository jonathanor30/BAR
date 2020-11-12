<?php

class Novedad
{
    /**
     * @var object
     * Instancia de la conexión
     */
    public $db;
    /**
     * @var mixed
     * Puede ser lo que queramos ;)
     */
    public $resultado;

    /**
     * 
     * @var string
     * 
     */
    private $relacion;

    public function __construct()
    {
        //Instancia de la conexión con base de datos
        $this->db = new Base;
        /*
        $this->relacion = (count($this->ObtenerTiposDeProductos()) > 0 ? "INNER JOIN tipo_producto ON tipo_producto.IdTipoProducto=producto.IdTipoProducto" : NULL);
        */
    }

    public function ObtenerTodos(string $ordenar = '')
    {
        $this->db->query("SELECT * FROM novedad");
        return $this->db->registrosrow();
    }

    public function ObtenerUno(string $campo = '', $id = null)
    {
        $join = $this->relacion;
        if ($join != NULL) {
            $this->db->query("SELECT * FROM novedad {$join} WHERE {$campo}=:id");
        } else {
            $this->db->query("SELECT * FROM novedad WHERE {$campo}=:id");
        }
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }
    //Método para eliminar usuario del sistema


    public function ObtenerTiposDeNovedades()
    {
        $join = $this->relacion;
        if ($join !=  NULL) {
            $this->db->query("SELECT * FROM tipo_novedad");
            return $this->db->registros();
        } else {
            $this->db->query("SELECT * FROM tipo_novedad");
            return $this->db->registros() ?? new StdClass;
        }
    }

    public function ObtenerTiposDeProducto()
    {
        $join = $this->relacion;
        if ($join !=  NULL) {
            $this->db->query("SELECT CodigoProducto,NombreProducto,Nombre FROM producto p INNER JOIN marca m on p.IdMarca = m.IdMarca");
            return $this->db->registros();
        } else {
            $this->db->query("SELECT CodigoProducto,NombreProducto,Nombre FROM producto p INNER JOIN marca m on p.IdMarca = m.IdMarca");
            return $this->db->registros() ?? new StdClass;
        }
    }

    public function ObtenerPrecios($producto)
    {
        $this->db->query("SELECT CodigoProducto,PrecioSugerido,Nombre,NombreProducto FROM producto p INNER JOIN marca m on p.IdMarca = m.IdMarca WHERE CodigoProducto=:producto");
        $this->db->bind(':producto', $producto);     
        return $this->db->registros();
    }

    public function SaveInvProv($datos)
	{
        $this->db->query('UPDATE producto SET Existencias = Existencias -:cantidad WHERE IdProducto=:IdTipoProducto');
        $this->db->bind(':cantidad', $datos['cantidad']);
        $this->db->bind(':IdTipoProducto', $datos['IdTipoProducto']);
        $this->db->execute();
            if (isset($datos['IdTipoProducto'])) {
                $this->db->query("INSERT INTO novedad(IdProducto,IdTipoNovedad,Cantidad,Descripcion,Fecha,Iva,Total) VALUES (:IdTipoProducto,1,:cantidad,:FacObservacion,:fecha,:iva,:total)");
                $this->db->bind(':IdTipoProducto', $datos['IdTipoProducto']);
                $this->db->bind(':cantidad', $datos['cantidad']);
                $this->db->bind(':FacObservacion', $datos['FacObservacion']);
                $this->db->bind(':fecha', date('Y-m-d'));
                $this->db->bind(':iva', $datos['iva']);
                $this->db->bind(':total', $datos['total']);
                if ($this->db->execute()) {
                    return false;
                } else {
                    return true;
                }
            } 
                
        
	}

    
}
