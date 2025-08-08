# Covoiturage d'entreprise – Projet MVC en PHP

Ce projet est une application de covoiturage interne à l'entreprise, réalisée en PHP avec architecture MVC.

## Fonctions

- Liste des trajets à venir avec places dispo
- Connexion utilisateur
- Proposer, modifier, supprimer un trajet
- Interface admin (agences, utilisateurs, trajets)

## Base de données

- Fichier `database/schema.sql` : création des tables
- Fichier `database/seed.sql` : insertion des données de test

Commande pour tout installer :

```bash
mysql -u root -p touche_pas_au_klaxon < database/schema.sql
mysql -u root -p touche_pas_au_klaxon < database/seed.sql
```
