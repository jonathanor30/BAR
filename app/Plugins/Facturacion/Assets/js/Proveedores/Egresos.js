var ruta = document.getElementById("ruta").value;

$(document).ready(function() {
  // Por si hay que exportar
  var buttonCommon = {
    exportOptions: {
      format: {
        body: function(data, row, column, node) {
          if (column == 5) {
            switch (parseInt(data)) {
              case 1:
                return "Efectivo";
                break;
              case 2:
                return "Transferencia bancaria";
                break;
              case 3:
                return "Cheque";
                break;
            }
          } else {
            return data;
          }
        }
      }
    }
  };
  //datatable recibos
  table = $("#recibos").DataTable({
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
      url: ruta + "/Facturacion/page/TableviewsOutsProveedor",
      type: "POST",
      data: function(d) {
        d.id = $("#est").val(); //importante
      }
    },

    columns: [
      {
        data: "numero",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.numero != null) {
            $(nTd).html(
              '<a href="' +
                ruta +
                "/Facturacion/page/detailOut/" +
                oData.id_recibo +
                '" title="Ir a info detallada" data-id="' +
                oData.id_recibo +
                '" >' +
                oData.numero +
                "</a>"
            );
          } else {
            $(nTd).html('<a   data-id="' + oData.id_recibo + '" ></a>');
          }
        }
      },
      {
        data: "idfactura",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.idfactura != null && oData.idfactura != 0) {
            $(nTd).html(
              '<a href="' +
                ruta +
                "/Facturacion/page/ProvFactdetail/" +
                oData.idfactura +
                '" title="Ir a info detallada" data-id="' +
                oData.idfactura +
                '" >' +
                oData.idfactura +
                "</a>"
            );
          } else {
            $(nTd).html('<a   data-id="' + oData.id_recibo + '" ></a>');
          }
        }
      },
      {
        data: "proveedor",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.codproveedor != null && oData.codproveedor != "") {
            $(nTd).html(
              '<a href="' +
                ruta +
                "/Facturacion/page/Provdetail/" +
                oData.codproveedor +
                '" title="Ir a info detallada del proveedor" data-id="' +
                oData.codproveedor +
                '" >' +
                oData.proveedor +
                "</a>"
            );
          } else {
            $(nTd).html(
              '<a   data-id="' +
                oData.proveedor +
                '" >' +
                oData.proveedor +
                "</a>"
            );
          }
        }
      },
      { data: "emitido" },
      { data: "divisa" },
      { data: "importe" },
      {
        data: "fp",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.fp)) {
            case 1:
              $(nTd).html("Consignación bancaria");
              break;
            case 2:
              $(nTd).html("Al contado");
              break;
            case 3:
              $(nTd).html("Cheque");
              break;
          }
        }
      },
      { data: "vencimiento" },
      {
        data: "pagado",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.pagado == "Si" && oData.notificado == "Si") {
            $(nTd).html(
              '<h6><span class="badge badge-pill badge-primary">Pagado/Notificado</span></h6>'
            );
          } else if (oData.pagado == "No" && oData.notificado == "No") {
            $(nTd).html(
              '<h6><span class="badge badge-pill badge-danger">NO Pagado/ NO Notificado</span></h6>'
            );
          } else if (oData.pagado == "Si" && oData.notificado == "No") {
            $(nTd).html(
              '<h6><span class="badge badge-pill badge-success">Pagado</span></h6>'
            );
          } else if (oData.pagado == "No" && oData.notificado == "Si") {
            $(nTd).html(
              '<h6><span class="badge badge-pill badge-warning">Notificado</span></h6>'
            );
          } else {
          }
        }
      },
      {
        data: "id_recibo",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.estado_recibo == 0) {
            $(nTd).html(
              '<div class="btn-group"><a href="' +
                ruta +
                "/Facturacion/page/detailOut/" +
                oData.id_recibo +
                '" class="btn btn-sm btn-outline-secondary"  data-id="' +
                oData.id_recibo +
                '" ><i class="fas fa-edit"></i></a><a class="btn btn-sm btn-outline-secondary" target="_blank" href="' +
                ruta +
                "/Facturacion/page/verEgreso/" +
                oData.id_recibo +
                '"><i class="fas fa-print"></i></a><a onclick="eliminar(' +
                oData.id_recibo +
                ')" class="btn btn-sm btn-outline-secondary"  data-id="' +
                oData.id_recibo +
                '" ><i class="fas fa-trash-alt"></i></a></div>'
            );
          } else {
            $(nTd).html(
              '<div class="btn-group"><a href="' +
                ruta +
                "/Facturacion/page/detailOut/" +
                oData.id_recibo +
                '" class="btn btn-sm btn-outline-secondary"  data-id="' +
                oData.id_recibo +
                '" ><i class="fas fa-eye"></i></a><a class="btn btn-sm btn-outline-secondary" target="_blank" href="' +
                ruta +
                "/Facturacion/page/verEgreso/" +
                oData.id_recibo +
                '"><i class="fas fa-print"></i></a></div>'
            );
          }
        }
      }
    ]
  });

  $("#prov").on("keydown", function(event) {
    if (
      event.keyCode == $.ui.keyCode.DELETE ||
      event.keyCode == $.ui.keyCode.BACKSPACE
    ) {
      $("#prov").val("");
      $("#idprov").val("");
    }
  });
  $("#invoice").on("keydown", function(event) {
    if (
      event.keyCode == $.ui.keyCode.DELETE ||
      event.keyCode == $.ui.keyCode.BACKSPACE
    ) {
      $("#prov").attr("readonly", false);
      $("#prov").val("");
      $("#invoice").val("");
      $("#id_factura").val("");
      $("#total").val("");
    }
  });
  $("#newout").submit(function(event) {
    $("#btnaddout").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/AddOut",
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
        var result = datos.split("-");
        if (result[0] == true) {
          $("#newout")[0].reset();
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddout").attr("disabled", true);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Egreso registrado correctamente</h6>'
          );
          //Para ir a factura detallada
          setTimeout(function() {
            location.href = ruta + "/Facturacion/page/detailOut/" + result[1];
          }, 1000);
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddout").attr("disabled", false);
          alertify.warning(datos);
          console.log(datos);
        }
      }
    });
    event.preventDefault();
  });

  $(function() {
    $("#invoice").autocomplete({
      source: ruta + "/Facturacion/page/autoCompleteInv",
      select: function(event, ui) {
        event.preventDefault();
        if (ui.item.estado != 1 && ui.item.estado != 2) {
          $("#prov").attr("readonly", true);
          $("#prov").val(ui.item.nombre);
          $("#invoice").val(ui.item.numero);
          $("#idprov").val(ui.item.codproveedor);
          $("#id_factura").val(ui.item.idfactura);
          $("#total").val(ui.item.total);
          // document.getElementById("ProdNombre").focus();
        } else {
          alertify.warning("la factura no puede estar pagada o anulada");
          $("#invoice").val("");
        }
      }
    });
  });

  $(function() {
    $("#prov").autocomplete({
      source: ruta + "/Facturacion/page/autoCompleteProvName",
      minLength: 2,
      select: function(event, ui) {
        event.preventDefault();
        if (ui.item.estado == 1) {
          $("#prov").val(ui.item.nombre);
          $("#idprov").val(ui.item.codproveedor);
          // document.getElementById("ProdNombre").focus();
        } else {
          alertify.warning("El proveedor no está activo");
          $("#prov").val("");
        }
      }
    });
  });
});

function eliminar(idProv) {
  var parametros = {
    id: idProv,
    table: "recibos_proveedor",
    key: "id_recibo"
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
    document.createTextNode("Realmente desea eliminar este recibo?")
  );
  alertify.confirm(
    pre,
    function() {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/Delete",
        data: parametros,
        q: q,
        beforeSend: function(objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;

          if (datos == true) {
            $("#recibos")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i>Recibo eliminado</h6>'
            );
          } else {
            console.log(result);
            $("#recibos")
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
    function() {
      alertify.error('<i class="fas fa-ban"></i> Cancelado');
    }
  );
}

//Cambia color filtros
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
  $("#recibos")
    .DataTable()
    .ajax.reload();
}
