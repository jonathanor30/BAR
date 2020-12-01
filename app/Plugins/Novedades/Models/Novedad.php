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

    public function horaMYSQL()
    {
        $hoy  = getdate();
        $hora = $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];

        return $hora;
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
    public function ObtenerRegistro(string $campo = '', string $tabla, $id = null)
    {
        $this->db->query("SELECT * FROM {$tabla} WHERE {$campo}=:id");
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }


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
///////////////////////////crear compra///////////////////////////
    public function ObtenerPrecios($producto)
    {
        $this->db->query("SELECT CodigoProducto,PrecioSugerido,Nombre,NombreProducto FROM producto p INNER JOIN marca m on p.IdMarca = m.IdMarca WHERE CodigoProducto=:producto");
        $this->db->bind(':producto', $producto);     
        return $this->db->registros();
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

    public function observacion($dat,$tipo)
    {
        if($tipo==1)
        {
            $this->db->query("INSERT INTO novedad(IdTiponovedad,Descripcion,Fecha,hora) VALUES (1,:FacObservacion,:fecha,:hora)");
            $this->db->bind(':FacObservacion', $dat['FacObservacion']);
            $this->db->bind(':fecha', date('Y-m-d'));
            $this->db->bind(':hora', $this->horaMYSQL());
            if ($this->db->execute()) {
                return false;
            } else {
                return true;
            }  
        }
        else{
        if (isset($dat['FacObservacion'])) {
            $this->db->query("INSERT INTO novedad(IdTiponovedad,Descripcion,Fecha,hora) VALUES (2,:FacObservacion,:fecha,:hora)");
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
    }
    public function SaveInvProv($datos)
    {
        if (isset($datos['IdTipoProducto'])) {
            $last = $this->Last('novedad', 'IdNovedad');
            $this->db->query("INSERT INTO detalle_novedad(IdProducto,IdNovedad,cantidad,iva,total) VALUES (:IdTipoProducto,:IdNovedad,:cantidad,:iva,:total)");
            $this->db->bind(':IdTipoProducto', $datos['IdTipoProducto']);
            $this->db->bind(':IdNovedad', $last->IdNovedad);
            $this->db->bind(':cantidad', $datos['cantidad']);
            $this->db->bind(':iva', $datos['iva']);
            $this->db->bind(':total', $datos['total']);
            if ($this->db->execute()) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function actualizarproducto($datos,$tipo)
    {
        if($tipo==1)
        {
            $this->db->query('UPDATE producto SET Existencias = Existencias -:cantidad WHERE IdProducto=:IdProducto');
            $this->db->bind(':cantidad', $datos['cantidad']);
            $this->db->bind(':IdProducto', $datos['IdTipoProducto']);
            if ($this->db->execute()) {
                return 2;
            } else {
                return 1;
            }
        }
        else{
        $this->db->query('UPDATE producto SET Existencias = Existencias +:cantidad WHERE IdProducto=:IdProducto');
        $this->db->bind(':cantidad', $datos['cantidad']);
        $this->db->bind(':IdProducto', $datos['IdTipoProducto']);
        if ($this->db->execute()) {
            return 2;
        } else {
            return 1;
        }
    }
    }

    




    /////////////////////////////////////crear venta///////////////////////////////





    public function SaveInvProv2($datos)
    {
        if (isset($datos['IdTipoProducto'])) {
            $last = $this->Last('venta', 'IdVenta');
            $this->db->query("INSERT INTO detalle_venta(IdProducto,IdVenta,IdUnidadMedida,Unidad_Medida,cantidad,iva,total) VALUES (:IdTipoProducto,:IdVenta,1,1,:cantidad,:iva,:total)");
            $this->db->bind(':IdTipoProducto', $datos['IdTipoProducto']);
            $this->db->bind(':IdVenta', $last->IdVenta);
            $this->db->bind(':cantidad', $datos['cantidad']);
            $this->db->bind(':iva', $datos['iva']);
            $this->db->bind(':total', $datos['total']);
            if ($this->db->execute()) {

                return false;
            } else {
                $this->db->query('UPDATE producto SET Existencias = Existencias-:cantidad WHERE IdProducto=:IdTipoProducto');
                $this->db->bind(':cantidad', $datos['cantidad']);
                $this->db->bind(':IdTipoProducto', $datos['IdTipoProducto']);
                $this->db->execute();
                return true;
            }
        }
    }

   
 public function obtenerdaton($id)
 {
   
        $this->db->query("SELECT * FROM novedad n INNER JOIN tipo_novedad t ON n.IdTipoNovedad = t.IdTipoNovedad WHERE IdNovedad=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registro();
    
 }
 public function obtenerdetallen($id)
 {
   
        $this->db->query("SELECT d.total,d.iva,d.cantidad,p.NombreProducto,p.PrecioSugerido,m.Nombre FROM detalle_novedad d INNER JOIN producto p ON d.IdProducto = p.IdProducto INNER JOIN marca m ON p.IdMarca = m.IdMarca WHERE IdNovedad=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    

 }
 public function total($id)
 {
    
    $this->db->query("SELECT SUM(total) as total,IdNovedad FROM detalle_novedad  WHERE IdNovedad=:id");
    //Vinculamos el valor del id
    $this->db->bind(':id', $id);
    //Ejecutamos la consulta
    $this->db->execute();
    return $this->db->registro();
 }

    
}


