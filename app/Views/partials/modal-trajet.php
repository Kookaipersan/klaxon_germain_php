<?php
// Variables attendues : $modalTrajet (trajet) + $isLogged
$idModal = 'modalTrajet' . (int)$modalTrajet['id'];
?>
<div class="modal fade" id="<?= $idModal ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Détails du trajet #<?= (int)$modalTrajet['id'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>
          <strong>Départ :</strong> <?= htmlspecialchars($modalTrajet['ville_depart']) ?> —
          <strong>Arrivée :</strong> <?= htmlspecialchars($modalTrajet['ville_arrivee']) ?>
        </p>
        <p>
          <strong>Départ :</strong> <?= date('d/m/Y H:i', strtotime($modalTrajet['date_depart'])) ?><br>
          <strong>Arrivée :</strong> <?= date('d/m/Y H:i', strtotime($modalTrajet['date_arrivee'])) ?>
        </p>
        <hr>

        <?php if ($isLogged): ?>
          <!-- Connecté : afficher l’auteur et infos -->
          <p><strong>Auteur :</strong> <?= htmlspecialchars($modalTrajet['auteur_prenom'] ?? '') ?>
             <?= htmlspecialchars($modalTrajet['auteur_nom'] ?? '') ?></p>
          <p><strong>Téléphone :</strong> <?= htmlspecialchars($modalTrajet['auteur_tel'] ?? '') ?></p>
          <p><strong>Email :</strong> <?= htmlspecialchars($modalTrajet['auteur_email'] ?? '') ?></p>
          <p><strong>Places totales :</strong> <?= (int)($modalTrajet['places_totales'] ?? 0) ?></p>
        <?php else: ?>
          <!-- Visiteur : invite à se connecter -->
          <div class="alert alert-info">
            Pour voir l’auteur (nom, téléphone, email) et le nombre total de places,
            <a href="<?= $base ?>/login" class="alert-link">veuillez vous connecter</a>.
          </div>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
