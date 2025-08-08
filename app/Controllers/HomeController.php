<?php

namespace App\Controllers;

use App\Models\Trajet;

class HomeController
{
    public function index()
    {
        $trajets = Trajet::getTrajetsDisponibles();

        require __DIR__ . '/../Views/home.php';
    }
}
