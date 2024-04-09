<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->match(['get', 'post'], '/register', 'AuthController::register');
$routes->match(['get', 'post'], '/login', 'AuthController::login');
$routes->match(['get', 'post'], '/logout', 'AuthController::logout');

$routes->get('/user_dashboard', 'UserDashboard::index');
$routes->get('/designer_dashboard', 'DesignerDashboard::index');

$routes->match(['get', 'post'], '/designer_dashboard/add_produk', 'DesignerDashboard::add_produk');

$routes->get('assets/(:any)', 'Assets::index/$1');

$routes->get('/designer_dashboard/show', 'DesignerDashboard::show');