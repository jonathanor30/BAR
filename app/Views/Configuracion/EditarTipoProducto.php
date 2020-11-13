<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <!--<h4 id="TituloProducto"><?php echo $datos['home']->NombreProducto ?></h4>-->
        </div>
        <div class="card-body">
            
            <form id="FormEditarProducto" action="" method="POST">
                <div class="row">
                    <div class="col-sm">
                        <label>Nombre</label>
                        <input class="form-control form-control-sm" type="text" name="Nombre" id="Nombre" value="<?php echo $datos['home']->Nombre ?>" />
                        <input type="hidden" id="IdTipoProducto" name="IdTipoProducto" value="<?php echo $datos['home']->IdTipoProducto ?>">
                    </div>
                    
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm">
                    <button type="submit" id="BtnEditProducto" class="btn btn-sm btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<script>

var ruta = document.getElementById("ruta").value;

// se ejecuta automaticamente la funcion de obtener tipo producto


//Mostrar nombre de producto de manera dinamica


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
      url: ruta + "/Configuracion/EditarTipoProducto",
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





</script>
