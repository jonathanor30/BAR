var ruta = $("#ruta").val();
$(document).ready(function() {
  var filter = $("#filter").val();
  $("#Productos").DataTable({
    processing: true,
    serverSide: true,
    language: { url: ruta + "/public/js/Spanish.json" },
    ajax: {
      url: ruta + "/Productos/tableViews",
      type: "POST",
      data: function(d) {
        d.id = $("#filter").val();
      }
    },
    columns: [
      { data: "NombreProducto" },
      { data: "CodigoProducto" },
      {
        data: "PrecioSugerido",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
         console.log(oData.PrecioSugerido);
          $(nTd).html(formatNumber.new(oData.PrecioSugerido, "$ "));
        }
      },
      { data: "Existencias" },
      {
        data: "Estado_P",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          switch (oData.Estado_P) {
            case "1":
              var estado = "Activo";
              var clase = "badge badge-success";
              break;
            case "2":
              var estado = "Inactivo";
              var clase = "badge badge-primary";
              break;
            case "3":
              var estado = "Agotado";
              var clase = "badge badge-warning";
              break;
           
          }
          $(nTd).html("<span class='" + clase + "'>" + estado + "</span>");
        }
      },
      {
        data: "IdProducto",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
              ruta +
              "/Productos/VerProducto/" +
              oData.IdProducto +
              "'>" +
              "<i class='fas fa-edit'></i>" +
              "</a><a title='Actualizar' href='#' class='btn btn-sm btn-outline-secondary' onclick='actualizar(" +
               oData.IdProducto+
              "," +
              oData.Estado_P +
              ");'><i class='fas fa-trash-alt'></i></a></div>"
          );
        }
      }
    ]
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
    document.createTextNode("Realmente desea cambiar el estado del producto")
  );

  alertify.confirm(
    pre,
    function() {
      $.ajax({
        type: "POST",
        url: ruta + "/productos/actualizar",
        data: "id=" + id + "&type=" + type,
        q: q,
        beforeSend: function(objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == "true") {
            $("#Productos")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i> producto actualizado correctamente</h6>'
            );
          } else {
            console.log(datos);
            alertify.warning(
              '<i class="fas fa-ban"></i> Error al actualizar producto'
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