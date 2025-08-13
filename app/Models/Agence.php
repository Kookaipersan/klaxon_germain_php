<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Agence
{
    public static function all(): array
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM agences ORDER BY nom");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM agences WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function create(array $data): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO agences (nom) VALUES (?)");
        return $stmt->execute([$data['nom']]);
    }

    public static function update(int $id, array $data): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE agences SET nom = ? WHERE id = ?");
        return $stmt->execute([$data['nom'], $id]);
    }

    public static function delete(int $id): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM agences WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
