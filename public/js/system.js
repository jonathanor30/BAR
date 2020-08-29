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

systemGTEP();