<?php require(RUTA_APP . '/Views/inc/header.php'); ?>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Crear información</a>
  </li>

</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
    <!--editar -->

    <body><br><br>
      <div>
        <form method="POST" action="" id="form-info" autocomplete="off">
          <div class="container" class="col-md-12">
            <div class="row">
              <div class="col-md-3 well">
                <label for="">
                  <h4><b>¿Quienes Somos?</b></h4>
                </label>
                <textarea style=" max-height: 100px;" name="Quienes_Somos" id="Quienes_Somos" value="" rows="10" cols="30"></textarea>
                <br><br>
              </div>
              <div class="col-md-3 well">
                <label for="">
                  <h4><b>Misión</b></h4>
                </label>
                <textarea style=" max-height: 100px;" name="Mision" id="Mision" value="" rows="10" cols="30"></textarea>
              </div>
              <div class="col-md-3 well">
                <label for="">
                  <h4><b>Visión</b></h4>
                </label>
                <textarea style=" max-height: 100px;" name="Vision" id="Vision" value="" rows="10" cols="30"></textarea>
              </div>
            </div>
            <div class="row">

              <div class="col-md-4 well">
                <label for="">
                  <h4><b>Imagen Quienes Somos</b></h4>
                </label>
                <?php if ($datos['home']->ImagenQuienes != NULL || $datos['home']->ImagenQuienes != '') : ?>
                  <div id="IMGProductoCargadoo">
                    <img style="width: -50%;" class="img-fluid img-producto" src="<?php echo RUTA_URL ?>/Configuracion/files?img=<?php echo $datos['home']->ImagenQuienes; ?>" alt="Configuracion">
                  </div>
                <?php else : ?>
                  <h5>El producto no tiene una imagen cargada</h5>
                <?php endif; ?>
                <br>
                <div class="input-group mb-4">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="ImagenQuienes" name="ImagenQuienes" onchange="upload_image1();" accept=".jpg,.png,.jpeg">
                    <label style="max-width: 80%;" class="custom-file-label" for="ImagenQuienes" aria-describedby="inputGroupFileAddon02"> Seleccione una imagen <i class="fas fa-image"></i></label>
                  </div>
                  <div id="LoadImgProductoo"></div>
                </div>
                <br><br>



                <input type="hidden" id="IdHome" name="IdHome" value="<?php echo $datos['home']->IdHome ?>">
              </div>

              <div class="col-md-4 well">
                <label for="">
                  <h4><b>Imagen Misión</b></h4>
                </label>
                <?php if ($datos['home']->ImagenMision != NULL || $datos['home']->ImagenMision != '') : ?>
                  <div id="IMGProductoCargado">
                    <img style="width: -50% ;" class="img-fluid img-producto" src="<?php echo RUTA_URL ?>/Configuracion/files?img=<?php echo $datos['home']->ImagenMision; ?>" alt="Configuracion">
                  </div>
                <?php else : ?>
                  <h5>El producto no tiene una imagen cargada</h5>
                <?php endif; ?>
                <br>
                <div class="input-group mb-4">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="ImagenMision" name="ImagenMision" onchange="upload_image();" accept=".jpg,.png,.jpeg">
                    <label style="max-width: 80%;" class="custom-file-label" for="ImagenMision" aria-describedby="inputGroupFileAddon02"> Seleccione una imagen <i class="fas fa-image"></i></label>
                  </div>
                  <div id="LoadImgProducto"></div>
                </div>
                <br><br>



                <input type="hidden" id="IdHome" name="IdHome" value="<?php echo $datos['home']->IdHome ?>">
              </div>

              <div class="col-md-4 well">
                <label for="">
                  <h4><b>Imagen Vision</b></h4>
                </label>
                <?php if ($datos['home']->ImagenVision != NULL || $datos['home']->ImagenVision != '') : ?>
                  <div id="IMGProductoCargad">
                    <img style="width: -50%;" class="img-fluid img-producto" src="<?php echo RUTA_URL ?>/Configuracion/files?img=<?php echo $datos['home']->ImagenVision; ?>" alt="Configuracion">
                  </div>
                <?php else : ?>
                  <h5>El producto no tiene una imagen cargada</h5>
                <?php endif; ?>
                <br>
                <div class="input-group mb-4">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="ImagenVision" name="ImagenVision" onchange="upload_image2();" accept=".jpg,.png,.jpeg">
                    <label style="max-width: 80%;" class="custom-file-label" for="ImagenVision" aria-describedby="inputGroupFileAddon02"> Seleccione una imagen <i class="fas fa-image"></i></label>
                  </div>
                  <div id="LoadImgProduct"></div>
                </div>
                <br><br>



                <input type="hidden" id="IdHome" name="IdHome" value="<?php echo $datos['home']->IdHome ?>">
              </div>
            </div>


            <button type="submit" id="guardar_datos" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>

          </div>

        </form>
      </div>

  </div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
    <div class="card-deck">
      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" action="" id="guardar_Tipo" method="POST" autocomplete="off">
            <h5 class="card-title">Tipo producto</h5><br>
            <input type="text" class="form-control form-control-sm" id="Nombre" name="Nombre" placeholder="Tipo producto" required="">
        </div>
        <div class="modal-footer">
          <button type="submit" id="guardar_datos" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal">Lista</button>
          </form>
        </div>
      </div>

      <!--modal-->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class=""></i>Tipos de Productos</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm">
                  <div class="container-fluid">
                    <div class="table-responsive">
                      <table style="width: 100%" id="tipopo" class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-left">Nombre</th>
                            <th class="text-left">Acciones</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" action="" id="guardar_Novedad" method="POST" autocomplete="off">
            <h5 class="card-title">Tipo novedad</h5><br>
            <input type="text" class="form-control form-control-sm" id="Nombre_Novedad" name="Nombre_Novedad" placeholder="Tipo novedad" required="">
        </div>
        <div class="modal-footer">
          <button type="submit" id="guardar_datos" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal1">Lista</button>
          </form>
        </div>
      </div>

      <!--modal-->
      <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1"><i class=""></i>Tipos de Novedad</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm">
                  <div class="container-fluid">
                    <div class="table-responsive">
                      <table style="width: 100%" id="tiponovedad" class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-left">Nombre novedad</th>
                            <th class="text-left">Acciones</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Marca</h5><br>
          <form class="form-horizontal" action="" id="guardar_Marca" method="POST" autocomplete="off">
            <input type="text" class="form-control form-control-sm" id="Nombre" name="Nombre" placeholder="Marca" required="">
        </div>
        <div class="modal-footer">
          <button type="submit" id="guardar_datos" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal2">Lista</button>
          </form>
        </div>
      </div>
      <!--modal-->
      <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1"><i class=""></i>Marca</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm">
                  <div class="container-fluid">
                    <div class="table-responsive">
                      <table style="width: 100%" id="marca" class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-left">Nombre marca</th>
                            <th class="text-left">Acciones</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
    </div>
    <div>
      <br>
    </div>
    <div class="card-deck">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Presentacion</h5><br>
          <form class="form-horizontal" action="" id="guardar_Presentacion" method="POST" autocomplete="off">
            <input type="text" class="form-control form-control-sm" id="Nombre" name="Nombre" placeholder="Presentacion" required="">
        </div>
        <div class="modal-footer">
          <button type="submit" id="guardar_datos" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal3">Lista</button>
          </form>
        </div>
      </div>

      <!--modal-->
      <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1"><i class=""></i>Presentacion</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm">
                  <div class="container-fluid">
                    <div class="table-responsive">
                      <table style="width: 100%" id="presentacion" class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-left">Nombre presentacion</th>
                            <th class="text-left">Acciones</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" action="" id="guardar_Documento" method="POST" autocomplete="off">
            <h5 class="card-title">Tipo documento</h5><br>
            <input type="text" class="form-control form-control-sm" id="Nombre_Documento" name="Nombre_Documento" placeholder="Tipo documento" required="">
        </div>
        <div class="modal-footer">
          <button type="submit" id="guardar_datos" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal4">Lista</button>
          </form>
        </div>
      </div>
      <!--modal-->
      <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1"><i class=""></i>Tipos de documentos</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm">
                  <div class="container-fluid">
                    <div class="table-responsive">
                      <table style="width: 100%" id="documento" class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-left">Nombre documento</th>
                            <th class="text-left">Acciones</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <!--modal-->
      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" action="" id="guardar_Unidad" method="POST" autocomplete="off">
            <h5 class="card-title">Unidad medida</h5><br>
            <input type="text" class="form-control form-control-sm" id="NombreUnidad" name="NombreUnidad" placeholder="Unidad medida" required="">
        </div>
        <div class="modal-footer">
          <button type="submit" id="guardar_datos" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal5">Lista</button>
          </form>
        </div>
      </div>
    </div>
    <!--modal-->
    <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1"><i class=""></i>Unidad de Medida</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm">
                <div class="container-fluid">
                  <div class="table-responsive">
                    <table style="width: 100%" id="unidad" class="table table-hover">
                      <thead>
                        <tr>
                          <th class="text-left">Nombre Unidad</th>
                          <th class="text-left">Acciones</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!--modal-->

  </div>
  <script type="text/javascript">
    var ruta = document.getElementById("ruta").value;



    // subir imagen mision
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


          },
        });
      }
    }

    function upload_image1() {


      var inputFileImage = document.getElementById("ImagenQuienes");
      var file = inputFileImage.files[0];
      if (typeof file === "object" && file !== null) {
        document.getElementById("LoadImgProductoo").innerText = "Cargando...";
        var data = new FormData();
        data.append("ImagenQuienes", file);
        $.ajax({
          url: ruta +
            `/Configuracion/ImagenQuienes/${
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
  <img style="width: -50%;" id="IMGProductoCargadoo" class="img-fluid img-producto" alt="Configuracion" src="${ruta}/Configuracion/files?img=${resultado}">
  `;
              document.getElementById("IMGProductoCargadoo").innerHTML = img;
            }
            document.getElementById("LoadImgProductoo").innerText = "";


          },
        });
      }
    }

    function upload_image2() {


      var inputFileImage = document.getElementById("ImagenVision");
      var file = inputFileImage.files[0];
      if (typeof file === "object" && file !== null) {
        document.getElementById("LoadImgProduct").innerText = "Cargando...";
        var data = new FormData();
        data.append("ImagenVision", file);
        $.ajax({
          url: ruta +
            `/Configuracion/ImagenVision/${
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
<img style="width: -50%;" id="IMGProductoCargadoo" class="img-fluid img-producto" alt="Configuracion" src="${ruta}/Configuracion/files?img=${resultado}">
`;
              document.getElementById("IMGProductoCargad").innerHTML = img;
            }
            document.getElementById("LoadImgProduct").innerText = "";


          },
        });
      }
    }


    window.onload = Autoload();

    function Autoload() {
      obtenerdatos();
    }
    $("#form-info").submit(function(event) {
      $('#guardar_datos').attr("disabled", true);
      var parametros = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo RUTA_URL ?>/Configuracion/editarHome",
        data: parametros,
        beforeSend: function(objeto) {
          //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == 'true') {
            $('#guardar_datos').attr("disabled", false);
            alertify.success('<h6><i class="fas fa-check"></i> Datos guardados correctamente</h6>');
          } else {
            $('#guardar_datos').attr("disabled", false);
            alertify.warning(result);
            console.log(datos);
          }
        }
      });
      event.preventDefault();

    });

    $(document).ready(function() {

      $('form').keypress(function(e) {
        if (e == 13) {
          return false;
        }
      });

      $('input').keypress(function(e) {
        if (e.which == 13) {
          return false;
        }
      });

    });

    function obtenerdatos() {
      $.ajax({
        type: "POST",
        url: "<?php echo RUTA_URL ?>/Configuracion/obtenerdatos",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(objeto) {
          //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(resultado) {
          console.log(resultado);
          for (var r in resultado) {
            console.log(resultado);
            document.getElementById("Mision").value = resultado[r].Mision;
            document.getElementById("Vision").value = resultado[r].Vision;
            document.getElementById("Quienes_Somos").value = resultado[r].Quienes_Somos;
          }

        }
      });
    }

    $("#guardar_Tipo").submit(function(event) {
      $("#guardar_datos").attr("disabled", true);
      var parametros = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo RUTA_URL ?>/Configuracion/agregar",
        data: parametros,
        beforeSend: function(objeto) {
          //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == true) {
            $("#exampleModal").modal("hide");
            $("#guardar_Tipo")[0].reset();
            $("#guardar_datos").attr("disabled", false);
            alertify.success(
              '<h6><i class="fas fa-check"></i> Tipo producto creado correctamente</h6>'
            );
          } else {
            $("#guardar_datos").attr("disabled", false);
            alertify.warning(result);
          }
        }
      });
      event.preventDefault();
    });

    $("#guardar_Novedad").submit(function(event) {
      $("#guardar_datos").attr("disabled", true);
      var parametros = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo RUTA_URL ?>/Configuracion/agregarNovedad",
        data: parametros,
        beforeSend: function(objeto) {
          //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == true) {
            $("#exampleModal").modal("hide");
            $("#guardar_Novedad")[0].reset();
            $("#guardar_datos").attr("disabled", false);
            alertify.success(
              '<h6><i class="fas fa-check"></i> Tipo novedad creado correctamente</h6>'
            );
          } else {
            $("#guardar_datos").attr("disabled", false);
            alertify.warning(result);
          }
        }
      });
      event.preventDefault();
    });

    $("#guardar_Documento").submit(function(event) {
      $("#guardar_datos").attr("disabled", true);
      var parametros = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo RUTA_URL ?>/Configuracion/agregarDocumento",
        data: parametros,
        beforeSend: function(objeto) {
          //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == true) {
            $("#exampleModal").modal("hide");
            $("#guardar_Documento")[0].reset();
            $("#guardar_datos").attr("disabled", false);
            alertify.success(
              '<h6><i class="fas fa-check"></i> Tipo documento creado correctamente</h6>'
            );
          } else {
            $("#guardar_datos").attr("disabled", false);
            alertify.warning(result);
          }
        }
      });
      event.preventDefault();
    });

    $("#guardar_Unidad").submit(function(event) {
      $("#guardar_datos").attr("disabled", true);
      var parametros = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo RUTA_URL ?>/Configuracion/agregarUnidad",
        data: parametros,
        beforeSend: function(objeto) {
          //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == true) {
            $("#exampleModal").modal("hide");
            $("#guardar_Unidad")[0].reset();
            $("#guardar_datos").attr("disabled", false);
            alertify.success(
              '<h6><i class="fas fa-check"></i> Unidad medida creado correctamente</h6>'
            );
          } else {
            $("#guardar_datos").attr("disabled", false);
            alertify.warning(result);
          }
        }
      });
      event.preventDefault();
    });

    $("#guardar_Presentacion").submit(function(event) {
      $("#guardar_datos").attr("disabled", true);
      var parametros = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo RUTA_URL ?>/Configuracion/agregarPresentacion",
        data: parametros,
        beforeSend: function(objeto) {
          //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == true) {
            $("#exampleModal").modal("hide");
            $("#guardar_Presentacion")[0].reset();
            $("#guardar_datos").attr("disabled", false);
            alertify.success(
              '<h6><i class="fas fa-check"></i> Presentacion creada correctamente</h6>'
            );
          } else {
            $("#guardar_datos").attr("disabled", false);
            alertify.warning(result);
          }
        }
      });
      event.preventDefault();
    });

    $("#guardar_Marca").submit(function(event) {
      $("#guardar_datos").attr("disabled", true);
      var parametros = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo RUTA_URL ?>/Configuracion/agregarMarca",
        data: parametros,
        beforeSend: function(objeto) {
          //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos) {
          var result = datos;
          if (datos == true) {
            $("#exampleModal").modal("hide");
            $("#guardar_Marca")[0].reset();
            $("#guardar_datos").attr("disabled", false);
            alertify.success(
              '<h6><i class="fas fa-check"></i> Marca creada correctamente</h6>'
            );
          } else {
            $("#guardar_datos").attr("disabled", false);
            alertify.warning(result);
          }
        }
      });
      event.preventDefault();
    });

    var ruta = $("#ruta").val();
    $(document).ready(function() {
      var filter = $("#filter").val();
      $("#tipopo").DataTable({
        processing: true,
        serverSide: true,
        language: {
          url: ruta + "/public/js/Spanish.json"
        },
        ajax: {
          url: ruta + "/Configuracion/tableViews",
          type: "POST",
          data: function(d) {
            d.id = $("#filter").val();
          },
        },
        columns: [


          {
            data: "Nombre"
          },
          {
            data: "IdTipoProducto",
            fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
              $(nTd).html(
                "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
                ruta +
                "/Configuracion/vertipoproducto/" +
                oData.IdTipoProducto +
                "'>" +
                "<i class='fas fa-edit'></i>" +
                "</a><a title='Actualizar' href='#' class='' (" +
                oData.IdTipoProducto +
                "," +
                oData.IdTipoProducto +
                ");" +
                oData.IdTipoProducto +
                "," +
                oData.IdTipoProducto +
                ");'></div>"
              );
            },
          },
        ],
      });
    });


    var ruta = $("#ruta").val();
    $(document).ready(function() {
      var filter = $("#filter").val();
      $("#tiponovedad").DataTable({
        processing: true,
        serverSide: true,
        language: {
          url: ruta + "/public/js/Spanish.json"
        },
        ajax: {
          url: ruta + "/Configuracion/tableViewsNovedades",
          type: "POST",
          data: function(d) {
            d.id = $("#filter").val();
          },
        },
        columns: [


          {
            data: "Nombre_Novedad"
          },
          {
            data: "IdTipoNovedad",
            fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
              $(nTd).html(
                "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
                ruta +
                "/Productos/VerProducto/" +
                oData.IdTipoNovedad +
                "'>" +
                "<i class='fas fa-edit'></i>" +
                "</a><a title='Actualizar' href='#' class='' (" +
                oData.IdTipoNovedad +
                "," +
                oData.IdTipoNovedad +
                ");'></a><a title='Actualizar' href='#' class='btn btn-sm btn-outline-secondary' onclick='Eliminar(" +
                oData.IdTipoNovedad +
                "," +
                oData.IdTipoNovedad +
                ");'><i class='fas fa-trash-alt'></i></a></div>"
              );
            },
          },
        ],
      });
    });

    var ruta = $("#ruta").val();
    $(document).ready(function() {
      var filter = $("#filter").val();
      $("#marca").DataTable({
        processing: true,
        serverSide: true,
        language: {
          url: ruta + "/public/js/Spanish.json"
        },
        ajax: {
          url: ruta + "/Configuracion/tableViewsMarca",
          type: "POST",
          data: function(d) {
            d.id = $("#filter").val();
          },
        },
        columns: [


          {
            data: "Nombre"
          },
          {
            data: "IdMarca",
            fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
              $(nTd).html(
                "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
                ruta +
                "/Productos/IdMarca/" +
                oData.IdMarca +
                "'>" +
                "<i class='fas fa-edit'></i>" +
                "</a><a title='Actualizar' href='#' class='' (" +
                oData.IdMarca +
                "," +
                oData.IdMarca +
                ");" +
                oData.IdMarca +
                "," +
                oData.IdMarca +
                ");'></div>"
              );
            },
          },
        ],
      });
    });

    var ruta = $("#ruta").val();
    $(document).ready(function() {
      var filter = $("#filter").val();
      $("#presentacion").DataTable({
        processing: true,
        serverSide: true,
        language: {
          url: ruta + "/public/js/Spanish.json"
        },
        ajax: {
          url: ruta + "/Configuracion/tableViewsPresentacion",
          type: "POST",
          data: function(d) {
            d.id = $("#filter").val();
          },
        },
        columns: [


          {
            data: "Nombre"
          },
          {
            data: "IdPresentacion",
            fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
              $(nTd).html(
                "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
                ruta +
                "/Productos/IdMarca/" +
                oData.IdPresentacion +
                "'>" +
                "<i class='fas fa-edit'></i>" +
                "</a><a title='Actualizar' href='#' class='' (" +
                oData.IdPresentacion +
                "," +
                oData.IdPresentacion +
                ");" +
                oData.IdPresentacion +
                "," +
                oData.IdPresentacion +
                ");'></div>"
              );
            },
          },
        ],
      });
    });

    var ruta = $("#ruta").val();
    $(document).ready(function() {
      var filter = $("#filter").val();
      $("#documento").DataTable({
        processing: true,
        serverSide: true,
        language: {
          url: ruta + "/public/js/Spanish.json"
        },
        ajax: {
          url: ruta + "/Configuracion/tableViewsdocumento",
          type: "POST",
          data: function(d) {
            d.id = $("#filter").val();
          },
        },
        columns: [


          {
            data: "Nombre_Documento"
          },
          {
            data: "IdTipoDocumento",
            fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
              $(nTd).html(
                "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
                ruta +
                "/Productos/IdMarca/" +
                oData.IdTipoDocumento +
                "'>" +
                "<i class='fas fa-edit'></i>" +
                "</a><a title='Actualizar' href='#' class='' (" +
                oData.IdTipoDocumento +
                "," +
                oData.IdTipoDocumento +
                ");" +
                oData.IdTipoDocumento +
                "," +
                oData.IdTipoDocumento +
                ");'></div>"
              );
            },
          },
        ],
      });
    });

    var ruta = $("#ruta").val();
    $(document).ready(function() {
      var filter = $("#filter").val();
      $("#unidad").DataTable({
        processing: true,
        serverSide: true,
        language: {
          url: ruta + "/public/js/Spanish.json"
        },
        ajax: {
          url: ruta + "/Configuracion/tableViewsUnidad",
          type: "POST",
          data: function(d) {
            d.id = $("#filter").val();
          },
        },
        columns: [


          {
            data: "NombreUnidad"
          },
          {
            data: "IdUnidadMedida",
            fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
              $(nTd).html(
                "<div class='btn-group'> <a title='Editar' class='btn btn-sm btn-outline-secondary' href='" +
                ruta +
                "/Productos/IdMarca/" +
                oData.IdUnidadMedida +
                "'>" +
                "<i class='fas fa-edit'></i>" +
                "</a><a title='Actualizar' href='#' class='' (" +
                oData.IdUnidadMedida +
                "," +
                oData.IdUnidadMedida +
                ");" +
                oData.IdUnidadMedida +
                "," +
                oData.IdUnidadMedida +
                ");'></div>"
              );
            },
          },
        ],
      });
    });
  </script>
  <?php require(RUTA_APP . '/Views/inc/footer.php'); ?>