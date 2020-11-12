var ruta = document.getElementById("ruta").value;

$("#guardar_pass").submit(function(event) {
    $("#guardar_datos").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Login/sendRecoveryCode",
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html("Mensaje: Cargando...");
      },
      success: function(datos) {
        var result = datos;
        if (datos == true) {
          $("#guardar_datos").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i>Se ha enviado un correo electrónico con las instrucciones para el cambio de tu contraseña.</h6>'
          );
        } else {
          $("#guardar_datos").attr("disabled", false);
          alertify.warning(result);
        }
      }
    });
    event.preventDefault();
  });
