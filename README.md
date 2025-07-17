# Taxi Parisien

Application web de réservation de taxis à Paris, développée avec Symfony.

## Fonctionnalités principales
- Réservation de taxi via formulaire
- Affichage des tarifs et services
- Gestion multilingue (français/anglais)
- Envoi d’e-mails de confirmation
- Géocodage d’adresses
- Interface responsive

## Prérequis
- PHP >= 8.1
- Composer
- Node.js et npm (si assets JS/CSS à recompiler)
- [Optionnel] Docker & Docker Compose

## Installation

### 1. Clonage du dépôt
```bash
git clone <repo_url>
cd taxi-paris
```

### 2. Installation des dépendances PHP
```bash
composer install
```

### 3. Configuration des variables d’environnement
Copiez le fichier `.env` si besoin et configurez vos accès (base de données, mailer, etc.) :
```bash
cp .env .env.local
```

### 4. Installation des assets (si modifiés)
```bash
# Si vous modifiez les JS/CSS
npm install
# ou
yarn install
```

### 5. Lancer le serveur de développement Symfony
```bash
symfony serve
# ou
php -S localhost:8000 -t public
```

## Utilisation avec Docker

Un fichier `docker-compose.yml` et des configurations pour Nginx et PHP sont fournis.

```bash
docker-compose up --build
```

- Accès : http://localhost:8080

## Structure du projet

```
assets/           # JS, CSS, contrôleurs Stimulus
bin/              # Scripts exécutables (console, phpunit)
config/           # Configurations Symfony (routes, services, bundles...)
docker/           # Configs Docker (nginx, php)
migrations/       # Migrations Doctrine
public/           # Racine web (index.php, assets, images...)
src/              # Code source PHP (Contrôleurs, Services, Formulaires...)
templates/        # Vues Twig
translations/     # Fichiers de traduction YAML
var/              # Fichiers temporaires, cache, logs
vendor/           # Dépendances Composer
```

## Internationalisation (i18n)

- Les fichiers de traduction sont dans `translations/` (`messages.fr.yaml`, `messages.en.yaml`, etc.)
- Le sélecteur de langue dans le header permet de basculer entre FR et EN (ramène toujours à la page d’accueil)
- Pour ajouter une langue, créer un fichier `messages.<locale>.yaml` et compléter les traductions

## Tests

Des tests unitaires sont présents dans le dossier `tests/`.

Pour lancer les tests :
```bash
./bin/phpunit
```

## Contribution

1. Forkez le projet
2. Créez une branche (`git checkout -b feature/ma-feature`)
3. Commitez vos modifications (`git commit -am 'Ajout d'une feature'`)
4. Pushez la branche (`git push origin feature/ma-feature`)
5. Ouvrez une Pull Request

## Auteurs
- Projet développé par Tom Rémili

## Licence
Ce projet est sous licence MIT. 