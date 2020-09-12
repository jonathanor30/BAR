var ruta = document.getElementById("ruta").value;
var contador = Array();
$(document).ready(function () {
  $("form").keypress(function (e) {
    if (e.keyCode == 13) {
      return false;
    }
  });
  $("input").keypress(function (e) {
    if (e.which == 13) {
      return false;
    }
  });
  $("#nombre").on("keydown", function (event) {
    if (
      event.keyCode == $.ui.keyCode.DELETE ||
      event.keyCode == $.ui.keyCode.BACKSPACE
    ) {
      $("#codcliente").val("");
      $("#cifnif").val("");
      $("#nombre").val("");
      $("#telefono").val("");
      $("#email").val("");
      $("#direccion").val("");
      $("#medio_pago").val("");
    }
  });
  $("#ProdNombre").on("keydown", function (event) {
    if (
      event.keyCode == $.ui.keyCode.DELETE ||
      event.keyCode == $.ui.keyCode.BACKSPACE
    ) {
      $("#line_code_name").val("");
      $("#line_code").val("");
      $("#ProdNombre").val("");
    }
  });

  $("#datos_factura").submit(function (event) {
    event.preventDefault();

    $("#btnsaveinvprov").attr("disabled", true);
    var parametros = $(this).serialize();
    if (validator(null, true) == true) {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/page/SaveInvClie",
        data: parametros,
        beforeSend: function (objeto) {
          //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function (datos) {
          //console.log(datos);
          var result = datos.split("-");
          if (result[0] == true) {
            $("#datos_factura")[0].reset();
            //$("#resultados_ajax").html('<span></span>');
            $("#btnsaveinvprov").attr("disabled", true);
            alertify.success(
              '<h6><i class="fas fa-check"></i> Factura agregada correctamente</h6>'
            );
            //Para ir a factura detallada
            setTimeout(function () {
              location.href =
                ruta + "/Facturacion/page/detalleFactura/" + result[1];
            }, 1000);
          } else {
            //$("#resultados_ajax").html('<span></span>');
            $("#btnsaveinvprov").attr("disabled", false);
            alertify.warning(datos);
            console.log(datos);
          }
        },
      });
    } else {
      $("#btnsaveinvprov").attr("disabled", false);
    }
  });
  //Autocompletar cliente
  $(function () {
    $("#nombre").autocomplete({
      source: ruta + "/Facturacion/page/autoCompletarCliente/nombre",
      minLength: 2,
      select: function (event, ui) {
        event.preventDefault();

        $("#id_cliente").val(ui.item.id_cliente);
        $("#cifnif").val(ui.item.cifnif);
        $("#nombre").val(ui.item.nombre);
        $("#telefono").val(ui.item.telefono1);
        $("#email").val(ui.item.email);
        $("#direccion").val(ui.item.direccion);
        $("#FacFormaPago").val(ui.item.codpago);
        $("#medio_pago").val(ui.item.medio_pago);
      },
    });
  });
  $(function () {
    $("#cifnif").autocomplete({
      source: ruta + "/Facturacion/page/autoCompletarCliente/cifnif",
      minLength: 2,
      select: function (event, ui) {
        event.preventDefault();
        if (
          ui.item.codcliente != null &&
          ui.item.cifnif != null &&
          ui.item.nombre != null &&
          ui.item.telefono1 != null &&
          ui.item.email != null &&
          ui.item.direccion != null &&
          ui.item.codcliente != "" &&
          ui.item.cifnif != "" &&
          ui.item.nombre != "" &&
          ui.item.telefono1 != "" &&
          ui.item.email != "" &&
          ui.item.direccion != ""
        ) {
          if (ui.item.estado == 1) {
            $("#codcliente").val(ui.item.codcliente);
            $("#cifnif").val(ui.item.cifnif);
            $("#nombre").val(ui.item.nombre);
            $("#telefono").val(ui.item.telefono1);
            $("#email").val(ui.item.email);
            $("#direccion").val(ui.item.direccion);
            $("#FacFormaPago").val(ui.item.codpago);
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
              $("#codcliente").val("");
              $("#cifnif").val("");
              $("#nombre").val("");
              $("#telefono").val("");
              $("#email").val("");
              $("#direccion").val("");
            }
          );
        }
      },
    });
  });
  //Autocompletar codigo de servicio
  $(function () {
    $(".input_code").on("keyup", function (e) {
      if (Number.isInteger(parseInt(this.value))) {
        var source = ruta + "/Facturacion/autoCompletarCodigo/CodigoProducto";
      } else {
        var source = ruta + "/Facturacion/autoCompletarCodigo/NombreProducto";
      }
      $(this).autocomplete({
        source: source,
        minLength: 1,
        select: function (event, ui) {
          event.preventDefault();
          if (
            ui.item.CodigoProducto != null &&
            ui.item.NombreProducto != null
          ) {
            $("#line_code_name").val(ui.item.NombreProducto);
            $("#line_code").val(ui.item.CodigoProducto);
            $("#ProdNombre").val(ui.item.NombreProducto);
          } else {
            $("#line_code_name").val("");
            $("#line_code").val("");
            $("#ProdNombre").val("");
          }
        },
      });
    });
  });
});

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

  if (
    nombre_producto != "" &&
    precio != "" &&
    cantidad != "" &&
    document.getElementById("line_code_name").value != ""
  ) {
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
    cell5.innerHTML = `<input class='form-control form-control-sm ProdPrecioVenta' name='ProdPrecioVenta[]' value='${parseFloat(
      precio
    ).toFixed(2)}' readonly='' required>`;
    cell6.innerHTML = `<input class='form-control form-control-sm dto' name='dto[]' value='${parseFloat(
      valdto
    ).toFixed(2)}' readonly='' required=''>`;
    cell7.innerHTML = `<input class='form-control form-control-sm recargo' name='recargo[]' value='${parseFloat(
      valrecargo
    ).toFixed(2)}' readonly='' required=''>`;
    cell8.innerHTML = `<input class='form-control form-control-sm subtotal' name='subtotal[]' value='${parseFloat(
      neto
    ).toFixed(2)}' readonly='' required=''>`;
    cell9.innerHTML = `<input class='form-control form-control-sm RE' name='RE[]' value='${parseFloat(
      RET
    ).toFixed(2)}' readonly='' required=''>`;
    cell10.innerHTML = `<input class='form-control form-control-sm iva' name='iva[]' value='${parseFloat(
      iva
    ).toFixed(2)}' readonly='' required=''>`;
    cell11.innerHTML = `<input class='form-control form-control-sm total' name='total[]' value='${parseFloat(
      total
    ).toFixed(2)}' readonly='' required=''>`;
    cell12.innerHTML = `<div class='btn-group'>
                            <button class='btn btn-warning edit btn-sm' title='Editar linea' type='button'>
                              <i class='fas fa-edit log'></i></button>
                              <button class='btn btn-danger btn-sm del' type='button' title='Delete' onclick='deleteRow(${numero_item},${parseFloat(
      total
    ).toFixed(2)});'><i class='fas fa-trash '></i>
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
          var source = ruta + "/Facturacion/autoCompletarCodigo/CodigoProducto";
        } else {
          var source = ruta + "/Facturacion/autoCompletarCodigo/NombreProducto";
        }
        $(this).autocomplete({
          source: source,
          minLength: 1,
          select: function (event, ui) {
            event.preventDefault();
            if ($(this).parent().get(0).tagName == "TD") {
              if (
                ui.item.CodigoProducto != null &&
                ui.item.NombreProducto != null
              ) {
                $(this).val(ui.item.CodigoProducto);
                var row = $(this).closest("tr");
                row.find(".ProdNombre").val(ui.item.NombreProducto);
              } else {
                $(this).val("");
              }
            } else {
              if (
                ui.item.CodigoProducto != null &&
                ui.item.NombreProducto != null
              ) {
                $(this).val(ui.item.NombreProducto);
                $("#line_code").val(ui.item.CodigoProducto);
              } else {
                $(this).val("");
                $("#line_code").val("");
              }
            }
          },
        });
      });
    });
  } else {
    alertify.warning("Las lineas a agregar no deben estar vacias");
  }
}

function deleteRow(r, valor, once = false) {
  if (once == false) {
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
        $(this).attr("onclick", "deleteRow(" + c + "," + attr + ");");
        c++;
      });
      calcular(true);
    }
  } else {
    document.getElementById("TableBody").deleteRow(r - 1);
    total = document.getElementById("sumAll").value;
    totalResta = Number(total) - Number(valor);
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
    parseFloat(totalFinal).toFixed(2),
    "$"
  );
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
  },
};

$(document).on("click", ".edit", function () {
  var $row = $(this).closest("tr");
  var doEdit = !$row.hasClass("edit-mode");
  toggleRowEdit($row, doEdit);
});

function toggleRowEdit($row, doEdit) {
  $row.toggleClass("edit-mode", doEdit);
  $row.find(".input_code").prop("hidden", !doEdit);
  $row
    .find(
      ".ProdNombre,.Reference,.cantidad,.ProdPrecioVenta,.dto,.RE,.iva,.recargo,.input_code"
    )
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
      $row.find(".ProdNombre").focus().select();
    } else {
      $row.find(".ProdNombre").focus().select();
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
      $row.find(".input_code").val(); //valor por defecto si no eligen un codigo
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
