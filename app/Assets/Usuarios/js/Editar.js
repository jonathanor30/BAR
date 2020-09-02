var ruta = $("#ruta").val();
var id_usuario = $("#id").val();
$("#guardar_datos").click(function() {
  if (validar_clave()) {
    $("#guardar_datos").attr("disabled", true);
    var button = document.getElementById("guardar_datos");
    var form = document.getElementById("edit-form");
    var parametros = $(form).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/usuarios/editar/" + id_usuario,
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html("Mensaje: Cargando...");
        button.innerHTML =
          '<span id="loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"> </span> Cargando... ';
      },
      success: function(datos) {
        var result = datos;
        if (datos == "true") {
          button.innerHTML = '<i class="fas fa-save"></i> Guardar ';
          $("#guardar_datos").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Usuario editado correctamente</h6>'
          );
        } else {
          $("#guardar_datos").attr("disabled", false);
          alertify.warning(result);
          console.log(result);
        }
      }
    });
    //event.preventDefault();
  }
});
document.addEventListener("keydown", function(e) {
  var tecla = this ? e.keyCode : e.which;
  if (e.ctrlKey && e.altKey) {
    switch (tecla) {
      case 66:
        //italic
        Developer();
        return false;
        break;
    }
  }
});
//No te pases de listo, validamo tambien desde el backend
function validar_clave() {
  var error = [];
  var caract_invalido = " ";
  var caract_longitud = 6;
  var cla1 = $("#edit-form #password").val();
  var cla2 = $("#edit-form #repassword").val();
  if (cla1 == "" || cla2 == "") {
    alertify.warning(
      "Debes introducir la contraseña en los dos campos para poder editar la información."
    );
    //document.registro
    error.push(1);
  }
  if (cla1.length < caract_longitud) {
    alertify.warning(
      "Tu clave debe constar de minimo " + caract_longitud + " carácteres."
    );
    //document.registro
    error.push(1);
  }
  if (cla1.indexOf(caract_invalido) > -1) {
    alertify.warning("Las contraseñas no pueden contener espacios");
    //document.registro
    error.push(1);
  } else {
    if (cla1 != cla2) {
      alertify.warning("Las contraseñas introducidas no coinciden");
      //document.registro
      error.push(1);
    }
  }
  if (error.length >= 1) {
    return false;
  } else {
    return true;
  }
}

function asignarModulos() {
  var select = document.getElementById("modulos").value;
  if (select != "") {
    agregarModulo(select);
  }
}

function agregarModulo(modulo) {
  $.ajax({
    type: "POST",
    url: ruta + "/usuarios/asignarModulos/" + id_usuario,
    data: "id=" + modulo,
    beforeSend: function(objeto) {
      //$("#resultados_ajax").html("Mensaje: Cargando...");
    },
    success: function(datos) {
      var result = datos;
      switch (result) {
        case "true":
          var table = document.getElementById("TableBody");
          var row = table.insertRow(0);
          row.setAttribute("id", modulo, 0);
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          cell1.innerHTML =
            "<input class='form-control-plaintext input-sm numero_item' type='hidden' name='nombre_plugin[]' readonly='' value='" +
            modulo +
            "' required=''><span class='badge badge-pill badge-info'>" +
            modulo +
            "</span>";
          cell2.innerHTML =
            "<button class='btn btn-sm badge badge-danger' type='button' title='Inhabilitar " +
            modulo +
            "' onclick='deleteRow(this, " +
            '"' +
            modulo +
            '"' +
            ");'><i class='fas fa-trash'></i></button>";
          alertify.success(
            '<i class="fas fa-check"></i> Módulo añadido correctamente'
          );
          break;
        case "false":
          alertify.warning("No puede aisgnar el mismo módulo dos veces.");
          console.log(result);
          break;
      }
    }
  });
}

function deleteRow(r, modulo) {
  $.ajax({
    type: "POST",
    url: ruta + "/usuarios/quitarModulos/" + id_usuario,
    data: "id=" + modulo,
    beforeSend: function(objeto) {
      //$("#resultados_ajax").html("Mensaje: Cargando...");
    },
    success: function(datos) {
      var result = datos;
      switch (result) {
        case "true":
          var i = r.parentNode.parentNode;
          document.getElementById("TableBody").deleteRow(i);
          alertify.success("Modulo retirado");
          break;
        case "false":
          alertify.warning("Hubo un problema al deshabilitar el Módulo.");
          console.log(result);
          break;
      }
    }
  });
}

function validityPassword() {
  var confirm = document.getElementById("repassword").value;
  var pass = document.getElementById("password").value;
  if (pass != null && pass != "" && confirm != null && confirm != "") {
    if (confirm == pass) {
      $("#password").attr(
        "class",
        "form-control form-control-sm border-success"
      );
      $("#repassword").attr(
        "class",
        "form-control form-control-sm border-success"
      );
    } else {
      $("#password").attr(
        "class",
        "form-control form-control-sm border-danger"
      );
      $("#repassword").attr(
        "class",
        "form-control form-control-sm border-danger"
      );
    }
  } else {
    $("#password").attr("class", "form-control form-control-sm");
    $("#repassword").attr("class", "form-control form-control-sm");
  }
}

function Validity() {
  var telegram_id = document.getElementById("telegram_id").value;
  var email = document.getElementById("user_email").value;
  var tel_2_step = document.getElementById("2-step");
  var em_2_step = document.getElementById("2-step-email");

  if (telegram_id == null || telegram_id == "") {
    document.getElementById("telegram_id").focus();
    tel_2_step.checked = false;
  } else if (email == null || email == "") {
    document.getElementById("user_email").focus();
    em_2_step.checked = false;
  }
}
function Developer() {
  var x = document.getElementById("user_type");
  var option = document.createElement("option");
  option.text = "Developer";
  option.value = 99;
  x.add(option);
  alertify.success("<i class='fas fa-check'></i> Categoría desbloqueada");
}
