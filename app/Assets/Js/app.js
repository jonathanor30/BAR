var base = document.getElementById("ruta").value;

var app = new Vue({
  el: "#mygtep",
  data: {
    modules: [],
    ruta: base
  },
  methods: {
    modulesList: function() {
      this.$http.get(base + "/Plugins/test").then(
        function(response) {
          return response.body;
        },
        function() {
          alert("Error!");
        }
      );
    },

    enviar: function() {
      this.$http
        .post("data.php", {
          nombre: this.nombre,
          telefono: this.telefono
        })
        .then(function(response) {
          this.modules = response.body;
          this.nombre = "";
          this.telefono = "";
        });
    },

    saludar: function() {
      // `this` dentro de los métodos apunta a la instancia de Vue
      alert("Hola " + this.name + "!");
      // `evento` es el evento DOM nativo
      if (event) {
        alert(event.target.tagName);
      }
    }
  },
  //Cargardor de métodos automaticos
  created: function() {
    this.modulesList();
  }
});

class myGTEP {
  constructor() {
    this.result;
  }
  /**
   * getModules
   * Este método permite obtener mediante un arreglo el listado de módulos
   * @return Array
   */
  getModules()
  {
    var modules = [];
    var result = this.HttpRequest({
      url: base + "/Plugins/listadoPlugin",
      method: 'GET',
     
    }).then(function(data) {
      var array = JSON.parse(data);
      for (let index = 0; index < array.length; index++) {
        const element = array[index];
        modules.push(element);
      }
        }).catch(function(error) {
      console.log(error);
    });

    return modules;
  }

  /**
   * HttpRequest
   * Este método se encarga de gestionar peticiones http
   * @param object
   *
   * url = Url a la cual se realizará la petición
   *
   * method = Tipo de método http para realizar petición.
   *
   * params = Parametros que seran enviado junto a la petición.
   *
   * type_result = Define el formato de datos para la respuesta.
   *
   * async = Define si la petición es Syncrona:false o Asyncrona:true
   *
   */
  HttpRequest(object = {}) {
    //Set request config
    var cotenType = this.SetContentType(object.conten_type) ?? "application/x-www-form-urlencoded";
    return new Promise(function(resolve, reject) {
      var xhr = new XMLHttpRequest();
      xhr.onload = function() {
        resolve(this.responseText);
      };
      xhr.onerror = reject;
        //Validación si se ha definido una url para la petición
        if(object.url == "" || object.url == null || object.url == undefined){
          //Lanzar error
         reject("Advertencia: Debe indicar una ruta para realizar la petición.");
        }else{
          //Validar si se ha definido un método para la petición
          if(object.method =="" || object.method == null || object.method == undefined){
            //Lanzar error
            reject("Advertencia: Debe indicar un tipo de método HTTP para realizar la petición.");
          }else{
             if(object.async == "" || object.async == null || object.async == undefined){
              xhr.open(object.method, object.url);
             }else{
              xhr.open(object.method, object.url, true);
             }
             
          }
        }
     
      //Validar si se hará envio de parametros
      if(object.params != undefined){
        if (object.params.length > 0) {
          xhr.setRequestHeader("Content-Type", cotenType);
          xhr.send(JSON.stringify(object.params));
        } else {
          xhr.send();
        }
      }else{
        xhr.send();
      }
    });
  }

  /**
   * HttpMethodVerified
   * Este método se encarga de validar si el método http definido
   * es valido para realizar peticiones.
   * @param string method:
   * Nombre del método a validar
   * @return bool
   */
  HttpMethodVerified(method) {
    switch (method) {
      case "GET":
        return true;
        break;
      case "POST":
        return true;
        break;
      case "PUT":
        return true;
        break;
      case "DELETE":
        return true;
        break;
      case "HEAD":
        return true;
        break;
      case "CONNECT":
        return true;
        break;
      case "OPTIONS":
        return true;
        break;
      case "TRACE":
        return true;
        break;
      case "PATCH":
        return true;
        break;
      default:
        return false;
    }
  }

  /**
   * SetContenType
   */
    SetContentType(type)
    {
      switch (type) {
        case 'json':
          return "application/json;charset=UTF-8";
          break;
        case 'form':
          return "application/x-www-form-urlencoded";
        default:
          return "application/x-www-form-urlencoded";
          break;
      }
    }
    test(object)
    {/*
      return (
        `<div>
          <img width="100" v-bind:src="image" v-bind:alt="title"/>
          <h2>`+object.element+`</h2>  
         </div>
        `
      );*/
    }


}



var G = new myGTEP();

//console.log(G.test({test:"test"}));
/*
G.HttpRequest({
  url: base + "/Plugins/test",
  method: 'GET',
  async: true,
}).then(function(data) {

    console.log(JSON.parse(data));
    }).catch(function(error) {
  console.log(error);
});
*/