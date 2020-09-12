<?php

/**
 * 
 * 
 * @author PlenusServices
 */
//Iniciamos modelo cliente
class ModelProv
{
	/**
	 * Variable de conexion
	 * @access public
	 * @var = $db
	 */
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
	//--------------------------------------------------------------CRUD
	/**
	 * Metodo para guardar proveedor
	 * @access public
	 * @param = $datos
	 * Array de datos del proveedor
	 * @return bool
	 */
	public function SaveProv($datos)
	{
		$this->db->query("INSERT INTO proveedores(nombre, type_id, cifnif, telefono1, country, deptoprov, cityprov, codpprov, direccion, personafisica) VALUES (:nombre, :type_id, :cifnif, :telefono1, :country, :deptoprov, :cityprov, :codpprov, :direccion, :personafisica)");
		$this->db->bind(':nombre', $datos['nombre']);
		$this->db->bind(':type_id', $datos['type_id']);
		$this->db->bind(':cifnif', $datos['cifnif']);
		$this->db->bind(':telefono1', $datos['telefono1']);
		$this->db->bind(':country', $datos['country']);
		$this->db->bind(':deptoprov', $datos['deptoprov']);
		$this->db->bind(':cityprov', $datos['cityprov']);
		$this->db->bind(':codpprov', $datos['codpprov']);
		$this->db->bind(':direccion', $datos['addrprov']);
		$this->db->bind(':personafisica', $datos['personafisica']);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Metodo para editar proveedor
	 * @access public
	 * @param = $datos
	 * Array de datos del proveedor
	 * @return bool
	 */
	public function EditProv($datos)
	{
		if (isset($datos['provname'])) {
			$this->db->query("UPDATE proveedores SET nombre=:nombre , type_id=:type_id, cifnif=:cifnif, telefono1=:telefono1, telefono2=:telefono2, email=:email, fp=:fp, divisa=:divisa, riva=:riva, observaciones=:observaciones, personafisica=:personafisica, estado=:estado WHERE codproveedor=:codproveedor");
			$this->db->bind(':nombre', $datos['provname']);
			$this->db->bind(':type_id', $datos['type_id']);
			$this->db->bind(':cifnif', $datos['provcifnif']);
			$this->db->bind(':telefono1', $datos['telefono1']);
			$this->db->bind(':telefono2', $datos['telefono2']);
			$this->db->bind(':email', $datos['email']);
			$this->db->bind(':fp', $datos['fp']);
			$this->db->bind(':divisa', $datos['divisa']);
			$this->db->bind(':riva', $datos['riva']);
			$this->db->bind(':observaciones', $datos['obs']);
			$this->db->bind(':personafisica', $datos['personafisica']);
			$this->db->bind(':codproveedor', $datos['codprov']);
			$this->db->bind(':estado', $datos['estado']);
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		} else if (isset($datos['bancname'])) {
			$this->db->query("UPDATE proveedores SET bancname=:bancname, banctype=:banctype, no_cuenta=:no_cuenta WHERE codproveedor =:codproveedor");
			$this->db->bind(':bancname', $datos['bancname']);
			$this->db->bind(':banctype', $datos['banctype']);
			$this->db->bind(':no_cuenta', $datos['bancnumber']);
			$this->db->bind(':codproveedor', $datos['accprov']);
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		} else if (isset($datos['addressprov'])) {
			$this->db->query("UPDATE proveedores SET country=:country, deptoprov=:deptoprov, cityprov=:cityprov, codpprov=:codpprov, direccion=:direccion WHERE codproveedor =:codproveedor");
			$this->db->bind(':country', $datos['country']);
			$this->db->bind(':deptoprov', $datos['deptoprov']);
			$this->db->bind(':cityprov', $datos['cityprov']);
			$this->db->bind(':codpprov', $datos['codpprov']);
			$this->db->bind(':direccion', $datos['addressprov']);
			$this->db->bind(':codproveedor', $datos['addrprov']);
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	//--------------------------------------------------------------/CRUD
	//--------------------------------------------------------------CRUD
	/**
	 * Metodo para guardar facturas Proveedor
	 * @access public
	 * @param = $datos
	 * Array de datos de la factura de proveedor
	 * @return bool
	 */
	public function SaveInvProv($datos)
	{
		if (isset($datos['codproveedor'])) {
			$divisa = $this->Prov($datos['codproveedor'])->divisa;
			$this->db->query("INSERT INTO facturasprov(cifnif, codproveedor,coddivisa, nombre, telefono, email, direccion, fecha,ejercicio,hora, fp, estado, lineasfactura, observaciones, numero, referencia) 
			VALUES (:cifnif, :codproveedor,:coddivisa, :nombre, :telefono, :email, :direccion, :fecha,:ejercicio, :hora, :fp, :estado, :lineasfactura, :observaciones, :numero, :referencia)");
			$this->db->bind(':nombre', $datos['ClieNombre']);
			$this->db->bind(':cifnif', $datos['ClieNit']);
			$this->db->bind(':codproveedor', $datos['codproveedor']);
			$this->db->bind(':telefono', $datos['ClieTelefono']);
			$this->db->bind(':email', $datos['ClieEmail']);
			$this->db->bind(':direccion', $datos['ClieDireccion']);
			$this->db->bind(':fp', $datos['FormaPago']);
			$this->db->bind(':estado', $datos['FacEstado']);
			$this->db->bind(':fecha', $datos['FacFecha']);
			$this->db->bind(':ejercicio', strval(date("Y")));
			$this->db->bind(':hora', $this->horaMYSQL());
			$this->db->bind(':lineasfactura', $datos['numero_item']);
			$this->db->bind(':observaciones', $datos['FacObservacion']);
			$this->db->bind(':numero', $datos['numero']);
			$this->db->bind(':coddivisa', $divisa ?? 'COP');
			$this->db->bind(':referencia', $datos['referencia']);
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		} else if (isset($datos['idfactura'])) {
			$this->db->query("INSERT INTO lineasfacturasprov(idfactura,No_linea, articulo, cantidad, precio, dto, neto, retencion, iva, total) VALUES (:idfactura,:No_linea,  :articulo, :cantidad, :precio, :dto, :neto, :retencion, :iva, :total)");
			$this->db->bind(':idfactura', $datos['idfactura']);
			$this->db->bind(':No_linea', $datos['No_linea']);
			$this->db->bind(':articulo', $datos['ProdNombre']);
			$this->db->bind(':cantidad', $datos['cantidad']);
			$this->db->bind(':precio', $datos['ProdPrecioVenta']);
			$this->db->bind(':dto', $datos['dto']);
			$this->db->bind(':neto', $datos['subtotal']);
			$this->db->bind(':retencion', $datos['RE']);
			$this->db->bind(':iva', $datos['iva']);
			$this->db->bind(':total', $datos['total']);
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		} else if (isset($datos['id'])) {
			$this->db->query("UPDATE facturasprov 
			SET total = :total, totaliva=:totaliva, totaldto=:totaldto, RE=:RE
			WHERE idfactura= :idfactura");
			$this->db->bind(':total', $datos['total']);
			$this->db->bind(':totaliva', $datos['iva']);
			$this->db->bind(':totaldto', $datos['dto']);
			$this->db->bind(':RE', $datos['RE']);
			$this->db->bind(':idfactura', $datos['id']);
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		}
	}
	/**
	 * Metodop ara crear factura desde recibos
	 * @access public
	 * @param = null
	 * @return bool
	 */
	public function GenInv($datos)
	{
		if ($datos['pagado'] == 'Si') {
			$pago = 1;
		} else {
			$pago = 0;
		}
		//date_default_timezone_set('America/Bogota');
		$num  = $this->Number('facturasprov', 'idfactura');
		$prov = $this->Prov($datos['codprov']);
		$divisa = $this->Prov($datos['codprov'])->divisa;

		$this->db->query("INSERT INTO facturasprov(cifnif, codproveedor,coddivisa, nombre, telefono, email, direccion, fecha,ejercicio,hora, fp, estado, lineasfactura, observaciones, numero, total) VALUES (:cifnif, :codproveedor,:coddivisa, :nombre, :telefono, :email, :direccion, :fecha,:ejercicio, :hora, :fp, :estado, :lineasfactura, :observaciones, :numero,:total)");
		$this->db->bind(':nombre', $datos['proveedor']);
		$this->db->bind(':codproveedor', $datos['codprov']);
		$this->db->bind(':numero', $num);
		$this->db->bind(':cifnif', $prov->cifnif);
		$this->db->bind(':telefono', $prov->telefono1);
		$this->db->bind(':email', $prov->email);
		$this->db->bind(':direccion', $prov->direccion);
		$this->db->bind(':fecha', date('Y-m-d'));
		$this->db->bind(':ejercicio', strval(date("Y")));
		$this->db->bind(':hora', $this->horaMYSQL());
		$this->db->bind(':fp', $prov->fp);
		$this->db->bind(':estado', $pago);
		$this->db->bind(':lineasfactura', 1);
		$this->db->bind(':observaciones', "Documento equivalente a factura de compra, generado mediante recibo No {$datos['number']}");
		$this->db->bind(':total', $datos['importe']);
		$this->db->bind(':coddivisa', $divisa ?? 'COP');

		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Metodo para agregar las lineas generadas desde los recibos
	 * @access public
	 * @param = $datos
	 * Id de factura a agregar lineas
	 * @return bool 
	 */
	public function GenLine($datos)
	{
		$last = $this->Last('facturasprov', 'idfactura');
		$this->db->query("INSERT INTO lineasfacturasprov (idfactura,No_linea,articulo,cantidad,precio,neto,total) VALUES (:idfactura,:No_linea,:articulo,:cantidad,:precio,:neto,:total)");
		$this->db->bind(':idfactura', $last->idfactura);
		$this->db->bind(':No_linea', 1);
		$this->db->bind(':articulo', $datos['observaciones']);
		$this->db->bind(':cantidad', 1);
		$this->db->bind(':precio', $datos['importe']);
		$this->db->bind(':neto', $datos['importe']);
		$this->db->bind(':total', $datos['importe']);
		if ($this->db->execute()) {
			return false;
		} else {
			$this->db->query("UPDATE recibos_proveedor SET idfactura=:idfactura WHERE id_recibo=:id_recibo");
			$this->db->bind(':idfactura', intval($last->idfactura));
			$this->db->bind(':id_recibo', intval($datos['recibo']));
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		}
	}
	/**
	 * Metodo para editar facturas
	 * @access public
	 * @param = $datos
	 * Array de datos de la factura de proveedor
	 * @return bool
	 */
	public function EditInvProv($datos)
	{
		if (isset($datos['numero_item'])) {
			$this->db->query("UPDATE facturasprov 
			SET cifnif=:cifnif, codproveedor=:codproveedor, nombre=:nombre, telefono=:telefono, email=:email, direccion=:direccion, fecha=:fecha, fp=:fp, estado=:estado, lineasfactura=:lineasfactura, observaciones=:observaciones, referencia=:referencia  WHERE idfactura=:idfactura");
			$this->db->bind(':idfactura', $datos['idfactura']);
			$this->db->bind(':nombre', $datos['ClieNombre']);
			$this->db->bind(':cifnif', $datos['ClieNit']);
			$this->db->bind(':codproveedor', $datos['codproveedor']);
			$this->db->bind(':telefono', $datos['ClieTelefono']);
			$this->db->bind(':email', $datos['ClieEmail']);
			$this->db->bind(':direccion', $datos['ClieDireccion']);
			$this->db->bind(':fp', $datos['FormaPago']);
			$this->db->bind(':estado', $datos['FacEstado']);
			$this->db->bind(':fecha', $datos['FacFecha']);
			$this->db->bind(':lineasfactura', $datos['numero_item']);
			$this->db->bind(':observaciones', $datos['FacObservacion']);
			$this->db->bind(':referencia', $datos['referencia']);
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		} else if (isset($datos['ProdNombre'])) {
			$this->db->query("INSERT INTO lineasfacturasprov(idfactura,No_linea, articulo, cantidad, precio, dto, neto, retencion, iva, total) VALUES (:idfactura,:No_linea,  :articulo, :cantidad, :precio, :dto, :neto, :retencion, :iva, :total)");
			$this->db->bind(':idfactura', $datos['idfactura']);
			$this->db->bind(':No_linea', $datos['No_linea']);
			$this->db->bind(':articulo', $datos['ProdNombre']);
			$this->db->bind(':cantidad', $datos['cantidad']);
			$this->db->bind(':precio', $datos['ProdPrecioVenta']);
			$this->db->bind(':dto', $datos['dto']);
			$this->db->bind(':neto', $datos['subtotal']);
			$this->db->bind(':retencion', $datos['RE']);
			$this->db->bind(':iva', $datos['iva']);
			$this->db->bind(':total', $datos['total']);
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		} else if (isset($datos['id'])) {
			$this->db->query("UPDATE facturasprov 
			SET total = :total, totaliva=:totaliva, totaldto=:totaldto, RE=:RE
			WHERE idfactura= :idfactura");
			$this->db->bind(':total', $datos['total']);
			$this->db->bind(':totaliva', $datos['iva']);
			$this->db->bind(':totaldto', $datos['dto']);
			$this->db->bind(':RE', $datos['RE']);
			$this->db->bind(':idfactura', $datos['id']);
			if ($this->db->execute()) {
				return false;
			} else {
				return true;
			}
		}
	}
	//--------------------------------------------------------------/CRUD
	//--------------------------------------------------------------CRUD
	/**
	 * Metodo para guardar recibos
	 * @access public
	 * @param = $datos
	 * array de datos a guardar
	 * @return bool
	 * @method ajax
	 */
	public function AddOut($datos = array())
	{
		$this->db->query("INSERT INTO recibos_proveedor(proveedor,codproveedor,idfactura, importe, emitido, observaciones, numero, date_added) VALUES (:proveedor,:codproveedor, :idfactura, :importe, :emitido, :observaciones, :numero, :date_added)");
		$this->db->bind(':proveedor', $datos['prov']);
		$this->db->bind(':idfactura', intval($datos['id_factura']) ?? NULL);
		$this->db->bind(':importe', $datos['importe']);
		$this->db->bind(':emitido', $datos['emitido']);
		$this->db->bind(':observaciones', $datos['obs']);
		$this->db->bind(':numero', $datos['numero']);
		$this->db->bind(':codproveedor', $datos['idprov']);
		$this->db->bind(':date_added', date('Y-m-d'));

		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Metodop ara editar egresos proveedor
	 * @access public
	 * @param = $datos
	 * @return bool
	 */
	public function EditOut($datos)
	{

		$this->db->query("UPDATE recibos_proveedor SET idfactura=:idfactura, emitido=:emitido, divisa=:divisa, importe=:importe, fp=:fp, vencimiento=:vencimiento, pagado=:pagado, notificado=:notificado, observaciones=:observaciones WHERE id_recibo =:id_recibo");
		$this->db->bind(':idfactura', intval($datos['id_factura']));
		$this->db->bind(':emitido', $datos['emitido']);
		$this->db->bind(':divisa', $datos['divisa']);
		$this->db->bind(':importe', $datos['importe']);
		$this->db->bind(':fp', $datos['fp']);
		$this->db->bind(':vencimiento', $datos['vence']);
		$this->db->bind(':pagado', $datos['pagado']);
		$this->db->bind(':notificado', $datos['notificado']);
		$this->db->bind(':observaciones', $datos['observaciones']);
		$this->db->bind(':id_recibo', $datos['recibo']);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
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
	public function AddRecibo($datos = array())
	{
		$num = $this->Number('recibos_proveedor', 'id_recibo');
		$this->db->query("INSERT INTO recibos_proveedor(proveedor,codproveedor,divisa,fp,vencimiento, pagado, notificado,idfactura, importe, emitido, observaciones, numero, estado_recibo, date_added) VALUES (:proveedor,:codproveedor,:divisa, :fp,:vencimiento, :pagado, :notificado, :idfactura, :importe, :emitido, :observaciones, :numero, :estado_recibo, :date_added)");
		$this->db->bind(':proveedor', $datos['prov']);
		$this->db->bind(':idfactura', intval($datos['idf']) ?? NULL);
		$this->db->bind(':importe', $datos['importe']);
		$this->db->bind(':emitido', $datos['fecha_emitido']);
		$this->db->bind(':observaciones', $datos['concepto']);
		$this->db->bind(':codproveedor', $datos['codprov']);
		$this->db->bind(':divisa', $datos['divisa']);
		$this->db->bind(':fp', $datos['fp_recibo']);
		$this->db->bind(':vencimiento', $datos['vencimiento']);
		$this->db->bind(':pagado', $datos['pagado']);
		$this->db->bind(':notificado', $datos['notificado']);
		$this->db->bind(':numero', $num);
		if (isset($datos['estado_recibo'])) {
			$this->db->bind(':estado_recibo', $datos['estado_recibo']);
		} else {
			$this->db->bind(':estado_recibo', 0);
		}
		$this->db->bind(':date_added', date('Y-m-d'));



		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Metodo blindar un recibo
	 * @access public 
	 * @param int $datos
	 * @return bool
	 */
	public function Armor($datos)
	{
		$this->db->query("UPDATE recibos_proveedor SET estado_recibo=:estado_recibo WHERE idfactura=:idfactura");
		$this->db->bind(':estado_recibo', 1);
		$this->db->bind(':idfactura', $datos);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	//--------------------------------------------------------------/CRUD

	/**
	 * Modelo cambia estados
	 * @access public
	 * @param = $id
	 * Id de proveedor
	 * @param = $state
	 * Estado de proveedor a swichear
	 * @return bool
	 */
	public function State($id, $state)
	{
		$this->db->query("UPDATE proveedores SET estado = $state WHERE codproveedor =:codproveedor");
		$this->db->bind(':codproveedor', $id);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
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
			echo false;
		} else {
			$this->db->query("SELECT * FROM $tabla ORDER BY  $campo DESC LIMIT 0,1");
			if ($this->db->registro() != "") {
				$this->result = $this->db->registro();
				return $this->result;
			} else {
				echo false;
			}
		}
	}

	/**
	 * trae info de un proveedor
	 * @access public
	 * @param = $id
	 * Id de proveedor
	 * @return object
	 */
	public function Prov($id)
	{
		$this->db->query("SELECT * FROM proveedores WHERE codproveedor= :codproveedor");
		$this->db->bind(':codproveedor', $id);
		if ($this->db->registro() != "") {
			$this->result = $this->db->registro();
			return $this->result;
		} else {
			return false;
		}
	}
	/**
	 * Trae info de una factura
	 * @access public
	 * @param = $id
	 * Id de factura
	 * @return object
	 */
	public function Inv($id)
	{
		$this->db->query("SELECT * FROM facturasprov WHERE idfactura= :idfactura");
		$this->db->bind(':idfactura', $id);
		if ($this->db->registro() != "") {
			$this->invoice = $this->db->registro();
			$this->db->query("SELECT * FROM lineasfacturasprov WHERE idfactura = :idfactura");
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
	 * Metodo cambia estados factura
	 * @access public
	 * @param int $id_factura
	 * @return bool
	 */
	public function StateInv($id_factura)
	{
		$this->db->query("UPDATE facturasprov SET estado=:estado WHERE idfactura=:idfactura");
		$this->db->bind(':estado', 1);
		$this->db->bind(':idfactura', $id_factura);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Metodo para consultar si un proveedor posee facturas asociadas
	 * @access public
	 * @param int $id_prov
	 * @return int
	 */
	public function Asociated($id_prov)
	{
		$this->db->query("SELECT count(*) FROM facturasprov WHERE codproveedor=:codproveedor");
		$this->db->bind(":codproveedor", $id_prov);
		$val = $this->db->fetchColumn();
		return $val;
	}
	/**
	 *Metodo cambia estados recibos
	 *@access public
	 *@param int $id_factura
	 *@return bool
	 */
	public function StateOut($id_factura)
	{
		$this->db->query("UPDATE recibos_proveedor SET estado_recibo=:estado_recibo WHERE idfactura=:idfactura");
		$this->db->bind(':estado_recibo', 1);
		$this->db->bind(':idfactura', $id_factura);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Metodo para guardar adjuntos
	 * @access public
	 * @param array $datos
	 * @return bool
	 */
	public function ProvData($datos)
	{
		$this->db->query("UPDATE proveedores SET adjunto_pdf=:adjunto_pdf WHERE codproveedor=:codproveedor");
		$this->db->bind(':adjunto_pdf', $datos['nombre']);
		$this->db->bind(':codproveedor', $datos['id']);
		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Metodo para numerar datos de factura
	 * @access public
	 * @param = $tabla
	 * tabla a traer ultima numeracion
	 * @param = $campo
	 * Llave primaria
	 * @return number
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
	 * Método para importar proveedores desde excel
	 * @access public
	 * @param array $datos
	 * @return bool
	 */
	public function Import(array $datos): bool
	{
		$this->db->query("INSERT INTO proveedores(nombre, type_id, cifnif, telefono1, telefono2, email, fp, divisa, riva, personafisica, bancname, banctype, no_cuenta, deptoprov, cityprov, codpprov, direccion) VALUES (:nombre, :type_id, :cifnif, :telefono1, :telefono2, :email, :fp, :divisa, :riva, :personafisica, :bancname, :banctype, :no_cuenta, :deptoprov, :cityprov, :codpprov, :direccion)");
		$this->db->bind(':nombre', $datos[0]);
		$this->db->bind(':type_id', $datos[1]);
		$this->db->bind(':cifnif', $datos[2]);
		$this->db->bind(':telefono1', $datos[3]);
		$this->db->bind(':telefono2', $datos[4]);
		$this->db->bind(':email', $datos[5]);
		$this->db->bind(':fp', $datos[6]);
		$this->db->bind(':divisa', $datos[7]);
		$this->db->bind(':riva', $datos[8]);
		$this->db->bind(':personafisica', $datos[9]);
		$this->db->bind(':bancname', $datos[10]);
		$this->db->bind(':banctype', $datos[11]);
		$this->db->bind(':no_cuenta', $datos[12]);
		$this->db->bind(':deptoprov', $datos[13]);
		$this->db->bind(':cityprov', $datos[14]);
		$this->db->bind(':codpprov', $datos[15]);
		$this->db->bind(':direccion', $datos[16]);

		if ($this->db->execute()) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Trae info de un recibo
	 * @access public
	 * @param = $id
	 * Id de recibo
	 * @param = $campo
	 * campo a filtrar
	 * @return object
	 */
	public function Recibo($id, $campo)
	{
		$this->db->query("SELECT * FROM recibos_proveedor WHERE $campo= :$campo");
		$this->db->bind(':' . $campo, $id);
		if ($this->db->registros() != "") {
			$this->data = $this->db->registros();
			return $this->data;
		} else {
			return false;
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
	 * Metodo para traer conteo 
	 * @access public
	 * @param = $tabla
	 * Tabla a contar registros
	 * @return number
	 */
	public function Count($tabla)
	{
		$this->db->query("SELECT count(*) FROM $tabla");
		$val = $this->db->fetchColumn();
		return $val;
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
			$this->db->bind(":$key", $id);
			//Ejecutamos la consulta:
			if ($this->db->execute()) {
				return false;
			} else //sino {
			{
				return true;
			}
		}
	}


	/**
	 * Metodo para autocompletar Proveedores
	 * @access public
	 * @param = $datos
	 * Termino a buscar
	 * @return object
	 */
	public function autoCompleteProv($datos, $campo)
	{
		$this->db->query("SELECT * FROM proveedores WHERE $campo LIKE '%" . $datos . "%' LIMIT 0 ,50");
		$this->db->execute();
		//Retornamos valor
		return $this->db->registrosrow();
	}

	/**
	 * Metodo para autocompletar Proveedores
	 * @access public
	 * @param = $datos
	 * Termino a buscar
	 * @return object
	 */
	public function autoCompleteProvName($datos)
	{
		$this->db->query("SELECT * FROM proveedores WHERE nombre LIKE '%" . $datos . "%' LIMIT 0 ,50");
		$this->db->execute();
		//Retornamos valor
		return $this->db->registrosrow();
	}
	/**
	 * Metodo para autocompletar facturas
	 * @access public
	 * @param = $datos
	 * Termino a buscar
	 * @return object
	 */
	public function autoCompleteInv($datos)
	{
		$this->db->query("SELECT * FROM facturasprov WHERE numero LIKE '%" . $datos . "%' LIMIT 0 ,50");
		$this->db->execute();
		//Retornamos valor
		return $this->db->registrosrow();
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
}
/**
 * @Table_names
 * proveedores
 * divisas
 * paises
 * facturasprov
 * lineasfacturasprov
 * recibos_proveedor
 */
