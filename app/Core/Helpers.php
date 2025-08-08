<?php
namespace App\Core;

class Helpers
{
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

    }
    public static function isLoggedIn(): bool 
    {
        self::starSession();
        return !empty($_SESSION['user']);
    }
public static function user(): ?array
{
    self::startSession();
    return $_SESSION['user'] ?? null;
}
public static function isAdmin(): bool
{
    $u = self::user();
    return !empty($u['est admin']);
}
public static function flash(string $msg, string $type='success'): void
{
    self::starSession();
    $_SESSION['flash']=['msg'=>$msg, 'type'=>$type];
}
public static function popFlash(): ?array
{
    self::startSession();
    if (empty($_SESSION['flash'])) return null;
    $f = $_SESSION['flash']; unset($_SESSION['flash']);
    return $f;
}
public static function basePath(): string
{
    return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
}
}