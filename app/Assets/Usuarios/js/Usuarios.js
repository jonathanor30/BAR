var ruta = $("#ruta").val();
$(document).ready(function() {
  var filter = $("#filter").val();
  $("#Usuarios").DataTable({
    processing: true,
    serverSide: true,
    language: { url: ruta + "/public/js/Spanish.json" },
    ajax: {
      url: ruta + "/usuarios/tableViews",
      type: "POST",
      data: function(d) {
        d.id = $("#filter").val();
      }
    },
    columns: [
      { data: "IdTipoDocumento" },
      { data: "Numero_Documento" },
      { data: "firstname" },
      { data: "user_name" },
      { data: "user_email" },
      {
        data: "user_type",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          switch (oData.user_type) {
            case "1":
              var estado = "Empleado";
              var clase = "badge badge-success";
              break;
            case "2":
              var estado = "Administrador";
              var clase = "badge badge-primary";
              break;
          }
          $(nTd).html("<span class='" + clase + "'>" + estado + "</span>");
        }
      },
      {
        data: "estado_usuario",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          switch (oData.estado_usuario) {
            case "1":
              var estado = "Activo";
              var clase = "badge badge-success";
              break;
            case "2":
              var estado = "Inactivo";
              var clase = "badge badge-danger";
              break;
            case "0":
              var estado = "Desvinculado";
              var clase = "badge badge-warning";
              break;
          }
          $(nTd).html("<span class='" + clase + "'>" + estado + "</span>");
        }
      },
      {
        data: "user_id",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
              ruta +
              "/usuarios/editar/" +
              oData.user_id +
              "'>" +
              "<i class='fas fa-edit'></i>" +
              "</a><a title='Eliminar' href='#' class='btn btn-sm btn-outline-secondary' onclick='eliminar(" +
              oData.user_id +
              "," +
              oData.user_type +
              ");'><i class='fas fa-trash-alt'></i></a></div>"
          );
        }
      }
    ]
  });
});
function eliminar(id, type) {
  var q = id;
  var pre = document.createElement("H5");
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  //pre.style.whiteSpace = "pre-wrap";

  pre.style.textAlign = "center";

  pre.appendChild(
  
    document.createTextNode("Realmente desea eliminar este usuario")
  );

  alertify.confirm(
    pre,
    function() {
      $.ajax({
        type: "POST",
        url: ruta + "/usuarios/borrar",
        data: "id=" + id + "&type=" + type,
        q: q,
        beforeSend: function(objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == "true") {
            $("#Usuarios")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i> Usuario eliminado correctamente  </h6>'
            );
          } else {
            console.log(datos);
            alertify.warning(
              '<i class="fas fa-ban"></i> Error al eliminar usuario'
            );
          }
        }
      });
    },
    function() {
      alertify.error('<i class="fas fa-ban"></i> Cancelado');
    }
  );
}
$("#guardar_usuario").submit(function(event) {
  $("#guardar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: ruta + "/usuarios/agregar",
    data: parametros,
    beforeSend: function(objeto) {
      //$("#resultados_ajax").html("Mensaje: Cargando...");
    },
    success: function(datos) {
      var result = datos;
      if (datos == true) {
        $("#Usuarios")
          .DataTable()
          .ajax.reload();
        $("#exampleModal").modal("hide");
        $("#guardar_usuario")[0].reset();
        $("#guardar_datos").attr("disabled", false);
        alertify.success(
          '<h6><i class="fas fa-check"></i> Usuario creado correctamente</h6>'
        );
      } else {
        $("#guardar_datos").attr("disabled", false);
        alertify.warning(result);
      }
    }
  });
  event.preventDefault();
});

$(document).ready(function() {
  $("form").keypress(function(e) {
    if (e == 13) {
      return false;
    }
  });

  $("input").keypress(function(e) {
    if (e.which == 13) {
      return false;
    }
  });
});

function reloadTable() {
  var select = document.getElementById("filter").value;
  switch (select) {
    case "1":
      document.getElementById("filter").className = "btn btn-success";
      break;
    case "2":
      document.getElementById("filter").className = "btn btn-warning";
      break;
    case "3":
      document.getElementById("filter").className = "btn btn-danger";
      break;
    case "":
      document.getElementById("filter").className = "btn btn-secondary";
      break;
  }

  $("#Usuarios")
    .DataTable()
    .ajax.reload();
}

function validityPassword() {
  var confirm = document.getElementById("user_password_repeat").value;
  var pass = document.getElementById("user_password_new").value;
  if (pass != null && pass != "" && confirm != null && confirm != "") {
    if (confirm == pass) {
      $("#user_password_new").attr(
        "class",
        "form-control form-control-sm border-success"
      );
      $("#user_password_repeat").attr(
        "class",
        "form-control form-control-sm border-success"
      );
    } else {
      $("#user_password_new").attr(
        "class",
        "form-control form-control-sm border-danger"
      );
      $("#user_password_repeat").attr(
        "class",
        "form-control form-control-sm border-danger"
      );
    }
  } else {
    $("#user_password_new").attr("class", "form-control form-control-sm");
    $("#user_password_repeat").attr("class", "form-control form-control-sm");
  }
}
