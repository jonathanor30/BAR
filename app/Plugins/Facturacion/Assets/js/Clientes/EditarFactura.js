var ruta = document.getElementById("ruta").value;
var contador = Array();
$(document).ready(function (e) {
  SetSelect(elements);
  var total_factura = document.getElementById("sumAll").value;
  total_recibos = 0;
  $("#tot").val(total_factura);
  table = $("#Ingresos").DataTable({
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
        d.idf = $("#idfactura").val();
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
              "/Facturacion/page/detalleIngreso/" +
              oData.id_ingreso +
              '" title="Ir a info detallada" data-id="' +
              oData.id_ingreso +
              '" >' +
              oData.numero +
              "</a>"
            );
          }
        }
      },
      {
        data: "cliente",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.numero != "" || oData.numero != null) {
            $(nTd).html(
              '<a href="' +
              ruta +
              "/Facturacion/page/detailClient/" +
              oData.id_cliente +
              '" title="Ir a info detallada" data-id="' +
              oData.id_cliente +
              '" >' +
              oData.cliente +
              "</a>"
            );
          }
        }
      },

      { data: "divisa" },
      {
        data: "importe",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          total_recibos = parseFloat(total_recibos) + parseFloat(oData.importe);
          $(nTd).html("$ " + oData.importe);
          var rest =
            parseFloat(total_factura).toFixed(2) -
            parseFloat(total_recibos).toFixed(2);
          if (rest >= 0) {
            $("#rest").val("Saldo restante $ " + parseFloat(rest).toFixed(2));
            $("#outtot").val(total_recibos);
            $("#remain").val(parseFloat(rest).toFixed(2));
            $("#importe").attr("placeholder", parseFloat(rest).toFixed(2));
          }
        }
      },
      {
        data: "fp",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.fp)) {
            case 1:
              $(nTd).html("Efectivo");
              break;
            case 2:
              $(nTd).html("Cheque");
              break;
            case 3:
              $(nTd).html("Transferencia");
              break;
            case 4:
              $(nTd).html("Crédito");
              break;
          }
        }
      },
      { data: "observaciones" },
      {
        data: "estado_ingreso",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.estado_ingreso != 0) {
            $(nTd).html(
              '<h6><span class="badge badge-pill badge-success">Pagado</span></h6>'
            );
          } else {
            $(nTd).html(
              '<h6><span class="badge badge-pill badge-warning">Emitido</span></h6>'
            );
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
  $("#Notas").DataTable({
    processing: true,
    serverSide: true,
    order: [[8, "desc"]],
    pageLength: 10,
    lengthMenu: [
      [10, 25, 50, -1],
      [25, 50, 100, "All"]
    ],
    language: { url: ruta + "/public/js/Spanish.json" },
    ajax: {
      url: ruta + "/Facturacion/page/dataTableNotes",
      type: "POST",
      data: function (d) {
        d.idf = $("#idfactura").val();
      },
      complete: function (d) {
        //console.log(d.responseText);
      }
    },

    columns: [
      {
        data: "numero",
      },
      {
        data: "prefijo",
      },
      {
        data: "numero2",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.numero2 != "" && oData.numero2 != null) {
            $(nTd).html(oData.prefijo + oData.numero2);
          } else {
            $(nTd).html("N/A");
          }
        }
      },
      {
        data: "nombrecliente",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.numero != "" || oData.numero != null) {
            $(nTd).html(
              '<a href="' +
              ruta +
              "/Facturacion/page/detailClient/" +
              oData.id_cliente +
              '" title="Ir a info detallada" data-id="' +
              oData.id_cliente +
              '" >' +
              oData.nombrecliente +
              "</a>"
            );
          }
        }
      },

      { data: "coddivisa" },
      {
        data: "total",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html("$ " + parseFloat(parseFloat(oData.total)/* + parseFloat(oData.totalretencion)*/).toFixed(2))
        }
      },
      { data: "observaciones" },
      {
        data: "estado",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.estado)) {
            case 1:
              $(nTd).html("Emitido").addClass("text-warning")
              break;
            case 2:
              $(nTd).html("Validada").addClass("text-success")
              break;
            case 3:
              $(nTd).html("Validada y notificada").addClass("text-primary")
              break;
            default:
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
        data: "id",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (parseInt(oData.estado) == 1) {
            if ($("#enabled").val() == 1) {
              if (oData.prefijo == "NC") {
                var BtnSnd = `
                <a href="#" id="nota-${oData.id}" title="Enviar nota electrónica" onclick="enviarCN(${oData.id})" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-qrcode"></i>
                <span class="text-success" style="font-weight: bold;font-size:10px;"> DIAN</span></a></div>`;
              } else {
                var BtnSnd = `
                <a href="#" id="nota-${oData.id}" title="Enviar nota electrónica" onclick="enviarDN(${oData.id})" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-qrcode"></i>
                <span class="text-success" style="font-weight: bold;font-size:10px;"> DIAN</span></a></div>`;
              }
            } else {
              var BtnSnd = "</div>";
            }
            $(nTd).html(
              `<div class="btn-group">
              <a target="_blank" class="btn btn-sm btn-outline-secondary" onclick="eliminarNC(${oData.id})"><i class="fas fa-trash"></i></a>
              ${BtnSnd}
              `
            );
          } else {
            $(nTd).html(
              `<div class="btn-group">
              <a target="_blank" href="${ruta}/Facturacion/ajaxFe/verFactura/${oData.id}?nc" class="btn btn-sm btn-outline-secondary">
              <i class="fas fa-print"></i>
              </a>
              </div>`
            );
            if (oData.estadodian2 == null || oData.estadodian2 == 10 || oData.estadodian2 == "") {
              $(nTd).find(".btn-group").append(
                `<button id="send-${oData.id}" type="button" class="btn btn-sm btn-outline-secondary" onclick="Resend(${oData.id}, '${oData.prefijo.toLowerCase()}')">
                <i class="fas fa-envelope"></i>
                </button>`
              );
            }
          }
        }
      }
    ]
  });
  $("form").keypress(function (e) {
    if (e == 13) {
      return false;
    }
  });
  $("input").keypress(function (e) {
    if (e.which == 13) {
      return false;
    }
  });
  $("#ClieNit").on("keydown", function (event) {
    if (
      event.keyCode == $.ui.keyCode.DELETE ||
      event.keyCode == $.ui.keyCode.BACKSPACE
    ) {
      $("#idTblCliente").val("");
      $("#ClieNit").val("");
      $("#ClieNombre").val("");
      $("#ClieTelefono").val("");
      $("#ClieEmail").val("");
      $("#ClieDireccion").val("");
    }
  });
  $("#datos_factura").submit(function (event) {
    $("#btnsaveinvprov").attr("disabled", true);
    var parametros = $(this).serialize();
    if (validator(null, true) == true) {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/EditInvClient",
        data: parametros,
        beforeSend: function (objeto) {
          //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function (datos) {
          var result = datos.split("-");
          if (result[0] == true) {
            $("#datos_factura")[0].reset();
            //$("#resultados_ajax").html('<span></span>');
            $("#btnsaveinvprov").attr("disabled", true);
            alertify.success(
              '<h6><i class="fas fa-check"></i>Factura editada correctamente</h6>'
            );
            //Para ir a factura detallada
            setTimeout(function () {
              location.reload();
            }, 1000);
          } else {
            //$("#resultados_ajax").html('<span></span>');
            $("#btnsaveinvprov").attr("disabled", false);
            alertify.warning(datos);
            console.log(datos);
          }
        }
      });
    } else {
      $("#btnsaveinvprov").attr("disabled", false);
    }


    event.preventDefault();
  });
  $(function () {
    $("#ClieNit").autocomplete({
      source: ruta + "/Facturacion/page/autoCompletarCliente/cifnif",
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
            $("#id_cliente").val(ui.item.id_cliente);
            $("#ClieNit").val(ui.item.cifnif);
            $("#ClieNombre").val(ui.item.nombre);
            $("#ClieTelefono").val(ui.item.telefono1);
            $("#ClieEmail").val(ui.item.email);
            $("#ClieDireccion").val(ui.item.direccion);
            $("#FacFormaPago").val(ui.item.codpago);
          } else {
            alertify.warning("Cliente inactivo");
            document.getElementById("ClieNombre").value = "";
            document.getElementById("ClieNombre").focus();
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
              $("#id_cliente").val("");
              $("#ClieNit").val("");
              $("#ClieNombre").val("");
              $("#ClieTelefono").val("");
              $("#ClieEmail").val("");
              $("#ClieDireccion").val("");
            }
          );
        }

        // document.getElementById("ProdNombre").focus();
      }
    });
  });
  $(function () {
    $("#ClieNombre").autocomplete({
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
            $("#id_cliente").val(ui.item.id_cliente);
            $("#ClieNit").val(ui.item.cifnif);
            $("#ClieNombre").val(ui.item.nombre);
            $("#ClieTelefono").val(ui.item.telefono1);
            $("#ClieEmail").val(ui.item.email);
            $("#ClieDireccion").val(ui.item.direccion);
            $("#FacFormaPago").val(ui.item.codpago);
          } else {
            alertify.warning("Cliente inactivo");
            document.getElementById("ClieNombre").value = "";
            document.getElementById("ClieNombre").focus();
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
              $("#id_cliente").val("");
              $("#ClieNit").val("");
              $("#ClieNombre").val("");
              $("#ClieTelefono").val("");
              $("#ClieEmail").val("");
              $("#ClieDireccion").val("");
            }
          );
        }
      }
    });
  });
  $("#newout").submit(function (event) {
    event.preventDefault();
    if (total_recibos < document.getElementById("sumAll").value) {
      $("#btnaddout").attr("disabled", true);
      var parametros = $(this).serialize();
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/AddIng",
        data: parametros,
        beforeSend: function (objeto) {
          //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function (datos) {
          var result = datos.split("-");
          if (result[0] == true) {
            $("#newout")[0].reset();
            $("#addin").modal("hide");
            //$("#resultados_ajax").html('<span></span>');
            $("#btnaddout").attr("disabled", false);
            var total = 0;

            alertify.success(
              '<h6><i class="fas fa-check"></i>Ingreso creado correctamente</h6>'
            );
            total_recibos = 0;
            $("#Ingresos")
              .DataTable()
              .ajax.reload();
            if (result[1] == "reload") {
              location.reload();
            }
            //Para ir a factura detallada
          } else {
            //$("#resultados_ajax").html('<span></span>');
            $("#btnaddout").attr("disabled", false);
            $("#newout")[0].reset();
            alertify.warning(datos);
            console.log(datos);
          }
        }
      });
    } else {
      alertify.warning("El valor del importe no puede ser mayor al total restante de la factura");
    }
  });
  $(function () {
    $(".input_code").on("keyup", function (e) {
      if (Number.isInteger(parseInt(this.value))) {
        var source = ruta + "/Facturacion/autoCompletarCodigo/product_code";
      } else {
        var source = ruta + "/Facturacion/autoCompletarCodigo/product_name";
      }
      $(this).autocomplete({
        source: source,
        minLength: 2,
        select: function (event, ui) {
          event.preventDefault();
          if ($(this).parent().get(0).tagName == "TD") {
            if (
              ui.item.product_code != null &&
              ui.item.product_name != null
            ) {
              $(this).val(ui.item.product_code);
            } else {
              $(this).val("");
            }
          } else {
            if (
              ui.item.product_code != null &&
              ui.item.product_name != null
            ) {
              $(this).val(ui.item.product_name);
              $("#line_code").val(ui.item.product_code);
            } else {
              $(this).val("");
              $("#line_code").val("");
            }
          }
        }
      });
    })
  });
  SetImporte(total_recibos);
  calcular(true);
});

