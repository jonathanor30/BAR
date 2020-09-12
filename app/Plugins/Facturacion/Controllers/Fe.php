<?php
if (file_exists(dirname(dirname(__FILE__)) . "/vendor/autoload.php")) {
    require dirname(dirname(__FILE__)) . "/vendor/autoload.php";
}

use Jenssegers\Blade\Blade;
use Models\Clientes\Clientes;
use Models\Configs\Company\Company;
use Models\Configs\Resolutions\Resolutions;
use Models\FacturaCliente\FacturaCliente;
use Models\FacturasNotes\FacturasNotes;

/**
 * Clase Fe es la encargada de gestionar la facturación
 * electronica en myGTEP.
 *
 * @author Juan Bautista
 */

class Fe extends Controller
{
    public $functions;
    public $class;
    public $sumary_functions;
    public $sumary_class;
    public $bill_storage;
    public $assets;
    public $bautomatico;
    public $modelFe;
    public $modelPerfil;
    public $modelFactura;
    public $factura;
    public $empresa;
    public $fe;
    public $trackId;
    public $methodSend;
    public $nitDIAN;
    public $departmentCode;
    public $fiscalObligations;
    public $ulrValidation;
    public $email; //Objeto para PHPMailer
    public $host; //Servidor de correo
    public $port; //Puerto
    public $userName; //cuenta de correo
    public $password; //Contraseña
    public $subjet; //Asunto
    public $addressee; //Destinatario
    public $ModelCliente;
    public $ModelResolution;
    public $ModelCompany;
    public $Company;
    public function __construct()
    {

        $this->bill_storage = RUTA_APP . SEPARATOR . 'Storage';
        $this->modelPerfil  = $this->modelo('Perfil');
        $this->modelFactura = new FacturaCliente;
        $this->ModelCliente = new Clientes;
        $this->ModelResolution = new Resolutions;
        $this->ModelCompany = new Company;
        $this->modelFe      = $this->modelo('ModelFE', 'Facturacion');
        //Instancia PHPMailer
        $this->mail          = new PHPMailer;
        $this->mail->CharSet = "UTF-8";
        $config = $this->modelPerfil->obtenerPerfil();
        //Configuracion predeterminada
        $this->host     = $config->hostEmail; //Servidor de correo
        $this->port     = 25;
        $this->userName = $config->userEmail;
        $this->password = $config->passwordEmail;
        $this->Company = $this->ModelCompany->where("id_config", 1)->first();
        //trackId solo para habilitación y es propio de cada empresa
        $this->trackId      = $this->Company->testsid;
        //Url del catalogo de verificación

        //Tipo de metodo para el envio de documentos electróni
        /*
          ------------------------
          - SendBillSync:        -
          ------------------------
           Recibir un ZIP con UBLs DE.
           Este servicio atiende la funcionalidad de enviar a la DIAN los documentos, de forma tal que la plataforma DIAN
           reciba y valide los documentos UBL (factura electrónica, nota de crédito y nota de débito) para efectos de obtener
           un TrackId que le permitirá consumir servicio GetStatusZIP para obtener la respuesta de validación para su uso y 
           expedición.
          ------------------------
          - SendBillAsync:       -
          ------------------------
          Recibir un ZIP con UBLs DE.
          Este servicio atiende la funcionalidad de enviar a la DIAN los documentos, de forma tal que la plataforma DIAN
          reciba y valide los documentos UBL (factura electrónica, nota de crédito y nota de débito) para efectos de obtener
          un TrackId que le permitirá consumir servicio GetStatusZIP para obtener la respuesta de validación para su uso y
          expedición.
          -----------------------
          - SendTestSetAsync    -
          -----------------------
           Recibir un ZIP con UBLs DE para pruebas de Habilitación.

           Este servicio atiende la funcionalidad de enviar a la DIAN los documentos, de forma tal que la plataforma DIAN
           reciba y valide los documentos UBL (factura electrónica, nota de crédito y nota de débito) para efectos de obtener
           un TrackId que le permitirá consumir servicio GetStatusZIP con el cual se obtendrá la respuesta de validación de
           estos documentos en pruebas de habilitación.

         */
        $this->methodSend        = "SendBillSync";
        //Nit de la Dirección de Inpuestos y Aduanas Nacionales
        $this->nitDIAN           = '800197268';
        //Código de departamento de la empresa
        $this->departmentCode    = '05'; //Antioquia
        //Obligaciones fiscales
        $this->fiscalObligations = 'ZZ';
    }

    

