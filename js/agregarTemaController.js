angular.module('app')

.controller('TemaCtrl', ['$scope', 'Temas', '$location', 'Usuarios', 'CONFIG', 'Tokens', function ($scope, Temas, $location, Usuarios, CONFIG, Tokens) {

    $scope.tema={
        nombre: '',
        activo: 'SI',
        es_filtro: 'NO'
    }

    $scope.filtro = function(result) {
        $scope.tema.es_filtro = result;
    }
    $scope.agregar = function () {
      Usuarios.get({id: window.localStorage.getItem('user_id')+'-',token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
        if(data.response.TIPO=='admin'){
            Temas.get({token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
              $scope.temas=data.response;
              var cont=0;
              for(var i=0;i<$scope.temas.length;i++){
                   if($scope.temas[i].NOMBRE.toLowerCase() == $scope.tema.nombre.toLowerCase()){
                     if($scope.temas[i].ACTIVO=="NO"){
                        $scope.tema={
                          id_tema: $scope.temas[i].ID_TEMA,
                          nombre: $scope.temas[i].NOMBRE,
                          activo: 'SI',
                          es_filtro: $scope.temas[i].ES_FILTRO
                        }
                        Temas.update({id: $scope.tema,token:window.localStorage.getItem('user')}).$promise.then(function (data) {
                            alertify.success('<b>Tema o Filtro agregado correctamente</b>');
                        }, function error(data) {
                            alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Puede ser su conexión a Internet');
                        });
                      }else{
                    alertify.alert('<b>¡Atención!</b>','Este Tema o Filtro ya existe');
                      }

                     cont++;
                     break;
                   }
              }
              if(cont==0){
                 Temas.save({id: $scope.tema, token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
                      alertify.success('<b>Tema o Filtro agregado correctamente</b>');
                    
                  }, function error(data) {
                      alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Puede ser su conexióna Internet');
                  });
              }
                  
            }, function error(data) {
                alertify.error('<b>No se encontraron temas. Puede ser su conexión a Internet</b>');
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
                alertify.alert('<b>¡Error!</b>','Puede ser su conexión a Internet');
                                    
      });
    }
  }]);