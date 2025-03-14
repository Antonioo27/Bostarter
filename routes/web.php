<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Creazione della collezione di rotte
$routes = new RouteCollection();

// Rotta per la registrazione
$routes->add('register', new Route('/register', [
    'controller' => 'AuthController',
    'method' => 'handleRegister'
]));

$routes->add('login', new Route('/login', [
    'controller' => 'AuthController',
    'method' => 'handleLogin'
]));

$routes->add('home', new Route('/', [ // Rotta per la Home
    'controller' => 'HomeController',
    'method' => 'index'
]));

$routes->add('aggiungi_progetto', new Route('/aggiungi_progetto', [ // Rotta per l'aggiunta di un progetto
    'controller' => 'HomeController',
    'method' => 'aggiungiProgetto'
]));

$routes->add('admin', new Route('/admin', [ // Rotta per la pagina di amministrazione
    'controller' => 'AdminController',
    'method' => 'handleAuthentication'
]));

$routes->add('adminDashboard', new Route('/admin/dashboard', [ // Rotta per la pagina di amministrazione
    'controller' => 'AdminController',
    'method' => 'dashboard'
]));

$routes->add('logout', new Route('/logout', [
    'controller' => 'AuthController',
    'method' => 'handleLogout'
]));

$routes->add('aggiungi_competenza', new Route('/admin/aggiungi_competenza', [
    'controller' => 'AdminController',
    'method' => 'aggiungiCompetenza'
]));

$routes->add('rimuovi_competenza', new Route('/admin/rimuovi_competenza', [
    'controller' => 'AdminController',
    'method' => 'rimuoviCompetenza'
]));

return $routes;
