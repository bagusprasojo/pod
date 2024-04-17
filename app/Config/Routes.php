<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/detail/(:any)', 'Home::detail/$1');
$routes->get('/produk_size_list_/(:any)', 'Home::produk_size_list_/$1');

$routes->match(['get', 'post'], '/register', 'AuthController::register');
$routes->match(['get', 'post'], '/login', 'AuthController::login');
$routes->match(['get', 'post'], '/logout', 'AuthController::logout');

$routes->get('/user_dashboard', 'UserDashboard::index');
$routes->get('/designer_dashboard', 'DesignerDashboard::index');

$routes->match(['get', 'post'], '/designer_dashboard/add_produk', 'DesignerDashboard::add_produk');
$routes->match(['get', 'post'], '/designer_dashboard/produk_list', 'DesignerDashboard::produk_list');
$routes->match(['get', 'post'], '/designer_dashboard/produk_list_', 'DesignerDashboard::produk_list_');

$routes->get('assets/desain/(:any)', 'Assets::desain/$1');
$routes->get('assets/produk/(:any)', 'Assets::produk/$1');

