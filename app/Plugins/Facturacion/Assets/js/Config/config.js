var ruta = document.getElementById("ruta").value;
validateCompatibility();
function upload_file() {
  //Funcion encargada de enviar el archivo via AJAX
  $(".upload-msg").text(
    '<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>'
  );
  var inputFileImage = document.getElementById("fileToUpload");
  var inputnitemisor = document.getElementById("nitemisor").value;
  var ruta_method = document.getElementById("ruta").value;

  var file = inputFileImage.files[0];
  var data = new FormData();
  data.append("fileToUpload", file);
  data.append("nitemisor", inputnitemisor);
  if (inputnitemisor != "") {
    $.ajax({
      url: ruta_method + "/Facturacion/ajaxFe/certificateUpload", // Url to which the request is send
      type: "POST", // Type of request to be send, called as method
      data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        $(".upload-msg").html(data);
        document.getElementById("UploadCerticate").reset();
        setTimeout("recargarPagina()", 2000);
      }
    });
  } else {
    alertify.warning("Debe ingresar el NIT");
    document.getElementById("UploadCerticate").reset();
    $(".upload-msg").html("");
  }
}
/**
* validatePass, se encarga de validar campos de contraseñas
* para que coincida la confirmación
* @param {string} campo 
*/
function validatePass(campo) {
  var password = document.getElementById(campo).value;
  var repassword = document.getElementById(campo + "_confirm").value;
  if (password != repassword) {
    if (repassword == "") {
      document.getElementById(campo + "_confirm").setAttribute("class", "form-control  form-control-sm");

    } else {
      document.getElementById(campo + "_confirm").setAttribute("class", "form-control  form-control-sm border-danger");
      document.getElementById(campo).setAttribute("class", "form-control  form-control-sm");
    }

  } else {
    document.getElementById(campo).setAttribute("class", "form-control form-control-sm border-success");
    document.getElementById(campo + "_confirm").setAttribute("class", "form-control form-control-sm border-success");

  }
}

function validateCompatibility() {
  var ruta_method = document.getElementById("ruta").value;
  $.ajax({
    url: ruta_method + "/Facturacion/ajaxFe/validateCompatibility", // Url to which the request is send
    type: "POST", // Type of request to be send, called as method
    data: Array(), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false, // The content type used when sending data to the server.
    cache: false, // To unable request pages to be cached
    processData: false, // To send DOMDocument or non processed data file it is set to false
    success: function (data) {
      if (data == 'true') {
        $(".compatibility-msg").html('<div class="alert alert-primary" role="alert">Su sistema es compatible!</div>');
      } else {
        $(".compatibility-msg").html('Su sistema no es compatible revise:<br><code>' + JSON.stringify(data) + '</code>');
      }


    }
  });
}
function eliminaEspacio() {
  $("input").val(function (_, value) {
    return $.trim(value);
  });
} //end function eliminaEspacio
function recargarPagina() {
  location.reload(true);
}
function configEmail() {
  $('#btnEmail').attr("disabled", true);
  var server = $("#hostEmail").val();
  var usuario = $("#userEmail").val();
  var password = $("#passwordEmail").val();
  var repassword = $("#repassword").val();
  if (server != "" && usuario != "" && password != "" && repassword != "") {
    if (password == repassword) {
      $.ajax({
        type: "POST",
        url: ruta + "/Facturacion/EditFeProfile",
        data: 'hostEmail=' + server + '&userEmail=' + usuario + '&emailPass=' + password,
        beforeSend: function (objeto) {
          //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function (datos) {
          var result = datos;
          if (datos == 'true') {
            $("#CorreoModal").modal("hide");
            $('#btnEmail').attr("disabled", false);
            alertify.success('<h6><i class="fas fa-check"></i> Datos guardados correctamente</h6>');
          } else {
            $('#btnEmail').attr("disabled", false);
            alertify.warning(result);
            console.log(datos);
          }
        }
      });

    } else {
      $('#btnEmail').attr("disabled", false);
      alertify.warning('<h6> La contraseña no coincide</h6>');
    }
  } else {
    alertify.warning('<h6> Complete los campos</h6>');
    $('#btnEmail').attr("disabled", false);
  }
}