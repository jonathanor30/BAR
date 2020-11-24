<?php require RUTA_APP . '/Views/inc/header.php' ?>

<div class="container-fluid">


    <div class="card card-primary border-primary">

        <div class="card-header bg-primary  mb-3">
            <h5 class="card-title" style="color:white">Compras asociadas del proveedor</h5>

        </div>

        <div class="card-body">
            <form id="editrec" autocomplete="off">


                <div class="form-group row">

                    <?php
                    foreach ($datos['datospro'] as $key) { ?>
                        <div class="col-sm">
                            <label>Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" readonly="" required="" value="<?php echo $key->Nombre; ?>">
                        </div>
                        <div class="col-sm">
                            <label>Telefono</label>
                            <input type="number" class="form-control form-control-sm" id="ClieNombre" name="ClieNombre" readonly="" required="" value="<?php echo $key->Telefono; ?>">
                        </div>
                    <?php } ?>
                </div>



                <div class="col-sm">
                    <div class="table-responsive">
                        <table class="table table-bordered border-primary table-hover" id="Recibos" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-left">
                                        <h5>Nª Compra</h5>
                                    </th>
                                    <th class="text-left">
                                        <h5>Proveedor</h5>
                                    </th>
                                    <th class="text-left">
                                        <h5>Producto</h5>
                                    </th>
                                    <th class="text-left">
                                        <h5>cantidad</h5>
                                    </th>
                                    <th class="text-left">
                                        <h5>Fecha</h5>
                                    </th>
                                    <th class="text-left">
                                        <h5>iva</h5>
                                    </th>
                                    <th class="text-left">
                                        <h5>total</h5>
                                    </th>
                                </tr>
                                <?php
                                foreach ($datos['proveedor'] as $key) { ?>
                                    <tr>
                                        <td>
                                            <h6><?php echo $key->IdCompra; ?></h6>
                                        </td>
                                        <td>
                                            <h6><?php echo $key->IdProveedor; ?></h6>
                                        </td>
                                        <td>
                                            <h6><?php echo $key->NombreProducto; ?></h6>
                                        </td>
                                        <td>
                                            <h6><?php echo $key->cantidad; ?></h6>
                                        </td>
                                        <td>
                                            <h6><?php echo $key->fecha; ?></h6>
                                        </td>
                                        <td>
                                            <h6><?php echo $key->iva; ?></h6>
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
                <br>

        </div>

        </form>


    </div>


    <?php require RUTA_APP . '/Views/inc/footer.php'; ?>