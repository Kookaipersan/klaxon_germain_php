<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$isLogged = isset($_SESSION['user']);
$isAdmin  = $isLogged && (!empty($_SESSION['user']['est_admin']));
$user     = $isLogged ? $_SESSION['user'] : null;
?>
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
// ----- BLOC FLASH GLOBAL (apparaît sous le header) -----
$flash = null;

// 1) si tu as la classe Helpers avec flashGet()
if (class_exists('\\App\\Core\\Helpers')) {
    $flash = \App\Core\Helpers::flashGet();
}

// 2) fallback si tu utilises encore $_SESSION['flash'] directement
if (!$flash && !empty($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

if ($flash):
    $type = htmlspecialchars($flash['type'] ?? 'success');
    $msg  = htmlspecialchars($flash['msg']  ?? '');
?>
  <div class="container">
    <div class="alert alert-<?= $type ?> text-center mb-4">
      <?= $msg ?>
    </div>
  </div>
<?php endif; ?>
