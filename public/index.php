<?php

session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
  'httponly' => true,
  'samesite' => 'Lax',
]);
if (session_status() === PHP_SESSION_NONE) { session_start(); }


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
// masque les Deprecated/Notice/Warning pour voir l'erreur utile
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE & ~E_USER_NOTICE & ~E_WARNING & ~E_USER_WARNING);

set_error_handler(function($severity,$message,$file,$line){
    // Ignore le bruit courant
    if (in_array($severity, [
        E_DEPRECATED, E_USER_DEPRECATED,
        E_NOTICE, E_USER_NOTICE,
        E_WARNING, E_USER_WARNING,
    ])) {
        return true; // on avale le message
    }
    // Montre seulement le reste (utile pour débuguer)
    echo "<pre>PHP ERROR: $message in $file:$line</pre>";
    return false;
});
set_exception_handler(function($e){
    echo "<pre>UNCAUGHT: ".get_class($e).": ".$e->getMessage()."\n".$e->getTraceAsString()."</pre>";
});
register_shutdown_function(function(){
    $e = error_get_last();
    if ($e && in_array($e['type'], [E_ERROR,E_PARSE,E_CORE_ERROR,E_COMPILE_ERROR])) {
        echo "<pre>FATAL: {$e['message']} in {$e['file']}:{$e['line']}</pre>";
    }
});


error_reporting(E_ALL & ~E_DEPRECATED);

// Autoload
require __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;

$router = new Router([
    'paths' => [
        // chemin ABSOLU vers tes contrôleurs
        'controllers' => __DIR__ . '/../app/Controllers',
        // 'middlewares' => __DIR__ . '/../app/Middlewares', // si besoin plus tard
    ],
    'namespaces' => [
        'controllers' => 'App\Controllers',
        // 'middlewares' => 'App\Middlewares',
    ],
    'debug' => true,
]);

if (!is_dir(__DIR__ . '/../app/Controllers')) {
    die('<pre>Chemin controllers introuvable: ' . __DIR__ . '/../app/Controllers</pre>');
}



// 2) Déclarer les routes (APRES l’instanciation !)
$router->get('/ping', function () { echo 'pong'; });

// --- Accueil (remplace ton closure de debug actuel) ---
$router->get('/', 'HomeController@index');

// --- Auth temporaire pour tester ---
$router->get('/login',  'LoginController@form');
$router->post('/login', 'LoginController@do');
$router->get('/logout', 'LoginController@logout');

// --- Trajets ---
$router->get('/trajet/create',        'TrajetController@createForm');
$router->post('/trajet/create',       'TrajetController@createAction');

$router->get('/trajet/edit/{id}',     'TrajetController@editForm');
$router->post('/trajet/edit/{id}',    'TrajetController@editAction');

$router->post('/trajet/delete/{id}',  'TrajetController@deleteAction');

// 3) Lancer le routeur
$router->run();


