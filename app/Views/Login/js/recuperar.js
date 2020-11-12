$("#txtCorreoElectronico").submit(function(event) {
    $("#txtCorreoElectronico").attr("disabled", true);
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
          $("#Login")
            .DataTable()
            .ajax.reload();

          $("#txtCorreoElectronico").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i>Se ha enviado un correo electrónico con las instrucciones para el cambio de tu contraseña. Por favor verifica la información enviada</h6>'
          );
        } else {
          $("#txtCorreoElectronico").attr("disabled", false);
          alertify.warning(
            '<h6><i class="fas fa-check"></i>El correo electrónico no se encuentra registrado en el sistema.</h6>'
            
          );
        }
      }
    });
    event.preventDefault();
  });