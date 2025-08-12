<?php
namespace App\Core;

class Helpers
{
    /** Démarre la session si nécessaire */
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** Alias interne pour compat: corrige les appels mal orthographiés éventuels */
    public static function starSession(): void
    {
        self::startSession(); // alias pour les vieux appels
    }

    /** L'utilisateur est-il connecté ? */
    public static function isLoggedIn(): bool
    {
        self::startSession();
        return !empty($_SESSION['user']);
    }

    /** Récupère l'utilisateur courant */
    public static function user(): ?array
    {
        self::startSession();
        return $_SESSION['user'] ?? null;
    }

    /** L'utilisateur courant est-il admin ? */
    public static function isAdmin(): bool
    {
        $u = self::user();
        // clé normale: 'est_admin' (snake_case)
        return !empty($u['est_admin']);
    }

    /** Définit un message flash (nom historique) */
    public static function flash(string $msg, string $type = 'success'): void
    {
        self::startSession();
        $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
    }

    /** Récupère et supprime le message flash (nom historique) */
    public static function popFlash(): ?array
    {
        self::startSession();
        if (empty($_SESSION['flash'])) return null;
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }

    /** --- ALIAS pour coller à la vue et aux contrôleurs que je t’ai donnés --- */
    public static function flashSet(string $msgOrType, ?string $msg = null): void
    {
        if ($msg === null) {
            $type = 'success';
            $msg  = $msgOrType;
        } else {
            $type = $msgOrType;
        }
        self::flash($msg, $type);
    }

    public static function flashGet(): ?array
    {
        return self::popFlash();
    }

    /* -------------------------------
       CSRF protection
       ------------------------------- */

    /** Génère ou retourne le token CSRF courant */
    public static function csrfToken(): string
    {
        self::startSession();
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    /** Retourne le champ <input hidden> à mettre dans les formulaires */
    public static function csrfField(): string
    {
        $t = self::csrfToken();
        return '<input type="hidden" name="_csrf" value="'.htmlspecialchars($t).'">';
    }

    /** Vérifie que le token POST correspond à celui en session */
    public static function csrfVerify(): bool
    {
        self::startSession();
        $ok = isset($_POST['_csrf'], $_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $_POST['_csrf']);
        return $ok;
    }

    /** Base path pour les URLs relatives (ex: /login) */
    public static function basePath(): string
    {
        return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }
}

