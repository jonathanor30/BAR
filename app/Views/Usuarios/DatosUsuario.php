<?php require RUTA_APP . '/Views/inc/header.php';?>
<br>
<div class="container">
  <div class="card">
  <div class="card-header">
    Información de usuario
  </div>
  <div class="card-body">
     <strong>Nombre Completo:</strong>
   <?php echo $datos['usuario']->firstname . " " . $datos['usuario']->lastname ?><br>
  <strong>Usuario:  </strong>
   <?php echo $datos['usuario']->user_name ?><br>
  <strong>Correo:  </strong>
   <?php echo $datos['usuario']->user_email ?><br>
  <strong>Agregado:  </strong>
   <?php echo $datos['usuario']->date_added ?>
   <input type="hidden" id="user_id" value="<?php echo $datos['usuario']->user_id ?>">
    
  </div>
</div>
</div>
<br>
<div class="container-fluid">
  <h3 class="text-title">Contratos asignados </h3>
  <form class="form-inline" id="asignarContrato">
  <div class="form-group mx-sm-3 mb-2">
   <input type="text"  class="form-control form-control-sm ui-autocomplete-input" id="contratante" name="contratante" placeholder="Asignar nuevo contrato" autocomplete="off" required="">
   <input type="hidden" id="id_contrato" name="">
  </div>
  <button type="button" onclick="asignar();" class="btn btn-primary btn-sm mb-2"><strong>+</strong></button>
</form>
   <div class="table-responsive">
      <table style="font-size: 12px;" id="Contratos" class="table table-hover">
         <thead>
            <tr>
               <th class="text-left">Numero</th>
               <th class="text-left">Inicial</th>
               <th class="text-left">Final</th>
               <th class="text-left">Objeto</th>
               <th class="text-left">Contratante</th>
               <th class="text-left">NIT C.</th>
               <th class="text-left">Responsable</th>
               <th class="text-left">NIT R.</th>
               <th class="text-left">Telefono R.</th>
               <th class="text-left">Estado</th>
               <th class="text-right">Acciones</th>
            </tr>
         </thead>
      </table>
   </div>
</div>
<hr>
<div class="container-fluid">
  <h3 class="text-title">Rutas asignadas </h3>
  <form class="form-inline" id="asignarRutas">
  <div class="form-group mx-sm-3 mb-2">
   <input type="text"  class="form-control form-control-sm ui-autocomplete-input" id="nombre_ruta" name="nombre_ruta" placeholder="Selecciona una ruta" autocomplete="off" required="">
   <input type="hidden" id="id_ruta" name="">
  </div>
  <button type="button" onclick="asignarRuta();" class="btn btn-primary btn-sm mb-2"><strong>+</strong></button>
</form>
   <div class="table-responsive">
   <table style="font-size: 13px;" id="Rutas" class="table table-hover">
      <thead>
         <tr>
            <th class="text-left">Ruta</th>
            <th class="text-left">Recorrido</th>
            <th class="text-left">Estado</th>
            <th class="text-right">Acciones</th>
         </tr>
      </thead>
   </table>
  </div>
</div>
<link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/jquery-ui.css">
<script src="<?php echo RUTA_URL ?>/public/js/jquery-ui.js"></script>
<script>
var documento =  $('#tabla').val();
var ruta      =  $('#ruta').val();
var user_id   =
$(document).ready(function() {
    var filter = $("#filter").val();
    $('#Contratos').DataTable( {
        "processing": true,
        "serverSide": true,
        "language": {"url": ruta+"/public/js/Spanish.json"},
        "ajax": {
            "url": ruta+"/usuarios/contratosAsignados",
            "type": "POST",
        "data": function ( d ) {
                d.id = $('#user_id').val();
            }
        },
        "columns": [
            { "data": "numero_contrato" },
            { "data": "fecha_inicial" },
            { "data": "fecha_final" },
            { "data": "objeto_contrato" },
            { "data": "contratante" },
            { "data": "nit_contratante" },
            { "data": "responsable" },
            { "data": "nit_responsable" },
            { "data": "telefono_responsable" },
            { "data": "estado_contrato",
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
              switch (oData.estado_contrato) {
                  case "1":
                   var estado = "Activo";
                   var clase  = "badge badge-success";
                   break;
                  case "2":
                   var estado = "Terminado";
                   var clase  = "badge badge-warning";
                   break;
                  case "0":
                   var estado = "Inactivo";
                   var clase  = "badge badge-danger";
                   break;
                  }
            $(nTd).html("<span class='"+clase+"'>"+estado+"</span>");
               }
            },
            { "data": "id_contrato_asignado",
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            $(nTd).html("<div class='btn-group'><a href='#' title='Eliminar' class='btn btn-sm btn-outline-secondary' onclick='eliminarContrato("+oData.id_contrato_asignado+");'><i class='fas fa-trash-alt'></i></a></div>");
               }
             },

        ]
    } );
} );

   function eliminarContrato(id)
   {
     var q = id;
     var pre = document.createElement('H5');
       //custom style.
       pre.style.maxHeight = "400px";
       pre.style.margin = "0";
       pre.style.padding = "24px";
       //pre.style.whiteSpace = "pre-wrap";
       pre.style.textAlign = "center";

     pre.appendChild(document.createTextNode('Realmente desea eliminar este contrato asignado'));

          alertify.confirm(pre, function(){
                   $.ajax({
            type: "POST",
            url: ruta+"/usuarios/eliminarContrato",
            data: "id=" + id, "q": q,
            beforeSend: function (objeto) {
              //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
              var result = datos;
                if (datos == 'true'){
                   $('#Contratos').DataTable().ajax.reload();
                alertify.success('<h6><i class="fas fa-check"></i> Contrato eliminado correctamente.</h6>');

              }else{
                alertify.warning('<i class="fas fa-ban"></i> Error al intentar eliminar el contrato.');
            }
              }
          });

          },function(){

              alertify.error('<i class="fas fa-ban"></i> Cencelado');
          })
   }
