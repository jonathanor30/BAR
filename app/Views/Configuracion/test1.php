<?php require RUTA_APP . '/Views/inc/header.php'; ?>
<div class="container">
  <div class="card">
    <div class="card-header">
      <h4 id="TituloProducto"><?php echo $datos['home']->IdHome ?></h4>
    </div>
    <div class="card-body">
      <div class="row" title="<?php echo $datos['home']->IdHome ?> $<?php echo $datos['home']->IdHome ?>">
        <div class="col-sm-auto">
          <?php if ($datos['home']->ImagenMision != NULL || $datos['home']->ImagenMision != '') : ?>
            <div id="IMGProductoCargado">
              <img style="width: -50%;" class="img-fluid img-producto" src="<?php echo RUTA_URL ?>/Configuracion/files?img=<?php echo $datos['home']->ImagenMision; ?>" alt="Configuracion">
            </div>
          <?php else : ?>
            <h5>El producto no tiene una imagen cargada</h5>
          <?php endif; ?>
          <br>
          <div class="input-group mb-3">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="ImagenMision" name="ImagenMision" onchange="upload_image();" accept=".jpg,.png,.jpeg">
              <label class="custom-file-label" for="ImagenMision" aria-describedby="inputGroupFileAddon02">Seleccione una imagen <i class="fas fa-image"></i></label>
            </div>
            <div id="LoadImgProducto"></div>
          </div>
          <br><br>
        </div>
      </div>


      <input type="hidden" id="IdHome" name="IdHome" value="<?php echo $datos['home']->IdHome ?>">




    </div>

  </div>

</div>
<script>
  var ruta = document.getElementById("ruta").value;


  function upload_image() {
    var inputFileImage = document.getElementById("ImagenMision");
    var file = inputFileImage.files[0];
    if (typeof file === "object" && file !== null) {
      document.getElementById("LoadImgProducto").innerText = "Cargando...";


      var data = new FormData();
      data.append("ImagenMision", file);
      $.ajax({
        url: ruta +
          `/Configuracion/ImagenMision/${
          document.getElementById("IdHome").value
        }`,
        type: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function(resultado) {
          if (resultado != false) {
            var img = `
              <img style="width: -50%;" id="IMGProductoCargado" class="img-fluid img-producto" alt="Configuracion" src="${ruta}/Configuracion/files?img=${resultado}">
              `;
            document.getElementById("IMGProductoCargado").innerHTML = img;
          }
          document.getElementById("LoadImgProducto").innerText = "";


          location.reload(true);
        },

      });
    }
  }
</script>

<?php require RUTA_APP . '/Views/inc/footer.php'; ?>