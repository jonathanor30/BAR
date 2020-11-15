<?php

/**

 */
class Sesion
{
    private $db; //Manejador de la base de datos
    private $comprobator; //Comprobador de elementos
    private $comprobator1; //Comprobador de elementos
    private $result; //

    public function __construct()
    {
        //Instanciando la clase asistente de la base de datos llamada Base
        $this->db = new Base();
    }

    /**
     * Método loginData()
     * se encarga de recibir datos enviados desde el formulario de login
     * @access public
     * @param array $datos
     * @return numbers 1=>2=>3
     */
    public function loginData($datos)
    {
        //Comprobación de usuario
        $this->comprobator = $this->issetUser($datos['usuario']);
        if ($this->comprobator == true) {

            //Comprobador de contraseña
            $this->comprobator1 = $this->passwordOk($datos['usuario'], $datos['contrasena']);

            if ($this->comprobator1 == true) {
                //Usuario y contraseña coinciden
                return 1;
            } else {
                //Contraseña incorrecta
                return 3;
            }
        } else {
            //No existe el usuario
            return 2;
        }
    }

    /**
     * Método issetUser()
     * se encarga de validar usuario
     * @access public
     * @param array $datos
     * @return true OR false
     */
    public function issetUser($user)
    {
        if (isset($user) && !empty($user)) {
            //preparamos consulta
            $this->db->query("SELECT * FROM users WHERE user_name=:user");
            //Vinculamos consulta
            $this->db->bind(':user', $user);
            $this->db->execute();
            $this->result = $this->db->rowCount();
            if ($this->result === 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Método passwordOk()
     * se encarga de validar contraseña enviada desde el formulario login
     * @access public
     * @param array $datos
     * @return true OR false
     */
    public function passwordOk($user, $password)
    {
        //preparamos consulta
        $this->db->query('SELECT user_id, user_name, user_email, user_password_hash FROM users WHERE user_name=:user');
        //Vinculamos consulta
        $this->db->bind(':user', $user);
        $this->db->execute();
        $this->result = $this->db->registro();
        //Verificamos que el password ingresado en el formulario sea el mismo almacenado en la base de datos
        if (password_verify($password, $this->result->user_password_hash)) {

            return true;
        } else {
            return false;
        }
    }
    /**
     * Método obtenerUsuario()
     * se encarga de obtener información del usuario.
     * @access public
     * @param array $datos
     * @return registros
     */
    public function obtenerUsuario($user_name)
    {

        //Asi se hace una consulta SQL, llamando el metodo query
        $this->db->query('SELECT * FROM users WHERE user_name=:user');

        //Vinculamos consulta
        $this->db->bind(':user', $user_name);

        $this->db->execute();
        //Instancia del metodo registros, que retorna el resultado del query
        return $this->db->registro();
    }
    /**
     * Metodo para bloquear usuarios
     * @access public
     * @param = $id
     * @return bool
     * 
     */
    public function LockUser($id)
    {
        $user = $this->obtenerUsuarioId($id);
        if ($user->estado_usuario != 0) {
            $this->db->query("UPDATE users SET estado_usuario=:estado WHERE user_id=:user_id");
            $this->db->bind(':estado', 0);
            $this->db->bind(':user_id', $id);
            if ($this->db->execute()) {
                return false;
            } else {
                return true;
            }
        }else{
            return true;
        }
    }
    //Obtener toda la incormación de x vehiculo
    public function obtenerUsuarioId($id)
    {
        //preparamos consulta con el filtro id_vehiculo
        $this->db->query("SELECT * FROM users WHERE user_id=:id");
        //Vinculamos el valor del id
        $this->db->bind(':id', $id);
        //Ejecutamos la consulta
        $this->db->execute();

        //Instancia del metodo registro, que retorna el resultado del query
        return $this->db->registro();
    }
}
