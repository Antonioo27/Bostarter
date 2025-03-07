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
