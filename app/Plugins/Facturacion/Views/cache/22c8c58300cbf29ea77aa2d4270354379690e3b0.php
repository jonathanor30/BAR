<cac:ReceiverParty>
    <cac:PartyTaxScheme>
        <cbc:RegistrationName><?php echo e($factura->Client()->first()->nombre); ?></cbc:RegistrationName>
        <?php if($factura->Client()->first()->tipoidfiscal == "NIT"): ?>
            <cbc:CompanyID schemeAgencyID="195" schemeID="<?php echo e($factura->Client()->first()->cifnif_dv); ?>" schemeName="31"><?php echo e($factura->Client()->first()->cifnif); ?></cbc:CompanyID>
            <?php else: ?>
            <cbc:CompanyID schemeAgencyID="195" schemeName="13"><?php echo e($factura->Client()->first()->cifnif); ?></cbc:CompanyID>
            <?php endif; ?>
            <cbc:TaxLevelCode listName="<?php echo e(($factura->Client()->first()->regimeniva == 1 ? 48 : 49)); ?>"><?php echo e(substr($factura->Client()->first()->responsabilidades,0,-1)); ?></cbc:TaxLevelCode>
            <?php if($factura->Client()->first()->regimeniva == 1): ?>
            <cac:TaxScheme>
                <cbc:ID><?php echo e(($factura->Client()->first()->regimeniva == 1 ? "01" : "XY")); ?></cbc:ID>
                <cbc:Name><?php echo e(($factura->Client()->first()->regimeniva == 1 ? "IVA" : "No causa")); ?></cbc:Name>
            </cac:TaxScheme>
            <?php endif; ?>
    </cac:PartyTaxScheme>
</cac:ReceiverParty>
<?php /**PATH /var/www/html/GTEP/app/Plugins/Facturacion/Views/xml_attach/_receiver_party.blade.php ENDPATH**/ ?>