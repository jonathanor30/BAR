$( document ).ready(function() {
    $("#Productos").DataTable({
       
        ajax: {
          url: document.getElementById("path_ajax").value+"ajax/DatablesAjax.php",
          type: "POST",
    
        },
        complete: function (data){
            console.log(data.responseText);
        },
        columns: [
          { data: "CodigoProducto"},
          { data: "ImagenProducto"},
          { data: "NombreProducto" },
          { data: "PrecioSugerido" },
          { data: "Existencia"},
          { data: "IdProducto",
          fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                $(nTd).html(`
                    <a href="`+document.getElementById("path_ajax").value+`editarproducto/`+oData.CodigoProducto+`" class="btn btn-sm btn-primary">Editar  
                    <i class="fas fa-pencil-alt"></i></a>
                    <button class="btn btn-sm btn-danger" onclick="EliminarProducto(`+oData.IdProducto+`)">Eliminar<i class="fas fa-trash-alt"></i></button>
                    <a   class="btn btn-sm btn-secondary">Ver
                    <i class="fas fa-eye"></i>
                    </a>
                    `);
          }
          }

          
        ]
      });});
function EliminarProducto(id){
     var respuesta = window.confirm("¿Realmente desea Eliminar este producto?");
    if(respuesta == true){
        $.ajax({
            url: document.getElementById("path_ajax").value + "ajax/EliminarProductoAjax.php",
            type: "POST",
            async: false,
            data: "id=" + id,
            success: function (data) {
                console.log(data);
              var result = JSON.parse(data);
                if(result.code == 200){
                    $("#Productos").DataTable().ajax.reload();
                    alert(result.mensaje);
                }else{
                    alert(result.mensaje);
                }
            },
          });
    }
}
$( document ).ready(function() {
  $("#cliente").DataTable({
     
      ajax: {
        url: document.getElementById("path_ajax").value+"ajax/tablaclienteAjax.php",
        type: "POST",
  
      },
      complete: function (data){
          console.log(data.responseText);
      },
      columns: [
        { data: "IdCliente"},
        { data: "IdTipoDocumento"},
        { data: "Nombre"},
        { data: "NumeroDocumento"},
        { data: "IdCliente",
        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
              $(nTd).html(`
                  <a href="`+document.getElementById("path_ajax").value+`editarcliente/`+oData.IdCliente+`" class="btn btn-sm btn-primary">Editar  
                  <i class="fas fa-pencil-alt"></i></a>
                  <button class="btn btn-sm btn-danger" onclick="Eliminarcliente(`+oData.IdCliente+`)">Eliminar<i class="fas fa-trash-alt"></i></button>
                  <a   class="btn btn-sm btn-secondary">Ver
                  <i class="fas fa-eye"></i>
                  </a>
                  `);
        }
        }

        
      ]
    });});

$( document ).ready(function() {
  $("#usuario").DataTable({
         
          ajax: {
            url: document.getElementById("path_ajax").value+"ajax/tablausuarioAjax.php",
            type: "POST",
      
          },
          complete: function (data){
              console.log(data.responseText);
          },
          columns: [
            { data: "IdUsuario"},
            { data: "NumeroDocumento"},
            { data: "Nombres"},
            { data: "Apellidos"},
            { data: "NombreUsuario"},
            { data: "IdUsuario",
            fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                  $(nTd).html(`
                      <a href="`+document.getElementById("path_ajax").value+`editarusuario/`+oData.IdCliente+`" class="btn btn-sm btn-primary">Editar  
                      <i class="fas fa-pencil-alt"></i></a>
                      <button class="btn btn-sm btn-danger" onclick="EliminarUsuario(`+oData.IdCliente+`)">Eliminar<i class="fas fa-trash-alt"></i></button>
                      <a   class="btn btn-sm btn-secondary">Ver
                      <i class="fas fa-eye"></i>
                      </a>
                      `);
            }
            }
    
            
          ]
        });});   