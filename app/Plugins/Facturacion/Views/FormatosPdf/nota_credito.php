<style type="text/css">
    table {
        vertical-align: top
    }

    tr {
        vertical-align: top
    }

    td {
        vertical-align: top
    }

    .midnight-blue {
        background: <?php echo $empresa->moneda; ?>;
        padding: 4px 4px 4px;
        color: #fff;
        font-weight: bold;
        font-size: 11px
    }

    .silver {
        background: #fff;
        padding: 3px 4px 3px
    }

    .clouds {
        background: #ecf0f1;
        padding: 3px 4px 3px
    }

    .border-top {
        border-top: solid 1px #bdc3c7
    }

    .border-left {
        border-left: solid 1px #bdc3c7
    }

    .border-right {
        border-right: solid 1px #bdc3c7
    }

    .border-bottom {
        border-bottom: solid 1px #bdc3c7
    }

    table.page_footer {
        width: 100%;
        border: none;
        background-color: #fff;
        padding: 2mm;
        border-collapse: collapse;
        border: none
    }

    .page-header {
        width: 100%;
        padding: 20px 25px 25px 25px;
    }

    #customers {
        border-collapse: collapse;
        width: 100%;

    }

    #customers td,
    th {
        border: 0.1px solid #333;
        padding: 4px;
    }

    hr {
        border: 0.1px;
        padding: 20px;
    }
