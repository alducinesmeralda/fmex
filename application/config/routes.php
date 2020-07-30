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

$route['default_controller'] = "login";
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = FALSE;


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";
$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['profile'] = "user/profile";
$route['profile/(:any)'] = "user/profile/$1";
$route['profileUpdate'] = "user/profileUpdate";
$route['profileUpdate/(:any)'] = "user/profileUpdate/$1";

$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['changePassword/(:any)'] = "user/changePassword/$1";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['login-history'] = "user/loginHistoy";
$route['login-history/(:num)'] = "user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

//parte izquierda carpeta/archivo = parte derecha controlador/metodo
$route['catalogos/licencias'] = 'licencia/licencias';
$route['catalogos/licencias/(:num)'] = "licencia/licencias/$1";
$route['catalogos/nuevaLicencia'] = "licencia/nuevaLicencia";
$route['insertarLicencia'] = "licencia/insertarLicencia";//insertar licencia en base de datos
$route['deleteLicencia'] = "licencia/deleteLicencia";//Invocar el borrado

$route['catalogos/editarLicencia'] = "licencia/editarLicencia";//dirige al form de editar licencia
$route['catalogos/editarLicencia/(:num)'] = "licencia/editarLicencia/$1";
$route['actualizarLicencia'] = "licencia/actualizarLicencia";//hacer un update a la tabla de licencia


//capacidades
$route['catalogos/capacidades'] = 'capacidad/capacidades';
$route['catalogos/capacidades/(:num)'] = "capacidad/capacidades/$1";
$route['catalogos/nuevaCapacidad'] = "capacidad/nuevaCapacidad";//te manda a la panllta de nueva capacidad
$route['insertarCapacidad'] = "capacidad/insertarCapacidad";//insertar licencia en base de datos
$route['deleteCapacidad'] = "capacidad/deleteCapacidad";//Invocar el borrado

$route['catalogos/editarCapacidad'] = "capacidad/editarCapacidad";//dirige al form de editar licencia
$route['catalogos/editarCapacidad/(:num)'] = "capacidad/editarCapacidad/$1";
$route['actualizarCapacidad'] = "capacidad/actualizarCapacidad";//hacer un update a la tabla de licencia

//tipos hora
$route['catalogos/tiposHora'] = 'tipoHora/tiposHora';
$route['catalogos/tiposHora/(:num)'] = "tipoHora/tiposHora/$1";
$route['catalogos/nuevaTipoHora'] = "tipoHora/nuevaTipoHora";//te manda a la panllta de nueva tipo_hora
$route['insertarTipoHora'] = "tipoHora/insertarTipoHora";//insertar tipo_hora en base de datos
$route['deleteTipoHora'] = "tipoHora/deleteTipoHora";//Invocar el borrado

$route['catalogos/editarTipoHora'] = "tipoHora/editarTipoHora";//dirige al form de editar tipo_hora
$route['catalogos/editarTipoHora/(:num)'] = "tipoHora/editarTipoHora/$1";
$route['actualizarTipoHora'] = "tipoHora/actualizarTipoHora";//hacer un update a la tabla de tipo_hora

//tipos productos
$route['catalogos/productos'] = 'producto/productos';
$route['catalogos/productos/(:num)'] = "producto/productos/$1";
$route['catalogos/nuevoProducto'] = "producto/nuevoProducto";//te manda a la panllta de nueva producto
$route['insertarProducto'] = "producto/insertarProducto";//insertar producto en base de datos
$route['deleteProducto'] = "producto/deleteProducto";//Invocar el borrado

$route['catalogos/editarProducto'] = "producto/editarProducto";//dirige al form de editar producto
$route['catalogos/editarProducto/(:num)'] = "producto/editarProducto/$1";
$route['actualizarProducto'] = "producto/actualizarProducto";//hacer un update a la tabla de producto

//tipos categorias
$route['catalogos/categorias'] = 'categoria/categorias';
$route['catalogos/categorias/(:num)'] = "categoria/categorias/$1";
$route['catalogos/nuevaCategoria'] = "categoria/nuevaCategoria";//te manda a la panllta de nueva categoria
$route['insertarCategoria'] = "categoria/insertarCategoria";//insertar categoria en base de datos
$route['deleteCategoria'] = "categoria/deleteCategoria";//Invocar el borrado

$route['catalogos/editarCategoria'] = "categoria/editarCategoria";//dirige al form de editar categoria
$route['catalogos/editarCategoria/(:num)'] = "categoria/editarCategoria/$1";
$route['actualizarCategoria'] = "categoria/actualizarCategoria";//hacer un update a la tabla de categoria

//tipos bases
$route['catalogos/bases'] = 'base/bases';
$route['catalogos/bases/(:num)'] = "base/bases/$1";
$route['catalogos/nuevaBase'] = "base/nuevaBase";//te manda a la panllta de nueva base
$route['insertarBase'] = "base/insertarBase";//insertar base en base de datos
$route['deleteBase'] = "base/deleteBase";//Invocar el borrado

$route['catalogos/editarBase'] = "base/editarBase";//dirige al form de editar base
$route['catalogos/editarBase/(:num)'] = "base/editarBase/$1";
$route['actualizarBase'] = "base/actualizarBase";//hacer un update a la tabla de base

//tipos aviones
$route['catalogos/aviones'] = 'avion/aviones';
$route['catalogos/aviones/(:num)'] = "avion/aviones/$1";
$route['catalogos/nuevoAvion'] = "avion/nuevoAvion";//te manda a la panllta de nuevo avion
$route['insertarAvion'] = "avion/insertarAvion";//insertar avion en base de datos
$route['deleteAvion'] = "avion/deleteAvion";//Invocar el borrado

$route['catalogos/editarAvion'] = "avion/editarAvion";//dirige al form de editar avion
$route['catalogos/editarAvion/(:num)'] = "avion/editarAvion/$1";
$route['actualizarAvion'] = "avion/actualizarAvion";//hacer un update a la tabla de avion
/* End of file routes.php */
/* Location: ./application/config/routes.php */
