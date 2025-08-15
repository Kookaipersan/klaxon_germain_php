<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$isLogged = isset($_SESSION['user']);
$isAdmin  = $isLogged && (!empty($_SESSION['user']['est_admin']));
$user     = $isLogged ? $_SESSION['user'] : null;
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Touche pas au Klaxon</title>
 
 <link rel="stylesheet" href="<?= $base ?>/css/custom.css">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<header class="bg-white border rounded-3 p-3 mb-4">
  <div class="container d-flex justify-content-between align-items-center flex-wrap">
    <a href="<?= $base ?>/" class="text-decoration-none">
      <h1 class="h5 m-0">Touche pas au Klaxon</h1>
    </a>

    <?php if (!$isLogged): ?>
      <a href="<?= $base ?>/login" class="btn btn-primary">Connexion</a>

    <?php elseif ($isAdmin): ?>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= $base ?>/dashboard/users"   class="btn btn-outline-secondary">Utilisateurs</a>
        <a href="<?= $base ?>/dashboard/agences" class="btn btn-outline-secondary">Agences</a>
        <a href="<?= $base ?>/dashboard/trajets" class="btn btn-outline-secondary">Trajets</a>
        <span class="mx-2">Bonjour <?= htmlspecialchars($user['prenom'].' '.$user['nom']) ?></span>
        <a href="<?= $base ?>/logout" class="btn btn-danger">Déconnexion</a>
      </div>

    <?php else: ?>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= $base ?>/trajet/create" class="btn btn-success">Créer un trajet</a>
        <span class="mx-2">Bonjour <?= htmlspecialchars($user['prenom'].' '.$user['nom']) ?></span>
        <a href="<?= $base ?>/logout" class="btn btn-danger">Déconnexion</a>
      </div>
    <?php endif; ?>
  </div>
</header>

<?php
// ----- FLASH sous le header -----
$flash = null;
if (class_exists('\\App\\Core\\Helpers')) $flash = \App\Core\Helpers::flashGet();
if (!$flash && !empty($_SESSION['flash'])) { $flash = $_SESSION['flash']; unset($_SESSION['flash']); }
if ($flash):
  $type = htmlspecialchars($flash['type'] ?? 'success');
  $msg  = htmlspecialchars($flash['msg']  ?? '');
?>
  <div class="container">
    <div class="alert alert-<?= $type ?> text-center mb-4"><?= $msg ?></div>
  </div>
<?php endif; ?>
