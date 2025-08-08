<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$isLogged = isset($_SESSION['user']);
$userId   = $isLogged ? (int)$_SESSION['user']['id'] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil - Touche pas au Klaxon</title>
  <link rel="stylesheet" href="<?= $base ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="<?= $base ?>/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<?php include __DIR__ . '/layout/header.php'; ?>

<div class="container">

  <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['flash']) ?></div>
    <?php unset($_SESSION['flash']); ?>
  <?php endif; ?>

  <h2 class="h5 mb-3">Trajets proposés</h2>

  <?php if (empty($trajets)) : ?>
    <div class="alert alert-info text-center">Aucun trajet disponible pour le moment.</div>
  <?php else : ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>Départ</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Places</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($trajets as $t) : ?>
          <?php
            // Adapte aux noms de colonnes que tu utilises déjà :
            // ville_depart, ville_arrivee, date_depart, date_arrivee, places_disponibles, id_utilisateur
            $id             = (int)$t['id'];
            $isOwner        = $isLogged && $userId === (int)$t['id_utilisateur'];
            $modalId        = 'modalTrajet'.$id;
            $viewBtnAttrs   = 'data-bs-toggle="modal" data-bs-target="#'.$modalId.'"';
            $editHref       = $isLogged && $isOwner ? "$base/trajet/edit/$id"   : "$base/login";
            $deleteAction   = $isLogged && $isOwner ? "$base/trajet/delete/$id" : "$base/login";
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
              <!-- ŒIL : ouvre la modale -->
              <button type="button" class="btn btn-sm btn-outline-secondary" <?= $viewBtnAttrs ?> title="Voir">
                <i class="bi bi-eye"></i>
              </button>

              <!-- CRAYON -->
              <?php if ($isLogged && $isOwner): ?>
                <a class="btn btn-sm btn-outline-warning" href="<?= $editHref ?>" title="Modifier">
                  <i class="bi bi-pencil-square"></i>
                </a>
              <?php else: ?>
                <a class="btn btn-sm btn-outline-secondary" href="<?= $editHref ?>" title="Connexion requise">
                  <i class="bi bi-pencil-square"></i>
                </a>
              <?php endif; ?>

              <!-- POUBELLE -->
              <?php if ($isLogged && $isOwner): ?>
                <form method="post" action="<?= $deleteAction ?>" style="display:inline;"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?');">
                  <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              <?php else: ?>
                <a class="btn btn-sm btn-outline-danger" href="<?= $deleteAction ?>" title="Connexion requise">
                  <i class="bi bi-trash"></i>
                </a>
              <?php endif; ?>
            </td>
          </tr>

          <!-- MODALE -->
          <?php $modalTrajet = $t; include __DIR__ . '/partials/modal-trajet.php'; ?>

        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <?php if (!$isLogged): ?>
    <div class="alert alert-info text-center mt-3">
      Pour obtenir plus d'informations sur le trajet, veuillez vous connecter.
    </div>
  <?php endif; ?>
</div>
</body>
</html>
