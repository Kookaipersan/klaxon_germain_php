<?php
namespace App\Controllers;

use App\Models\Trajet;

class HomeController
{
    public function index()
    {
        try {
            $trajets = Trajet::getTrajetsDisponibles();   // <-- on remet l'appel BDD
            require __DIR__ . '/../Views/home.php';
        } catch (\Throwable $e) {
            echo '<pre>HomeController error: '.$e->getMessage()."\n".$e->getTraceAsString().'</pre>';
        }
    }
}

