<?php

class Producto
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
        $this->relacion = (count($this->ObtenerPresentacion()) > 0 ? "INNER JOIN presentacion ON presentacion.IdPresentacion=producto.IdPresentacion" : NULL);
        $this->relacion = (count($this->ObtenerMarca()) > 0 ? "INNER JOIN marca ON marca.IdMarca=producto.IdMarca" : NULL);
        $this->relacion = (count($this->ObtenerUnidadMedida()) > 0 ? "INNER JOIN unidad_medida ON unidad_medida.IdUnidadMedida=producto.IdUnidadMedida" : NULL);
    }

    public function ObtenerTodos(string $ordenar = '')
    {
        $this->db->query("SELECT * FROM producto");
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
        if ($join !=  NULL) {
            $this->db->query("SELECT * FROM tipo_producto");
            return $this->db->registros();
        } else {
            $this->db->query("SELECT * FROM tipo_producto");
            return $this->db->registros() ?? new StdClass;
        }
    }

    public function ObtenerPresentacion()
    {
        $join = $this->relacion;
        if ($join !=  NULL) {
            $this->db->query("SELECT * FROM presentacion");
            return $this->db->registros();
        } else {
            $this->db->query("SELECT * FROM presentacion");
            return $this->db->registros() ?? new StdClass;
        }
    }

    public function ObtenerMarca()
    {
        $join = $this->relacion;
        if ($join !=  NULL) {
            $this->db->query("SELECT * FROM marca");
            return $this->db->registros();
        } else {
            $this->db->query("SELECT * FROM marca");
            return $this->db->registros() ?? new StdClass;
        }
    }

    public function ObtenerUnidadMedida()
    {
        $join = $this->relacion;
        if ($join !=  NULL) {
            $this->db->query("SELECT * FROM unidad_medida");
            return $this->db->registros();
        } else {
            $this->db->query("SELECT * FROM unidad_medida");
            return $this->db->registros() ?? new StdClass;
        }
    }

    public function agregarProducto($datos = [])
    {
        $this->comprobator = $this->comprobarProducto($datos['CodigoProducto']);
        $this->comprobator1 = $this->soloLetras($datos['NombreProducto']);
        $this->comprobator2 = $this->is_negative_number($datos['PrecioSugerido']);
        $this->comprobator3 = $this->is_negative_number($datos['StockMaximo']);
        $this->comprobator4 = $this->is_negative_number($datos['StockMinimo']);
        $this->comprobator5 = $this->is_negative_number($datos['Existencias']);
        $this->comprobator6 = $this->is_negative_number($datos['Contenido']);

        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        }
        if ($this->comprobator1 == true) {
            //solo letras
            return 4;
        }
        if ($this->comprobator2 == true) {
            //solo letras
            return 5;
        }
        if ($this->comprobator3 == true) {
            //solo letras
            return 6;
        }
        if ($this->comprobator4 == true) {
            //solo letras
            return 7;
        }
        if ($this->comprobator5 == true) {
            //solo letras
            return 8;
        }
        if ($this->comprobator6 == true) {
            //solo letras
            return 9;
        }
        else {
            $this->db->query('INSERT INTO producto (IdMarca, IdPresentacion, 
        IdTipoProducto,CodigoProducto,IdUnidadMedida,NombreProducto,PrecioSugerido,
        StockMaximo,StockMinimo,Existencias,Contenido,Estado_P) VALUES(:IdMarca, :IdPresentacion, :IdTipoProducto,:CodigoProducto, 
        :IdUnidadMedida, :NombreProducto,:PrecioSugerido, :StockMaximo,:StockMinimo,:Existencias, :Contenido,1)');

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
    public function comprobarProducto($cliente)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($cliente) && !empty($cliente)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM producto WHERE CodigoProducto=:CodigoProducto");
            //Vinculamos consulta
            $this->db->bind(':CodigoProducto', $cliente);
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

    function soloLetras($in)
    {
        if (preg_match('/^[\pL\s]+$/u', $in)) return false;
        else return true;
    }

    function is_negative_number($number=0){

        if( is_numeric($number) AND ($number<0) ){
            return true;
        }else{
            return false;
        }
    
    }
}
