<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/products', 'ProductController::index');
$routes->get('/products/create', 'ProductController::create');
$routes->post('/products/store', 'ProductController::store');
$routes->get('/products/edit/(:segment)', 'ProductController::edit/$1');
$routes->post('/products/update/(:segment)', 'ProductController::update/$1');
// $routes->post('/products/(:segment)', 'ProductController::delete/$1');
$routes->delete('/products/delete/(:num)', 'ProductController::delete/$1');

