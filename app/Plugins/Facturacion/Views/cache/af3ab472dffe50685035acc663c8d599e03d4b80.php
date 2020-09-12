<cac:SenderParty>
    <cac:PartyTaxScheme>
        <cbc:RegistrationName><?php echo e($company->tipo_empresa); ?></cbc:RegistrationName>
        <cbc:CompanyID schemeAgencyID="195" schemeID="<?php echo e(explode("-",$empresa->nit_empresa)[1]); ?>" schemeName="31"><?php echo e(explode("-",$empresa->nit_empresa)[0]); ?></cbc:CompanyID>
        <cbc:TaxLevelCode listName="<?php echo e(($company->tipo_regimen == "COMUN" ? 48 : 49)); ?>"><?php echo e(substr($company->responsabilidades, 0, -1)); ?></cbc:TaxLevelCode>
        <cac:TaxScheme>
            <cbc:ID>01</cbc:ID>
            <cbc:Name>IVA</cbc:Name>
        </cac:TaxScheme>
    </cac:PartyTaxScheme>
</cac:SenderParty>
<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml_attach/_sender_party.blade.php ENDPATH**/ ?>