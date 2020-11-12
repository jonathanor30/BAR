

var ruta = document.getElementById("ruta").value;

var token = document.getElementById("token").value;
window.onload=Autoload();
function Autoload(){
    autovalidator();
    
  }

function autovalidator(){
    $.ajax({
        type: "POST",
        url: ruta + "/Login/autovalidacion",
        data: {token:token},
        beforeSend: function (objeto) {
        
        },
        success: function (datos) {
          var result = datos;
          if (datos == 1) {
            location.href =  ruta + "/Login/home";
          } else if(datos == false) {
            location.href =  ruta + "/Login/Expiracion";
          }
        },
      });
}
  
$("#guardar_new").submit(function(event) {
    $("#guardar_datos").attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: ruta + "/Login/updatePasswordWithCode",
      data: parametros,
      beforeSend: function(objeto) {
        //$("#resultados_ajax").html("Mensaje: Cargando...");
      },
      success: function(datos) {
        var result = datos;
        if (datos == true) {
          $("#guardar_datos").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i>Se ha cambiado la contraseña.</h6>'
          );
          setTimeout(function() {
            location.href =
              ruta + "/Login/home";
          }, 1000);
        } else {
          $("#guardar_datos").attr("disabled", false);
          alertify.warning(result);
        }
      }
    });
    event.preventDefault();
  });