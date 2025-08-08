<?php use App\Core\Helpers; $base = Helpers::basePath(); ?>
<div class="container">
  <h2 class="h5 mb-3">Modifier le trajet #<?= (int)$trajet['id'] ?></h2>
  <form method="post" action="<?= $base ?>/trajet/edit/<?= (int)$trajet['id'] ?>" class="row g-3">

    <div class="col-md-6">
      <label class="form-label">Agence de départ</label>
      <select name="agence_depart_id" class="form-select" required>
        <?php foreach ($agences as $a): ?>
          <option value="<?= (int)$a['id'] ?>" <?= $a['nom']===$trajet['ville_depart']?'selected':'' ?>>
            <?= htmlspecialchars($a['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Agence d'arrivée</label>
      <select name="agence_arrivee_id" class="form-select" required>
        <?php foreach ($agences as $a): ?>
          <option value="<?= (int)$a['id'] ?>" <?= $a['nom']===$trajet['ville_arrivee']?'selected':'' ?>>
            <?= htmlspecialchars($a['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Date & heure de départ</label>
      <input type="datetime-local" name="date_heure_depart"
             value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_depart'])) ?>"
             class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Date & heure d'arrivée</label>
      <input type="datetime-local" name="date_heure_arrivee"
             value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_arrivee'])) ?>"
             class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Places totales</label>
      <input type="number" name="nb_places_total" min="1"
             value="<?= (int)$trajet['places_totales'] ?>"
             class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Places disponibles</label>
      <input type="number" name="nb_places_dispo" min="0"
             value="<?= (int)$trajet['places_disponibles'] ?>"
             class="form-control" required>
    </div>

    <div class="col-12">
      <button class="btn btn-primary">Enregistrer</button>
      <a href="<?= $base ?>/" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
