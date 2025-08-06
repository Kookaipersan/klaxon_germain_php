<?php

namespace App\Controllers;

use App\Core\Database;

class HomeController
{
    public function index()
    {
        $pdo = Database::getInstance();

        $stmt = $pdo->query("SELECT * FROM trajets");
        $trajets = $stmt->fetchAll();

        require __DIR__ . '/../Views/home.php';
    }
}
