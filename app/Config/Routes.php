<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

$routes->get('/', 'AuthController::index');
$routes->get('/auth/login', 'AuthController::login');
$routes->post('/auth/login', 'AuthController::login');
$routes->get('/auth/logout', 'AuthController::logout');
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/dashboard/profile', 'DashboardController::profile');
$routes->post('/dashboard/update-profile', 'DashboardController::updateProfile');
$routes->get('/dashboard/change-password', 'DashboardController::changePassword');
$routes->post('/dashboard/change-password', 'DashboardController::changePassword');

// Routes for leave management system
$routes->group('leave', function($routes) {
    $routes->get('/', 'LeaveController::index');
    $routes->get('apply', 'LeaveController::applyLeave');
    $routes->post('submit', 'LeaveController::submitLeave');
    $routes->get('get-states/(:num)', 'LeaveController::getStates/$1');
    $routes->get('get-cities/(:num)', 'LeaveController::getCities/$1');
});
