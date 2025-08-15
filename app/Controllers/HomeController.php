<?php
namespace App\Controllers;

use App\Models\Trajet;

/**
 * Contrôleur de la page d'accueil.
 * Affiche la liste des trajets disponibles.
 */
class HomeController
{
    /**
     * Affiche la page d'accueil avec les trajets disponibles.
     * En cas d'erreur, affiche un message détaillé.
     *
     * @return void
     */
    public function index(): void
    {
        try {
            $trajets = Trajet::getTrajetsDisponibles();  
            require __DIR__ . '/../Views/home.php';
        } catch (\Throwable $e) {
            echo '<pre>HomeController error: ' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>';
        }
    }
}
