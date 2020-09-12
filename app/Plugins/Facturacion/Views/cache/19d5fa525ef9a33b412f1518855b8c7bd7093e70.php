<ext:UBLExtensions>
    <ext:UBLExtension>
        <ext:ExtensionContent>
            <sts:DianExtensions>
                <?php if(isset($number_fe)): ?>
                <sts:InvoiceControl>
                    <sts:InvoiceAuthorization><?php echo e($resolution->resolution); ?></sts:InvoiceAuthorization>
                    <sts:AuthorizationPeriod>
                        <cbc:StartDate><?php echo e($resolution->date_from); ?></cbc:StartDate>
                        <cbc:EndDate><?php echo e($resolution->date_to); ?></cbc:EndDate>
                    </sts:AuthorizationPeriod>
                    <sts:AuthorizedInvoices>
                        <?php if($resolution->prefix): ?>
                        <sts:Prefix><?php echo e($resolution->prefix); ?></sts:Prefix>
                        <?php endif; ?>
                        <sts:From><?php echo e($resolution->from_number); ?></sts:From>
                        <sts:To><?php echo e($resolution->to_number); ?></sts:To>
                    </sts:AuthorizedInvoices>
                </sts:InvoiceControl>
                <?php endif; ?>
                <sts:InvoiceSource>
                    <cbc:IdentificationCode listAgencyID="6" listAgencyName="United Nations Economic Commission for Europe" listSchemeURI="urn:oasis:names:specification:ubl:codelist:gc:CountryIdentificationCode-2.1"><?php echo e($company->codigo_pais); ?></cbc:IdentificationCode>
                </sts:InvoiceSource>
                <sts:SoftwareProvider>
                    <sts:ProviderID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" <?php if(count(explode("-",$empresa->nit_empresa))>1): ?> schemeID="<?php echo e(explode("-",$empresa->nit_empresa)[1]); ?>" <?php endif; ?> schemeName="31"><?php echo e(explode("-",$empresa->nit_empresa)[0]); ?></sts:ProviderID>
                    <sts:SoftwareID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)"><?php echo e($company->id_software); ?></sts:SoftwareID>
                </sts:SoftwareProvider>
                <sts:SoftwareSecurityCode schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)"><?php echo e(hash('sha384', $company->id_software . $company->pin_software.$prefix.(isset($number_nc) ? $number_nc : $number_fe))); ?></sts:SoftwareSecurityCode>
                <sts:AuthorizationProvider>
                    <sts:AuthorizationProviderID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)" schemeID="4" schemeName="31">800197268</sts:AuthorizationProviderID>
                </sts:AuthorizationProvider>
                <sts:QRCode><?php echo e($company->Type_E['qr_url'].$cufe); ?></sts:QRCode>
            </sts:DianExtensions>
        </ext:ExtensionContent>
    </ext:UBLExtension>
    
    <ext:UBLExtension>
        <ext:ExtensionContent></ext:ExtensionContent>
    </ext:UBLExtension>
</ext:UBLExtensions>
<?php /**PATH /var/www/html/GTEP/app/Plugins/Facturacion/Views/xml/_ubl_extensions.blade.php ENDPATH**/ ?>