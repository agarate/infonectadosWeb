<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Routes para los mensajes
$route['mensajes']['get'] = 'mensajes/index';
$route['mensajes/(:num)']['get'] = 'mensajes/find/$1';
$route['mensajes']['post'] = 'mensajes/index';
$route['mensajes/(:num)']['put'] = 'mensajes/index/$1';
$route['mensajes/(:num)']['delete'] = 'mensajes/index/$1';

// Routes para las preguntas
$route['preguntas']['get'] = 'preguntas/index';
$route['preguntas/(:num)']['get'] = 'preguntas/find/$1';
$route['preguntas']['post'] = 'preguntas/index';
$route['preguntas/(:num)']['put'] = 'preguntas/index/$1';
$route['preguntas/(:num)']['delete'] = 'preguntas/index/$1';
// Routes para los usuarios
$route['usuarios']['get'] = 'usuarios/index';
$route['usuarios/(:any)']['get'] = 'usuarios/find/$1';
$route['usuarios']['post'] = 'usuarios/index';
$route['usuarios/(:num)']['put'] = 'usuarios/index/$1';
$route['usuarios/(:num)']['delete'] = 'usuarios/index/$1';
// Routes para los temas
$route['temas']['get'] = 'temas/index';
$route['temas/(:any)']['get'] = 'temas/find/$1';
$route['temas']['post'] = 'temas/index';
$route['temas/(:num)']['put'] = 'temas/index/$1';
$route['temas/(:num)']['delete'] = 'temas/index/$1';
// Routes para los usuario_tema
$route['usuario_tema']['get'] = 'usuario_tema/index';
$route['usuario_tema/(:any)']['get'] = 'usuario_tema/find/$1';
$route['usuario_tema']['post'] = 'usuario_tema/index';
$route['usuario_tema/(:num)']['put'] = 'usuario_tema/index/$1';
$route['usuario_tema/(:num)']['delete'] = 'usuario_tema/index/$1';
// Routes para los mensaje_tema
$route['mensaje_tema']['get'] = 'mensaje_tema/index';
$route['mensaje_tema/(:num)']['get'] = 'mensaje_tema/find/$1';
$route['mensaje_tema']['post'] = 'mensaje_tema/index';
$route['mensaje_tema/(:num)']['put'] = 'mensaje_tema/index/$1';
$route['mensaje_tema/(:num)']['delete'] = 'mensaje_tema/index/$1';
// Routes para los votos de las preguntas
$route['preguntas_voto']['get'] = 'preguntas_voto/index';
$route['preguntas_voto/(:num)']['get'] = 'preguntas_voto/find/$1';
$route['preguntas_voto']['post'] = 'preguntas_voto/index';
$route['preguntas_voto/(:num)']['put'] = 'preguntas_voto/index/$1';
$route['preguntas_voto/(:num)']['delete'] = 'preguntas_voto/index/$1';
// Routes para los tokens
$route['tokens']['get'] = 'tokens/index';
$route['tokens/(:any)']['get'] = 'tokens/find/$1';
$route['tokens']['post'] = 'tokens/index';
$route['tokens/(:num)']['put'] = 'tokens/index/$1';
$route['tokens/(:any)']['delete'] = 'tokens/index/$1';
