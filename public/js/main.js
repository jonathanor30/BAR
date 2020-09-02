//Main javascript GTEP
$(document).ready(function() {
  modals();
});

function VentanaCentrada(
  theURL,
  winName,
  features,
  myWidth,
  myHeight,
  isCenter
) {
  //v3.0
  if (window.screen)
    if (isCenter)
      if (isCenter == "true") {
        var myLeft = (screen.width - myWidth) / 2;
        var myTop = (screen.height - myHeight) / 2;
        features += features != "" ? "," : "";
        features += ",left=" + myLeft + ",top=" + myTop;
      }
  window.open(
    theURL,
    winName,
    features +
      (features != "" ? "," : "") +
      "width=" +
      myWidth +
      ",height=" +
      myHeight
  );
}

function terminal(comando, password) {
  var ruta = $("#ruta").val();
  if (comando != "" && password != "") {
    $.ajax({
      type: "POST",
      url: ruta + "/empresa/comandos",
      data: {
        comando: comando,
        password: password
      },
      beforeSend: function(objeto) {
        console.log("Ejecutando...");
      },
      success: function(datos) {
        alertify.warning(datos);
      }
    });
  } else {
    console.log("error");
  }
}

function mode() {
  var ruta = $("#ruta").val();
  var checkBox = document.getElementById("checkbox");
  var status = $("#checkbox").val();

  if (checkBox.checked == true) {
    var modeView = "1";
    $("#linkestilo1").attr("href", ruta + "/public/css/styles_dark.css");
    $("#linkestilo2").attr("href", ruta + "/public/bootstrap/css/dark.min.css");
    $("body")
      .hide()
      .fadeIn("slow");
  } else if (checkBox.checked != true) {
    var modeView = "0";
    $("#linkestilo1").attr("href", ruta + "/public/css/styles.css");
    $("#linkestilo2").attr(
      "href",
      ruta + "/public/bootstrap/css/bootstrap.min.css"
    );
    $("body")
      .hide()
      .fadeIn("slow");
  }
  $.ajax({
    type: "POST",
    url: ruta + "/empresa/modeView",
    data: "id=" + modeView,
    beforeSend: function(objeto) {},
    success: function(datos) {
      if (datos == "true") {
        alertify.success("Modo día");
      } else {
        alertify.success(datos);
      }
    }
  });
}
function modals() {
  $(".modal").appendTo("body");
}

$(function() {
  if ($("#myPlugin").val() != null) {
    $("#myPlugin").autocomplete({
      source: $("#ruta").val() + "/Plugins/listadoPlugin",
      minLength: 2,
      select: function(event, ui) {
        document.getElementById("myPlugin").value = ui.item.value;
      }
    });
  }
});
function redireccionar(id) {
  location.href = $("#ruta").val() + "/" + id;
}
function buscarModulo() {
  if (document.getElementById("myPlugin").value != "") {
    var modulo = document.getElementById("myPlugin").value;
    redireccionar(modulo);
  } else {
    alertify.warning("No ha ingresado ningún termino de busqueda");
  }
}
