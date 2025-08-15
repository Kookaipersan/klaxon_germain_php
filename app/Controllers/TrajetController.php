<?php
namespace App\Controllers;

use App\Core\Helpers;
use App\Core\Database;
use App\Models\Trajet;
use PDO;

/**
 * Contrôleur pour la gestion des trajets.
 */
class TrajetController
{
    /**
     * Affiche le formulaire d'édition d'un trajet.
     *
     * @param int $id ID du trajet à modifier.
     * @return void
     */
    public function editForm($id)
    {
        if (!Helpers::isLoggedIn()) {
            Helpers::flash('Connexion requise', 'warning');
            header('Location: ' . Helpers::basePath() . '/login');
            exit;
        }

        $trajet = Trajet::findById($id);
        if (!$trajet) {
            Helpers::flash('Trajet introuvable', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        $uid = Helpers::user()['id'] ?? 0;
        if ($uid !== (int)$trajet['id_utilisateur'] && !Helpers::isAdmin()) {
            Helpers::flash('Accès refusé', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        $agences = $this->fetchAgences();
        require __DIR__ . '/../Views/trajets/edit.php';
    }

    /**
     * Normalise une date/heure en format SQL.
     *
     * @param string $s Chaîne de date.
     * @return string Date normalisée.
     */
    private function normDt(string $s): string
    {
        $s = trim($s);
        if ($s === '') return $s;
        $s = str_replace('T', ' ', $s);
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $s)) {
            $s .= ':00';
        }
        return $s;
    }

    /**
     * Valide les données d'un trajet.
     *
     * @param int    $ad ID agence départ.
     * @param int    $aa ID agence arrivée.
     * @param string $dd Date/heure départ.
     * @param string $da Date/heure arrivée.
     * @param int    $pt Places totales.
     * @param int    $pd Places disponibles.
     * @return array Liste des erreurs.
     */
    private function validate(int $ad, int $aa, string $dd, string $da, int $pt, int $pd): array
    {
        $errors = [];

        if ($ad <= 0 || $aa <= 0) {
            $errors[] = "Agences invalides.";
        } elseif ($ad === $aa) {
            $errors[] = "L'agence de départ doit être différente de l'agence d'arrivée.";
        }

        if ($dd === '' || $da === '') {
            $errors[] = "Les dates de départ et d'arrivée sont obligatoires.";
        } else {
            $tsd = strtotime($dd);
            $tsa = strtotime($da);
            if ($tsd === false || $tsa === false) {
                $errors[] = "Format de date invalide.";
            } elseif ($tsa <= $tsd) {
                $errors[] = "On ne peut pas arriver avant (ou au même instant que) le départ.";
            }
        }

        if ($pt <= 0) {
            $errors[] = "Le nombre total de places doit être strictement positif.";
        }
        if ($pd < 0 || $pd > $pt) {
            $errors[] = "Les places disponibles doivent être entre 0 et le total.";
        }

        return $errors;
    }

    /**
     * Récupère la liste des agences.
     *
     * @return array Liste des agences (id, nom).
     */
    private function fetchAgences(): array
    {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT id, nom FROM agences ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Affiche le formulaire de création de trajet.
     *
     * @return void
     */
    public function createForm()
    {
        if (!Helpers::isLoggedIn()) {
            Helpers::flash('Connexion requise', 'warning');
            header('Location: ' . Helpers::basePath() . '/login');
            exit;
        }

        $agences = $this->fetchAgences();
        require __DIR__ . '/../Views/trajets/create.php';
    }

    /**
     * Traite la création d’un trajet.
     *
     * @return void
     */
    public function createAction()
    {
        if (!Helpers::isLoggedIn()) {
            Helpers::flash('Connexion requise', 'warning');
            header('Location: ' . Helpers::basePath() . '/login');
            exit;
        }

        if (!Helpers::csrfVerify()) {
            Helpers::flash('Session expirée. Merci de réessayer.', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        $ad  = (int)($_POST['agence_depart_id']  ?? 0);
        $aa  = (int)($_POST['agence_arrivee_id'] ?? 0);
        $dd  = $this->normDt((string)($_POST['date_heure_depart']  ?? ''));
        $da  = $this->normDt((string)($_POST['date_heure_arrivee'] ?? ''));
        $pt  = (int)($_POST['nombres_places_total'] ?? 0);
        $pd  = (int)($_POST['nombres_places_dispo'] ?? 0);
        $uid = (int)(Helpers::user()['id'] ?? 0);

        $errors = $this->validate($ad, $aa, $dd, $da, $pt, $pd);
        if ($errors) {
            Helpers::flash(implode(' ', $errors), 'danger');
            header('Location: ' . Helpers::basePath() . '/trajet/create');
            exit;
        }

        Trajet::create([
            'agence_depart_id'      => $ad,
            'agence_arrivee_id'     => $aa,
            'date_heure_depart'     => $dd,
            'date_heure_arrivee'    => $da,
            'nombres_places_total'  => $pt,
            'nombres_places_dispo'  => $pd,
            'utilisateur_id'        => $uid,
        ]);

        Helpers::flash('Le trajet a été créé', 'success');
        header('Location: ' . Helpers::basePath() . '/');
        exit;
    }

    /**
     * Traite la modification d’un trajet.
     *
     * @param int $id ID du trajet.
     * @return void
     */
    public function editAction($id)
    {
        if (!Helpers::isLoggedIn()) {
            Helpers::flash('Connexion requise', 'warning');
            header('Location: ' . Helpers::basePath() . '/login');
            exit;
        }

        $id = (int)$id;
        $trajet = Trajet::findById($id);
        if (!$trajet) {
            Helpers::flash('Trajet introuvable', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        $uid = (int)(Helpers::user()['id'] ?? 0);
        if ($uid !== (int)$trajet['id_utilisateur'] && !Helpers::isAdmin()) {
            Helpers::flash('Accès refusé', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        $ad  = (int)($_POST['agence_depart_id']  ?? 0);
        $aa  = (int)($_POST['agence_arrivee_id'] ?? 0);
        $dd  = $this->normDt((string)($_POST['date_heure_depart']  ?? ''));
        $da  = $this->normDt((string)($_POST['date_heure_arrivee'] ?? ''));
        $pt  = (int)($_POST['nombres_places_total'] ?? 0);
        $pd  = (int)($_POST['nombres_places_dispo'] ?? 0);

        $errors = $this->validate($ad, $aa, $dd, $da, $pt, $pd);
        if ($errors) {
            Helpers::flash(implode(' ', $errors), 'danger');
            header('Location: ' . Helpers::basePath() . "/trajet/edit/$id");
            exit;
        }

        Trajet::update($id, [
            'agence_depart_id'      => $ad,
            'agence_arrivee_id'     => $aa,
            'date_heure_depart'     => $dd,
            'date_heure_arrivee'    => $da,
            'nombres_places_total'  => $pt,
            'nombres_places_dispo'  => $pd,
        ]);

        Helpers::flash('Le trajet a été modifié', 'success');
        if (Helpers::isAdmin()) {
            header('Location: ' . Helpers::basePath() . '/dashboard/trajets');
        } else {
            header('Location: ' . Helpers::basePath() . '/');
        }
        exit;
    }

    /**
     * Supprime un trajet.
     *
     * @param int $id ID du trajet à supprimer.
     * @return void
     */
    public function deleteAction($id)
    {
        if (!Helpers::isLoggedIn()) {
            Helpers::flash('Connexion requise', 'warning');
            header('Location: ' . Helpers::basePath() . '/login');
            exit;
        }

        if (!Helpers::csrfVerify()) {
            Helpers::flash('Session expirée. Merci de réessayer.', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        $id = (int)$id;
        $trajet = Trajet::findById($id);
        if (!$trajet) {
            Helpers::flash('Trajet introuvable', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        $uid = (int)(Helpers::user()['id'] ?? 0);
        if ($uid !== (int)$trajet['id_utilisateur'] && !Helpers::isAdmin()) {
            Helpers::flash('Accès refusé', 'danger');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        Trajet::delete($id);

        Helpers::flash('Le trajet a été supprimé', 'success');
        if (Helpers::isAdmin()) {
            header('Location: ' . Helpers::basePath() . '/dashboard/trajets');
        } else {
            header('Location: ' . Helpers::basePath() . '/');
        }
        exit;
    }
}