    /**
     * soapTemplate
     * Plantilla para las peticiones SOAP al WS DIAN
     * @access public
     * @param string $nit_company
     * @return string
     */
    public function soapTemplate(string $nit_company): string
    {
        return $this->bill_storage . SEPARATOR . 'NIT' . $nit_company . SEPARATOR . 'plantillas' . SEPARATOR . 'wssSoapTemplate.xml';
    }

    /**
     * Método validateCompatibility()
     * se encarga de revisar la compatibilidad del sistema para la facturacion electronica.
     */
    public function validateCompatibility()
    {
        $this->functions = [
            'openssl_pkcs12_read', //Convierte un Almacén de Certificado PKCS#12 a una matriz
            'base64_encode', //Codifica datos con MIME base64
            'openssl_x509_export', //Exporta un certificado como una cadena
            'openssl_sign', //computa una firma para la información  especificada, generando una firma digital criptográfica
        ];
        $this->sumary_functions = array();
        $this->class            = [
            'ZipArchive', //Un fichero, comprimido con Zip.
            'DOMDocument', //Representa un documento HTML o XML en su totalidad; sirve como raíz del árbol de documento.
        ];
        $this->sumary_class = array();
        //Comprobador automatico de funciones nativas
        foreach ($this->functions as $key) {
            if (!function_exists($key)) {
                array_push($this->sumary_functions, $key);
            }
        }
        //Comprobardor automatico de Clases nativas
        foreach ($this->class as $key) {
            if (!class_exists($key)) {
                array_push($this->sumary_class, $key);
            }
        }

        //Validación final para dar la respuesta de compatibilidad
        if (!empty($this->sumary_functions) || !empty($this->sumary_class)) {
            header('Content-Type: application/json');
            echo json_encode(array('functions' => $this->sumary_functions, 'class' => $this->sumary_class), JSON_PRETTY_PRINT);
        } else {
            echo 'true';
        }
    }

    /**
     * getStorage()
     * se encarga de mostrar la ruta de almacenamiento de las facturas electronicas.
     */
    public function getStorage()
    {
        echo $this->bill_storage;
    }
    /**
     * routeReplyDIAN
     * Define la ruta donde se almacenan las respuesta de de envios
     * hechos al web services de la DIAN.
     * @access public 
     * @return string
     */
    public function routeReplyDIAN(string $nit_company): string
    {
        return $this->bill_storage . SEPARATOR . 'NIT' . $nit_company . SEPARATOR . 'rptaenvio' . SEPARATOR;
    }



