<?php require RUTA_APP . '/Views/inc/header.php' ?>


<div class="container-fluid">

    <div class="card card-primary border-primary">
        <div class="card-header bg-primary  mb-3">
            <h5 class="card-title" style="color:white">Ventas asociadas del cliente</h5>
        </div>

        <div class="card-body">
            <form id="editrec" autocomplete="off">

                <div class="form-group row">

                    <?php
                    foreach ($datos['datoscli'] as $key) { ?>
                        <div class="col-sm">
                            <label>Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" readonly="" required="" value="<?php echo $key->Nombre; ?>">
                        </div>
                        <div class="col-sm">
                            <label>Numero documento</label>
                            <input type="number" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" readonly="" required="" value="<?php echo $key->Numero_Documento; ?>">
                        </div>
                    <?php } ?>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered border-primary table-hover" id="Recibos" style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-left">
                                    <h5>Nª Venta Asociada</h5>
                                </th>
                                <th class="text-left">
                                    <h5>Cliente</h5>
                                </th>
                                <th class="text-left">
                                    <h5>Producto</h5>
                                </th>
                                <th class="text-left">
                                    <h5>Fecha</h5>
                                </th>
                                <th class="text-left">
                                    <h5>Total</h5>
                                </th>
                            </tr>
                            <?php

                            foreach ($datos['cliente'] as $key) { ?>
                                <tr>
                                    <td>
                                        <h6><?php echo $key->IdVenta; ?></h6>
                                    </td>
                                    <td>
                                        <h6><?php echo $key->IdCliente; ?></h6>
                                    </td>
                                    <td>
                                        <h6><?php echo $key->NombreProducto; ?></h6>
                                    </td>
                                    <td>
                                        <h6><?php echo $key->Fecha; ?></h6>
                                    </td>
                                    <td>
                                        <h6><?php echo $key->total; ?></h6>
                                    </td>
                                </tr>
                            <?php } ?>
                        </thead>
                    </table>

                </div>

        </div>
        </form>


    </div>

    <?php require RUTA_APP . '/Views/inc/footer.php'; ?>