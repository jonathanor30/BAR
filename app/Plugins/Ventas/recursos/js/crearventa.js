var ruta = document.getElementById("ruta").value;

var contador = Array();
// se ejecuta automaticamente la funcion de obtener tipo producto
window.onload=Autoload();

function Autoload(){
  var p;
  /*
  ObtenerTipoDeNovedad();
  */
 
 ObtenerClientes() ;
  iniciar();

}
/*
 document.getElementById("BuscaProducto").addEventListener("keyup", function (e) {
  e.preventDefault();
  $.ajax({
    type: "GET",
    url: ruta + "/Compras/AutoCompletarProducto/NombreProducto",
    data: `term=${this.value}`,
    success: function(datos) {
      console.log(datos);
    }
  });

});
 */
  $(document).ready(function () {
  $("#BuscaProducto").autocomplete({
      source: ruta + "../Compras/AutoCompletarProducto/NombreProducto",
      minLength: 2,
      select: function (event, ui) {
        event.preventDefault();
         document.getElementById("IdTipoProducto").value = ui.item.IdProducto;
         document.getElementById("BuscaProducto").value = ui.item.NombreProducto+" "+ui.item.Marca;
         document.getElementById("nombrep").value = ui.item.NombreProducto;
         document.getElementById("marcap").value = ui.item.Marca;
         document.getElementById("precio").value = ui.item.PrecioSugerido;
      }
  });
});
$("#BuscaProducto").on("keydown", function (event) {
  if (
      event.keyCode == $.ui.keyCode.DELETE ||
      event.keyCode == $.ui.keyCode.BACKSPACE
  ) {
    document.getElementById("IdTipoProducto").value = "";
    document.getElementById("BuscaProducto").value = "";
    document.getElementById("nombrep").value ="";
    document.getElementById("marcap").value = "";
    document.getElementById("precio").value = "";
  }
});
$("#datos_factura").submit(function(event) {
  $("#btnsaveinvprov").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: ruta + "/Ventas/SaveinvProv",
    data: parametros,
  
    success: function(datos) {
      var result = datos.split("-");
      console.log(result);
      if (result[0] == "") {
        if (contador.length == 0) {
          $("#datos_factura")[0].reset();
          //$("#resultados_ajax").html('<span></span>');
          $("#btnsaveinvprov").attr("disabled", true);
          alertify.success(
            '<h6><i class="fas fa-check"></i> Factura agregada correctamente</h6>'
          );
          //Para ir a factura detallada
          setTimeout(function() {
            location.href =
              ruta + "/Ventas";
          }, 1000);
        } else {
          alertify.warning(
            "No se puede guardar la factura sin bloquear las lineas"
          );
          $("#btnsaveinvprov").attr("disabled", false);
        }
      } else {
        //$("#resultados_ajax").html('<span></span>');
        $("#btnsaveinvprov").attr("disabled", false);
        alertify.warning(
          result[0]
        );
      }
    }
  });
  event.preventDefault();
});


function ObtenerClientes() {
  $.ajax({
    url: ruta + `../Ventas/ObtenerClientes`,
    type: "POST",
    contentType: false,
    cache: false,
    processData: false,
    success: function (resultado) {
      var x = document.getElementById("IdCliente");
      //Acá estamos pintando los tipos de productos
      for (var r in resultado) {
    var option = document.createElement("option");
    
    option.text = resultado[r].Nombre;
    option.value = resultado[r].IdCliente;
        
        x.add(option);
      }
      //Definimos el tipo de producto actual

    },
  });

  
}




function iniciar() {
  var iniciar;
 iniciar = document.getElementById('IdTipoProducto');
 iniciar.addEventListener("click",ObtenerPrecio);
}

function validarstock(id, cantidad) {
  var autorizador;
  $.ajax({
    beforesend: function(){
     
    },
    async:false,
    url: ruta + `/Compras/validarstocks`,
    type: "GET",
    data:`IdProducto=${id}&cantidad=${cantidad}`,
    success: function (resultado) {
        if(resultado == "true"){
            autorizador =true;
        }else{
           autorizador =false;
        }
    },
  });
    return autorizador;
}

