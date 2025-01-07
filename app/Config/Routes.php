<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Make sure index.php is removed from URLs
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Auth routes
$routes->get('/', 'Home::index');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');

// Dashboard routes
$routes->get('dashboard', 'DashboardController::index');
$routes->get('creator/dashboard', 'DashboardController::creatorDashboard');
$routes->get('client/dashboard', 'DashboardController::clientDashboard');
$routes->get('dashboard/deletePortfolio/(:num)', 'DashboardController::deletePortfolio/$1');
$routes->post('dashboard/updatePortfolio/(:num)', 'DashboardController::updatePortfolio/$1');

// Feed routes
$routes->get('feed', 'FeedController::index');
$routes->get('feed/creator/(:segment)', 'FeedController::creatorProfile/$1');

// Portfolio routes
$routes->get('portfolio/create', 'PortfolioController::create');
$routes->post('portfolio/create', 'PortfolioController::create');