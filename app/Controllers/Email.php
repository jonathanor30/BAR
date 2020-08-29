<?php

/**
 *
 */
class Email extends Controller
{

    public $email; //Objeto para PHPMailer
    public $host; //Servidor de correo
    public $port; //Puerto
    public $userName; //cuenta de correo
    public $password; //Contraseña
    public $subjet; //Asunto
    public $addressee; //Destinatario
    public $url_bot;

    public function __construct()
    {

        //Instancia del modelo Perfil
        $this->modeloEmail = $this->modelo('Perfil');
        //Configuracion de correo
        $config = $this->modeloEmail->obtenerPerfil();

        $this->url_bot = 'http://mygtep.com/bot/index.php';

        //Instancia PHPMailer
        $this->mail          = new PHPMailer;
        $this->mail->CharSet = "UTF-8";

        //Configuracion predeterminada
        $this->host     = $config->hostEmail; //Servidor de correo
        $this->port     = 25;
        $this->userName = $config->userEmail;
        $this->password = $config->passwordEmail;
    }

    public function index()
    {
        redireccionar('');
    }

    //Método para enviar alertas de documentos
    public function emailAlerta()
    {
        if (isset($_GET['documento']) && isset($_GET['tipo']) && isset($_GET['id']) && isset($_GET['fecha'])) {

            $this->perfilModelo = $this->modelo('Perfil');
            $empresa            = $this->perfilModelo->obtenerPerfil(); //Datos de empresa
            if ($empresa->id_telegram != "" && $empresa->id_telegram != null) :
                $sms = 'Alerta❗' . "\n" . 'Los siguientes ' . $_GET['tipo'] . ', tienen el documento: ' . "\n" . $_GET['documento'] . ' vencido o a punto de vencer.' . "\n" . $_GET['id'] . ' Fecha: ' . $_GET['fecha'] . "\n" . "_______________________" . "\n" . "© 2017-" . date("Y") . " myGTEP Negocio, reescrito por software ";
                $this->telegramAlert($empresa->id_telegram, $sms);
            endif;
            //Tell PHPMailer to use SMTP
            $this->mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $this->mail->SMTPDebug = 0;
            //Set the hostname of the mail server
            $this->mail->Host = $this->host;
            //Set the SMTP port number - likely to be 25, 465 or 587
            $this->mail->Port = $this->port;
            //Whether to use SMTP authentication
            $this->mail->SMTPAuth = true;
            //Username to use for SMTP authentication
            $this->mail->Username = $this->userName;
            //Password to use for SMTP authentication
            $this->mail->Password = $this->password;
            //Set who the message is to be sent from
            $this->mail->setFrom($this->userName, 'GTEP');
            //Set an alternative reply-to address
            //$this->mail->addReplyTo('judamo94@hotmail.com', 'First Last');
            //Set who the message is to be sent to
            $this->mail->addAddress($empresa->email_alerta, $empresa->email_alerta);
            //Set the subject line
            $this->mail->Subject = 'ALERTA DOCUMENTO (!)';

            $mensaje = '<html class=""><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> <meta name="viewport" content="width=device-width">  <title>Simple Transactional Email</title> <style>img{border: none; -ms-interpolation-mode: bicubic; max-width: 100%;}body{background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;}table{border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;}table td{font-family: sans-serif; font-size: 14px; vertical-align: top;}.body{background-color: #f6f6f6; width: 100%;}/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */ .container{display: block; margin: 0 auto !important; /* makes it centered */ max-width: 580px; padding: 10px; width: 580px;}/* This should also be a block element, so that it will fill 100% of the .container */ .content{box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;}.main{background: #ffffff; border-radius: 3px; width: 100%;}.wrapper{box-sizing: border-box; padding: 20px;}.content-block{padding-bottom: 10px; padding-top: 10px;}.footer{clear: both; margin-top: 10px; text-align: center; width: 100%;}.footer td, .footer p, .footer span, .footer a{color: #999999; font-size: 12px; text-align: center;}h1, h2, h3, h4{color: #000000; font-family: sans-serif; font-weight: 400; line-height: 1.4; margin: 0; margin-bottom: 30px;}h1{font-size: 35px; font-weight: 300; text-align: center; text-transform: capitalize;}p, ul, ol{font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;}p li, ul li, ol li{list-style-position: inside; margin-left: 5px;}a{color: #3498db; text-decoration: underline;}.btn{box-sizing: border-box; width: 100%;}.btn > tbody > tr > td{padding-bottom: 15px;}.btn table{width: auto;}.btn table td{background-color: #ffffff; border-radius: 5px; text-align: center;}.btn a{background-color: #ffffff; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; color: #3498db; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize;}.btn-primary table td{background-color: #3498db;}.btn-primary a{background-color: #3498db; border-color: #3498db; color: #ffffff;}.last{margin-bottom: 0;}.first{margin-top: 0;}.align-center{text-align: center;}.align-right{text-align: right;}.align-left{text-align: left;}.clear{clear: both;}.mt0{margin-top: 0;}.mb0{margin-bottom: 0;}.preheader{color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;}.powered-by a{text-decoration: none;}hr{border: 0; border-bottom: 1px solid #f6f6f6; margin: 20px 0;}@media only screen and (max-width: 620px){table[class=body] h1{font-size: 28px !important; margin-bottom: 10px !important;}table[class=body] p, table[class=body] ul, table[class=body] ol, table[class=body] td, table[class=body] span, table[class=body] a{font-size: 16px !important;}table[class=body] .wrapper, table[class=body] .article{padding: 10px !important;}table[class=body] .content{padding: 0 !important;}table[class=body] .container{padding: 0 !important; width: 100% !important;}table[class=body] .main{border-left-width: 0 !important; border-radius: 0 !important; border-right-width: 0 !important;}table[class=body] .btn table{width: 100% !important;}table[class=body] .btn a{width: 100% !important;}table[class=body] .img-responsive{height: auto !important; max-width: 100% !important; width: auto !important;}}@media all{.ExternalClass{width: 100%;}.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height: 100%;}.apple-link a{color: inherit !important; font-family: inherit !important; font-size: inherit !important; font-weight: inherit !important; line-height: inherit !important; text-decoration: none !important;}#MessageViewBody a{color: inherit; text-decoration: none; font-size: inherit; font-family: inherit; font-weight: inherit; line-height: inherit;}.btn-primary table td:hover{background-color: #34495e !important;}.btn-primary a:hover{background-color: #34495e !important; border-color: #34495e !important;}}</style> <link type="text/css" rel="stylesheet" charset="UTF-8" href="https://translate.googleapis.com/translate_static/css/translateelement.css"></head> <body class=""> <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body"> <tbody><tr> <td>&nbsp;</td><td class="container"> <div class="content"> <table role="presentation" class="main"> <tbody><tr> <td class="wrapper"> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tbody><tr> <td><img style="width: 159px;height: 24px;" class="responsive" src="data:image/png;base64,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"><br><br><h3 style="color: #ef5b55; font-size: 24px;">Alerta</h3> <p>Los siguientes ' . $_GET['tipo'] . ', tienen el documento: <strong>' . $_GET['documento'] . '</strong> vencido y a punto de vencer.</p><table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary"> <tbody> <tr> <td align="left"> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tbody> <br><p></p><strong>' . $_GET['id'] . ' Fecha: ' . $_GET['fecha'] . ' </strong><p></p></tbody> </table> </td></tr></tbody> </table> <p>Por favor verifique toda la información</p></td></tr></tbody></table> </td></tr></tbody></table> <div class="footer"> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tbody><tr> <td class="content-block"> <span class="apple-link">myGTEP Negocio, reescrito por software. </span> <br>. </td></tr><tr> <td class="content-block powered-by"> Powered by <a href="">Plenus Services</a>. </td></tr></tbody></table> </div></div></td><td>&nbsp;</td></tr></tbody></table><div id="goog-gt-tt" class="skiptranslate" dir="ltr"><div style="padding: 8px;"><div><div class="logo"></div></div></div><div class="top" style="padding: 8px; float: left; width: 100%;"></div><div class="middle" style="padding: 8px;"><div class="original-text"></div></div><div class="bottom" style="padding: 8px;"><div class="activity-links"></div><div class="started-activity-container"><hr style="color: #CCC; background-color: #CCC; height: 1px; border: none;"><div class="activity-root"></div></div></div><div class="status-message" style="display: none;"></div></div><div class="goog-te-spinner-pos"><div class="goog-te-spinner-animation"><svg xmlns="http://www.w3.org/2000/svg" class="goog-te-spinner" width="96px" height="96px" viewBox="0 0 66 66"><circle class="goog-te-spinner-path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div></div></body></html>';

            $this->mail->Body = $mensaje;
            //$mail->CreateBody($mensagem);
            $this->mail->IsHTML(true);
            //Attach an image file
            //$this->mail->addAttachment(RUTA_UPLOAD . $nombreExtracto);
            //send the message, check for errors
            if (!$this->mail->send()) {
                echo 'Mailer Error: ' . $this->mail->ErrorInfo;
            } else {
                exit();
            }
        } else {
            echo "no existen";
        }
    }

