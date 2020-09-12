<?php

/**
 * ModelFE
 * Este archivo hace parte del módulo Facturación de myGTEP.
 *
 * @author     Juan Bautista <soyjuanbautista0@gmail.com>
 */
class ModelFE
{
    /**
     * Esta se usa para la instancia de la conexión a la base de datos.
     *
     * @var object
     */
    private $db;
    /**
     * Esta variable se usa para gestionar todos los resultados de las consultas.
     *
     * @var array ?? object
     */
    public $result;
    /**
     * Esta variable define el nombre de la tabla.
     *
     * @var string
     */
    private $table;


    public function __construct()
    {
        $this->db = new Base();
        $this->table = 'facturacion_electronica';
    }

    /**
     * updateConfig se encarga de actualizar los campos de la tabla
     * facturacion_electronica.
     *
     * @param array
     *
     * @return bool
     */
    public function updateConfig(array $datos, $table, $campo, $id): bool
    {
        unset($datos['clave_certificado_confirm']);
        return $this->db->Update($datos, $table, $campo, $id);
    }
    /**
     * getConfig se encarga de obtener la información de la tabla
     * facturacion_electronica.
     * @return object
     */
    public function getConfig()
    {
        $this->db->query("SELECT * FROM facturacion_electronica WHERE id_config=1");

        //Ejecutamos la consulta
        //Instancia del metodo registro, que retorna el resultado del query
        if ($this->db->registro() != null) {
            $this->result = $this->db->registro();
            return $this->result;
        } else {
            $this->db->query("INSERT INTO facturacion_electronica(id_config) VALUES(1)");
            if ($this->db->execute()) {
                $this->result = $this->db->registro();
                return  $this->result;
            }
        }
    }
    /**
     * updateCertifique
     * Se encarga de actualizar el nombre del certificado de firma digital
     * @access public
     * @param string
     * @return bool
     */
    public function updateCertifique($name): bool
    {
        $this->db->query("UPDATE facturacion_electronica SET certificado=:certificado WHERE id_config='1' ");
        $this->db->bind(':certificado', $name);
        if ($this->db->execute()) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * existeCertificado
     * Se encarga de validar si existe un certificado de firma digital
     * @access public
     * @return bool
     */
    public function existeCertificado(): bool
    {
        return true;
    }

    /**
     * Trae el ultimo registro de una tabla
     * @access public
     * @param string Tabla de la cual se requieren los datos
     * @param string Campo del cual se requiere ordenar de manera Descendiente
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

    /**
     * numberFe
     * Se ancarge asignar la numeración de manera ascendente para la facturas electrónicas
     * tal numero corresponde al valor del campo numero2 de la tabla facturascli
     * @access public
     * @return  int
     */
    public function numberFe(): int
    {
        $this->result = $this->Last('facturascli', 'numero2');
        if ($this->result) {
            if ($this->result->numero2 != "") {
                return $this->result->numero2 + 1;
            } else {
                return $this->getConfig()->rango_desde ?? 1;
            }
        } else {
            return $this->getConfig()->rango_desde ?? 1;
        }
    }

    /**
     * numberNote
     * Se ancarge asignar la numeración de manera ascendente para los documentos electronicos
     * de tipo nota credito o debito
     * tal numero corresponde al valor del campo numero2 de la tabla facturascli
     * @access public
     * @param  string $document
     * Esta variable se usa para referenciar de qu tipo de documento se necesita el número
     * ascedente, nc= nota credito nd= nota debito
     * @return  int
     */
    public function numberNote(string $document): int
    {
        $this->db->query("SELECT * FROM notas_dian WHERE prefijo=:document ORDER BY numero  DESC LIMIT 0,1");
        $this->db->bind(':document', $document);
        $this->result = $this->db->registro();
        if ($this->result != null) {
            return $this->result->numero + 1;
        } else {
            return 1;
        }
    }
    /**
     * getNote
     * Este método se encarga de obtener el registro de una nota electrónica mediante
     * el idfactura.
     * @access public
     * @param int $idfactura
     * Identificador de factura
     * @param string $doc
     * Tipo de documento electrónico NC|ND
     * @return object 
     */
    public function getNote(int $idfactura, string $doc)
    {
        $this->db->query('SELECT * FROM notas_dian WHERE idfactura=:idfactura AND prefijo=:prefijo');

        $this->db->bind(':idfactura', $idfactura);
        $this->db->bind(':prefijo', $doc);
        //Instancia del metodo registro, que retorna el resultado del query
        $this->result = $this->db->registro();

        return $this->result;
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
}
