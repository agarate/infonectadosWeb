angular.module('app')

.controller('AllAdminCtrl', ['$scope', 'Usuarios', '$location', 'CONFIG', 'Tokens',function($scope, Usuarios, $location, CONFIG, Tokens){
      
    
    Usuarios.get({id: 'admin',token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {        
          
          $scope.admins = data.response;  //obtiene los mensajes de la api rest (de php)
          window.localStorage.setItem('cant',$scope.admins.length);
                    
    }, function error(data) {
       alert('No se encontraron usuarios. Puede ser su conexión a Internet');
    });

    $scope.eliminar = function (id,usuario,index,gcm_regid) {
      if(window.localStorage.getItem('cant')>1){
        Usuarios.get({id: window.localStorage.getItem('user_id')+'-',token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
          if(data.response.TIPO=='admin'){
                $scope.admin={
                        id_usuario: id,
                        usuario: usuario,
                        tipo: 'estu',
                        gcm_regid: gcm_regid
                    }
                    Usuarios.update({id: $scope.admin,token:CONFIG.KEY_LOGIN}).$promise.then(function (data) {
                          $scope.admins.splice(index, 1);
                          window.localStorage.setItem('cant',window.localStorage.getItem('cant')-1);
                          alertify.success('<b>Administrador dado de baja correctamente</b>');
                       }, function error(data) {
                  alertify.alert('<b>¡Error!</b>','Ha ocurrido un error al eliminar el administrador');
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
      }else{
        alertify.alert('<b>¡Atención!</b>','No puede eliminar más administradores');
      }
    }

  }]);