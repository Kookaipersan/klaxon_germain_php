<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\Helpers;
use PDO;

class DashboardController
{
    private function guardAdmin(): void
    {
        if (!Helpers::isLoggedIn() || !Helpers::isAdmin()) {
            Helpers::flash('Accès réservé à l’administrateur.', 'danger');
            header('Location: ' . Helpers::basePath() . '/'); exit;
        }
    }

    public function users()
    {
        $this->guardAdmin();
        $pdo = Database::getInstance();
        $users = $pdo->query("SELECT id, prenom, nom, email, telephone, role FROM utilisateurs ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../Views/admin/users.php';
    }

    public function agences()
    {
        $this->guardAdmin();
        $pdo = Database::getInstance();
        $agences = $pdo->query("SELECT id, nom FROM agences ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../Views/admin/agences.php';
    }

    public function trajets()
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