</style>
<page backtop="50mm" backbottom="6mm" backleft="5.5mm" backright="5.5mm" style="font-size: 11px; font-family: Arial" footer="page">
    <?php
    /*-------------------------
        Autor: Juan Bautista | PLENUSSERVICES S.A.S
        Web: www.plenusservices.com
        Email: contacto@plenusservices.com
        App nombre: GTEP
        ---------------------------*/

    //Formato de fecha para hosting
    //setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

    //Formato de fecha para servers locales
    setlocale(LC_TIME, 'es_ES.UTF-8');


    $imgEmpresa    = getimagesize(RUTA_UPLOAD . $empresa->logo_url);
    $imgSuper      =  getimagesize(RUTA_UPLOAD . 'Empresa/img/logo-super.png');
    $imgSuperAncho = number_format($imgSuper[0] * 0.35, 0);
    $imgSuperAlto = number_format($imgSuper[1] * 0.35, 0);
    $logoAncho = number_format($imgEmpresa[0] * 0.70, 0);
    $logoAlto = number_format($imgEmpresa[1] * 0.70, 0);


    //Total en letras
    $V           = new EnLetras();
    $setTotal = explode(".", number_format($factura[0]->total, 2, '.', ''));
    $con_letra   = ucfirst($V->ValorEnLetras(number_format($factura[0]->total, 2, '.', ''), "pesos-"));
    $centavos    = ucfirst($V->ValorEnLetras(number_format($setTotal[1], 2, '.', ''), "centavos"));
    $centavos = str_replace(" 00", "", $centavos);
    $totalFinalSet = explode("-", $con_letra);

    $dateDIAN = explode("|", $factura[0]->fecha_hora_dian);
    //[0]=resolucion, [1]=Rangodesde,[2]=Rangohasta,[3]=Fechadesde,[4]=Fechahasta
    $infoTrasabilidad = explode("|", $factura[0]->codtrans);
    $d = $infoTrasabilidad[4]; //Fecha de expedicion de extracto, consultado de la bd
    $vigencia = strftime("%d de %B de %Y", strtotime($d)); // 09 de marzo de 2010
    $porcent = ""; //Porcentaje del iva aplicado

    $totalRetenciones = 0;
    //Acá se calcula el total de la retención
    ?>
    <page_header>
        <table class="page-header" cellspacing="0">
            <tr>
                <td style="width: 40%; color: #444444;">
                    <div style="margin-top: 15px; align-content: center;" align="left">
                        <img style="width:<?php echo $logoAncho; ?>; height:<?php echo $logoAlto ?>;opacity:0.7;" src="<?php echo RUTA_UPLOAD . $empresa->logo_url; ?>" alt="Logo">
                    </div>
                </td>
                <td style="width: 60%;text-align:left;">
                    <?php if ($notaCredito->prefijo == "NC") : ?>
                        <h5>NOTA CRÉDITO ELECTRÓNICA No: <?php echo $notaCredito->prefijo . $notaCredito->numero2 ?></h5>
                    <?php else : ?>
                        <h5>NOTA DÉBITO ELECTRÓNICA No: <?php echo $notaCredito->prefijo . $notaCredito->numero2 ?></h5>
                    <?php endif; ?>
                    <strong>Numero de Autorización:</strong> <?php echo $infoTrasabilidad[0]; ?><br>
                    <strong>Rango Autorizado Desde:</strong> <?php echo $infoTrasabilidad[1]; ?><br>
                    <strong>Rango Autorizado Hasta:</strong> <?php echo $infoTrasabilidad[2]; ?><br>
                    <strong>Vigencia numeración:</strong> <?php echo $vigencia; ?><br>
                    <strong>Fecha de Nota:</strong> <?php echo  $dateDIAN[0] ?>
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table id="customers" align="right" cellspacing="0" style="width:100%;padding:25px 25px 25px 25px;">
            <tr>
                <td style="width: 100%;font-weight:bold;font-size: 15px;background: <?php echo $empresa->moneda; ?>;color:#fff;">Observaciones</td>
            </tr>
            <tr>
                <td style="width:100%;word-break: break-all;">
                    <?php echo $factura[0]->observaciones ?>
                </td>
            </tr>
        </table>
        <table id="customers" align="right" cellspacing="0" style="width:100%;padding:25px 25px 25px 25px;">
            <tr>
                <td style="width: 50%;word-break: break-all;" rowspan="2">
                    <qrcode value="<?php echo $notaCredito->qr ?>" ec="M" style="width: 38mm; background-color: white; color: black;border:none;margin-top:5px;margin-bottom: 5px;"></qrcode>
                    <br><br><a style="color:#186487;" href="<?php echo $notaCredito->qr ?>" target="_blank">Verificación DIAN</a>
                </td>
                <td style="width:auto;font-weight:bold;word-break: break-all;font-size: 15px;background: <?php echo $empresa->moneda; ?>;color:#fff;">Totales</td>
            </tr>
            <tr>
                <td style="width: 50%;font-size:11px;">
                    <strong>Moneda:</strong><?php $factura[0]->coddivisa ?><br>
                    <hr>
                    <strong>TOTAL BASE IMPONIBLE:</strong> $<?php echo  number_format($factura[0]->Lines->sum("neto"),  2, ',', '.') ?><br>
                    <hr>
                    <strong>IVA <?php echo $porcent; ?>%:</strong>$ <?php echo  number_format($factura[0]->Lines->sum("iva"), 2, ',', '.') ?><br>
                    <hr>
                    <strong>TOTAL RETENCIONES:</strong> $<?php echo  number_format($factura[0]->Lines->sum("retencion"), 2, '.', ',') ?><br>
                    <hr>
                    <strong>TOTAL DESCUENTO:</strong> $<?php echo  number_format($factura[0]->Lines->sum("dto"), 2, ',', '.') ?><br>
                    <hr>
                    <strong>TOTAL RECARGO:</strong> $<?php echo  number_format($factura[0]->Lines->sum("recargo"), 2, ',', '.') ?><br>
                    <hr>
                    <strong>TOTAL:</strong> $<?php echo  number_format($factura[0]->Lines->sum("pvptotal"), 2, ',', '.') ?><br>
                    <hr>
                    <strong>TOTAL EN LETRAS:</strong><br>
                    <?php echo $totalFinalSet[0] . ", con " . $centavos; ?>.
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong style="font-size:11px;">CUDE: <?php echo $notaCredito->cufedian ?></strong>
                </td>
            </tr>
        </table>
        <table class="page_footer">
            <tr>
                <td style="width:40%;text-align:left;font-size:10px">
                    <?php echo "Documento generado e impreso por " . NOMBRE_APP . " | ";
                    echo  date('Y'); ?>
                </td>
                <td style="width:20%;text-align: center">
                    <img style="width:<?php echo $imgSuperAncho ?>px;heigth:<?php echo $imgSuperAlto ?>px;" src="<?php echo RUTA_UPLOAD ?>Empresa/img/logo-super.png" alt="Logo">

                </td>
                <td style="width:40%; text-align: right">
                </td>
            </tr>
        </table>
    </page_footer>
    <table border="0.1" id="customers" cellspacing="0" style="width: 100%; text-align: left;">
        <tr>
            <td style="width:50%; text-align: center" class="midnight-blue">
                <strong>EMISOR</strong>
            </td>
            <td style="width:50%; text-align: center" class="midnight-blue">
                <strong>ADQUIRIENTE</strong>
            </td>
        </tr>
        <tr>
            <td style="width:50%;">
                <strong>NOMBRE:</strong> <?php echo $empresa->nombre_empresa ?><br>
                <strong>NIT/CC:</strong> <?php echo $empresa->nit_empresa ?><br>
                <strong>CIUDAD:</strong> <?php echo $empresa->ciudad ?><br>
                <strong>DEPARTAMENTO:</strong> <?php echo $empresa->estado ?><br>
                <strong>DIRECCIÓN:</strong> <?php echo $empresa->direccion ?><br>
                <strong>TELÉFONO:</strong> <?php echo $empresa->telefono ?><br>
               <strong>E-MAIL:</strong> <?php echo $company->userEmail ?><br>
            </td>
            <td style="width:50%;">
                <strong>CLIENTE:</strong> <?php echo $client->nombre ?><br>
                <strong>NIT/CC:</strong> <?php echo $client->cifnif ?><br>
                <strong>CIUDAD:</strong> <?php echo $client->ciudad ?><br>
                <strong>DEPARTAMENTO:</strong> <?php echo $client->departamento ?><br>
                <strong>DIRECCIÓN:</strong> <?php echo $client->direccion ?><br>
                <strong>TELÉFONO:</strong> <?php echo $client->telefono1 ?><br>
                <strong>E-MAIL:</strong> <?php echo $client->email ?><br>
            </td>
        </tr>
        <tr>

        </tr>

        <tr>
            <td colspan="2" style="text-align: center" class="midnight-blue"><strong>FACTURA REFERENCIADA</strong></td>
        </tr>
        <tr>
            <td colspan="2">
                FACTURA DE VENTA No: <?php echo $factura[0]->Invoice->prefijo . $factura[0]->Invoice->numero2 ?><br>
                CUFE: <a style="color:#186487;" href="<?php echo $factura[0]->Invoice->qr ?>" target="_blank"><?php echo $factura[0]->Invoice->cufedian ?></a><br>
            </td>
        </tr>
    </table>
    <br>
    <table id="customers" cellspacing="0" style="width: 100%;">
        <tr class="midnight-blue">
            <td colspan="5"></td>
            <td style="text-align:center" colspan="2">Cargos o Descuentos</td>
            <td style="text-align:center" colspan="3">Impuestos</td>
            <td style="text-align:center;width: 70px;" rowspan="2">Total item</td>
        </tr>
        <tr class="midnight-blue">
            <td style="text-align:center;width: 20px;">#</td>
            <td style="width: 85px;text-align:center">Código</td>
            <td style="width: 150px;text-align:center">Descripción</td>
            <td style="width: 25px;text-align:center">Cant</td>
            <td style="text-align:center">Precio Unitario</td>
            <td style="text-align:center">Descuento</td>
            <td style="text-align:center">Recargo</td>
            <td style="text-align:center">IVA</td>
            <td style="text-align:center">ICA</td>
            <td style="text-align:center">INC</td>
        </tr>
        <?php foreach ($factura[0]->Lines()->get() as $key => $value) : ?>
            <tr>
                <td><?php echo $value->no_linea ?></td>
                <td style="word-break: break-all;width: 85px;text-align:center"><?php echo $value->referencia ?? 'N/A' ?></td>
                <td align="justify" style="word-break: break-all;width: 150px;"><?php echo $value->descripcion ?></td>
                <td style="width: 30px;text-align:center;word-break: break-all;"><?php echo $value->cantidad ?></td>
                <?php if ($factura[0]->idfactura == 34) : ?>
                    <td style="width: 60px;text-align:center;word-break: break-all;">$<?php echo number_format(1897133, 2, ',', '.') ?></td>
                <?php else : ?>
                    <td style="width: 60px;text-align:center;word-break: break-all;">$<?php echo number_format($value->pvpunitario, 2, ',', '.') ?></td>
                <?php endif; ?>
                <td style="width: 40px;text-align:center;word-break: break-all;">$<?php echo number_format($value->dtopor, 2, ',', '.') ?></td>
                <td style="width: 40px;text-align:center;word-break: break-all;">$<?php echo number_format($value->recargo, 2, ',', '.') ?></td>
                <td style="width: 60px;text-align:center;word-break: break-all;">$<?php echo number_format($value->iva, 2, ',', '.') ?></td>
                <td></td>
                <td></td>
                <?php if ($factura[0]->idfactura == 34) : ?>
                    <td style="width: 60px;text-align:center;word-break: break-all;">$<?php echo number_format(1897133, 2, ',', '.') ?></td>
                <?php else : ?>
                    <td style="width: 60px;text-align:center;word-break: break-all;">$<?php echo number_format($value->pvptotal, 2, ',', '.') ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
   
</page>