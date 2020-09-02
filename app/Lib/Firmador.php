<?php

class Firmador
{

    const POLITICA_FIRMA = array(
        "name"      => "Política de firma para facturas electrónicas de la República de Colombia",
        "url"       => "https://facturaelectronica.dian.gov.co/politicadefirma/v2/politicadefirmav2.pdf",
        "digest"    => "dMoMvtcG5aIzgYo0tIsSQeVJBDnUnfSOfBpxXrmor0Y="
    );

    private $publicKey        = NULL;
    private $privateKey       = NULL;


    public function base64Encode($strcadena)
    {
        return base64_encode(hash('sha256', $strcadena, true));
    }

    public function firmar($certificadop12, $clavecertificado, $xmlsinfirma, $UUID, $doctype)
    {

        $pfx = file_get_contents($certificadop12);
        openssl_pkcs12_read($pfx, $key, $clavecertificado);
        $this->publicKey          = $key["cert"];
        $this->privateKey         = $key["pkey"];
        $this->signPolicy         = self::POLITICA_FIRMA;
        $this->signatureID        = "xmldsig-" . $UUID;
        $this->Reference0Id       = "xmldsig-" . $UUID . "-ref0";
        $this->KeyInfoId          = "xmldsig-" . $UUID . "-KeyInfo";
        $this->SignedPropertiesId = "xmldsig-" . $UUID . "-signedprops";
        return $this->insertaFirma($xmlsinfirma, $doctype);
    }


    public function get_schemas($doctype)
    {

        // obtener como una string los schemas heredados por la etiqueta KeyInfo al momento que el sistema haciendo la validacion del documento (DIAN) canonize el elemento para verificar que el digest sea correcto

        // los schemas heredados por SignedInfo y SignedProperties son los mismos 

        $string = '';

        switch ($doctype) {
            case 'fv':
                $string .= 'xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" ';
                break;
            case 'nc':
                $string .= 'xmlns="urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2" ';
                break;
            case 'nd':
                $string .= 'xmlns="urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2" ';
                break;
        }


        $string .= 'xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:sts="http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures" xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" xmlns:xades141="http://uri.etsi.org/01903/v1.4.1#" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';

        return $string;
    }

    public function generateSignedProperties($signTime, $certDigest, $certIssuer, $certSerialNumber)
    {

        // version canonicalizada no es necesario volver a hacerlo
        return '<xades:SignedProperties Id="' . $this->SignedPropertiesId . '">' .
            '<xades:SignedSignatureProperties>' .
            '<xades:SigningTime>' . $signTime . '</xades:SigningTime>' .
            '<xades:SigningCertificate>' .
            '<xades:Cert>' .
            '<xades:CertDigest>' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $certDigest . '</ds:DigestValue>' .
            '</xades:CertDigest>' .
            '<xades:IssuerSerial>' .
            '<ds:X509IssuerName>' . $certIssuer . '</ds:X509IssuerName>' .
            '<ds:X509SerialNumber>' . $certSerialNumber . '</ds:X509SerialNumber>' .
            '</xades:IssuerSerial>' .
            '</xades:Cert>' .
            '</xades:SigningCertificate>' .
            '<xades:SignaturePolicyIdentifier>' .
            '<xades:SignaturePolicyId>' .
            '<xades:SigPolicyId>' .
            '<xades:Identifier>' . $this->signPolicy['url'] . '</xades:Identifier>' .
            '<xades:Description>' . $this->signPolicy['name'] . '</xades:Description>' .
            '</xades:SigPolicyId>' .
            '<xades:SigPolicyHash>' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $this->signPolicy['digest'] . '</ds:DigestValue>' .
            '</xades:SigPolicyHash>' .
            '</xades:SignaturePolicyId>' .
            '</xades:SignaturePolicyIdentifier>' .
            '<xades:SignerRole>' .
            '<xades:ClaimedRoles>' .
            '<xades:ClaimedRole>supplier</xades:ClaimedRole>' .
            '</xades:ClaimedRoles>' .
            '</xades:SignerRole>' .
            '</xades:SignedSignatureProperties>' .
            '</xades:SignedProperties>';
    }

    public function getKeyInfo()
    {
        // version canonicalizada no es necesario volver a hacerlo
        return '<ds:KeyInfo Id="' . $this->KeyInfoId . '">' .
            '<ds:X509Data>' .
            '<ds:X509Certificate>' . $this->getCertificate() . '</ds:X509Certificate>' .
            '</ds:X509Data>' .
            '</ds:KeyInfo>';
    }

