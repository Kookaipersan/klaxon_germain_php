<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
</head>
<body>
    <h1>Liste des trajets</h1>
    <ul>
        <?php foreach ($trajets as $trajet): ?>
            <li><?= $trajet['id'] ?> : De <?= $trajet['agence_depart_id'] ?> à <?= $trajet['agence_arrivee_id'] ?> (<?= $trajet['date_heure_depart'] ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
