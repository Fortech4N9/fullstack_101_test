<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/', 'Home::index');
$routes->get('/home/fetch', 'Home::fetch');
$routes->post('/home/create', 'Home::create');
$routes->get('/home/delete/(:num)', 'Home::delete/$1');
