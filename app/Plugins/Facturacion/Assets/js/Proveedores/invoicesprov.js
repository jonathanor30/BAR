var ruta = document.getElementById("ruta").value;

$(document).ready(function () {
  //datatable facturas
  table = $("#invoices").DataTable({
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
      url: ruta + "/Facturacion/page/TableviewsFactProveedor",
      type: "POST",
      data: function (d) {
        d.id = $("#festado").val(); //importante
      }
    },

    columns: [
      {
        data: "numero",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.numero != "" || oData.numero != null) {
            $(nTd).html(
              '<a href="' +
              ruta +
              "/Facturacion/page/ProvFactdetail/" +
              oData.idfactura +
              '" title="Ir a info detallada" data-id="' +
              oData.idfactura +
              '" >' +
              oData.numero +
              "</a>"
            );
          }
        }
      },
      {
        data: "nombre"
      },
      { data: "cifnif" },
      {
        data: "total",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html(formatNumber.new(oData.total, '$ '));
        }
      },
      { data: "observaciones" },
      {
        data: "estado",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.estado)) {
            case 0:
              $(nTd).html(
                '<h6><span class="badge badge-pill badge-danger">Sin pagar</span></h6>'
              );
              break;
            case 1:
              $(nTd).html(
                '<h6><span  class="badge badge-pill badge-success">Pagada</span></h6>'
              );
              break;
            case 2:
              $(nTd).html(
                '<h6><span class="badge badge-pill badge-warning">Anulada</span></h6>'
              );
              break;
            case 3:
              $(nTd).html(
                '<h6><span  class="badge badge-pill badge-primary">Completada</span></h6>'
              );
              break;
          }
        }
      },
      {
        data: "idfactura",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.estado != 3) {
            $(nTd).html(
              `<div class="btn-group">
              <a href="${ruta}/Facturacion/page/ProvFactdetail/${oData.idfactura}" class="btn btn-sm btn-outline-secondary">
              <i class="fas fa-edit"></i>
              </a>
              <a href="${ruta}/Facturacion/page/verFacturaProv/${oData.idfactura}" class="btn btn-sm btn-outline-secondary"
              ><i class="fas fa-print"></i>
              </a>
              <a onclick="eliminar(${oData.idfactura})" class="btn btn-sm btn-outline-secondary"
              ><i class="fas fa-trash-alt"></i>
              </a>
              </div>`
            );
          } else {
            $(nTd).html(
              '<div class="btn-group"><a href="' +
              ruta +
              "/Facturacion/page/ProvFactdetail/" +
              oData.idfactura +
              '" class="btn btn-sm btn-outline-secondary"  data-id="' +
              oData.idfactura +
              '" ><i class="fas fa-eye"></i></a></div>'
            );
          }
        }
      }
    ]
  });
  //Jquery para añadir nuevo proveedor
  $("#newinv").submit(function (event) {
    event.preventDefault();
    $("#btnaddprov").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/AddProv",
      data: parametros,
      beforeSend: function (objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function (datos) {
        var result = datos.split(",");
        var state = result[0];
        var id = result[1];
        console.log(id);
        if (state == true) {
          $("#addprov").modal("hide");
          $("#newprov")[0].reset();
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddprov").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Proveedor agregado correctamente</h6>'
          );
          $("#invoices")
            .DataTable()
            .ajax.reload();
          setTimeout(function () {
            window.top.location = ruta + "/Facturacion/page/Provdetail/" + id;
          }, 2000);
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddprov").attr("disabled", false);
          alertify.warning(result);
          //console.log(result);
          $("#invoices")
            .DataTable()
            .ajax.reload();
        }
      }
    });
  });
});
//El que no puede faltar
function eliminar(idProv) {
  var parametros = {
    id: idProv,
    table: "facturasprov",
    key: "idfactura"
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
    document.createTextNode("Realmente desea eliminar esta factura?")
  );
  alertify.confirm(
    pre,
    function () {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/Delete",
        data: parametros,
        q: q,
        beforeSend: function (objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
          var result = datos;

          if (datos == true) {
            $("#invoices")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i>Factura eliminada</h6>'
            );
          } else {
            console.log(result);
            $("#invoices")
              .DataTable()
              .ajax.reload();
            alertify.warning(
              result,
              '<i class="fas fa-ban"></i> Error al intentar eliminar la factura.'
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

//Cambia color filtros
function cambiar() {
  var filter = document.getElementById("festado").value;

  switch (parseInt(filter)) {
    case 0:
      $("#festado").attr("class", "btn btn-danger btn-sm");
      break;
    case 1:
      $("#festado").attr("class", "btn btn-success btn-sm");
      break;
    case 2:
      $("#festado").attr("class", "btn btn-warning btn-sm");
      break;
    case 3:
      $("#festado").attr("class", "btn btn-primary btn-sm");
      break;
    default:
      $("#festado").attr("class", "btn btn-secondary btn-sm");
      break;
  }
  $("#invoices")
    .DataTable()
    .ajax.reload();
}

var formatNumber = {
  separador: ".", // separador para los miles
  sepDecimal: ",", // separador para los decimales
  formatear: function (num) {
    num += "";
    var splitStr = num.split(".");
    var splitLeft = splitStr[0];
    var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : "";
    var regx = /(\d+)(\d{3})/;
    while (regx.test(splitLeft)) {
      splitLeft = splitLeft.replace(regx, "$1" + this.separador + "$2");
    }
    return this.simbol + splitLeft + splitRight;
  },
  new: function (num, simbol) {
    this.simbol = simbol || "";
    return this.formatear(num);
  }
};