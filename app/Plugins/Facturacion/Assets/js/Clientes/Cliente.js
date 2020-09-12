var ruta = document.getElementById("ruta").value;

$(document).ready(function() {
  //datatable proveedores
  table = $("#clientes").DataTable({
    responsive: true,
    processing: true,
    order: [[0, "desc"]],
    pageLength: 10,
    lengthMenu: [
      [10, 25, 50, -1],
      [25, 50, 100, "All"]
    ],
    language: { url: ruta + "/public/js/Spanish.json" },

    ajax: {
      url: ruta + "/Facturacion/page/TableviewsClientes",
      type: "POST",
      data: function(d) {
        d.id = $("#festado").val(); //importante
      }
    },

    columns: [
      { data: "codcliente" },
      {
        data: "nombre",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.nombre != "" || oData.nombre != null) {
            $(nTd).html(
              '<a href="' +
                ruta +
                "/Facturacion/page/detailClient/" +
                oData.id_cliente +
                '" title="Ir a info detallada" data-id="' +
                oData.id_cliente +
                '" >' +
                oData.nombre +
                "</a>"
            );
          }
        }
      },
      { data: "cifnif" },
      { data: "email" },
      {
        data: "telefono1",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.telefono1 != null && oData.telefono1 != "") {
            if (oData.telefono1.length == 10) {
              $(nTd).html(
                "<a href='tel:" +
                  oData.telefono1 +
                  "'>" +
                  oData.telefono1 +
                  "</a><br>"
              );
            }
          } else if (oData.telefono1 != null && oData.telefono1 != "") {
            if (oData.telefono1.length == 7) {
              $(nTd).html(
                "<a href='tel:" +
                  oData.telefono1 +
                  "'>" +
                  oData.telefono1 +
                  "</a>"
              );
            }
          } else {
            $(nTd).html("N/A");
          }
        }
      },
      {
        data: "estado",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.estado)) {
            case 0:
              $(nTd).html(
                '<span onclick="Active(' +
                  oData.id_cliente +
                  "," +
                  oData.estado +
                  ')" class="badge badge-pill badge-danger">Inactivo</span>'
              );
              break;
            case 1:
              $(nTd).html(
                '<span onclick="Active(' +
                  oData.id_cliente +
                  "," +
                  oData.estado +
                  ')"  class="badge badge-pill badge-success">Activo</span>'
              );
              break;
          }
        }
      },
      {
        data: "id_cliente",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            '<div class="btn-group"><a href="' +
              ruta +
              "/Facturacion/page/detailClient/" +
              oData.id_cliente +
              '" class="btn btn-sm btn-outline-secondary"  data-id="' +
              oData.id_cliente +
              '" ><i class="fas fa-edit"></i></a><a onclick="eliminar(' +
              oData.id_cliente +
              ')" class="btn btn-sm btn-outline-secondary"  data-id="' +
              oData.id_cliente +
              '" ><i class="fas fa-trash-alt"></i></a></div>'
          );
        }
      }
    ]
  });
  //Jquery para aè´–adir nuevo cliente
  $("#newclient").submit(function(event) {
    event.preventDefault();
    $("#btnaddclient").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/AddClient",
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
        var result = datos.split(",");
        var state = result[0];
        var id = result[1];

        if (state == true) {
          $("#addprov").modal("hide");
          $("#newclient")[0].reset();
          $("#btnaddclient").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Cliente agregado correctamente</h6>'
          );
          $("#clientes")
            .DataTable()
            .ajax.reload();
          setTimeout(function() {
            window.top.location = ruta + "/Facturacion/page/detailClient/" + id;
          }, 2000);
        } else {
          console.log(datos);
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddclient").attr("disabled", false);
          alertify.warning("Error al guardar, verifique los datos.");
          //console.log(result);
          $("#clientes")
            .DataTable()
            .ajax.reload();
        }
      }
    });
  });
  $("#frmimp").submit(function(event) {
    event.preventDefault();
    var parametros = new FormData(document.getElementById("frmimp"));

    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/ImportarCliente",
      data: parametros,
      processData: false,
      contentType: false,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
        var result = datos;
        if (datos == true) {
          $("#addfile").modal("hide");
          $("#frmimp")[0].reset();
          //$("#resultados_ajax").html('<span></span>');

          alertify.success(
            '<h6><i class="fas fa-check"></i> Archivo importado correctamente</h6>'
          );
          $("#clientes")
            .DataTable()
            .ajax.reload();
        } else {
          //$("#resultados_ajax").html('<span></span>');
          alertify.warning(result);
          console.log(result);
          $("#clientes")
            .DataTable()
            .ajax.reload();
        }
      }
    });
  });
});
//El que no puede faltar
function eliminar(idProv) {
  var q = idProv;
  var pre = document.createElement("H5");
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  //pre.style.whiteSpace = "pre-wrap";
  pre.style.textAlign = "center";
  pre.appendChild(
    document.createTextNode("Realmente desea eliminar este cliente?")
  );
  alertify.confirm(
    pre,
    function() {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/DeleteClient",
        data: "id=" + idProv + "&table=clientes&key=id_cliente",
        q: q,
        beforeSend: function(objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;

          if (datos == true) {
            $("#clientes")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i>Cliente eliminado</h6>'
            );
          } else {
            console.log(result);
            $("#clientes")
              .DataTable()
              .ajax.reload();
            alertify.warning(
              result,
              '<i class="fas fa-ban"></i> Error al intentar eliminar el cliente.'
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

function Active(id, estado) {
  if (estado == 0) {
    var q = id;
    var pre = document.createElement("H5");
    //custom style.
    pre.style.maxHeight = "400px";
    pre.style.margin = "0";
    pre.style.padding = "24px";
    //pre.style.whiteSpace = "pre-wrap";
    pre.style.textAlign = "center";
    pre.appendChild(
      document.createTextNode("è¢ƒDesea cambiar el estado de este cliente?")
    );
    alertify.confirm(
      pre,
      function() {
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/page/StateClient",
          data: "idA=" + id,
          q: q,
          beforeSend: function(objeto) {
            //$("#resultados").html("Mensaje: Cargando...");
          },
          success: function(datos) {
            var result = datos;

            if (datos == true) {
              $("#clientes")
                .DataTable()
                .ajax.reload();
              alertify.success(
                '<h6><i class="fas fa-check"></i> Cliente Activo</h6>'
              );
            } else {
              console.log(result);
              $("#clientes")
                .DataTable()
                .ajax.reload();
              alertify.warning(
                '<i class="fas fa-ban"></i> Error al intentar habilitar el Cliente.'
              );
            }
          }
        });
      },
      function() {
        alertify.error('<i class="fas fa-ban"></i> Proceso Cancelado');
      }
    );
  } else {
    var q = id;
    var pre = document.createElement("H5");
    //custom style.
    pre.style.maxHeight = "400px";
    pre.style.margin = "0";
    pre.style.padding = "24px";
    //pre.style.whiteSpace = "pre-wrap";
    pre.style.textAlign = "center";
    pre.appendChild(
      document.createTextNode("è¢ƒDesea cambiar el estado de este cliente?")
    );
    alertify.confirm(
      pre,
      function() {
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/page/StateClient",
          data: "idI=" + id,
          q: q,
          beforeSend: function(objeto) {
            //$("#resultados").html("Mensaje: Cargando...");
          },
          success: function(datos) {
            var result = datos;

            if (datos == true) {
              $("#clientes")
                .DataTable()
                .ajax.reload();
              alertify.success(
                '<h6><i class="fas fa-check"></i> Cliente Inactivo</h6>'
              );
            } else {
              console.log(result);
              $("#clientes")
                .DataTable()
                .ajax.reload();
              alertify.warning(
                '<i class="fas fa-ban"></i> Error al intentar inhabilitar el Cliente.'
              );
            }
          }
        });
      },
      function() {
        alertify.error('<i class="fas fa-ban"></i> Proceso Cancelado');
      }
    );
  }
}

function cambiar() {
  var filter = document.getElementById("festado").value;

  switch (parseInt(filter)) {
    case 0:
      $("#festado").attr("class", "btn btn-danger btn-sm");
      break;
    case 1:
      $("#festado").attr("class", "btn btn-success btn-sm");
      break;
    default:
      $("#festado").attr("class", "btn btn-secondary btn-sm");
      break;
  }
  $("#clientes")
    .DataTable()
    .ajax.reload();
}
