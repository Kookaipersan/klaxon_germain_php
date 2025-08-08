<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Trajet
{
    // --- déjà fourni précédemment ---
    public static function getTrajetsDisponibles(): array { /* ... */ }
    public static function findById(int $id): ?array { /* ... */ }

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

    public static function delete(int $id): bool
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM trajets WHERE id=:id");
        return $stmt->execute([':id'=>$id]);
    }
}
