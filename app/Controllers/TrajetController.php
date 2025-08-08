<?php
namespace App\Controllers;

use App\Core\Helpers;
use App\Models\Trajet;
use App\Core\Database;
use PDO;

class TrajetController
{
    // --- FORM CREATE ---
    public function createForm()
    {
        if (!Helpers::isLoggedIn()) { Helpers::flash('Connexion requise', 'warning'); header('Location: '.Helpers::basePath().'/login'); exit; }

        // Récupérer la liste des agences pour les <select>
        $pdo = Database::getInstance();
        $agences = $pdo->query("SELECT id, nom FROM agences ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../Views/trajets/create.php';
    }

    // --- ACTION CREATE ---
    public function createAction()
    {
        if (!Helpers::isLoggedIn()) { Helpers::flash('Connexion requise', 'warning'); header('Location: '.Helpers::basePath().'/login'); exit; }

        // 1) Récup input
        $ad  = (int)($_POST['agence_depart_id']  ?? 0);
        $aa  = (int)($_POST['agence_arrivee_id'] ?? 0);
        $dd  = trim($_POST['date_heure_depart']  ?? '');
        $da  = trim($_POST['date_heure_arrivee'] ?? '');
        $pt  = (int)($_POST['nombres_places_total']   ?? 0);
        $pd  = (int)($_POST['nombres_places_dispo']   ?? 0);
        $uid = (int)Helpers::user()['id'];

        // 2) Validations minimales
        $errors = [];
        if ($ad <= 0 || $aa <= 0 || $ad === $aa) $errors[] = "Agences invalides (départ ≠ arrivée).";
        if (!$dd || !$da || strtotime($da) <= strtotime($dd)) $errors[] = "Dates invalides (arrivée > départ).";
        if ($pt <= 0) $errors[] = "Nombre total de places invalide.";
        if ($pd < 0 || $pd > $pt) $errors[] = "Places dispo doit être entre 0 et le total.";

        if ($errors) {
            Helpers::flash(implode(' ', $errors), 'danger');
            header('Location: '.Helpers::basePath().'/trajet/create');
            exit;
        }

        // 3) Create
        Trajet::create([
            'agence_depart_id'   => $ad,
            'agence_arrivee_id'  => $aa,
            'date_heure_depart'  => $dd,
            'date_heure_arrivee' => $da,
            'nombres_places_total'    => $pt,
            'nombres_places_dispo'    => $pd,
            'utilisateur_id'     => $uid,
        ]);

        Helpers::flash('Le trajet a été créé', 'success');
        header('Location: '.Helpers::basePath().'/');
        exit;
    }

    // --- FORM EDIT ---
    public function editForm($id)
    {
        if (!Helpers::isLoggedIn()) { Helpers::flash('Connexion requise', 'warning'); header('Location: '.Helpers::basePath().'/login'); exit; }

        $id = (int)$id;
        $trajet = Trajet::findById($id);
        if (!$trajet) { Helpers::flash('Trajet introuvable', 'danger'); header('Location: '.Helpers::basePath().'/'); exit; }

        // Autorisation : auteur OU admin
        $uid = (int)Helpers::user()['id'];
        if ($uid !== (int)$trajet['id_utilisateur'] && !Helpers::isAdmin()) {
            Helpers::flash("Accès refusé", 'danger');
            header('Location: '.Helpers::basePath().'/'); exit;
        }

        $pdo = Database::getInstance();
        $agences = $pdo->query("SELECT id, nom FROM agences ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../Views/trajets/edit.php';
    }

    // --- ACTION EDIT ---
    public function editAction($id)
    {
        if (!Helpers::isLoggedIn()) { Helpers::flash('Connexion requise', 'warning'); header('Location: '.Helpers::basePath().'/login'); exit; }

        $id = (int)$id;
        $trajet = Trajet::findById($id);
        if (!$trajet) { Helpers::flash('Trajet introuvable', 'danger'); header('Location: '.Helpers::basePath().'/'); exit; }

        $uid = (int)Helpers::user()['id'];
        if ($uid !== (int)$trajet['id_utilisateur'] && !Helpers::isAdmin()) {
            Helpers::flash("Accès refusé", 'danger');
            header('Location: '.Helpers::basePath().'/'); exit;
        }

        // Inputs + validations (mêmes règles que create)
        $ad  = (int)($_POST['agence_depart_id']  ?? 0);
        $aa  = (int)($_POST['agence_arrivee_id'] ?? 0);
        $dd  = trim($_POST['date_heure_depart']  ?? '');
        $da  = trim($_POST['date_heure_arrivee'] ?? '');
        $pt  = (int)($_POST['nombres_places_total']   ?? 0);
        $pd  = (int)($_POST['nombres_places_dispo']   ?? 0);

        $errors = [];
        if ($ad <= 0 || $aa <= 0 || $ad === $aa) $errors[] = "Agences invalides (départ ≠ arrivée).";
        if (!$dd || !$da || strtotime($da) <= strtotime($dd)) $errors[] = "Dates invalides (arrivée > départ).";
        if ($pt <= 0) $errors[] = "Nombre total de places invalide.";
        if ($pd < 0 || $pd > $pt) $errors[] = "Places dispo doit être entre 0 et le total.";

        if ($errors) {
            Helpers::flash(implode(' ', $errors), 'danger');
            header('Location: '.Helpers::basePath()."/trajet/edit/$id"); exit;
        }

        Trajet::update($id, [
            'agence_depart_id'   => $ad,
            'agence_arrivee_id'  => $aa,
            'date_heure_depart'  => $dd,
            'date_heure_arrivee' => $da,
            'nombres_places_total'    => $pt,
            'nombres_places_dispo'    => $pd,
        ]);

        Helpers::flash('Le trajet a été modifié', 'success');
        header('Location: '.Helpers::basePath().'/'); exit;
    }

    // --- ACTION DELETE ---
    public function deleteAction($id)
    {
        if (!Helpers::isLoggedIn()) { Helpers::flash('Connexion requise', 'warning'); header('Location: '.Helpers::basePath().'/login'); exit; }

        $id = (int)$id;
        $trajet = Trajet::findById($id);
        if (!$trajet) { Helpers::flash('Trajet introuvable', 'danger'); header('Location: '.Helpers::basePath().'/'); exit; }

        $uid = (int)Helpers::user()['id'];
        if ($uid !== (int)$trajet['id_utilisateur'] && !Helpers::isAdmin()) {
            Helpers::flash("Accès refusé", 'danger');
            header('Location: '.Helpers::basePath().'/'); exit;
        }

        Trajet::delete($id);
        Helpers::flash('Le trajet a été supprimé', 'success');
        header('Location: '.Helpers::basePath().'/'); exit;
    }
}
