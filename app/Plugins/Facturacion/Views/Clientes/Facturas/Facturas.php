<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<div class="container-fluid">

  <div class="row">
    <input hidden type="text" id="enabled" value="<?php echo $datos['configFE']->enabled ?>">
    <div class="col-md-7">
      <div class="btn-group">
        <select class="btn btn-secondary btn-sm" onchange="cambiar()" id="festado" name="festado">
          <option value="" selected>Filtrar</option>
          <option value="0">Pendiente</option>
          <option value="1">Pagada</option>
          <option value="2">Fact/NCrédito</option>
          <option value="3">Firmadas</option>
          <option value="4">Firmadas/Pagadas</option>
          <option value="5">Fact/NDébito</option>
          <option value="6">Fact/NCrédito/NDébito</option>
        </select>
        &nbsp;&nbsp;
        <a href="<?php echo RUTA_URL; ?>/Facturacion/page/nuevaFactura" id="btnnewinv" class="btn btn-success btn-sm "><i class="fa fa-plus" style="color:white"></i>&nbsp; <strong style="color:white">Nueva</strong></a>
      </div>
      <a class="btn btn-sm btn-primary" data-toggle="collapse" href="#Filtros" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fas fa-filter"></i>
      </a>
    </div>
  </div> <br>
  <div class="collapse" id="Filtros">
    <div class="row">
      <div class="col-sm-2">
        <label>Desde:</label>
        <input type="date" class="form-control form-control-sm" id="date_from">
      </div>
      <div class="col-sm-2">
        <label>Hasta:</label>
        <input type="date" class="form-control form-control-sm" id="date_till">
      </div>
      <div class="col-sm-2">
        <label>Cliente:</label>
        <input type="text" class="form-control form-control-sm" id="client_name">
      </div>
      <div class="col-sm-auto">
        <br>
        <button type="button" class="btn btn-sm btn-success" onclick="ListadoXls()"><i class="fas fa-file-excel"></i></button>
      </div>
    </div>
  </div>

  <br>
  <div class="table table-responsive ">
    <table id="invoices" style="width:100%">
      <thead>
        <tr>
          <th>Número</th>
          <th>Número FE</th>
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
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Clientes/Facturas.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>