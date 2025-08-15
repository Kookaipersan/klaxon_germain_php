# Documentation technique – Klaxon Germain (PHP)


## 1. Introduction
Cette documentation contient les fichiers PHP commentés avec PHPDoc.


---

## Controllers/HomeController.php
```php
<?php
namespace App\Controllers;

use App\Models\Trajet;

/**
 * Contrôleur de la page d'accueil.
 */
class HomeController
{
    /**
     * Affiche la page d'accueil avec la liste des trajets disponibles.
     *
     * @return void
     */
    public function index()
    {
        try {
            $trajets = Trajet::getTrajetsDisponibles();  
            require __DIR__ . '/../Views/home.php';
        } catch (\Throwable $e) {
            echo '<pre>HomeController error: '.$e->getMessage()."
".$e->getTraceAsString().'</pre>';
        }
    }
}
```

---

## Models/Agence.php
```php
<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Classe représentant les opérations sur les agences.
 */
class Agence
{
    /**
     * Récupère toutes les agences triées par nom.
     *
     * @return array
     */
    public static function all(): array
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM agences ORDER BY nom");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une agence par son ID.
     *
     * @param int $id
     * @return array|null
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
     * @param array $data
     * @return bool
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
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update(int $id, array $data): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE agences SET nom = ? WHERE id = ?");
        return $stmt->execute([$data['nom'], $id]);
    }

    /**
     * Supprime une agence par ID.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM agences WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
```