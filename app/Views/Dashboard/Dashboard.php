<?php require(RUTA_APP . '/Views/inc/header.php'); ?>
<script src="<?php echo RUTA_URL ?>/public/js/chartjs.js"></script>
<link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/jquery-ui.css">
<script src="<?php echo RUTA_URL ?>/public/js/jquery-ui.js"></script>
<div class="container-fluid">
    <h3 class="text-secondary">Panel de información <i class="fas fa-tachometer-alt"></i></h3>
    <br>
    <div class="row">
        <div class="col-md-3">
            <div class="card dash-box dash-box-color-1">
                <br>
                <a href="<?php echo RUTA_URL; ?>/Vehiculos"><img class="img-fluid dash-box-icon" src="<?php echo RUTA_URL; ?>/public/img/fleet.png"></a>
                <br>
                <div class="text-center mt-3">
                    <h4>Vehículos</h4>
                </div>
                <div class="text-center mt-2">
                    <h3><?php echo $datos['total']->vehiculos ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dash-box dash-box dash-box-color-2">
                <br>
                <a href="<?php echo RUTA_URL; ?>/Servicios"><img class="img-fluid dash-box-icon" src="<?php echo RUTA_URL; ?>/public/img/service.png"></a><br>
                <div class="text-center mt-3">
                    <h4>Servicios</h4>
                </div>
                <div class="text-center mt-2">
                    <h3><?php echo $datos['total']->servicios ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dash-box dash-box dash-box-color-3">
                <br>
                <a href="<?php echo RUTA_URL; ?>/Contratos"><img class="img-fluid dash-box-icon" src="<?php echo RUTA_URL; ?>/public/img/contract.png"></a><br>
                <div class="text-center mt-3">
                    <h4>Contratos</h4>
                </div>
                <div class="text-center mt-2">
                    <h3><?php echo $datos['total']->contratos ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dash-box dash-box dash-box-color-4">
                <br>
                <a href="<?php echo RUTA_URL; ?>/Extractos"><img class="img-fluid dash-box-icon" src="<?php echo RUTA_URL; ?>/public/img/extract.png"></a><br>
                <div class="text-center mt-3">
                    <h4>Extractos</h4>
                </div>
                <div class="text-center mt-2">
                    <h3><?php echo $datos['total']->extractos ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<?php
//Consulta para graficar la utilidad de todos los servicios realizados por los vehiculos
$meses = array(
    '',
    'Ene',
    'Feb',
    'Mar',
    'Abr',
    'May',
    'Jun',
    'Jul',
    'Ago',
    'Sept',
    'Oct',
    'Nov',
    'Dic',
);
for ($x = 1; $x <= 12; $x = $x + 1) {
    $dinero[$x] = 0;
}

$anno = date('Y');

//Bucle para seterar el valor de la consulta en la variable $row
foreach ($datos['servicios'] as $row) {

    $y = date("Y", strtotime($row['fecha_servicio']));
    $mes = (int) date("m", strtotime($row['fecha_servicio']));

    if ($y == $anno) {
        $dinero[$mes] = $dinero[$mes] + round($row['utilidad_servicio'], 0);
    }
}
//print_r($dinero);
//Consulta para graficar los gastos de todos los gasto de vehiculos
$meses_gasto = array(
    '',
    'Ene',
    'Feb',
    'Mar',
    'Abr',
    'May',
    'Jun',
    'Jul',
    'Ago',
    'Sept',
    'Oct',
    'Nov',
    'Dic',
);
for ($y = 1; $y <= 12; $y = $y + 1) {
    $dinero_gasto[$y] = 0;
}

foreach ($datos['servicios'] as $row_gasto) {
    $y_gasto = date("Y", strtotime($row_gasto['fecha_servicio']));

    $mes_gasto = (int) date("m", strtotime($row_gasto['fecha_servicio']));

    if ($y_gasto == $anno) {
        $dinero_gasto[$mes_gasto] = $dinero_gasto[$mes_gasto] + round($row_gasto['valor_gasto'], 0);
    }
}

?>
<div class="container-fluid">
    <h3 class="text-secondary">Gráfica <i class="fas fa-chart-bar"></i> <i class="fas fa-chart-pie"></i></h3>
    <div class="aling-rigth">
        <form class="form-inline" action="<?php echo RUTA_URL ?>/vehiculos/informeVehiculo" method="POST">
            <div class="form-group mb-2">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Informe por vehículo: ">
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control form-control-sm" name="placa_vehiculo" id="placa_vehiculo" placeholder="Ingrese placa..." required="" autocomplete="off">
                <input type="hidden" name="id_vehiculo" id="id_vehiculo" required>
            </div>
            <button type="submit" class="btn btn-primary mb-2 btn-sm"><i class="fas fa-share-square"></i></button>
        </form>
    </div>
    <br>
    <div class="chartDashboard" id="imagen">
        <div class="row">
            <div class="col-sm-6">
                <div class="chart-container">
                    <canvas id="utilidad"></canvas>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="chart-container">
                    <canvas id="gastos"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chart-container">
                    <canvas id="disponibilidad"></canvas>
                </div>

                <button id="boton-descarga" class="btn btn-primary">Exportar gráficas <i class="fas fa-download"></i></button>
            </div>
        </div>
    </div>
