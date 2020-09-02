<?php

/**
 * This file is part of myGTEP softwware
 * Copyright (C) 2018-2019 Juan Bautista <soyjuanbautista0@gmail.com>
 *
 *This program is not free software, therefore it should not be modified or shared its logic.
 */
/**
 * Class for connection to the framework database
 *
 * @author Juan Bautista <soyjuanbautista0@gmail.com>
 */


class Base
{
    private $dbDriver = DB_DRIVER; //Tipo de motor de base de datos
    private $dbHost   = DB_HOST; //Servidor de bas de datos
    private $dbUser   = DB_USER; //Usuarios de la base de datos
    private $dbName   = DB_NAME; //Nombre de la base de datos
    private $dbPass   = DB_PASS; //Contraseña de la base de datos

    private $dbh;
    private $stmt;
    private $error;
    //Opciones de PDO
    private $options = array(
        PDO::ATTR_PERSISTENT         => true,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_DIRECT_QUERY => true
        //PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\'',

    );
    public $writeLog;
    public $con; //Variable para retornar la conexión a la base de datos

    public function __construct($charset = false)
    {
        //Acá inicia el algoritmo de conexión, con un manejador de errores orientado a objetos
        try {
            //Estructura condicional para evaluar el tipo de driver, para el motor de base de datos a usar
            switch ($this->dbDriver) {
                case 'mssql': // Microsoft Sql Server
                    $this->con = new PDO('mssql:host=' . $this->dbHost . ';dbname=' . $this->dbName . '', $this->dbuser, $this->dbPass, $this->options);
                    break;
                case 'sybase': // Sybase con PDO_DBLIB
                    $this->con = new PDO('sybase:host=' . $this->dbHost . ';dbname=' . $this->dbName . '', $this->dbuser, $this->dbPass, $this->options);
                    break;
                case 'sqlite': // SQLite
                    $this->con = new PDO('sqlite:host=' . $this->dbHost . ';dbname=' . $this->dbName . '', $this->dbuser, $this->dbPass, $this->options);
                    break;
                case 'mysql': // Mysql
                    //UTF8 validation
                    if ($charset != false) {
                        array_push($this->options, "PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''");
                    }

                    $this->con = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName . '', $this->dbUser, $this->dbPass, $this->options);

                    break;
                case 'pgsql': // Postgres SQL
                    $this->con = new PDO('pgsql:host=' . $this->dbHost . ';dbname=' . $this->dbName . '', $this->dbUser, $this->dbPass, $this->options);
                    break;
            }
            //Codificación de las consultas
            if ($charset != false) {
                # code...
            } else {
                $this->con->exec("SET names utf8");
            }

            //Está es la excepcion por si hay un error en la conexión, el cual pasa el mensaje de error a la variable $e y lo imprime mediante la función nativa getMessage()
        } catch (PDOException $e) {

            $this->writeLog = new LogManager(array(
                'tipo'    => 'ERROR',
                'mensaje' => $e->getMessage(),
            ));

            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                  <strong>Error!</strong> " . NOMBRE_APP . " detecto que hay algún problema en la conexión. " . $e->getMessage() . " </div>";
        }
    }

    //Función para preparar consultas SQL
    public function query($sql)
    {
        $this->stmt = $this->con->prepare($sql);
    }

    //Función para vicular valores de la consulta SQL
    public function bind($parametro, $valor, $tipo = null)
    {
        //Verificación del tipo de dato
        if (is_null($tipo)) {
            switch (true) {
                    //Si es de tipo entero
                case is_int($valor):
                    //Sera ratifica que PDO lo tratará como un entero
                    $tipo = PDO::PARAM_INT;
                    break;
                    //Si es de tipo Boleano
                case is_bool($valor):
                    //Sera ratifica que PDO lo tratará como un Boleano
                    $tipo = PDO::PARAM_BOOL;
                    break;
                    //Si es nulo
                case is_null($valor):
                    //Sera ratifica que PDO lo tratará como un null
                    $tipo = PDO::PARAM_NULL;
                    break;
                    //Valor por defecto
                default:
                    $tipo = PDO::PARAM_STR;
                    break;
            }
        }

        $this->stmt->bindValue($parametro, $valor, $tipo);
    }

    /**
     * Create
     * Este método se encarga de guardar un registro
     * de manera dinamica, solo indcando los campos con sus respectivos valores y la tabla
     * @access public
     * @param array $datos
     * La variable datos contiene un array asociativo con los indices
     * correspondites del esquema de la tabla y sus valores
     * @param string $tabla
     * Define el nombre de la tabla a la cual se realizará la consulta de tipo INSERT
     * @return bool
     */
    public function Create(array $datos, string $tabla): bool
    {
        $this->query("INSERT INTO $tabla(" . implode(',', array_keys($datos)) . ") VALUES(:" . implode(',:', array_keys($datos)) . ")");
        foreach ($datos as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        if ($this->execute()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Update
     * Este método se encarga de editar un registro de manera dinamica, solo 
     * indcando los campos con sus respectivos valores y la tabla
     * @access public
     * @param array $datos
     * La variable datos contiene un array asociativo con los indices
     * correspondites del esquema de la tabla y sus valores
     * @param string $tabla
     * Define el nombre de la tabla a la cual se realizará la consulta de tipo UPDATE
     * @param string $campo
     * Campo intenficador de registro
     * @param void $id
     * Dato a buscar (puede ser unico)
     * @return bool
     */
    public function Update(array $datos, string $tabla, string $campo, $id): bool
    {

        $text = '';
        foreach ($datos as $key => $value) {
            $text .= $key . '=:' . $key . ',';
        }
        $text = substr($text, 0, -1);
        $this->query("UPDATE $tabla SET " . strval($text) . " WHERE $campo=:$campo");
        $this->bind(':' . $campo, $id);
        foreach ($datos as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        if ($this->execute()) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * Delete
     * Este método se encarga de eliminar un registro unicamente indicando la tabla
     * y el identifiacor de la misma.
     * @access public
     * @param string $tabla
     * Define el nombre de la tabla a la cual se realizará la consulta de tipo DELETE
     * @param string $key
     * Campo intenficador de registro
     * @param void $id
     * Dato a buscar (puede ser unico)
     */
    public function Delete(string $tabla, string $key, $id)
    {
        //Preparamos consulta:
        $this->query("DELETE FROM $tabla WHERE $key=:$key"); //query borrar de tabla
        //Vinculamos valores:
        $this->bind(':' . $key, $id);
        //Ejecutamos la consulta:
        if ($this->execute()) {
            return false;
        } else {
            return true;
        }
    }
    //Función para ejecutar consultas SQL
    public function execute()
    {
        //Acedemos a la función ejecutar
        $this->stmt->execute();
    }
    //Función para obtener varios registros de las consulta SQL
    public function registrosrow()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->stmt->closeCursor();
    }
    //Función para obtener varios registros de las consulta SQL
    public function registros()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        $this->stmt->closeCursor();
    }

    //Función para btener un solo registro de las consulta SQL
    public function registro()
    {
        $this->execute();

        //return $this->stmt->fetchAll(PDO::FETCH_OBJ)[0];
        return $this->stmt->fetch(PDO::FETCH_OBJ);


        $this->stmt->closeCursor();
    }

    //Función para contar cantidad de filas o  registros con el metodo rowCount de php
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    //Función para contar columnas
    public function columCounter()
    {
        $this->execute();
        return $this->stmt->columnCount();
    }

    public function fetchColumn()
    {
        $this->execute();
        return $this->stmt->fetchColumn();
    }
    public function disconnect()
    {
        $this->stmt = null;
        $this->con = false;
    }
}
