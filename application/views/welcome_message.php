<!DOCTYPE html>
<!--le decimos a nuestra página que vamos a utilizar el módulo app que hemos creado-->
<html ng-app="app">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Bienvenidos!</title>

<link rel="stylesheet" href="bootstrap/js/alertify.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="bootstrap/js/themes/default.min.css"/>


<script src="bootstrap/js/alertify.min.js"></script>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/tema.css">

<!-- Latest compiled and minified JavaScript -->
  <script src="bootstrap/js/jquery-2.2.4.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script type='text/javascript' src="js/angular/angular.min.js"></script>
  <!--modulo ngRoute de angular-->
  <script src="js/angular/angular-route.min.js"></script>
  <!--archivo app.js, donde hemos definido nuestro modulo app-->
  <script type='text/javascript' src="js/app.js"></script>
  <script type='text/javascript' src="js/signinController.js"></script>
  <script type='text/javascript' src="js/registroController.js"></script>
  <script type='text/javascript' src="js/informacionController.js"></script>
  <script type='text/javascript' src="js/preguntasController.js"></script>
  <script type='text/javascript' src="js/agregarPreguntaController.js"></script>
  <script type='text/javascript' src="js/agregarInfoController.js"></script>
  <script type='text/javascript' src="js/temasEstuController.js"></script>
  <script type='text/javascript' src="js/informacionEstuController.js"></script>
  <script type='text/javascript' src="js/agregarAdminController.js"></script>
  <script type='text/javascript' src="js/agregarTemaController.js"></script>
  <script type='text/javascript' src="js/editarTemaController.js"></script>
  <script type='text/javascript' src="js/editarAdminController.js"></script>
  <script type='text/javascript' src="js/homeController.js"></script>
  <script type='text/javascript' src="js/Servicios.js"></script>
  <script type='text/javascript' src="js/Factorias.js"></script>
  <script type='text/javascript' src="js/angular-resource.min.js"></script>
  <script type='text/javascript' src="js/angular-md5/angular-md5.js"></script>

</head>
    <body>
      
      <!--directiva ng-view, aquí cargara todo el contenido-->
        <div ng-view></div>
        
    </body>
</html>