<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<DebitNote
    xmlns="urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2"
    xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
    xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
    xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
    xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
    xmlns:sts="http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures"
    xmlns:xades="http://uri.etsi.org/01903/v1.3.2#"
    xmlns:xades141="http://uri.etsi.org/01903/v1.4.1#"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2    http://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-DebitNote-2.1.xsd">
    
    <?php echo $__env->make('xml._ubl_extensions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <cbc:UBLVersionID>UBL 2.1</cbc:UBLVersionID>
    <cbc:CustomizationID>10</cbc:CustomizationID>
    <cbc:ProfileID>DIAN 2.1</cbc:ProfileID>
    <cbc:ProfileExecutionID><?php echo e($company->tipo_ambiente); ?></cbc:ProfileExecutionID>
    <cbc:ID><?php echo e($invoice->prefijo . $number_nc); ?></cbc:ID>
    <cbc:UUID schemeID="<?php echo e($company->tipo_ambiente); ?>" schemeName="CUDE-SHA384"><?php echo e($cufe); ?></cbc:UUID>
    <cbc:IssueDate><?php echo e(explode("|", $invoice->fecha_hora_dian)[0]); ?></cbc:IssueDate>
    <cbc:IssueTime><?php echo e(explode("|", $invoice->fecha_hora_dian)[1]); ?>-05:00</cbc:IssueTime>
    
    <cbc:DocumentCurrencyCode><?php echo e($invoice->coddivisa); ?></cbc:DocumentCurrencyCode>
    <cbc:LineCountNumeric><?php echo e($invoice->lines_count); ?></cbc:LineCountNumeric>
    
    <?php echo $__env->make('xml._billing_reference', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml._accounting', ['node' => 'AccountingSupplierParty', 'supplier' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml._accounting_customer', ['node' => 'AccountingCustomerParty', 'user' => $invoice->Client, 'supplier' =>true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml._payment_means', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml._allowance_charges', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml._tax_totals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml._legal_monetary_total', ['node' => 'RequestedMonetaryTotal'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('xml._debit_note_lines', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</DebitNote>
<?php /**PATH /var/www/html/GTEP/app/Plugins/Facturacion/Views/xml/92.blade.php ENDPATH**/ ?>