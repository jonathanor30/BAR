var ruta = document.getElementById("ruta").value;

$(document).ready(function () {
  // Por si hay que exportar

  //datatable recibos
  table = $("#ingresos").DataTable({
    processing: true,
    serverSide: true,
    order: [[0, "desc"]],
    pageLength: 10,
    lengthMenu: [
      [10, 25, 50, -1],
      [25, 50, 100, "All"]
    ],
    language: { url: ruta + "/public/js/Spanish.json" },

    ajax: {
      url: ruta + "/Facturacion/page/tableViewsInsCliente",
      type: "POST",
      data: function (d) {
        d.idfa = $("#est").val(); //importante
      },
      /*complete: function(data){
        console.log(data.responseText);
      }*/
    },

    columns: [
      {
        data: "numero",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.numero != null) {
            $(nTd).html(
              '<a href="' +
              ruta +
              "/Facturacion/page/detalleIngreso/" +
              oData.id_ingreso +
              '" title="Ir a info detallada" data-id="' +
              oData.id_ingreso +
              '" >' +
              oData.numero +
              "</a>"
            );
          } else {
            $(nTd).html('<a   data-id="' + oData.id_ingreso + '" ></a>');
          }
        }
      },
      {
        data: "idfactura",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.idfactura != null && oData.idfactura != 0) {
            $(nTd).html(
              '<a href="' +
              ruta +
              "/Facturacion/page/detalleFactura/" +
              oData.idfactura +
              '" title="Ir a info detallada" data-id="' +
              oData.idfactura +
              '" >' +
              oData.idfactura +
              "</a>"
            );
          } else {
            $(nTd).html('<a   data-id="' + oData.id_ingreso + '" ></a>');
          }
        }
      },
      {
        data: "cliente",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.id_cliente != null && oData.id_cliente != "") {
            $(nTd).html(
              '<a href="' +
              ruta +
              "/Facturacion/page/detailClient/" +
              oData.id_cliente +
              '" title="Ir a info detallada del proveedor" data-id="' +
              oData.id_cliente +
              '" >' +
              oData.cliente +
              "</a>"
            );
          } else {
            $(nTd).html(
              '<a href="#"  data-id="' +
              oData.cliente +
              '" >' +
              oData.cliente +
              "</a>"
            );
          }
        }
      },
      { data: "divisa" },
      { data: "importe" },
      {
        data: "fp",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.fp)) {
            case 1:
              $(nTd).html("Efectivo");
              break;
            case 2:
              $(nTd).html("Crédito");
              break;
          }
        }
      },
      {
        data: "estado_ingreso",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.estado_ingreso)) {
            case 0:
              $(nTd).html(
                '<h6><span class="badge badge-pill badge-warning">Emitida</span></h6>'
              );
              break;
            case 1:
              $(nTd).html(
                '<h6><span  class="badge badge-pill badge-success">Pagada</span></h6>'
              );
              break;
          }
        }
      },
      {
        data: "id_ingreso",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            '<div class="btn-group"><a href="' +
            ruta +
            "/Facturacion/page/detalleIngreso/" +
            oData.id_ingreso +
            '" class="btn btn-sm btn-outline-secondary"  data-id="' +
            oData.id_ingreso +
            '" ><i class="fas fa-edit"></i></a><a class="btn btn-sm btn-outline-secondary" target="_blank" href="' +
            ruta +
            "/Facturacion/page/verIngreso/" +
            oData.id_ingreso +
            '"><i class="fas fa-print"></i></a><a onclick="eliminar(' +
            oData.id_ingreso +
            ')" class="btn btn-sm btn-outline-secondary"  data-id="' +
            oData.id_ingreso +
            '" ><i class="fas fa-trash-alt"></i></a></div>'
          );


        }
      }
    ]
  });

  $("#newin").submit(function (event) {
    $("#btnaddin").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/AddIn",
      data: parametros,
      beforeSend: function (objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function (datos) {
        var result = datos.split("-");
        if (result[0] == true) {
          $("#newin")[0].reset();
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddin").attr("disabled", true);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Ingreso registrado correctamente</h6>'
          );
          //Para ir a factura detallada
          setTimeout(function () {
            location.href =
              ruta + "/Facturacion/page/detalleIngreso/" + result[1];
          }, 1000);
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddin").attr("disabled", false);
          alertify.warning(datos);
          console.log(datos);
        }
      }
    });
    event.preventDefault();
  });

  $(function () {
    $("#invoice").autocomplete({
      source: ruta + "/Facturacion/page/autoCompleteInvClient",
      select: function (event, ui) {
        event.preventDefault();
        if (ui.item.estado != 1 && ui.item.estado != 2) {
          $("#prov").val(ui.item.nombre);
          $("#codprov").val(ui.item.codcliente);
          $("#invoice").val(ui.item.numero);
          $("#idf").val(ui.item.idfactura);
          $("#tot_recibos").val(ui.item.total_recibos);

          // document.getElementById("ProdNombre").focus();
        } else {
          alertify.warning("la factura no puede estar pagada o anulada");
          $("#invoice").val("");
        }
      }
    });
  });
  $("#invoice").on("keydown", function (event) {
    if (
      event.keyCode == $.ui.keyCode.DELETE ||
      event.keyCode == $.ui.keyCode.BACKSPACE
    ) {
      $("#client").val("");
      $("#idclient").val("");
      $("#invoice").val("");
      $("#id_factura").val("");
      $("#tot_recibos").val("");
    }
  });
});

function eliminar(idProv) {
  var parametros = {
    id: idProv,
    table: "ingresos_clientes",
    key: "id_ingreso"
  };
  var q = idProv;
  var pre = document.createElement("H5");
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  //pre.style.whiteSpace = "pre-wrap";
  pre.style.textAlign = "center";
  pre.appendChild(
    document.createTextNode("Realmente desea eliminar este ingreso?")
  );
  alertify.confirm(
    pre,
    function () {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/DeleteClient",
        data: parametros,
        q: q,
        beforeSend: function (objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
          var result = datos;

          if (datos == true) {
            $("#ingresos")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i>Ingreso eliminado</h6>'
            );
          } else {
            console.log(result);
            $("#ingresos")
              .DataTable()
              .ajax.reload();
            alertify.warning(
              result,
              '<i class="fas fa-ban"></i> Error al intentar eliminar el recibo.'
            );
          }
        }
      });
    },
    function () {
      alertify.error('<i class="fas fa-ban"></i> Cancelado');
    }
  );
}
function cambiar() {
  var filter = document.getElementById("est").value;

  switch (parseInt(filter)) {
    case 0:
      $("#est").attr("class", "btn btn-warning btn-sm");
      break;
    case 1:
      $("#est").attr("class", "btn btn-success btn-sm");
      break;

    default:
      $("#est").attr("class", "btn btn-secondary btn-sm");
      break;
  }
  $("#ingresos")
    .DataTable()
    .ajax.reload();
}