    public function getSignedInfo($documentDigest, $kInfoDigest, $SignedPropertiesDigest)
    {
        // version canonicalizada no es necesario volver a hacerlo
        return '<ds:SignedInfo>' .
            '<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></ds:CanonicalizationMethod>' .
            '<ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"></ds:SignatureMethod>' .
            '<ds:Reference Id="' . $this->Reference0Id . '" URI="">' .
            '<ds:Transforms><ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></ds:Transform></ds:Transforms>' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $documentDigest . '</ds:DigestValue>' .
            '</ds:Reference>' .
            '<ds:Reference URI="#' . $this->KeyInfoId . '">' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $kInfoDigest . '</ds:DigestValue>' .
            '</ds:Reference>' .
            '<ds:Reference Type="http://uri.etsi.org/01903#SignedProperties" URI="#' . $this->SignedPropertiesId . '">' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $SignedPropertiesDigest . '</ds:DigestValue>' .
            '</ds:Reference>' .
            '</ds:SignedInfo>';
    }

    public function getIssuer($issuer)
    {
        $certIssuer = array();
        foreach ($issuer as $item => $value) {
            $certIssuer[] = $item . '=' . $value;
        }
        $certIssuer = implode(', ', array_reverse($certIssuer));
        return $certIssuer;
    }

    public function getCertificate()
    {
        openssl_x509_export($this->publicKey, $publicPEM);
        $publicPEM = str_replace("-----BEGIN CERTIFICATE-----", "", $publicPEM);
        $publicPEM = str_replace("-----END CERTIFICATE-----", "", $publicPEM);
        $publicPEM = str_replace("\r", "", str_replace("\n", "", $publicPEM));
        return $publicPEM;
    }

