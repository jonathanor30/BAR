<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Proveedores/invoicesprov.js"></script>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-7">
      <div class="btn-group">
        <select class="btn btn-secondary btn-sm" onchange="cambiar()" id="festado" name="festado">
          <option value="" selected>Filtrar</option>
          <option value="0">Sin pagar</option>
          <option value="1">Pagada</option>
          <option value="2">Anulada</option>
          <option value="3">Completada</option>
        </select>
        &nbsp;&nbsp;
        <a href="<?php echo RUTA_URL; ?>/Facturacion/page/FacturaProveedor" id="btnnewinv" class="btn btn-success btn-sm "><i class="fa fa-plus" style="color:white"></i>&nbsp; <strong style="color:white">Nueva</strong></a>

      </div>

    </div>
    


  </div>
  <br>
  <div class="table table-responsive ">
    <table id="invoices" style="width:100%">
      <thead>
        <tr>
          <th style="width:30px">Número</th>
          <th>Nombre</th>
          <th>NIT/CC</th>
          <th>Total</th>
          <th>Observaciones</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>