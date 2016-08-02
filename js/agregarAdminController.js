angular.module('app')

.controller('AdminCtrl', ['$scope', 'Usuarios', '$location', 'CONFIG', 'Tokens',function ($scope, Usuarios, $location, CONFIG, Tokens) {

    $scope.admin={
        usuario: '',
        tipo: 'admin',
        gcm_regid: 'NO'
    }

    $scope.agregar = function () {
      Usuarios.get({id: window.localStorage.getItem('user_id')+'-',token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {

        if(data.response.TIPO=='admin'){
              Usuarios.get({id: $scope.admin.usuario,token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
                      //el administrador ya existe

                      if(data.response.TIPO=="estu"){
                        $scope.admin={
                            id_usuario: data.response.ID_USUARIO,
                            usuario: data.response.USUARIO,
                            tipo: 'admin',
                            gcm_regid: data.response.GCM_REGID
                        }
                        Usuarios.update({id: $scope.admin,token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
                            angular.copy({}, $scope.admin);
                            alertify.success('<b>Nuevo administrador asignado</b>');
                          
                        }, function error(data) {
                            angular.copy({}, $scope.admin);
                            alertify.alert('<b>¡Error!</b>','No se ha podido asignar al nuevo administrador');
                        });
                      }else{
                        angular.copy({}, $scope.admin);
                            alertify.alert('<b>¡Atención!</b>','Ya existe este administrador');
                      }

             }, function error(data) {
                $scope.admin.tipo='admin';
                $scope.admin.gcm_regid='NO';
                Usuarios.save({id: $scope.admin,token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
                    angular.copy({}, $scope.admin);
                    alertify.success('<b>Nuevo administrador agregado</b>');
                  
                }, function error(data) {
                    alertify.alert('<b>¡Error!</b>','Puede ser su conexión a Internet');

                });
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