function eliminarNC(idProv) {
  var q = idProv;
  var pre = document.createElement("H5");
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  //pre.style.whiteSpace = "pre-wrap";
  pre.style.textAlign = "center";
  pre.appendChild(
    document.createTextNode("Realmente desea eliminar esta Nota crédito?")
  );
  alertify.confirm(
    pre,
    function () {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/DeleteClient",
        data: "id=" + idProv + "&table=facturasnotes&key=id",
        q: q,
        beforeSend: function (objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
          var result = datos;

          if (datos == true) {
            total_recibos = 0;
            $("#Notas")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i>Nota crédito eliminada</h6>'
            );
          } else {
            console.log(result);
            total_recibos = 0;
            $("#Notas")
              .DataTable()
              .ajax.reload();
            alertify.warning(
              result,
              '<i class="fas fa-ban"></i> Error al intentar eliminar la Nota crédito.'
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
    document.createTextNode("Realmente desea eliminar este ingreso?")
  );
  alertify.confirm(
    pre,
    function () {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/DeleteClient",
        data: "id=" + idProv + "&table=ingresos_clientes&key=id_ingreso",
        q: q,
        beforeSend: function (objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
          var result = datos;

          if (datos == true) {
            total_recibos = 0;
            $("#Ingresos")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i>Ingreso eliminado</h6>'
            );
          } else {
            console.log(result);
            total_recibos = 0;
            $("#Ingresos")
              .DataTable()
              .ajax.reload();
            alertify.warning(
              result,
              '<i class="fas fa-ban"></i> Error al intentar eliminar el Ingreso.'
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
function Values() {
  var idf = document.getElementById("idfactura").value;
  var cprov = document.getElementById("id_cliente").value;
  $("#idf").val(idf);
  $("#codprov").val(cprov);
}
function agregaritem() {
  var ultimo = document.getElementsByName("numero_item[]");
  var numero_item = ultimo.length + 1;
  //Valores qe se van a gregar a linea
  var referencia = document.getElementById("line_reference").value;
  var codigo = document.getElementById("line_code").value;
  var nombre_producto = document.getElementById("ProdNombre").value;
  var precio = document.getElementById("ProdPrecioVenta").value;
  var cantidad = document.getElementById("cantidad").value;
  var RE = document.getElementById("RE").value;
  var tasa_iva = document.getElementById("iva").value;
  var dto = document.getElementById("Dto").value;
  var recargo = document.getElementById("recargo").value;

  if (nombre_producto != "" && precio != "" && cantidad != "" && document.getElementById("line_code_name").value != "") {
    //Calculos a mostrar
    var subtotal = cantidad * precio;
    var valdto = subtotal * (dto / 100);
    var valrecargo = (subtotal - valdto) * (recargo / 100);
    var neto = subtotal - valdto + valrecargo;
    var Ret = neto - (neto * RE) / 100;
    var RET = (neto * RE) / 100;
    var iva_calculo = (neto * tasa_iva) / 100;
    var iva = iva_calculo;
    var total = Ret + iva;
    var table = document.getElementById("TableBody");
    var row = table.insertRow(-1);
    row.setAttribute("id", numero_item);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
    var cell9 = row.insertCell(8);
    var cell10 = row.insertCell(9);
    var cell11 = row.insertCell(10);
    var cell12 = row.insertCell(11);
    cell1.innerHTML = `<input hidden class='form-control input-sm numero_item'  type='text' name='numero_item[]' readonly value='${numero_item}'required>`;
    cell2.innerHTML = `<input class='form-control form-control-sm Reference' type='text' name='referencia[]' value='${referencia}' readonly='' required>
      <input hidden class='form-control form-control-sm input-sm input_code'  type='text' name='codigo[]' readonly value='${codigo}'required>`;
    cell3.innerHTML = `<input class='form-control form-control-sm ProdNombre' type='text' name='ProdNombre[]' value='${nombre_producto}' readonly='' required='' title='${nombre_producto}'>`;
    cell4.innerHTML = `<input class='form-control form-control-sm cantidad' name='cantidad[]' value='${cantidad}' readonly='' required>`;
    cell5.innerHTML = `<input class='form-control form-control-sm ProdPrecioVenta' name='ProdPrecioVenta[]' value='${parseFloat(precio).toFixed(2)}' readonly='' required>`;
    cell6.innerHTML = `<input class='form-control form-control-sm dto' name='dto[]' value='${parseFloat(valdto).toFixed(2)}' readonly='' required=''>`;
    cell7.innerHTML = `<input class='form-control form-control-sm recargo' name='recargo[]' value='${parseFloat(valrecargo).toFixed(2)}' readonly='' required=''>`;
    cell8.innerHTML = `<input class='form-control form-control-sm subtotal' name='subtotal[]' value='${parseFloat(neto).toFixed(2)}' readonly='' required=''>`;
    cell9.innerHTML = `<input class='form-control form-control-sm RE' name='RE[]' value='${parseFloat(RET).toFixed(2)}' readonly='' required=''>`;
    cell10.innerHTML = `<input class='form-control form-control-sm iva' name='iva[]' value='${parseFloat(iva).toFixed(2)}' readonly='' required=''>`;
    cell11.innerHTML = `<input class='form-control form-control-sm total' name='total[]' value='${parseFloat(total).toFixed(2)}' readonly='' required=''>`;
    cell12.innerHTML = `<div class='btn-group'>
                          <button class='btn btn-warning edit btn-sm' title='Editar linea' type='button'>
                            <i class='fas fa-edit log'></i></button>
                            <button class='btn btn-danger btn-sm del' type='button' title='Delete' onclick='deleteRow(${numero_item},${parseFloat(total).toFixed(2)});'><i class='fas fa-trash '></i>
                            </button></div>`;

    //Reset formulario
    $("#line_reference").val("");
    $("#ProdNombre").val("");
    $("#ProdNombre").val("");
    $("#ProdPrecioVenta").val("");
    $("#Dto").val("");
    $("#recargo").val("");
    $("#line_code_name").val("");
    $("#line_code").val("");
    document.getElementById("cantidad").value = "1";
    document.getElementById("ProdNombre").focus();
    calculator(total);
    $(function () {
      $(".input_code").on("keyup", function (e) {
        if (Number.isInteger(parseInt(this.value))) {
          var source = ruta + "/Facturacion/autoCompletarCodigo/product_code";
        } else {
          var source = ruta + "/Facturacion/autoCompletarCodigo/product_name";
        }
        $(this).autocomplete({
          source: source,
          minLength: 2,
          select: function (event, ui) {
            event.preventDefault();
            console.log($(this).parent().get(0).tagName);
            if ($(this).parent().get(0).tagName == "TD") {
              if (
                ui.item.product_code != null &&
                ui.item.product_name != null
              ) {
                $(this).val(ui.item.product_code);
              } else {
                $(this).val("");
              }
            } else {
              if (
                ui.item.product_code != null &&
                ui.item.product_name != null
              ) {
                $(this).val(ui.item.product_name);
                $("#line_code").val(ui.item.product_code);
              } else {
                $(this).val("");
                $("#line_code").val("");
              }
            }
          }
        });
      })
    });
  } else {
    alertify.warning("Las lineas a agregar no deben estar vacias");
  }
}
function deleteRow(r, valor) {
  var opcion = confirm("¿Realmente desea eliminar esta linea?");
  if (opcion == true) {
    document.getElementById("TableBody").deleteRow(r - 1);
    total = document.getElementById("sumAll").value;
    totalResta = Number(total) - Number(valor);
    var c = 1;
    $(".del").each(function () {
      var attr = $(this).attr("onclick");
      attr = attr.split(",");
      attr = attr[1];
      attr = attr.replace(");", "");
      $(this).attr("onclick", "deleteRow(" + c + "," + attr + " );");
      c++;
    });
    calcular(true);
  }
}
function calcular(type = false) {
  var ultimo = document.getElementsByName("numero_item[]");
  var numero_item = ultimo.length;
  if (numero_item == 0) {
    $("#sumAll").val(0);
    document.getElementById("sumViewTotal").value = 0;
  } else {
    var add = 0;
    $(".total").each(function () {
      if (!isNaN($(this).val())) {
        add += Number($(this).val());
      }
    });

    $("#sumAll").val(add);
    if (type == true) {
      document.getElementById("sumViewTotal").value = formatNumber.new(
        add,
        "$"
      );
    }
  }
}
function calculator(total) {
  //Total
  totalActual = document.getElementById("sumAll").value;
  totalFinal = Number(totalActual) + Number(total);
  $("#sumAll").val("");
  $("#sumAll").val(parseFloat(totalFinal).toFixed(2));
  document.getElementById("sumViewTotal").value = "";
  document.getElementById("sumViewTotal").value = formatNumber.new(
    totalFinal,
    "$"
  );
}
function detectedTotal() {
  var total = document.getElementById("sumAll").value;
  document.getElementById("sumViewTotal").value = formatNumber.new(total, "$");
}
function auto() {
  var sel = document.getElementById("ResponseCode").value;
  var area = document.getElementById("Description");

  switch (parseInt(sel)) {
    case 1:
      area.value =
        "Devolución parcial de los bienes y/o no aceptación parcial del servicio";
      break;
    case 2:
      area.value = "Anulación de factura electrónica";
      break;
    case 3:
      area.value = "Rebaja o descuento parcial o total";
      break;
    case 4:
      area.value = "Ajuste de precio";
      break;
    case 5:
      area.value = "Otros";
      area.removeAttribute("readonly");
      break;
  }
}
//$("#sumAll").val(formatNumber.new(totalFinal, "$"));
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
$(document).on("click", ".edit", function () {
  var $row = $(this).closest("tr");
  var doEdit = !$row.hasClass("edit-mode");
  toggleRowEdit($row, doEdit);
});
function toggleRowEdit($row, doEdit) {
  $row.toggleClass("edit-mode", doEdit);
  $row.find(".input_code").prop("hidden", !doEdit)
  $row
    .find(".ProdNombre,.Reference,.cantidad,.ProdPrecioVenta,.dto,.RE,.iva,.recargo,.input_code")
    .prop("readOnly", !doEdit);
  if (doEdit) {
    $row.find(".dto").val("");
    $row.find(".RE").val("");
    $row.find(".recargo").val("");
    $row.find(".iva").val("");
    $row.find(".dto").attr("placeholder", "%...");
    $row.find(".RE").attr("placeholder", "%...");
    $row.find(".recargo").attr("placeholder", "%...");
    $row.find(".iva").attr("placeholder", "%...");
    alertify.success("Linea desbloqueada");
  }
  contador.push(1);
  $row.find(".edit").val(doEdit ? "Save" : "Edit");
  $row.find(".edit").attr("class", "btn btn-success edit btn-sm");
  $row.find(".log").attr("class", "fas fa-check log");

  if (doEdit) {
    if (contador.length == 1) {
      $row
        .find(".ProdNombre")
        .focus()
        .select();
    } else {
      $row
        .find(".ProdNombre")
        .focus()
        .select();
    }
  } else {
    //alertify.success("Linea bloqueada.");
    $row.find(".edit").attr("class", "btn btn-warning edit btn-sm");
    $row.find(".log").attr("class", "fas fa-edit log");
    var codigo = $row.find(".input_code").val();
    var art = $row.find(".ProdNombre").val();
    var cant = $row.find(".cantidad").val();
    var price = $row.find(".ProdPrecioVenta").val();
    var dto = $row.find(".dto").val();
    var sub = $row.find(".subtotal").val();
    var ret = $row.find(".RE").val();
    var recargo = $row.find(".recargo").val();
    var iva = $row.find(".iva").val();

    var subtotal = cant * price;
    var valdto = (subtotal * dto) / 100;
    var recargov = (subtotal - valdto) * (recargo / 100);

    var neto = subtotal - valdto + recargov;
    var Ret = neto - (neto * ret) / 100;
    var RET = (neto * ret) / 100;
    var ivac = (neto * iva) / 100;
    var total = Ret + ivac;
    $row
      .find(".del")
      .attr("onclick", "deleteRow(" + $row[0].id + "," + total + ");");
    if (codigo == "" || codigo == null) {
      $row.find(".input_code").val();//valor por defecto si no eligen un codigo
    }
    $row.find(".ProdNombre").val(art);
    $row.find(".cantidad").val(cant);
    $row.find(".ProdPrecioVenta").val(parseFloat(price).toFixed(2));
    $row.find(".dto").val(parseFloat(valdto).toFixed(2));
    $row.find(".subtotal").val(parseFloat(neto).toFixed(2));
    $row.find(".RE").val(parseFloat(RET).toFixed(2));
    $row.find(".recargo").val(parseFloat(recargov).toFixed(2));
    $row.find(".iva").val(parseFloat(ivac).toFixed(2));
    $row.find(".total").val(parseFloat(total).toFixed(2));
    calcular(true);
    alertify.success("Linea bloqueada");
    contador = Array();
  }
}
function validator(rowid = null, complete = false) {
  var net = 0;
  var total = 0;
  var iv = 0;
  if (complete) {
    $(".total").each(function () {
      var row = $(this).closest("tr");
      var neto = row.find(".subtotal").val();
      var ret = row.find(".RE").val();
      var iva = row.find(".iva").val();
      var tot = row.find(".total").val();
      var bruto = parseFloat(neto) - parseFloat(ret);
      var calculo = (parseFloat(tot / bruto) - 1) * 100;
      net += parseFloat(neto);
      total += parseFloat(tot);
      iv += parseFloat(iva);
    });
    if (iv != 0) {
      var br = parseFloat(total / (total - iv));
      var mir = (br - 1) * 100;
      if (
        Math.round(mir) == 19 ||
        Math.round(mir) == 5 ||
        Math.round(mir) == 0
      ) {
        return true;
      } else {
        alertify.warning(
          "Todas las lineas deben tener los mismos porcentaje de iva, por favor revise"
        );
        return false;
      }
    } else {
      return true;
    }
  }
}
function SetSelect(elements) {
  for (var k in elements) {
    document.getElementById(Object.keys(elements[k])[0]).value = Object.values(elements[k])[0]
  }
}
//Funciones de ingreso
function SetImporte(value) {
  document.getElementById("importe").setAttribute("placeholder", document.getElementById("sumAll").value - value);
}
function enviarDN(idnota) {
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
        "¿Realmente desea generar esta nota débito? Recuerde que esta operación no se puede deshacer, ya que será validada por la DIAN."
      )
    );
    alertify.confirm(
      pre,
      function () {
        //feManager
        var button = document.getElementById("nota-" + idnota);
        button.setAttribute("disabled", true);
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/ajaxFE/generateDebitNote",
          data: "id=" + idnota,
          beforeSend: function (objeto) {
            button.innerHTML = "";
            button.innerHTML =
              '<span id="loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"> </span>';
          },
          success: function (datos) {
            if (datos == "true") {
              button.removeAttribute("disabled");
              alertify.success("Nota débito generada");
              $("#Notas")
                .DataTable()
                .ajax.reload();
              contador = Array();
            } else {
              button.innerHTML = "";
              button.innerHTML =
                '<i class="fas fa-qrcode"></i><span class="text-success" style="font-weight: bold;font-size:12px;"> DIAN</span>';
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
function enviarCN(idnota) {
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
        "¿Realmente desea generar esta nota crédito? Recuerde que esta operación no se puede deshacer, ya que será validada por la DIAN."
      )
    );
    alertify.confirm(
      pre,
      function () {
        //feManager
        var button = document.getElementById("nota-" + idnota);
        button.setAttribute("disabled", true);
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/ajaxFE/generateCreditNote",
          data: "id=" + idnota,
          beforeSend: function (objeto) {
            button.innerHTML = "";
            button.innerHTML =
              '<span id="loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"> </span>';
          },
          success: function (datos) {
            if (datos == "true") {
              button.removeAttribute("disabled");
              alertify.success("Nota crédito generada");
              $("#Notas")
                .DataTable()
                .ajax.reload();
              contador = Array();
            } else {
              button.innerHTML = "";
              button.innerHTML =
                '<i class="fas fa-qrcode"></i><span class="text-success" style="font-weight: bold;font-size:12px;"> DIAN</span>';
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
        "Desea reenviar el correo de nota ?"
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
              alertify.success("<i class='fas fa-check'></i> Correo nota reenviado correctamente");
              $("#Notas")
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