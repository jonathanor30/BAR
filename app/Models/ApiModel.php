<?php
class ApiModel
{
    private $db;
    private $where;
    private $order_by;
    private $table;
    public $result;
    public $db_tables;
    public $table_colums;
    public $colums;
    public $counter;
    public $id;


    public function __construct()
    {
        $this->db = new Base;
    }

    public function GET_ALL($datos = array())
    {
        $this->where = $datos['where'] ?? '';
        $this->order_by = $datos['order_by'] ?? '';
        $this->table = $datos['table'] ?? null;
        if ($this->table != null) :
            $this->db->query("SELECT * FROM {$datos['table']} {$this->where} {$this->order_by}");
            return $this->db->registrosrow();
        else :
            return false;
        endif;
    }

    public function GET_ONE($datos = [])
    {
        $this->where = $datos['where'] ?? '';
        $this->order_by = $datos['order_by'] ?? '';
        $this->table = $datos['table'] ?? null;
        if ($this->table != null) :
            $this->db->query("SELECT * FROM {$datos['table']} {$this->where} {$this->order_by}");
            return $this->db->registrosrow();
        else :
            return false;
        endif;
    }


    public function POST($datos = [])
    {
        //Manejador de errores
        try {
            //Verificar si existe una llave unica para evitar redundancia 
            if (isset($datos[$this->getKeys($datos['table'])[0]])) {
                //Comprobar si ya existe un registro con la misma llave unica
                if (!$this->Isset(array(
                    'table' => $datos['table'],
                    'key'   => $this->getKeys($datos['table'])[0],
                    'id'    => $datos[$this->getKeys($datos['table'])[0]]

                ))) {
                    //Si no existe crea el registro
                    $this->colums = $this->getColumns($datos['table'], true);
                    $this->db->query("INSERT INTO {$datos['table']} (" . join(',', $this->getColumns($datos['table'])) . ") VALUES(" . join(',', $this->getColumns($datos['table'], true)) . ")");

                    //set Array $datos
                    foreach ($datos as $keyDatos => $valueDatos) {
                        if ($keyDatos == 'table' || $keyDatos == 'api_key') {
                            unset($datos[$keyDatos]);
                        }
                    }
                    //Vinculación de valores dinamico
                    foreach ($datos as $key => $value) {
                        $this->db->bind(":{$key}", $value);
                    }


                    //Ejecutar consulta
                    if ($this->db->execute()) {
                        return array("message" => "Hubo un error al crear el registro, intente de nuevo");
                    } else {
                        return "success";
                    }
                } else {
                    return array("message" => "Ya existe un registro con la misma llave unica");
                }
            } else {
                return array("message" => "La tabla " . $datos['table'] . " no tiene mecanismo de llave unica");
            }
        } catch (Throwable $e) {
            return array("message" => $e->getMessage());
        }
    }

    public function PUT($datos = [])
    {   //Manejador de errores
        try {



            $test = array(
                'table' => $datos['table'],
                'key'   => $this->getKeys($datos['table'])[0],
                'id'    => $datos[$this->getKeys($datos['table'])[0]]

            );
            //Si no existe editar el registro
            $this->colums = array();
            //preparamos las columnas del UPDATE
            foreach ($datos as $key => $value) {
                if ($key == 'table' || $key == 'api_key' || $key == $this->getPrimaryKey($datos['table'])) {
                } else {
                    array_push($this->colums, $key);
                }
            }

            //Rescatar la llave unica
            $this->id = $datos[$this->getPrimaryKey($datos['table'])];
            $this->table = $datos['table'];
            //Unset Array $datos
            foreach ($datos as $keyDatos => $valueDatos) {
                if ($keyDatos == 'table' || $keyDatos == 'api_key' || $keyDatos == $this->getPrimaryKey($datos['table'])) {
                    unset($datos[$keyDatos]);
                }
            }
            //Seteamos las columnas del update
            $this->table_colums = array();
            foreach ($this->colums as $key) {
                array_push($this->table_colums, $key . '=:' . $key);
            }

            //Preparamos query
            $this->db->query("UPDATE {$this->table} SET " . join(",", $this->table_colums) . " WHERE {$this->getPrimaryKey($this->table)}=:id");



            //Vinculación de valores de manera dinamica
            foreach ($datos as $key => $value) {

                $this->db->bind(":{$key}", $value);
            }
            //vinculación del valor para la llave primaria
            $this->db->bind(':id', $this->id);


            //Ejecutar consulta
            if ($this->db->execute()) {
                return array("message" => "Hubo un error al editar el registro, intente de nuevo");
            } else {
                return "success";
                //return array("message" => $this->table_colums);
            }
        } catch (Throwable $e) {

            return array("message" => $e->getMessage());
        }
    }

    public function DELETE($datos = [])
    {
        try {
            //Preparamos consulta
            $this->db->query("DELETE FROM {$datos['table']} WHERE {$this->getPrimaryKey($datos['table'])}=:id");
            //vinculamos valo
            $this->db->bind(':id', $datos['id']);
            //Ejecutamos la consulta:
            if ($this->db->execute()) {
                return false;
            } else {
                return "success";
            }
        } catch (Throwable $e) {
            return array("message" => $e->getMessage());
        }
    }

    public function getColumns($table, $enrich = false, $required = false)
    {
        if ($required != false) {
            $this->db->query("SHOW COLUMNS FROM {$table}");
        } else {
            $this->db->query("SHOW COLUMNS FROM {$table} WHERE `Null` != 'YES'");
        }
        $this->result = $this->db->registrosrow();
        $this->table_colums = array();

        foreach ($this->result as $key => $value) {
            if ($this->getPrimaryKey($table) != $value['Field']) {
                if ($enrich != false) {
                    array_push($this->table_colums, ':' . $value['Field']);
                } else {
                    array_push($this->table_colums, $value['Field']);
                }
            }
        }

        return $this->table_colums;
    }

    public function scheme()
    {
        $this->db->query('SHOW TABLES');
        $this->result =  $this->db->registrosrow();

        $this->table = array();
        $this->db_tables = 'Tables_in_' . DB_NAME;
        foreach ($this->result as $key => $value) {
            array_push($this->table, $value[$this->db_tables]);
        }

        return $this->table;
    }

    public function getPrimaryKey($table)
    {
        $this->db->query("SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'");

        $this->result = $this->db->registro();
        return $this->result->Column_name;
    }

    public function getRequired($datos = [])
    {

        $this->counter = 0;
        foreach ($this->scheme() as $key => $value) {
            if ($value == $datos['table']) {
                $this->counter++;
            }
        }
        if ($this->counter > 0) {
            return $this->getColumns($datos['table']);
        } else {
            return false;
        }
    }

    public function getKeys($table)
    {
        $this->db->query("SHOW KEYS FROM {$table}");
        $this->result = $this->db->registros();

        $this->colums = array();

        foreach ($this->result as $key => $value) {
            if ($this->getPrimaryKey($table) != $value->Column_name) {
                array_push($this->colums, $value->Column_name);
            }
        }

        return $this->colums;
    }

    public function Isset($datos = [])
    {
        //preparamos consulta
        $this->db->query("SELECT * FROM {$datos['table']} WHERE {$datos['key']}=:id");
        //Vinculamos consulta
        $this->db->bind(':id', $datos['id']);
        $this->db->execute();
        $this->result = $this->db->rowCount();
        if ($this->result == 1) {
            return true;
        } else {
            return false;
        }
    }
}
