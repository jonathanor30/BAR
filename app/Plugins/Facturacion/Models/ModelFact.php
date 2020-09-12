<?php

/**
 * 
 * 
 * @author PlenusServices
 */
//Iniciamos modelo cliente
class ModelFact
{
	public $db;
	public function __construct()
	{
		$this->db = new Base;
	}

	public function showTables()
	{
		$this->db->query('SHOW TABLES');
		$this->db->execute();
		//Retornamos valor
		return $this->db->registrosrow();
	}

	public function Enablesystem($data)
	{
		$this->db->query("UPDATE facturacion_electronica SET enabled={$data['status']} WHERE id_config=1");
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Metodo eliminar global de proveedores
	 * @access public
	 * @param = $id
	 * id de los datos a eliminar
	 * @param = $table
	 * Tabla a eliminar datos
	 * @param = $key
	 * LLave primaria o id de registros
	 * @return bool
	 */
	public function Delete($id, $table, $key)
	{
		if ($id != "") //si id en array datos es didtinto a nulo
		{
			//Preparamos consulta:
			$this->db->query("DELETE FROM $table WHERE $key=:$key"); //query borrar de tabla
			//Vinculamos valores:
			$this->db->bind(":" . $key, $id);
			//Ejecutamos la consulta:
			if ($this->db->execute()) {
				return false;
			} else //sino {
			{
				return true;
			}
		}
	}

	public function GetResolution(int $id)
	{
		$this->db->query("SELECT * FROM resolutions WHERE id={$id}");
		$this->result = (array) $this->db->registro();
		if ($this->result) {
			return $this->db->registro();
		} else {
			return false;
		}
	}

	public function Save(array $datos, string $table)
	{
		return $this->db->Create($datos, $table);
	}

	public function Update($datos, $tabla, $campo, $id)
	{
		return $this->db->Update($datos, $tabla, $campo, $id);
	}

	/**
	 * Trae lo ultimo guardado
	 * @access public
	 * @param = $tabla
	 * Tabla de la que se traen los datos
	 * @param = $campo
	 * Campo a ordenar los datos de manera descendiente
	 * @return object
	 */
	public function LastResolution(string $tabla, string $campo = null, string $typed = null)
	{
		if ($campo == null || $typed == null) {
			return false;
		} else {
			$this->db->query("SELECT * FROM {$tabla} WHERE type='{$typed}' ORDER BY {$campo}  DESC LIMIT 0,1");
			$this->result = $this->db->registro();
			if ($this->result != null) {
				return $this->result;
			} else {
				return false;
			}
		}
	}
	/**
	 * Método para numeración de facturación
	 * @access public
	 * @param string $tabla
	 * @param string $campo
	 * @return int
	 * 
	 */
	public function NumberRes(string $tabla, string $campo, string $type)
	{
		if ($this->Count($tabla) > 0) {
			$this->result = $this->LastResolution($tabla, $campo, $type);
			return $this->result->number + 1;
		} else {
			return 1;
		}
	}
	/**
	 * Metodo para obtener conteo de registros de una tabla
	 * @access public
	 * @param string $tabla
	 * @return int
	 */
	public function Count($tabla)
	{
		$this->db->query("SELECT count(*) FROM $tabla");
		$val = $this->db->fetchColumn();
		return $val;
	}

	public function SetStatus(string $type)
	{
		$this->db->query("UPDATE resolutions SET status=2 WHERE status=1 AND type='{$type}'");
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}

	public function GetRegister(string $tabla, string $campo,  int $id)
	{
		$this->db->query("SELECT * FROM {$tabla} WHERE {$campo}=:{$campo}");
		$this->db->bind(":" . $campo, $id);
		if ($this->db->registro() != null) {
			return $this->db->registro();
		} else {
			return false;
		}
	}
}
