<?php

class Logs extends Controller
{
    public function __construct()
    {
        $this->sessionValidator();
        $this->adminProtector(); //Protección admin
    }

    public function index()
    {
        $datos = [
            'titulo' => 'Logs',
            'icon'   => 'fas fa-exclamation-circle',
            'dataTables' => dataTables(),

        ];
        $this->vista('Logs/Logs', $datos);
    }

    public function tableViews()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['desde']) && !empty($_POST['desde']) && isset($_POST['hasta']) && !empty($_POST['hasta'])) {
                $fileLog = file_get_contents(RUTA_APP . SEPARATOR . "Logs" . SEPARATOR . "Log.json");
                $decode_logs = json_decode($fileLog, TRUE);
                $dataFiltered = array(
                    'data' => array(),
                );

                if ($_POST['id'] != "ALL") {
                    foreach ($decode_logs['data'] as $key => $value) {
                        $date = explode(" ", $value['fecha']);
                        if ($date[0] >= $_POST['desde'] && $date[0] <= $_POST['hasta'] && $_POST['id'] == $value['tipo']) {
                            array_push($dataFiltered['data'], $value);
                        }
                    }
                } else {
                    foreach ($decode_logs['data'] as $key => $value) {
                        $date = explode(" ", $value['fecha']);
                        if ($date[0] >= $_POST['desde'] && $date[0] <= $_POST['hasta']) {
                            array_push($dataFiltered['data'], $value);
                        }
                    }
                }

                header("Content-type: application/json; charset=utf-8");
                echo json_encode($dataFiltered, JSON_PRETTY_PRINT);
            } else {
                $fileLog = file_get_contents(RUTA_APP . SEPARATOR . "Logs" . SEPARATOR . "Log.json");
                $decode_logs = json_decode($fileLog, TRUE);
                header("Content-type: application/json; charset=utf-8");
                echo json_encode($decode_logs, JSON_PRETTY_PRINT);
            }
        }
    }
    //Método para manejar arhcivos
    public function files()
    {
        if (isset($_GET['img']) || isset($_GET['js']) || isset($_GET['css']) || isset($_GET['pdf'])) {
            if (isset($_GET['img'])) {
                return $this->filesGTEP($_GET['img'], false, 'img');
            }
            if (isset($_GET['pdf'])) {
                return $this->filesGTEP($_GET['pdf'], false, 'pdf');
            }
            if (isset($_GET['js'])) {
                //Personalizado
                return $this->filesGTEP('Assets' . SEPARATOR . __CLASS__, $_GET['js'], 'js', 'Assets');
            }
            if (isset($_GET['css'])) {
                return $this->filesGTEP($this->nombrePlugin, $_GET['css'], 'css');
            }
        } else {
            $this->pagina404(false);
        }
    }

    public function informeExcel()
    {
        if (isset($_GET['desde']) && !empty($_GET['desde']) && isset($_GET['hasta']) && !empty($_GET['hasta'])) {
            $fileLog = file_get_contents(RUTA_APP . SEPARATOR . "Logs" . SEPARATOR . "Log.json");
            $decode_logs = json_decode($fileLog, TRUE);
            $dataFiltered = array(
                'data' => array(),
            );

            if ($_GET['id'] != "ALL") {
                foreach ($decode_logs['data'] as $key => $value) {
                    $date = explode(" ", $value['fecha']);
                    if ($date[0] >= $_GET['desde'] && $date[0] <= $_GET['hasta'] && $_GET['id'] == $value['tipo']) {
                        array_push($dataFiltered['data'], $value);
                    }
                }
            } else {
                foreach ($decode_logs['data'] as $key => $value) {
                    $date = explode(" ", $value['fecha']);
                    if ($date[0] >= $_GET['desde'] && $date[0] <= $_GET['hasta']) {
                        array_push($dataFiltered['data'], $value);
                    }
                }
            }

            return new Excel(array(
                'requirement' => 'list',
                'title'       => 'LISTADO LOGS',
                'subject'     => 'RELACION DE LOGS',
                'description' => 'Este arhivo fue generado por el modulo myGTEP Logs',
                'keywords'    => 'Informes, listados, Logs, informacion',
                'category'    => 'Informes',
                'columns'     => array(
                    'TIPO',
                    'MENSAJE',
                    'USUARIO',
                    'IP',
                    'FECHA'
                ),
                'info'        => $dataFiltered['data'],
                'config_data' => 'array',
            ));
        } else {
            redireccionar('');
        }
    }
}
