<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['usuario'] = 'user';
$route['administrador'] = 'admin';
$route['usuario/iniciar_sesion'] = 'user/login';
