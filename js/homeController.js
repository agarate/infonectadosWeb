angular.module('app')

.controller('HomeCtrl', ['$scope','$location', 'Mensajes', 'Mensaje_Tema', 'Tokens', 'CONFIG', 'md5',function($scope, $location, Mensajes, Mensaje_Tema, Tokens, CONFIG,md5) {
    var user_id=window.localStorage.getItem('user_id');
    $scope.salir= function(){

        Tokens.delete({id: window.localStorage.getItem('user'),token:CONFIG.KEY_LOGIN}).$promise.then(function success(dato){
                window.localStorage.clear();
                $location.path('login');

        }, function error(dato) {
          console.log('no se pudo borrar el token');
                  
        });    
    }
    $scope.nombre='informaciones';
    $scope.vista= function(vista){
      $scope.nombre=vista;

    }
    $scope.tipo=window.localStorage.getItem('tipo');

}]);