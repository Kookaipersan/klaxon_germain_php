<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Trajet
{
    /**
     * Trajets à venir, avec places dispo, triés par départ croissant.
     * Colonnes aliasées pour coller à ta vue/modale :
     * - ville_depart, ville_arrivee
     * - date_depart, date_arrivee
     * - places_disponibles, places_totales
     * - id_utilisateur, auteur_prenom, auteur_nom, auteur_tel, auteur_email
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
                t.nombre_places_dispo   AS places_disponibles,
                t.nombres_places_total   AS places_totales,
                u.id                AS id_utilisateur,
                u.prenom            AS auteur_prenom,
                u.nom               AS auteur_nom,
                u.telephone         AS auteur_tel,
                u.email             AS auteur_email
            FROM trajets t
            JOIN agences ad ON ad.id = t.agence_depart_id
            JOIN agences aa ON aa.id = t.agence_arrivee_id
            JOIN utilisateurs u ON u.id = t.utilisateur_id
            WHERE t.date_heure_depart > NOW()
              AND t.nb_places_dispo > 0
            ORDER BY t.date_heure_depart ASC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un trajet par id avec toutes les infos (utile pour une page détail / edit).
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
                u.id                AS id_utilisateur,
                u.prenom            AS auteur_prenom,
                u.nom               AS auteur_nom,
                u.telephone         AS auteur_tel,
                u.email             AS auteur_email
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
        $trajet = $stmt->fetch(PDO::FETCH_ASSOC);

        return $trajet ?: null;
    }
}
