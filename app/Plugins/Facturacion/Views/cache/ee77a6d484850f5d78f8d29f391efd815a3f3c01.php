<?php
$counterLine = 1;
//print_debug($invoice->toArray())
?>

<?php if($invoice->totaldto != 0 && $invoice->prefijo != "ND"): ?>
<cac:AllowanceCharge>
    <cbc:ID><?php echo e($counterLine++); ?></cbc:ID>
    <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
    <cbc:AllowanceChargeReasonCode>11</cbc:AllowanceChargeReasonCode>
    <?php if($invoice->observaciones != ""): ?>
    <cbc:AllowanceChargeReason><?php echo e($invoice->observaciones); ?></cbc:AllowanceChargeReason>
    <?php endif; ?>
    <cbc:MultiplierFactorNumeric>0.00</cbc:MultiplierFactorNumeric>
    <cbc:Amount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>">0.00</cbc:Amount>
    <cbc:BaseAmount currencyID="<?php echo e($invoice->Client()->first()->coddivisa); ?>">0.00</cbc:BaseAmount>
</cac:AllowanceCharge>
<?php endif; ?>

<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml/_allowance_charges.blade.php ENDPATH**/ ?>