<?php

namespace App\Core;

use PDO;
use PDOException;

Class Database
{
    private static $instance = null;
    private $pdo;

    private function _construct()
    {
        $config= require __DIR__. '/../../config/config.php';
        try {
           $this->pdo = new PDO(
            "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8",
            $config['db_user'],
            $config['db_pass']
           );
           $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) {
            die('Erreur connexion BDD:' .$e->getMessage());
        }
    }
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $db = new self();
            self::$instance = $db->pdo;
        }
        return self::$instance;
    }
}