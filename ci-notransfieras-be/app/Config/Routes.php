<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


#EXTERNOS -REGISTRO INCIDENTE 
$routes->post('profile/login/index', 'Login::loginProfileIndex/$1');
$routes->post('profile/login', 'Login::loginProfile');
$routes->post('profile/incidente', 'Incidentes::registrar');
#ACCIONES DE INTRANET ADMIN
$routes->get('/', 'Home::index');
$routes->get('/external/auth/login/facebook', 'Home::facebookOaut');

#USUARIO
$routes->get('/adm/login', 'Login::index');
$routes->post('/adm/login/submit', 'Login::login');
$routes->get('/adm/login/salir', 'Login::salir');
$routes->post('/adm/dashboard/usuario', 'Usuario::registrar');
$routes->get('/adm/dashboard/usuario/registro', 'Usuario::indexRegistrar');
$routes->get('/adm/dashboard/usuario/editor', 'Usuario::indexUpdate');
$routes->get('/adm/dashboard/usuario/rol/editor', 'Usuario::indexRol');
$routes->post('/adm/dashboard/usuario/rol/find', 'Usuario::buscarRolUser');
$routes->get('/adm/dashboard/usuario/rol/(:segment)/(:segment)', 'Usuario::eliminarRol');
$routes->post('/adm/dashboard/usuario/rol/register', 'Usuario::registrarRol');
#ADMIN RUTIFICADOR
$routes->get('/adm/dashboard/rut', 'Ruts::index');
$routes->get('/adm/dashboard/rut/alter', 'Ruts::indexModificar');
$routes->get('/adm/dashboard/rut/fraude', 'Ruts::indexFraude');
$routes->get('/adm/dashboard/rut/fraude/alter', 'Ruts::indexFraude');
$routes->post('/adm/dashboard/rut/buscar', 'Ruts::buscar');
$routes->post('/adm/dashboard/rut', 'Ruts::registrar');
$routes->post('/adm/dashboard/rut/alter', 'Ruts::modificar');
$routes->post('/adm/dashboard/rut/fraude', 'Ruts::registrar');
$routes->post('/adm/dashboard/rut/fraude/alter', 'Ruts::modificar');


$routes->post('/adm/dashboard/usuario/editor', 'Usuario::editar');
$routes->post('/adm/dashboard/usuario/editor/buscar', 'Usuario::buscar');
//$routes->get('/adm/dashboard/usuario/(:segment)', 'Dashboard::usuario/$1');

$routes->get('/adm/dashboard', 'Dashboard::index');


$routes->post('/rutifica', 'Home::ruts');
$routes->post('/rutifica/fraude/(:segment)', 'Home::detalleFraude/$1');
$routes->post('auth/login', 'Auth::login');


$routes->post('auth/user', 'Auth::register');

$routes->get('auth/user/id/(:segment)', 'Auth::findId/$1');
$routes->get('auth/user/username/(:segment)', 'Auth::findUserName/$1');
$routes->get('auth/user/email/(:segment)', 'Auth::findEmail/$1');

$routes->delete('auth/user', 'Auth::delete');
$routes->patch('auth/user', 'Auth::editar');

$routes->get('usuarios/rutificador/rut/(:segment)', 'UserRutificados::find/$1');
$routes->get('usuarios/rutificador/name/(:segment)', 'UserRutificados::findNombre/$1');

$routes->get('usuarios/rutificador/(:num)', 'UserRutificados::findById/$1');
$routes->patch('usuarios/rutificador/fake', 'UserRutificados::patchAdmin');

$routes->get('usuarios/fraude/(:segment)', 'Fraude::findListFunas/$1');
$routes->post('usuarios/fraude', 'Fraude::registrar');

$routes->get('usuarios/fraude/detalle/(:num)', 'Fraude::getDetalle/$1');
$routes->get('usuarios/fraude/adjunto/(:num)', 'Adjuntos::getById/$1');
$routes->post('usuarios/fraude/adjunto', 'Adjuntos::upload');
$routes->delete('usuarios/fraude/adjunto/(:num)', 'Adjuntos::deleteById/$1');
$routes->post('usuarios/roles', 'Roles::registrar');
$routes->get('usuarios/roles', 'Roles::listar');
$routes->delete('usuarios/roles', 'Roles::eliminar');
$routes->post('usuarios/roles/asignar', 'Roles::asignarRol');

$routes->post('usuarios/telefonos', 'Telefono::registrar');
$routes->post('usuarios/rrss', 'RRSS::registrar');
$routes->post('mail/confirmar', 'Casilla::hashConfirm');
$routes->post('mail/confirmar/code', 'Casilla::codeConfirm');
$routes->get('mail/confirmar/(:segment)', 'Casilla::verifica/$1');
$routes->get('mail/confirmar/code/(:num)', 'Casilla::codeValidate/$1');
