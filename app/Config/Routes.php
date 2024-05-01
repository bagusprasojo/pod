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
$routes->get('/designer_dashboard', 'designer\DesignerDashboard::index');

$routes->match(['get', 'post'], '/designer_dashboard/add_desain', 'designer\DesignerDashboard::add_desain');
$routes->match(['get', 'post'], '/designer_dashboard/desain_list', 'designer\DesignerDashboard::desain_list');
$routes->match(['get', 'post'], '/designer_dashboard/desain_list_', 'designer\DesignerDashboard::desain_list_');

$routes->get('assets/desain/(:any)', 'Assets::desain/$1');
$routes->get('assets/produk/(:any)', 'Assets::produk/$1');

$routes->match(['get', 'post'],'/order/payment_success', 'order\Order::payment_success');
$routes->match(['get', 'post'],'/order/pengiriman', 'order\Order::pengiriman');

$routes->match(['get', 'post'],'/order/add_cart', 'order\Order::add_cart');
$routes->match(['get', 'post'],'/order/show_cart', 'order\Order::show_cart');
$routes->get('/order/checkout/(:any)', 'order\Order::checkout/$1');
$routes->get('/order/remove_item_cart/(:any)', 'order\Order::remove_item_cart/$1');
$routes->get('/order/add_qty_cart/(:any)/(:any)', 'order\Order::add_qty_cart/$1/$2');
$routes->get('/order/get_ongkir/(:any)', 'order\Order::get_ongkir/$1');

$routes->get('/order/bayar_midtrans/(:any)', 'order\Order::bayar_midtrans/$1');
$routes->post('/payment/callback', 'order\Payment::callback');



