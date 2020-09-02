<?php require(RUTA_APP . '/Views/inc/header.php'); ?>
<br>
<div class="container">
    <div id="resultados"></div>
</div>
<div class="container-fluid d-print-none">
    <div class="row">
        <div class="col-md-7">
            <div class="btn-group">
                <a class="btn btn-sm btn-outline-secondary" href="">
                    <i class="fas fa-sync" aria-hidden="true"></i>
                </a>
                <a class="btn btn-sm btn-outline-secondary" href="">
                    <i class="fas fa-bookmark" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <!-- Carga los datos ajax -->
        <div class="col-md-5 text-right">
            <h1 class="h3 d-none d-md-inline-block">
                <?php echo $datos["titulo"] . " <i class='" . $datos["icon"] . "'></i>"; ?>
            </h1>
            <br class="d-md-none">
        </div>
    </div>
</div>
<div class="container">
    <hr>
    <h5><i class="fas fa-filter"></i> Filtros</h5>
    <div class="row">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <label style="font-size: 12px;">Desde</label>
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                    <input type="date" class="form-control form-control-sm" id="desde">
                </div>
            </div>
            <div class="col-auto">
                <label style="font-size: 12px;">Hasta</label>
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                    <input type="date" class="form-control form-control-sm" id="hasta">
                </div>
            </div>
            <div class="col-auto">
                <label style="font-size: 12px;">Tipo</label>
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-info"></i></div>
                    </div>
                    <select class="form-control form-control-sm" id="filter" name="filter">
                        <option value="ALL">TODOS</option>
                        <option value="ERROR">ERROR</option>
                        <option value="WARNING">WARNING</option>
                        <option value="DANGER">DANGER</option>
                        <option value="INFO">INFO</option>
                        <option value="DB-QUERY">DB-QUERY</option>
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <label> </label>
                <div class="form-check mb-2">
                    <button type="button" class="btn btn-sm btn-secondary" title="Aplicar filtros" onclick="aplicarFiltros();" id="aplicar"><i class="fas fa-search"></i></button>
                    <button type="button" class="btn btn-success btn-sm" title="Excel"><i class="fas fa-file-excel" onclick="aplicarFiltros('Excel');"></i></button>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="container-fluid">
    <div class="table-responsive">
        <table style="font-size: 12px;" id="Logs" class="table table-hover">
            <thead>
                <tr>
                    <th class="text-left">Tipo</th>
                    <th style="width:35%;" class="text-left">Mensaje</th>
                    <th class="text-left">Usuario</th>
                    <th class="text-left">IP</th>
                    <th class="text-left">Fecha</th>
                </tr>
            </thead>
        </table>
    </div>
    <script src="<?php echo RUTA_URL ?>/Logs/files?js=js/Index.js"></script>
    <?php require(RUTA_APP . '/Views/inc/footer.php'); ?>