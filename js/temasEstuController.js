angular.module('app')

.controller('TemasEstuCtrl', ['$scope', 'Temas', 'Usuario_Tema',function($scope, Temas, Usuario_Tema) {

    var id=window.localStorage.getItem('user_id');

    //MOSTRAR LOS TEMAS
    Temas.get({id: 'activo',token:window.localStorage.getItem('user')}).$promise.then(function success(data) {        
          $scope.temas = data.response;  //obtiene los temas de la api rest (de php)
        
          
          Usuario_Tema.get({id: id+'-', token: window.localStorage.getItem('user')}).$promise.then(function success(data) {        
          
            $scope.temas_usuario = data.response;  //obtiene los temas de la api rest (de php)
            
            for (var i = 0; i <$scope.temas.length; i++) {
              var cont=0;
                for(var j=0; j<$scope.temas_usuario.length;j++){
                      if($scope.temas[i].ID_TEMA==$scope.temas_usuario[j].ID_TEMA){
                        cont++;
                      }

                }
                if(cont==1){

                  $scope.temas[i]=angular.extend({}, $scope.temas[i], {'habilitado': 'true'});
                }else{

                  $scope.temas[i]=angular.extend({}, $scope.temas[i], {'habilitado': 'false'});
                }
            
            }            
          
          }, function error(data) {
              for (var i = 0; i <$scope.temas.length; i++) {

                  $scope.temas[i]=angular.extend({}, $scope.temas[i], {'habilitado': 'false'});
                } 
          });
            
      }, function error(data) {
        alertify.alert('<b>¡Error!</b>','No se encontraron temas. Puede ser su conexión a Internet');
    });

    //ELECCION DE TEMAS
    $scope.habilitar= function(tema){
          if(tema.habilitado=='true'){
            tema.habilitado='false';
          }else{
            tema.habilitado='true';
          }
    }

    $scope.elegir = function() {
            //guarda en un array los temas seleccionados
        $scope.array = [];
        
        angular.forEach($scope.temas, function(tema){
                if (tema.habilitado=='true'){

                 $scope.array.push(tema.ID_TEMA);
               }
        });

        if($scope.array.length>0){ 
          Usuario_Tema.delete({id: id, token: window.localStorage.getItem('user')}).$promise.then(function (data) {
              for(var i=0;i<$scope.array.length;i++){
                      $scope.user_tema={
                        id_usuario: id,
                        id_tema: $scope.array[i]
                          //temas
                      }
                        Usuario_Tema.save({id: $scope.user_tema, token: window.localStorage.getItem('user')}).$promise.then(function success(data) {
                          //console.log('tema guardado');
                        }, function error(data) {

                            alertify.alert('<b>¡Error!</b>','No se han guardado los temas. Puede ser su conexión a Internet');
                                                                    
                        });
                }

              alertify.success('<b>Temas guardados con éxito</b>');
          }, function error(data) {

              for(var i=0;i<$scope.array.length;i++){
                      $scope.user_tema={
                        id_usuario: id,
                        id_tema: $scope.array[i]
                          //temas
                      }
                        Usuario_Tema.save({id: $scope.user_tema, token: window.localStorage.getItem('user')}).$promise.then(function success(data) {
                          //console.log('tema guardado');
                        }, function error(data) {

                            alertify.alert('<b>¡Error!</b>','No se han guardado los temas. Puede ser su conexión a Internet');
                                                                    
                        });
                }
              alertify.success('<b>Temas guardados con éxito</b>');
          });                 
        
        }else{
                alertify.alert('<b>¡Atención!</b>','Debe seleccionar algún Tema o Filtro');
        }
    }
}]);