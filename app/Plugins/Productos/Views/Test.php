<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 id="TituloProducto"><?php echo $datos['producto']->NombreProducto ?></h4>
        </div>
        <input hidden id="TipoProductoActual" value="<?php echo $datos['producto']->IdTipoProducto?>">
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
                            <input type="file" class="custom-file-input" id="ImagenProducto" name="ImagenProducto" onchange="upload_image();" accept=".jpg,.png,.jpeg">
                            <label class="custom-file-label" for="ImagenProducto" aria-describedby="inputGroupFileAddon02">Seleccione una imagen <i class="fas fa-image"></i></label>
                        </div>
                        <div id="LoadImgProducto"></div>
                    </div>
                    <br><br>
                </div>
            </div>
            <form id="FormEditarProducto" action="" method="POST">
                <div class="row">
                    <div class="col-sm">
                        <label>Nombre</label>
                        <input class="form-control form-control-sm" type="text" name="NombreProducto" id="NombreProducto" value="<?php echo $datos['producto']->NombreProducto ?>" />
                        <input type="hidden" id="IdProducto" name="IdProducto" value="<?php echo $datos['producto']->IdProducto ?>">
                    </div>
                    <div class="col-sm">
                        <label>Precio Sugerido</label>
                        <input class="form-control form-control-sm" type="number" name="PrecioSugerido" id="PrecioSugerido" value="<?php echo $datos['producto']->PrecioSugerido ?>" />

                    </div>
                    <div class="col-sm">
                        <label>Stock Máximo</label>
                        <input class="form-control form-control-sm" type="number" name="StockMaximo" id="StockMaximo" value="<?php echo $datos['producto']->StockMaximo ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Stock Minimo</label>
                        <input class="form-control form-control-sm" type="number" name="StockMinimo" id="StockMinimo" value="<?php echo $datos['producto']->StockMinimo ?>" />
                    </div>
                    <div class="col-sm">
                        <label>Existencias</label>
                        <input class="form-control form-control-sm" type="number" name="Existencias" id="Existencias" value="<?php echo $datos['producto']->Existencias ?>" />
                    </div>
                    <div class="col-sm">
                        <label>Contenido</label>
                        <input class="form-control form-control-sm" type="text" name="Contenido" id="Contenido" value="<?php echo $datos['producto']->Contenido ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-auto">
                        <label>Tipo de producto</label>
                        <select class="form-control form-control-sm" name="IdTipoProducto" id="IdTipoProducto">
                            <option disable>--Selecione--</option>
                        </select>
                    </div>
                    <div class="col-sm-auto">
                        <label>Estado</label>
                        <select class="form-control form-control-sm" id="Estado_P">
                            <?php if ($datos['producto']->Estado_P == 1) : ?>
                                <option selected value="<?php $datos['producto']->Estado_P ?>">Activo</option>
                                <option value="2">Inactivo</option>
                            <?php else : ?>
                                <option selected value="<?php $datos['producto']->Estado_P ?>">Inactivo</option>
                                <option value="1">Activo</option>
                            <?php endif; ?>

                        </select>
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm">
                    <button type="submit" id="BtnEditProducto" class="btn btn-sm btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<script src="<?php echo RUTA_URL; ?>/Productos/files?js=recursos/js/Producto.js"></script>
<?php require RUTA_APP . '/Views/inc/footer.php'; ?>