angular.module('app')

.controller('AllTemaCtrl', ['$scope', 'Temas', 'Usuarios', '$location','CONFIG', 'Tokens', function($scope, Temas,Usuarios, $location, CONFIG, Tokens){
      
    Temas.get({id: 'activo',token:window.localStorage.getItem('user')}).$promise.then(function success(data) {        
          
          $scope.temas = data.response;  //obtiene los mensajes de la api rest (de php)
        
            
    }, function error(data) {
        alertify.error('<b>No se encontraron temas</b>');
    });

    $scope.eliminar = function (id, nombre,index,filtro) {
    Usuarios.get({id: window.localStorage.getItem('user_id')+'-',token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
        if(data.response.TIPO=='admin'){
            $scope.tema={
                id_tema: id,
                nombre: nombre,
                activo: 'NO',
                es_filtro: filtro
            }
            Temas.update({id: $scope.tema,token:window.localStorage.getItem('user')}).$promise.then(function (data) {
                    $scope.temas.splice(index, 1);
                    alertify.success('<b>Tema eliminado</b>');

            }, function error(data) {
                alertify.alert('<b>¡Error!</b>','Ha ocurrido un error al eliminar el tema');
            });
        }else{
            alertify.alert('<b>Atención</b>', 'Usted no tiene permisos para realizar esta acción. Debe iniciar sesión nuevamente.', function(){ 
              Tokens.delete({id: window.localStorage.getItem('user'),token:CONFIG.KEY_LOGIN}).$promise.then(function success(dato){
                window.localStorage.clear();
                $location.path('login');

                }, function error(dato) {
                  console.log('no se pudo borrar el token');
                          
                }); 
            });
          }
      }, function error(data) {
                alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Puede ser su conexión a Internet');
                                    
      });
    }
    $scope.filtrar = function (id, nombre,filtro) {
    Usuarios.get({id: window.localStorage.getItem('user_id')+'-',token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
        if(data.response.TIPO=='admin'){
          if(filtro=='SI'){
            $scope.tema={
                id_tema: id,
                nombre: nombre,
                activo: 'SI',
                es_filtro: 'NO'
            }
            Temas.update({id: $scope.tema,token:window.localStorage.getItem('user')}).$promise.then(function (data) {
              alertify.success('<b>El Tema ya no es un Filtro. Actualice para ver cambios</b>');

            }, function error(data) {
                alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Actualice la página');
            });
          }else{
            $scope.tema={
                id_tema: id,
                nombre: nombre,
                activo: 'SI',
                es_filtro: 'SI'
            }
            Temas.update({id: $scope.tema,token:window.localStorage.getItem('user')}).$promise.then(function (data) {
              alertify.success('<b>El Tema ahora es un Filtro. Actualice para ver cambios</b>');
            }, function error(data) {
                alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Actualice la página');
            });
          }
        }else{
             alertify.alert('<b>Atención</b>', 'Usted no tiene permisos para realizar esta acción. Debe iniciar sesión nuevamente.', function(){ 
              Tokens.delete({id: window.localStorage.getItem('user'),token:CONFIG.KEY_LOGIN}).$promise.then(function success(dato){
                window.localStorage.clear();
                $location.path('login');

                }, function error(dato) {
                  console.log('no se pudo borrar el token');
                          
                });  
            });
          }
      }, function error(data) {
                alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Puede ser su conexión a Internet');
                                    
      });
    }
    $scope.editar = function (id, nombre,filtro) {
      alertify.defaults.glossary.title = "Edita el nombre del Tema o Filtro";
      Usuarios.get({id: window.localStorage.getItem('user_id')+'-',token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
        if(data.response.TIPO=='admin'){
          $scope.tema={
              id_tema: id,
              nombre: nombre,
              activo: 'SI',
              es_filtro: filtro
          }
          var original=$scope.tema.nombre;
          alertify.prompt( 'Modifica el nombre del tema:', original, function(evt, value) { 
            if(value!="" && value!=original){
              $scope.tema.nombre=value;

              Temas.update({id: $scope.tema,token:window.localStorage.getItem('user')}).$promise.then(function (data) {
                    alertify.success('<b>Has modificado el tema a: "</b>' + value+'<b>". Actualice para ver cambios</b>')
              }, function error(data) {
               alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Puede ser su conexión a Internet');
              });
            }else{
              //alertify.error('Tema sin modificación');
            }
          }, function() { 
            //cancelado 
          });
        }else{

          alertify.alert('<b>Atención</b>', 'Usted no tiene permisos para realizar esta acción. Debe iniciar sesión nuevamente.', function(){ 
            Tokens.delete({id: window.localStorage.getItem('user'),token:CONFIG.KEY_LOGIN}).$promise.then(function success(dato){
                window.localStorage.clear();
                $location.path('login');

                }, function error(dato) {
                  console.log('no se pudo borrar el token');
                          
                });  
          });
        }
      }, function error(data) {
                alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Puede ser su conexión a Internet');
                                    
      });
    }
    
  }]);