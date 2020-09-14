var ruta = document.getElementById("ruta").value;
var contador = Array();
$(document).ready(function () {
  //datatable facturas
  table = $("#invoices").dataTable({
    responsive: true,
    processing: true,
    order: [
      [0, "desc"]
    ],
    pageLength: 10,
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ],
    language: { url: ruta + "/public/js/Spanish.json" },
    ajax: {
      url: ruta + "/Facturacion/page/tableViewsFactCliente",
      type: "POST",
      data: function (d) {
        d.id = $("#festado").val(); //importante
      },
      /*complete: function (data) {
        console.log(data.responseText);
      }*/
    },


    columns: [
      {
        data: "numero",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.numero != "" && oData.numero != null) {
            $(nTd).html(parseInt(oData.numero));
          } else {
            $(nTd).html("N/A");
          }
        }
      },
      {
        data: "numero2",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.numero2 != "" && oData.numero2 != null) {
            $(nTd).html(oData.numero2);
          } else {
            $(nTd).html("N/A");
          }
        }
      },
      {
        data: "nombrecliente",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.nombrecliente != "" || oData.nombrecliente != null) {
            $(nTd).html(
              '<a href="' +
              ruta +
              "/Facturacion/page/detailClient/" +
              oData.codcliente +
              '" title="Ir a info detallada" data-id="' +
              oData.codcliente +
              '" >' +
              oData.nombrecliente +
              "</a>"
            );
          }
        }
      },
      { data: "cifnif" },
      {
        data: "total",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html(formatNumber.new(oData.total, "$ "));
        }
      },
      { data: "observaciones" },
      {
        data: "estado",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.estado)) {
            case 0:
              $(nTd).html("Pendiente").addClass("text-danger");
              break;
            case 1:
              $(nTd).html("Pagada").addClass("text-success");
              break;
            case 2:
              $(nTd).html("F/NCrédito").addClass("text-warning");
              break;
            case 3:
              $(nTd).html("Firmada").addClass("text-primary");
              break;
            case 4:
              $(nTd).html("Firmada/Pagada").addClass("text-primary");
              break;
            case 5:
              $(nTd).html("Fact/NDébito").addClass("text-info");
              break;
            case 6:
              $(nTd).html("Fact/NCrédito/NDébito").addClass("text-info")
              break;
          }
          if (parseInt(oData.estadodian2) == 10) {
            $(nTd).append(`\n<h6><span  class="badge badge-pill badge-success">Aceptada</span></h6>`);
          } else if (parseInt(oData.estadodian2) == 11) {
            $(nTd).append(`\n<h6><span  class="badge badge-pill badge-danger">Rechazada</span></h6>`);
          }
        }
      },
      {
        data: "idfactura",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          var estados = new Array(0, 1);
          if (estados.indexOf(parseInt(oData.estado)) != -1) {
            if ($("#enabled").val() == 1) {
              var BtnSnd = `
              <a href="#" id="factura-${oData.idfactura}" title="Enviar factura electrónica" onclick="enviarFE(${oData.idfactura})" class="btn btn-sm btn-outline-secondary">
              <i class="fas fa-qrcode"></i>
              <span class="text-success" style="font-weight: bold;font-size:10px;"> DIAN</span></a></div>`;
            } else {
              var BtnSnd = "</div>";
            }
            $(nTd).html(
              `
              <div class="btn-group">
              <a href="${ruta}/Facturacion/page/detalleFactura/${oData.idfactura}" class="btn btn-sm btn-outline-secondary" data-id="${oData.idfactura}" >
              <i class="fas fa-edit"></i>
              </a>
              <a href="#" onclick="eliminar(${oData.idfactura})" class="btn btn-sm btn-outline-secondary"  data-id="${oData.idfactura}">
              <i class="fas fa-trash-alt"></i>
              </a>
              <a class="btn btn-sm btn-outline-secondary" target="_blank" href="${ruta}/Facturacion/ajaxFE/verFactura/${oData.idfactura}">
              <i class="fas fa-print"></i>
              </a>
              ${BtnSnd}
              `
            );
          } else {
            $(nTd).html("");
            $(nTd).append(
              `<div class="btn-group">
              <a href="${ruta}/Facturacion/page/detallefactura/${oData.idfactura}" class="btn btn-sm btn-outline-secondary" title="Ver factura">
              <i class="fas fa-eye"></i>
              </a>
              <a class="btn btn-sm btn-outline-secondary" target="_blank" href="${ruta}/Facturacion/ajaxFE/verFactura/${oData.idfactura}">
              <i class="fas fa-print"></i>
              </a>
              `
            );
            if (oData.estadodian2 == null || oData.estadodian2 == 10 || oData.estadodian2 == "") {
              $(nTd).find(".btn-group").append(
                `<button id="send-${oData.idfactura}" type="button" class="btn btn-sm btn-outline-secondary" onclick="Resend(${oData.idfactura}, 'fv')">
                <i class="fas fa-envelope"></i>
                </button>`
              );
            }
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

  //Autocompletar cliente
  $(function () {
    $("#client_name").autocomplete({
      source: ruta + "/Facturacion/page/autoCompletarCliente/nombre",
      minLength: 2,
      select: function (event, ui) {
        event.preventDefault();
        if (
          ui.item.id_cliente != null &&
          ui.item.cifnif != null &&
          ui.item.nombre != null &&
          ui.item.telefono1 != null &&
          ui.item.email != null &&
          ui.item.direccion != null &&
          ui.item.id_cliente != "" &&
          ui.item.cifnif != "" &&
          ui.item.nombre != "" &&
          ui.item.telefono1 != "" &&
          ui.item.email != "" &&
          ui.item.direccion != ""
        ) {
          if (ui.item.estado == 1) {
            $("#client_name").val(ui.item.nombre);
          } else {
            alertify.warning("Cliente inactivo");
            document.getElementById("nombre").value = "";
            document.getElementById("nombre").focus();
          }
        } else {
          alertify.confirm(
            "Datos incompletos",
            "Debe ingresar toda la información del cliente. Desea hacerlo ahora?",
            function () {
              location.href =
                ruta + "/Facturacion/page/detailClient/" + ui.item.id_cliente;
            },
            function () {
              alertify.error("Cancelado");
              $("#client_name").val("");
            }
          );
        }
      }
    });
  });
});
//El que no puede faltar
function eliminar(idProv) {
  //console.log(contador);
  if (contador.length == 0) {
    contador.push("delete");
    var parametros = {
      id: idProv,
      table: "facturascli",
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
      document.createTextNode("Realmente desea eliminar esta factura ? , se eliminarán las lineas de factura y los ingresos asociados a esta factura")
    );
    alertify.confirm(
      pre,
      function () {
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/page/InvoiceDelete",
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
              contador = Array();
            } else {
              console.log(result);
              $("#invoices")
                .DataTable()
                .ajax.reload();
              alertify.warning(
                result,
                '<i class="fas fa-ban"></i> Error al intentar eliminar la factura.'
              );
              contador = Array();
            }
          }
        });
      },
      function () {
        alertify.error('<i class="fas fa-ban"></i> Cancelado');
        contador = Array();
      }
    );
  } else {
    alertify.warning("Ya hay procesos ejecutándose, por favor espere...");
  }
}

