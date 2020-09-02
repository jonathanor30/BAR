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
     //Método para eliminar usuario del sistema
     public function actualizarProducto($datos = [])
     {
         
             //Preparamos consulta:
             if($datos['Estado_P'] != 1){
             $this->db->query('UPDATE producto SET Estado_P= 1 WHERE IdProducto=:id');
            }
            if($datos['Estado_P'] != 2)
            {
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
