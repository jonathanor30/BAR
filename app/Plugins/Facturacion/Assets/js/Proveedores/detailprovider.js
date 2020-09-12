var ruta = document.getElementById("ruta").value;
//js para vista detailprovider
$(document).ready(function() {
  //datatable facturas cliente
  table = $("#invoicesprov").DataTable({
    processing: true,
    serverSide: true,
    order: [[1, "asc"]],
    pageLength: 10,
    lengthMenu: [
      [10, 25, 50, -1],
      [25, 50, 100, "All"]
    ],
    language: { url: ruta + "/public/js/Spanish.json" },

    ajax: {
      url: ruta + "/Facturacion/page/TableviewsFactProveedor",
      type: "POST",
      data: function(d) {
        d.cifnif = $("#id_proveedor").val(); //importante
      }
    },

    columns: [
      {
        data: "numero",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.idfactura != null) {
            console.log(oData.idfactura);
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
          } else {
            $(nTd).html(oData.numero);
          }
        }
      },
      {
        data: "totaldto",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html("$ " + oData.totaldto);
        }
      },
      {
        data: "totaliva",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html("$ " + oData.totaliva);
        }
      },
      {
        data: "total",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html("$ " + oData.total);
        }
      },
      { data: "observaciones" },
      {
        data: "estado",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
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
                '<h6><span  class="badge badge-pill badge-primary">Pago parcial</span></h6>'
              );
              break;
          }
        }
      },
      {
        data: "idfactura",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            '<div class="btn-group"><a href="' +
              ruta +
              "/Facturacion/page/ProvFactdetail/" +
              oData.idfactura +
              '" class="btn btn-sm btn-outline-secondary"  data-id="' +
              oData.idfactura +
              '" ><i class="fas fa-edit"></i></a><a onclick="eliminar(' +
              oData.idfactura +
              ')" class="btn btn-sm btn-outline-secondary"  data-id="' +
              oData.idfactura +
              '" ><i class="fas fa-trash-alt"></i></a></div>'
          );
        }
      }
    ]
  });
  //Jquery para ajax editar proveedor
  $("#editprov").submit(function(event) {
    event.preventDefault();
    $("#btneditprov").attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/EditProv", //Ruta metodo
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
        var result = datos;
        if (datos == true) {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditprov").attr("disabled", false);

          alertify.success(
            '<h6><i class="fas fa-check"></i> Proveedor editado correctamente</h6>'
          );
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btneditprov").attr("disabled", false);
          alertify.warning(result);
          console.log(result);
        }
      }
    });
  });
  //Jquery para ajax editar cuenta bancaria proveedor
  $("#editaccount").submit(function(event) {
    event.preventDefault();
    $("#btneditaccount").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/EditProv",
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
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
  //Jquery para ajax editar direcci��n
  $("#editaddress").submit(function(event) {
    event.preventDefault();
    $("#btneditaddress").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/EditProv",
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
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
    function() {
      alertify.error('<i class="fas fa-ban"></i> Cancelado');
    }
  );
}

function upload_adj() {
  var inputFileContrato = document.getElementById("adjunto_pdf");
  var file = inputFileContrato.files[0];
  var prov = document.getElementById('codprov').value;
  if ((typeof file === "object") && (file !== null)) {
      $("#load_doc_pdf").html('<div align="center"><div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div></div>');
      var data = new FormData();
      data.append('adjunto_pdf', file);
      data.append('id', prov);
      $.ajax({
          url: ruta + "/Facturacion/page/ProvData",
          type: "POST",
          data: data,
          contentType: false,
          cache: false,
          processData: false,
          success: function(data) {
            console.log(data);
            var result = data.split('-');
            if(result[0] == true){
              alertify.success('Adjunto guardado');
              var html = '<br><a target="__blank" href="'+ruta+'/Facturacion/files?pdf=Facturacion/pdf/'+result[1]+'" title="Documento"> <i class="fas fa-file-pdf"></i><h4>Doc Proveedor</h4></a>';
              $("#load_doc_pdf").html(html);
              $("#adj_doc")[0].reset();
            }else{
              alertify.warning(data);
              console.log(data);
            }
          }
      });
  }
}
