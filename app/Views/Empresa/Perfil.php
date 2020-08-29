<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<br>
<div class="container-fluid">
   <div class="card">
      <h5 class="card-header"><i class="<?php echo $datos['icon'] ?>"></i> Configuración</h5>
      <div class="card-body">
         <div>
            <div id="load_img">
               <img class="img-fluid" src="<?php echo RUTA_URL ?>/Empresa/files?img=<?php echo $datos['empresa']->logo_url; ?>" alt="Logo">
            </div>
            <br>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group col-md-6">
                     <form id="logo-profile">
                        <div class="upload-btn-wrapper">
                           <input class='filestyle' data-buttonText="Logo" type="file" name="imagefile" id="imagefile" onchange="upload_image();">
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div id="info_empresa">
            <form method="POST" action="" id="form-info" autocomplete="off">
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label>Nombre de la empresa</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-building fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->nombre_empresa; ?>" type="text" class="form-control form-control-sm" id="nombre_empresa" name="nombre_empresa" placeholder="Escribe el nombre de tu empresa">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>NIT</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-hashtag fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->nit_empresa; ?>" type="text" class="form-control form-control-sm" id="nit_empresa" name="nit_empresa" placeholder="Numero de identificación">
                     </div>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label>Dirección Territorial</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-street-view fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->direccion_territorial; ?>" type="text" class="form-control form-control-sm" id="direccion_territorial" name="direccion_territorial" placeholder="Dirección territorial de su emprea">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Resolucion empresa</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-scroll fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->resolucion_empresa; ?>" type="text" class="form-control form-control-sm" id="resolucion_empresa" name="resolucion_empresa" placeholder="resolución del ministerio">
                     </div>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label>Año habilitación empresa (Ultimos 2 digitos)</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-layer-group fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->numero_habilitacion; ?>" type="text" class="form-control form-control-sm" id="numero_habilitacion" name="numero_habilitacion" placeholder="Escriba los dos ultimos digitos del año de habilitación">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Teléfono</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-phone fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->telefono; ?>" type="text" class="form-control form-control-sm" id="telefono" name="telefono" placeholder="Numero de telefono de la empresa">
                     </div>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label>Correo electrónico</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-envelope fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->email; ?>" type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Escriba el correo de la empresa">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Representante legal</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-user fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->representante_legal; ?>" type="text" class="form-control form-control-sm" id="representante_legal" name="representante_legal" placeholder="Representante legal">
                     </div>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label>Servidor verificación FUEC</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-server fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->servidor_verificacion; ?>" type="text" class="form-control form-control-sm" id="servidor_verificacion" name="servidor_verificacion" placeholder="Escriba la url del servidor FUEC">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Dirección</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-map-marked-alt fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->direccion; ?>" type="text" class="form-control form-control-sm" id="direccion" name="direccion" placeholder="Escriba la dirección de la empresa">
                     </div>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label>Ciudad</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-city fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->ciudad; ?>" type="text" class="form-control form-control-sm" id="ciudad" name="ciudad" placeholder="Ciudad de la empresa">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Región/Provincia</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-map-signs fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->estado; ?>" type="text" class="form-control form-control-sm" id="estado" name="estado" placeholder="Región de la empresa">
                     </div>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label>Correo de alertas</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-mail-bulk fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input required="" value="<?php echo $datos['empresa']->email_alerta; ?>" type="email" class="form-control form-control-sm" id="email_alerta" name="email_alerta" placeholder="Escriba el correo que remitirá las alertas">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>ID Telegram</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fab fa-telegram-plane fa-fw" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input value="<?php echo $datos['empresa']->id_telegram; ?>" type="text" class="form-control form-control-sm" id="id_telegram" name="id_telegram" placeholder="Ingrese un id de Telegram para recibir alertas">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Banco:</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-wallet" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input class="form-control form-control-sm" type="text" id="nombre_banco" name="nombre_banco" value="<?php echo $datos['empresa']->nombre_banco; ?>" placeholder="Ingrese el nombre del banco...">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Tipo de cuenta:</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-hand-pointer" aria-hidden="true"></i>
                           </span>
                        </span>
                        <select class="form-control form-control-sm" id="tipo_cuenta" name="tipo_cuenta">
                           <?php switch ($datos['empresa']->tipo_cuenta) {
                              case 'Ahorros':
                                 echo '<option selected value="Ahorros">AHORROS</option>
                                       <option value="Corriente">CORRIENTE</option>';
                                 break;
                              case 'Corriente':
                                 echo '<option value="Ahorros">AHORROS</option>
                                       <option selected value="Corriente">CORRIENTE</option>';
                                 break;

                              default:
                                 echo '<option selected disabled>Seleccione el tipo de cuenta</option>
                                    <option value="Ahorros">AHORROS</option>
                                    <option value="Corriente">CORRIENTE</option>';
                                 break;
                           } ?>

                        </select>
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Número de cuenta:</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-hashtag" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input class="form-control form-control-sm" type="text" id="numero_cuenta" name="numero_cuenta" value="<?php echo $datos['empresa']->numero_cuenta; ?>" placeholder="Ingrese el número de la cuenta...">
                     </div>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="favcolor">Seleccione su color favorito:</label>
                     <div class="input-group">
                        <span class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fas fa-fill-drip" aria-hidden="true"></i>
                           </span>
                        </span>
                        <input class="form-control form-control-sm" type="color" id="favcolor" name="favcolor" value="<?php echo $datos['empresa']->moneda; ?>">
                     </div>
                  </div>
               </div>
               <button type="submit" id="guardar_datos" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </form>
            <hr>
            <br>
            <!-- Button trigger modal -->
            <button type="button" title="Configuración de correo electronico para envio de alertas y documentos." class="btn btn-sm btn-primary" data-toggle="modal" data-target="#CorreoModal">
               <i class="fas fa-server fa-fw" aria-hidden="true"></i> Servidor de correo
            </button>
            <!-- Modal -->
            <div class="modal fade" id="CorreoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Configuración de correo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <div class="form-group">
                           <label>Servidor</label>
                           <input type="text" class="form-control form-control-sm form-control form-control-sm-sm" id="hostEmail" name="hostEmail" value="<?php echo $datos['empresa']->hostEmail ?>" placeholder="mail.tudominio.com">
                           <small id="emailHelp" class="form-text text-muted">Solo para correo corporativo</small>
                        </div>
                        <div class="form-group">
                           <label>Cuenta de correo</label>
                           <input type="email" class="form-control form-control-sm form-control form-control-sm-sm" id="userEmail" name="userEmail" value="<?php echo $datos['empresa']->userEmail ?>" placeholder="gtep@tudominio.com">
                        </div>
                        <div class="form-group">
                           <label>Contraseña</label>
                           <input type="password" class="form-control form-control-sm form-control form-control-sm-sm" id="passwordEmail" name="passwordEmail" placeholder="*********">
                        </div>
                        <div class="form-group">
                           <label>Repetir Contraseña</label>
                           <input type="password" class="form-control form-control-sm form-control form-control-sm-sm" id="repassword" name="repassword" placeholder="*********">
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                           <button type="button" class="btn btn-primary" id="btnEmail" onclick="configEmail();">Guardar</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <br>
            <hr>
            <div class="row">
               <div class="form-group col-md-6">
                  <div class="col-xs-3">
                     <div id="load_img_firma">
                        <a href="#" data-toggle="modal" data-target="#ModalFirma">
                           <img style="height:48px; width: 150px;" class="img-fluid" src="<?php echo RUTA_URL ?>/Empresa/files?img=<?php echo $datos['empresa']->firma ?>" alt="Foto">
                        </a>
                        <h4>Firma representante</h4>
                        <small>alto 223px, ancho 700px;</small>
                        <!-- Modal Imagen licencia -->
                        <div class="modal fade" id="ModalFirma" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h4 class="modal-title">Firma</h4>
                                    <button type="button" class="btn close" data-dismiss="modal">&times;</button>
                                 </div>
                                 <div class="modal-body">
                                    <img class="img-fluid" src="<?php echo RUTA_URL ?>/Empresa/files?img=<?php echo $datos['empresa']->firma ?>">
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-rojo-claro" data-dismiss="modal">Cerrar</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <br>
                     <div class="row">
                        <div class="col-md-8">
                           <div class="form-group">
                              <div id="respuesta"></div>
                              <form action="" id="guardar_imagen" enctype="multipart/form-data">
                                 <input class='filestyle' data-buttonText="Foto" type="file" name="image_firma" id="image_firma" onchange="upload_image_firma();">
                                 <br>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script type="text/javascript">
      $("#form-info").submit(function(event) {
         $('#guardar_datos').attr("disabled", true);
         var parametros = $(this).serialize();
         $.ajax({
            type: "POST",
            url: "<?php echo RUTA_URL ?>/empresa/editarPerfil",
            data: parametros,
            beforeSend: function(objeto) {
               //$("#resultados_ajax").html("Mensaje: Cargando...");
            },
            success: function(datos) {
               var result = datos;
               if (datos == 'true') {
                  $('#guardar_datos').attr("disabled", false);
                  alertify.success('<h6><i class="fas fa-check"></i> Datos guardados correctamente</h6>');
               } else {
                  $('#guardar_datos').attr("disabled", false);
                  alertify.warning(result);
                  console.log(datos);
               }
            }
         });
         event.preventDefault();

      });

      $(document).ready(function() {

         $('form').keypress(function(e) {
            if (e == 13) {
               return false;
            }
         });

         $('input').keypress(function(e) {
            if (e.which == 13) {
               return false;
            }
         });

      });

      function upload_image() {

         var inputFileImage = document.getElementById("imagefile");
         var file = inputFileImage.files[0];
         if ((typeof file === "object") && (file !== null)) {
            $("#load_img").text('Cargando...');
            var data = new FormData();
            data.append('imagefile', file);


            $.ajax({
               url: "<?php echo RUTA_URL ?>/empresa/logoEmpresa",
               type: "POST",
               data: data,
               contentType: false,
               cache: false,
               processData: false,
               success: function(resultado) {

                  $("#load_img").html(resultado);
                  $("#logo-profile")[0].reset();
               }
            });
         }


      }

      function upload_image_firma() {

         var inputFileImage = document.getElementById("image_firma");
         var file = inputFileImage.files[0];
         if ((typeof file === "object") && (file !== null)) {
            $("#load_img_firma").text('Cargando...');
            var data = new FormData();
            data.append('image_firma', file);


            $.ajax({
               url: "<?php echo RUTA_URL ?>/empresa/firmaImagen",
               type: "POST",
               data: data,
               contentType: false,
               cache: false,
               processData: false,
               success: function(resultado) {

                  $("#load_img_firma").html(resultado);

               }
            });
         }


      }

      function cargado() {
         alertify.success('<h6><i class="fas fa-check"></i> Imagen cargada correctamente</h6>');
      }

      function configEmail() {
         $('#btnEmail').attr("disabled", true);
         var server = $("#hostEmail").val();
         var usuario = $("#userEmail").val();
         var password = $("#passwordEmail").val();
         var repassword = $("#repassword").val();
         if (server != "" && usuario != "" && password != "" && repassword != "") {
            if (password == repassword) {
               $.ajax({
                  type: "POST",
                  url: "<?php echo RUTA_URL ?>/empresa/configEmail",
                  data: 'server=' + server + '&usuario=' + usuario + '&password=' + password,
                  beforeSend: function(objeto) {
                     //$("#resultados_ajax").html("Mensaje: Cargando...");
                  },
                  success: function(datos) {
                     var result = datos;
                     if (datos == 'true') {
                        $('#btnEmail').attr("disabled", false);
                        alertify.success('<h6><i class="fas fa-check"></i> Datos guardados correctamente</h6>');
                     } else {
                        $('#btnEmail').attr("disabled", false);
                        alertify.warning(result);
                        console.log(datos);
                     }
                  }
               });

            } else {
               alertify.warning('<h6> La contraseña no coincide</h6>');
            }
         } else {
            alertify.warning('<h6> Complete los campos</h6>');
            $('#btnEmail').attr("disabled", false);
         }
      }
   </script>
   <?php require RUTA_APP . '/Views/inc/footer.php'; ?>