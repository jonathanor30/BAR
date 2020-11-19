<?php

class Venta
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

    public function ObtenerTodos(string $ordenar = '')
    {
        $this->db->query("SELECT * FROM venta");
        return $this->db->registrosrow();
    }

    public function ObtenerUno(string $campo = '', $id = null)
    {
        $this->db->query("SELECT * FROM venta WHERE {$campo}=:id");
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }
    public function obtenerdatos($id)
    {
        $this->db->query("SELECT * FROM detalle_venta WHERE IdVenta=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }

    public function CancelarVenta($id)
    {

                $this->db->query('UPDATE venta SET IdEstadoVenta= 3 WHERE IdVenta=:id');
            $this->db->bind(':id', $id);
            //Ejecutamos la consulta:
            if ($this->db->execute()) {
                return 2;
            } else {
                return 1;
            }
        
    }
    public function obtenertotal($id=null)
    {
        $this->db->query("SELECT SUM(total) as suma,total FROM `detalle_venta` WHERE  IdVenta=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }
    public function obtenerventa($id=null)
    {
        $this->db->query("SELECT * FROM venta c INNER JOIN cliente p ON c.IdCliente = p.IdCliente WHERE  IdVenta=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registro();
    }
    public function pruebaxd($id=null)
    {
        $this->db->query("SELECT IdVenta,cantidad,iva,total,NombreProducto,PrecioSugerido,Nombre FROM detalle_venta d INNER JOIN producto p ON  d.IdProducto=p.IdProducto INNER JOIN  marca m ON p.IdMarca = m.IdMarca WHERE IdVenta=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }
    public function actualizarVenta($id)
    {

        $this->db->query('UPDATE venta SET IdEstadoVenta= 1 WHERE IdVenta=:id');
            $this->db->bind(':id', $id);
       
        if ($this->db->execute()) {
          return 2;
        } else {
            return 1;
        }
             
    }
    //Método para eliminar usuario del sistema
    public function actualizarProducto($datos = [])
    {

        //Preparamos consulta:
        if ($datos['Estado_P'] != 1) {
            $this->db->query('UPDATE producto SET Estado_P= 1 WHERE IdProducto=:id');
        }
        if ($datos['Estado_P'] != 2) {
            $this->db->query('UPDATE producto SET Estado_P= 2 WHERE IdProducto=:id');
        }
        //Vinculamos valores:
        $this->db->bind(':id', $datos['IdProducto']);
        //Ejecutamos la consulta:
        if ($this->db->execute()) {
            return 2;
        } else {
            return 1;
        }
    }

    public function actualizarproductoinventario($datos)
    {
        $this->db->query('UPDATE producto SET Existencias = Existencias +:cantidad WHERE IdProducto=:IdProducto');
            $this->db->bind(':cantidad', $datos['cantidad']);
            $this->db->bind(':IdProducto', $datos['IdProducto']);
            if ($this->db->execute()) {
                return 2;
            } else {
                return 1;
            }
    }

    public function ObtenerClientes()
    {

        $this->db->query("SELECT * FROM cliente");
        return $this->db->registros();
    }
    public function ObtenerDocumento($cliente)
    {
        $this->db->query("SELECT  Numero_Documento FROM cliente WHERE IdCliente=:cliente");
        $this->db->bind(':cliente', $cliente);
        return $this->db->registros();
    }

    public function observacion($dat)
    {
        $sesion= $_SESSION['user_id'];
        if(isset($dat['FacObservacion'])){
            $this->db->query("INSERT INTO venta(user_id,IdCliente,IdEstadoVenta,fecha,observaciones,hora) VALUES ($sesion,:IdCliente,2,:fecha,:FacObservacion,:hora)");
                    $this->db->bind(':IdCliente', $dat['IdCliente']);
                    $this->db->bind(':FacObservacion', $dat['FacObservacion']);
                    $this->db->bind(':fecha', date('Y-m-d'));
                    $this->db->bind(':hora', $this->horaMYSQL());
                    if($this->db->execute())
                    {
                        return false;
                    }
                    else{
                        return true;
                    }
                    }
    }

    public function SaveInvProv($datos)
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
                return false;
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

    public function horaMYSQL()
	{
		$hoy  = getdate();
		$hora = $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];

		return $hora;
	}
}
