angular.module('app')

.controller('MensajesCtrl', ['$scope', 'Mensajes', 'Mensaje_Tema',function($scope, Mensajes, Mensaje_Tema) {


          Mensajes.get({token:window.localStorage.getItem('user')}).$promise.then(function success(dato) {
              
              Mensaje_Tema.get({token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
                $scope.temas=data.response;
                $scope.mensajes = dato.response;  //obtiene los mensajes de la api rest (de php)

                var j=0;
                for(var i=0;i<$scope.mensajes.length;i++){
                  $scope.mensajes[i].FECHA_MENSAJE = new Date($scope.mensajes[i].FECHA_MENSAJE.replace(/-/g,"/"));
                  $scope.mensajes[i]=angular.extend({}, $scope.mensajes[i], {'TEMAS': []});
                  while(j<$scope.temas.length && $scope.temas[j].ID_MENSAJE==$scope.mensajes[i].ID_MENSAJE){
                      $scope.mensajes[i].TEMAS.push($scope.temas[j].NOMBRE);
                    j++;
                  }

                }
              }, function error(data) {
                //alertify.alert('<b>¡Error!</b>','No se encontraron mensajes');    
              });

              }, function error(dato) {
                alertify.error('<b>No se encontraron mensajes</b>');    
              });

}]);