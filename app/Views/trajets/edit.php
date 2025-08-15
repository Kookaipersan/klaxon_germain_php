<?php
/** @var array $trajet */
/** @var array $agences */

use App\Core\Helpers;

$trajet ??= [];
$agences ??= [];
$base = Helpers::basePath();
?>

<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
  <h2 class="h5 mb-3">Modifier le trajet #<?= (int)$trajet['id'] ?></h2>
  <form method="post" action="<?= $base ?>/trajet/edit/<?= (int)$trajet['id'] ?>" class="row g-3">
    <?= \App\Core\Helpers::csrfField() ?>

    <div class="col-md-6">
      <label class="form-label">Agence de départ</label>
      <select name="agence_depart_id" class="form-select" required>
        <?php foreach ($agences as $a): ?>
          <option value="<?= (int)$a['id'] ?>" <?= $a['nom'] === ($trajet['ville_depart'] ?? '') ? 'selected' : '' ?>>
            <?= htmlspecialchars($a['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Agence d'arrivée</label>
      <select name="agence_arrivee_id" class="form-select" required>
        <?php foreach ($agences as $a): ?>
          <option value="<?= (int)$a['id'] ?>" <?= $a['nom'] === ($trajet['ville_arrivee'] ?? '') ? 'selected' : '' ?>>
            <?= htmlspecialchars($a['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Date & heure de départ</label>
      <input type="datetime-local" name="date_heure_depart"
             value="<?= isset($trajet['date_heure_depart']) ? date('Y-m-d\TH:i', strtotime($trajet['date_heure_depart'])) : '' ?>"
             class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Date & heure d'arrivée</label>
      <input type="datetime-local" name="date_heure_arrivee"
             value="<?= isset($trajet['date_heure_arrivee']) ? date('Y-m-d\TH:i', strtotime($trajet['date_heure_arrivee'])) : '' ?>"
             class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Places totales</label>
      <input type="number" name="nombres_places_total" min="1"
             value="<?= (int)($trajet['nombres_places_total'] ?? 0) ?>"
             class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Places disponibles</label>
      <input type="number" name="nombres_places_dispo" min="0"
             value="<?= (int)($trajet['nombres_places_dispo'] ?? 0) ?>"
             class="form-control" required>
    </div>

    <div class="col-12">
      <button type="submit" class="btn btn-primary">Enregistrer</button>
      <a href="<?= $base ?>/" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
