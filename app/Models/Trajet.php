<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Trajet
{
    /**
     * Retourne tous les trajets à venir avec places disponibles
     */
    public static function getTrajetsDisponibles(): array
    {
        $pdo = Database::getInstance();

        $sql = "
            SELECT
                t.id,
                ad.nom AS ville_depart,
                aa.nom AS ville_arrivee,
                t.date_heure_depart AS date_depart,
                t.date_heure_arrivee AS date_arrivee,
                t.nombres_places_dispo   AS places_disponibles,
                t.nombres_places_total   AS places_totales,
                u.id        AS id_utilisateur,
                u.prenom    AS auteur_prenom,
                u.nom       AS auteur_nom,
                u.telephone AS auteur_tel,
                u.email     AS auteur_email
            FROM trajets t
            JOIN agences ad ON ad.id = t.agence_depart_id
            JOIN agences aa ON aa.id = t.agence_arrivee_id
            JOIN utilisateurs u ON u.id = t.utilisateur_id
            WHERE t.date_heure_depart > NOW()
              AND t.nombres_places_dispo > 0
            ORDER BY t.date_heure_depart ASC
        ";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un trajet par son ID
     */
    public static function findById(int $id): ?array
    {
        $pdo = Database::getInstance();

        $sql = "
            SELECT
                t.id,
                ad.nom AS ville_depart,
                aa.nom AS ville_arrivee,
                t.date_heure_depart AS date_depart,
                t.date_heure_arrivee AS date_arrivee,
                t.nombres_places_dispo   AS places_disponibles,
                t.nombres_places_total   AS places_totales,
                u.id        AS id_utilisateur,
                u.prenom    AS auteur_prenom,
                u.nom       AS auteur_nom,
                u.telephone AS auteur_tel,
                u.email     AS auteur_email
            FROM trajets t
            JOIN agences ad ON ad.id = t.agence_depart_id
            JOIN agences aa ON aa.id = t.agence_arrivee_id
            JOIN utilisateurs u ON u.id = t.utilisateur_id
            WHERE t.id = :id
            LIMIT 1
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    /**
     * Création d’un trajet
     */
    public static function create(array $data): int
    {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO trajets
                (agence_depart_id, agence_arrivee_id, date_heure_depart, date_heure_arrivee,
                 nombres_places_total, nombres_places_dispo, utilisateur_id)
                VALUES (:ad, :aa, :dd, :da, :pt, :pd, :uid)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':ad'  => $data['agence_depart_id'],
            ':aa'  => $data['agence_arrivee_id'],
            ':dd'  => $data['date_heure_depart'],
            ':da'  => $data['date_heure_arrivee'],
            ':pt'  => $data['nombres_places_total'],
            ':pd'  => $data['nombres_places_dispo'],
            ':uid' => $data['utilisateur_id'],
        ]);
        return (int)$pdo->lastInsertId();
    }

    /**
     * Mise à jour d’un trajet
     */
    public static function update(int $id, array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "UPDATE trajets SET
                agence_depart_id=:ad,
                agence_arrivee_id=:aa,
                date_heure_depart=:dd,
                date_heure_arrivee=:da,
                nombres_places_total=:pt,
                nombres_places_dispo=:pd
                WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':ad' => $data['agence_depart_id'],
            ':aa' => $data['agence_arrivee_id'],
            ':dd' => $data['date_heure_depart'],
            ':da' => $data['date_heure_arrivee'],
            ':pt' => $data['nombres_places_total'],
            ':pd' => $data['nombres_places_dispo'],
            ':id' => $id,
        ]);
    }

    /**
     * Suppression d’un trajet
     */
    public static function delete(int $id): bool
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM trajets WHERE id=:id");
        return $stmt->execute([':id' => $id]);
    }
}
