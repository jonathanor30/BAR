$("#guardar_Tipo").submit(function(event) {
    $("#guardar_datos").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Configuracion/agregar",
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html("Mensaje: Cargando...");
      },
      success: function(datos) {
        var result = datos;
        if (datos == true) {
          $("#Configuracion")
            .DataTable()
            .ajax.reload();
          $("#exampleModal").modal("hide");
          $("#guardar_Tipo")[0].reset();
          $("#guardar_datos").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Tipo producto creado correctamente</h6>'
          );
        } else {
          $("#guardar_datos").attr("disabled", false);
          alertify.warning(result);
        }
      }
    });
    event.preventDefault();
  });
  