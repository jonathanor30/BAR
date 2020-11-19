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
        data: "IdEstadoVenta",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          switch (oData.IdEstadoVenta) {
            case "1":
              var estado = "Completada";
              var clase = "badge badge-success";
              break;
            case "2":
              var estado = "procesando";
              var clase = "badge badge-warning";
              break;
            case "3":
              var estado = "cancelada";
              var clase = "badge badge-danger";
              break;
          }
          $(nTd).html("<span class='" + clase + "'>" + estado + "</span>");
        },
      },
      {
        data: "IdVenta",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if(oData.IdEstadoVenta==2){$(nTd).html(
            "<div class='btn-group'> <a title='Cancelar' href='#' class='btn btn-sm btn-outline-secondary' onclick='actualizar(" +
            oData.IdVenta +
            ");'><i class='fas fa-check-circle'></i></a></a><a title='Cancelar' href='#' class='btn btn-sm btn-outline-secondary' onclick='Eliminar(" +
              oData.IdVenta +
              ");'><i class='fas fa-times-circle'></i></a></div>"
          )}else
          {$(nTd).html(
            "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
            ruta +
            "/Ventas/VerVenta/" +
            oData.IdVenta +
            "'>" +
            "<i class='fas fa-eye'></i></a></div>" 
          )};
        },
      },
    ],
  });
});

function actualizar(id) {
  var q = id;
  var pre = document.createElement("H5");
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  //pre.style.whiteSpace = "pre-wrap";
  pre.style.textAlign = "center";

  pre.appendChild(
    document.createTextNode("Realmente desea completar esta venta")
  );

  alertify.confirm(
    pre,
    function () {
      $.ajax({
        type: "POST",
        url: ruta + "/ventas/actualizar",
        data: "id=" + id,
        q: q,
        beforeSend: function (objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
          var result = datos;
          if (datos == "true") {
            $("#Ventas").DataTable().ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i> venta completada correctamente</h6>'
            );
          } else {
            console.log(datos);
            alertify.warning(
              '<i class="fas fa-ban"></i> Error al completar venta'
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

  $("#Ventas").DataTable().ajax.reload();
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
    document.createTextNode("Realmente desea cancelar esta Ventas")
  );

  alertify.confirm(
    pre,
    function () {
      $.ajax({
        type: "POST",
        url: ruta + "/ventas/cancelar",
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
            $("#Ventas").DataTable().ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i> Venta cancelada correctamente</h6>'
            );
          } else {
            console.log(datos);
            alertify.warning(
              '<i class="fas fa-ban"></i> Error al cancelar la venta'
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


