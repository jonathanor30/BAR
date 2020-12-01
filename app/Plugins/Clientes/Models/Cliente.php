<?php

class Cliente
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
        $this->relacion = (count($this->ObtenerVentas()) > 0 ? "INNER JOIN venta on cliente.IdCliente=venta.IdCliente" : NULL);
        $this->relacion = (count($this->ObtenerTipoDocumento()) > 0 ? "INNER JOIN tipo_documento ON tipo_documento.IdTipoDocumento=cliente.IdTipoDocumento" : NULL);
    }

    public function ObtenerTodos(string $ordenar = '')
    {
        $this->db->query("SELECT * FROM cliente");
        return $this->db->registrosrow();
    }

    public function ObtenerUno(string $campo = '', $id = null)
    {
            $this->db->query("SELECT * FROM cliente WHERE IdCliente=1");
        
        return $this->db->registro();
    }
    //Método para eliminar usuario del sistema
    public function actualizarProducto($datos = [], string $tipo = '', string $campo = '', $value = false, $id = false)
    {
        if ($tipo != '') {
            $this->db->query("UPDATE producto SET {$campo}=:value WHERE IdProducto=:id");
            $this->db->bind(':value', $value);
            $this->db->bind(':id', $id);
            if ($this->db->execute()) {
                return false;
            } else {
                return true;
            }
        } else {
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
    }

    public function ObtenerTipoDocumento()
    {
        $join = $this->relacion;
        if ($join !=  NULL) {
            $this->db->query("SELECT * FROM tipo_documento");
            return $this->db->registros();
        } else {
            $this->db->query("SELECT * FROM tipo_documento");
            return $this->db->registros() ?? new StdClass;
        }
    }

    public function ObtenerVentas()
    {
        $join = $this->relacion;
        if ($join != NULL) {
            $this->db->query("SELECT * FROM venta ");
            return $this->db->registros();
        } else {
            $this->db->query("SELECT * FROM venta ");
            return $this->db->registros() ?? new StdClass ;
        }
    }

    public function agregarCliente($datos = [])
    {
        $this->comprobator = $this->comprobarCliente($datos['Numero_Documento']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO cliente (IdTipoDocumento, Numero_Documento, Nombre) VALUES(:IdTipoDocumento, :Numero_Documento, :Nombre)');

            //Vincular valores
            /*
            $this->db->bind(':IdTipoDocumento', $datos['IdTipoDocumento']);
            $this->db->bind(':Numero_Documento', $datos['Numero_Documento']);
            $this->db->bind(':Nombre', $datos['Nombre']);
             */
            //Algoritmo para vincular valores de las columnas a la consulta preparada
            //Requisito: los seudo campos de las columna en VALUE() de la consulta, debe ser iguales a los nombres
            //de los indices en la variable datos que son recibidos desde el controlador
            foreach ($datos as $campo => $valor) {
                //Iteración en el método  bind() de la clase Base, donde se agrega el indice y valor
                $this->db->bind(":{$campo}", $valor);
            }

            //Ejecutar consulta
            if ($this->db->execute()) {
                return 2;
            } else {

                return 1;
            }
        }
    }
    public function agregarVenta($datos = [])
    {
        $this->comprobator = $this->comprobarVenta($datos['IdVenta']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO venta (user_id, IdCliente, hora, fecha, observaciones, hora) VALUES(:user_id, :IdCliente, :IdEstadoVenta, :fecha, :observaciones, :hora)');

            //Vincular valores
            /*
            $this->db->bind(':user_id', $datos['user_id']);
            $this->db->bind(':IdCliente', $datos['IdCliente']);
            $this->db->bind(':IdEstadoVenta', $datos['IdEstadoVenta']);
            $this->db->bind(':fecha', $datos['fecha']);
            $this->db->bind(':observaciones', $datos['observaciones']);
            $this->db->bind(':hora', $datos['hora']);
             */
            //Algoritmo para vincular valores de las columnas a la consulta preparada
            //Requisito: los seudo campos de las columna en VALUE() de la consulta, debe ser iguales a los nombres
            //de los indices en la variable datos que son recibidos desde el controlador
            foreach ($datos as $campo => $valor) {
                //Iteración en el método  bind() de la clase Base, donde se agrega el indice y valor
                $this->db->bind(":{$campo}", $valor);
            }

            //Ejecutar consulta
            if ($this->db->execute()) {
                return 2;
            } else {

                return 1;
            }
        }
    }
    public function agregarProducto($datos = [])
    {
        $this->comprobator = $this->comprobarProducto($datos['IdVenta']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO venta (fecha, observaciones, hora, user_id, IdCliente, IdEstadoVenta) VALUES(:fecha, :observaciones, :hora, :user_id, :IdCliente, :IdEstadoVenta)');

            //Vincular valores
            /*
            $this->db->bind(':fecha', $datos['fecha']);
            $this->db->bind(':observaciones', $datos['observaciones']);
            $this->db->bind(':hora', $datos['hora']);
            $this->db->bind(':hora', $datos['hora']);
            $this->db->bind(':hora', $datos['hora']);
             */
            //Algoritmo para vincular valores de las columnas a la consulta preparada
            //Requisito: los seudo campos de las columna en VALUE() de la consulta, debe ser iguales a los nombres
            //de los indices en la variable datos que son recibidos desde el controlador
            foreach ($datos as $campo => $valor) {
                //Iteración en el método  bind() de la clase Base, donde se agrega el indice y valor
                $this->db->bind(":{$campo}", $valor);
            }

            //Ejecutar consulta
            if ($this->db->execute()) {
                return 2;
            } else {

                return 1;
            }
        }
    }
    public function comprobarCliente($cliente)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($cliente) && !empty($cliente)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM cliente WHERE Numero_Documento=:Numero_Documento");
            //Vinculamos consulta
            $this->db->bind(':Numero_Documento', $cliente);
            $this->db->execute();
            $this->result = $this->db->rowCount();
            if ($this->result == 1) {
                //Existe
                return true;
            } else {
                //No existe
                return false;
            }
        }
    }
    public function comprobarVenta($venta)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($venta) && !empty($venta)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM venta WHERE IdVenta=:IdVenta");
            //Vinculamos consulta
            $this->db->bind(':IdVenta', $venta);
            $this->db->execute();
            $this->result = $this->db->rowCount();
            if ($this->result == 1) {
                //Existe
                return true;
            } else {
                //No existe
                return false;
            }
        }
    }
    public function comprobarProducto($producto)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($producto) && !empty($producto)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM producto WHERE IdProducto=:IdProducto");
            //Vinculamos consulta
            $this->db->bind(':IdProducto', $producto);
            $this->db->execute();
            $this->result = $this->db->rowCount();
            if ($this->result == 1) {
                //Existe
                return true;
            } else {
                //No existe
                return false;
            }
        }
    }

    public function editarCliente($datos = [])
    {
        $this->db->query('UPDATE cliente SET Nombre=:Nombre, IdTipoDocumento=:IdTipoDocumento,  Numero_Documento:=Numero_Documento  WHERE  	IdCliente=:IdCliente');

        //Vincular valores
        $this->db->bind(':IdCliente', $datos['IdCliente']);
        $this->db->bind(':IdTipoDocumento', $datos['IdTipoDocumento']);
        $this->db->bind(':Numero_Documento', $datos['Numero_Documento']);


        //Ejecutar consulta
        if ($this->db->execute()) {
            return 2;
        } else {

            return 1;
        }
    }    

    public function horaMYSQL()
    {
        $hoy  = getdate();
        $hora = $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];

        return $hora;
    }

    public function ObtenerPrecios($venta)
    {
        $this->db->query("SELECT IdVenta, IdCliente, fecha, hora FROM venta v INNER JOIN cliente c on v.IdCliente = c.IdCliente WHERE IdVenta=:venta");
        $this->db->bind(':venta', $venta);
        return $this->db->registros();
    }

    public function Obtenerventas2()
    {

        $this->db->query("SELECT * FROM venta");
        return $this->db->registros();
    }

    public function obtenerdatos($id)
    {
        $this->db->query("SELECT * FROM cliente WHERE IdCliente=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }


    public function pruebaxd($id=null)
    {
        $this->db->query("SELECT v.IdVenta, c.IdCliente, c.Nombre, Fecha, dv.total, p.NombreProducto, c.Numero_Documento FROM detalle_venta dv INNER JOIN venta v on dv.IdVenta=v.IdVenta inner join cliente c on v.IdCliente=c.IdCliente INNER JOIN producto p on dv.IdProducto=p.IdProducto WHERE c.IdCliente=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }
    public function obtenertotal($id=null)
    {
        $this->db->query("SELECT SUM(total) as suma,total FROM detalle_venta WHERE IdVenta=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }

    public function obtenerventa($id)
    {
        $this->db->query("SELECT * FROM venta v INNER JOIN cliente c ON v.IdCliente = c.IdCliente WHERE  IdVenta=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }
    public function prueba2($id=null)
    {
         $this->db->query("SELECT * FROM venta v INNER JOIN cliente c ON v.IdCliente = c.IdCliente WHERE  IdCliente=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }

    public function VerVentas($variable)
    {
        $this->db->query("SELECT v.fecha,v.observaciones,v.hora,c.Nombre,u.user_name,e.Estado FROM venta v INNER JOIN cliente c ON v.IdCliente = c.IdCliente INNER JOIN estado_venta e on v.IdEstadoVenta = e.IdEstadoVenta INNER JOIN users u ON v.user_id = u.user_id WHERE IdVenta=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $variable);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }
    public function VerProductos($variable)
    {
        $this->db->query("SELECT d.cantidad,d.iva,d.total,p.NombreProducto,p.PrecioSugerido,m.Nombre FROM detalle_venta d INNER JOIN producto p ON d.IdProducto = p.IdProducto INNER JOIN marca m ON p.IdMarca = m.IdMarca ");
        //Vinculamos el valor del id
        $this->db->bind(':id', $variable);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }
    public function ObtenerPresentacion(string $campo = '', $id = null)
    {
        
            $this->db->query("SELECT * FROM presentacion WHERE {$campo}=:id");
        
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }
    public function ObservarTodo($variable)
    {
        $this->db->query("SELECT v.fecha,v.observaciones,v.hora,c.Nombre,u.user_name,e.Estado, d.cantidad,d.iva,d.total,p.NombreProducto,p.PrecioSugerido,m.Nombre 
        FROM venta v INNER JOIN cliente c ON v.IdCliente = c.IdCliente INNER JOIN estado_venta e on v.IdEstadoVenta = e.IdEstadoVenta 
        INNER JOIN users u ON v.user_id = u.user_id INNER JOIN detalle_venta d on v.IdVenta = d.IdVenta INNER JOIN producto p on d.IdProducto = p.IdProducto 
        INNER JOIN marca m on p.IdMarca = m.IdMarca WHERE v.IdVenta=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $variable);
        //Ejecutamos la consulta
        $this->db->execute();
        return $this->db->registros();
    }
}
