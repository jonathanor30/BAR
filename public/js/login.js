var ruta = document.getElementById("ruta").value;
var log = document.getElementById("start");
$(document).ready(function() {
  $(document).keypress(function(e) {
    if (e.keyCode == 13) {
      log.click();
    }
  });
});

/**
 * funcion para  validar el codifgo dinámico al ingresar al sistema
 */
function Search() {
  var user = document.getElementById("inputEmail").value;
  var pass = document.getElementById("inputPassword").value;
  var button = document.getElementById("start");
  var form = document.getElementById("login");
  button.setAttribute("disabled", true);
  $.ajax({
    url: ruta + "/Login/Autenticate",
    type: "POST",
    data: "user_name=" + user + "&user_password=" + pass,

    beforeSend: function(object) {
      button.innerHTML =
        '<span id="loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"> </span> Cargando... ';
    },
    success: function(datos) {
      var result = datos.split("-");
      if (result[0] == true && result[1] == "verification") {
        button.setAttribute("disabled", true);
        alertify
          .prompt(
            "Autenticación en 2 pasos",
            "Ingrese su clave dinámica.",
            "",
            function(evt, value) {
              if (value != "") {
                var password = value;
                document
                  .getElementsByClassName("ajs-input")[0]
                  .setAttribute("placeholder", "******");
                $.ajax({
                  type: "POST",
                  url: ruta + "/Login/Autenticate",
                  data: "pass=" + password + "&user=" + user,
                  beforeSend: function(objeto) {
                    //$("#resultados").html("Mensaje: Cargando...");
                  },
                  success: function(datos) {
                    var result = datos;
                    if (datos == true) {
                      alertify.success(
                        '<h6><i class="fa fa-check"></i> Clave dinámica correcta. Bienvenido...</h6>'
                      );
                      button.removeAttribute("disabled", false);
                      form.submit();
                    } else {
                      alertify.warning(
                        "<i class='fa fa-ban'></i> " + datos + " "
                      );
                      console.log(datos);
                    }
                  }
                });
              }
            },

            function() {
              button.innerHTML = "Login";
              alertify.error('<i class="fas fa-ban"></i> Cancelado');
              button.removeAttribute("disabled", false);
            }
          )
          .set({
            type: "password",
            onclose: function() {
              this.set({ type: "text", value: "" });
            }
          });
      } else if (result[0] == true && result[1] == "no_verification") {
        alertify.success("Bienvenido...");
        form.submit();
      } else {
        alertify.error('<i class="fas fa-ban"></i> ' + datos);
        button.innerHTML =
          '<span id="loader" class="glyphicon glyphicon-remove" role="status" aria-hidden="true"> </span> Login';
        button.removeAttribute("disabled");
        console.log(datos);
      }
    }
  });
}
