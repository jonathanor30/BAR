var ruta = $("#ruta").val();
$(document).ready(function() {
  var filter = $("#filter").val();
  $("#Ventas").DataTable({
    processing: true,
    serverSide: true,
    language: { url: ruta + "/public/js/Spanish.json" },
    ajax: {
      url: ruta + "/Ventas/tableViews",
      type: "POST",
      data: function(d) {
        d.id = $("#filter").val();
      }
    },
    columns: [
      
      { data: "user_id" },
      
      { data: "IdCliente" },
      { data: "Fecha" },
      { data: "observaciones" },
      { data: "hora" },
      { data: "IdVenta" },
      
      {
        data: "IdVenta",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            "<div class='btn-group'>" +
              "</a><a title='Eliminar' href='#' class='btn btn-sm btn-outline-secondary' onclick='actualizar(" +
               oData.IdVenta+
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
    document.createTextNode("Realmente desea actualizar este producto")
  );

  alertify.confirm(
    pre,
    function() {
      $.ajax({
        type: "POST",
        url: ruta + "/ventas/actualizar",
        data: "id=" + id + "&type=" + type,
        q: q,
        beforeSend: function(objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == "true") {
            $("#Ventas")
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