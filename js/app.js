angular.module('app', ['ngRoute','ngResource','angular-md5'])
 
//configuramos las rutas del blog
//resolve lo utilizamos para comprobar si tiene o no acceso a esa zona
.constant('CONFIG', {
 URL_SERVIDOR: "http://localhost/appweb/index.php",
 KEY_LOGIN: '00e84c40ad7782afbc261ac068016a54'
})
.run(function($rootScope, $location){

  $rootScope.$on('$routeChangeStart', function(event, next, current){

      if(window.localStorage.getItem('sesion')=='activa'){
        if(next.templateUrl =='templates/login.html' || next.templateUrl =='templates/registro.html'){
          $location.path('home');

        }
      }else{
        if(window.localStorage.getItem('user')==null){
          if(next.templateUrl =='templates/registro.html' || next.templateUrl =='templates/home.html'){
            $location.path('login');

          }
        }else{
          if(window.localStorage.getItem('sesion')==null){
            if(next.templateUrl =='templates/home.html'){
              $location.path('login');

            }
          }
        }
        
      }

  })
})
.config(function($routeProvider)
{

    $routeProvider
    .when("/login", 
    {
        templateUrl : "templates/login.html",
        controller : "SignInCtrl"
        
    })
    .when("/home", 
    {
        templateUrl : "templates/home.html",
        controller : "HomeCtrl"
    })
    .when("/registro", 
    {
        templateUrl : "templates/registro.html",
        controller : "RegistrarCtrl"
    })
    /*
	 *ruta por defecto
    */
    .otherwise({ redirectTo : "/login" });
});

 
  