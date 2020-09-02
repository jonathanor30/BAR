var ruta = $('#ruta').val();
$(document).ready(function() {
    var icon;
    var title;
    $('#Plugins').DataTable({
       
        "language": {
            "url": ruta + "/public/js/Spanish.json"
        },
        "ajax": {
            "url": ruta + "/plugins/tableViews",
            "type": "POST",
            "data": function(d) {
                d.id = $('#filter').val();
            }
        },
        "columns": [{
            "data": "nombre"
        }, {
            "data": "descripcion"
        }, {
            "data": "version"
        }, {
            "data": "autor"
        }, {
            "data": "estado",
            "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                switch (oData.estado) {
                    case "activo":
                        var clase = "badge badge-success";
                        icon = "<i class='fas fa-times fa-fw'></i>";
                        title = "Desactivar";
                        break;
                    case "inactivo":
                        var clase = "badge badge-warning";
                        icon = "<i class='fas fa-check fa-fw'></i>";
                        title = "Activar";
                        break;
                }
                $(nTd).html("<span class='" + clase + "'>" + oData.estado + "</span>");
            }
        }, {
            "data": "id",
            "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                var argumento = '"' + oData.id + '"';
                $(nTd).html("<div class='btn-group'><a title='"+title+"' href='#' class='btn btn-sm btn-outline-secondary' onclick='setPlugin(" + argumento + ");'>" + icon + "</a> <a title='Eliminar' href='#' class='btn btn-sm btn-outline-secondary' onclick='eliminar(" + argumento + ");'><i class='fas fa-trash-alt'></i></a></div>");
            }
        }, ]
    });
});

function eliminar(id) {
    var q = id;
    var pre = document.createElement('H5');
    //custom style.
    pre.style.maxHeight = "400px";
    pre.style.margin = "0";
    pre.style.padding = "24px";
    //pre.style.whiteSpace = "pre-wrap";
    pre.style.textAlign = "center";
    pre.appendChild(document.createTextNode('Realmente desea eliminar el plugin ' + q));
    alertify.confirm(pre, function() {
        $.ajax({
            type: "POST",
            url: ruta + "/plugins/borrar",
            data: "id=" + id,
            "q": q,
            beforeSend: function(objeto) {
                //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                var result = datos;
                if (datos == result) {
                    $("#Plugins").DataTable().ajax.reload();
                    alertify.success('<h6><i class="fas fa-check"></i> Plugin eliminado correctamente</h6>');
                } else {
                    alertify.warning('<i class="fas fa-ban"></i> Error al eliminar plugin');
                }
            }
        });
    }, function() {
        alertify.error('<i class="fas fa-ban"></i> Cencelado');
    })
}

function setPlugin(id) {
    var q = id;
    var pre = document.createElement('H5');
    //custom style.
    pre.style.maxHeight = "400px";
    pre.style.margin = "0";
    pre.style.padding = "24px";
    //pre.style.whiteSpace = "pre-wrap";
    pre.style.textAlign = "center";
    pre.appendChild(document.createTextNode('Realmente desea cambiar el estado del plugin ' + q));
    alertify.confirm(pre, function() {
        $.ajax({
            type: "POST",
            url: ruta + "/plugins/setPlugin",
            data: "id=" + id,
            "q": q,
            beforeSend: function(objeto) {
                //$("#resultados").html("Mensaje: Cargando...");
            },
            success: function(datos) {
                if (datos == 'true') {
                    $("#Plugins").DataTable().ajax.reload();
                    alertify.success('<h6><i class="fas fa-check"></i> Plugin editado correctamente</h6>');
                } else {
                    alertify.warning('<i class="fas fa-ban"></i>' + datos);
                    console.log(datos);
                }
            }
        });
    }, function() {
        alertify.error('<i class="fas fa-ban"></i> Cencelado');
    })
}