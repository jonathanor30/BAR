<cac:ParentDocumentLineReference>
    <cbc:LineID>1</cbc:LineID>
    <cac:DocumentReference>
        <cbc:ID><?php echo e($factura->prefijo . $factura->numero2); ?></cbc:ID>
        <cbc:UUID schemeName="CUFE-SHA384"><?php echo e($factura->cufedian); ?></cbc:UUID>
        <cbc:IssueDate><?php echo e($factura->fecha); ?></cbc:IssueDate>
        <cbc:DocumentType>ApplicationResponse</cbc:DocumentType>
        <cac:Attachment>
            <cac:ExternalReference>
                <cbc:MimeCode>text/xml</cbc:MimeCode>
                <cbc:EncodingCode>UTF-8</cbc:EncodingCode>
                <cbc:Description><?php echo e($Response); ?></cbc:Description>
            </cac:ExternalReference>
        </cac:Attachment>
        <cac:ResultOfVerification>
            <cbc:ValidatorID>
                Unidad Especial Dirección de Impuestos y Aduanas Nacionales
            </cbc:ValidatorID>
            <cbc:ValidationResultCode>002</cbc:ValidationResultCode>
            <cbc:ValidationDate><?php echo e(explode('|', $factura->fecha_hora_dian)[0]); ?></cbc:ValidationDate>
            <cbc:ValidationTime><?php echo e(explode('|', $factura->fecha_hora_dian)[1]); ?></cbc:ValidationTime>
        </cac:ResultOfVerification>
    </cac:DocumentReference>
</cac:ParentDocumentLineReference>
<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml_attach/_parent_document.blade.php ENDPATH**/ ?>