<cac:<?php echo e($node); ?>>
    <cbc:LineExtensionAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($invoice->lines()->sum("neto"), 2, '.', '')); ?></cbc:LineExtensionAmount>
    <cbc:TaxExclusiveAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($invoice->lines()->sum("neto"), 2, '.', '')); ?></cbc:TaxExclusiveAmount>
    <cbc:TaxInclusiveAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($invoice->lines()->sum("neto") + $invoice->lines()->sum("iva"), 2, '.', '')); ?></cbc:TaxInclusiveAmount>
    <cbc:AllowanceTotalAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>">0.00</cbc:AllowanceTotalAmount>
    <cbc:ChargeTotalAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>">0.00</cbc:ChargeTotalAmount>
    <?php if($invoice->prepaids != NULL && $invoice->prepaids()->sum('importe') < $invoice->total && $invoice->prepaids_count > 0 && $invoice->prefijo != "NC" && $invoice->prefijo != "ND"): ?>
    <cbc:PrepaidAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($invoice->prepaids()->sum('importe'), 2, '.', '')); ?></cbc:PrepaidAmount>
    <cbc:PayableAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($invoice->lines()->sum("neto") + $invoice->lines()->sum("iva") - ($invoice->prepaids()->sum('importe')!=NULL && isset($number_fe) ?$invoice->prepaids()->sum('importe'): 0), 2, '.', '')); ?></cbc:PayableAmount>
    <?php else: ?>
    <cbc:PayableAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($invoice->lines()->sum("neto") + $invoice->lines()->sum("iva"), 2, '.', '')); ?></cbc:PayableAmount>
    <?php endif; ?>
</cac:<?php echo e($node); ?>>
<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml/_legal_monetary_total.blade.php ENDPATH**/ ?>