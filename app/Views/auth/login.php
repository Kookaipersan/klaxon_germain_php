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
    <h1 class="h4 mb-3">Connexion (temporaire)</h1>
    <form method="post" action="<?= $base ?>/login" class="vstack gap-3">
      <div>
        <label class="form-label">ID utilisateur (auteur)</label>
        <input class="form-control" type="number" name="user_id" value="1">
      </div>
      <div class="row">
        <div class="col-md-6">
          <label class="form-label">Prénom</label>
          <input class="form-control" type="text" name="prenom" value="Jean">
        </div>
        <div class="col-md-6">
          <label class="form-label">Nom</label>
          <input class="form-control" type="text" name="nom" value="Dupont">
        </div>
      </div>
      <div>
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" value="jean.dupont@exemple.com">
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin">
        <label class="form-check-label" for="is_admin">Se connecter en admin</label>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-primary">Se connecter</button>
        <a class="btn btn-secondary" href="<?= $base ?>/">Annuler</a>
      </div>
    </form>
  </div>
</body>
</html>
