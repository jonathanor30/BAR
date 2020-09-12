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
      font-weight: 700;
      font-size: 12px
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
</style>
<page backtop="50mm" backbottom="6mm" backleft="6.5mm" backright="6.5mm" style="font-size: 12px; font-family: Arial" footer="page">
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
   $imgSuperAncho = number_format($imgSuper[0] * 0.25, 0);
   $imgSuperAlto = number_format($imgSuper[1] * 0.25, 0);
   $logoAncho = number_format($imgEmpresa[0] * 0.70, 0);
   $logoAlto = number_format($imgEmpresa[1] * 0.70, 0);

   //phpinfo();die;
   //Total en letras
   $V           = new EnLetras();
   $setTotal = explode(".", number_format($factura[0]->total, 2, '.', ''));
   $con_letra   = strtoupper($V->ValorEnLetras(number_format($factura[0]->total, 2, '.', ''), "pesos-"));
   $centavos    = strtoupper($V->ValorEnLetras(number_format($setTotal[1], 2, '.', ''), "centavos"));
   $centavos = str_replace(" 00", "", $centavos);
   $totalFinalSet = explode("-", $con_letra);
   //[0]=resolucion, [1]=Rangodesde,[2]=Rangohasta,[3]=Fechadesde,[4]=Fechahasta
   $porcent = ""; //Porcentaje del iva aplicado



   ?>
   <page_header>
      <table class="page-header" cellspacing="0">
         <?php if (isset($resolution) && $resolution != null) : ?>
            <tr>
               <td style="width: 40%; color: #444444;">
                  <div style="margin-top: 15px; align-content: center;" align="left">
                     <img style="width:<?php echo $logoAncho; ?>; height:<?php echo $logoAlto ?>;opacity:0.7;" src="<?php echo RUTA_UPLOAD . $empresa->logo_url; ?>" alt="Logo">
                  </div>
               </td>
               <td style="width: 60%;text-align:center">
                  <h5>DOCUMENTO SOPORTE No: <?php echo $resolution->prefix . $factura[0]->numero ?></h5>
                  <strong>Numero de Autorización:</strong> <?php echo $resolution->resolution; ?><br>
                  <strong>Rango Autorizado Desde:</strong> <?php echo $resolution->from_number; ?><br>
                  <strong>Rango Autorizado Hasta:</strong> <?php echo $resolution->to_number; ?><br>
                  <strong>Vigencia numeración:</strong> <?php echo $resolution->date_to; ?><br>
                  <strong>Fecha de documento:</strong> <?php echo  $factura[0]->fecha ?>

               </td>
            </tr>
         <?php else : ?>
            <tr>
               <td style="width: 40%; color: #444444;">
                  <div style="margin-top: 15px; align-content: center;" align="left">
                     <img style="width:<?php echo $logoAncho; ?>; height:<?php echo $logoAlto ?>;opacity:0.7;" src="<?php echo RUTA_UPLOAD . $empresa->logo_url; ?>" alt="Logo">
                  </div>
               </td>
               <td style="width: 60%;text-align:right;">
                  <h3>DOCUMENTO EQUIVALENTE No: <?php echo $factura[0]->numero ?></h3>
               </td>
            </tr>
         <?php endif; ?>
      </table>
   </page_header>
   <table border="0.1" id="customers" cellspacing="0" style="width: 100%; text-align: left; font-size: 13px;">
      <tr>
         <td style="width:50%; text-align: center" class="midnight-blue">
            <strong>EMISOR</strong>
         </td>
         <td style="width:50%; text-align: center" class="midnight-blue">
            <strong>TERCERO/PROVEEDOR</strong>
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
            <strong>E-MAIL:</strong> <?php echo $empresa->email ?><br>
         </td>
         <td style="width:50%;">
            <strong>CLIENTE:</strong> <?php echo $client->nombre ?><br>
            <strong>NIT/CC:</strong> <?php echo $client->cifnif ?><br>
            <strong>CIUDAD:</strong> <?php echo $client->cityprov ?><br>
            <strong>DEPARTAMENTO:</strong> <?php echo $client->deptoprov ?><br>
            <strong>DIRECCIÓN:</strong> <?php echo $client->direccion ?><br>
            <strong>TELÉFONO:</strong> <?php echo $client->telefono1 ?><br>
            <strong>E-MAIL:</strong> <?php echo $client->email ?><br>
         </td>
      </tr>
      <tr>
         <td colspan="2" style="text-align: center" class="midnight-blue"><strong>OBSERVACIONES</strong></td>
      </tr>
      <tr>
         <td colspan="2" style="text-align: justify;word-break: break-all;">
            <?php echo $factura[0]->observaciones ?>
         </td>
      </tr>
   </table>
   <br>
   <table id="customers" cellspacing="0" style="width: 100%;">
      <tr style="text-align: center;font-weight: bold" class="midnight-blue">
         <td style=" width: 4%">
            #
         </td>
         <td style="width:3%">
            Cant
         </td>
         <td style="width: 12%">
            PRODUCTO/SERVICIO
         </td>
         <td style="width: 11%">
            REFERENCIA
         </td>
         <td style="width: 11%">
            Vr UNITARIO
         </td>
         <td style="width: 12%">
            % IMPUESTO <br> VR IMPUESTO
         </td>
         <td style="width: 11%">
            RETENCION
         </td>
         <td style="width: 11%">
            DESCUENTO
         </td>
         <td style="width: 12%">
            TOTAL
         </td>
      </tr>
      <?php
      $neto = 0;
      $iva = 0;
      $retencion = 0;
      $dto = 0;
      ?>
      <?php foreach ((object)$factura[1] as $key => $value) : ?>
         <?php switch (($value->total / $value->neto * 100) - 100) {
            case 19:
               $porcent = '19.00';
               break;
            case 5:
               $porcent = '5.00';
               break;
            case 0:
               $porcent = '0.00';
               break;
            default:
               $porcent = '0.00';
               break;
         }

         ?>
         <tr>
            <td style="width: 4%; text-align: center">
               <?php echo $value->No_linea ?>
            </td>
            <td style="width:3%;text-align: center;">
               <?php echo $value->cantidad ?>
            </td>
            <td align="" style="width: 23% ;word-break: break-all;font-size: 11px;">
               <?php echo str_replace("\r\n", "</br>", $value->articulo) ?>
            </td>
            <td style="width: 11%;text-align: center;word-break: break-all;font-size: 11px;">
               <?php echo $factura[0]->referencia ?>
            </td>
            <td style="width: 13%;text-align: center;font-size: 11px;">
               <?php echo  "$" . number_format($value->precio, 2, ',', '.') ?>
            </td>
            <td style="width: 12%;text-align: center;font-size: 11px;">
               <?php echo $porcent; ?>%<br><?php echo   "$" . number_format($value->iva, 2, ',', '.') ?>
            </td>
            <td style="width: 11%;text-align: center;font-size: 11px;">
               <?php echo number_format(($value->retencion / $value->neto) * 100, 2, ",", "."); ?>%<br><?php echo   "$" . number_format($value->retencion, 2, ',', '.') ?>
            </td>
            <td style="width: 11%;text-align: center;font-size: 11px;">
               <?php echo   "$" . number_format($value->dto, 2, ',', '.') ?>
            </td>
            <td style="width: 12%;text-align: center;font-size: 11px;">
               <?php echo   "$" . number_format($value->total, 2, ',', '.') ?>
            </td>
         </tr>
      <?php
         $neto = $neto + $value->neto;
         $iva = $iva + $value->iva;
         $retencion = $retencion + $value->retencion;
         $dto = $dto + $value->dto;
      endforeach; ?>
   </table>
   <page_footer>
      <table id="customers" align="right" cellspacing="0" style="width:100%;padding:25px 25px 25px 25px;">
         <tr>
            <td style="width:auto;font-weight:bold;word-break: break-all;font-size: 15px;background: <?php echo $empresa->moneda; ?>;color:#fff;">Totales</td>
         </tr>
         <tr>
            <td style="width: 100%;">
               <strong style='font-size: 12px;'>TOTAL BASE IMPONIBLE:</strong> $<?php echo  number_format($neto, 2, ',', '.') ?><br>
               <strong style='font-size: 12px;'>IVA <?php echo $porcent; ?>%:</strong> <?php echo number_format($iva, 2, ',', '.') ?><br>
               <strong style='font-size: 12px;'>TOTAL RETENCIONES:</strong> $<?php echo number_format($retencion, 2, '.', '') ?><br>
               <strong style='font-size: 12px;'>TOTAL DESCUENTOS:</strong> $<?php echo  number_format($dto,  2, ',', '.') ?><br>
               <strong style='font-size: 12px;'>TOTAL:</strong> $<?php echo number_format($factura[0]->total, 2, ',', '.') ?><br>
               <strong style='font-size: 12px;'>TOTAL EN LETRAS:</strong><br>
               <?php echo $totalFinalSet[0] . ", CON " . $centavos; ?>
            </td>
         </tr>
      </table>
      <table class="page_footer">
         <tr>
            <td style="width:40%;text-align:left;">
               <?php echo "Documento generado e impreso por " . NOMBRE_APP . " | ";
               echo  date('Y'); ?>
            </td>
            <td style="width:20%; text-align: center">
               <img style="width:<?php echo $imgSuperAncho ?>px;heigth:<?php echo $imgSuperAlto ?>px;" src="<?php echo RUTA_UPLOAD ?>Empresa/img/logo-super.png" alt="Logo">
            </td>
            <td style="width:40%; text-align: right">
            </td>
         </tr>
      </table>
   </page_footer>
</page>