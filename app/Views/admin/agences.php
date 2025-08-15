<?php
/** @var array $agences */
$agences ??= [];

include __DIR__.'/../layout/header.php';
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
?>

<div class="container">
  <h2 class="mb-3">Agences</h2>

  <a class="btn btn-success mb-3" href="<?= $base ?>/agence/create">Créer une agence</a>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr><th>ID</th><th>Nom</th></tr>
      </thead>
      <tbody>
        <?php foreach ($agences as $a): ?>
          <tr>
            <td><?= (int)$a['id'] ?></td>
            <td><?= htmlspecialchars($a['nom']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__.'/../layout/footer.php'; ?>
