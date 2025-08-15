<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\Helpers;
use PDO;

/**
 * Contrôleur du tableau de bord administrateur.
 * Gère l'affichage des listes des utilisateurs, agences et trajets.
 */
class DashboardController
{
    /**
     * Vérifie que l'utilisateur est connecté et est administrateur.
     * Redirige avec un message flash sinon.
     *
     * @return void
     */
    private function guardAdmin(): void
    {
        if (!Helpers::isLoggedIn() || !Helpers::isAdmin()) {
            Helpers::flash('Accès réservé à l’administrateur.', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }
    }

    /**
     * Affiche la liste des utilisateurs dans la vue admin.
     *
     * @return void
     */
    public function users(): void
    {
        $this->guardAdmin();

        $pdo = Database::getInstance();
        $users = $pdo
            ->query("SELECT id, prenom, nom, email, telephone, role FROM utilisateurs ORDER BY id")
            ->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../Views/admin/users.php';
    }

    /**
     * Affiche la liste des agences dans la vue admin.
     *
     * @return void
     */
    public function agences(): void
    {
        $this->guardAdmin();

        $pdo = Database::getInstance();
        $agences = $pdo
            ->query("SELECT id, nom FROM agences ORDER BY nom")
            ->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../Views/admin/agences.php';
    }

    /**
     * Affiche la liste des trajets dans la vue admin.
     *
     * @return void
     */
    public function trajets(): void
    {
        $this->guardAdmin();

        $pdo = Database::getInstance();

        $sql = "SELECT t.id, a1.nom AS ville_depart, a2.nom AS ville_arrivee,
                       t.date_heure_depart, t.date_heure_arrivee,
                       t.nombres_places_total, t.nombres_places_dispo,
                       u.prenom, u.nom
                FROM trajets t
                JOIN agences a1 ON a1.id = t.agence_depart_id
                JOIN agences a2 ON a2.id = t.agence_arrivee_id
                JOIN utilisateurs u ON u.id = t.utilisateur_id
                ORDER BY t.date_heure_depart DESC";

        $trajets = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../Views/admin/trajets.php';
    }
}
