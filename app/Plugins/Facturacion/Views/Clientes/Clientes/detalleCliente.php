<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<script>
    var elements = [];
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <div class="btn-group">
                <a href="<?php echo RUTA_URL; ?>/Facturacion/page/Clientes" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Clientes</a>
            </div>
        </div>
        <div class="col-sm" style="text-align:center"><strong>
                <h3>Editar Cliente &nbsp;<?php echo $datos['datos']->id_cliente ?><h3>
                        <input hidden type="text" id="enabled" value="<?php echo $datos['configFE']->enabled ?>">
            </strong>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Datos generales</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Cuenta Bancaria</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Dirección</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices" role="tab" aria-controls="contact" aria-selected="false">Facturas</a>
                </li>
            </ul>
            <br>
            <div class="tab-content" id="myTabContent">
                <?php require RUTA_PLUGINS . "/{$datos['Name']}/Views/Clientes/Clientes/TabsdetalleCliente/TabClient.php"; ?>
                <?php require RUTA_PLUGINS . "/{$datos['Name']}/Views/Clientes/Clientes/TabsdetalleCliente/TabBankType.php"; ?>
                <?php require RUTA_PLUGINS . "/{$datos['Name']}/Views/Clientes/Clientes/TabsdetalleCliente/TabAddress.php"; ?>
                <?php require RUTA_PLUGINS . "/{$datos['Name']}/Views/Clientes/Clientes/TabsdetalleCliente/TabInvoices.php"; ?>
            </div>
        </div>
    </div>
</div>
<script>
    elements[0] = {
        tipoidfiscal: '<?php echo $datos['datos']->tipoidfiscal ?>'
    };
    elements[1] = {
        codpago: '<?php echo $datos['datos']->codpago ?>'
    };
    elements[2] = {
        regimeniva: '<?php echo $datos['datos']->regimeniva ?>'
    };
    elements[3] = {
        tipo_organizacion: '<?php echo $datos['datos']->tipo_organizacion ?>'
    };
    elements[4] = {
        estado: '<?php echo $datos['datos']->estado ?>'
    };
    elements[5] = {
        medio_pago: '<?php echo $datos['datos']->medio_pago ?>'
    };
    elements[6] = {
        banctype: '<?php echo $datos['datos']->banctype ?>'
    };
</script>
<br>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Clientes/Clientedetallado.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>