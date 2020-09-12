<cac:<?php echo e($node); ?>>
    <cbc:AdditionalAccountID><?php echo e($invoice->Client()->first()->tipo_organizacion); ?></cbc:AdditionalAccountID>
    <cac:Party>
        <?php if($invoice->Client()->first()->tipo_organizacion == 2): ?>
        <cac:PartyIdentification>
            <?php if($invoice->Client()->first()->tipoidfiscal == "NIT"): ?>
            <cbc:ID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeID="<?php echo e($invoice->Client()->first()->cifnif_dv); ?>" schemeName="31"><?php echo e($invoice->Client()->first()->cifnif); ?></cbc:ID>
            <?php else: ?>
            <cbc:ID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeName="13"}}><?php echo e($invoice->Client()->first()->cifnif); ?></cbc:ID>
            <?php endif; ?>
        </cac:PartyIdentification>
        <?php endif; ?>
        <cac:PartyName>
            <cbc:Name><?php echo e($invoice->Client()->first()->nombre); ?></cbc:Name>
        </cac:PartyName>
        <?php if(isset($supplier)): ?>
        <cac:PhysicalLocation>
            <cac:Address>
                <cbc:ID><?php echo e($invoice->Client()->first()->codigo_departamento.$invoice->Client()->first()->codigo_municipio); ?></cbc:ID>
                <cbc:CityName><?php echo e($invoice->Client()->first()->ciudad); ?></cbc:CityName>
                <cbc:CountrySubentity><?php echo e($invoice->Client()->first()->departamento); ?></cbc:CountrySubentity>
                <cbc:CountrySubentityCode><?php echo e($invoice->Client()->first()->codigo_departamento); ?></cbc:CountrySubentityCode>
                <cac:AddressLine>
                    <cbc:Line><?php echo e($invoice->Client()->first()->direccion); ?></cbc:Line>
                </cac:AddressLine>
                <cac:Country>
                    <cbc:IdentificationCode><?php echo e($invoice->Client()->first()->pais); ?></cbc:IdentificationCode>
                    <cbc:Name languageID="es"><?php echo e($invoice->Client()->first()->Country()->first()->nombre); ?></cbc:Name>
                </cac:Country>
            </cac:Address>
        </cac:PhysicalLocation>
        <?php endif; ?>
        <cac:PartyTaxScheme>
            <cbc:RegistrationName><?php echo e($invoice->Client()->first()->nombre); ?></cbc:RegistrationName>
            <?php if($invoice->Client()->first()->tipoidfiscal == "NIT"): ?>
            <cbc:CompanyID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeID="<?php echo e($invoice->Client()->first()->cifnif_dv); ?>" schemeName="31"><?php echo e($invoice->Client()->first()->cifnif); ?></cbc:CompanyID>
            <?php else: ?>
            <cbc:CompanyID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeName="13"><?php echo e($invoice->Client()->first()->cifnif); ?></cbc:CompanyID>
            <?php endif; ?>
            <cbc:TaxLevelCode listName="<?php echo e(($invoice->Client()->first()->regimeniva == 1 ? 48 : 49)); ?>"><?php echo e(substr($invoice->Client()->first()->responsabilidades,0,-1)); ?></cbc:TaxLevelCode>
            <cac:RegistrationAddress>
                <cbc:ID><?php echo e($invoice->Client()->first()->codigo_departamento.$invoice->Client()->first()->codigo_municipio); ?></cbc:ID>
                <cbc:CityName><?php echo e($invoice->Client()->first()->ciudad); ?></cbc:CityName>
                <cbc:CountrySubentity><?php echo e($invoice->Client()->first()->departamento); ?></cbc:CountrySubentity>
                <cbc:CountrySubentityCode><?php echo e($invoice->Client()->first()->codigo_departamento); ?></cbc:CountrySubentityCode>
                <cac:AddressLine>
                    <cbc:Line><?php echo e($invoice->Client()->first()->direccion); ?></cbc:Line>
                </cac:AddressLine>
                <cac:Country>
                    <cbc:IdentificationCode><?php echo e($invoice->Client()->first()->pais); ?></cbc:IdentificationCode>
                    <cbc:Name languageID="es"><?php echo e($invoice->Client()->first()->Country()->first()->nombre); ?></cbc:Name>
                </cac:Country>
            </cac:RegistrationAddress>
            <?php if($invoice->Client()->first()->regimeniva == 1): ?>
            <cac:TaxScheme>
                <cbc:ID><?php echo e(($invoice->Client()->first()->regimeniva == 1 ? "01" : "XY")); ?></cbc:ID>
                <cbc:Name><?php echo e(($invoice->Client()->first()->regimeniva == 1 ? "IVA" : "No causa")); ?></cbc:Name>
            </cac:TaxScheme>
            <?php endif; ?>
        </cac:PartyTaxScheme>
        <cac:PartyLegalEntity>
            <cbc:RegistrationName><?php echo e($invoice->Client()->first()->nombre); ?></cbc:RegistrationName>
            <?php if($invoice->Client()->first()->tipoidfiscal == "NIT"): ?>
            <cbc:CompanyID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeID="<?php echo e($invoice->Client()->first()->cifnif_dv); ?>" schemeName="31"><?php echo e($invoice->Client()->first()->cifnif); ?></cbc:CompanyID>
            <?php else: ?>
            <cbc:CompanyID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeName="13"><?php echo e($invoice->Client()->first()->cifnif); ?></cbc:CompanyID>
            <?php endif; ?>
            <?php if($invoice->Client()->first()->mercant_register !=NULL): ?>
            <cac:CorporateRegistrationScheme>
                <cbc:Name><?php echo e($invoice->Client()->first()->mercant_register); ?></cbc:Name>
            </cac:CorporateRegistrationScheme>
            <?php endif; ?>
        </cac:PartyLegalEntity>
        <cac:Contact>
            <cbc:Name><?php echo e($invoice->Client()->first()->nombre); ?></cbc:Name>
            <cbc:Telephone><?php echo e($invoice->Client()->first()->telefono1); ?></cbc:Telephone>
            <cbc:ElectronicMail><?php echo e($invoice->Client()->first()->email); ?></cbc:ElectronicMail>
        </cac:Contact>
    </cac:Party>
</cac:<?php echo e($node); ?>>
<?php /**PATH /var/www/html/GTEP/app/Plugins/Facturacion/Views/xml/_accounting_customer.blade.php ENDPATH**/ ?>