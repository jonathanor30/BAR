<?php 

class Producto
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
        $this->db->query("SELECT * FROM producto");
        return $this->db->registrosrow();
      
    }

    public function ObtenerUno(string $campo = '', $id = null )
    {
        $this->db->query("SELECT * FROM producto WHERE {$campo}=:id");
        $this->db->bind(":id", $id);
        return $this->db->registro();

    }

}
