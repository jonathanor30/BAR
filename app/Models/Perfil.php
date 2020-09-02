<?php

/**
 *
 */

class Perfil
{
    private $db;
    public function __construct()
    {
        $this->db = new Base;
    }

    public function obtenerPerfil()
    {
        //Preparamos consulta SQL
        $this->db->query("SELECT * FROM perfil WHERE id_perfil='1'");
        return $this->db->registro();
    }

    public function editarPerfil($datos)
    {
        //Preparacion de consulta SQL
        $this->db->query('UPDATE perfil SET nombre_empresa=:nombre_empresa, direccion_territorial=:direccion_territorial, resolucion_empresa=:resolucion_empresa, numero_habilitacion=:numero_habilitacion, telefono=:telefono, email=:email,  email_alerta=:email_alerta, id_telegram=:id_telegram, servidor_verificacion=:servidor_verificacion,moneda=:favcolor, direccion=:direccion, ciudad=:ciudad, nit_empresa=:nit_empresa, representante_legal=:representante_legal, estado=:estado, nombre_banco=:nombre_banco, tipo_cuenta=:tipo_cuenta, numero_cuenta=:numero_cuenta  WHERE id_perfil=:id_perfil');
        //Vincular valores a la consulta
        $this->db->bind(':nombre_empresa', $datos['nombre_empresa']);
        $this->db->bind(':favcolor', $datos['favcolor']);
        $this->db->bind(':direccion_territorial', $datos['direccion_territorial']);
        $this->db->bind(':resolucion_empresa', $datos['resolucion_empresa']);
        $this->db->bind(':numero_habilitacion', $datos['numero_habilitacion']);
        $this->db->bind(':telefono', $datos['telefono']);
        $this->db->bind(':email', $datos['email']);
        $this->db->bind(':email_alerta', $datos['email_alerta']);
        $this->db->bind(':id_telegram', $datos['id_telegram']);
        $this->db->bind(':servidor_verificacion', $datos['servidor_verificacion']);
        $this->db->bind(':direccion', $datos['direccion']);
        $this->db->bind(':ciudad', $datos['ciudad']);
        $this->db->bind(':nit_empresa', $datos['nit_empresa']);
        $this->db->bind(':representante_legal', $datos['representante_legal']);
        $this->db->bind(':estado', $datos['estado']);
        $this->db->bind(':nombre_banco', $datos['nombre_banco']);
        $this->db->bind(':tipo_cuenta', $datos['tipo_cuenta']);
        $this->db->bind(':numero_cuenta', $datos['numero_cuenta']);
        $this->db->bind(':id_perfil', $datos['id_perfil']);

        //Ejecutar consulta
        if ($this->db->execute()) {
            return 2;
        } else {

            return 1;
        }
    }

    public function subirImagen($datos)
    {
        $this->db->query("UPDATE perfil SET logo_url=:foto_update WHERE id_perfil='1'");
        $this->db->bind(':foto_update', $datos['foto_update']);

        if ($this->db->execute()) {
            return 2;
        } else {
            return 1;
        }
    }

    //Método para actualizar firma
    public function firma($datos)
    {
        //Sentencia SQL
        $this->db->query("UPDATE perfil SET firma=:foto_update WHERE id_perfil='1'");
        //vincular valores
        $this->db->bind(':foto_update', $datos['foto']);
        //Ejeción
        if ($this->db->execute()) {
            return false;
        } else {
            return true;
        }
    }

    //Método para conocer el tamaño de la base de datos
    public function infoDB()
    {
        $this->db->query('SHOW TABLE STATUS');
        $this->db->execute();
        //Retornamos valor
        return $this->db->registrosrow();
    }

    //Método para configurar servidor de correo SMTP
    public function configEmail($datos)
    {
        //Preparar consulta
        $this->db->query("UPDATE perfil SET hostEmail=:host, userEmail=:user, passwordEmail=:password WHERE id_perfil='1'");
        //Vincular valores
        $this->db->bind(':host', $datos['server']);
        $this->db->bind(':user', $datos['usuario']);
        $this->db->bind(':password', $datos['password']);

        //Ejeción
        if ($this->db->execute()) {
            return false;
        } else {
            return true;
        }
    }
}
