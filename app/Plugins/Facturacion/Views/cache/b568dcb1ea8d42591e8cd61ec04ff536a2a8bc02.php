<cac:Attachment>
    <cac:ExternalReference>
        <cbc:MimeCode>text/xml</cbc:MimeCode>
        <cbc:EncodingCode>UTF-8</cbc:EncodingCode>
        <cbc:Description><?php echo e(file_get_contents($storage . $factura->nombrexml )); ?>></cbc:Description>
    </cac:ExternalReference>
</cac:Attachment>
<?php /**PATH /var/www/html/GTEP/app/Plugins/Facturacion/Views/xml_attach/_attachment.blade.php ENDPATH**/ ?>