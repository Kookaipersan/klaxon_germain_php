<?php
namespace App\Controllers;

use App\Core\Helpers;

class LoginController
{
    public function form()
    {
        // mini form pour tester
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function do()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Fake login: on “connecte” un user id=1 (auteur), et on peut cocher admin
        $_SESSION['user'] = [
            'id'        => (int)($_POST['user_id'] ?? 1),
            'prenom'    => $_POST['prenom'] ?? 'Jean',
            'nom'       => $_POST['nom'] ?? 'Dupont',
            'email'     => $_POST['email'] ?? 'jean.dupont@exemple.com',
            'est_admin' => !empty($_POST['is_admin']) ? 1 : 0,
        ];

        \App\Core\Helpers::flashSet('success', 'Connexion réussie');
        header('Location: ' . Helpers::basePath() . '/'); exit;
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['user']);
        Helpers::flashSet('Déconnexion effectuée', 'success');
        header('Location: ' . Helpers::basePath() . '/'); exit;
    }
}
