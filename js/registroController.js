angular.module('app')

.controller('RegistrarCtrl', ['$scope','$location', 'Usuarios', 'Usuario_Tema', 'md5', 'CONFIG','Tokens', function($scope, $location, Usuarios, Usuario_Tema, md5, CONFIG, Tokens) {
        
    var nom_user=window.localStorage.getItem("user");

    $scope.usuario={
        usuario: nom_user,
        tipo: 'estu',
        gcm_regid: 'NO'
      //temas
    }

      $scope.ob = function(result) {
        $scope.array = [];
              $scope.array.push(result); 
      }
      $scope.ob2 = function(result2) {
        $scope.array2 = [];
              $scope.array2.push(result2); 
      }
    $scope.Registrar = function() {
      var filtros=$scope.array.concat($scope.array2);
    //guarda en un array los temas seleccionados       
 
      //se registra al usuario
      Usuarios.save({id: $scope.usuario,token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
                      //si se guardo bien, lo busco para saber su id y guardar los temas
                        var id=data.response;
                        var time=new Date();
                        window.localStorage.setItem("user",md5.createHash(window.localStorage.getItem("user")+time || ''));
                        var token_user=window.localStorage.getItem("user");
                        $scope.token={
                              id_usuario: id,
                              token: token_user
                        }
                        
                        Tokens.save({id: $scope.token,token:CONFIG.KEY_LOGIN}).$promise.then(function success(dato){

                            for(var i=0;i<filtros.length;i++){
                              $scope.user_tema={
                                    id_usuario: id,
                                    id_tema: filtros[i]
                                            //temas
                              }
                              //REPETIR esto por la cantidad de temas que elija (se supone que son 2)
                              Usuario_Tema.save({id: $scope.user_tema, token: window.localStorage.getItem('user')}).$promise.then(function success(data) {
                                //filtros guardados exitosamente
                              
                              }, function error(data) {
                                alertify.error('<b>No se han guardado los temas o filtros. Puede ser su conexión a Internet</b>');
                                                          
                              });
                            }
                            if(i==filtros.length){
                                window.localStorage.setItem("sesion","activa");
                                window.localStorage.setItem("tipo",$scope.usuario.tipo);
                                window.localStorage.setItem("user_id",id);
                                $location.path('home');
                            }
                        }, function error(dato) {
                    //HTML DE REGISTRO $location.path('registro')
                            console.log(dato);
                
                        });

      }, function error(data) {

            alertify.alert('<b>¡Error!</b>','No se ha podido registrarse. Puede ser su conexión a Internet');
            
      });
    }
}]);
