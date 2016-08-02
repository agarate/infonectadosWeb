 angular.module('app')
 .controller('PreguntasCtrl', ['$scope', 'Preguntas', 'Usuarios', 'Preguntas_Voto','$location', 'CONFIG', 'Tokens', function($scope, Preguntas, Usuarios, Preguntas_Voto,$location, CONFIG, Tokens){
  	
    var user_id=window.localStorage.getItem('user_id');


    Preguntas.get({token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
        $scope.preguntas = data.response;  //obtiene los mensajes de la api rest (de php)

        for(var i=0;i<$scope.preguntas.length;i++){
          $scope.preguntas[i].FECHA_PREGUNTA = new Date($scope.preguntas[i].FECHA_PREGUNTA.replace(/-/g,"/"));
        }
            Preguntas_Voto.get({id: user_id,token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
                  $scope.votado=data.response;

                  for(var i=0;i<$scope.preguntas.length;i++){
                      for(var j=0;j<$scope.votado.length;j++){
                          if($scope.preguntas[i].ID_PREGUNTA==$scope.votado[j].ID_PREGUNTA){
                            $scope.preguntas[i]=angular.extend({}, $scope.preguntas[i], {'VOTADO': '#0c54aa'});
                            break;
                          }else{
                          $scope.preguntas[i]=angular.extend({}, $scope.preguntas[i], {'VOTADO': 'gray'});
                          }
                      }
                    }
                  }, function error(data) {
                          
                });
              
            }, function error(data) {
              alertify.error('<b>No se encontraron preguntas.</b>');
              
    });

    $scope.votar = function(id_pregunta,index,votos) {

      $scope.pregunta_voto={
        id_usuario: user_id,
        id_pregunta: id_pregunta
      }
      Preguntas_Voto.get({id: user_id,token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
             var contador_voto=0;
             for(var i=0; i<data.response.length;i++){

                if(data.response[i].ID_PREGUNTA==id_pregunta){
                    contador_voto++;
                    var id_pregunta_voto=data.response[i].ID_VOTO;
                    break;
                }

             }

             if(contador_voto==1){  //si existe, entonces ya votó y se elimina
              Preguntas_Voto.delete({id: id_pregunta_voto,token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
                          $scope.preguntas[$scope.preguntas.indexOf(index)].VOTOS-=1;
                          $scope.preguntas[$scope.preguntas.indexOf(index)].VOTADO='gray';


                }, function error(data) {

                alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Puede ser su conexión a Internet');
                                                                          
                });
                
             }else{ // si no existe, entonces no ha votado y se agrega el voto 
                Preguntas_Voto.save({id: $scope.pregunta_voto,token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
                                if(votos==0){
                                  $scope.preguntas[$scope.preguntas.indexOf(index)].VOTOS=1;
                                  $scope.preguntas[$scope.preguntas.indexOf(index)].VOTADO='#0c54aa';

                                }else{
                                  votos++;
                                  $scope.preguntas[$scope.preguntas.indexOf(index)].VOTOS=votos;
                                  $scope.preguntas[$scope.preguntas.indexOf(index)].VOTADO='#0c54aa';
                                }

                }, function error(data) {

                alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Puede ser su conexión a Internet');
                                                                          
                });
             }
        
      }, function error(data) {

          Preguntas_Voto.save({id: $scope.pregunta_voto,token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
                          if(votos==0){
                                  $scope.preguntas[$scope.preguntas.indexOf(index)].VOTOS=1;
                                  $scope.preguntas[$scope.preguntas.indexOf(index)].VOTADO='#0c54aa';
                          }else{
                            votos++;
                                  $scope.preguntas[$scope.preguntas.indexOf(index)].VOTOS=votos;
                                  $scope.preguntas[$scope.preguntas.indexOf(index)].VOTADO='#0c54aa';
                          }

          }, function error(data) {

          alertify.alert('<b>¡Error!</b>','Ha ocurrido un error. Puede ser su conexión a Internet');
                                                                    
          });
      });
    }
    $scope.responder = function (id, id_usuario, enunciado, importancia,tema,res, votos) {
      Usuarios.get({id: user_id+'-',token:CONFIG.KEY_LOGIN}).$promise.then(function success(data) {
        
        if(data.response.TIPO=='admin'){
            $scope.pregunta = {
              id_pregunta: id,
              id_usuario: id_usuario,
              enunciado: enunciado,
              importancia: importancia,
              tema: tema,
              respuesta: res,
              votos: votos
            };
            Preguntas.update({id: $scope.pregunta, token:window.localStorage.getItem('user')}).$promise.then(function success(data) {
                alertify.success('<b>Pregunta respondida</b>');
              
            }, function error(data) {
                alertify.error('<b>Debe cambiar el contenido de la respuesta.</b>');
            });
          }else{
            alertify.alert('<b>Atención</b>', 'Usted no tiene permisos para realizar esta acción. Debe iniciar sesión nuevamente.', function(){ 
              Tokens.delete({id: window.localStorage.getItem('user'),token:CONFIG.KEY_LOGIN}).$promise.then(function success(dato){
                window.localStorage.clear();
                $location.path('login');

                }, function error(dato) {
                  //console.log('no se pudo borrar el token');
                          
                }); 
            });
          }
      }, function error(data) {
            alertify.alert('<b>¡Error!</b>','Ha ocurido un error. Puede ser su conexión a Internet');
                                    
      });

    }
    
}]);