    public function insertaFirma($xml, $doctype)
    {
        //antes linearizar es decir borrar saltos de linea y retorno de carros
        $xml = str_replace("\r", "", str_replace("\n", "", $xml));
        $xml = str_replace('&', '&amp;', $xml);
        //canoniza todo el documento  para el digest

        $d = new DOMDocument('1.0', 'UTF-8');
        $d->preserveWhiteSpace = true;
        $d->loadXML($xml);
        $canonicalXML = $d->C14N(false, false, null, null);
        $documentDigest = base64_encode(hash('sha256', $canonicalXML, true));

        $signTime = date('Y-m-d\TH:i:s-05:00');


        $certData   = openssl_x509_parse($this->publicKey);
        $certDigest = base64_encode(openssl_x509_fingerprint($this->publicKey, "sha256", true));
        if ($doctype == 'nc') {
            $certSerialNumber = intval($certData['serialNumber']);
        } else {
            $certSerialNumber = $certData['serialNumber'];
        }
        $certIssuer = $this->getIssuer($certData['issuer']);

        $SignedProperties = $this->generateSignedProperties($signTime, $certDigest, $certIssuer, $certSerialNumber);
        $SignedPropertiesWithSchemas = str_replace('<xades:SignedProperties', '<xades:SignedProperties ' . $this->get_schemas($doctype), $SignedProperties);
        $SignedPropertiesDigest = $this->base64Encode($SignedPropertiesWithSchemas);

        $KeyInfo = $this->getKeyInfo();
        $keyInfoWithShemas = str_replace('<ds:KeyInfo', '<ds:KeyInfo ' . $this->get_schemas($doctype), $KeyInfo);
        $kInfoDigest = $this->base64Encode($keyInfoWithShemas);

        $signedInfo = $this->getSignedInfo($documentDigest, $kInfoDigest, $SignedPropertiesDigest);
        $SignedInfoWithSchemas = str_replace('<ds:SignedInfo', '<ds:SignedInfo ' . $this->get_schemas($doctype), $signedInfo);

        $algo = "SHA256";
        openssl_sign($SignedInfoWithSchemas, $signatureResult, $this->privateKey, $algo);
        $signatureResult = base64_encode($signatureResult);


        $s = '<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Id="' . $this->signatureID . '">' . $signedInfo . '<ds:SignatureValue>' . $signatureResult . '</ds:SignatureValue>' . $KeyInfo . '<ds:Object><xades:QualifyingProperties Target="#' . $this->signatureID . '">' . $SignedProperties . '</xades:QualifyingProperties></ds:Object></ds:Signature>';

        /*$search = '<ext:ExtensionContent></ext:ExtensionContent>';
        $replace = '<ext:ExtensionContent>' . $s . "</ext:ExtensionContent>";
        $signed = str_replace($search, $replace, $canonicalXML);
        return $signed;*/
        $buscar    = '<ext:ExtensionContent></ext:ExtensionContent>';
        $remplazar = "<ext:ExtensionContent>" . $s . "</ext:ExtensionContent>";
        $pos       = strrpos($canonicalXML, $buscar);
        if ($pos !== false) {
            $xml = substr_replace($canonicalXML, $remplazar, $pos, strlen($buscar));
        }

        return $xml;
    }
    /**
     * firmar2
     * Se encarga de gestionar la solicitud de firma para la factura electrónica
     * segun documentación anexo técnico en la versión 1.8
     * @access public
     * @param string
     * Ruta del certificado de firma electrónica.
     * @param string 
     * Contraseña del certificado de firma electrónica.
     * @param string 
     * xml sin firma.
     * @param string
     * xml firmado (No usado).
     * @return string
     * 
     */
    public function firmar2($certificadop12, $clavecertificado, $xmlsinfirma, $xmlfirmado = false)
    {
        //Se define y se valida la variable $pfx con el contenido del certificado de firma.
        if (!$pfx = file_get_contents($certificadop12)) {
            echo "Error: No se puede leer el fichero del certificado o no existe en la ruta especificada\n";
            exit;
        }
        //Se definen y se validan variables con la información del certificado
        if (openssl_pkcs12_read($pfx, $key, $clavecertificado)) {
            $publicKey    = $key["cert"];
            $privateKey   = $key["pkey"];
            $cerINTERMEDIO = '';
            $cerROOT = "";
            if (isset($key["extracerts"][1])) {
                $cerROOT      = $key["extracerts"][1];
            }
            $publicPEM     = "";
            openssl_x509_export($publicKey, $publicPEM);
            $publicPEM = str_replace("\r", "", str_replace("\n", "", str_replace("-----END CERTIFICATE-----", "", str_replace("-----BEGIN CERTIFICATE-----", "", $publicPEM))));
        } else {
            echo "Error: No se puede leer el almacén de certificados o la clave no es la correcta.\n";
            exit;
        }
        //Pólitica de firma
        $signPolicy = array(
            "name"         => "Política de firma para facturas electrónicas de la República de Colombia",
            "url"         => "https://facturaelectronica.dian.gov.co/politicadefirma/v2/politicadefirmav2.pdf",
            "digest"     => "dMoMvtcG5aIzgYo0tIsSQeVJBDnUnfSOfBpxXrmor0Y=" //digest en sha1 y base64
        );
        //Id de firma
        $signatureID = "ab2df1fb-1819-413d-8b8c-79e9ed75638a"; //valor fijo del ID favor no alterar esta linea sin permiso expreso del autor
        //$xmlTemp = file_get_contents($xmlsinfirma);
        //acá se inserta la firma, se definen los espacios de nombre y nodos a usar
        $xmlTemp = $this->insertaFirma2($xmlsinfirma, $publicKey, $privateKey, $cerINTERMEDIO, $cerROOT, $publicPEM, $signatureID, $signPolicy);
        //Acá retorna el xml firmado
        return $xmlTemp;
    }