function ObtenerPrecio() {

  var valorproducto;
  valorproducto = document.getElementById('IdTipoProducto').value;
  $.ajax({
    beforesend: function(){
     
    },
    url: ruta + `/Compras/ObtenerPrecios`,
    type: "POST",
    data:{producto:valorproducto},

    success: function (resultado) {
      //Acá estamos pintando los tipos de productos

  
   for (var r in resultado) {
    document.getElementById("precio").value=resultado[r].PrecioSugerido;
    document.getElementById("nombrep").value=resultado[r].NombreProducto;
    document.getElementById("marcap").value=resultado[r].Nombre;
      }
      
      //Definimos el tipo de producto actual

    },
  });
}
function validaritem()
{
  var IdTipoProducto = document.getElementById("IdTipoProducto").value;
  var nombre_producto = document.getElementById("nombrep").value;
  var marca_producto = document.getElementById("marcap").value;
  var precio = document.getElementById("precio").value;
  var cantidad = document.getElementById("Cantidad").value;
  var tasa_iva = document.getElementById("iva").value;
  if (nombre_producto != "" && cantidad != "") {
  if(isNaN(cantidad))
  {
    alertify.warning("La cantidad solo admiten caracteres numericos");
  }else
  {
    if(isNaN(tasa_iva))
    {
      alertify.warning("El iva solo admiten caracteres numericos");
    }else
    {
      if(cantidad <= 0)
      {
        alertify.warning("La cantidad no puede contener numeros negativos ni estar en 0")
      }
      else
      {
        if(tasa_iva < 0)
        {
          alertify.warning("El iva no puede contener numeros negativos");
        }else
        {
          if(!validarstock(IdTipoProducto, cantidad))
          {
            alertify.warning("la cantidad supera el Stock máximo");
          }
          else{
            agregaritem();
          
           }
        }
      }
    }
  }
}else {
  alertify.warning("Las lineas a agregar no deben estar vacias");
}
}


function agregaritem() {
  
  var ultimo = document.getElementsByName("numero_item[]");
  var numero_item = ultimo.length + 1;
  var InputsPrincipales = ["IdTipoProducto", "BuscaProducto", "nombrep","marcap" ,"precio", "Cantidad", "iva"];
  //Valores qe se van a gregar a linea
  var IdTipoProducto = document.getElementById("IdTipoProducto").value;
  var nombre_producto = document.getElementById("nombrep").value;
  var marca_producto = document.getElementById("marcap").value;
  var precio = document.getElementById("precio").value;
  var cantidad = document.getElementById("Cantidad").value;
  var tasa_iva = document.getElementById("iva").value;


  
    
    var subtotal = cantidad * precio;
    var iva = (subtotal*tasa_iva)/100;
    var total = subtotal + iva;
    var neto = subtotal;

    var table = document.getElementById("TableBody");
    var row = table.insertRow(-1);
    
    row.setAttribute("id", numero_item);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
    var cell9 = row.insertCell(8);
    var cell10 = row.insertCell(9);
    cell1.innerHTML =
      "<input hidden class='form-control input-sm numero_item'  type='text' name='numero_item[]' readonly value='" +
      numero_item +
      "'  required>";
      cell2.innerHTML =
      "<input type='text' step='any' class='form-control form-control-sm IdTipoProducto' name='IdTipoProducto[]' value='" +
      IdTipoProducto +
      "' readonly='' required=''>";
    cell3.innerHTML =
    "<input type='text' step='any' class='form-control form-control-sm nombre_producto' name='nombre_producto[]' value='" +
    nombre_producto +
    "' readonly='' required=''>";
      cell4.innerHTML =
      "<input type='text' step='any' class='form-control form-control-sm marca_producto' name='marca_producto[]' value='" +
      marca_producto +
      "' readonly='' required=''>";
    cell5.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm cantidad' name='cantidad[]' value='" +
      cantidad +
      "' readonly='' required=''>";
    cell6.innerHTML =
    "<input type='number' step='any' class='form-control form-control-sm precio' name='precio[]' value='" +
    parseFloat(precio).toFixed(2) +
    "' readonly='' required=''>";
    cell7.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm neto' name='neto[]' value='" +
      parseFloat(neto).toFixed(2) +
      "' readonly='' required=''>";
    cell8.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm iva' name='iva[]' value='" +
      parseFloat(iva).toFixed(2) +
      "' readonly='' required=''>";
    cell9.innerHTML =
      "<input type='number' step='any' class='form-control form-control-sm total' name='total[]' value='" +
      parseFloat(total).toFixed(2) +
      "' readonly='' required=''>";
    cell10.innerHTML =
      "<div class='btn-group'><button class='btn btn-warning edit btn-sm' title='Editar linea' type='button'><i class='fas fa-edit log'></i></button><button class='btn btn-danger btn-sm del' type='button' title='Delete' onclick='deleteRow(" +
      numero_item +
      "," +
      parseFloat(total).toFixed(2) +
      ");'><i class='fas fa-trash '></i></button></div>";
   

    //Reset formulario

    document.getElementById("Cantidad").value = "1";
    for (let i = 0; i < InputsPrincipales.length; i++) {
       document.getElementById(InputsPrincipales[i]).value = "";
    }
    document.getElementById("IdTipoProducto").focus();

    calculator(total);

 
}

