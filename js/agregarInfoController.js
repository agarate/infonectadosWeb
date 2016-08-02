 angular.module('app')

.controller('InsertarCtrl', ['$scope','$location', 'Usuarios', 'Temas', 'Usuario_Tema', 'productService', 'CONFIG', 'Tokens', 'servicioMensajes',function ($scope, $location, Usuarios, Temas, Usuario_Tema,productService, CONFIG, Tokens, servicioMensajes) {
    
    Temas.get({id: 'activo',token:window.localStorage.getItem('user')}).$promise.then(function success(data) {        
          $scope.temas = data.response;  //obtiene los mensajes de la api rest (de php)
          for (var i = 0; i <$scope.temas.length; i++) {

                  $scope.temas[i]=angular.extend({}, $scope.temas[i], {'habilitado': 'false'});
                } 
    }, function error(data) {
       alertify.alert('<b>¡Error!</b>','No se encontraron temas. Puede ser su conexión a Internet');
    });


    $scope.mensaje = {
      id_usuario: "",
      titulo: "",
      contenido: ""
    };

    $scope.habilitar= function(tema){
          if(tema.habilitado=='true'){
            tema.habilitado='false';
          }else{
            tema.habilitado='true';
          }
    }
  $scope.guardar = function (titulo,contenido) {
      $scope.mensaje.id_usuario=window.localStorage.getItem("user_id");
      $scope.array = [];
      
      angular.forEach($scope.temas, function(tema){
                if (tema.habilitado=='true'){

                 $scope.array.push(tema.ID_TEMA);
               }
               
      })

      Usuarios.get({id: window.localStorage.getItem('user_id')+'-',token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
          
          if(data.response.TIPO=='admin'){

              if($scope.array.length>0){

                var usuarios_temas=[]; //id de los usuarios que tienen los filtros del mensaje
                var k=0;
                for(var i=0;i<$scope.array.length;i++){
                  
                  Usuario_Tema.get({id: $scope.array[i], token: window.localStorage.getItem('user')}).$promise.then(function success(data) {
                    $scope.users=data.response;
                    for(var j=0;j< $scope.users.length;j++){
                          usuarios_temas.push($scope.users[j].ID_USUARIO);
                          
                      }
                      productService.addProduct(1);
                      k=productService.getProducts().length;
                      if(k==$scope.array.length){
                      
                        servicioMensajes.enviarMensaje(usuarios_temas, $scope.array, $scope.mensaje, contenido, titulo);
                      
                      }
                  }, function error(data) {
                      productService.addProduct(1);
                      k=productService.getProducts().length;
                      if(k==$scope.array.length){
                        
                        servicioMensajes.enviarMensaje(usuarios_temas, $scope.array, $scope.mensaje, contenido, titulo);
                        
                      }
                      //no se encuentra el tema
                  });
                }

              }else{
                alertify.alert('<b>¡Atención!</b>','Debe elegir algún Tema o Filtro');
              }
          
    //ES ADMINISTRADOR

          }else{
            // NO ES ADMIN
            alertify.alert('<b>¡Atención!</b>', 'Usted no tiene permisos para realizar esta acción. Debe iniciar sesión nuevamente.', function(){ 
              Tokens.delete({id: window.localStorage.getItem('user'),token:CONFIG.KEY_LOGIN}).$promise.then(function success(dato){
                window.localStorage.clear();
                $location.path('login');

                }, function error(dato) {
                  //console.log('no se pudo borrar el token');
                          
                }); ; 
            });
          }
 
        }, function error(data) {
          alertify.alert('<b>¡Error!</b>','Puede ser su conexión a Internet');
                                      
      });
    }
  
  }]);