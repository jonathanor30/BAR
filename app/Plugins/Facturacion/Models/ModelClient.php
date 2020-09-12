<?php

/**
 * 
 * 
 * @author PlenusServices
 */
//Iniciamos modelo cliente
class ModelClient
{
	public $db;
	public function __construct()
	{
		$this->db = new Base;
	}
	/**
	 * Metodo para traer listado de paises
	 * @access public
	 * @param = null
	 * @return object
	 */
	public function countries()
	{
		$this->db->query("SELECT * FROM paises");
		if ($this->db->registros() != "") {
			$this->result = $this->db->registros();
			return $this->result;
		} else {
			echo false;
		}
	}

	/**
	 * trae info de un cliente
	 * @access public
	 * @param = $campo
	 * campo de tabla a buscar
	 * @param = $dato
	 * dato a buscar
	 * @return object
	 */
	public function Client($campo, $dato)
	{
		$this->db->query("SELECT * FROM clientes WHERE $campo= :$campo");
		$this->db->bind(':' . $campo, $dato);
		if ($this->db->registro() != "") {
			$this->result = $this->db->registro();
			return $this->result;
		} else {
			return false;
		}
	}

	/**
	 * Metodop ara editar ingresos proveedor
	 * @access public
	 * @param = $datos
	 * @return bool
	 */
	public function EditIn($datos)
	{

		$this->db->query("UPDATE ingresos_clientes SET  divisa=:divisa, importe=:importe, fp=:fp, observaciones=:observaciones WHERE id_ingreso =:id_ingreso");
		$this->db->bind(':divisa', $datos['divisa']);
		$this->db->bind(':importe', $datos['importe']);
		$this->db->bind(':fp', $datos['fp']);
		$this->db->bind(':observaciones', $datos['observaciones']);
		$this->db->bind(':id_ingreso', $datos['id_ingreso']);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * trae las divisas
	 * @access public
	 * @param = null
	 * @return object
	 */
	public function Divisas()
	{
		$this->db->query("SELECT * FROM divisas");
		if ($this->db->registros() != "") {
			$this->result = $this->db->registros();
			return $this->result;
		} else {
			echo false;
		}
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
	public function Last($tabla, $campo = null)
	{
		if ($campo == null) {
			return false;
		} else {
			$this->db->query("SELECT * FROM {$tabla} ORDER BY {$campo}  DESC LIMIT 0,1");
			$this->db->execute();
			$this->result = $this->db->registro();
			if ($this->result != null) {
				return $this->result;
			} else {
				return false;
			}
		}
	}
	//------------------------------------------------------------------------CRUD Cliente
	/**
	 * Metodo para guardar proveedor
	 * @access public
	 * @param array $datos datos del cliente
	 * @return bool
	 */
	public function SaveClient(array $datos = [])
	{

		$this->db->query("INSERT INTO clientes  (cifnif,codcliente,pais,departamento,ciudad,codpostal, direccion,nombre,telefono1,tipoidfiscal, personafisica) VALUES(:cifnif,:codcliente,:pais,:departamento,:ciudad,:codpostal,:direccion,:nombre,:telefono1,:tipoidfiscal,:personafisica)");
		$this->db->bind(':cifnif', $datos['cifnif']);
		$this->db->bind(':codcliente', $datos['codcliente']);
		$this->db->bind(':pais', $datos['country']);
		$this->db->bind(':departamento', $datos['deptocli']);
		$this->db->bind(':ciudad', $datos['citycli']);
		$this->db->bind(':codpostal', $datos['codpcli']);
		$this->db->bind(':direccion', $datos['addrcli']);
		$this->db->bind(':nombre', $datos['nombre']);
		$this->db->bind(':telefono1', $datos['telefono1']);
		$this->db->bind(':tipoidfiscal', $datos['type_id']);
		$this->db->bind(':personafisica', $datos['personafisica']);

		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Metodo para consultar si un cliente posee facturas asociadas
	 * @access public
	 * @param int $id_cliente
	 * @return int
	 */
	public function Asociated($id_cliente)
	{
		$this->db->query("SELECT count(*) FROM facturascli WHERE codcliente=:codcliente");
		$this->db->bind(":codcliente", $id_cliente);
		$val = $this->db->fetchColumn();
		return $val;
	}

	/**
	 * Metodo para editar cliente
	 * @access public
	 * @param = $datos
	 * Array de datos del proveedor
	 * @return bool
	 */
	public function Edit(array $datos, string $table, string $campo, int $id)
	{
		return $this->db->Update($datos, $table, $campo, $id);
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
	//------------------------------------------------------------------------CRUD Cliente

	//-----------------------------------------------------------------------Factura
	/**
	 * Trae info de una factura
	 * @access public
	 * @param = $id
	 * Id de factura
	 * @return object
	 */
	public function Inv($id)
	{
		$this->db->query("SELECT * FROM facturascli WHERE idfactura= :idfactura");
		$this->db->bind(':idfactura', $id);
		if ($this->db->registro() != "") {
			$this->invoice = $this->db->registro();
			$this->db->query("SELECT * FROM lineasfacturascli WHERE idfactura = :idfactura");
			$this->db->bind(':idfactura', $id);
			if ($this->db->registros() != "") {
				$this->data = array($this->invoice, $this->db->registros());
				return $this->data;
			}
		} else {
			return false;
		}
	}

	/**
	 * Metodo para guardar recibos
	 * @access public
	 * @param = $datos
	 * array de datos a guardar
	 * @return bool
	 * @method ajax
	 */
	public function AddIn($datos = array())
	{
		$num1 = $this->Inv($datos['idf'])[0]->numero;
		$num = $this->Number('ingresos_clientes', 'numero');
		$this->db->query("INSERT INTO ingresos_clientes (idfactura,numero,cliente,id_cliente,importe,fp,observaciones,concepto,estado_ingreso,date_added) 
		VALUES (:idfactura,:numero,:cliente,:id_cliente,:importe,:fp,:observaciones,:concepto,:estado_ingreso,:date_added)");
		$this->db->bind(':idfactura', intval($datos['idf']));
		$this->db->bind(':numero', $num);
		$this->db->bind(':cliente', $datos['prov']);
		$this->db->bind(':id_cliente', $datos['codprov']);
		$this->db->bind(':importe', $datos['importe']);
		$this->db->bind(':fp', (intval($datos['fp_recibo']) ?? 1));
		$this->db->bind(':observaciones', 'Abono recibido para la factura No: ' . $num1);
		$this->db->bind(':concepto', (strval($datos['concepto']) ?? null));
		$this->db->bind(':estado_ingreso', 1);
		$this->db->bind(':date_added', date('Y-m-d'));

		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Modelo cambia estados
	 * @access public
	 * @param int $id
	 * Id de proveedor
	 * @param int $state
	 * Estado de proveedor a swichear
	 * @return bool
	 */
	public function State($id, $state)
	{
		$this->db->query("UPDATE clientes SET estado=:estado WHERE id_cliente =:id_cliente");
		$this->db->bind(':estado', $state);
		$this->db->bind(':id_cliente', $id);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Método para importar proveedores desde archivo de excel
	 * @access public
	 * @param array $datos
	 * @return bool
	 */
	public function Import(array $datos): bool
	{
		$cod = $this->getCodCliente();
		$this->db->query("INSERT INTO clientes(nombre, tipoidfiscal, cifnif,codcliente, telefono1, telefono2, email,codpago, coddivisa, regimeniva, personafisica, bancname, banctype, bancnumber, departamento, ciudad, codpostal, direccion) VALUES (:nombre, :tipoidfiscal, :cifnif,:codcliente, :telefono1, :telefono2, :email,:codpago, :coddivisa, :regimeniva, :personafisica, :bancname, :banctype, :bancnumber, :departamento, :ciudad, :codpostal, :direccion)");
		$this->db->bind(':nombre', $datos[0]);
		$this->db->bind(':tipoidfiscal', $datos[1]);
		$this->db->bind(':cifnif', $datos[2]);
		$this->db->bind(':telefono1', $datos[3]);
		$this->db->bind(':telefono2', $datos[4]);
		$this->db->bind(':email', $datos[5]);
		$this->db->bind(':codpago', $datos[6]);
		$this->db->bind(':coddivisa', $datos[7]);
		$this->db->bind(':regimeniva', $datos[8]);
		$this->db->bind(':personafisica', $datos[9]);
		$this->db->bind(':bancname', $datos[10]);
		$this->db->bind(':banctype', $datos[11]);
		$this->db->bind(':bancnumber', $datos[12]);
		$this->db->bind(':departamento', $datos[13]);
		$this->db->bind(':ciudad', $datos[14]);
		$this->db->bind(':codpostal', $datos[15]);
		$this->db->bind(':direccion', $datos[16]);
		$this->db->bind(':codcliente', $cod);


		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * getCodCliente()
	 * obtiene el código para nuevos clientes de manera ascendente
	 * @access public
	 * @return int  
	 */
	public function getCodCliente()
	{
		$this->db->query('SELECT * FROM clientes ORDER BY id_cliente DESC LIMIT 0,1');
		$this->db->execute();

		$this->result = $this->db->registro();
		if ($this->result != null) {
			return $this->result->codcliente + 1;
		} else {
			return 1;
		}
	}

	/**
	 * Metodo para autocompletar Clientes
	 * @access public
	 * @param string $datos
	 * Termino a buscar
	 * @return object
	 */
	public function autocompletarCliente($datos, $campo)
	{
		$this->db->query("SELECT * FROM clientes WHERE $campo LIKE '%" . $datos . "%' LIMIT 0 ,50");
		$this->db->execute();
		//Retornamos valor
		return $this->db->registrosrow();
	}
	/**
	 * Metodo para traer notas credito
	 * @access public
	 * @param int $id_factura
	 * @param string $prefix_note
	 * @return object
	 */
	public function NC(int $id_factura, string $prefix_note)
	{
		$this->db->query("SELECT * FROM notas_dian WHERE idfactura=:idfactura AND prefijo=:prefijo");
		$this->db->bind(':idfactura', $id_factura);
		$this->db->bind(':prefijo', $prefix_note);
		if ($this->db->registro() != null) {
			return $this->db->registro();
		} else {
			return false;
		}
	}


	/**
	 * Método para insertar nueva factura de cliente
	 * @access public 
	 * @param array $datos
	 * @return bool
	 */
	public function nuevaFacturaCliente(array $datos)
	{
		$this->db->query("INSERT INTO facturascli(" . implode(',', array_keys($datos)) . ") VALUES(:" . implode(',:', array_keys($datos)) . ")");
		//Vinculación de valores dinamico
		foreach ($datos as $key => $value) {
			$this->db->bind(":{$key}", $value);
		}
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Metodo edita el total de la factura
	 * @access public
	 * @param array $datos
	 * Trae un array con el id de factura y el valor a insertar
	 * @return bool
	 */
	public function InsertaTotal($datos)
	{
		$text = '';
		foreach ($datos as $key => $value) {
			$text .= $key . '=:' . $key . ',';
		}
		$text = substr($text, 0, -1);
		$this->db->query("UPDATE facturascli SET " . strval($text) . " WHERE idfactura=:idfactura");
		foreach ($datos as $key => $value) {
			$this->db->bind(':' . $key, $value);
		}
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Método para insertar lineas de facturas de cliente
	 * @access public
	 * @param array datos
	 * @return bool 
	 */
	public function insertarLineasFactura(array $datos): bool
	{
		$this->db->query("INSERT INTO lineasfacturascli(" . implode(',', array_keys($datos)) . ") VALUES(:" . implode(',:', array_keys($datos)) . ")");
		//Vinculación de valores dinamico
		foreach ($datos as $key => $value) {
			$this->db->bind(":{$key}", $value);
		}
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	public function EditInvClient($datos)
	{
		if (isset($datos['lineasfactura'])) {
			$text = '';
			foreach ($datos as $key => $value) {
				$text .= $key . '=:' . $key . ',';
			}
			$text = substr($text, 0, -1);
			$this->db->query("UPDATE facturascli SET " . strval($text) . " WHERE idfactura=:idfactura");
			foreach ($datos as $key => $value) {
				$this->db->bind(':' . $key, $value);
			}
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		} else if (isset($datos['descripcion'])) {
			$this->db->query("INSERT INTO lineasfacturascli(" . implode(',', array_keys($datos)) . ") VALUES(:" . implode(',:', array_keys($datos)) . ")");
			//Vinculación de valores dinamico
			foreach ($datos as $key => $value) {
				$this->db->bind(":{$key}", $value);
			}
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		}
	}

	/**
	 * actualizarFacturaDian
	 * Método del modelo encargo de actualizar factura y setear campos, con los valores
	 * que acrediten el registro como una factura electrónica
	 * @access public
	 * @param array
	 * @return bool
	 */
	public function actualizarFacturaDian(array $datos): bool
	{
		if (isset($datos['NC']) && $datos['NC'] != false) {
			$this->db->query("UPDATE facturascli SET  estado=:estado, estadodian2=:estadodian2 WHERE idfactura=:id");
			$this->db->bind(':estado', $datos['estado']);
			$this->db->bind(':estadodian2', $datos['estadodian2']);
			$this->db->bind(':id', $datos['id']);
		} else {
			$this->db->query("UPDATE facturascli 
		SET codtrans=:codtrans,prefijo=:prefijo,qr=:qr,fecha_hora_dian=:fecha_hora_dian,numero2=:numero2, estadodian1=:estadodian1, 
		nombrexml=:nombrexml, 
		cufedian=:cufedian, 
		zipkey=:zipkey, estado=:estado WHERE idfactura=:id");
			$this->db->bind(':codtrans',    $datos['codtrans']);
			$this->db->bind(':prefijo',     $datos['prefijo']);
			$this->db->bind(':qr',          $datos['qr']);
			$this->db->bind(':fecha_hora_dian', $datos['fecha_hora_dian']);
			$this->db->bind(':numero2',     $datos['numero2']);
			$this->db->bind(':estadodian1', $datos['estadodian1']);
			$this->db->bind(':nombrexml',   $datos['nombrexml']);
			$this->db->bind(':cufedian',    $datos['cufedian']);
			$this->db->bind(':zipkey',      $datos['zipkey']);
			$this->db->bind(':estado',      intval(3));
			$this->db->bind(':id',          $datos['id']);
		}

		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * newNote
	 * Se encarga de crear un nuevo documento de tipo nota credio o debito
	 * @access public
	 * @param array $datos
	 * contiene toda la información para un nuevo registro
	 * @return bool
	 */
	public function newNote(array $datos): bool
	{

		$this->db->query("INSERT INTO notas_dian (idfactura, CUDE, prefijo, numero, nombre_zip, nombre_xml, zipkey, fecha_hora_dian, date_added) VALUES (:idfactura,:CUDE,:prefijo,:numero,:nombre_zip,:nombre_xml,:zipkey,:fecha_hora_dian,:date_added)");
		//Vinculación de valores de manera dinamica
		foreach ($datos as $key => $value) {

			$this->db->bind(":{$key}", $value);
		}
		//ejecuón de la consulta SQL
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
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
	public function Number($tabla, $campo)
	{
		if ($this->Count($tabla) > 0) {
			$this->result = $this->Last($tabla, $campo);
			return $this->result->numero + 1;
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

	/**
	 * Trae info de un ingreso
	 * @access public
	 * @param = $id
	 * Id de recibo
	 * @param = $campo
	 * campo a filtrar
	 * @return object
	 */
	public function Ingresos($id, $campo)
	{
		$this->db->query("SELECT * FROM ingresos_clientes WHERE $campo= :$campo");
		$this->db->bind(':' . $campo, $id);
		if ($this->db->registros() != "") {
			$this->data = $this->db->registros();
			return $this->data;
		} else {
			return false;
		}
	}
	/**
	 * Metodo cambia estados factura
	 * @access public
	 * @param int $id_factura
	 * @return bool
	 */
	public function StateInv($id_factura)
	{
		$this->db->query("UPDATE facturascli SET estado=:estado WHERE idfactura=:idfactura");
		$this->db->bind(':estado', 1);
		$this->db->bind(':idfactura', $id_factura);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}


	/**
	 * Método para obtener la hora en formato MYSQL
	 * @access public
	 * @return time
	 */
	public function horaMYSQL()
	{
		$hoy  = getdate();
		$hora = $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];

		return $hora;
	}

	/**
	 * Metodo para autocompletar facturas
	 * @access public
	 * @param = $datos
	 * Termino a buscar
	 * @return object
	 */
	public function autoCompleteInvClient($datos)
	{
		$this->db->query("SELECT * FROM facturascli WHERE numero LIKE '%" . $datos . "%' LIMIT 0 ,50");
		$this->db->execute();
		//Retornamos valor
		return $this->db->registrosrow();
	}

	public function GetAll(string $table)
	{
		$this->db->query("SELECT * FROM {$table} ORDER BY id ASC");
		return $this->db->registros();
	}

	public function GetOne(string $table, array $datos)
	{
		$this->db->query("SELECT * FROM {$table} WHERE id={$datos['id']} ORDER BY id ASC");
		if(count($this->db->registrosrow()) > 0){
			return $this->db->registrosrow()[0];
		}else{
			return array();
		}
	}
}
