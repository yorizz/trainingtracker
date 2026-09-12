<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Dashboard::index');
$routes->get('dashboard', 'Dashboard::index');

$routes->get('training', 'Training::session');
$routes->get('training/(:segment)', 'Training::session/$1');
$routes->post('training/complete', 'Training::complete');

$routes->post('training/set-absence', 'Training::setAbsence');
$routes->get('training/state/(:segment)', 'Training::state/$1');

$routes->get('players', 'Players::index');
$routes->get('players/(:num)', 'Players::view/$1');

$routes->get('teams', 'Teams::index');