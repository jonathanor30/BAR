
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
          } else {
           
          
          }
        },
      });
}
