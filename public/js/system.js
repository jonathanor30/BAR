parametros = "";
function systemGTEP(){
    $.ajax({
      type: "POST",
      url: document.getElementById("ruta").value+"/empresa/infoSystem",
      data: parametros,
       beforeSend: function(objeto){
        //$("#resulSystem").html("Mensaje: Cargando...");
        },
      success: function(datos){
        var sumary = datos.split('-');
          $("#database").html(sumary[0]);
          $("#harddisk").html(sumary[1]);
          $("#memory").html(sumary[2]);
            
      }
   });
}
var formatNumber = {
  separador: ".", // separador para los miles
  sepDecimal: ",", // separador para los decimales
  formatear: function(num) {
    num += "";
    var splitStr = num.split(".");
    var splitLeft = splitStr[0];
    var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : "";
    var regx = /(\d+)(\d{3})/;
    while (regx.test(splitLeft)) {
      splitLeft = splitLeft.replace(regx, "$1" + this.separador + "$2");
    }
    return this.simbol + splitLeft + splitRight;
  },
  new: function(num, simbol) {
    this.simbol = simbol || "";
    return this.formatear(num);
  }
};

systemGTEP();