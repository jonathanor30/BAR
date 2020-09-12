<cac:<?php echo e($node); ?>>
    <cbc:AdditionalAccountID>1</cbc:AdditionalAccountID>
    <cac:Party>
        <cac:PartyName>
            <cbc:Name><?php echo e($company->tipo_empresa); ?></cbc:Name>
        </cac:PartyName>
        <?php if(isset($supplier)): ?>
            <cac:PhysicalLocation>
                <cac:Address>
                    <cbc:ID><?php echo e($company->codigo_municipio); ?></cbc:ID>
                    <cbc:CityName><?php echo e($empresa->ciudad); ?></cbc:CityName>
                    <cbc:CountrySubentity><?php echo e($empresa->estado); ?></cbc:CountrySubentity>
                    <cbc:CountrySubentityCode><?php echo e(substr($company->codigo_municipio, 0, 2)); ?></cbc:CountrySubentityCode>
                    <cac:AddressLine>
                        <cbc:Line><?php echo e($empresa->direccion); ?></cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode><?php echo e($company->codigo_pais); ?></cbc:IdentificationCode>
                        <cbc:Name languageID="es"><?php echo e($company->country->nombre); ?></cbc:Name>
                    </cac:Country>
                </cac:Address>
            </cac:PhysicalLocation>
        <?php endif; ?>
        <cac:PartyTaxScheme>
            <cbc:RegistrationName><?php echo e($company->tipo_empresa); ?></cbc:RegistrationName>
            <cbc:CompanyID schemeAgencyID="195"  schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeID="<?php echo e(explode("-",$empresa->nit_empresa)[1]); ?>" schemeName="31"><?php echo e(explode("-",$empresa->nit_empresa)[0]); ?></cbc:CompanyID>
            <cbc:TaxLevelCode listName="<?php echo e(($company->tipo_regimen == "COMUN" ? 48 : 49)); ?>"><?php echo e(substr($company->responsabilidades, 0, -1)); ?></cbc:TaxLevelCode>
            <cac:RegistrationAddress>
                    <cbc:ID><?php echo e($company->codigo_municipio); ?></cbc:ID>
                    <cbc:CityName><?php echo e($empresa->ciudad); ?></cbc:CityName>
                    <cbc:CountrySubentity><?php echo e($empresa->estado); ?></cbc:CountrySubentity>
                    <cbc:CountrySubentityCode><?php echo e(substr($company->codigo_municipio, 0, 2)); ?></cbc:CountrySubentityCode>
                    <cac:AddressLine>
                        <cbc:Line><?php echo e($empresa->direccion); ?></cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode><?php echo e($company->codigo_pais); ?></cbc:IdentificationCode>
                        <cbc:Name languageID="es"><?php echo e($company->country->nombre); ?></cbc:Name>
                    </cac:Country>
            </cac:RegistrationAddress>
            <cac:TaxScheme>
                <cbc:ID><?php echo e(($company->tipo_regimen == "COMUN" ? "01" : "XY")); ?></cbc:ID>
                <cbc:Name><?php echo e(($company->tipo_regimen == "COMUN" ? "IVA" : "No causa")); ?></cbc:Name>
            </cac:TaxScheme>
        </cac:PartyTaxScheme>
        <cac:PartyLegalEntity>
            <cbc:RegistrationName><?php echo e($company->tipo_empresa); ?></cbc:RegistrationName>
            <cbc:CompanyID schemeAgencyID="195"  schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeID="<?php echo e(explode("-",$empresa->nit_empresa)[1]); ?>" schemeName="31"><?php echo e(explode("-",$empresa->nit_empresa)[0]); ?></cbc:CompanyID>            
            <cac:CorporateRegistrationScheme>
                <?php if(isset($supplier)): ?>
                    <cbc:ID><?php echo e($resolution->prefix); ?></cbc:ID>
                <?php endif; ?>
                <cbc:Name><?php echo e($company->no_matricula); ?></cbc:Name>
            </cac:CorporateRegistrationScheme>
        </cac:PartyLegalEntity>
        <cac:Contact>
            <cbc:Telephone><?php echo e($empresa->telefono); ?></cbc:Telephone>
            <cbc:ElectronicMail><?php echo e($company->userEmail); ?></cbc:ElectronicMail>
        </cac:Contact>
    </cac:Party>
</cac:<?php echo e($node); ?>>

<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml/_accounting.blade.php ENDPATH**/ ?>