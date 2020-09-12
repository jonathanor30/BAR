<?php
$datetime1 = new DateTime(date("Y-m-d", strtotime($invoice->fecha)));

$datetime2 = new DateTime($invoice->vencimiento);

$difference = $datetime1->diff($datetime2);
?>
<?php if($invoice->fp == '2'): ?>
<cac:PaymentTerms>
    <cbc:ReferenceEventCode><?php echo e($invoice->fp); ?></cbc:ReferenceEventCode>
   <cac:SettlementPeriod>
    <cbc:StartDate><?php echo e(date("Y-m-d", strtotime($invoice->fecha))); ?></cbc:StartDate>
    <cbc:StartTime>12:00:00</cbc:StartTime>
    <cbc:EndDate><?php echo e($invoice->vencimiento); ?></cbc:EndDate>
    <cbc:EndTime>12:00:00</cbc:EndTime>
    <cbc:DurationMeasure unitCode="DAY"><?php echo e($difference->d); ?></cbc:DurationMeasure>
    <cbc:DescriptionCode>DAY</cbc:DescriptionCode>
    <cbc:Description>Términos de pago</cbc:Description>
    </cac:SettlementPeriod>
</cac:PaymentTerms>
<?php endif; ?>

<?php /**PATH /var/www/html/GTEP/app/Plugins/Facturacion/Views/xml/_payment_terms.blade.php ENDPATH**/ ?>