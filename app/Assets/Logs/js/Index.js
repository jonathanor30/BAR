var ruta = $("#ruta").val();
$(document).ready(function() {
  var icon;
  var title;
  $("#Logs").DataTable({
    order: [[ 4, "desc" ]],
    language: {
      url: ruta + "/public/js/Spanish.json"
    },
    ajax: {
      url: ruta + "/logs/tableViews",
      type: "POST",
      data: function(d) {
        d.id = document.getElementById("filter").value;
        d.desde = document.getElementById("desde").value;
        d.hasta = document.getElementById("hasta").value;
      }
    },
    columns: [
      {
        data: "tipo"
      },
      {
        data: "mensaje"
      },
      {
        data: "usuario"
      },
      {
        data: "IP"
      },
      {
        data: "fecha"
      }
    ]
  });
});

function aplicarFiltros(exportar = false) {
  if (
    document.getElementById("desde").value != "" &&
    document.getElementById("hasta").value != ""
  ) {
    if (exportar != false) {
      informe(
        document.getElementById("desde").value,
        document.getElementById("hasta").value,
        document.getElementById("filter").value
      );
    } else {
      $("#Logs")
        .DataTable()
        .ajax.reload();
    }
  } else {
    if (document.getElementById("desde").value == "") {
      document.getElementById("desde").focus();
    } else if (document.getElementById("hasta").value == "") {
      document.getElementById("hasta").focus();
    } else {
    }
    alertify.warning("Para aplicar filtros debe completar los campos.");
  }
}

function informe(desde, hasta, id) {
  var url =
    ruta +
    "/Logs/informeExcel/?id=" +
    id +
    "&desde=" +
    desde +
    "&hasta=" +
    hasta;
  window.open(url);
}
