<?php
/** @var array $trajets */
$trajets ??= [];

include __DIR__.'/../layout/header.php';
$base = \App\Core\Helpers::basePath();
?>
<div class="container">
  <h2 class="mb-3">Trajets</h2>

  <div class="table-responsive">
    <table class="table table-striped align-middle text-center">
      <thead>
        <tr>
          <th>ID</th><th>Départ</th><th>Arrivée</th>
          <th>Départ (date/heure)</th><th>Arrivée (date/heure)</th>
          <th>Places (tot/dispo)</th><th>Auteur</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($trajets as $t): $id=(int)$t['id']; ?>
          <tr>
            <td><?= $id ?></td>
            <td><?= htmlspecialchars($t['ville_depart']) ?></td>
            <td><?= htmlspecialchars($t['ville_arrivee']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($t['date_heure_depart'])) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($t['date_heure_arrivee'])) ?></td>
            <td><?= (int)$t['nombres_places_total'] ?>/<?= (int)$t['nombres_places_dispo'] ?></td>
            <td><?= htmlspecialchars($t['prenom'].' '.$t['nom']) ?></td>
            <td class="text-nowrap">
              <?php
                $isAdmin = $_SESSION['user']['est_admin'] ?? false;
                if ($isAdmin):
              ?>
                <a href="<?= $base ?>/trajet/edit/<?= $id ?>" class="btn btn-sm btn-outline-warning" title="Modifier">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <form method="post" action="<?= $base ?>/trajet/delete/<?= $id ?>" style="display:inline"
                      onsubmit="return confirm('Supprimer ce trajet ?');">
                  <?= \App\Core\Helpers::csrfField() ?>
                  <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__.'/../layout/footer.php'; ?>
