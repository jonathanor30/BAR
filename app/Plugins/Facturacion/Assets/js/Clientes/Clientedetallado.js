var ruta = document.getElementById("ruta").value;
window.onload = Autoload();
function Autoload() {
  SetSelect(elements);
}
document.getElementById("cifnif").addEventListener("keyup", function (e) {
  this.value = this.value.trim();
});
document.getElementById("remove-liabilities").addEventListener("click", function () {
  if(document.getElementById("responsabilidades").value != "" && typeof document.getElementById("responsabilidades").value != 'undefined'){
    alertify.confirm('Remover responsabilidades', '¿Desea remover las responsabilidades?', function () {
      document.getElementById("responsabilidades").value = "";
      alertify.success("Responsabilidades eliminadas");
    }, function () {
      alertify.error('Cancelado')
    });
  }
});
//js para vista detailprovider
$(document).ready(function () {

  //datatable facturas cliente
  table = $("#invoicesprov").DataTable({
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
      url: ruta + "/Facturacion/page/TableviewsFactCliente",
      type: "POST",
      data: function (d) {
        d.cifnif = $("#id_cliente").val(); //importante
      }
    },

    columns: [
      {
        data: "numero",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          if (oData.idfactura != null) {
            $(nTd).html(
              '<a href="' +
              ruta +
              "/Facturacion/page/detalleFactura/" +
              oData.idfactura +
              '" title="Ir a info detallada" data-id="' +
              oData.idfactura +
              '" >' +
              oData.numero +
              "</a>"
            );
          } else {
            $(nTd).html(oData.numero);
          }
        }
      },
      {
        data: "totaldto",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html("$ " + oData.totaldto);
        }
      },
      {
        data: "totaliva",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html("$ " + oData.totaliva);
        }
      },
      {
        data: "total",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html("$ " + oData.total);
        }
      },
      { data: "observaciones" },
      {
        data: "estado",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.estado)) {
            case 0:
              $(nTd).html(
                '<span class="badge badge-pill badge-danger">Pendiente</span>'
              );
              break;
            case 1:
              $(nTd).html(
                '<span  class="badge badge-pill badge-success">Pagada</span>'
              );
              break;
            case 2:
              $(nTd).html(
                '<h6><span class="badge badge-pill badge-warning">Fact/NCrédito</span></h6>'
              );
              break;
            case 3:
              $(nTd).html(
                '<h6><span  class="badge badge-pill badge-primary">Firmada</span></h6>'
              );
              break;
            case 4:
              $(nTd).html(
                '<h6><span  class="badge badge-pill badge-primary">Firmada/Pagada</span></h6>'
              );
              break;
            case 5:
              $(nTd).html(
                '<h6><span  class="badge badge-pill badge-info">Fact/NDébito</span></h6>'
              );
              break;
            case 6:
              $(nTd).html(
                '<h6><span  class="badge badge-pill badge-info">Fact/NCrédito/NDébito</span></h6>'
              );
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
          if (oData.estado != 3 && oData.estado != 4 && oData.estado != 2) {
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
            $(nTd).html(
              '<div class="btn-group"><a href="' +
              ruta +
              "/Facturacion/page/detallefactura/" +
              oData.idfactura +
              '" class="btn btn-sm btn-outline-secondary" title="Ver factura"  data-id="' +
              oData.idfactura +
              '" ><i class="fas fa-eye"></i></a><a class="btn btn-sm btn-outline-secondary" target="_blank" href="' +
              ruta +
              "/Facturacion/ajaxFE/verFactura/" +
              oData.idfactura + '"><i class="fas fa-print"></i></a></div>'
            );
          }
        }
      }
    ]
  });
  //Jquery para ajax editar proveedor
  $("#editar_cliente").submit(function (event) {
    event.preventDefault();
    $("#btneditclie").attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/EditClient", //Ruta metodo
      data: parametros,
      beforeSend: function (objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function (datos) {
        var result = datos;
        if (datos == true) {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditclie").attr("disabled", false);

          alertify.success(
            '<h6><i class="fas fa-check"></i> Cliente editado correctamente</h6>'
          );
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditclie").attr("disabled", false);
          alertify.warning(result);
          console.log(result);
        }
      }
    });
  });
  //Jquery para ajax editar cuenta bancaria proveedor
  $("#editaccount").submit(function (event) {
    event.preventDefault();
    $("#btneditaccount").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/EditClient",
      data: parametros,
      beforeSend: function (objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function (datos) {
        var result = datos;
        if (datos == true) {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditaccount").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Cuenta bancaria editada correctamente</h6>'
          );
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditaccount").attr("disabled", false);
          alertify.warning(result);
          console.log(result);
        }
      }
    });
  });
  //Jquery para ajax editar dirección
  $("#editaddress").submit(function (event) {
    event.preventDefault();
    $("#btneditaddress").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/EditClient",
      data: parametros,
      beforeSend: function (objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function (datos) {
        var result = datos;
        if (datos == true) {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditaddress").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Dirección editada correctamente</h6>'
          );
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditaddress").attr("disabled", false);
          alertify.warning(result);
          console.log(result);
        }
      }
    });
  });
});

function eliminar(idProv) {
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
    document.createTextNode("Realmente desea eliminar esta factura?")
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
            $("#invoicesprov")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i>Factura eliminada</h6>'
            );
          } else {
            console.log(result);
            $("#invoicesprov")
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
function SetSelect(elements) {
  for (var k in elements) {
    document.getElementById(Object.keys(elements[k])[0]).value = Object.values(elements[k])[0]
  }
}

function SetLiabilities(id, source, key = "", key_value = "") {
  var parameters = "key=" + key + "&id=" + key_value;
  $.ajax({
    type: "POST",
    url: ruta + "/Facturacion/page/" + source,
    data: parameters,
    success: function (data) {
      if (isJSON(data)) {
        var liabilities = document.getElementById(id);
        var current = liabilities.value;
        var result = JSON.parse(data);
        var temp = liabilities.value.split(";");
        if (liabilities.value == "") {
          liabilities.value = null;
          temp.splice("", 1);
        }

        if (temp.length > 0) {
          liabilities.value = null;
          temp.splice("", 1);
          for (let i = 0; i < temp.length; i++) {
            if (temp[i] != result.code) {
              liabilities.value = current + result.code + ";";
            }
          }
        } else {
          liabilities.value = current + result.code + ";";
        }
      } else {
        alertify.warning("Error al traer los datos, por favor revise");
      }
    }
  })
}
document.getElementById("cifnif_dv").addEventListener("keyup", function (e) {
  if (this.value.length > 1) {
    this.classList.add("is-invalid");
    this.value = "";
  } else if (this.value.length == 0) {
    this.classList.remove("is-invalid");
    this.classList.remove("is-valid");
  } else {
    this.classList.remove("is-invalid");
    this.classList.add("is-valid");
  }
});
document
  .getElementById("liabilities")
  .addEventListener("change", function () {
    SetLiabilities("responsabilidades", "GetLiabilities", "id", this.value);
    alertify.success(this.options[this.options.selectedIndex].text);
  });
function isJSON(str) {
  try {
    JSON.parse(str);
  } catch (error) {
    return false;
  }
  return true;
}