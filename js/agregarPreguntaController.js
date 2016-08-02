 angular.module('app')

 // AGREGA UNA NUEVA PREGUNTA
  .controller('AddPreguntasCtrl', ['$scope', 'Preguntas', 'Temas', function ($scope, Preguntas, Temas) {
    

    Temas.get({id: 'activo',token:window.localStorage.getItem('user')}).$promise.then(function success(data) {        
          
          $scope.temas = data.response;  //obtiene los mensajes de la api rest (de php)
                    
    }, function error(data) {
       alertify.alert('<b>¡Error!</b>','No se encontraron temas. Puede ser su conexión a Internet');
    });
    $scope.pregunta = {
      id_usuario: window.localStorage.getItem("user_id"),
      enunciado: "",
      importancia: "Normal",
      tema: "Suspensión de clases",
      respuesta: "",
      votos: 0
    };
    

    $scope.preguntar = function () {

      Preguntas.save({id: $scope.pregunta, token:window.localStorage.getItem('user')}).$promise.then(function (data) {
        
              $scope.pregunta.enunciado="";
              alertify.alert('<b>¡Listo!</b>','Pregunta realizada con éxito.');
      }, function error(data) {

          alertify.alert('<b>¡Error!</b>','Ha ocurido un error. Puede ser su conexión a Internet');
      });
    }
  }]);