$(document).ready(function() {
    var filter = $("#filter").val();
    $('#Rutas').DataTable( {
        "processing": true,
        "serverSide": true,
        "language": {"url": ruta+"/public/js/Spanish.json"},
        "ajax": {
            "url": ruta+"/usuarios/rutasAsignadas",
            "type": "POST",
        "data": function ( d ) {
                d.id =  $('#user_id').val();
            }
        },
        "columns": [
            { "data": "nombre_ruta" ,
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
              var ruta    = oData.nombre_ruta.split('-');
              var origen  = ruta[0];
              var destino = ruta[1];
            $(nTd).html(" <a href='https://www.google.com/maps/dir/"+origen+"/"+destino+"' target='_blank'><span class='badge badge-primary'>"+oData.nombre_ruta+"</span></a>");
               }
             },
            { "data": "descripccion" },
            { "data": "status_ruta",
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
              switch (oData.status_ruta) {
                  case "1":
                   var estado = "Activa";
                   var clase  = "badge badge-success";
                   break;
                  case "2":
                   var estado = "Terminado";
                   var clase  = "badge badge-warning";
                   break;
                  case "0":
                   var estado = "Inactiva";
                   var clase  = "badge badge-danger";
                   break;
                  }
            $(nTd).html("<span class='"+clase+"'>"+estado+"</span>");
               }
            },
            { "data": "id_ruta_asignada",
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            $(nTd).html("<div class='btn-group'> <a href='#' title='Eliminar' class='btn btn-sm btn-outline-secondary' onclick='eliminarRuta("+oData.id_ruta_asignada+");'><i class='fas fa-trash-alt'></i></a></div>");
               }
             },


        ]
    } );
} );

  function eliminarRuta(id)
   {
     var id_ruta = id;
     var pre = document.createElement('H5');
  
       //custom style.
       pre.style.maxHeight = "400px";
       pre.style.margin = "0";
       pre.style.padding = "24px";
       //pre.style.whiteSpace = "pre-wrap";
       pre.style.textAlign = "center";
   
     pre.appendChild(document.createTextNode('Realmente desea eliminar esta ruta'));
   
          alertify.confirm(pre, function(){
            $.ajax({
            type: "POST",
            url: ruta+"/usuarios/borrarRuta",
            data: "id="+id_ruta,
            beforeSend: function (objeto) {
              //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
              
                if (datos == 'true'){
                 $('#Rutas').DataTable().ajax.reload();
                alertify.success('<h6><i class="fas fa-check"></i> Se ha eliminado correctamente la ruta asignada</h6>');
              }else{
                alertify.warning('<i class="fas fa-ban"></i> Error :'+datos);
                
            }
              }
          });
             
          },function(){
              
              alertify.error('<i class="fas fa-ban"></i> Cencelado');
          })
   }
     //Contratos
