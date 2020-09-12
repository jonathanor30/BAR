ruta = document.getElementById("ruta").value;

$(document).ready(function() {
  //Jquery para ajax editar proveedor
  $("#editrec").submit(function(event) {
    event.preventDefault();
    $("#btneditout").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/EditOut", //Ruta metodo
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
        console.log(datos);
        var result = datos.split("-");
        if (result[0] == "true" && result.length == 2) {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditout").attr("disabled", false);

          alertify.success(
            '<h6><i class="fas fa-check"></i>Egreso editado correctamente</h6>'
          );
          setTimeout(function() {
            window.location.href =
              ruta + "/Facturacion/page/ProvFactdetail/" + result[1];
          }, 1500);
        } else if (datos == "true") {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditout").attr("disabled", false);
          setTimeout(function() {
            location.reload();
          }, 1500);
          alertify.success(
            '<h6><i class="fas fa-check"></i>Egreso editado correctamente</h6>'
          );
        } else if (result[1] == 'reload') {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditout").attr("disabled", false);
          setTimeout(function() {
            location.reload();
          }, 1000);
          alertify.success(
            '<h6><i class="fas fa-check"></i>Egreso editado correctamente</h6>'
          );
        }else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditout").attr("disabled", false);
          alertify.warning(datos);
          console.log(datos);
        }
      }
    });
  });

  $(function() {
    $("#id_factura").autocomplete({
      source: ruta + "/Facturacion/page/autoCompleteInv",
      select: function(event, ui) {
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
