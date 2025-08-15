<?php
namespace App\Controllers;

use App\Core\Helpers;
use App\Models\Agence;
use App\Core\Database;
use PDO;

/**
 * Contrôleur de gestion des agences (CRUD) pour les administrateurs.
 */
class AgenceController
{
    /**
     * Affiche la liste des agences dans le dashboard admin.
     *
     * @return void
     */
    public function index()
    {
        if (!Helpers::isAdmin()) {
            Helpers::flash('Accès réservé aux administrateurs.', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        $agences = Agence::all();
        require __DIR__ . '/../Views/admin/agences.php';
    }

    /**
     * Affiche le formulaire de création d’une nouvelle agence.
     *
     * @return void
     */
    public function createForm()
    {
        if (!Helpers::isAdmin()) {
            Helpers::flash('Accès réservé aux administrateurs.', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        require __DIR__ . '/../Views/admin/agences_create.php';
    }

    /**
     * Traite la création d’une nouvelle agence après soumission du formulaire.
     *
     * @return void
     */
    public function createAction()
    {
        if (!Helpers::isAdmin()) {
            Helpers::flash('Accès refusé', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        if (!Helpers::csrfVerify()) {
            Helpers::flash('Session expirée. Merci de réessayer.', 'danger');
            header('Location: ' . Helpers::basePath() . '/dashboard/agences');
            exit;
        }

        $nom = trim($_POST['nom'] ?? '');
        if ($nom === '') {
            Helpers::flash('Le nom de l’agence est requis.', 'danger');
            header('Location: ' . Helpers::basePath() . '/agence/create');
            exit;
        }

        Agence::create(['nom' => $nom]);

        Helpers::flash('Agence créée avec succès.');
        header('Location: ' . Helpers::basePath() . '/dashboard/agences');
        exit;
    }
}
