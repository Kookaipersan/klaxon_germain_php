<?php
echo "<pre>REQUEST_URI: {$_SERVER['REQUEST_URI']}</pre>";

// --- Session & erreurs ---
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
  'httponly' => true,
  'samesite' => 'Lax',
]);
if (session_status() === PHP_SESSION_NONE) session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE & ~E_USER_NOTICE & ~E_WARNING & ~E_USER_WARNING);

set_error_handler(function($severity, $message, $file, $line) {
    if (in_array($severity, [E_DEPRECATED, E_USER_DEPRECATED, E_NOTICE, E_USER_NOTICE, E_WARNING, E_USER_WARNING])) {
        return true;
    }
    echo "<pre>PHP ERROR: $message in $file:$line</pre>";
    return false;
});
set_exception_handler(function($e) {
    echo "<pre>UNCAUGHT: ".get_class($e).": ".$e->getMessage()."\n".$e->getTraceAsString()."</pre>";
});
register_shutdown_function(function() {
    $e = error_get_last();
    if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "<pre>FATAL: {$e['message']} in {$e['file']}:{$e['line']}</pre>";
    }
});

// --- Autoload ---
require __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;

// --- Router configuration ---
$router = new Router([
    'debug' => true,
    'base_folder' => '',
    'paths' => [
        'controllers' => __DIR__ . '/../app/Controllers',
    ],
    'namespaces' => [
        'controllers' => 'App\Controllers',
    ],
    'parameters' => [
        'id' => '[0-9]+',
    ],
]);

// --- Routes de test ---
$router->get('/debug', fn() => print('Router fonctionne bien'));
$router->get('/ping', fn() => print('pong'));
$router->get('/test/edit', fn() => print('ROUTE EDIT STATIC OK'));

// --- Accueil ---
$router->get('/', 'HomeController@index');

// --- Auth ---
$router->get('/login',  'LoginController@form');
$router->post('/login', 'LoginController@do');
$router->get('/logout', 'LoginController@logout');

// --- Trajets ---
$router->get('/trajet/create',        'TrajetController@createForm');
$router->post('/trajet/create',       'TrajetController@createAction');
$router->get('/trajet/edit/:id',      'TrajetController@editForm');       // ✅ dynamique
$router->post('/trajet/edit/:id',     'TrajetController@editAction');
$router->post('/trajet/delete/:id',   'TrajetController@deleteAction');

// --- Dashboard Admin ---
$router->get('/dashboard/users',   'DashboardController@users');
$router->get('/dashboard/agences', 'DashboardController@agences');
$router->get('/dashboard/trajets', 'DashboardController@trajets');
$router->post('/dashboard/trajets/delete/:id', 'DashboardController@deleteTrajet');

// --- Agences ---
$router->get('/agence/create',         'AgenceController@createForm');
$router->post('/agence/create',        'AgenceController@createAction');
$router->get('/agence/edit/:id',       'AgenceController@editForm');
$router->post('/agence/edit/:id',      'AgenceController@editAction');
$router->post('/agence/delete/:id',    'AgenceController@deleteAction');

// --- Lancer le routeur ---
$router->run();
