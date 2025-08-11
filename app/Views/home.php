<?php include __DIR__ . '/layout/header.php'; ?>

<div class="container">

  <?php if ($f = \App\Core\Helpers::flashGet()): ?>
    <div class="alert alert-<?= htmlspecialchars($f['type']) ?> text-center">
      <?= htmlspecialchars($f['msg']) ?>
    </div>
  <?php endif; ?>

  <h2 class="mb-4">Trajets proposés</h2>

  <?php if (empty($trajets)): ?>
    <div class="alert alert-warning text-center">Aucun trajet disponible pour le moment.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>Départ</th>
            <th>Date départ</th>
            <th>Heure départ</th>
            <th>Destination</th>
            <th>Date arrivée</th>
            <th>Heure arrivée</th>
            <th>Places</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($trajets as $t): ?>
          <?php
            $id      = (int)$t['id'];
            $modalId = 'trajetModal'.$id;
            $base    = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
          ?>
          <tr>
            <td><?= htmlspecialchars($t['ville_depart']) ?></td>
            <td><?= date('d/m/Y', strtotime($t['date_depart'])) ?></td>
            <td><?= date('H:i',     strtotime($t['date_depart'])) ?></td>
            <td><?= htmlspecialchars($t['ville_arrivee']) ?></td>
            <td><?= date('d/m/Y', strtotime($t['date_arrivee'])) ?></td>
            <td><?= date('H:i',     strtotime($t['date_arrivee'])) ?></td>
            <td><?= (int)$t['places_disponibles'] ?></td>
            <td class="text-nowrap">
              <!-- Œil = détails -->
              <button type="button" class="btn btn-sm btn-outline-secondary"
                      data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>" title="Voir">
                <i class="bi bi-eye"></i>
              </button>

              <!-- Edit / Delete (activés seulement si auteur/admin : logique déjà côté contrôleur) -->
              <a class="btn btn-sm btn-outline-warning" href="<?= $base ?>/trajet/edit/<?= $id ?>" title="Modifier">
                <i class="bi bi-pencil-square"></i>
              </a>

              <form method="post" action="<?= $base ?>/trajet/delete/<?= $id ?>" style="display:inline;"
                    onsubmit="return confirm('Supprimer ce trajet ?');">
                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>

          <!-- Modale détails -->
          <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Détails du trajet #<?= $id ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                  <p><strong>Départ :</strong> <?= htmlspecialchars($t['ville_depart']) ?></p>
                  <p><strong>Arrivée :</strong> <?= htmlspecialchars($t['ville_arrivee']) ?></p>
                  <p><strong>Départ :</strong> <?= date('d/m/Y H:i', strtotime($t['date_depart'])) ?></p>
                  <p><strong>Arrivée :</strong> <?= date('d/m/Y H:i', strtotime($t['date_arrivee'])) ?></p>
                  <?php if (!empty($_SESSION['user'])): ?>
                    <hr>
                    <p><strong>Auteur :</strong> <?= htmlspecialchars(($t['auteur_prenom'] ?? '').' '.($t['auteur_nom'] ?? '')) ?></p>
                    <p><strong>Téléphone :</strong> <?= htmlspecialchars($t['auteur_tel'] ?? '') ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($t['auteur_email'] ?? '') ?></p>
                    <p><strong>Places totales :</strong> <?= (int)($t['places_totales'] ?? 0) ?></p>
                  <?php else: ?>
                    <div class="alert alert-info">
                      Pour voir l’auteur et les détails, veuillez vous connecter.
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
