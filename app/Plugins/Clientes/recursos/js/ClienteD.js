var ruta = $("#ruta").val();
$(document).ready(function() {
  var filter = $("#filter").val();
  $("#presentacionn").DataTable({
    processing: true,
    serverSide: true,
    language: {
      url: ruta + "/public/js/Spanish.json"
    },
    ajax: {
      url: ruta + "/Clientes/tableViewsPresentacion",
      type: "POST",
      data: function(d) {
        d.id = $("#filter").val();
      },
    },
    columns: [


      {
        data: "Nombre"
      },
      {
        data: "IdPresentacion",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
            ruta +
            "/Configuracion/VerPresentacion/" +
            oData.IdPresentacion +
            "'>" +
            "<i class='fas fa-edit'></i>" +
            "</a><a title='Actualizar' href='#' class='' (" +
            oData.IdPresentacion +
            "," +
            oData.IdPresentacion +
            ");" +
            oData.IdPresentacion +
            "," +
            oData.IdPresentacion +
            ");'></div>"
          );
        },
      },
    ],
  });
});