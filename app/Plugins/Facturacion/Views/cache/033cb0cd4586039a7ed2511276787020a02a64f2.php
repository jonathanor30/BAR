<AttachedDocument xmlns="urn:oasis:names:specification:ubl:schema:xsd:AttachedDocument-2"
    xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
    xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
    xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
    xmlns:ccts="urn:un:unece:uncefact:data:specification:CoreComponentTypeSchemaModule:2"
    xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
    xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" xmlns:xades141="http://uri.etsi.org/01903/v1.4.1#">
    <cbc:UBLVersionID>UBL 2.1</cbc:UBLVersionID>
    <cbc:CustomizationID>Documentos adjuntos</cbc:CustomizationID>
    <cbc:ProfileID>DIAN 2.1</cbc:ProfileID>
    <cbc:ProfileExecutionID><?php echo e($company->tipo_ambiente); ?></cbc:ProfileExecutionID>
    <cbc:ID><?php echo e($factura->numero2); ?></cbc:ID>
    <cbc:IssueDate><?php echo e($factura->fecha); ?></cbc:IssueDate>
    <cbc:IssueTime><?php echo e($factura->hora); ?></cbc:IssueTime>
    <cbc:DocumentType>Contenedor de Factura Electrónica</cbc:DocumentType>
    <cbc:ParentDocumentID><?php echo e($factura->prefijo . $factura->numero2); ?></cbc:ParentDocumentID>
    
    <?php echo $__env->make('xml_attach._sender_party', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml_attach._receiver_party', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml_attach._attachment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml_attach._parent_document', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</AttachedDocument>
<?php /**PATH /home/transpor/gtep.transportesonix.com/app/Plugins/Facturacion/Views/xml_attach/01.blade.php ENDPATH**/ ?>