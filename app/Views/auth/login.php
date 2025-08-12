<?php $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <div class="container" style="max-width:520px;">
    <h1 class="h4 mb-3">Connexion</h1>

    <?php if ($f = \App\Core\Helpers::flashGet()): ?>
      <div class="alert alert-<?= htmlspecialchars($f['type']) ?> text-center">
        <?= htmlspecialchars($f['msg']) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= $base ?>/login" class="vstack gap-3">
      <?= \App\Core\Helpers::csrfField() ?>

      <div>
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" required autofocus>
      </div>

      <div>
        <label class="form-label">Mot de passe</label>
        <input class="form-control" type="password" name="password" required>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-primary">Se connecter</button>
        <a class="btn btn-secondary" href="<?= $base ?>/">Annuler</a>
      </div>
    </form>
  </div>
</body>
</html>
