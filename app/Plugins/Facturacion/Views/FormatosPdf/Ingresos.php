<style type="text/css">
   <!--
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
   -->
</style>
<page backtop="38mm" backbottom="6mm" backleft="6.5mm" backright="6.5mm" style="font-size: 12px; font-family: Arial" footer="page">
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



   ?>
   <page_header>
      <table class="page-header" cellspacing="0">
         <tr>
            <td style="width: 40%; color: #444444;">
               <div style="margin-top: 15px; align-content: center;" align="left">
                  <img style="width:<?php echo $logoAncho; ?>; height:<?php echo $logoAlto ?>;opacity:0.7;" src="<?php echo RUTA_UPLOAD . $empresa->logo_url; ?>" alt="Logo">
               </div>
            </td>
            <td style="width: 60%;text-align:right;">
               <p><strong style="font-size: 20px;"><?php echo $empresa->nombre_empresa ?></strong><br />
                  NIT/CC: <?php echo $empresa->nit_empresa ?> <br />
                  <?php echo $empresa->direccion . ' - Teléfono: ' . $empresa->telefono ?></p>
            </td>
         </tr>
      </table>
   </page_header>
   <h3 style="text-align: center;">RECIBO DE INGRESO No <?php echo $ingreso[0]->numero ?></h3>
   <table id="customers" cellspacing="0" style="width: 100%; text-align: left;">
      <tr>
         <td style="width: 25%"><strong>Ingreso No</strong></td>
         <td style="width: 25%; text-align: center;">
            <?php echo $ingreso[0]->numero ?>
         </td>
         <td style="width: 25%"><strong><?php if ($factura[0]->numero2 != "") {
                                             echo 'Factura Electrónica No';
                                          } else {
                                             echo 'Factura No';
                                          } ?>
            </strong></td>
         <td style="width: 25%; text-align: center;">
            <?php if ($factura[0]->numero2 != "") {
               echo $factura[0]->numero2;
            } else {
               echo $factura[0]->numero;
            } ?>
         </td>
      </tr>
      <tr>
         <td style="width: 25%"><strong>Cliente</strong></td>
         <td style="width: 25%; text-align: center;">
            <?php echo $cliente->nombre ?>
         </td>
         <td style="width: 25%"><strong>NIT/CC</strong></td>
         <td style="width: 25%; text-align: center;">
            <?php echo $cliente->cifnif ?>
         </td>
      </tr>
      <tr>
         <td style="width: 25%"><strong>Dirección</strong></td>
         <td style="width: 25%; text-align: center;">
            <?php echo $cliente->direccion ?>
         </td>
         <td style="width: 25%"><strong>Teléfono</strong></td>
         <td style="width: 25%; text-align: center;">
            <?php echo $cliente->telefono1 ?>
         </td>
      </tr>
      <tr>
         <td style="width: 25%"><strong>Importe Ingreso</strong></td>
         <td style="width: 25%; text-align: center;">
            <?php echo "$  " . number_format($ingreso[0]->importe, 0, ',', '.') ?>
         </td>
         <td style="width: 25%"><strong>Estado</strong></td>
         <td style="width: 25%; text-align: center;">
            <?php switch ($ingreso[0]->estado_ingreso) {
               case 0:
                  echo "Emitido";
                  break;
               case 1:
                  echo "Pagado";
                  break;
            } ?>
         </td>
      </tr>
      <tr>
         <td style="width: 25%"><strong>Forma de pago</strong></td>
         <td style="width: 25%; text-align: center;">
            <?php switch ($ingreso[0]->fp) {
               case 1:
                  echo "Efectivo";
                  break;
               case 2:
                  echo "Crédito";
                  break;
            } ?>
         </td>
         <td style="width: 25%"><strong>Emitido:</strong></td>
         <td style="width: 25%; text-align: center;">
            <?php echo $ingreso[0]->date_added ?>
         </td>
      </tr>

   </table>
   <table id="customers" cellspacing="0" style="width: 100%; text-align: left;">
      <tr>
         <td style="width: 50%" ;>
            <strong>Concepto:</strong>
            <br>
            <?php echo $ingreso[0]->concepto ?>
            <br><br><br>
         </td>
         <td style="width: 50%" ;>
            <strong>Firma:</strong>
         </td>
      </tr>
   </table>
   <br>
   <page_footer>

      <table class="page_footer">
         <tr>
            <td style="width:40%;text-align:left;">
               <?php echo "Documento generado e impreso por " . NOMBRE_APP . " | ";
               echo  date('Y'); ?>
            </td>
            <td style="width:20%;text-align:center">
               <img style="width:<?php echo $imgSuperAncho . '%;heigth:' . $imgSuperAlto ?>%" src="<?php echo RUTA_UPLOAD ?>Empresa/img/logo-super.png" alt="Logo">

            </td>
            <td style="width:40%; text-align: right">
            </td>
         </tr>
      </table>
   </page_footer>
</page>