function enviarFE(idfactura) {
  if (contador.length == 0) {
    contador.push("FE");
    var pre = document.createElement("H5");
    //custom style.
    pre.style.maxHeight = "400px";
    pre.style.margin = "0";
    pre.style.padding = "24px";
    //pre.style.whiteSpace = "pre-wrap";
    pre.style.textAlign = "center";
    pre.appendChild(
      document.createTextNode(
        "¿Realmente desea generar factura electrónica? Recuerde que esta operación no se puede deshacer, ya que será validada por la DIAN."
      )
    );
    alertify.confirm(
      pre,
      function () {
        //feManager
        var button = document.getElementById("factura-" + idfactura);
        button.setAttribute("disabled", true);
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/ajaxFE/generateXml",
          data: "id=" + idfactura,
          beforeSend: function (objeto) {
            button.innerHTML = "";
            button.innerHTML =
              '<span id="loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"> </span>';
          },
          success: function (datos) {
            if (datos == "true") {
              button.removeAttribute("disabled");
              alertify.success("Factura electrónica generada");
              $("#invoices")
                .DataTable()
                .ajax.reload();
              contador = Array();
            } else {
              button.innerHTML = "";
              button.innerHTML =
                '<i class="fas fa-qrcode"></i><span class="text-success" style="font-weight: bold;font-size:12px;"> DIAN</span>';
              $("#invoices")
                .DataTable()
                .ajax.reload();
              alertify.warning(datos);
              button.removeAttribute("disabled");
              console.log(datos);
              contador = Array();
            }
          }
        });
      },
      function () {
        alertify.error('<i class="fas fa-ban"></i> Cancelado');
        contador = Array();
      }
    );
  } else {
    alertify.warning("Ya hay procesos ejecutándose, por favor espere...");
  }
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
    case 4:
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

function ListadoXls() {
  try {
    var campos = Array("date_from", "date_till");
    campos.forEach(element => {
      if (document.getElementById(element).value == null || document.getElementById(element).value == "") {
        alertify.warning(`Campo ${element} vacío`);
        document.getElementById(element).focus();
        throw Error;
      }
    })
  } catch (error) {
    return false;
  }
  window.open(`${ruta}/Facturacion/page/GenerarXls?from=${document.getElementById("date_from").value}&to=${document.getElementById("date_till").value}` + (document.getElementById("client_name").value != "" ? `&client=${document.getElementById("client_name").value}` : ""));
}
function Resend(id, type) {
  if (contador.length == 0) {
    contador.push("FE");
    var button = document.getElementById("send-" + id);
    var pre = document.createElement("H5");
    //custom style.
    pre.style.maxHeight = "400px";
    pre.style.margin = "0";
    pre.style.padding = "24px";
    //pre.style.whiteSpace = "pre-wrap";
    pre.style.textAlign = "center";
    pre.appendChild(
      document.createTextNode(
        "Desea reenviar el correo de factura ?"
      )
    );
    alertify.confirm(
      pre,
      function () {
        //feManager
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/ajaxFE/Resend",
          data: "id=" + id + "&type=" + type,
          beforeSend: function (objeto) {
            button.innerHTML = "";
            button.innerHTML =
              '<span id="loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"> </span>';
          },
          success: function (datos) {
            if (datos == "true") {
              button.removeAttribute("disabled");
              alertify.success("<i class='fas fa-check'></i> Correo factura reenviado correctamente");
              $("#invoices")
                .DataTable()
                .ajax.reload();
              contador = Array();
            } else {
              button.innerHTML = "";
              button.innerHTML =
                '<i class="fas fa-envelope"></i>';
              alertify.warning(datos);
              console.log(datos);
              contador = Array();
            }
          }
        });
      },
      function () {
        alertify.error('<i class="fas fa-ban"></i> Cancelado');
        contador = Array();
      }
    );
  } else {
    alertify.warning("Ya hay procesos ejecutándose, por favor espere...");
  }
}