<?php require RUTA_APP . '/Views/inc/header.php' ?>
<script src="<?php echo RUTA_URL; ?>/Facturacion/files?js=Assets/js/Proveedores/detailOuts.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-6">
            <div class="btn-group">
            </div>
        </div>
    </div>
    <br>
    <div class="card card-primary border-primary">
        <div class="card-header bg-primary  mb-3">
        <h5 id="TituloProducto" class="card-title" style="color:white"><?php echo $datos['producto']->NombreProducto ?></h5>
        </div>
        <input hidden id="TipoProductoActual" value="<?php echo $datos['producto']->IdTipoProducto?>">
        <input hidden id="TipoPresentacionActual" value="<?php echo $datos['producto']->IdPresentacion?>">  
        <input hidden id="TipoMarcaActual" value="<?php echo $datos['producto']->IdMarca?>">
        <input hidden id="TipoUnidadActual" value="<?php echo $datos['producto']->IdUnidadMedida?>">
        <div class="card-body">
            <div class="row" title="<?php echo $datos['producto']->NombreProducto ?> $<?php echo $datos['producto']->PrecioSugerido ?>">
                <div class="col-sm-auto">
                    <?php if ($datos['producto']->ImagenProducto != NULL || $datos['producto']->ImagenProducto != '') : ?>
                        <div id="IMGProductoCargado">
                            <img style="width: -50%;" class="img-fluid img-producto" src="<?php echo RUTA_URL ?>/Productos/files?img=<?php echo $datos['producto']->ImagenProducto; ?>" alt="Producto">
                        </div>
                    <?php else : ?>
                        <h5>El producto no tiene una imagen cargada</h5>
                    <?php endif; ?>
                    <br>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <label class="form-control form-control-sm" class="custom-file-label" for="ImagenProducto" aria-describedby="inputGroupFileAddon02">Imagen del producto <i class="fas fa-image"></i></label>
                        </div>
                        <div></div>
                    </div>
                    <br><br>
                </div>
            </div>
            <form id="FormEditarProducto" action="" method="POST">
                <div class="row">
                <div class="col-sm">
                        <label>Codigo</label>
                        <input class="form-control form-control-sm" type="text" readonly name="CodigoProducto" id="CodigoProducto" value="<?php echo $datos['producto']->CodigoProducto ?>" />
                    </div>
                    <div class="col-sm">
                        <label>Nombre</label>
                        <input class="form-control form-control-sm" type="text" readonly name="NombreProducto" id="NombreProducto" value="<?php echo $datos['producto']->NombreProducto ?>" />
                        <input type="hidden" id="IdProducto" name="IdProducto" value="<?php echo $datos['producto']->IdProducto ?>">
                    </div>
                    <div class="col-sm">
                        <label>Precio Sugerido</label>
                        <input class="form-control form-control-sm" readonly type="number" name="PrecioSugerido" id="PrecioSugerido" value="<?php echo $datos['producto']->PrecioSugerido ?>" />

                    </div>
                    <div class="col-sm">
                        <label>Stock Máximo</label>
                        <input class="form-control form-control-sm" readonly type="number" name="StockMaximo" id="StockMaximo" value="<?php echo $datos['producto']->StockMaximo ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Stock Minimo</label>
                        <input class="form-control form-control-sm" readonly type="number" name="StockMinimo" id="StockMinimo" value="<?php echo $datos['producto']->StockMinimo ?>" />
                    </div>
                    <div class="col-sm">
                        <label>Existencias</label>
                        <input class="form-control form-control-sm" readonly type="number" name="Existencias" id="Existencias" value="<?php echo $datos['producto']->Existencias ?>" />
                    </div>
                    <div class="col-sm">
                        <label>Contenido</label>
                        <input class="form-control form-control-sm" readonly type="text" name="Contenido" id="Contenido" value="<?php echo $datos['producto']->Contenido ?>" />
                    </div>
                    <div class="col-sm">
                        <label>Unidad medida</label>
                        <select disabled=»disabled» class="form-control form-control-sm" readonly name="IdUnidadMedida" id="IdUnidadMedida">
                            <option disable></option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Tipo de producto</label>
                        <select  disabled=»disabled» class="form-control form-control-sm" readonly name="IdTipoProducto" id="IdTipoProducto">
                            <option disable></option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label>presentacion</label>
                        <select disabled=»disabled» class="form-control form-control-sm" readonly name="IdPresentacion" id="IdPresentacion">
                            <option disable></option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label>Marca</label>
                        <select disabled=»disabled» class="form-control form-control-sm" readonly name="IdMarca" id="IdMarca">
                            <option disable></option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label>Estado</label>
                        <select disabled=»disabled» class="form-control form-control-sm" readonly id="Estado_P">
                            <?php if ($datos['producto']->Estado_P == 1) : ?>
                                <option selected value="<?php $datos['producto']->Estado_P ?>">Activo</option>
                            <?php else : ?>
                                <option selected value="<?php $datos['producto']->Estado_P ?>">Inactivo</option>
                            <?php endif; ?>

                        </select>
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <div class="row">
            </div>
        </div>
    </div>
    </form>
</div>
<script src="<?php echo RUTA_URL; ?>/Productos/files?js=recursos/js/Producto.js"></script>

<?php require RUTA_APP . '/Views/inc/footer.php'; ?>