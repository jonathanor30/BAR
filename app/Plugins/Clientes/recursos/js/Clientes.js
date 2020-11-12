var ruta = $("#ruta").val();
$(document).ready(function () {
  var filter = $("#filter").val();
  $("#Clientes").DataTable({
    processing: true,
    serverSide: true,
    language: { url: ruta + "/public/js/Spanish.json" },
    ajax: {
      url: ruta + "/Clientes/tableViews",
      type: "POST",
      data: function (d) {
        d.id = $("#filter").val();
      },
    },
    columns: [
      
      {
        data: "IdTipoDocumento",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          switch (oData.IdTipoDocumento) {
            case "1":
              var Tipo = "Cedula";
              var clase = "";
              break;
            case "2":
              var Tipo = "Cedula extranjera";
              var clase = "";
              break;
            case "3":
              var Tipo = "NIT";
              var clase = "";
              break;
          }
          $(nTd).html("<span class='" + clase + "'>" + Tipo + "</span>");
        },
      },
      { data: "Numero_Documento" },
      { data: "Nombre" },
      {
        data: "IdCliente",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            "<div class='btn-group'> <a title='Actualizar' href='#' class='btn btn-sm btn-outline-secondary' (" +
              oData.IdProducto +
              "," +
              oData.Estado_P +
              ");'><i class='fas fa-eye'></i></a><a title='Actualizar' href='#' class='btn btn-sm btn-outline-secondary' onclick='Eliminar(" +
              oData.IdProducto +
              "," +
              oData.Estado_P +
              ");</div>"
          );
        },
      },
    ],
  });
});
function actualizar(id, type) {
  var q = id;
  var pre = document.createElement("H5");
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  //pre.style.whiteSpace = "pre-wrap";
  pre.style.textAlign = "center";

  pre.appendChild(
    document.createTextNode("Realmente desea actualizar este producto")
  );

  alertify.confirm(
    pre,
    function () {
      $.ajax({
        type: "POST",
        url: ruta + "/productos/actualizar",
        data: "id=" + id + "&type=" + type,
        q: q,
        beforeSend: function (objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
          var result = datos;
          if (datos == "true") {
            $("#Productos").DataTable().ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i> producto actualizado correctamente</h6>'
            );
          } else {
            console.log(datos);
            alertify.warning(
              '<i class="fas fa-ban"></i> Error al actualizar producto'
            );
          }
        },
      });
    },
    function () {
      alertify.error('<i class="fas fa-ban"></i> Cancelado');
    }
  );
}
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

  $("#Productos").DataTable().ajax.reload();
}

function Eliminar(id) {
  var q = id;
  var pre = document.createElement("H5");
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  //pre.style.whiteSpace = "pre-wrap";
  pre.style.textAlign = "center";

  pre.appendChild(
    document.createTextNode("Realmente desea eliminar este producto")
  );

  alertify.confirm(
    pre,
    function () {
      $.ajax({
        type: "POST",
        url: ruta + "/productos/eliminar",
        data: "id=" + id,
        q: q,
        beforeSend: function (objeto) {
          $("#ResultadoAjax").html(`
          <div class="mx-auto" style="width: 200px;">
            <div class="spinner-border text-info" role="status">
              <span class="sr-only">Procesando...</span>
            </div>
            <span>Loading...</span>
          </div>
          
          `);
        },
        success: function (datos) {
          var result = datos;
          if (datos == "true") {
            $("#ResultadoAjax").html("");
            $("#Productos").DataTable().ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i> producto actualizado correctamente</h6>'
            );
          } else {
            console.log(datos);
            alertify.warning(
              '<i class="fas fa-ban"></i> Error al actualizar producto'
            );
          }
        },
      });
    },
    function () {
      alertify.error('<i class="fas fa-ban"></i> Cancelado');
    }
  );
}

$("#guardar_cliente").submit(function(event) {
  $("#guardar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: ruta + "/Clientes/agregar",
    data: parametros,
    beforeSend: function(objeto) {
      //$("#resultados_ajax").html("Mensaje: Cargando...");
    },
    success: function(datos) {
      var result = datos;
      if (datos == true) {
        $("#Clientes")
          .DataTable()
          .ajax.reload();
        $("#exampleModal").modal("hide");
        $("#guardar_cliente")[0].reset();
        $("#guardar_datos").attr("disabled", false);
        alertify.success(
          '<h6><i class="fas fa-check"></i> Cliente creado correctamente</h6>'
        );
      } else {
        $("#guardar_datos").attr("disabled", false);
        alertify.warning(result);
      }
    }
  });
  event.preventDefault();
});
