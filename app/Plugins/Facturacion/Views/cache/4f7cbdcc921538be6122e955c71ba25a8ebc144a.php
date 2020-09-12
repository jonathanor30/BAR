<?php if($invoice->totalretencion != null && $invoice->totalretencion != ""): ?>
<cac:WithholdingTaxTotal>
    <cbc:TaxAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($invoice->totalretencion, 2, '.', '')); ?></cbc:TaxAmount>
    <?php $__currentLoopData = $invoice->lines()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($value['retencion'] != NULL): ?>
    <cac:TaxSubtotal>
        <cbc:TaxableAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['neto'], 2, '.', '')); ?></cbc:TaxableAmount>
        <cbc:TaxAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['retencion'], 2, '.', '')); ?></cbc:TaxAmount>
        <cac:TaxCategory>
            <cbc:Percent><?php echo e(number_format(($value['retencion']/$value['neto'])*100, 2, '.','')); ?></cbc:Percent>
            <cac:TaxScheme>
                <cbc:ID>06</cbc:ID>
                <cbc:Name>Retefuente</cbc:Name>
            </cac:TaxScheme>
        </cac:TaxCategory>
    </cac:TaxSubtotal>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</cac:WithholdingTaxTotal>
<?php endif; ?>
<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml/_withholding_tax.blade.php ENDPATH**/ ?>