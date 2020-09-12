<?xml version="1.0" encoding="UTF-8"?>
<ApplicationResponse xmlns="urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:sts="dian:gov:co:facturaelectronica:Structures-2-1">
   <ext:UBLExtensions>
      <ext:UBLExtension>
         <ext:ExtensionContent>
            <sts:DianExtensions>
                <sts:InvoiceSource>
                    <cbc:IdentificationCode listAgencyID="6" listAgencyName="United Nations Economic Commission for Europe" listSchemeURI="urn:oasis:names:specification:ubl:codelist:gc:CountryIdentificationCode-2.1"><?php echo e($company->codigo_pais); ?></cbc:IdentificationCode>
                </sts:InvoiceSource>
                <sts:SoftwareProvider>
                    <sts:ProviderID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" <?php if(count(explode('-', $empresa->nit_empresa)) > 1): ?> schemeID="<?php echo e(explode('-', $empresa->nit_empresa)[1]); ?>" <?php endif; ?> schemeName="31"><?php echo e(explode('-', $empresa->nit_empresa)[0]); ?></sts:ProviderID>
                    <sts:SoftwareID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)"><?php echo e($company->id_software); ?></sts:SoftwareID>
                </sts:SoftwareProvider>
                <sts:SoftwareSecurityCode schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)"><?php echo e(hash('sha384', $company->id_software . $company->pin_software . $factura->prefix . $factura->numero2)); ?></sts:SoftwareSecurityCode>
                <sts:AuthorizationProvider>
                    <sts:AuthorizationProviderID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeID="4" schemeName="31">800197268</sts:AuthorizationProviderID>
                </sts:AuthorizationProvider>
            </sts:DianExtensions>
         </ext:ExtensionContent>
      </ext:UBLExtension>
      <ext:UBLExtension>
         <ext:ExtensionContent></ext:ExtensionContent>
      </ext:UBLExtension>
   </ext:UBLExtensions>
   <cbc:UBLVersionID>UBL 2.1</cbc:UBLVersionID>
   <cbc:CustomizationID>1</cbc:CustomizationID>
   <cbc:ProfileID>DIAN 2.1</cbc:ProfileID>
   <cbc:ProfileExecutionID><?php echo e($company->tipo_ambiente); ?></cbc:ProfileExecutionID>
   <cbc:ID><?php echo e($factura->numero2); ?></cbc:ID>
<cbc:UUID schemeName="CUDE-SHA384"><?php echo e($factura->cufedian); ?></cbc:UUID>
   <cbc:IssueDate><?php echo e(explode('|', $factura->fecha_hora_dian)[0]); ?></cbc:IssueDate>
   <cbc:IssueTime><?php echo e(explode('|', $factura->fecha_hora_dian)[1]); ?></cbc:IssueTime>
   <cac:SenderParty>
    <cac:PartyTaxScheme>
        <cbc:RegistrationName><?php echo e($company->tipo_empresa); ?></cbc:RegistrationName>
        <cbc:CompanyID schemeAgencyID="195" schemeID="<?php echo e(explode('-', $empresa->nit_empresa)[1]); ?>" schemeName="31"><?php echo e(explode('-', $empresa->nit_empresa)[0]); ?></cbc:CompanyID>
        <cbc:TaxLevelCode listName="<?php echo e($company->tipo_regimen == 'COMUN' ? 48 : 49); ?>"><?php echo e(substr($company->responsabilidades, 0, -1)); ?></cbc:TaxLevelCode>
        <cac:TaxScheme>
            <cbc:ID>01</cbc:ID>
            <cbc:Name>IVA</cbc:Name>
        </cac:TaxScheme>
    </cac:PartyTaxScheme>
</cac:SenderParty>
<cac:ReceiverParty>
    <cac:PartyTaxScheme>
        <cbc:RegistrationName><?php echo e($factura->Client()->first()->nombre); ?></cbc:RegistrationName>
        <?php if($factura->Client()->first()->tipoidfiscal == 'NIT'): ?>
            <cbc:CompanyID schemeAgencyID="195" schemeID="<?php echo e($factura->Client()->first()->cifnif_dv); ?>" schemeName="31"><?php echo e($factura->Client()->first()->cifnif); ?></cbc:CompanyID>
    <?php else: ?>
            <cbc:CompanyID schemeAgencyID="195" schemeName="13"><?php echo e($factura->Client()->first()->cifnif); ?></cbc:CompanyID>
            <?php endif; ?>
            <cbc:TaxLevelCode listName="<?php echo e($factura->Client()->first()->regimeniva == 1 ? 48 : 49); ?>"><?php echo e(substr($factura->Client()->first()->responsabilidades, 0, -1)); ?></cbc:TaxLevelCode>
            <?php if($factura->Client()->first()->regimeniva == 1): ?>
            <cac:TaxScheme>
                <cbc:ID><?php echo e($factura->Client()->first()->regimeniva == 1 ? '01' : 'XY'); ?></cbc:ID>
                <cbc:Name><?php echo e($factura->Client()->first()->regimeniva == 1 ? 'IVA' : 'No causa'); ?></cbc:Name>
            </cac:TaxScheme>
            <?php endif; ?>
    </cac:PartyTaxScheme>
</cac:ReceiverParty>
   <cac:DocumentResponse>
      <cac:Response>
         <cbc:ResponseCode>02</cbc:ResponseCode>
         <cbc:Description>Documento validado por la DIAN</cbc:Description>
      </cac:Response>
      <cac:DocumentReference>
         <cbc:ID><?php echo e($factura->prefijo . $factura->numero2); ?></cbc:ID>
         <cbc:UUID schemeName="CUFE-SHA384"><?php echo e($factura->cufedian); ?></cbc:UUID>
      </cac:DocumentReference>
      <cac:LineResponse>
         <cac:LineReference>
            <cbc:LineID>1</cbc:LineID>
         </cac:LineReference>
         <cac:Response>
            <cbc:ResponseCode>0000</cbc:ResponseCode>
            <cbc:Description>0</cbc:Description>
         </cac:Response>
      </cac:LineResponse>
      <cac:LineResponse>
         <cac:LineReference>
            <cbc:LineID>2</cbc:LineID>
         </cac:LineReference>
         <cac:Response>
            <cbc:ResponseCode>0</cbc:ResponseCode>
            <cbc:Description>La Factura electrónica <?php echo e($factura->prefijo . '-' . $factura->numero2); ?>, ha sido autorizada.</cbc:Description>
         </cac:Response>
      </cac:LineResponse>
   </cac:DocumentResponse>
</ApplicationResponse>
<?php /**PATH /var/www/html/GTEP/app/Plugins/Facturacion/Views/xml_appResponse/01.blade.php ENDPATH**/ ?>