    /**
     * insertarFirma2
     * Este método se encarga de insertar la firma a la factura en formato xml
     * @access public
     */
    public function insertaFirma2($xml, $publicKey, $privateKey, $cerINTERMEDIO, $cerROOT, $publicPEM, $signatureID, $signPolicy)
    {
        if (is_null($publicKey) || is_null($privateKey)) return $xml;
        //antes linearizar es decir borrar saltos de linea y retorno de carros
        $xml = str_replace("\r", "", str_replace("\n", "", $xml));
        //canoniza todo el documento  para el digest
        $d = new DOMDocument('1.0');
        $d->preserveWhiteSpace = true;
        $d->loadXML($xml);
        $canonizadoreal = $d->C14N(false, false, null, null);

        $documentDigest = base64_encode(hash('sha256', $canonizadoreal, true)); //EL digest de todo el documento 
        $tipodoc = "Invoice"; //por defecto

        $tipodoc1 = $this->STREXTRACT($xml, '<CreditNote', '</CreditNote>');
        if (strlen($tipodoc1) >= "1") {
            $tipodoc = "CreditNote";
        }

        $tipodoc1 = $this->STREXTRACT($xml, '<DebitNote', '</DebitNote>');
        if (strlen($tipodoc1) >= "1") {
            $tipodoc = "DebitNote";
        }



        //////////////////// Definir los namespace para los diferentes nodos se puede apreciar que en esta version es igual para todos
        $xmlns_keyinfo = 'xmlns="urn:oasis:names:specification:ubl:schema:xsd:' . $tipodoc . '-2" ' .
            'xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" ' .
            'xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" ' .
            'xmlns:ds="http://www.w3.org/2000/09/xmldsig#" ' .
            'xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" ' .
            'xmlns:sts="urn:dian:gov:co:facturaelectronica:Structures-2-1" ' .
            'xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" ' .
            'xmlns:xades141="http://uri.etsi.org/01903/v1.4.1#" ' .
            'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';

        $xmnls_signedprops = 'xmlns="urn:oasis:names:specification:ubl:schema:xsd:' . $tipodoc . '-2" ' .
            'xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" ' .
            'xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" ' .
            'xmlns:ds="http://www.w3.org/2000/09/xmldsig#" ' .
            'xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" ' .
            'xmlns:sts="urn:dian:gov:co:facturaelectronica:Structures-2-1" ' .
            'xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" ' .
            'xmlns:xades141="http://uri.etsi.org/01903/v1.4.1#" ' .
            'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';

        $xmnls_signeg = 'xmlns="urn:oasis:names:specification:ubl:schema:xsd:' . $tipodoc . '-2" ' .
            'xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" ' .
            'xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" ' .
            'xmlns:ds="http://www.w3.org/2000/09/xmldsig#" ' .
            'xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" ' .
            'xmlns:sts="urn:dian:gov:co:facturaelectronica:Structures-2-1" ' .
            'xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" ' .
            'xmlns:xades141="http://uri.etsi.org/01903/v1.4.1#" ' .
            'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';



        //date_default_timezone_set("America/Bogota");
        //$signTime1='2019-06-20T15:15:15.000-05:00';
        $signTime1 = date('Y-m-d\TH:i:s.vT:00');

        $certData   = openssl_x509_parse($publicKey);
        $certDigest = openssl_x509_fingerprint($publicKey, "sha256", true);
        $certDigest = base64_encode($certDigest);


        $certIssuer = array();
        foreach ($certData['issuer'] as $item => $value) {
            $certIssuer[] = $item . '=' . $value;
        }
        $certIssuer = implode(',', array_reverse($certIssuer));
        $issuerNameexternoC = $certIssuer;
        $prop = '<xades:SignedProperties Id="xmldsig-' . $signatureID .  '-signedprops">' .
            '<xades:SignedSignatureProperties>' .
            '<xades:SigningTime>' .  $signTime1 . '</xades:SigningTime>' .
            '<xades:SigningCertificate>' .
            '<xades:Cert>' .
            '<xades:CertDigest>' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $certDigest . '</ds:DigestValue>' .
            '</xades:CertDigest>' .
            '<xades:IssuerSerial>' .
            '<ds:X509IssuerName>'   . $issuerNameexternoC       . '</ds:X509IssuerName>' .
            '<ds:X509SerialNumber>' . substr($certData['serialNumber'], 1, 24) . '</ds:X509SerialNumber>' .
            '</xades:IssuerSerial>' .
            '</xades:Cert>' .
            '</xades:SigningCertificate>' .
            '<xades:SignaturePolicyIdentifier><xades:SignaturePolicyId>' .
            '<xades:SigPolicyId><xades:Identifier>' . $signPolicy['url'] .
            '</xades:Identifier></xades:SigPolicyId><xades:SigPolicyHash>' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $signPolicy['digest'] .
            '</ds:DigestValue></xades:SigPolicyHash></xades:SignaturePolicyId>' .
            '</xades:SignaturePolicyIdentifier><xades:SignerRole>' .
            '<xades:ClaimedRoles><xades:ClaimedRole>supplier</xades:ClaimedRole>' .
            '</xades:ClaimedRoles></xades:SignerRole>' .
            '</xades:SignedSignatureProperties></xades:SignedProperties>';
        // Preparar el KeyInfo
        $kInfo =
            '<ds:KeyInfo Id="KeyInfo">' .
            '<ds:X509Data>'  .
            '<ds:X509Certificate>' . $publicPEM  . '</ds:X509Certificate>' .
            '</ds:X509Data>' .
            '</ds:KeyInfo>';
        $keyinfo_para_hash1 = str_replace('<ds:KeyInfo', '<ds:KeyInfo ' . $xmlns_keyinfo, $kInfo);

        //$kInfoDigest=retC14DigestSha256($keyinfo_para_hash1);
        $kInfoDigest = "";
        $DomDocuI = new DOMDocument('1.0', 'UTF-8');
        $DomDocuI->loadXML(str_replace("\r", "", str_replace("\n", "", $keyinfo_para_hash1)));
        //$kInfoDigest= base64_encode(hash('sha256',$DomDocuI->C14N(), true));
        $kInfoDigest = base64_encode(hash('sha256', $keyinfo_para_hash1, true));

        $aconop = str_replace('<xades:SignedProperties', '<xades:SignedProperties ' . $xmnls_signedprops, $prop);
        $propDigest = "";
        $DomDocuP = new DOMDocument('1.0', 'UTF-8');
        $DomDocuP->loadXML(str_replace("\r", "", str_replace("\n", "", $aconop)));
        //$propDigest= base64_encode(hash('sha256',$DomDocuP->C14N(false,false), true));
        $propDigest = base64_encode(hash('sha256', $aconop, true));

        // Prepare signed info
        $sInfo = "";
        $sInfo = '<ds:SignedInfo>' .
            '<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></ds:CanonicalizationMethod>' .
            '<ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"></ds:SignatureMethod>' .
            '<ds:Reference Id="xmldsig-' . $signatureID . '-ref0" URI="">' .
            '<ds:Transforms>' .
            '<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></ds:Transform>' .
            '</ds:Transforms>' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $documentDigest . '</ds:DigestValue>' .
            '</ds:Reference>' .
            '<ds:Reference Id="xmldsig-' .  $signatureID . '-ref1" URI="#KeyInfo">' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $kInfoDigest . '</ds:DigestValue>' .
            '</ds:Reference>' .
            '<ds:Reference Type="http://uri.etsi.org/01903#SignedProperties" URI="#xmldsig-' . $signatureID . '-signedprops">' .
            '<ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></ds:DigestMethod>' .
            '<ds:DigestValue>' . $propDigest . '</ds:DigestValue>' .
            '</ds:Reference>' .
            '</ds:SignedInfo>';

        $signaturePayload = str_replace('<ds:SignedInfo', '<ds:SignedInfo ' . $xmnls_signeg, $sInfo);

        //file_put_contents("signaturePayloadantes.xml" , $signaturePayload);	

        $d1p = new DOMDocument('1.0', 'UTF-8');
        $d1p->loadXML($signaturePayload);
        $signaturePayload = $d1p->C14N(false, false, null, null);
        //file_put_contents("signaturePayloaddespues.xml" , $signaturePayload);	
        $resultadodefirma = "";
        openssl_sign($signaturePayload, $resultadodefirma, $privateKey, 'sha256WithRSAEncryption');

        $resultadodefirma = base64_encode($resultadodefirma);

        //Armamos toda la estructura de la firma
        $sig = '<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Id="xmldsig-' . $signatureID . '">' .
            $sInfo .
            '<ds:SignatureValue Id="xmldsig-' . $signatureID . '-sigvalue">' .
            $resultadodefirma .  '</ds:SignatureValue>'  . $kInfo .
            '<ds:Object><xades:QualifyingProperties xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" xmlns:xades141="http://uri.etsi.org/01903/v1.4.1#"' .
            ' Target="#xmldsig-' . $signatureID . '">' . $prop .
            '</xades:QualifyingProperties></ds:Object></ds:Signature>';

        $buscar = '<ext:ExtensionContent></ext:ExtensionContent>';
        $remplazar = '<ext:ExtensionContent>' . $sig . '</ext:ExtensionContent>';
        $pos = strrpos($xml, $buscar);
        if ($pos !== false) {
            $xml = substr_replace($xml, $remplazar, $pos, strlen($buscar));
        }
        return $xml;
    }

    public function STREXTRACT($CadenaOrigen, $CadenaIni, $CadenaFin)
    {
        $posIni = strrpos($CadenaOrigen, $CadenaIni);
        $posFin = strrpos($CadenaOrigen, $CadenaFin);
        if ($posIni !== false) {
            $xml = substr($CadenaOrigen, $posIni + strlen($CadenaIni), $posFin - $posIni - strlen($CadenaIni));
        } else {
            $xml = "";
        }
        return $xml;
    }
}
