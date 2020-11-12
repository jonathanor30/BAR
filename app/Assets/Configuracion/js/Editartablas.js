var ruta = document.getElementById("ruta").value;

$("#form-info").submit(function(event) {
         $('#guardar_datos').attr("disabled", true);
         var parametros = $(this).serialize();
         $.ajax({
            type: "POST",
            url: "/Configuracion/editarHome",
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
