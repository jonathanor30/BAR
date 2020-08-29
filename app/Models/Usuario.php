<?php

/**
 * This file is part of Elephant Framework
 * Copyright (C) 2018-2019 Juan Bautista <soyjuanbautista0@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * Vehicle model to manage driver's inquiries Vehicles
 *
 * @author Juan Bautista <soyjuanbautista0@gmail.com>
 */
class Usuario
{
    private $db; //Manejador de la base de datos
    private $comprobator; //Comprobador de elementos
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
    //Método para Insertar nuevo vehiculo a la base de datos
    public function agregarUsuario($datos = [])
    {
        $this->comprobator = $this->comprobarUsuario($datos['user_name']);
        if ($this->comprobator == true) {
            //El usuario ya existe
            return 3;
        } else {
            $this->db->query('INSERT INTO users (user_type, firstname, lastname, user_name, user_password_hash, user_email, vigencia, estado_usuario, date_added) VALUES(:user_type, :firstname, :lastname, :user_name, :user_password_hash, :user_email,:user_vigencia, :user_status , :date_added)');

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
    //Método para Insertar nuevo vehiculo a la base de datos
    public function editarUsuario($datos = [])
    {

        $this->db->query('UPDATE users SET user_type=:user_type, firstname=:firstname, lastname=:lastname, user_name=:user_name, user_password_hash=:user_password_hash, user_email=:user_email, vigencia=:user_vigencia, estado_usuario=:user_status, telegram_id=:telegram_id, telegram_verification=:telegram_verification, email_verification=:email_verification   WHERE user_id=:user_id');

        //Vincular valores
        $this->db->bind(':user_id', $datos['user_id']);
        $this->db->bind(':user_type', $datos['user_type']);
        $this->db->bind(':firstname', $datos['firstname']);
        $this->db->bind(':lastname', $datos['lastname']);
        $this->db->bind(':user_name', $datos['user_name']);
        $this->db->bind(':user_password_hash', $datos['user_password_hash']);
        $this->db->bind(':user_email', $datos['user_email']);
        $this->db->bind(':user_vigencia', $datos['user_vigencia']);
        $this->db->bind(':user_status', $datos['user_status']);
        $this->db->bind(':telegram_id', $datos['telegram_id']);
        $this->db->bind(':telegram_verification', $datos['verification']);
        $this->db->bind(':email_verification', $datos['em_verification']);

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
    //Generar ficha técnica
    public function ficha($id)
    {
        if (isset($id) && !empty($id)) {
            //Preparamos consulta
            $this->db->query('SELECT * FROM users where id_vehiculo=:id');
            //Vinculamos valores
            $this->db->bind(':id', $id);
            //Ejecutamos consulta
            $this->db->execute();
            //Obtener registros
            $this->db->registro();
        } else {
            return false;
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

    //Método para eliminar contrato asignado a Usuario
    public function eliminarContrato($datos = [])
    {
        //Se prepara la consulta SQL
        $this->db->query('DELETE FROM contratos_asignados WHERE id_contrato_asignado=:id');
        //Ejecutamos consulta
        $this->db->bind(':id', $datos['id']);

        if ($this->db->execute()) {
            return 2;
        } else {
            return 1;
        }
    }

    //Método para asignar contratos
    public function asignarContrato($datos = [])
    {
        //Se prepara la consulta SQL
        $this->db->query('INSERT INTO contratos_asignados (id_contrato, numero_contrato, usuario_asignado, user_id, fecha_inicial, fecha_final, objeto_contrato, nit_contratante, contratante, nit_responsable, responsable, telefono_responsable, direccion_responsable, estado_contrato, date_added) VALUES(:id_contrato,:numero_contrato,:usuario_asignado,:user_id,:fecha_inicial,:fecha_final,:objeto_contrato,:nit_contratante,:contratante,:nit_responsable,:responsable,:telefono_responsable,:direccion_responsable,:estado_contrato,:date_added)');
        //Vincular valores
        $this->db->bind(':id_contrato', $datos['id_contrato']);
        $this->db->bind(':numero_contrato', $datos['numero_contrato']);
        $this->db->bind(':usuario_asignado', $datos['usuario_asignado']);
        $this->db->bind(':user_id', $datos['user_id']);
        $this->db->bind(':fecha_inicial', $datos['fecha_inicial']);
        $this->db->bind(':fecha_final', $datos['fecha_final']);
        $this->db->bind(':objeto_contrato', $datos['objeto_contrato']);
        $this->db->bind(':nit_contratante', $datos['nit_contratante']);
        $this->db->bind(':contratante', $datos['contratante']);
        $this->db->bind(':nit_responsable', $datos['nit_responsable']);
        $this->db->bind(':responsable', $datos['responsable']);
        $this->db->bind(':telefono_responsable', $datos['telefono_responsable']);
        $this->db->bind(':direccion_responsable', $datos['direccion_responsable']);
        $this->db->bind(':estado_contrato', $datos['estado_contrato']);
        $this->db->bind(':date_added', $datos['date_added']);
        //Ejecutamos consulta
        if ($this->db->execute()) {
            return 2;
        } else {
            return 1;
        }
    }

    //Método para comprobar contrato asignado
    public function comprobarContrato($numero_contrato, $user_id)
    {
        //Preparamos consulta
        $this->db->query('SELECT * FROM contratos_asignados WHERE numero_contrato=:numero_contrato AND user_id=:user_id');
        //Vinculamos valores
        $this->db->bind(':numero_contrato', $numero_contrato);
        $this->db->bind(':user_id', $user_id);
        //Ejecutar consulta
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

    //Método para asignar rutas
    public function asignarRuta($datos = [])
    {
        //Se prepara la consulta SQL
        $this->db->query('INSERT INTO rutas_asignadas (id_ruta, usuario_asignado, user_id, nombre_ruta, descripccion, status_ruta, date_added) VALUES(:id_ruta,:usuario_asignado,:user_id,:nombre_ruta,:descripccion,:status_ruta,:date_added)');
        //Vincular valores
        $this->db->bind(':id_ruta', $datos['id_ruta']);
        $this->db->bind(':usuario_asignado', $datos['usuario_asignado']);
        $this->db->bind(':user_id', $datos['user_id']);
        $this->db->bind(':nombre_ruta', $datos['nombre_ruta']);
        $this->db->bind(':descripccion', $datos['descripccion']);
        $this->db->bind(':status_ruta', $datos['status_ruta']);
        $this->db->bind(':date_added', $datos['date_added']);
        //Ejecutamos consulta
        if ($this->db->execute()) {
            return 2;
        } else {
            return 1;
        }
    }
    //Método para comprobar contrato asignado
    public function comprobarRuta($id_ruta, $user_id)
    {
        //Preparamos consulta
        $this->db->query('SELECT * FROM rutas_asignadas WHERE id_ruta=:id_ruta AND user_id=:user_id');
        //Vinculamos valores
        $this->db->bind(':id_ruta', $id_ruta);
        $this->db->bind(':user_id', $user_id);
        //Ejecutar consulta
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

    //Método para eliminar ruta asignada
    public function borrarRuta($datos = [])
    {
        //Preparamos consulta:
        $this->db->query('DELETE FROM rutas_asignadas WHERE id_ruta_asignada=:id');
        //Vinculamos valores:
        $this->db->bind(':id', $datos['id']);
        //Ejecutamos la consulta:
        if ($this->db->execute()) {
            return 2;
        } else {
            return 1;
        }
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
}
