<?php

use Mini\Models\Log;
use Mini\Lib\Helper;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Usuario extends Base
{
    private $db; //Manejador de la base de datos
    private $comprobator; //Comprobador de elementos
    private $comprobator2; //Comprobador de elementos
    private $result; //

    public function __construct()
    {
        //Instanciando la clase asistente de la base de datos llamada Base
        $this->db = new Base;
    }

    
    //Obtener todo el listado de usuarios de la base de datos
    public function obtenerUsuarios()
    {
        //Asi se hace una consulta SQL, llamando el metodo query
        $this->db->query("SELECT * FROM users");

        //Instancia del metodo registros, que retorna el resultado del query
        return $this->db->registros();
    }

    public function ObtenerUno(string $campo = '', $id = null)
    {

        $this->db->query("SELECT * FROM home WHERE {$campo}=:id");

        $this->db->bind(":id", $id);
        return $this->db->registro();
    }

    //Obtener toda la incormación de x u
    public function obtenerUsuario($id, string $campo = null)
    {
        if ($campo != null) {
            $this->db->query("SELECT * FROM users WHERE $campo=:$campo");
            //Vinculamos el valor del id
            $this->db->bind(':' . $campo, $id);
            //Ejecutamos la consulta
            $this->db->execute();
            return $this->db->registro();
        } else {
            //preparamos consulta con el filtro id_vehiculo
            $this->db->query("SELECT * FROM users WHERE user_id=:id");
            //Vinculamos el valor del id
            $this->db->bind(':id', $id);
            //Ejecutamos la consulta
            $this->db->execute();
            return $this->db->registro();
        }
        //Instancia del metodo registro, que retorna el resultado del query
    }

    public function Obtenerdatos($datos)
    {
        $datos = $this->db->query("SELECT * FROM home WHERE IdHome=1");
        return $this->db->registros();

        return $datos;
    }


    

    //Método para Insertar nuevo vehiculo a la base de datos
    public function agregarUsuario($datos = [])
    {
        $this->comprobator = $this->comprobarUsuario($datos['user_name']);
        $this->comprobator2 = $this->comprobarCorreo($datos['user_email']);
        $this->comprobator3 = $this->comprobardocumento($datos['Numero_Documento']);

        if ($this->comprobator3 == true) {
            return 5;
            exit();
        }

        if ($this->comprobator == true) {
            return 3;
            exit();
        } else {
            if ($this->comprobator2 == true) {
                //El usuario ya existe
                return 4;
            } else {
                $this->db->query('INSERT INTO users (user_type, firstname, lastname, user_name, user_password_hash, user_email, estado_usuario, date_added, IdTipoDocumento, Numero_Documento) VALUES(:user_type, :firstname, :lastname, :user_name, :user_password_hash, :user_email, :user_status , :date_added, :IdTipoDocumento, :Numero_Documento)');

                //Vincular valores
                /*
            $this->db->bind(':user_type', $datos['user_type']);
            $this->db->bind(':firstname', $datos['firstname']);
            $this->db->bind(':lastname', $datos['lastname']);
            $this->db->bind(':user_name', $datos['user_name']);
            $this->db->bind(':user_password_hash', $datos['user_password_hash']);
            $this->db->bind(':user_email', $datos['user_email']);
            $this->db->bind(':user_vigencia', $datos['user_vigencia']);
            $this->db->bind(':user_status', $datos['user_status']);
            $this->db->bind(':date_added', $datos['date_added']);
            $this->db->bind(':IdTipoDocumento', $datos['IdTipoDocumento']);
            $this->db->bind(':Numero_Documento', $datos['Numero_Documento']);
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
    }
    //Método para Insertar nuevo vehiculo a la base de datos
    public function editarUsuario($datos = [])
    {

        $this->comprobator = $this->comprobarUsuario2($datos['user_name'],$datos['Numero_Documento']);
        $this->comprobator2 = $this->comprobarCorreo2($datos['user_email'],$datos['Numero_Documento']);

    
        if(strlen($datos['user_password_hash']) <= 7)
        { 
        return 7;
        exit();
        }
        if(strlen($datos['user_name']) <=5 )
        {
            return 8;
            exit();
        }
    
        if($this->comprobator == true)
        {
            return 3;
            exit();
        }else{
        if ($this->comprobator2 == true) {
            //El usuario ya existe
            return 4;
        } else {
            $this->db->query('UPDATE users SET user_type=:user_type, firstname=:firstname, lastname=:lastname, user_name=:user_name, user_password_hash=:user_password_hash, user_email=:user_email, estado_usuario=:user_status WHERE user_id=:user_id');

            //Vincular valores
            $this->db->bind(':user_id', $datos['user_id']);
            $this->db->bind(':user_type', $datos['user_type']);
            $this->db->bind(':firstname', $datos['firstname']);
            $this->db->bind(':lastname', $datos['lastname']);
            $this->db->bind(':user_name', $datos['user_name']);
            $this->db->bind(':user_password_hash', $datos['user_password_hash']);
            $this->db->bind(':user_email', $datos['user_email']);
            $this->db->bind(':user_status', $datos['user_status']);
           
    
     
    
            //Ejecutar consulta
            if ($this->db->execute()) {
                return 2;
            } else {
    
                return 1;
            }
        }
    }
    }

    public function editarUsuario2($datos = [])
    {

        $this->db->query('UPDATE users SET estado_usuario=:user_status  WHERE user_id=:user_id');

        //Vincular valores
        $this->db->bind(':user_id', $datos['user_id']);      
        $this->db->bind(':user_status', $datos['user_status']);
 
        //Ejecutar consulta
        if ($this->db->execute()) {
            return 2;
        } else {

            return 1;
        }
    }
    //Método para eliminar usuario del sistema
    public function borrarUsuario($datos = [])
    {
        if ($datos['user_id'] != 1) {
            //Preparamos consulta:
            $this->db->query('DELETE FROM users WHERE user_id=:id');
            //Vinculamos valores:
            $this->db->bind(':id', $datos['user_id']);
            //Ejecutamos la consulta:
            if ($this->db->execute()) {
                return 2;
            } else {
                $this->db->query("DELETE FROM modulos_asignados WHERE user_id=:id");
                $this->db->bind(':id', $datos['user_id']);
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

    public function comprobarUsuario($usuario)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($usuario) && !empty($usuario)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM users WHERE user_name=:usuario");
            //Vinculamos consulta
            $this->db->bind(':usuario', $usuario);
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
    public function comprobarCorreo($correo)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($correo) && !empty($correo)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM users WHERE user_email=:correo");
            //Vinculamos consulta
            $this->db->bind(':correo', $correo);
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

    public function comprobardocumento($cc)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($cc) && !empty($cc)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM users WHERE Numero_Documento=:cc");
            //Vinculamos consulta
            $this->db->bind(':cc', $cc);
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

    public function comprobarUsuario2($usuario,$documento)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($usuario) && !empty($usuario)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM users WHERE Numero_Documento !=:documento AND user_name=:usuario");
            //Vinculamos consulta
            $this->db->bind(':usuario', $usuario);
            $this->db->bind(':documento', $documento);
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

    public function comprobarCorreo2($correo,$documento)
    {
        //verificamos que exista y no este vacio el campo placa vehiculo
        if (isset($correo) && !empty($correo)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM users WHERE Numero_Documento !=:documento AND user_email=:correo");
            //Vinculamos consulta
            $this->db->bind(':correo', $correo);
            $this->db->bind(':documento', $documento);
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



    public function autocompletarUsuarios($datos = [])
    {
        //Query con todos los privilegios
        $this->db->query("SELECT * FROM users WHERE user_name LIKE '%" . $datos['term'] . "%' LIMIT 0 ,50");
        $this->db->execute();
        //Retornamos valor
        return $this->db->registrosrow();
    }




    //Método para obtener Módulos de usuario
    public function obtenerModulos($id)
    {
        $this->db->query('SELECT * FROM modulos_asignados WHERE user_id=:id');
        $this->db->bind(':id', $id);
        return $this->db->registros();
    }



    //Método par asignar modulo a usuarios
    public function asignarModulo($datos = [])
    {
        //Preparamos consulta
        $this->db->query('INSERT INTO modulos_asignados (nombre_modulo, user_id, user_id_asignador, date_added) VALUES(:nombre_modulo, :user_id, :user_id_asignador, :date_added)');

        $this->db->bind(':nombre_modulo', $datos["nombre_modulo"]);
        $this->db->bind(':user_id', $datos["user_id"]);
        $this->db->bind(':user_id_asignador', $datos["user_id_asignador"]);
        $this->db->bind(':date_added', date("Y-m-d"));

        //Ejecutar consulta
        if ($this->db->execute()) {
            return 2;
        } else {

            return 1;
        }
    }

    //Método para validar módulos asignados
    public function validarModulo($datos = [])
    {
        $this->db->query('SELECT * FROM modulos_asignados WHERE nombre_modulo=:nombre_modulo AND user_id=:user_id');

        $this->db->bind(':nombre_modulo', $datos['nombre_modulo']);
        $this->db->bind(':user_id', $datos['user_id']);

        $this->result = $this->db->registros();

        foreach ($this->result as $key => $index) {

            if ($index->nombre_modulo === $datos['nombre_modulo']) {
                //Existe
                return true;
            } else {
                //No existe
                return false;
            }
        }
    }
    //Método para eliminar módulos asignados
    public function eliminarModulo($datos = [])
    {
        $this->db->query('DELETE FROM modulos_asignados WHERE nombre_modulo=:nombre_modulo AND user_id=:id');
        $this->db->bind(':nombre_modulo', $datos['nombre_modulo']);
        $this->db->bind(':id', $datos['user_id']);
        //Ejecutamos la consulta:
        if ($this->db->execute()) {
            return false;
        } else {
            return true;
        }
    }

    public function getUserWithEmail1($p_correoElectronico)
    {

        if (isset($p_correoElectronico) && !empty($p_correoElectronico)) {

            //preparamos consulta
            $this->db->query("SELECT * FROM users WHERE user_email=:correo");
            //Vinculamos consulta
            $this->db->bind(':correo', $p_correoElectronico);
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

    public function recoverPassword($p_correoElectronico)
    {

        $sql = "UPDATE users  WHERE user_email = :p_correoElectronico";
        $parameters = array(
            ':p_correoElectronico' => $p_correoElectronico
        );

        try {

            $query = $this->db->query($sql);
            return $this->execute($parameters);
        } catch (PDOException $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'Usuario', $e->getCode(), $e->getMessage());
            return false;
        } catch (Exception $e) {

            $logModel = new Log();
            $sql = Helper::debugPDO($sql, $parameters);
            $logModel->addLog($sql, 'Usuario', $e->getCode(), $e->getMessage());
            return false;
        }
    }


    public function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }


    public function sendMail($mailer)
    {

        $token = $this->generateRandomString(8);
        $horavencimiento = date("Y-m-d H:i:s", strtotime('+20 minutes'));
        $this->db->query("UPDATE users SET token=:token, fecha_expiracion=:fecha_expiracion WHERE user_email=:correo");
        $this->db->bind(':token', $token);
        $this->db->bind(':fecha_expiracion', $horavencimiento);
        $this->db->bind(':correo', $mailer);
        $this->db->execute();

        $template = file_get_contents(RUTA_APP . '/Views/Login/template.php');
        $template = str_replace("{{year}}", date('Y'), $template);
        $template = str_replace("{{action_url_1}}", 'http://localhost/Bar70/Login/password/?token=' . $token . '', $template);
        $template = str_replace("{{operating_system}}", Helper::getOS(), $template);
        $template = str_replace("{{browser_name}}", Helper::getBrowser(), $template);

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";


        $mail->isSMTP();
        $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'pruebasproyecto1907@gmail.com';   //username
        $mail->Password = '123456789+4';   //password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;                    //smtp port

        $correo = "brayitan2018@hotmail.com";
        $mail->setFrom('pruebasproyecto1907@gmail.com', 'Bar la 70');
        $mail->addAddress($mailer);

        $mail->isHTML(true);

        $mail->Subject = 'Recuperación de contraseña - Bar70';
        $mail->Body    = $template;

        if (!$mail->send()) {
            return 2;
        } else {
            return 1;
        }
    }

    public function recuperarpass($datos = [])
    {

        $comprobator = $this->getUserWithEmail1($datos['txtCorreoElectronico']);
        if ($comprobator == false) {
            return 2;
            exit();
        } else {
            $check = $this->sendMail($datos['txtCorreoElectronico']);
            if ($check == 1) {
                return 1;
            } else {
                return 3;
            }
        }
    }

    public function validarfecha($token)
    {
        $this->db->query("SELECT * FROM users WHERE token=:token");
        $this->db->bind(":token", $token);
        return $this->db->registro();
    }

    public function cambiarcontraseña($datos = [])
    {
        if ($datos['txtContrasena'] != $datos['txtRepetirContrasena']) {
            return 2;
            exit();
        }
        if (!preg_match('`[A-Z]`', $datos['txtContrasena'])) {
            return 3;
            exit();
        }
        if (!preg_match('`[0-9]`', $datos['txtContrasena'])) {
            return 3;
            exit();
        }
        if (strlen($datos['txtContrasena']) < 8) {
            return 4;
            exit();
        }
        $user_password = $datos['txtContrasena'];
        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
        $fecha = date("Y-m-d H:i:s");
        $this->db->query("UPDATE users SET user_password_hash=:user_password_hash,fecha_expiracion=:fecha WHERE token=:token");
        $this->db->bind(":user_password_hash",$user_password_hash);
        $this->db->bind(":fecha",$fecha);
        $this->db->bind(":token",$datos['token']);
        
        if ($this->db->execute()) {
            return 5;
        } else {
            return 1;
        }
    }

    public function autovalidacion($token)
    {
        $this->db->query("SELECT token FROM users WHERE token=:token");
        $this->db->bind(':token', $token);
        $this->db->execute();
        $this->result = $this->db->rowCount();

        $resultado = $this->validarfecha($token);
        if ($this->result == 1) {

            $fecha = date("Y-m-d H:i:s");
            if ($fecha >= $resultado->fecha_expiracion) {
                return 3;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }
}
