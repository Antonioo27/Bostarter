<?php

// Carica il file di configurazione
require_once '../config/config.php';

// Autoload delle classi
require_once '../vendor/autoload.php';

// Carica le rotte
require_once '../routes/web.php';
require_once '../app/Router.php';

// Inizializza e avvia il Router
use App\Router;

$router = new Router();
$router($routes);
