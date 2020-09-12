<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo RUTA_URL; ?>/Facturacion/files?css=Assets/css/styles.css">
<br>
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-6">
         <div class="card">
            <div class="card-header">
               <h3>Compras</h3>
            </div>
            <div class="card-body">
               <div class="icon proveedores">
                  <a title="Proveedores" href="<?php echo RUTA_URL; ?>/Facturacion/page/Providers"><img class="img-fluid" src="<?php echo RUTA_URL; ?>/Facturacion/files?img=Assets/img/providers.png"></a>
                  <span class="icon-title">&nbsp; Proveedores</span>
               </div>
               <div class="icon proveedor-facturas">
                  <a title="Facturas" href="<?php echo RUTA_URL; ?>/Facturacion/page/InvoicesProv"><img class="img-fluid" src="<?php echo RUTA_URL; ?>/Facturacion/files?img=Assets/img/invoice.png"></a>
                  <span class="icon-title">&nbsp;&nbsp;&nbsp;&nbsp;Facturas</span>
               </div>
               <div class="icon proveedor-egresos">
                  <a title="Egresos" href="<?php echo RUTA_URL; ?>/Facturacion/page/OutProv"><img class="img-fluid" src="<?php echo RUTA_URL; ?>/Facturacion/files?img=Assets/img/payment.png"></a>
                  <span class="icon-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Egresos</span>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-6">
         <div class="card">
            <div class="card-header">
               <h3>Ventas</h3>
            </div>
            <div class="card-body">
               <div class="icon clientes">
                  <a title="Clientes" href="<?php echo RUTA_URL; ?>/Facturacion/page/Clientes"><img class="img-fluid" src="<?php echo RUTA_URL; ?>/Facturacion/files?img=Assets/img/clients.png"></a>
                  <span class="icon-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clientes</span>
               </div>
               <div class="icon clientes-facturas">
                  <a title="Facturas" href="<?php echo RUTA_URL; ?>/Facturacion/page/FacturasCliente"><img class="img-fluid" src="<?php echo RUTA_URL; ?>/Facturacion/files?img=Assets/img/invoice.png"></a>
                  <span class="icon-title">&nbsp;&nbsp;&nbsp;&nbsp;Facturas</span>
               </div>
               <div class="icon clientes-ingresos">
                  <a title="Ingresos" href="<?php echo RUTA_URL; ?>/Facturacion/page/Ingresos"><img class="img-fluid" src="<?php echo RUTA_URL; ?>/Facturacion/files?img=Assets/img/payment2.png"></a>
                  <span class="icon-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ingresos</span>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/index.js"></script>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Config/config.js"></script>

<?php require RUTA_APP . '/Views/inc/footer.php'; ?>