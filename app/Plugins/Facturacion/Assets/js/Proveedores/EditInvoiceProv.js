var ruta = document.getElementById("ruta").value;
var contador = Array();
$(document).ready(function (e) {
  detectedTotal();
  Values();
  var total_factura = document.getElementById("sumAll").value;
  total_recibos = 0;
  $("#tot").val(total_factura);
  table = $("#Recibos").DataTable({
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
      url: ruta + "/Facturacion/page/tableViewsOutsProveedor",
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
              "/Facturacion/page/detailOut/" +
              oData.id_recibo +
              '" title="Ir a info detallada" data-id="' +
              oData.id_recibo +
              '" >' +
              oData.numero +
              "</a>"
            );
          }
        }
      },
      {
        data: "proveedor",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.numero != "" || oData.numero != null) {
            $(nTd).html(
              '<a href="' +
              ruta +
              "/Facturacion/page/Provdetail/" +
              oData.codproveedor +
              '" title="Ir a info detallada" data-id="' +
              oData.codproveedor +
              '" >' +
              oData.proveedor +
              "</a>"
            );
          }
        }
      },
      {
        data: "emitido"
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
      { data: "vencimiento" },
      {
        data: "pagado",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
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
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          var state = document.getElementById("FacEstado").value;
          //console.log(state);
          if (state != 1 && state != 3) {
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
              '" class="btn btn-sm btn-outline-secondary"  target="__blank" data-id="' +
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
  //------------------------------------
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
    event.preventDefault();

    $("#btnsaveinvprov").attr("disabled", true);
    var state = document.getElementById("FacEstado").value;
    var count_outs = document.getElementById("count_recibos").value;
    var parametros = $(this).serialize();
    var idf = document.getElementById("idfactura").value;

    console.log(count_outs);
    if (state == 2) {
      if (count_outs == 0) {
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/page/EditInvProv",
          data: parametros,
          beforeSend: function (objeto) {
            //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
          },
          success: function (datos) {
            var result = datos.split("-");
            if (result[0] == true) {
              //$("#resultados_ajax").html('<span></span>');
              $("#btnsaveinvprov").attr("disabled", false);
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
            }
          }
        });
      } else {
        alertify.confirm(
          "Advertencia !!!",
          "Esta factura tiene recibos asociados, si desea anular esta factura se eliminarán los recibos. Está seguro de esta acción?",
          function () {
            $.ajax({
              type: "POST",
              url: ruta + "/Facturacion/page/Delete",
              data: "id=" + idf + "&table=recibos_proveedor&key=idfactura",
              beforeSend: function (objeto) { },
              success: function (datos) {
                if (datos == true) {
                  $.ajax({
                    type: "POST",
                    url: ruta + "/Facturacion/page/EditInvProv",
                    data: parametros,
                    beforeSend: function (objeto) {
                      //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
                    },
                    success: function (datos) {
                      var result = datos.split("-");
                      if (result[0] == true) {
                        //$("#resultados_ajax").html('<span></span>');
                        $("#btnsaveinvprov").attr("disabled", false);
                        alertify.success(
                          '<h6><i class="fas fa-check"></i>Factura editada correctamente</h6>'
                        );
                        //Para ir a factura detallada
                        setTimeout(function () {
                          location.reload();
                        }, 1500);
                      } else {
                        //$("#resultados_ajax").html('<span></span>');
                        $("#btnsaveinvprov").attr("disabled", false);
                        alertify.warning(datos);
                      }
                    }
                  });
                }
              }
            });
            alertify.success(
              '<h6><i class="fas fa-check"></i>Factura Anulada correctamente</h6>'
            );
          },
          function () {
            alertify.error("Proceso cancelado");
          }
        );
      }
    } else if (state == 3) {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/CheckInvOut",
        data: "idf=" + idf,
        beforeSend: function (objeto) {
          //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function (datos) {
          var result = datos.split("-");
          if (datos == true) {
            //$("#resultados_ajax").html('<span></span>');
            $.ajax({
              type: "POST",
              url: ruta + "/Facturacion/page/EditInvProv",
              data: parametros,
              beforeSend: function (objeto) {
                //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
              },
              success: function (datos) {
                var result = datos.split("-");
                if (result[0] == true) {
                  //$("#resultados_ajax").html('<span></span>');
                  $("#btnsaveinvprov").attr("disabled", false);
                  alertify.success(
                    '<h6><i class="fas fa-check"></i>Factura editada correctamente</h6>'
                  );
                  //Para ir a factura detallada
                } else {
                  //$("#resultados_ajax").html('<span></span>');
                  $("#btnsaveinvprov").attr("disabled", false);
                  alertify.warning(datos);
                }
              }
            });
            $("#btnsaveinvprov").attr("disabled", false);
            alertify.success(
              '<h6><i class="fas fa-check"></i>Factura completada</h6>'
            );
            //Para ir a factura detallada
            setTimeout(function () {
              location.reload();
            }, 1500);
          } else {
            //$("#resultados_ajax").html('<span></span>');
            $("#btnsaveinvprov").attr("disabled", false);
            alertify.warning(datos);
            console.log(datos);
          }
        }
      });
    } else {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/EditInvProv",
        data: parametros,
        beforeSend: function (objeto) {
          //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function (datos) {
          var result = datos.split("-");
          if (result[0] == true) {
            //$("#resultados_ajax").html('<span></span>');
            $("#btnsaveinvprov").attr("disabled", false);
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
          }
        }
      });
    }
  });
  $("#newout").submit(function (event) {
    $("#btnaddout").attr("disabled", true);
    var parametros = $(this).serialize();
    var tot = document.getElementById("sumAll").value;
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/AddRecibo",
      data: parametros,
      beforeSend: function (objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function (datos) {
        var result = datos.split("-");
        if (result[0] == true) {
          $("#newout")[0].reset();
          $("#addout").modal("hide");
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddout").attr("disabled", false);
          var total = 0;

          alertify.success(
            '<h6><i class="fas fa-check"></i>Recibo creado correctamente</h6>'
          );
          total_recibos = 0;
          $("#Recibos")
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
    event.preventDefault();
  });
  $(function () {
    $("#ClieNit").autocomplete({
      source: ruta + "/Facturacion/page/autoCompleteProv/cifnif",
      minLength: 2,
      select: function (event, ui) {
        event.preventDefault();
        $("#codproveedor").val(ui.item.codproveedor);
        $("#ClieNit").val(ui.item.cifnif);
        $("#ClieNombre").val(ui.item.nombre);
        $("#prov").val(ui.item.nombre);
        $("#ClieTelefono").val(ui.item.telefono1);
        $("#ClieEmail").val(ui.item.email);
        $("#ClieDireccion").val(ui.item.direccion);
        // document.getElementById("ProdNombre").focus();
      }
    });
  });
});

function Values() {
  var idf = document.getElementById("idfactura").value;
  var cprov = document.getElementById("codproveedor").value;
  $("#idf").val(idf);
  $("#codprov").val(cprov);
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
    document.createTextNode("Realmente desea eliminar este recibo?")
  );
  alertify.confirm(
    pre,
    function () {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/Delete",
        data: "id=" + idProv + "&table=recibos_proveedor&key=id_recibo",
        q: q,
        beforeSend: function (objeto) {
          //$("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
          var result = datos;

          if (datos == true) {
            total_recibos = 0;
            $("#Recibos")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i>Recibo eliminado</h6>'
            );
          } else {
            console.log(result);
            total_recibos = 0;
            $("#Recibos")
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
function agregaritem() {
  var ultimo = document.getElementsByName("numero_item[]");
  var numero_item = ultimo.length + 1;
  //Valores qe se van a gregar a linea
  var nombre_producto = document.getElementById("ProdNombre").value;
  var precio = document.getElementById("ProdPrecioVenta").value;
  var cantidad = document.getElementById("cantidad").value;
  var RE = document.getElementById("RE").value;
  var tasa_iva = document.getElementById("iva").value;
  var dto = document.getElementById("Dto").value;

  if (nombre_producto != "" && precio != "" && cantidad != "") {
    var subtotal = cantidad * precio;
    var valdto = (subtotal * dto) / 100;
    var neto = subtotal - valdto;
    var Ret = neto - (neto * RE) / 100;
    var RET = (neto * RE) / 100;
    var iva_calculo = (Ret * tasa_iva) / 100;
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
    cell1.innerHTML =
      "<input hidden class='form-control input-sm numero_item'  type='text' name='numero_item[]' readonly value='" +
      numero_item +
      "'  required>";
    cell2.innerHTML =
      "<input class='form-control form-control-sm ProdNombre' type='text' name='ProdNombre[]' value='" +
      nombre_producto +
      "' readonly='' required='' title='" +
      nombre_producto +
      "'>";
    cell3.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm cantidad' name='cantidad[]' value='" +
      cantidad +
      "' readonly='' required=''>";
    cell4.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm ProdPrecioVenta' name='ProdPrecioVenta[]' value='" +
      parseFloat(precio).toFixed(2) +
      "' readonly='' required=''>";
    cell5.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm Dto' name='dto[]' value='" +
      parseFloat(valdto).toFixed(2) +
      "' readonly='' required=''>";
    cell6.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm subtotal' name='subtotal[]' value='" +
      parseFloat(neto).toFixed(2) +
      "' readonly='' required=''>";
    cell7.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm RE' name='RE[]' value='" +
      parseFloat(RET).toFixed(2) +
      "' readonly='' required=''>";
    cell8.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm iva' name='iva[]' value='" +
      parseFloat(iva).toFixed(2) +
      "' readonly='' required=''>";
    cell9.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm total ' name='total[]' value='" +
      parseFloat(total).toFixed(2) +
      "' readonly='' required=''>";
    cell10.innerHTML =
      "<div class='btn-group'><button type='button' class='btn btn-warning btn-sm edit'><i class='fas fa-edit log'></i></button><button class='btn btn-danger btn-sm del' type='button' title='Delete' onclick='deleteRow(" +
      numero_item +
      ", " +
      parseFloat(total).toFixed(2) +
      ");'><i class='fas fa-trash'></i></button></div>";

    //Reset formulario
    $("#ProdNombre").val("");
    $("#ProdNombre").val("");
    $("#ProdPrecioVenta").val("");
    $("#Dto").val("");
    document.getElementById("cantidad").value = "1";
    document.getElementById("ProdNombre").focus();

    calculator(total);
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
  $row
    .find(".ProdNombre,.cantidad,.ProdPrecioVenta,.Dto,.RE,.iva")
    .prop("readOnly", !doEdit);
  if (doEdit) {
    $row.find(".Dto").val("");
    $row.find(".RE").val("");
    $row.find(".iva").val("");
    $row.find(".Dto").attr("placeholder", "%...");
    $row.find(".RE").attr("placeholder", "%...");
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

    var art = $row.find(".ProdNombre").val();
    var cant = $row.find(".cantidad").val();
    var price = $row.find(".ProdPrecioVenta").val();
    var dto = $row.find(".Dto").val();
    var sub = $row.find(".subtotal").val();
    var ret = $row.find(".RE").val();
    var iva = $row.find(".iva").val();

    var subtotal = cant * price;
    var valdto = (subtotal * dto) / 100;
    var neto = subtotal - valdto;
    var Ret = neto - (neto * ret) / 100;
    var RET = (neto * ret) / 100;

    var ivac = (Ret * iva) / 100;
    var total = Ret + ivac;

    $row
      .find(".del")
      .attr("onclick", "deleteRow(" + $row[0].id + "," + total + ");");

    $row.find(".ProdNombre").val(art);
    $row.find(".cantidad").val(cant);
    $row.find(".ProdPrecioVenta").val(parseFloat(price).toFixed(2));
    $row.find(".Dto").val(parseFloat(valdto).toFixed(2));
    $row.find(".subtotal").val(parseFloat(neto).toFixed(2));
    $row.find(".RE").val(parseFloat(RET).toFixed(2));
    $row.find(".iva").val(parseFloat(ivac).toFixed(2));
    $row.find(".total").val(parseFloat(total).toFixed(2));
    calcular(true);
    alertify.success("Linea bloqueada");
    contador = Array();
  }
}
