# Taxi Paris Vitrine

Ce projet est un site vitrine développé avec **Symfony** pour un chauffeur de taxi parisien souhaitant présenter ses services.

## Fonctionnalités principales

- Présentation des services de taxi à Paris
- Réservation en ligne : formulaire permettant aux clients de réserver un taxi directement depuis le site
- Gestion des réservations par e-mail : le chauffeur reçoit les demandes de réservation par mail et peut y répondre
- Site multilingue : français 🇫🇷 et anglais 🇬🇧
- Design moderne et responsive

## Prérequis

- PHP >= 8.1
- Composer
- Un serveur web (Apache, Nginx, ou le serveur interne Symfony)
- Node.js et npm (pour la gestion des assets si besoin)

## Installation

1. **Cloner le dépôt**

```bash
git clone <url-du-repo>
cd taxi-paris-vitrine
```

2. **Installer les dépendances PHP**

```bash
composer install
```

3. **Configurer les variables d'environnement**

Copiez le fichier `.env` en `.env.local` et adaptez les paramètres (base de données, mailer, etc.) :

```bash
cp .env .env.local
```

4. **Installer les assets (optionnel)**

```bash
npm install
# ou
yarn install
```

5. **Lancer le serveur de développement**

```bash
symfony serve
# ou
php -S localhost:8000 -t public
```

Accédez ensuite au site sur [http://localhost:8000](http://localhost:8000).

## Structure du projet

- `src/` : Code source PHP (contrôleurs, entités, etc.)
- `templates/` : Templates Twig pour le rendu HTML
- `public/` : Fichiers accessibles publiquement (index.php, images, CSS)
- `assets/` : Fichiers front-end (JS, CSS)
- `config/` : Configuration Symfony

## Gestion des e-mails et des réservations

Le formulaire de réservation permet aux clients d'envoyer une demande de réservation de taxi. Le chauffeur reçoit ces demandes par e-mail et peut y répondre directement.

Configurez le transporteur d'e-mails dans `.env.local` :

```
MAILER_DSN=smtp://user:pass@smtp.example.com:port
```

## Internationalisation (FR/EN)

Le site est disponible en français et en anglais. Les fichiers de traduction se trouvent dans le dossier `translations/`.

## Contribution

Les contributions sont les bienvenues !

1. Forkez le projet
2. Créez votre branche (`git checkout -b feature/ma-fonctionnalite`)
3. Commitez vos changements (`git commit -am 'Ajout d'une fonctionnalité'`)
4. Poussez la branche (`git push origin feature/ma-fonctionnalite`)
5. Ouvrez une Pull Request

## Licence

Ce projet est sous licence MIT. 