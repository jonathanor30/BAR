ruta = document.getElementById('ruta').value;

$(document).ready(function () {
  //Jquery para ajax editar proveedor
  $("#editing").submit(function (event) {
    event.preventDefault();
    $("#btneditin").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/EditIn", //Ruta metodo
      data: parametros,
      beforeSend: function (objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function (datos) {
        var result = datos.split('-');
        if (datos == true) {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditin").attr("disabled", false);

          alertify.success(
            '<h6><i class="fas fa-check"></i>Ingreso editado correctamente</h6>'
          );
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditin").attr("disabled", false);
          alertify.warning(datos);
          console.log(datos);
        }
      }
    });
  });

  $(function () {
    $("#id_factura").autocomplete({
      source: ruta + "/Facturacion/page/autoCompleteInv",
      select: function (event, ui) {
        event.preventDefault();
        if (ui.item.estado != 1 && ui.item.estado != 2) {
          $("#id_factura").val(ui.item.numero);
          $("#idfactura").val(ui.item.idfactura);
          // document.getElementById("ProdNombre").focus();
        } else {
          alertify.warning("la factura no puede estar pagada o anulada");
          $("#id_factura").val("");
        }
      }
    });
  });
});