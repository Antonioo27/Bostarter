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
    'controller' => 'HomeCreatorController',
    'method' => 'addNewProject'
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

$routes->add('skill', new Route('/skill', [
    'controller' => 'SkillController',
    'method' => 'index'
]));

$routes->add('addSkill', new Route('/skill/add', [
    'controller' => 'SkillController',
    'method' => 'addSkill'
]));

$routes->add('project', new Route('/project', [
    'controller' => 'ProjectController',
    'method' => 'index'
]));

$routes->add('infoCreatori', new Route('/infoCreatori', [
    'controller' => 'HomeController',
    'method' => 'infoCreator'
]));

$routes->add('registerCreator', new Route('/registerCreator', [
    'controller' => 'AuthController',
    'method' => 'handleRegisterCreator'
]));

$routes->add('createProject', new Route('/createProject', [
    'controller' => 'HomeCreatorController',
    'method' => 'viewFormNewProject'
]));

$routes->add('candidatura', new Route('/candidatura', [
    'controller' => 'CandidaturaController',
    'method' => 'index'
]));

$routes->add('aggiungi_candidatura', new Route('/aggiungi_candidatura', [
    'controller' => 'CandidaturaController',
    'method' => 'addApplication'
]));

$routes->add('projectFinance', new Route('/project/finance', [
    'controller' => 'ProjectController',
    'method' => 'getFinancePage'
]));

$routes->add('projectFinancePay', new Route('/project/finance/pay', [
    'controller' => 'FinanceController',
    'method' => 'addFinancing'
]));

$routes->add('insertReward', new Route('/insertReward', [
    'controller' => 'RewardController',
    'method' => 'addReward'
]));

$routes->add('gestioneCandidature', new Route('/gestioneCandidature', [
    'controller' => 'CandidatureRicevuteController',
    'method' => 'index'
]));

$routes->add('accetta_candidatura', new Route('/gestioneCandidature/accetta_candidatura', [
    'controller' => 'CandidatureRicevuteController',
    'method' => 'acceptApplication'
]));


$routes->add('rifiuta_candidatura', new Route('/gestioneCandidature/rifiuta_candidatura', [
    'controller' => 'CandidatureRicevuteController',
    'method' => 'rejectApplication'
]));

$routes->add('addProfile', new Route('/addProfile', [
    'controller' => 'ProfileController',
    'method' => 'index'
]));

$routes->add('aggiungi_profilo', new Route('/aggiungi_profilo', [
    'controller' => 'ProfileController',
    'method' => 'addProfile'
]));

$routes->add('add_comment', new Route('/project/add_comment', [
    'controller' => 'ProjectController',
    'method' => 'addComment'
]));

$routes->add('reply', new Route('/project/reply', [
    'controller' => 'ProjectController',
    'method' => 'addReplyComment'
]));

return $routes;
