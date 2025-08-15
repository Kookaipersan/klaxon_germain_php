<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modèle Agence
 *
 * Gère les opérations CRUD pour la table `agences` :
 * - Récupération de toutes les agences
 * - Recherche par ID
 * - Création, modification et suppression
 */
class Agence
{
    /**
     * Récupère toutes les agences classées par nom.
     *
     * @return array Liste des agences (tableau associatif)
     */
    public static function all(): array
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM agences ORDER BY nom");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche une agence par son ID.
     *
     * @param int $id ID de l’agence
     * @return array|null Données de l’agence ou null si non trouvée
     */
    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM agences WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Crée une nouvelle agence.
     *
     * @param array $data Données à insérer (clé 'nom' requise)
     * @return bool Succès ou échec de l’insertion
     */
    public static function create(array $data): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO agences (nom) VALUES (?)");
        return $stmt->execute([$data['nom']]);
    }

    /**
     * Met à jour une agence existante.
     *
     * @param int $id ID de l’agence à modifier
     * @param array $data Données à mettre à jour (clé 'nom' requise)
     * @return bool Succès ou échec de la mise à jour
     */
    public static function update(int $id, array $data): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE agences SET nom = ? WHERE id = ?");
        return $stmt->execute([$data['nom'], $id]);
    }

    /**
     * Supprime une agence par son ID.
     *
     * @param int $id ID de l’agence à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public static function delete(int $id): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM agences WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
