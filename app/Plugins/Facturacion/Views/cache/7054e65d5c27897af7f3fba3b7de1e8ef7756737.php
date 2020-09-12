<cac:PaymentMeans>
    <cbc:ID><?php echo e($invoice->fp); ?></cbc:ID>
    <cbc:PaymentMeansCode><?php echo e($invoice->paymentM()->first()->code); ?></cbc:PaymentMeansCode>
    <?php if($invoice->fp == '2'): ?>
    <cbc:PaymentDueDate><?php echo e($invoice->vencimiento); ?></cbc:PaymentDueDate>
    <?php endif; ?>
    <cbc:PaymentID><?php echo e($invoice->fp); ?></cbc:PaymentID>
</cac:PaymentMeans>
<?php if($invoice->prepaids != NULL && $invoice->prepaids()->sum('importe') < $invoice->total && $invoice->prepaids_count > 0 && $invoice->prefijo != "NC" && $invoice->prefijo != "ND"): ?>
<cac:PrepaidPayment>
    <cbc:ID>1</cbc:ID>
    <cbc:PaidAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>"><?php echo e(number_format($invoice->prepaids()->sum('importe'), 2, '.', '')); ?></cbc:PaidAmount>
    <cbc:ReceivedDate><?php echo e($invoice->prepaids()->get()->last()->date_added); ?></cbc:ReceivedDate>
    <cbc:PaidDate><?php echo e($invoice->prepaids()->get()->last()->date_added); ?></cbc:PaidDate>
    <?php if($invoice->prepaids()->get()->last()->observaciones != NULL): ?>
    <cbc:InstructionID><?php echo e($invoice->prepaids()->get()->last()->observaciones); ?></cbc:InstructionID>
    <?php endif; ?>
</cac:PrepaidPayment>
<?php endif; ?>
<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml/_payment_means.blade.php ENDPATH**/ ?>