    public function telegramAlert($id_contacto, $mensaje)
    {
        $this->callMethod(array(
            'id_contacto' => $id_contacto,
            'mensaje'     => $mensaje,
        ));
    }
    /**
     * Spanish:
     * Use este método para hacer peticiones al Bot de Telegram myGTEP
     *
     * English:
     * Use this method to make requests to the Bot of Telegram myGTEP
     *
     * @access public
     * @param string
     * @param array
     * @return jsonArray
     */
    public function callMethod($datos = [])
    {


        //Lo primerito, creamos una variable iniciando curl, pasándole la url
        $ch = curl_init($this->url_bot);

        //especificamos el POST (tambien podemos hacer peticiones enviando datos por GET
        curl_setopt($ch, CURLOPT_POST, 1);

        //le decimos qué paramáetros enviamos (pares nombre/valor, también acepta un array)
        curl_setopt($ch, CURLOPT_POSTFIELDS, "id_contacto={$datos['id_contacto']}&mensaje={$datos['mensaje']}");

        //le decimos que queremos recoger una respuesta (si no esperas respuesta, ponlo a false)
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }

    //Método para enviar extractos por correo electronico
    public function enviarExtracto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $id           = $_POST['id'];
            $destinatario = $_POST['email'];
            if (isset($id) && !empty($id)) {

                $this->perfilModelo   = $this->modelo('Perfil');
                $empresa              = $this->perfilModelo->obtenerPerfil(); //Datos de la empresa
                $this->extractoModelo = $this->modelo('Extracto', 'Extractos');
                $extracto             = $this->extractoModelo->obtenerExtracto($id); //Datos del extracto

                //Comprobador de de error 404;
                if ($extracto == false) {
                    echo "404";
                    exit();
                }
                //Información del extracto
                $id_extracto               = $extracto->id_extracto;
                $numero_extracto           = $extracto->numero_extracto;
                $fecha_extracto            = $extracto->fecha_extracto;
                $placa_vehiculo            = $extracto->placa_vehiculo;
                $modelo_vehiculo           = $extracto->modelo_vehiculo;
                $marca_vehiculo            = $extracto->marca_vehiculo;
                $clase_vehiculo            = $extracto->clase_vehiculo;
                $numerointerno_vehiculo    = $extracto->numerointerno_vehiculo;
                $tarjetaoperacion_vehiculo = $extracto->tarjetaoperacion_vehiculo;
                $numero_contrato           = $extracto->numero_contrato;
                $contratante               = $extracto->contratante;
                $nit_cc_contratante        = $extracto->nit_contratante;
                $objeto                    = $extracto->objeto;
                $responsable               = $extracto->responsable;
                $nit_responsable           = $extracto->nit_responsable;
                $telefono_responsable      = $extracto->telefono_responsable;
                $direccion_responsable     = $extracto->direccion_responsable;
                $fecha_inicial             = $extracto->fecha_inicial;
                $fecha_final               = $extracto->fecha_final;
                $tipo_convenio             = $extracto->tipo_convenio;
                if ($tipo_convenio == 1) {
                    $tipo_convenio = "N/A";
                }
                $empresa_convenio = $extracto->empresa_convenio;
                if ($empresa_convenio == 1) {
                    $empresa_convenio = "N/A";
                }
                $nit_empresa_convenio = $extracto->nit_empresa_convenio;
                if ($nit_empresa_convenio == 1) {
                    $nit_empresa_convenio = "N/A";
                }
                $nombre_ruta        = $extracto->nombre_ruta;
                $descripccion       = $extracto->descripccion;
                $nombre_ruta2       = $extracto->nombre_ruta2;
                $descripccion2      = $extracto->descripccion2;
                $nombre_ruta3       = $extracto->nombre_ruta3;
                $descripccion3      = $extracto->descripccion3;
                $conductor          = $extracto->conductor;
                $cc_conductor       = $extracto->cc_conductor;
                $licencia_conductor = $extracto->licencia_conductor;
                $vigencia_conductor = $extracto->vigencia_conductor;
                $conductor2         = $extracto->conductor2;
                $cc_conductor2      = $extracto->cc_conductor2;
                //Reseteo de valores
                if ($cc_conductor2 == 1) {
                    $cc_conductor2 = "";
                }
                $licencia_conductor2 = $extracto->licencia_conductor2;
                $vigencia_conductor2 = $extracto->vigencia_conductor2;
                if ($vigencia_conductor2 == date('9999-12-31')) {
                    $vigencia_conductor2 = "";
                }
                $conductor3    = $extracto->conductor3;
                $cc_conductor3 = $extracto->cc_conductor3;
                //Reseteo de valores
                if ($cc_conductor3 == 1) {
                    $cc_conductor3 = "";
                }
                $licencia_conductor3 = $extracto->licencia_conductor3;
                $vigencia_conductor3 = $extracto->vigencia_conductor3;
                if ($vigencia_conductor3 == date('9999-12-31')) {
                    $vigencia_conductor3 = "";
                }
                $estado_extracto = $extracto->estado_extracto;
                $date_added      = $extracto->date_added;
                $hora_creacion   = $extracto->hora_creacion;

                //Start output
                ob_start();
                require_once RUTA_PLUGINS . 'Extractos' . SEPARATOR . 'Views' . SEPARATOR . 'FuecPdf.php';
                $content = ob_get_clean();
                //End output

                try {
                    // init HTML2PDF para generar PDF
                    $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(
                        0,
                        0,
                        0,
                        0,
                    ));
                    //Titulo documento
                    $html2pdf->pdf->SetTitle('Extracto de Contrato: ' . $numero_extracto);
                    //display the full page
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    // convert
                    $html2pdf->writeHTML($content);
                    // send the PDF
                    //$html2pdf->pdf->IncludeJS('print(TRUE)');
                    $nombreExtracto = time() . '_FUEC:_' . $numero_extracto . '.pdf';
                    $extractoEmail  = $html2pdf->Output(RUTA_UPLOAD . $nombreExtracto, 'F');

                    move_uploaded_file($extractoEmail, RUTA_UPLOAD);

                    if (file_exists(RUTA_UPLOAD . $nombreExtracto)) {
                        //SMTP needs accurate times, and the PHP time zone MUST be set
                        //This should be done in your php.ini, but this is how to do it if you don't have access to that
                        //Tell PHPMailer to use SMTP
                        $this->mail->isSMTP();
                        //Enable SMTP debugging
                        // 0 = off (for production use)
                        // 1 = client messages
                        // 2 = client and server messages
                        $this->mail->SMTPDebug = 0;
                        //Set the hostname of the mail server
                        $this->mail->Host = $this->host;
                        //Set the SMTP port number - likely to be 25, 465 or 587
                        $this->mail->Port = $this->port;
                        //Whether to use SMTP authentication
                        $this->mail->SMTPAuth = true;
                        //Username to use for SMTP authentication
                        $this->mail->Username = $this->userName;
                        //Password to use for SMTP authentication
                        $this->mail->Password = $this->password;
                        //Set who the message is to be sent from
                        $this->mail->setFrom($this->userName, 'GTEP');
                        //Set an alternative reply-to address
                        //$this->mail->addReplyTo('judamo94@hotmail.com', 'First Last');
                        //Set who the message is to be sent to
                        $this->mail->addAddress($destinatario, 'Destinatario');
                        //Set the subject line
                        $this->mail->Subject = 'Extracto de Contrato';

                        $mensagem = "<!DOCTYPE html>
                        <html>
                        <head>
                        <meta name='viewport' content='width=device-width'>
                        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                        <style>.responsive{width: 100%;height: auto;}</style>
                        </head>
                        <body>
                        <img style='width: 159px;height: 24px;'src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWQAAABACAYAAAAtUQ20AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4wMOAxgSiJ+ZJwAAEUdJREFUeNrtnXuUVMWdxz/VPTMXQRCirk9cVIjMQ8Fr1s2yK2qI58QYE5Xpa4KBHgZf2fW5rm+jZleJrxxfwawvmAZFuD3jM1nwqIkL8RXdqxJ6AJ9ohDiCCKgwd6b71v7RjcGhp2/19O2e7pn6nDMHTlfdulV1f/WtdxVoNBqNRqPRaDQajUaj0Wg0Go1Go9FoNBqNRqPRaDQajUaj0Wg0Gk1+iFK85LR57aOqQt5oEHsDw4FqACnZLgSbkHKd3dTwQRDvisxLjCDEAcC+SIYjMAQICd1ItogQHSkv/H5b0/ht+vNrNJWBYVrDgaoyjV7SdezPiybIkVhiDHAc4Pk8H/ZkeFlb0/h3s4bTkjgVwfkCxgAjgd13iPFObAO2SMnHCP47Hq2/r09CPD9xrJDyAhATgD2AEUBND29dwOfAJgnLRSh0kz299m2/sH80d9WImrD3Y6BTIUs3VlVVPfPIGd/sLsaXj8QSP8qkz48qT4RfaJsxfk0eRi8AI/OtpgBHAQcBQ0tVefeCB3wIvAgsBba6ju3mWaBPzqRnoFEN3OM69rosAnYxEKqw9HjA7T0FzjCtl4F/LPO4fww8AywCnge6XMdO5hNAVS8qPQmYpxJAmFQz8JUgn7rgnSFVdJ0oUt6DCEYpBDEUGCoE+wH3RmKJ6yDU2J3seuXxWRNyVgjWg+1VslpMxPNiQlKnoBk1wJ7AngLG4XnNkZbEXARXxKP1G3otzGFvu4SbBCrpkZ2pZNcE4K2gv7YVa68D+VCmYssdC6ArLHbPQ7BOBH4BHAp8o0wN/twdhm+Y1uvARa5jq+bzD4EzB2gD8klgXY/fhme+ZyXyYKbhtDPdFRDvfYHpmb8U8L5hWkuBy13HVuqRh3LUUqqNbG+n1tvkas99VnjyUYQY1ZcUCdhf4L1YXVU1p3HBezW9+Zs6LzGaKvmQkN6rQlDX5y6CoFnACqtl5Yze/KQIJwWottyHSEKRYnxtCaepiHGGW58647AvFYR4omFaDvA/wD+UsRj3NPwTgTWGacUM09pTseU1UJG9mm7lkcqRnkoiDIwFzgO+NEzrFsO09uqrIOdNY0v7mQKeBv45oLGUc4XXuTT78MSag0OCN4HTAyvgQsSs+SvPy+bYFh0vkfIp4Eu14iGvK06xk5co+twKzFcQ4zOB14EjK9jwZwAbDdMaiMMRmoHDpcAGw7SmFFeQhfSslvYLQ0LeDwwJMgUCeXwklmj7Wre9ZdVkIZPvCbXhkDz1TtwdaUlEs7nZTQ0vAEoTj0JQbbW0/2vAwxUXCMFIRe8vp9ij3UeMZwP3DyCD/5NhWsfocq8pc541TOvqogmyhKsQ8o5ixV7AaY2x9gsBps5f3YDwniziuxCCeyOxxKReBPu/8qioLhnZ+lkgE2Gnxf5cDfJGVf8e4tZHowd6OcR4CnDlADP0ELDMMK0Dc3xeTfkzGL7TDYZpNWdzqAog98YXv6TJ6yLz33kI6T6N2gqDQjAEXBFZsGpqfHrt1yYS4k11iyKxxL0ivYLDj/1P+GL9d+PpWdeCCBP+GUilsWMJ7a3RumdziPE+wLMFRKcb2FLCgmOgPm4OECO9QqQnHwD/t1OhT7LrWGWyR7pklt+yzZoPJz3+3htdwCukxxWLkT99WXLVmfmO5YZH38f7LwNeKIFthknPtYwDjga+l6eNAjxomNainpN95bquryejhHRXkp7MKQUnC5kaA2RbEncNcJdCGEOE4NRpD654buGsI/o8oWTNXzlUSnlGHjXkLB8fv8wzCkuBRzJi9pbr2P0y252pSI4Emsg9d/Adw7SmuI793M4/uo59I3BjkeL2beClHF4+dR17cpmVqUWuY88cYC3Pla5jv9hP9rkfcAxwdqZBIBUqhueAf6pEQaaEYpxpG4lzgP/YdSSCpxBcj8JqBAkzNu417KJMC6lvpMJ1IuQdrej7BYFwchhNFaBaCFcAJ7mO/VE5fHzXsTsylcNSw7RuA/6X9JLJbFybMfaSlccK7IZXD8ChgFA/2udfARuwDdM6CVgMDPN5bKJhWvtkbLvoCdgAvCThHon4OcjZUvI0sLZI73sPeEZK8SuJuErCbTK9OHt9H8PLugwuVW38Bfij4nDOsJGbO88qqF4IeTerdvU8aLFn1OUS/3sUwzobmFguYpzF+F8j9yaPOsO0wmg0/WOfvwO+qdKLpscKp2K1kG9Eyvl2U8Mui/anxlbtHZKeJQS/DqQhCxslnBdCPG9H6zp6ukfmtY8mzPnCk5cilLoRO9j71IVvj3ps2rjPdv6x7YyxqUjLygVCiB8qRnA2MKcvaWtckDhKeHxHMR+2eqGwnaN1XANMVQhqmuvYj1SA0a82TOte4JwszntlejAbtDxo+sk+1xumdWymJ5eLH2R6fkVoIUtIIabY0fprsokxQFu0dkO8qX6OJ0PHFvw6yWpqOLA1Wr84mxgDxGfW/SU+o+4yLz38kFfXsbq728waZlNDq1SdSBGMiLQkpvUlfcJTGqvewd2PTh+/NYf7XvhPPDxcCWK8E3YOtylaFgYdZdUrch17GfC+j7eGYo25dCLk5LZo3e9VPLc21S6TiDkFvM8RI4YdGf9JvdKZBmFRcyeS5XkJvvAOzSGXl+UR1KxTYom8jCUSSxwlYIJiPdjJIYde7+NtDLue7bEzG3obpiljcm2bPkLr06CjHMfq/fYujCqKIEvEHXa0IT/B80Kz6ds2yZSU4nz7tDGdqg8sjo5LSsEC8llSI8Xo3pw8wnORcquSlQi+VZ0+I0JNjB9aLYQQP8Z/UmDHG66NHzPEL13H+bgvcR270rYX56qMR2t90pQBftvXw8UQ5K1IeVu+D7XOHL9eyj7Nhi+JN9XlvbzFS4WX5CPIQsoDenNrix7WJYWYpxjUCCE5RTmi3andkPJsRd+fglys4G+ij/uiCjT2jZlWf8h1bNHjb7rWAk0Z4LdnYUPggiwlj8Sb6j/t08Mh8UC+j3SnjJ/15VVtzeM/kqAcTynECB8PjwHbFYcVrlGuCELyEtQ2nyDh2Xi0/kMFr2N83JdXmqW7ji1dx+52HVvqcq8pUw72cX+9CC3k0J19b9DLPFvI8u3Hmsf2fTmW5E/KwuizO+7V741aJhWX1QnB8Mb57c1+/qbf+26NRPwn6pH8laLPYT7i9oUuOxpNcBimNYn0ZHrO3n6ggiwlbrypdlVfn4/PrN+YV/NGhpYVGOUV6totci4LXLvvflIgb1fWTk/+3M9P55Dtlwvl+LE8PqP+VdWqTxcRjaZkYlyF/7EJLrAy2BaywCl8zEN984ZEvllQdEPyPfWk9boT7CvsaMMcmf18g2yt5P0jscQJvblbsT+PEohGRTEmJMJBbX31dBHSaALlUfz1YyPQEaggC8TqAERdeVw3JMTawrRfbMsrZmreblAMr0ZIpkbmJ0LZ41Z1FIrLtYRkSXey6/2AjEe3ngcfA7ES7ve5BMO0ag3TWgOcrOD9op4rm6oCyIGOANKhfOqUlN4XhcVXbBUBfzchaEFymUKNCAILIf6d9F2CPUTWu1mxCkhK5NxHm48IqlAl0Qw2jjdM63HKa+3up65jNxfwfHVmy3wpz7QwgDrgFKCZ9Jixyp6DV1zHbu35Y+HHb0rZUUJB6EbgFvIimRKbCQVckSbFXwnL54HvK/geJTxvGvC11SWRWOJYwFSsBD/p6t79Kd1a0hTAgZm/cuLjAp9vraD8z3oqYxBjyNsDiJyyIEtE2V12aDfXdnkyD2OQux4DKaT65CCIm584a4wbYBL0kIWmHBgsdjjFdexENocADhcSnQFEUDUMSZlegDh6aE3LR9u77hEq11gJ8XeRlvbGeFNdK4AVS0zOdHsUckBuijfV31XuFmeY1ijgpH56vQDedx37j2g05cXxrmM/35tj4YJcWnlMUabjnbdb42QklrgJuF4x4y4EWk+PrQpJvDPwP1N3R5/m8iJEvxh5+vfAgn78JHEUj0nVaErAcqDZdex3chdvTWB0J3e7FcXxWCE4vHF+e20yHN4DqXyozzpPhJ4oQtSLcQyrpH/Hpru0RWr6WxKAjzJDFJP9xLhYBXHQ8visQ7ZZscQDpA9492OPkGSKTHYfhFC8rVvy29bpdfqMX00QdACryixOGwdAvn4M/J70BOPrrmOv7e+W0aDGE6FFIenNROWKHCkvQfieMfE37yJ0e5GirW9kHnwsGYB36v0b6d1xpe75J4FNrmN/Vo5d1UFNVTcvpar4UKgctykYo7xNWtIWb6pdU6Ro1+gvN+gYiHfqrXMd++1KToAeQw6YRbNqO4WU8wMNVEq6q0LnVljhLNUCfX3Sm2bgNOh0FgRP5+7Vtwz5MvmL4BRHLHz8p7XFHF8LXDhdx3YowVCIYVpakDUDBt1CLgJPNh7WKRF3B6XvCObpXNVotCBr+kjKC98WUFDvfD5s5PMlaGmGKy2PDdMaoS1NowVZ45+xoWQH/uehKiBnL208IIiNG35rgmsrMJv31Zam0YKs8aU1Wu9KeIyCNkfI9Xa04ZGAorTZx/24CszmQ7SlabQga9SapCljIerndGT7POcFGJ13fdx/UIFZfGQOtw5tgRotyJqvaGseu0XS5wm51RL+EGB0/G7p/hfDtCrNHnLd5P2atkCNFmTN1+gaMvTqvqzLktAWj9ZtDjAqy8i9ZncYcH+l5KthWmOAo3N4WaqtT6MFWfM1njj94C0CFuenxhLhhX4dcFQ6AL/bVpoN05pYIVn7cA63DcBWbX0aLciaLAIr7iOfHWVC3GfPrP04yCi4jr0VeEXB60uGae1W5q3jScCkHF5Wuo6tD93XaEHW7IoHHwCfKGk3EAp5lxYpKio3Wg8BPjJMa0KZivFx+J9zfLO2Ok0lordOl6LWE/I4YB+lxjHcvWj64UXpbruOvcUwrTuAi3y8fgN4wzCtu4DfuI69ur/z0DAtA5gJ/MbH6wrXsZ/WVufLKMO0jijTRlnCdezuwfhRghBkUcIwQiWObyBnMUi4RjGgL2WRb9lwHftiw7SagJEK3i8ALjBM6wughfREWQLYBGxzHTvQm0YyuwVrgGrXsbcapiWABuAc0kcrqnQwmrTWKvF91C7lLTUp4CBgvRbkv7EauBP/SwfDCLkygHg8BryF/zhrJ4hPCnpTiHXAHFC6vfqDQhMWaUlEBWpnHkvJGweuHFeK5VpjSa9L3kPR/+7AeZm/nQU0lzAWVMHlCDsX17qO/brWWs2AEmQ7Wv9GZG7iYpUA4s31hZ+2lWKuUiBCEJ9ZV9D72qK1ayNzE+eXKoMF8g51HRI33n5bTdFPL3Md+1PDtPYH3syIc/DJLj0LXce+QRdpzYAcsghEaBUp5btK+b5ILDETUDoAR8KqeFPdklLlgevY24BxhmndAlxa4XZ8tevYs3Vx1lQ6epVFkTi9JTFEwHTlPBahs/ojnq5jXwZMAB6qwGxeDZygxVgz4FvImsLwwowVHscren8Nz+u3sU/XsVcA0w3TmgH8EphGetJveBlm7VbSEz5Xuo79uLa0XJ0utpO+uaWSSDGIb4HRglw0RWaOcsGRcmG8qWFbf0fZdWwJXGGY1lWkJ/xGAN8GjiI91rwX6fHhcObf0E49gB2/5UMyx/9F5t8twFrSZ1MsBza7jr25zL62X7qNfohTB3BwhZaeTVl+U7mZPVzpsqEFuQhMbUlMEjBZsRnTVRWWD5RT/F3H9oDPMn8fkO/W78GHAxyTo2XX3U/fcOMAyuPv4n/3Y8Vvl9fXvxeBSEviD0Koni8sb7KjDVfqXNNoNLqFHLQYxxITBXxL0XunSMprda5pNBrQqyyK0eX4KemNFAqNY25aPOvwbp1rGo1GC3LA/OThNcOBCxW9b0YKPTar0Wi0IBeDZDJ5M4rDQBJetmfWrda5ptFodvD/CDxxNeRhHEIAAAAASUVORK5CYII='><br><br>
                        <hr>
                        <table><tbody><tr>
                         <td style='background-color: #ffffff;'>
                        <div style='color: #2C3E50; font-family: sans-serif'>
                            <h2 style='color: #052d4b; margin: 0 0 7px'>Se ha generado un documento  para ti</h2>
                            <p style='margin: 2px; font-size: 15px'>
                                    Extracto de contrato generado: <span style='color:#333;'><strong>" . date("Y-m-d H:i:s") . "</strong></span>
                            </div>
                        </div>
                       </td>
                       </tr>
                       </tbody></table><div style='font-size: 15px;  margin: 10px 0; color:red; text-align: center'></div><p style='color: #22222; font-size: 12px; text-align: center;margin: 30px 0 0; font-family: sans-serif;'>GTEP Power by: <a style='color: #22222;' href='https://www.plenusservices.com/'>Plenus Services</a></p>
                        </body>
                        </html>";

                        //Read an HTML message body from an external file, convert referenced images to embedded,
                        //convert HTML into a basic plain-text alternative body
                        //$this->mail->msgHTML(file_get_contents(RUTA_UPLOAD . 'Email_template.html'), __DIR__);
                        $this->mail->Body = $mensagem;
                        //$mail->CreateBody($mensagem);
                        $this->mail->IsHTML(true);
                        //Attach an image file
                        $this->mail->addAttachment(RUTA_UPLOAD . $nombreExtracto);
                        //send the message, check for errors
                        if (!$this->mail->send()) {
                            echo 'Mailer Error: ' . $this->mail->ErrorInfo;
                        } else {
                            echo 'true';
                            //Elimar archivo de extracto temporal
                            unlink(RUTA_UPLOAD . $nombreExtracto);
                            exit();
                        }
                    }
                } catch (HTML2PDF_exception $e) {
                    echo $e;
                    exit;
                }
            }
        } else {
            redireccionar('');
        }
    }

    //Método para enviar alertas de documentos
    public function emailVerification($email, $clave = null, $type = null)
    {        //Tell PHPMailer to use SMTP

        $this->mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->mail->SMTPDebug = 0;
        //Set the hostname of the mail server
        $this->mail->Host = $this->host;
        //Set the SMTP port number - likely to be 25, 465 or 587
        $this->mail->Port = $this->port;
        //Whether to use SMTP authentication
        $this->mail->SMTPAuth = true;
        //Username to use for SMTP authentication
        $this->mail->Username = $this->userName;
        //Password to use for SMTP authentication
        $this->mail->Password = $this->password;
        //Set who the message is to be sent from
        $this->mail->setFrom($this->userName, NOMBRE_APP);
        //Set an alternative reply-to address
        //$this->mail->addReplyTo('judamo94@hotmail.com', 'First Last');
        //Set who the message is to be sent to
        $this->mail->addAddress($email, $email);
        //Set the subject line
        $this->mail->Subject = 'Clave dinámica';
        

        if ($clave == null && $type == null) {
            $mensaje = '<html class=""><head><meta http-equiv="Content-Type"content="text/html; charset=utf-8"><meta name="viewport"content="width=device-width"><title>Simple Transactional Email</title><style>img{ border:none; -ms-interpolation-mode:bicubic; max-width:100%;} body{ background-color:#f6f6f6; font-family:sans-serif; -webkit-font-smoothing:antialiased; font-size:14px; line-height:1.4; margin:0; padding:0; -ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;} table{ border-collapse:separate; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%;} table td{ font-family:sans-serif; font-size:14px; vertical-align:top;} .body{ background-color:#f6f6f6; width:100%;} .container{ display:block; margin:0 auto !important; max-width:580px; padding:10px; width:580px;} .content{ box-sizing:border-box; display:block; margin:0 auto; max-width:580px; padding:10px;} .main{ background:#ffffff; border-radius:3px; width:100%;} .wrapper{ box-sizing:border-box; padding:20px;} .content-block{ padding-bottom:10px; padding-top:10px;} .footer{ clear:both; margin-top:10px; text-align:center; width:100%;} .footer td, .footer p, .footer span, .footer a{ color:#999999; font-size:12px; text-align:center;} h1, h2, h3, h4{ color:#000000; font-family:sans-serif; font-weight:400; line-height:1.4; margin:0; margin-bottom:30px;} h1{ font-size:35px; font-weight:300; text-align:center; text-transform:capitalize;} p, ul, ol{ font-family:sans-serif; font-size:14px; font-weight:normal; margin:0; margin-bottom:15px;} p li, ul li, ol li{ list-style-position:inside; margin-left:5px;} a{ color:#3498db; text-decoration:underline;} .btn{ box-sizing:border-box; width:100%;} .btn>tbody>tr>td{ padding-bottom:15px;} .btn table{ width:auto;} .btn table td{ background-color:#ffffff; border-radius:5px; text-align:center;} .btn a{ background-color:#ffffff; border:solid 1px #3498db; border-radius:5px; box-sizing:border-box; color:#3498db; cursor:pointer; display:inline-block; font-size:14px; font-weight:bold; margin:0; padding:12px 25px; text-decoration:none; text-transform:capitalize;} .btn-primary table td{ background-color:#3498db;} .btn-primary a{ background-color:#3498db; border-color:#3498db; color:#ffffff;} .last{ margin-bottom:0;} .first{ margin-top:0;} .align-center{ text-align:center;} .align-right{ text-align:right;} .align-left{ text-align:left;} .clear{ clear:both;} .mt0{ margin-top:0;} .mb0{ margin-bottom:0;} .preheader{ color:transparent; display:none; height:0; max-height:0; max-width:0; opacity:0; overflow:hidden; mso-hide:all; visibility:hidden; width:0;} .powered-by a{ text-decoration:none;} hr{ border:0; border-bottom:1px solid #f6f6f6; margin:20px 0;} @media only screen and (max-width:620px){ table[class=body] h1{ font-size:28px !important; margin-bottom:10px !important;} table[class=body] p, table[class=body] ul, table[class=body] ol, table[class=body] td, table[class=body] span, table[class=body] a{ font-size:16px !important;} table[class=body] .wrapper, table[class=body] .article{ padding:10px !important;} table[class=body] .content{ padding:0 !important;} table[class=body] .container{ padding:0 !important; width:100% !important;} table[class=body] .main{ border-left-width:0 !important; border-radius:0 !important; border-right-width:0 !important;} table[class=body] .btn table{ width:100% !important;} table[class=body] .btn a{ width:100% !important;} table[class=body] .img-responsive{ height:auto !important; max-width:100% !important; width:auto !important;}} @media all{ .ExternalClass{ width:100%;} .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{ line-height:100%;} .apple-link a{ color:inherit !important; font-family:inherit !important; font-size:inherit !important; font-weight:inherit !important; line-height:inherit !important; text-decoration:none !important;} #MessageViewBody a{ color:inherit; text-decoration:none; font-size:inherit; font-family:inherit; font-weight:inherit; line-height:inherit;} .btn-primary table td:hover{ background-color:#34495e !important;} .btn-primary a:hover{ background-color:#34495e !important; border-color:#34495e !important;}} </style><link type="text/css"rel="stylesheet"charset="UTF-8"href="https://translate.googleapis.com/translate_static/css/translateelement.css"></head><body class=""><table role="presentation"border="0"cellpadding="0"cellspacing="0"class="body"><tbody><tr><td>&nbsp;</td><td class="container"><div class="content"><table role="presentation"class="main"><tbody><tr><td class="wrapper"><table role="presentation"border="0"cellpadding="0"cellspacing="0"><tbody><tr><td><img style="width:159px;height:24px;"class="responsive"src="data:image/png;base64,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"><br><br><h3 style="color:#ef5b55; font-size:24px;">Clave dinámica</h3><p>Usted ha habilitado el servicio de clave dinámica de '. NOMBRE_APP .'</p><table role="presentation"border="0"cellpadding="0"cellspacing="0"class="btn btn-primary"><tbody><tr><td align="left"><table role="presentation"border="0"cellpadding="0"cellspacing="0"><tbody><p></p><strong>Fecha:' . date("Y-m-d") . ' </strong></tbody></table></td></tr></tbody></table><p>Por favor verifique toda la información</p></td></tr></tbody></table></td></tr></tbody></table><div class="footer"><table role="presentation"border="0"cellpadding="0"cellspacing="0"><tbody><tr><td class="content-block"><span class="apple-link">myGTEP Negocio, reescrito por software. </span><br>. </td></tr><tr><td class="content-block powered-by">Powered by <a href="">Plenus Services</a>. </td></tr></tbody></table></div></div></td><td>&nbsp;</td></tr></tbody></table><div id="goog-gt-tt"class="skiptranslate"dir="ltr"><div style="padding:8px;"><div><div class="logo"></div></div></div><div class="top"style="padding:8px; float:left; width:100%;"></div><div class="middle"style="padding:8px;"><div class="original-text"></div></div><div class="bottom"style="padding:8px;"><div class="activity-links"></div><div class="started-activity-container"><hr style="color:#CCC; background-color:#CCC; height:1px; border:none;"><div class="activity-root"></div></div></div><div class="status-message"style="display:none;"></div></div><div class="goog-te-spinner-pos"><div class="goog-te-spinner-animation"><svg xmlns="http://www.w3.org/2000/svg"class="goog-te-spinner"width="96px"height="96px"viewBox="0 0 66 66"><circle class="goog-te-spinner-path"fill="none"stroke-width="6"stroke-linecap="round"cx="33"cy="33"r="30"></circle></svg></div></div></body></html>';
        } else {
            $mensaje = '<html class=""><head><meta http-equiv="Content-Type"content="text/html; charset=utf-8"><meta name="viewport"content="width=device-width"><title>Simple Transactional Email</title><style>img{ border:none; -ms-interpolation-mode:bicubic; max-width:100%;} body{ background-color:#f6f6f6; font-family:sans-serif; -webkit-font-smoothing:antialiased; font-size:14px; line-height:1.4; margin:0; padding:0; -ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;} table{ border-collapse:separate; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%;} table td{ font-family:sans-serif; font-size:14px; vertical-align:top;} .body{ background-color:#f6f6f6; width:100%;} .container{ display:block; margin:0 auto !important; max-width:580px; padding:10px; width:580px;} .content{ box-sizing:border-box; display:block; margin:0 auto; max-width:580px; padding:10px;} .main{ background:#ffffff; border-radius:3px; width:100%;} .wrapper{ box-sizing:border-box; padding:20px;} .content-block{ padding-bottom:10px; padding-top:10px;} .footer{ clear:both; margin-top:10px; text-align:center; width:100%;} .footer td, .footer p, .footer span, .footer a{ color:#999999; font-size:12px; text-align:center;} h1, h2, h3, h4{ color:#000000; font-family:sans-serif; font-weight:400; line-height:1.4; margin:0; margin-bottom:30px;} h1{ font-size:35px; font-weight:300; text-align:center; text-transform:capitalize;} p, ul, ol{ font-family:sans-serif; font-size:14px; font-weight:normal; margin:0; margin-bottom:15px;} p li, ul li, ol li{ list-style-position:inside; margin-left:5px;} a{ color:#3498db; text-decoration:underline;} .btn{ box-sizing:border-box; width:100%;} .btn>tbody>tr>td{ padding-bottom:15px;} .btn table{ width:auto;} .btn table td{ background-color:#ffffff; border-radius:5px; text-align:center;} .btn a{ background-color:#ffffff; border:solid 1px #3498db; border-radius:5px; box-sizing:border-box; color:#3498db; cursor:pointer; display:inline-block; font-size:14px; font-weight:bold; margin:0; padding:12px 25px; text-decoration:none; text-transform:capitalize;} .btn-primary table td{ background-color:#3498db;} .btn-primary a{ background-color:#3498db; border-color:#3498db; color:#ffffff;} .last{ margin-bottom:0;} .first{ margin-top:0;} .align-center{ text-align:center;} .align-right{ text-align:right;} .align-left{ text-align:left;} .clear{ clear:both;} .mt0{ margin-top:0;} .mb0{ margin-bottom:0;} .preheader{ color:transparent; display:none; height:0; max-height:0; max-width:0; opacity:0; overflow:hidden; mso-hide:all; visibility:hidden; width:0;} .powered-by a{ text-decoration:none;} hr{ border:0; border-bottom:1px solid #f6f6f6; margin:20px 0;} @media only screen and (max-width:620px){ table[class=body] h1{ font-size:28px !important; margin-bottom:10px !important;} table[class=body] p, table[class=body] ul, table[class=body] ol, table[class=body] td, table[class=body] span, table[class=body] a{ font-size:16px !important;} table[class=body] .wrapper, table[class=body] .article{ padding:10px !important;} table[class=body] .content{ padding:0 !important;} table[class=body] .container{ padding:0 !important; width:100% !important;} table[class=body] .main{ border-left-width:0 !important; border-radius:0 !important; border-right-width:0 !important;} table[class=body] .btn table{ width:100% !important;} table[class=body] .btn a{ width:100% !important;} table[class=body] .img-responsive{ height:auto !important; max-width:100% !important; width:auto !important;}} @media all{ .ExternalClass{ width:100%;} .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{ line-height:100%;} .apple-link a{ color:inherit !important; font-family:inherit !important; font-size:inherit !important; font-weight:inherit !important; line-height:inherit !important; text-decoration:none !important;} #MessageViewBody a{ color:inherit; text-decoration:none; font-size:inherit; font-family:inherit; font-weight:inherit; line-height:inherit;} .btn-primary table td:hover{ background-color:#34495e !important;} .btn-primary a:hover{ background-color:#34495e !important; border-color:#34495e !important;}} </style><link type="text/css"rel="stylesheet"charset="UTF-8"href="https://translate.googleapis.com/translate_static/css/translateelement.css"></head><body class=""><table role="presentation"border="0"cellpadding="0"cellspacing="0"class="body"><tbody><tr><td>&nbsp;</td><td class="container"><div class="content"><table role="presentation"class="main"><tbody><tr><td class="wrapper"><table role="presentation"border="0"cellpadding="0"cellspacing="0"><tbody><tr><td><img style="width:159px;height:24px;"class="responsive"src="data:image/png;base64,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"><br><br><h3 style="color:#ef5b55; font-size:24px;">Clave dinámica</h3><p>Su clave dinámica es <strong>' . $clave . '</strong></p><table role="presentation"border="0"cellpadding="0"cellspacing="0"class="btn btn-primary"><tbody><tr><td align="left"><table role="presentation"border="0"cellpadding="0"cellspacing="0"><tbody><p></p><strong>Fecha:' . date("Y-m-d") . '</strong></tbody></table></td></tr></tbody></table><p>Por favor verifique toda la información</p></td></tr></tbody></table></td></tr></tbody></table><div class="footer"><table role="presentation"border="0"cellpadding="0"cellspacing="0"><tbody><tr><td class="content-block"><span class="apple-link">myGTEP Negocio, reescrito por software. </span><br>. </td></tr><tr><td class="content-block powered-by">Powered by <a href="">Plenus Services</a>. </td></tr></tbody></table></div></div></td><td>&nbsp;</td></tr></tbody></table><div id="goog-gt-tt"class="skiptranslate"dir="ltr"><div style="padding:8px;"><div><div class="logo"></div></div></div><div class="top"style="padding:8px; float:left; width:100%;"></div><div class="middle"style="padding:8px;"><div class="original-text"></div></div><div class="bottom"style="padding:8px;"><div class="activity-links"></div><div class="started-activity-container"><hr style="color:#CCC; background-color:#CCC; height:1px; border:none;"><div class="activity-root"></div></div></div><div class="status-message"style="display:none;"></div></div><div class="goog-te-spinner-pos"><div class="goog-te-spinner-animation"><svg xmlns="http://www.w3.org/2000/svg"class="goog-te-spinner"width="96px"height="96px"viewBox="0 0 66 66"><circle class="goog-te-spinner-path"fill="none"stroke-width="6"stroke-linecap="round"cx="33"cy="33"r="30"></circle></svg></div></div></body></html>';
        }

        $this->mail->Body = $mensaje;
        //$mail->CreateBody($mensagem);
        $this->mail->IsHTML(true);
        //Attach an image file
        //$this->mail->addAttachment(RUTA_UPLOAD . $nombreExtracto);
        //send the message, check for errors
        if (!$this->mail->send()) {
            echo 'Mailer Error: ' . $this->mail->ErrorInfo;
        } else {
            return true;
        }
    }
}
