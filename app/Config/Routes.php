<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Dashboard::index');
$routes->get('dashboard', 'Dashboard::index');

$routes->get('training', 'Training::session');
$routes->get('training/(:segment)', 'Training::session/$1');

$routes->post('training/toggle-absence', 'Training::toggleAbsence');

$routes->get('players', 'Players::index');
$routes->get('players/(:num)', 'Players::view/$1');

$routes->get('teams', 'Teams::index');