function deleteRow(r, valor) {
  var opcion = confirm("¿Realmente desea eliminar esta linea?");
  if (opcion == true) {
    document.getElementById("TableBody").deleteRow(r - 1);
    total = document.getElementById("sumAll").value;
    totalResta = Number(total) - Number(valor);
    var c = 1;
    $(".del").each(function() {
      var attr = $(this).attr("onclick");
      attr = attr.split(",");
      attr = attr[1];
      attr = attr.replace(");", "");
      console.log(attr);
      $(this).attr("onclick", "deleteRow(" + c + "," + attr + ");");
      c++;
    });
    calcular(true);
  }
}
function ValidadorId(id, cantidad_extra = false) {
  var elementos = document.getElementsByClassName("IdTipoProducto")
  var contador = 0;
  if(elementos.length > 0){
      for (let i = 0; i < elementos.length; i++) {
          if(elementos[i].value = id && cantidad_extra != false){
            elementos[i].parentNode.parentNode.cells[4].childNodes[0].value  = (Number(elementos[i].parentNode.parentNode.cells[4].childNodes[0].value)+ Number(cantidad_extra));
              contador++;
              return true;
              break;
          }else if(elementos[i].value = id) {
            contador++;
            return true;
            break;
          }
      }
      if(contador == 0){
        return false;
      }
  }

}
function calcular(type = false) {
  var ultimo = document.getElementsByName("numero_item[]");
  var numero_item = ultimo.length;
  if (numero_item == 0) {
    $("#sumAll").val(0);
    document.getElementById("sumViewTotal").value = 0;
  } else {
    var add = 0;
    $(".total").each(function() {
      if (!isNaN($(this).val())) {
        add += Number($(this).val());
      }
    });

    $("#sumAll").val(add);
    if (type == true) {
      document.getElementById("sumViewTotal").value = formatNumber.new(
        add,
        "$"
      );
    }
  }
}

function calculator(total) {
  //Total
  totalActual = document.getElementById("sumAll").value;
  totalFinal = Number(totalActual) + Number(total);
  $("#sumAll").val("");
  $("#sumAll").val(parseFloat(totalFinal).toFixed(2));
  document.getElementById("sumViewTotal").value = "";
  document.getElementById("sumViewTotal").value = formatNumber.new(
    totalFinal,
    "$"
  );
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

$(document).on("click", ".edit", function() {
  var $row = $(this).closest("tr");
  var doEdit = !$row.hasClass("edit-mode");
  toggleRowEdit($row, doEdit);
});

function toggleRowEdit($row, doEdit) {
  $row.toggleClass("edit-mode", doEdit);
  $row
    .find(".cantidad,.iva")
    .prop("readOnly", !doEdit);
  if (doEdit) {
    $row.find(".iva").val(($row.find(".iva").val()/ $row.find(".precio").val())*100);
    $row.find(".nombre_producto").attr("placeholder", "%...");
    $row.find(".marca_producto").attr("placeholder", "%...");
    $row.find(".iva").attr("placeholder", "%...");
    alertify.success("Linea desbloqueada");
  }
  contador.push(1);
  $row.find(".edit").val(doEdit ? "Save" : "Edit");
  $row.find(".edit").attr("class", "btn btn-success edit btn-sm");
  $row.find(".log").attr("class", "fas fa-check log");

  if (doEdit) {
    if (contador.length == 1) {
      $row
        .find(".nombre_producto")
        .focus()
        .select();
    } else {
      $row
        .find(".nombre_producto")
        .focus()
        .select();
    }
  } else {
    //alertify.success("Linea bloqueada.");
    $row.find(".edit").attr("class", "btn btn-warning edit btn-sm");
    $row.find(".log").attr("class", "fas fa-edit log");
    var cant = $row.find(".cantidad").val();
    var price = $row.find(".precio").val();
    var sub = $row.find(".subtotal").val();
    var iva = $row.find(".iva").val();

    var subtotal = cant * price;
    var ivac = (subtotal * iva) / 100;
    var total = subtotal + ivac;
    var neto = cant * price;

    $row
      .find(".del")
      .attr("onclick", "deleteRow(" + $row[0].id + "," + total + ");");
/*
    $row.find(".nombre_producto").val(art);
    */
    $row.find(".cantidad").val(cant);
    $row.find(".precio").val(parseFloat(price).toFixed(2));
    $row.find(".neto").val(parseFloat(neto).toFixed(2));
    $row.find(".iva").val(parseFloat(ivac).toFixed(2));
    $row.find(".total").val(parseFloat(total).toFixed(2));
    calcular(true);
    alertify.success("Linea bloqueada");
    contador = Array();
    console.log(contador);
  }
}

