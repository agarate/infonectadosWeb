angular.module('app')

.controller('MyinfoCtrl', ['$scope','Usuario_Tema', 'Mensaje_Tema',function($scope, Usuario_Tema, Mensaje_Tema) {
      

      var id=window.localStorage.getItem('user_id');
      
      Usuario_Tema.get({id: id+'w', token: window.localStorage.getItem('user')}).$promise.then(function success(data) {

          $scope.mensajes_estudiante=data.response; 

          $scope.mensajes_estu=[];
          var j=0,i=0;
          while(i<$scope.mensajes_estudiante.length){
            $scope.mensajes_estudiante[i].FECHA_MENSAJE = new Date($scope.mensajes_estudiante[i].FECHA_MENSAJE.replace(/-/g,"/"));

              $scope.mensajes_estudiante[i]=angular.extend({}, $scope.mensajes_estudiante[i], {'TEMAS': []});
              while(j<$scope.mensajes_estudiante.length && 
                $scope.mensajes_estudiante[i].ID_MENSAJE==$scope.mensajes_estudiante[j].ID_MENSAJE){
                  $scope.mensajes_estudiante[i].TEMAS.push($scope.mensajes_estudiante[j].NOMBRE);
                  j++;
              }
              $scope.mensajes_estu.push({ID_MENSAJE: $scope.mensajes_estudiante[i].ID_MENSAJE,
                                        USUARIO:$scope.mensajes_estudiante[i].USUARIO,
                                        TITULO:$scope.mensajes_estudiante[i].TITULO,
                                        FECHA_MENSAJE:$scope.mensajes_estudiante[i].FECHA_MENSAJE,
                                        TEMAS:$scope.mensajes_estudiante[i].TEMAS,
                                        CONTENIDO:$scope.mensajes_estudiante[i].CONTENIDO});
              i=j;

          }        
              
      }, function error(data) {

         alertify.error('<b>No se encontraron mensajes para usted</b>');
      });
     
}]);