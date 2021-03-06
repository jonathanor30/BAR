var ruta = document.getElementById("ruta").value;


window.onload = Autoload();

function Autoload() {
  ObtenerTipoDocumento();
}
//Mostrar nombre de producto de manera dinamica
document
  .getElementById("NombreProducto")
  .addEventListener("keyup", function (e) {
    document.getElementById("TituloProducto").innerText = "";
    document.getElementById("TituloProducto").innerText = this.value;
  });

//Editar Producto
document
  .getElementById("FormEditarProducto")
  .addEventListener("submit", function (e) {
    $("#BtnEditProducto").attr("disabled", true);
    //Prevenir
    e.preventDefault();
    var form = this; //Acá se obtienen todo los campos del formulario
    var parametros = $(form).serialize(); //Acá se serializa o se identifica varaibles y sus valores (Campos del formulario)
    var button = document.getElementById("BtnEditProducto");
    /**
     * Petición ajax al controlador y el método editar producto
     */
    $.ajax({
      type: "POST",
      url: ruta + "/Productos/editar",
      data: parametros,
      beforeSend: function (objeto) {
        //$("#resultados_ajax").html("Mensaje: Cargando...");
        button.innerHTML =
          '<span id="loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"> </span> Cargando... ';
      },
      success: function (datos) {
        var result = datos;
        if (datos == "true") {
          button.innerHTML = '<i class="fas fa-save"></i> Guardar ';
          $("#BtnEditProducto").attr("disabled", false);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Producto editado correctamente</h6>'
          );
        } else {
          $("#BtnEditProducto").attr("disabled", false);
          alertify.warning(result);
          console.log(result);
        }
      },
    });
  });

function ObtenerTipoDeProducto() {
  $.ajax({
    url: ruta + `/Productos/ObtenerTiposDeProductos`,
    type: "POST",
    contentType: false,
    cache: false,
    processData: false,
    success: function (resultado) {
      var x = document.getElementById("IdTipoProducto");
      //Acá estamos pintando los tipos de productos
      for (var r in resultado) {
        var option = document.createElement("option");
        option.text = resultado[r].Nombre;
        option.value = resultado[r].IdTipoProducto;
        x.add(option);
      }
      //Definimos el tipo de producto actual
      x.value = parseInt(document.getElementById("TipoProductoActual").value);
    },
  });
}

function ObtenerTipoDocumento() {
  $.ajax({
    url: ruta + `/Clientes/ObtenerTipoDocumento`,
    type: "POST",
    contentType: false,
    cache: false,
    processData: false,
    success: function (resultado) {
      var x = document.getElementById("IdTipoDocumento");
      //Acá estamos pintando los tipos de productos
      for (var r in resultado) {
        var option = document.createElement("option");
        option.text = resultado[r].Nombre_Documento;
        option.value = resultado[r].IdTipoDocumento;
        x.add(option);
      }
      //Definimos el tipo de producto actual
      x.value = parseInt(document.getElementById("TipoDocumentoActual").value);

    },
  });
}

function upload_image() {
  var inputFileImage = document.getElementById("ImagenProducto");
  var file = inputFileImage.files[0];
  if (typeof file === "object" && file !== null) {
    document.getElementById("LoadImgProducto").innerText = "Cargando...";
    var data = new FormData();
    data.append("ImagenProducto", file);
    $.ajax({
      url:
        ruta +
        `/Productos/ImagenProducto/${
          document.getElementById("IdProducto").value
        }`,
      type: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (resultado) {
        if (resultado != false) {
          var img = `
              <img style="width: -50%;" id="IMGProductoCargado" class="img-fluid img-producto" alt="Producto" src="${ruta}/Productos/files?img=${resultado}">
              `;
          document.getElementById("IMGProductoCargado").innerHTML = img;
        }
        document.getElementById("LoadImgProducto").innerText = "";
      },
    });
  }

 
}
