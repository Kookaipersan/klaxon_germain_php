<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modèle Trajet
 *
 * Gère les opérations CRUD et les requêtes personnalisées pour les trajets.
 * Utilisé pour récupérer les trajets disponibles, les trajets par ID,
 * ainsi que pour créer, modifier et supprimer un trajet.
 */
class Trajet
{
    /**
     * Récupère tous les trajets disponibles à venir (date future et places dispo > 0).
     *
     * @return array Liste des trajets disponibles (tableau associatif)
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
            t.nombres_places_total  AS places_totales,
            t.nombres_places_dispo  AS places_disponibles,
            t.utilisateur_id        AS id_utilisateur,
            u.prenom AS auteur_prenom,
            u.nom    AS auteur_nom,
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Recherche un trajet par son ID, avec les infos de l’auteur et des agences.
     *
     * @param int $id ID du trajet à récupérer
     * @return array|null Données du trajet ou null si introuvable
     */
    public static function findById(int $id): ?array
    {
        $pdo = Database::getInstance();

        $sql = "
        SELECT
            t.*,
            ad.nom AS ville_depart,
            aa.nom AS ville_arrivee,
            u.prenom AS auteur_prenom,
            u.nom    AS auteur_nom,
            u.telephone AS auteur_tel,
            u.email     AS auteur_email
        FROM trajets t
        JOIN agences ad ON ad.id = t.agence_depart_id
        JOIN agences aa ON aa.id = t.agence_arrivee_id
        JOIN utilisateurs u ON u.id = t.utilisateur_id
        WHERE t.id = :id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Insère un nouveau trajet en base de données.
     *
     * @param array $data Données du trajet à insérer
     *                    (attend les clés : agence_depart_id, agence_arrivee_id,
     *                     date_heure_depart, date_heure_arrivee, nombres_places_total,
     *                     nombres_places_dispo, utilisateur_id)
     * @return int ID du trajet inséré
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
            ':ad' => $data['agence_depart_id'],
            ':aa' => $data['agence_arrivee_id'],
            ':dd' => $data['date_heure_depart'],
            ':da' => $data['date_heure_arrivee'],
            ':pt' => $data['nombres_places_total'],
            ':pd' => $data['nombres_places_dispo'],
            ':uid'=> $data['utilisateur_id'],
        ]);
        return (int)$pdo->lastInsertId();
    }

    /**
     * Met à jour un trajet existant.
     *
     * @param int $id ID du trajet à modifier
     * @param array $data Données à mettre à jour (mêmes clés que pour create)
     * @return bool Succès ou échec de la requête
     */
    public static function update(int $id, array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "UPDATE trajets SET
                agence_depart_id=:ad, agence_arrivee_id=:aa,
                date_heure_depart=:dd, date_heure_arrivee=:da,
                nombres_places_total=:pt, nombres_places_dispo=:pd
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
     * Supprime un trajet par son ID.
     *
     * @param int $id ID du trajet à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public static function delete(int $id): bool
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM trajets WHERE id=:id");
        return $stmt->execute([':id'=>$id]);
    }
}
