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

    /** flashSet(alias) = même chose que flash() mais ordre (type, msg) harmonisé */
    public static function flashSet(string $msgOrType, ?string $msg = null): void
    {
        // Autorise les deux signatures:
        // - flashSet('success', 'Message')
        // - flashSet('Message')  -> default type = success
        if ($msg === null) {
            $type = 'success';
            $msg  = $msgOrType;
        } else {
            $type = $msgOrType;
        }
        self::flash($msg, $type);
    }

    /** flashGet(alias) = même chose que popFlash() */
    public static function flashGet(): ?array
    {
        return self::popFlash();
    }

    /** Base path pour les URLs relatives (ex: /login) */
    public static function basePath(): string
    {
        return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }
}
