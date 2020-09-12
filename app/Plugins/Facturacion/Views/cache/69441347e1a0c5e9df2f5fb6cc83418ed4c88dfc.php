<cac:TaxTotal>
    <cbc:TaxAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($invoice->totaliva, 2, '.', '')); ?></cbc:TaxAmount>
    <?php $__currentLoopData = $invoice->lines()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <cac:TaxSubtotal>
        <cbc:TaxableAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['neto'], 2, '.', '')); ?></cbc:TaxableAmount>
        <cbc:TaxAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['iva'], 2, '.', '')); ?></cbc:TaxAmount>
        <cbc:BaseUnitMeasure unitCode="NIU"><?php echo e(number_format($value['cantidad'], 2, '.', '')); ?></cbc:BaseUnitMeasure>
        <cbc:PerUnitAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($value['iva']/$value['cantidad'], 2, '.', '')); ?></cbc:PerUnitAmount>
        <cac:TaxCategory>
            <cbc:Percent><?php echo e(number_format(($value['iva']/($value['neto']))*100, 2, '.','')); ?></cbc:Percent>
            <cac:TaxScheme>
                <cbc:ID>01</cbc:ID>
                <cbc:Name>IVA</cbc:Name>
            </cac:TaxScheme>
        </cac:TaxCategory>
    </cac:TaxSubtotal>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</cac:TaxTotal>

<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml/_tax_totals.blade.php ENDPATH**/ ?>