 angular.module('app')
 .service('productService', function() {
    var productList = [];

    var addProduct = function(newObj) {
        productList.push(newObj);
    };

    var getProducts = function(){
        return productList;
    };
    var vaciar = function(){
        productList=[];
    };
    return {
      addProduct: addProduct,
      getProducts: getProducts,
      vaciar: vaciar
    };

  })
 .service('servicioMensajes',['Mensajes','$http','CONFIG','productService','Mensaje_Tema', 'Usuarios', function(Mensajes, $http, CONFIG, productService, Mensaje_Tema, Usuarios) {

  var enviarMensaje = function(usuarios_temas, cantidad, mensaje, contenido, titulo) {
        var temas_usuario=usuarios_temas.count_value();
        var array_usuarios=[];
        productService.vaciar();

        for (var i in temas_usuario) {
                                //si el usuario tiene la misma cantidad de filtros que el mensaje pide, entonces se guarda
          if(temas_usuario[i]==cantidad.length){
            array_usuarios.push(i);
                                  
          } 
        }
                        
        Mensajes.save({id:mensaje,token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
          Mensajes.get({token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
            for(var i=0;i<data.response.length;i++){
                              
                  if(i==data.response.length-1){
                    var id=data.response[i].ID_MENSAJE;
                  }
              }                   

            for(var i=0;i<cantidad.length;i++){
                var mensaje_tema={
                id_mensaje: id,
                id_tema: cantidad[i]
                                  //temas
              }
              Mensaje_Tema.save({id: mensaje_tema,token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
                //console.log('tema guardado');
              }, function error(data) {

                 alertify.alert('<b>¡Error!</b>','No se han guardado los temas. Puede ser su conexión a Internet');
                                                                            
              });
          }

          if(i==cantidad.length){
 
            if(array_usuarios.length>0 ){
              alertify.alert('<b>¡Listo!</b>','Información enviada con éxito');

              Usuarios.get({id:"congcm",token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
                        var ids=[];       
                        for (var i=0;i<array_usuarios.length;i++){
                          for(var j=0;j< data.response.length;j++){
                              if(array_usuarios[i]==data.response[j].ID_USUARIO){
                                    ids.push(data.response[j].GCM_REGID);
                                    break;
                              }
                          }
                          //guarda los ids en un array 
                        }
                        var msg = {
                          'message': contenido,
                           'title': titulo,
                           'vibrate': 1,
                          'sound': 1
                         };
                         var datos={
                           'ids': ids, //ids contiene todos los id de los dispositivos a enviar
                          'mensaje': msg
                         };
                      if(ids.length>0){
                          $http({
                            method: 'POST',
                            url: CONFIG.URL_SERVIDOR+'/pruebapush',
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'},

                             data: {data: datos}
                          }).then(function successCallback(response) {

                            console.log(response);
                          }, function errorCallback(response) {

                            console.log(response);
                          });
                      }
                    }, function error(data) {

                    //console.log('No hay usuarios que tengan notificaciones activadas');
                    });
                  }else{
                                //console.log(' no se manda notificacion pues no hay usuarios que cumplan los temas');
                    alertify.alert('<b>¡Listo!</b>','Información enviada con éxito');

                    }
                  }
                  angular.copy({}, mensaje);
          }, function error(data) {

              alertify.alert('<b>¡Error!</b>','No se encontró el mensaje. Puede ser su conexión a Internet');
          });
        }, function error(data) {

             alertify.alert('<b>¡Error!</b>','No pudo enviarse el mensaje. Puede ser su conexión a Internet');
        });
    };
      Array.prototype.count_value = function(){
        var count = {};
        for(var i = 0; i < this.length; i++){
        if(!(this[i] in count))count[this[i]] = 0;
        count[this[i]]++;
        }
        return count;
      };
  return {
      enviarMensaje: enviarMensaje
    };
  
}]);