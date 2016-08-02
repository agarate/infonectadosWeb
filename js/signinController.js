angular.module('app')
.controller('SignInCtrl', ['$scope', '$location', '$http','Usuarios', 'md5', 'CONFIG', 'Tokens', function($scope, $location, $http, Usuarios, md5, CONFIG, Tokens) {

      $scope.user={
        user: '',
        pass: '',
        keyapi: CONFIG.KEY_LOGIN
      }

      $scope.signIn = function() {
        var time= new Date();
        var password = md5.createHash($scope.user.pass || '');

          $http({
              method: 'POST',
              url: 'http://inicio.diinf.usach.cl/webservice3.php',
              headers: {'Content-Type': 'application/x-www-form-urlencoded'},

              data: 'user='+$scope.user.user+'&pass='+password+'&keyapi='+$scope.user.keyapi
          }).then(function successCallback(response) {
              if(response.data.pass_ok==true){ //logeado en LDAP
                //busco si existe en la base de datos USUARIOS
                Usuarios.get({id: $scope.user.user,token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
                //si existe, inicia sesion normalmente segun tipo
                var KEY_AUTH = md5.createHash(data.response.USUARIO+time || '');


                  $scope.token={
                    id_usuario: data.response.ID_USUARIO,
                    token: KEY_AUTH
                  }
                  Tokens.save({id: $scope.token,token:CONFIG.KEY_LOGIN}).$promise.then(function success(dato){

                    window.localStorage.setItem("sesion","activa");
                    window.localStorage.setItem("tipo",data.response.TIPO);
                    window.localStorage.setItem("user_id",data.response.ID_USUARIO);
                    window.localStorage.setItem("user",KEY_AUTH);
                    $location.path('home');
                  }, function error(dato) {
                    //HTML DE REGISTRO $location.path('registro')
                    console.log(dato);
                
                  });
                    
                    //si no existe, se abre una pestaña para el registro
                }, function error(data) {
                    //HTML DE REGISTRO $location.path('registro')
                    window.localStorage.setItem("user",$scope.user.user);

                    $location.path('registro');
                
                });
              }else{
                  alertify.alert('<b>¡Error!</b>','Usuario o contraseña incorrecta, inténtelo nuevamente.');
              }
          }, function errorCallback(response) {
              alertify.alert('<b>¡Error de conexión!</b>','Pruebe su conexión a Internet');
          });
        }
  }]);
