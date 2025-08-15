<?php
namespace App\Controllers;

use App\Core\Helpers;
use App\Core\Database;
use PDO;

/**
 * Contrôleur de gestion de l'authentification utilisateur (login/logout).
 */
class LoginController
{
    /**
     * Affiche le formulaire de connexion.
     * Route : GET /login
     *
     * @return void
     */
    public function form(): void
    {
        require __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Traite la soumission du formulaire de connexion.
     * Vérifie le CSRF, l'identifiant, le mot de passe, puis connecte l'utilisateur.
     * Route : POST /login
     *
     * @return void
     */
    public function do(): void
    {
        // 1) CSRF
        if (!Helpers::csrfVerify()) {
            Helpers::flash('Session expirée. Merci de réessayer.', 'danger');
            header('Location: ' . Helpers::basePath() . '/login');
            exit;
        }

        // 2) Inputs
        $email = trim($_POST['email'] ?? '');
        $pass  = (string)($_POST['password'] ?? '');

        if ($email === '' || $pass === '') {
            Helpers::flash('Email et mot de passe requis.', 'danger');
            header('Location: ' . Helpers::basePath() . '/login');
            exit;
        }

        // 3) Lookup BDD
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT id, prenom, nom, email, telephone, mot_de_passe, role
            FROM utilisateurs
            WHERE email = :email
            LIMIT 1
        ");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 4) Vérification du mot de passe (hash)
        if ($user && password_verify($pass, $user['mot_de_passe'])) {
            Helpers::startSession();
            session_regenerate_id(true); // protection contre la fixation de session

            $_SESSION['user'] = [
                'id'        => (int)$user['id'],
                'prenom'    => $user['prenom'],
                'nom'       => $user['nom'],
                'email'     => $user['email'],
                'telephone' => $user['telephone'],
                'role'      => $user['role'],
                'est_admin' => ($user['role'] === 'admin'),
            ];

            Helpers::flash('Connexion réussie', 'success');
            header('Location: ' . Helpers::basePath() . '/');
            exit;
        }

        // 5) Échec
        Helpers::flash('Identifiants invalides.', 'danger');
        header('Location: ' . Helpers::basePath() . '/login');
        exit;
    }

    /**
     * Déconnecte l'utilisateur (suppression de session).
     * Route : GET /logout
     *
     * @return void
     */
    public function logout(): void
    {
        Helpers::startSession();
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $p['path'],
                $p['domain'],
                $p['secure'],
                $p['httponly']
            );
        }

        session_destroy();

        Helpers::flash('Déconnexion effectuée', 'success');
        header('Location: ' . Helpers::basePath() . '/');
        exit;
    }
}
