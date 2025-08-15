<?php
/** @var array $users */
$users ??= [];

include __DIR__.'/../layout/header.php';
?>
<div class="container">
  <h2 class="mb-4">Utilisateurs</h2>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead><tr>
        <th>ID</th><th>Prénom</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Rôle</th>
      </tr></thead>
      <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= (int)$u['id'] ?></td>
          <td><?= htmlspecialchars($u['prenom']) ?></td>
          <td><?= htmlspecialchars($u['nom']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= htmlspecialchars($u['telephone']) ?></td>
          <td><?= htmlspecialchars($u['role']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__.'/../layout/footer.php'; ?>