    /**
     * nombreArchivo()
     * Se encarga de definir el nombre del documento.
     *
     * @param $letra
     * Letra que define el tipo de documento.
     * @param $nit
     * NIT del Facturador Electrónico sin DV, de diez (10) dígitos 
     * alineados a la derecha y relleno con ceros a la izquierda.
     * @param $prefijo
     * No disponible.
     * @param $numero
     * Numeración del documento electrónico.
     *
     * @return string
     */
    public function nombreArchivo($letra, $nit, $numero, $prefijo = false)
    {
        //Ejemplo de retorno: fv08001972680001900000011.xml
        return    $letra .  //Letras que identifiquen el tipo de documento
            str_pad($nit, 10, "0", STR_PAD_LEFT) . //nit ded iez (10) dígitos alineados a la derecha.
            '000' . //Código de proveedor tecnologico
            substr(strval(date("Y")), -2) . //ulitmos dos digitos del año
            str_pad($numero, 8, "0", STR_PAD_LEFT); //consecutivo de archivos enviados, de ocho (8) dígitos decimales alineados a la derecha
    }
    /**
     * verFactura
     * Este método se encarga de mostrar la representación grafica de la factura de venta
     * @access public 
     */
    public function verFactura($idfactura)
    {
        if (!isset($_GET['nc'])) {
            $factura = [$this->modelFactura::with("Lines")->where("idfactura", $idfactura)->first()];
            $this->pagina404($factura);
            $client = $this->ModelCliente->where('id_cliente', $factura[0]->codcliente)->first();
            $this->pagina404($client);
        } else {
            $notaCredito = \Models\FacturasNotes\FacturasNotes::with("Lines")->where("id", $idfactura)->first();
            $factura = [FacturaCliente::with("Lines")->where("idfactura", $notaCredito->idfactura)->first()];
            $client = Clientes::where("id_cliente", $notaCredito->codcliente)->first();
        }
        $empresa            = $this->modelPerfil->obtenerPerfil(); //Datos de la empresa
        $company            = Company::where("id_config", 1)->first();
        //print_debug($company);
        //Se comprueba si la factura es electrónica
        switch (true) {
            case (in_array($factura[0]->estado, [3, 4, 2, 5, 6]) && !isset($_GET['nc'])):
                //Start output
                ob_start();
                require_once RUTA_PLUGINS . 'Facturacion' . SEPARATOR . 'Views' . SEPARATOR . 'FormatosPdf' . SEPARATOR . 'factura_html.php';
                $content = ob_get_clean();
                //End output

                try {
                    // init HTML2PDF para generar PDF
                    $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(
                        0,
                        0,
                        0,
                        0,
                    ));
                    //Titulo documento
                    $html2pdf->pdf->SetTitle(explode(".", $factura[0]->nombrexml)[0]);
                    //display the full page
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    // convert
                    $html2pdf->writeHTML($content);
                    // send the PDF
                    //$html2pdf->pdf->IncludeJS('print(TRUE)');
                    $html2pdf->Output(explode(".", $factura[0]->nombrexml)[0] . '.pdf');
                } catch (HTML2PDF_exception $e) {
                    echo $e;
                    exit;
                }
                break;
            case (in_array($factura[0]->estado, [0, 1])):

                //De lo contrario muestra pre-factura
                //Start output

                ob_start();
                require_once RUTA_PLUGINS . 'Facturacion' . SEPARATOR . 'Views' . SEPARATOR . 'FormatosPdf' . SEPARATOR . 'prefactura.php';
                $content = ob_get_clean();
                //End output

                try {
                    // init HTML2PDF para generar PDF
                    $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(
                        0,
                        0,
                        0,
                        0,
                    ));
                    //Titulo documento
                    $html2pdf->pdf->SetTitle($factura[0]->numero);
                    //display the full page
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    // convert
                    $html2pdf->writeHTML($content);
                    // send the PDF
                    //$html2pdf->pdf->IncludeJS('print(TRUE)');
                    $html2pdf->Output($factura[0]->numero . '.pdf');
                } catch (HTML2PDF_exception $e) {
                    echo $e;
                    exit;
                }
                break;
            case (isset($_GET['nc'])):
                //Start output
                $factura = [$notaCredito];
                ob_start();
                require_once RUTA_PLUGINS . 'Facturacion' . SEPARATOR . 'Views' . SEPARATOR . 'FormatosPdf' . SEPARATOR . 'nota_credito.php';
                $content = ob_get_clean();
                //End output

                try {
                    // init HTML2PDF para generar PDF
                    $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(
                        0,
                        0,
                        0,
                        0,
                    ));
                    //Titulo documento
                    $html2pdf->pdf->SetTitle(substr($notaCredito->nombrexml, 0, -4));
                    //display the full page
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    // convert
                    $html2pdf->writeHTML($content);
                    // send the PDF
                    //$html2pdf->pdf->IncludeJS('print(TRUE)');
                    $html2pdf->Output(substr($notaCredito->nombrexml, 0, -4) . '.pdf');
                } catch (HTML2PDF_exception $e) {
                    echo $e;
                    exit;
                }
                break;
        }
    }

}
