var ruta = document.getElementById("ruta").value;
var contador = Array();

$(document).ready(function () {
  $("#Resolutions").DataTable({
    processing: true,
    responsive: true,
    order: [[0, "desc"]],
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    language: { url: ruta + "/public/js/Spanish.json" },
    ajax: {
      url: ruta + "/Facturacion/dataTableResoluciones",
      type: "POST",
      data: function (d) {
        d.status = $("#filter").val();
        d.year = $("#res-year").val();
      },
      /*complete: function (data) {
        console.log(data.responseText);
      },*/
    },
    columns: [
      {
        data: "number",
      },
      {
        data: "prefix",
      },
      {
        data: "resolution",
      },
      {
        data: "from",
      },
      {
        data: "to",
      },
      {
        data: "date_from",
      },
      {
        data: "date_to",
      },
      {
        data: "status",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {

          switch (parseInt(oData.status)) {
            case 1:
              $(nTd).html("Activo").addClass("text-success");
              break;
            case 2:
              $(nTd).html("Inctivo").addClass("text-warning")
              break;
            default:
              $(nTd).html("No disponible").addClass("text-danger")
              break;
          }
        },
      },
      {
        data: "id",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          nTd.classList.add("text-center");
          $(nTd).html(
            `
             <div class='btn-group'>
             <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#edit-resolution" onclick="LoadResolution(${oData.id})">
             <svg width='1.2em' height='1.2em' viewBox='0 0 16 16' class='bi bi-pencil-square' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/><path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/></svg>
             </button>
             <button type="button" class="btn btn-sm btn-outline-secondary" onclick='DeleteResolution(${oData.id});'>
             <svg width='1.2em' height='1.2em' viewBox='0 0 16 16' class='bi bi-trash-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/></svg>
             </button>
             </div>
             `
          );
        },
      },
    ],
    createdRow: function (row, data, dataIndex) {
      $(row).addClass("text-center");
    },
  });
  $("#configuracionesFE").submit(function (event) {
    $("#save-config-fe").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Facturacion/ajaxFE/configFE",
      data: parametros,
      beforeSend: function (objeto) {
        //Mienstras tanto
      },
      success: function (datos) {
        if (datos == true) {
          var button = '<button type="button" onclick="enabledConfig();" id="enableConfig" class="btn btn-sm btn-secondary">Editar <i class="fas fa-edit"></i></button>';
          document.getElementById("clave_certificado").setAttribute("class", "form-control  form-control-sm");
          document.getElementById("clave_certificado_confirm").setAttribute("class", "form-control  form-control-sm");
          document.getElementById("myFieldset").disabled = true;
          document.getElementById("resultEdit").innerHTML = button;

          alertify.success(
            '<h6><i class="fa fa-check"></i> Datos guardados correctamente.</h6>'
          );
        } else {
          document.getElementById("save-config-fe").disabled = false;
          alertify.warning("Hubo un problema al guardar");
          console.log(datos);
        }
      }
    });
    event.preventDefault();
  });
});

