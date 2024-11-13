<?php

use App\Controllers\Admin\Dashboard;
use App\Controllers\Admin\Auth;
use App\Controllers\Admin\User;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('dashboard', [Dashboard::class, 'index']);
$routes->get('signin', [Auth::class, 'signin']);
$routes->get('signup', [Auth::class, 'signup']);
$routes->post('loginSubmit', [Auth::class, 'loginSubmit']);
$routes->post('registerSubmit', [Auth::class, 'registerSubmit']);
$routes->get('search', [Dashboard::class, 'search']);
$routes->get('profile', [User::class, 'index']);
$routes->post('profile/update', [User::class, 'profile_update']);