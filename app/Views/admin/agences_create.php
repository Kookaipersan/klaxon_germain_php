<?php include __DIR__.'/../layout/header.php'; ?>
<div class="container">
  <h2>Créer une agence</h2>

  <?php if ($f = \App\Core\Helpers::flashGet()): ?>
    <div class="alert alert-<?= htmlspecialchars($f['type']) ?>">
      <?= htmlspecialchars($f['msg']) ?>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= \App\Core\Helpers::basePath() ?>/agence/create" class="vstack gap-3">
    <?= \App\Core\Helpers::csrfField() ?>
    <div>
      <label class="form-label">Nom de l’agence</label>
      <input class="form-control" type="text" name="nom" required>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-success">Créer</button>
      <a class="btn btn-secondary" href="<?= \App\Core\Helpers::basePath() ?>/dashboard/agences">Annuler</a>
    </div>
  </form>
</div>
<?php include __DIR__.'/../layout/footer.php'; ?>