function dropprov() {
  closeclient();
  $("#dropprov").attr("class", "dropdown-menu show");
}
function closeprov() {
  $("#dropprov").attr("class", "dropdown-menu");
}
function dropclient() {
  closeprov();
  $("#dropclient").attr("class", "dropdown-menu show");
}
function closeclient() {
  $("#dropclient").attr("class", "dropdown-menu");
}
function enabledConfig() {
  event.preventDefault();
  var button =
    '<button type="button" onclick="enabledConfig();" id="enableConfig" class="btn btn-sm btn-secondary">Editar <i class="fas fa-edit"></i></button> <button type="submit" class="btn btn-sm btn-primary" id="save-config-fe">Guardar <i class="fas fa-save"></i></button>';
  var pre = document.createElement("H5");
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  //pre.style.whiteSpace = "pre-wrap";
  pre.style.textAlign = "center";
  pre.appendChild(
    document.createTextNode("¿Realmente desea editar la configuración?")
  );
  alertify.confirm(
    pre,
    function () {
      alertify.prompt(
        "Código de seguridad",
        "Ingrese el código previamente asignado.",
        "",
        function (evt, value) {
          if (value != "") {
            var password = value;
            $.ajax({
              type: "POST",
              url: ruta + "/Facturacion/dinamicPass",
              data: "password=" + password,
              beforeSend: function (objeto) {
                //$("#resultados").html("Mensaje: Cargando...");
              },
              success: function (datos) {
                var result = datos;
                if (datos == true) {
                  document.getElementById("myFieldset").disabled = false;
                  document.getElementById("resultEdit").innerHTML = button;
                  document.getElementById("enableConfig").disabled = true;
                  alertify.success(
                    '<h6><i class="fa fa-check"></i> Permiso definido.</h6>'
                  );
                } else {
                  alertify.warning("<i class='fa fa-ban'></i> Permiso denegado");
                }
              }
            });
          }
        },

        function () {
          alertify.error('<i class="fas fa-ban"></i> Cancelado');
        }
      ).set(
        {
          type: 'password',
          onclose: function () {
            this.set({ type: 'text', value: '' });
          }
        });
    },
    function () {
      alertify.error('<i class="fas fa-ban"></i> Cancelado');
    }
  );
}
function updateCertifique() {
  event.preventDefault();
  var button =
    '<button type="button" onclick="enabledConfig();" id="enableConfig" class="btn btn-sm btn-secondary">Editar <i class="fas fa-edit"></i></button> <button type="submit" class="btn btn-sm btn-primary" id="save-config-fe">Guardar <i class="fas fa-save"></i></button>';
  var pre = document.createElement("H5");
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  //pre.style.whiteSpace = "pre-wrap";
  pre.style.textAlign = "center";
  pre.appendChild(
    document.createTextNode("¿Realmente desea actualizar el certificado de firma digital?")
  );
  alertify.confirm(
    pre,
    function () {
      alertify.prompt(
        "Código de seguridad",
        "Ingrese el código previamente asignado.",
        "",
        function (evt, value) {
          if (value != "") {
            var password = value;
            $.ajax({
              type: "POST",
              url: ruta + "/Facturacion/dinamicPass",
              data: "password=" + password,
              beforeSend: function (objeto) {
                //$("#resultados").html("Mensaje: Cargando...");
              },
              success: function (datos) {
                var result = datos;
                if (datos == true) {
                  document.getElementById("certificadoConfig").innerHTML = '<form id="UploadCerticate"> <div class="form-group"> <label for="exampleInputEmail1">NIT:</label> <input type="text" class="form-control form-control-sm" id="nitemisor" name="nitemisor" placeholder="Ingrese el NIT" onchange="eliminaEspacio();"> <small class="form-text text-danger">Por favor ingrese el NIT sin digito de verificación</small> </div><div class="form-group"> <label>Archivo:</label> <div class="custom-file" id="customFile"> <input type="file" accept=".p12 , .pfx" class="custom-file-input form-control form-control-sm" id="fileToUpload" name="fileToUpload" onchange="upload_file();" aria-describedby="fileHelp"> <label class="custom-file-label" for="exampleInputFile"> <i class="fas fa-upload"></i> Seleccionar Archivo </label> </div><small class="form-text text-danger">La extensión de archivo debe ser <b>.pfx</b> o <b>.p12</b></small> </div></form>';
                  alertify.success(
                    '<h6><i class="fa fa-check"></i> Permiso definido.</h6>'
                  );
                } else {
                  alertify.warning("<i class='fa fa-ban'></i>" + datos + " ");
                  console.log(datos);
                }
              }
            });
          }
        },

        function () {
          alertify.error('<i class="fas fa-ban"></i> Cancelado');
        }
      ).set(
        {
          type: 'password',
          onclose: function () {
            this.set({ type: 'text', value: '' });
          }
        });
    },
    function () {
      alertify.error('<i class="fas fa-ban"></i> Cancelado');
    }
  );
}
function enablesystem(e) {

  if (e.checked == true) {
    var status = 1;
  } else {
    var status = 2;
  }
  $.ajax({
    url: ruta + "/Facturacion/EnableSystem",
    type: "POST",
    data: "status=" + status,
    success: function (data) {
      if (data == true) {
        alertify.success("<i class='fas fac-check'></i> Sistema actualizado");
      } else {
        alertify.warning("Error");
      }
    }
  })
}
function reloadTable(id, filter) {
  $("#" + id).DataTable().ajax.reload();
}
//Tab resoluiones
function DeleteResolution(id) {
  //console.log(contador);
  if (contador.length == 0) {
    contador.push("delete");
    var parametros = {
      id: id,
      table: "resolutions",
      key: "id"
    };
    var q = id;
    var pre = document.createElement("H5");
    //custom style.
    pre.style.maxHeight = "400px";
    pre.style.margin = "0";
    pre.style.padding = "24px";
    //pre.style.whiteSpace = "pre-wrap";
    pre.style.textAlign = "center";
    pre.appendChild(
      document.createTextNode("Realmente desea eliminar esta resolución?")
    );
    alertify.confirm(
      pre,
      function () {
        $.ajax({
          type: "POST",
          url: ruta + "/Facturacion/DeleteResolution",
          data: parametros,
          q: q,
          beforeSend: function (objeto) {
            //$("#resultados").html("Mensaje: Cargando...");
          },
          success: function (datos) {
            var result = datos;

            if (datos == true) {
              $("#Resolutions")
                .DataTable()
                .ajax.reload();
              alertify.success(
                '<h6><i class="fas fa-check"></i>Resolución eliminada</h6>'
              );
              contador = Array();
            } else {
              console.log(result);
              $("#Resolutions")
                .DataTable()
                .ajax.reload();
              alertify.warning(
                result,
                '<i class="fas fa-ban"></i> Error al intentar eliminar la Resolución.'
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
function LoadResolution(id) {
  var inp = document.createElement("input");
  inp.name = "id";
  inp.id = "id"
  inp.setAttribute("hidden", true);
  inp.value = id;
  document.getElementById("edit-resolution-form").appendChild(inp);
  $.ajax({
    type: "POST",
    url: ruta + "/Facturacion/GetResolution",
    data: "id=" + id,
    beforeSend: function (objeto) {
      //$("#resultados").html("Mensaje: Cargando...");
    },
    success: function (data) {
      if (IsJson(data)) {
        var datos = JSON.parse(data)
        DrawResolution(datos);
      } else {
        console.log(data);
      }
    }
  });
}
function DelId() {
  document.getElementById("edit-resolution-form").reset();
  if (document.getElementById("edit-resolution").querySelector("#id") != null) {
    document.getElementById("edit-resolution").querySelector("#id").remove();
  }
}
function DrawResolution(data) {
  for (var k in data) {
    if (document.getElementById(k) != null) {
      document.getElementById(k).value = data[k];
    }
  }
}
function IsJson(str) {
  try {
    JSON.parse(str);
  } catch (error) {
    return false;
  }
  return true;
}



  function isJSON(str) {
    try {
      JSON.parse(str);
    } catch (error) {
      return false;
    }
    return true;
  }