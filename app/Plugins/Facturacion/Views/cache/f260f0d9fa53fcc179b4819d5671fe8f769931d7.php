<cac:BillingReference>
    <cac:InvoiceDocumentReference>
        <cbc:ID><?php echo e($invoice->Invoice()->first()->prefijo.$invoice->Invoice()->first()->numero2); ?></cbc:ID>
        <cbc:UUID schemeName="CUFE-SHA384"><?php echo e($invoice->Invoice()->first()->cufedian); ?></cbc:UUID>
        <cbc:IssueDate><?php echo e(explode("|",$invoice->Invoice()->first()->fecha_hora_dian)[0]); ?></cbc:IssueDate>
    </cac:InvoiceDocumentReference>
</cac:BillingReference>
<?php /**PATH /var/www/html/GTEP/app/Plugins/Facturacion/Views/xml/_billing_reference.blade.php ENDPATH**/ ?>