</div>
<script>
    //Utilidad
    var utilidadServicios = document.getElementById("utilidad");

    Chart.defaults.global.defaultFontSize = 14;

    var utilidad = {
        label: 'Utilidad de vehículos por mes',
        data: [<?php
                for ($y = 1; $y <= 12; $y = $y + 1) {
                    if ($y == 12) {
                        echo $dinero[$y];
                    } else {
                        echo $dinero[$y] . ',';
                    }
                } ?>],
        backgroundColor: [
            "#3e95cd",
            "#3e95cd",
            "#3e95cd",
            "#3e95cd",
            "#3e95cd",
            "#3e95cd",
            "#3e95cd",
            "#3e95cd",
            "#3e95cd",
            "#3e95cd",
            "#3e95cd",
            "#3e95cd"
        ],
        borderWidth: 2,
        hoverBorderWidth: 0


    };
    //console.log(utilidad);
    var options = {
        scaleBeginAtZero: true
    }
    var barChart1 = new Chart(utilidadServicios, {
        type: 'bar',
        data: {
            labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            datasets: [utilidad]

        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return addCommas(value);
                        }
                    },
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(t, d) {
                        var xLabel = d.datasets[t.datasetIndex].label;
                        var yLabel = t.yLabel >= 1000 ?
                            '$' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".", ",") :
                            '$' + t.yLabel;
                        return xLabel + ': ' + yLabel;
                    }
                }
            }

        }
    });

    //Gastos
    var gastosServicios = document.getElementById("gastos");
    var gastos = {
        label: 'Gastos de vehículos por mes',
        data: [<?php
                for ($y = 1; $y <= 12; $y = $y + 1) {
                    $dinero_gasto[$y];
                } ?>],
        backgroundColor: [
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c",
            "#ff6c2c"

        ],
        borderWidth: 2,
        hoverBorderWidth: 0


    };
    var options = {

    }
    var barChart1 = new Chart(gastosServicios, {
        type: 'bar',
        data: {
            labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            datasets: [gastos]

        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return addCommas(value);
                        }
                    },
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(t, d) {
                        var xLabel = d.datasets[t.datasetIndex].label;
                        var yLabel = t.yLabel >= 1000 ?
                            '$' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".", ",") :
                            '$' + t.yLabel;
                        return xLabel + ': ' + yLabel;
                    }
                },

            }

        }
    });

    new Chart(document.getElementById("disponibilidad"), {
        type: 'doughnut',
        data: {
            labels: ["Activos", "Inactivos", "Desvinculados"],
            datasets: [{
                label: "Disponibilidad",
                backgroundColor: ['#55ce63', '#f62d51', '#ffc107'],
                data: [<?php echo $datos['vehiculos_activos'] ?>, <?php echo $datos['vehiculos_inactivos'] ?>, <?php echo $datos['vehiculos_desvin'] ?>]
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Disponibilidad de vehículos'
            }
        }
    });

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    $(window).resize(function() {
        Chart();
    });
</script>
<script type="text/javascript">
    $(function() {
        function downloadCanvas(canvasId, filename) {
            // Obteniendo la etiqueta la cual se desea convertir en imagen
            var domElement = document.getElementById(canvasId);

            // Utilizando la función html2canvas para hacer la conversión
            html2canvas(domElement, {
                onrendered: function(domElementCanvas) {
                    // Obteniendo el contexto del canvas ya generado
                    var context = domElementCanvas.getContext('2d');

                    // Creando enlace para descargar la imagen generada
                    var link = document.createElement('a');
                    link.href = domElementCanvas.toDataURL("image/png");
                    link.download = filename;

                    // Chequeando para browsers más viejos
                    if (document.createEvent) {
                        var event = document.createEvent('MouseEvents');
                        // Simulando clic para descargar
                        event.initMouseEvent("click", true, true, window, 0,
                            0, 0, 0, 0,
                            false, false, false, false,
                            0, null);
                        link.dispatchEvent(event);
                    } else {
                        // Simulando clic para descargar
                        link.click();
                    }
                }
            });
        }

        // Haciendo la conversión y descarga de la imagen al presionar el botón
        $('#boton-descarga').click(function() {
            downloadCanvas('imagen', 'imagen.png');
        });
    });
</script>
<script>
    //Vehiculos 
    $(function() {
        $("#placa_vehiculo").autocomplete({
            source: "<?php echo RUTA_URL ?>/Vehiculos/autocompletarVehiculo",
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $('#id_vehiculo').val(ui.item.id_vehiculo);
                $('#placa_vehiculo').val(ui.item.placa_vehiculo);
                $('#modelo_vehiculo').val(ui.item.modelo_vehiculo);
                $('#marca_vehiculo').val(ui.item.marca_vehiculo);
                $('#clase_vehiculo').val(ui.item.clase_vehiculo);
                $('#numerointerno_vehiculo').val(ui.item.numerointerno_vehiculo);
                $('#tarjetaoperacion_vehiculo').val(ui.item.tarjetaoperacion_vehiculo);
                $('#status_vehiculo').val(ui.item.status_vehiculo);
            }
        });
    });
    $("#placa_vehiculo").on("keydown", function(event) {
        if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
            $('#id_vehiculo').val("");
            $('#placa_vehiculo').val("");
            $('#modelo_vehiculo').val("");
            $('#marca_vehiculo').val("");
            $('#clase_vehiculo').val("");
            $('#numerointerno_vehiculo').val("");
            $('#tarjetaoperacion_vehiculo').val("");
            $('#status_vehiculo').val("");

        }
        if (event.keyCode == $.ui.keyCode.DELETE) {
            $('#id_vehiculo').val("");
            $('#placa_vehiculo').val("");
            $('#modelo_vehiculo').val("");
            $('#marca_vehiculo').val("");
            $('#clase_vehiculo').val("");
            $('#numerointerno_vehiculo').val("");
            $('#tarjetaoperacion_vehiculo').val("");
            $('#status_vehiculo').val("");
        }
    });
</script>
<script type="text/javascript" src="<?php echo RUTA_URL; ?>/public/js/canvas.js"></script>
<?php require(RUTA_APP . '/Views/inc/footer.php'); ?>