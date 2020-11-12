<?php

class Proveedor
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
        $this->relacion = (count($this->ObtenerTiposDeProductos()) > 0 ? "INNER JOIN tipo_producto ON tipo_producto.IdTipoProducto=producto.IdTipoProducto" : NULL);
    }

    public function ObtenerTodos(string $ordenar = '')
    {
        $this->db->query("SELECT * FROM proveedor");
        return $this->db->registrosrow();
    }

    public function ObtenerUno(string $campo = '', $id = null)
    {
        $join = $this->relacion;
        if ($join != NULL) {
            $this->db->query("SELECT * FROM producto {$join} WHERE {$campo}=:id");
        } else {
            $this->db->query("SELECT * FROM producto WHERE {$campo}=:id");
        }
        $this->db->bind(":id", $id);
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

    public function ObtenerTiposDeProductos()
    {
        $join = $this->relacion;
        if ($join != NULL) {
            $this->db->query("SELECT * FROM tipo_producto");
            return $this->db->registros();
        } else {
            $this->db->query("SELECT * FROM tipo_producto");
            return $this->db->registros() ?? new StdClass ;
        }
    }

    public function agregarProveedor($datos = [])
    {
        $this->comprobator = $this->comprobarProveedor($datos['Nombre']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO proveedor (Nombre, Telefono) VALUES(:Nombre, :Telefono)');

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
    public function comprobarProveedor($proveedor)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($proveedor) && !empty($proveedor)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM proveedor WHERE Nombre=:Nombre");
            //Vinculamos consulta
            $this->db->bind(':Nombre', $proveedor);
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
}
