<?php

/**
     * 
     * index
     * (IN) Method for deafault
     * (ES) Método por defecto
     * @access public
     */
    
class Configuracion1
{
    public $db;
    public function __construct()
    {
        //Instancia de la conexión con base de datos
        $this->db = new Base;
    }

    public function obtener()
    {
        //Preparamos consulta SQL
        $this->db->query("SELECT * FROM home WHERE IdHome= '1'");
        return $this->db->registro();
    }

    public function ObtenerUno(string $campo = '', $id = null)
    {
        
            $this->db->query("SELECT * FROM home WHERE {$campo}=:id");
        
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }
    
    public function ObtenerUnoTipoProducto(string $campo = '', $id = null)
    {
        
            $this->db->query("SELECT * FROM tipo_producto WHERE {$campo}=:id");
        
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }
    public function editarHome($datos)
    {
        //Preparacion de consulta SQL
        $this->db->query('UPDATE home SET Mision=:Mision, Vision=:Vision, Quienes_Somos=:Quienes_Somos  WHERE IdHome=:IdHome');
        //Vincular valores a la consulta
        $this->db->bind(':Mision', $datos['Mision']);
        $this->db->bind(':Vision', $datos['Vision']);
        $this->db->bind(':Quienes_Somos', $datos['Quienes_Somos']);
        $this->db->bind(':IdHome', $datos['IdHome']);

        //Ejecutar consulta
        if ($this->db->execute()) {
            return 2;
        } else {

            return 1;
        }
    }
      public function Obtenerdatos()
    {
        $this->db->query("SELECT * FROM home WHERE IdHome=1");    
        return $this->db->registros();
    }


    public function agregarTipo($datos = [])
    {
        $this->comprobator = $this->comprobarTipo($datos['Nombre']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO tipo_producto (Nombre) VALUES(:Nombre)');

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
    public function comprobarTipo($tipo)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($tipo) && !empty($tipo)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM tipo_producto WHERE Nombre=:Nombre");
            //Vinculamos consulta
            $this->db->bind(':Nombre', $tipo);
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

    public function agregarNovedad($datos = [])
    {
        $this->comprobator = $this->comprobarNovedad($datos['Nombre_Novedad']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO tipo_novedad (Nombre_Novedad) VALUES(:Nombre_Novedad)');

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
    public function comprobarNovedad($novedad)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($novedad) && !empty($novedad)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM tipo_novedad WHERE Nombre_Novedad=:Nombre_Novedad");
            //Vinculamos consulta
            $this->db->bind(':Nombre_Novedad', $novedad);
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

    public function agregarDocumento($datos = [])
    {
        $this->comprobator = $this->comprobarDocumento($datos['Nombre_Documento']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO tipo_documento (Nombre_Documento) VALUES(:Nombre_Documento)');

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
    public function comprobarDocumento($documento)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($documento) && !empty($documento)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM tipo_documento WHERE Nombre_Documento=:Nombre_Documento");
            //Vinculamos consulta
            $this->db->bind(':Nombre_Documento', $documento);
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

    public function agregarUnidad($datos = [])
    {
        $this->comprobator = $this->comprobarUnidad($datos['NombreUnidad']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO unidad_medida (NombreUnidad) VALUES(:NombreUnidad)');

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
    public function comprobarUnidad($unidad)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($unidad) && !empty($unidad)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM unidad_medida WHERE NombreUnidad=:NombreUnidad");
            //Vinculamos consulta
            $this->db->bind(':NombreUnidad', $unidad);
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

    public function agregarPresentacion($datos = [])
    {
        $this->comprobator = $this->comprobarPresentacion($datos['Nombre']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO presentacion (Nombre) VALUES(:Nombre)');

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
    public function comprobarPresentacion($presentacion)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($presentacion) && !empty($presentacion)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM presentacion WHERE Nombre=:Nombre");
            //Vinculamos consulta
            $this->db->bind(':Nombre', $presentacion);
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

    public function agregarMarca($datos = [])
    {
        $this->comprobator = $this->comprobarMarca($datos['Nombre']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO marca (Nombre) VALUES(:Nombre)');

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
    public function comprobarMarca($marca)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($marca) && !empty($marca)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM marca WHERE Nombre=:Nombre");
            //Vinculamos consulta
            $this->db->bind(':Nombre', $marca);
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

    public function borrar($datos = [])
    {
        if ($datos['IdTipoProducto'] != 1) {
            //Preparamos consulta:
            $this->db->query('DELETE FROM tipo_producto WHERE user_id=:id');
            //Vinculamos valores:
            $this->db->bind(':id', $datos['IdTipoProducto']);
            //Ejecutamos la consulta:
            if ($this->db->execute()) {
                return 2;
            } else {
                $this->db->query("DELETE FROM tipo_producto WHERE user_id=:id");
                $this->db->bind(':id', $datos['IdTipoProducto']);
                if ($this->db->execute()) {
                    return 2;
                } else {
                    return 1;
                }
            }
        } else {
            //No se puede eliminar el usuario administrador
            return 3;
        }
    }

}