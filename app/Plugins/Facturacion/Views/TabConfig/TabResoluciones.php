<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    <br>
    <div class="container-fluid">
        <div class="row justify-content-start">
            <div class="col-auto">
                <select class="form-control form-control-sm" id="filter" onchange="reloadTable('Resolutions','filter');">
                    <option value="" selected="" data-icon="icono-caretDown">Filtro</option>
                    <option value="1" data-icon="icono-caretDown">Activo</option>
                    <option value="2" data-icon="icono-caretDown">Inactivo</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-sm ias-btn-icon btn-primary" onclick="reloadTable('Resolutions','filter')">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-repeat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M2.854 7.146a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L2.5 8.207l1.646 1.647a.5.5 0 0 0 .708-.708l-2-2zm13-1a.5.5 0 0 0-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0 0-.708z" />
                        <path fill-rule="evenodd" d="M8 3a4.995 4.995 0 0 0-4.192 2.273.5.5 0 0 1-.837-.546A6 6 0 0 1 14 8a.5.5 0 0 1-1.001 0 5 5 0 0 0-5-5zM2.5 7.5A.5.5 0 0 1 3 8a5 5 0 0 0 9.192 2.727.5.5 0 1 1 .837.546A6 6 0 0 1 2 8a.5.5 0 0 1 .501-.5z" />
                    </svg>
                </button>
                <button type="button" data-toggle="modal" data-target="#edit-resolution" onclick="DelId()" class="btn btn-sm ias-btn-icon btn-primary">
                    <svg class="bi bi-plus" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z" />
                        <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z" />
                    </svg>
                </button>
                <button class="btn btn-sm btn-default" type="button" data-toggle="collapse" data-target="#filtroFecha" aria-expanded="false" aria-controls="" title="Filtro de fechas">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-funnel-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z" />
                    </svg>
                </button>
            </div>
            <div class="col-auto">
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar-date-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM0 5h16v9a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5zm9.336 7.79c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm.066-2.544c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2zm-2.957-2.89v5.332H5.77v-4.61h-.012c-.29.156-.883.52-1.258.777V8.16a12.6 12.6 0 0 1 1.313-.805h.632z" />
                            </svg>
                        </div>
                    </div>
                    <select id="res-year" class="form-control form-control-sm" autocomplete="off" onchange="reloadTable('Resolutions', 'filter');">
                        <?php for ($i = date('Y'); $i >= date('Y') - 4; $i--) : ?>
                            <?php if ($i == date('Y')) : ?>
                                <option selected value="<?php echo $i ?>">
                                    <?php echo $i ?>
                                </option>
                            <?php else : ?>
                                <option value="<?php echo $i ?>">
                                    <?php echo $i ?>
                                </option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>

        <br>
        <div class="container-fluid">
            <div class="table-responsive">
                <table id="Resolutions" class="table table-hover table-bordered ias-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-sort-numeric-down-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11A.5.5 0 0 1 4 2z" />
                                    <path fill-rule="evenodd" d="M6.354 11.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L4 12.793l1.646-1.647a.5.5 0 0 1 .708 0z" />
                                    <path d="M9.598 5.82c.054.621.625 1.278 1.761 1.278 1.422 0 2.145-.98 2.145-2.848 0-2.05-.973-2.688-2.063-2.688-1.125 0-1.972.688-1.972 1.836 0 1.145.808 1.758 1.719 1.758.69 0 1.113-.351 1.261-.742h.059c.031 1.027-.309 1.856-1.133 1.856-.43 0-.715-.227-.773-.45H9.598zm2.757-2.43c0 .637-.43.973-.933.973-.516 0-.934-.34-.934-.98 0-.625.407-1 .926-1 .543 0 .941.375.941 1.008zM12.438 14V8.668H11.39l-1.262.906v.969l1.21-.86h.052V14h1.046z" />
                                </svg>
                            </th>
                            <th class="text-center">Prefijo</th>
                            <th class="text-center">Resolución</th>
                            <th class="text-center">No desde</th>
                            <th class="text-center">No hasta</th>
                            <th class="text-center">Fecha desde</th>
                            <th class="text-center">Fecha hasta</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="edit-resolution" tabindex="-1" aria-labelledby="edit-resolutionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-resolutionLabel">Guardar o editar resolución</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit-resolution-form" method="POST" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm">
                                <label>Prefijo</label>
                                <input type="text" class="form-control form-control-sm" name="prefix" id="prefix" required>
                            </div>
                            <div class="col-sm">
                                <label>Resolución</label>
                                <input type="text" class="form-control form-control-sm" name="resolution" id="resolution" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <label>Fecha resolución</label>
                                <input type="date" step="1" min="0" class="form-control form-control-sm" name="resolution_date" id="resolution_date" required>
                            </div>
                            <div class="col-sm">
                                <label>Llave técnica</label>
                                <input type="text" class="form-control form-control-sm" name="technical_key" id="technical_key" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <label>Desde</label>
                                <input type="number" step="1" min="0" class="form-control form-control-sm" name="from_number" id="from_number" required>
                            </div>
                            <div class="col-sm">
                                <label>Hasta</label>
                                <input type="number" step="1" min="0" class="form-control form-control-sm" name="to_number" id="to_number" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <label>Fecha desde</label>
                                <input type="date" class="form-control form-control-sm" name="date_from" id="date_from" required>
                            </div>
                            <div class="col-sm">
                                <label>Fecha hasta</label>
                                <input type="date" class="form-control form-control-sm" name="date_to" id="date_to" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <label>Tipo</label>
                                <select class="form-control form-control-sm" name="type" id="type" required>
                                    <option selected disabled value="">--Seleccione--</option>
                                    <option value="FE">Facturación</option>
                                    <option value="DS">Documento Soporte</option>
                                </select>
                            </div>
                            <div class="col-sm">
                                <label>Estado</label>
                                <select class="form-control form-control-sm" name="status" id="status" required>
                                    <option selected disabled value="">--Seleccione--</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="save-resolution" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>