<?php $__currentLoopData = $invoice->lines()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$counterLine = 1;
$diference = $value['recargo'] - $value['dtopor'];
?>
    <cac:CreditNoteLine>
        <cbc:ID><?php echo e(($key + 1)); ?></cbc:ID>
        <cbc:CreditedQuantity unitCode="NIU"><?php echo e(number_format($value['cantidad'], 2, '.', '')); ?></cbc:CreditedQuantity>
        <cbc:LineExtensionAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['neto'], 2, '.', '')); ?></cbc:LineExtensionAmount>
          
         <cac:TaxTotal>
            <cbc:TaxAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['iva'],2, '.', '')); ?></cbc:TaxAmount>
            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['neto'], 2, '.', '')); ?></cbc:TaxableAmount>
                <cbc:TaxAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['iva'], 2, '.', '')); ?></cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent><?php echo e(number_format(($value['iva']/$value['neto'])*100, 2, '.','')); ?></cbc:Percent>
                    <cac:TaxScheme>
                        <cbc:ID>01</cbc:ID>
                        <cbc:Name>IVA</cbc:Name>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        </cac:TaxTotal> 
        <?php if($diference > 0): ?>
        <cac:AllowanceCharge>
            <cbc:ID><?php echo e($counterLine++); ?></cbc:ID>
            <cbc:ChargeIndicator>true</cbc:ChargeIndicator>
            <cbc:AllowanceChargeReason><?php echo e($invoice->observaciones); ?></cbc:AllowanceChargeReason>
            <cbc:MultiplierFactorNumeric><?php echo e(number_format(($diference / $value['pvpsindto']) * 100 ,2, '.', '')); ?></cbc:MultiplierFactorNumeric>
            <cbc:Amount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($diference, 2, '.', '')); ?></cbc:Amount>
            <cbc:BaseAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['pvpsindto'], 2, '.', '')); ?></cbc:BaseAmount>
        </cac:AllowanceCharge>
        <?php elseif($diference < 0): ?> <cac:AllowanceCharge>
            <cbc:ID><?php echo e($counterLine++); ?></cbc:ID>
            <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
            <cbc:AllowanceChargeReasonCode>11</cbc:AllowanceChargeReasonCode>
            <cbc:AllowanceChargeReason><?php echo e($invoice->observaciones); ?></cbc:AllowanceChargeReason>
            <cbc:MultiplierFactorNumeric><?php echo e(number_format((abs($diference) / $value['pvpsindto']) * 100 ,2, '.', '')); ?></cbc:MultiplierFactorNumeric>
            <cbc:Amount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format(abs($diference), 2, '.', '')); ?></cbc:Amount>
            <cbc:BaseAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['pvpsindto'] , 2, '.', '')); ?></cbc:BaseAmount>
            </cac:AllowanceCharge>
        <?php endif; ?>
            <cac:Item>
                <cbc:Description><?php echo e($value['descripcion']); ?></cbc:Description>
                <?php if($value['referencia'] != NULL): ?>
                <cac:SellersItemIdentification>
                    <cbc:ID><?php echo e($value['referencia']); ?></cbc:ID>
                </cac:SellersItemIdentification>
                <?php endif; ?>
                <?php if($value['codigo_estandar'] != NULL): ?>
                <cac:StandardItemIdentification>
                    <cbc:ID schemeID="001" schemeName="UNSPSC" schemeAgencyID="10"><?php echo e($value['codigo_estandar']); ?></cbc:ID>
                </cac:StandardItemIdentification>
                <?php endif; ?>
            </cac:Item>
            <cac:Price>
                <cbc:PriceAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['pvpunitario'], 2, '.', '')); ?></cbc:PriceAmount>
                <cbc:BaseQuantity unitCode="NIU"><?php echo e(number_format($value['cantidad'], 2, '.', '')); ?></cbc:BaseQuantity>
            </cac:Price>
    </cac:CreditNoteLine>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml/_credit_note_lines.blade.php ENDPATH**/ ?>