var ruta = document.getElementById("ruta").value;
var contador = Array();
$(document).ready(function() {
  $("form").keypress(function(e) {
    if (e == 13) {
      return false;
    }
  });
  $("input").keypress(function(e) {
    if (e.which == 13) {
      return false;
    }
  });
  $("#ClieNit").on("keydown", function(event) {
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
  $("#datos_factura").submit(function(event) {
    $("#btnsaveinvprov").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/SaveinvProv",
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
        var result = datos.split("-");
        if (result[0] == true) {
          if (contador.length == 0) {
            $("#datos_factura")[0].reset();
            //$("#resultados_ajax").html('<span></span>');
            $("#btnsaveinvprov").attr("disabled", true);
            alertify.success(
              '<h6><i class="fas fa-check"></i> Factura agregada correctamente</h6>'
            );
            //Para ir a factura detallada
            setTimeout(function() {
              location.href =
                ruta + "/Facturacion/page/ProvFactdetail/" + result[1];
            }, 1000);
          } else {
            alertify.warning(
              "No se puede guardar la factura sin bloquear las lineas"
            );
            $("#btnsaveinvprov").attr("disabled", false);
          }
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btnsaveinvprov").attr("disabled", false);
          alertify.warning(datos);
          console.log(datos);
        }
      }
    });
    event.preventDefault();
  });
  //Autocompletar cliente
  $(function() {
    $("#ClieNit").autocomplete({
      source: ruta + "/Facturacion/page/autoCompleteProv/cifnif",
      minLength: 2,
      select: function(event, ui) {
        event.preventDefault();
        if (ui.item.estado == 1) {
          $("#codproveedor").val(ui.item.codproveedor);
          $("#ClieNit").val(ui.item.cifnif);
          $("#ClieNombre").val(ui.item.nombre);
          $("#ClieTelefono").val(ui.item.telefono1);
          $("#ClieEmail").val(ui.item.email);
          $("#ClieDireccion").val(ui.item.direccion);
          // document.getElementById("ProdNombre").focus();
        } else {
          alertify.warning("El proveedor no está activo");
          $("#ClieNit").val("");
        }
      }
    });
  });
  $(function() {
    $("#ClieNombre").autocomplete({
      source: ruta + "/Facturacion/page/autoCompleteProv/nombre",
      minLength: 2,
      select: function(event, ui) {
        event.preventDefault();
        if (ui.item.estado == 1) {
          $("#codproveedor").val(ui.item.codproveedor);
          $("#ClieNit").val(ui.item.cifnif);
          $("#ClieNombre").val(ui.item.nombre);
          $("#ClieTelefono").val(ui.item.telefono1);
          $("#ClieEmail").val(ui.item.email);
          $("#ClieDireccion").val(ui.item.direccion);
          // document.getElementById("ProdNombre").focus();
        } else {
          alertify.warning("El proveedor no está activo");
          $("#ClieNit").val("");
        }
      }
    });
  });
});

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
      "<input class='form-control form-control-sm ProdNombre'  type='text' name='ProdNombre[]' value='" +
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
      "<input type='number' step='any' class='form-control form-control-sm dto' name='dto[]' value='" +
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
      "<input type='number' step='any' class='form-control form-control-sm total' name='total[]' value='" +
      parseFloat(total).toFixed(2) +
      "' readonly='' required=''>";
    cell10.innerHTML =
      "<div class='btn-group'><button class='btn btn-warning edit btn-sm' title='Editar linea' type='button'><i class='fas fa-edit log'></i></button><button class='btn btn-danger btn-sm del' type='button' title='Delete' onclick='deleteRow(" +
      numero_item +
      "," +
      parseFloat(total).toFixed(2) +
      ");'><i class='fas fa-trash '></i></button></div>";

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
    $(".del").each(function() {
      var attr = $(this).attr("onclick");
      attr = attr.split(",");
      attr = attr[1];
      attr = attr.replace(");", "");
      console.log(attr);
      $(this).attr("onclick", "deleteRow(" + c + "," + attr + ");");
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
    $(".total").each(function() {
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

var formatNumber = {
  separador: ".", // separador para los miles
  sepDecimal: ",", // separador para los decimales
  formatear: function(num) {
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
  new: function(num, simbol) {
    this.simbol = simbol || "";
    return this.formatear(num);
  }
};

$(document).on("click", ".edit", function() {
  var $row = $(this).closest("tr");
  var doEdit = !$row.hasClass("edit-mode");
  toggleRowEdit($row, doEdit);
});

function toggleRowEdit($row, doEdit) {
  $row.toggleClass("edit-mode", doEdit);
  $row
    .find(".ProdNombre,.cantidad,.ProdPrecioVenta,.dto,.RE,.iva")
    .prop("readOnly", !doEdit);
  if (doEdit) {
    $row.find(".dto").val("");
    $row.find(".RE").val("");
    $row.find(".iva").val("");
    $row.find(".dto").attr("placeholder", "%...");
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
    var dto = $row.find(".dto").val();
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
