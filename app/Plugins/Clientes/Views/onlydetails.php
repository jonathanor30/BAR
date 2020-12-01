<?php require RUTA_APP . '/Views/inc/header.php' ?>


<div class="form-group row">

    <?php
    foreach ($datos['VerV'] as $key) { ?>
        <div class="col-sm">
            <label>Cliente</label>
            <input type="text" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" readonly="" required="" value="<?php echo $key->Nombre; ?>">
        </div>
        <div class="col-sm">
            <label>Fecha</label>
            <input class="form-control form-control-sm" readonly id="fecha" placeholder="" type="date" value="<?php echo $key->fecha; ?>" name="FacFecha" required="">
        </div>
        <div class="col-sm">
            <label>Hora</label>
            <input class="form-control form-control-sm" readonly id="ref" placeholder="" type="text" value="<?php echo $key->hora; ?>" name="FacRef">

        </div>
        <div class="col-sm">
            <label>Estado</label>
            <input type="text" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" readonly="" required="" value="<?php echo $key->Estado; ?>">
        </div>
        <div class="col-sm">
            <label>Usuario que hizo la venta</label>
            <input type="text" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" readonly="" required="" value="<?php echo $key->user_name; ?>">
        </div>
    <?php } ?>
</div>

<hr>
<div class="table-responsive">
    <table class="table table-bordered border-primary table-hover" id="Recibos" style="width: 100%">
        <thead>
            <tr>
                <th class="text-left">Producto</th>
                <th class="text-left">Marca</th>
                <th class="text-left">Precio</th>
                <th class="text-left">cantidad</th>
                <th class="text-left">iva</th>
                <th class="text-left">total</th>
            </tr>
            <?php
            foreach ($datos['ObservarTodo'] as $key) { ?>
                <tr>
                    <td><?php echo $key->NombreProducto; ?></td>
                    <td><?php echo $key->Nombre; ?></td>
                    <td><?php echo $key->PrecioSugerido; ?></td>
                    <td><?php echo $key->cantidad; ?></td>
                    <td><?php echo $key->iva; ?></td>
                    <td><?php echo $key->total; ?></td>
                </tr>
            <?php } ?>
        </thead>
    </table>
    <?php
    foreach ($datos['total'] as $key) { ?>
        <div class="form-group text-right">
            <div class="col">
                <label class="control-label"><span class="badge badge-primary">Total:</span></label>
                <?php foreach ($datos['total'] as $key) {
                ?>
                    <input id="sumViewTotal" class="form-control " style="border:none;outline: none;cursor:none; font-size: 25px;" type="" value="<?php echo "$" . $key->suma; ?>" readonly />
                <?php } ?> <input type="hidden" id="sumAll" type="" value="" /> </div>
        </div>
    <?php } ?>
    <?php
    foreach ($datos['VerV'] as $key) { ?>
        <div class="form-group">
            <label class="control-label">Observaciones</label>
            <textarea class="form-control" readonly name="FacObservacion"><?php echo $key->observaciones; ?></textarea>
        </div>
    <?php } ?>
</div>



<?php require RUTA_APP . '/Views/inc/footer.php'; ?>