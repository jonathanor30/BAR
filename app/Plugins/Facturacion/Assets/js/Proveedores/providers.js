var ruta = document.getElementById("ruta").value;

$(document).ready(function() {
  if($('#new').val() != ""){
      $('#addprov').modal('show');
      document.getElementById("nombre").value = document.getElementById("propietario").value;
      document.getElementById("cifnif").value = document.getElementById("nit_cc").value;

  }
  //datatable proveedores
  table = $("#proveedores").DataTable({
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
      url: ruta + "/Facturacion/page/TableviewsProveedor",
      type: "POST",
      data: function(d) {
        d.id = $("#festado").val(); //importante
      }
    },

    columns: [
      { data: "codproveedor" },
      {
        data: "nombre",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.nombre != "" || oData.nombre != null) {
            $(nTd).html(
              '<a href="' +
                ruta +
                "/Facturacion/page/Provdetail/" +
                oData.codproveedor +
                '" title="Ir a info detallada" data-id="' +
                oData.codproveedor +
                '" >' +
                oData.nombre +
                "</a>"
            );
          }
        }
      },
      { data: "cifnif" },
      { data: "email" },
      {
        data: "telefono1",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          if (oData.telefono1 != null && oData.telefono1 != "") {
            if (oData.telefono1.length == 10) {
              $(nTd).html(
                "<a href='tel:" +
                  oData.telefono1 +
                  "'>" +
                  oData.telefono1 +
                  "</a><br>"
              );
            }
          } else if (oData.telefono1 != null && oData.telefono1 != "") {
            if (oData.telefono1.length == 7) {
              $(nTd).html(
                "<a href='tel:" +
                  oData.telefono1 +
                  "'>" +
                  oData.telefono1 +
                  "</a>"
              );
            }
          } else {
            $(nTd).html("N/A");
          }
        }
      },
      { data: "observaciones" },
      {
        data: "estado",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          switch (parseInt(oData.estado)) {
            case 0:
              $(nTd).html(
                '<h6><span onclick="Active(' +
                  oData.codproveedor +
                  "," +
                  oData.estado +
                  ')" class="badge badge-pill badge-danger">Inactivo</span></h6>'
              );
              break;
            case 1:
              $(nTd).html(
                '<h6><span onclick="Active(' +
                  oData.codproveedor +
                  "," +
                  oData.estado +
                  ')"  class="badge badge-pill badge-success">Activo</span></h6>'
              );
              break;
          }
        }
      },
      {
        data: "codproveedor",
        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            '<div class="btn-group"><a href="' +
              ruta +
              "/Facturacion/page/Provdetail/" +
              oData.codproveedor +
              '" class="btn btn-sm btn-outline-secondary"  data-id="' +
              oData.codproveedor +
              '" ><i class="fas fa-edit"></i></a><a onclick="eliminar(' +
              oData.codproveedor +
              ')" class="btn btn-sm btn-outline-secondary"  data-id="' +
              oData.codproveedor +
              '" ><i class="fas fa-trash-alt"></i></a></div>'
          );
        }
      }
    ]
  });
  //Jquery para añadir nuevo proveedor
  $("#newprov").submit(function(event) {
    event.preventDefault();
    $("#btnaddprov").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/AddProv",
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
        var result = datos.split(",");
        var state = result[0];
        var id = result[1];
        
        if (state == true) {
          $("#addprov").modal("hide");
          $("#newprov")[0].reset();
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddprov").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Proveedor agregado correctamente</h6>'
          );
          $("#proveedores")
            .DataTable()
            .ajax.reload();
          setTimeout(function() {
            window.top.location = ruta + "/Facturacion/page/Provdetail/" + id;
          }, 2000);
        } else {
          //$("#resultados_ajax").html('<span></span>');
          $("#btnaddprov").attr("disabled", false);
          alertify.warning(datos);
          console.log(datos);
          $("#proveedores")
            .DataTable()
            .ajax.reload();
        }
      }
    });
  });

  
  $("#frmimp").submit(function(event) {
    event.preventDefault();
    var parametros = new FormData(document.getElementById("frmimp"));

    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/page/ImportarProveedor",
      data: parametros,
      processData: false,
      contentType: false,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html('<i class="fas fa-spinner fa-spin"></i>');
      },
      success: function(datos) {
        var result = datos;
        if (datos == true) {
          $("#addfile").modal("hide");
          $("#frmimp")[0].reset();
          //$("#resultados_ajax").html('<span></span>');

          alertify.success(
            '<h6><i class="fas fa-check"></i> Archivo importado correctamente</h6>'
          );
          $("#proveedores")
            .DataTable()
            .ajax.reload();
        } else {
          //$("#resultados_ajax").html('<span></span>');
          alertify.warning(result);
          console.log(result);
          $("#proveedores")
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
    "id": idProv,
    "table" : "proveedores",
    "key" : "codproveedor"
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
    document.createTextNode("Realmente desea eliminar este proveedor?, también se eliminarán sus archivos adjuntos.")
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
            $("#proveedores")
              .DataTable()
              .ajax.reload();
            alertify.success(
              '<h6><i class="fas fa-check"></i>Proveedor eliminado</h6>'
            );
          } else {
            console.log(result);
            $("#proveedores")
              .DataTable()
              .ajax.reload();
            alertify.warning(
              result,
              '<i class="fas fa-ban"></i> Error al intentar eliminar el proveedor.'
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

function Active(id, estado) {
  if (estado == 0) {
    var q = id;
    var pre = document.createElement("H5");
    //custom style.
    pre.style.maxHeight = "400px";
    pre.style.margin = "0";
    pre.style.padding = "24px";
    //pre.style.whiteSpace = "pre-wrap";
    pre.style.textAlign = "center";
    pre.appendChild(document.createTextNode("Este proveedor está activo?"));
    alertify.confirm(
      pre,
      function() {
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/page/State",
          data: "idA=" + id,
          q: q,
          beforeSend: function(objeto) {
            //$("#resultados").html("Mensaje: Cargando...");
          },
          success: function(datos) {
            var result = datos;

            if (datos == true) {
              $("#proveedores")
                .DataTable()
                .ajax.reload();
              alertify.success(
                '<h6><i class="fas fa-check"></i> Proveedor Activo</h6>'
              );
            } else {
              console.log(result);
              $("#proveedores")
                .DataTable()
                .ajax.reload();
              alertify.warning(
                '<i class="fas fa-ban"></i> Error al intentar habilitar el Proveedor.'
              );
            }
          }
        });
      },
      function() {
        alertify.error('<i class="fas fa-ban"></i> Proceso Cancelado');
      }
    );
  } else {
    var q = id;
    var pre = document.createElement("H5");
    //custom style.
    pre.style.maxHeight = "400px";
    pre.style.margin = "0";
    pre.style.padding = "24px";
    //pre.style.whiteSpace = "pre-wrap";
    pre.style.textAlign = "center";
    pre.appendChild(document.createTextNode("Este proveedor está inactivo?"));
    alertify.confirm(
      pre,
      function() {
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/page/State",
          data: "idI=" + id,
          q: q,
          beforeSend: function(objeto) {
            //$("#resultados").html("Mensaje: Cargando...");
          },
          success: function(datos) {
            var result = datos;

            if (datos == true) {
              $("#proveedores")
                .DataTable()
                .ajax.reload();
              alertify.success(
                '<h6><i class="fas fa-check"></i> Proveedor Inactivo</h6>'
              );
            } else {
              console.log(result);
              $("#proveedores")
                .DataTable()
                .ajax.reload();
              alertify.warning(
                '<i class="fas fa-ban"></i> Error al intentar inhabilitar el Proveedor.'
              );
            }
          }
        });
      },
      function() {
        alertify.error('<i class="fas fa-ban"></i> Proceso Cancelado');
      }
    );
  }
}


function cambiar() {
  var filter = document.getElementById("festado").value;

  switch (parseInt(filter)) {
    case 0:
      $("#festado").attr("class", "btn btn-danger btn-sm");
      break;
    case 1:
      $("#festado").attr("class", "btn btn-success btn-sm");
      break;
    default:
      $("#festado").attr("class", "btn btn-secondary btn-sm");
      break;
  }
  $("#proveedores")
    .DataTable()
    .ajax.reload();
}
