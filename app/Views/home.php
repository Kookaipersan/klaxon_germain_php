<?php
// On inclut le header commun
include __DIR__ . '/layout/header.php';
?>

<div class="container">

    <?php if ($f = \App\Core\Helpers::flashGet()): ?>
        <div class="alert alert-<?= htmlspecialchars($f['type']) ?> text-center">
            <?= htmlspecialchars($f['msg']) ?>
        </div>
    <?php endif; ?>

    <h2 class="mb-4">Liste des trajets disponibles</h2>

    <?php if (empty($trajets)): ?>
        <p class="text-muted text-center">Aucun trajet disponible pour le moment.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Date départ</th>
                        <th>Date arrivée</th>
                        <th>Places totales</th>
                        <th>Places dispo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trajets as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['id']) ?></td>
                            <td><?= htmlspecialchars($t['depart']) ?></td>
                            <td><?= htmlspecialchars($t['arrivee']) ?></td>
                            <td><?= htmlspecialchars($t['date_heure_depart']) ?></td>
                            <td><?= htmlspecialchars($t['date_heure_arrivee']) ?></td>
                            <td><?= htmlspecialchars($t['nombres_places_total']) ?></td>
                            <td><?= htmlspecialchars($t['nombres_places_dispo']) ?></td>
                            <td>
                                <!-- Bouton œil (modal) -->
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalTrajet<?= $t['id'] ?>">
                                    👁
                                </button>

                                <!-- Bouton édition -->
                                <a href="<?= $base ?>/trajet/edit/<?= $t['id'] ?>" class="btn btn-sm btn-warning">
                                    ✏
                                </a>

                                <!-- Form suppression -->
                                <form action="<?= $base ?>/trajet/delete/<?= $t['id'] ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer ce trajet ?');">
                                        🗑
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal détails trajet -->
                        <div class="modal fade" id="modalTrajet<?= $t['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Détails du trajet #<?= $t['id'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Départ :</strong> <?= htmlspecialchars($t['depart']) ?></p>
                                        <p><strong>Arrivée :</strong> <?= htmlspecialchars($t['arrivee']) ?></p>
                                        <p><strong>Date départ :</strong> <?= htmlspecialchars($t['date_heure_depart']) ?></p>
                                        <p><strong>Date arrivée :</strong> <?= htmlspecialchars($t['date_heure_arrivee']) ?></p>
                                        <p><strong>Places totales :</strong> <?= htmlspecialchars($t['nombres_places_total']) ?></p>
                                        <p><strong>Places dispo :</strong> <?= htmlspecialchars($t['nombres_places_dispo']) ?></p>
                                        <?php if (!empty($t['auteur'])): ?>
                                            <p><strong>Auteur :</strong> <?= htmlspecialchars($t['auteur']) ?></p>
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

<?php
// On inclut le footer commun
include __DIR__ . '/layout/footer.php';
?>
