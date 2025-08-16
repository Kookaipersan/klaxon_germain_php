# 🚗 Projet de Covoiturage d'Entreprise - Klaxon PHP

Application web de covoiturage développée en PHP (MVC personnalisé) dans le cadre de ma formation Développeur Web & Web Mobile.

## 🔧 Technologies utilisées

- PHP 8.4
- MySQL / phpMyAdmin
- Bootstrap 5 (personnalisé avec Sass)
- Composer
- PHPStan (niveau 5)
- PHPUnit
- phpDocumentor
- Routeur Buki

## 🎯 Fonctionnalités principales

- ✅ Authentification (connexion, déconnexion)
- ✅ Gestion des trajets (création, modification, suppression)
- ✅ Dashboard administrateur :
  - Gestion des utilisateurs
  - Gestion des agences
  - Suppression de trajets
- ✅ Création de documentation automatique
- ✅ Interface responsive

## 🗂️ Structure MVC

```text
📁 app/
 ├── Controllers/
 ├── Models/
 ├── Views/
 └── Core/ (Database, Router, Helpers, etc.)


## 🧪 Tests & qualité de code

Analyse statique : PHPStan (niveau 5)

Tests unitaires : PHPUnit

Documentation : phpDocumentor

## 📚 Documentation technique

Dossier : docs/phpdoc/index.html

Générée avec phpDocumentor

Commande de génération :

php phpdoc.phar run -d app,index.php -t docs/phpdoc

## 🔒 Sécurité

Protection CSRF sur tous les formulaires

Échappement des sorties HTML avec htmlspecialchars()

Restrictions par rôle (admin vs utilisateur)

## 🛠️ Installation

Cloner le dépôt

Configurer la base de données (.env ou app/Core/Database.php)

Lancer un serveur local :

php -S localhost:8000 -t public/


Accéder à l'application sur http://localhost:8000

👤 Auteur

William Germain
Formation Webmaster Full Stack - 2025
GitHub : @WilliamGermain
```
