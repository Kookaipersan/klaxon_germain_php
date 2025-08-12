<?php
use App\Core\Helpers;
$base = Helpers::basePath();
include __DIR__ . '/../layout/header.php';
?>

<div class="container" style="max-width: 920px;">
  <?php if ($f = \App\Core\Helpers::flashGet()): ?>
    <div class="alert alert-<?= htmlspecialchars($f['type']) ?> text-center">
      <?= htmlspecialchars($f['msg']) ?>
    </div>
  <?php endif; ?>

  <h2 class="h5 mb-4">Créer un trajet</h2>

  <form method="post" action="<?= $base ?>/trajet/create" class="row g-3">
    <?= \App\Core\Helpers::csrfField() ?> 
    <div class="col-md-6">
      <label class="form-label">Agence de départ</label>
      <select name="agence_depart_id" class="form-select" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($agences as $a): ?>
          <option value="<?= (int)$a['id'] ?>"><?= htmlspecialchars($a['nom']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Agence d'arrivée</label>
      <select name="agence_arrivee_id" class="form-select" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($agences as $a): ?>
          <option value="<?= (int)$a['id'] ?>"><?= htmlspecialchars($a['nom']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Date & heure de départ</label>
      <input type="datetime-local" name="date_heure_depart" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Date & heure d'arrivée</label>
      <input type="datetime-local" name="date_heure_arrivee" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Places totales</label>
      <input type="number" name="nombres_places_total" min="1" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Places disponibles</label>
      <input type="number" name="nombres_places_dispo" min="0" class="form-control" required>
    </div>

    <div class="col-12">
      <button class="btn btn-success">Enregistrer</button>
      <a href="<?= $base ?>/" class="btn btn-secondary">Retour</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