$(function() {
    $("#contratante").autocomplete({
        source: "<?php echo RUTA_URL?>/contratos/autocompletarContrato",
        minLength: 2,
        select: function(event, ui) {
            event.preventDefault();
            $('#id_contrato').val(ui.item.id_contrato);
            $('#numero_contrato').val(ui.item.numero_contrato);
            $('#fecha_inicial').val(ui.item.fecha_inicial);
            $('#objeto').val(ui.item.objeto_contrato);
            $('#nit_contratante').val(ui.item.nit_contratante);
            $('#contratante').val(ui.item.contratante);
            $('#nit_responsable').val(ui.item.nit_responsable);
            $('#responsable').val(ui.item.responsable);
            $('#telefono_responsable').val(ui.item.telefono_responsable);
            $('#direccion_responsable').val(ui.item.direccion_responsable);
            $('#estado_contrato').val(ui.item.estado_contrato);
        }
    });
});
$("#contratante").on("keydown", function(event) {
    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
        $("#id_contrato").val("");
        $("#numero_contrato").val("");
        $("#fecha_inicial").val("");
        $("#objeto").val("");
        $("#nit_contratante").val("");
        $("#contratante").val("");
        $("#nit_responsable").val("");
        $("#responsable").val("");
        $("#telefono_responsable").val("");
        $("#direccion_responsable").val("");
        $("#estado_contrato").val("");
        
    }
    if (event.keyCode == $.ui.keyCode.DELETE) {
        $("#id_contrato").val("");
        $("#numero_contrato").val("");
        $("#fecha_inicial").val("");
        $("#objeto").val("");
        $("#nit_contratante").val("");
        $("#contratante").val("");
        $("#nit_responsable").val("");
        $("#responsable").val("");
        $("#telefono_responsable").val("");
        $("#direccion_responsable").val("");
        $("#estado_contrato").val("");
    }
});
$(function() {
    $("#nombre_ruta").autocomplete({
        source: ruta + "/rutas/autocompletarRuta",
        minLength: 2,
        select: function(event, ui) {
            event.preventDefault();
            $('#id_ruta').val(ui.item.id_ruta);
            $('#codigo_ruta').val(ui.item.codigo_ruta);
            $('#nombre_ruta').val(ui.item.nombre_ruta);
            $('#descripccion').val(ui.item.descripccion);
            $('#status_ruta').val(ui.item.status_ruta);
        }
    });
});
$("#nombre_ruta").on("keydown", function(event) {
    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
        $('#id_ruta').val("");
        $('#codigo_ruta').val("");
        $('#nombre_ruta').val("");
        $('#descripccion').val("");
        $('#status_ruta').val("");
        
    }
    if (event.keyCode == $.ui.keyCode.DELETE) {
        $('#id_ruta').val("");
        $('#codigo_ruta').val("");
        $('#nombre_ruta').val("");
        $('#descripccion').val("");
        $('#status_ruta').val("");
    }
});
function asignar(){
 if($("#id_contrato").val() !=""){
  var pre = document.createElement('H5');
 var id_contrato = $("#id_contrato").val();
 var user_id = $("#user_id").val();
       //custom style.
       pre.style.maxHeight = "400px";
       pre.style.margin = "0";
       pre.style.padding = "24px";
       //pre.style.whiteSpace = "pre-wrap";
       pre.style.textAlign = "center";
   
     pre.appendChild(document.createTextNode('Desea asignar este contrato'));
     
          alertify.confirm(pre, function(){
                   $.ajax({
            type: "POST",
            url: ruta+"/usuarios/asignarContrato",
            data: "id=" + id_contrato+"-"+user_id,
            beforeSend: function (objeto) {
              //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
              var result = datos;
                if (datos == 'true'){
                   $('#Contratos').DataTable().ajax.reload();
                 alertify.success('<h6><i class="fas fa-check"></i> Contrato asignado correctamente</h6>');
                 document.getElementById("asignarContrato").reset();

   
              }else{
                alertify.warning('<i class="fas fa-ban"></i> '+datos);
                document.getElementById("asignarContrato").reset();
                //Debug:console.log(datos);
            }
              }
          });
             
          },function(){
              
              alertify.error('<i class="fas fa-ban"></i> Cencelado');
          })
        }else{
           alertify.warning('<i class="fas fa-ban"></i> Seleccione un contrato');
        }
}
function asignarRuta(){
 if($("#id_ruta").val() !=""){
  var pre = document.createElement('H5');
 var id_ruta = $("#id_ruta").val();
 var user_id = $("#user_id").val();
       //custom style.
       pre.style.maxHeight = "400px";
       pre.style.margin = "0";
       pre.style.padding = "24px";
       //pre.style.whiteSpace = "pre-wrap";
       pre.style.textAlign = "center";
   
     pre.appendChild(document.createTextNode('Desea asignar esta ruta'));
     
          alertify.confirm(pre, function(){
                   $.ajax({
            type: "POST",
            url: ruta+"/usuarios/asignarRuta",
            data: "id=" + id_ruta+"-"+user_id,
            beforeSend: function (objeto) {
              //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
              var result = datos;
                if (datos == 'true'){
                   $('#Rutas').DataTable().ajax.reload();
                 alertify.success('<h6><i class="fas fa-check"></i> Ruta asignada correctamente</h6>');
                 document.getElementById("asignarRutas").reset();

   
              }else{
                alertify.warning('<i class="fas fa-ban"></i> '+datos);
                document.getElementById("asignarRutas").reset();
                //Debug:console.log(datos);
            }
              }
          });
             
          },function(){
              
              alertify.error('<i class="fas fa-ban"></i> Cencelado');
          })
        }else{
           alertify.warning('<i class="fas fa-ban"></i> Seleccione un contrato');
        }
}

window.addEventListener("keypress", function(event){
    if (event.keyCode == 13){
        event.preventDefault();
    }
}, false);
</script>
<?php require RUTA_APP . '/Views/inc/footer.php';?>