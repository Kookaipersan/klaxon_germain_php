<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use \Buki\Router\Router;

$router = new Router([
    'paths' => [
        'controllers' => 'app/Controllers',
        'middlewares' => 'app/Middlewares',
    ],
    'namespaces' => [
        'controllers' => 'A^^\Controllers',
        'middlewares' => 'App\Middlewares',
    ]
    ]);

    $router->get('/', 'HomeController@index');
    
    $router->get('/trajet/create', 'TrajetController@createForm');
    $router->post('/trajet/create', 'TrajetController@createAction');

    $router->get('/trajet/edit/{id}', 'TrajetController@editForm');
    $router->post('/trajet/edit/{id}', 'TrajetController@editAction');

    $router->post('/trajet/delete/{id}', 'TrajetController@deleteAction');

    $router->run();