# AllGames

Application web de catalogue de jeux vidéo (style Steam / Epic Games) réalisée avec **Symfony 6.4**.

Les jeux ont un genre et un éditeur. Les utilisateurs peuvent ajouter des jeux à leur **wishlist** et laisser un **avis** (recommandé oui/non + commentaire).

## Stack technique

- Symfony 6.4 (`--webapp`)
- Doctrine ORM + migrations + MariaDB/MySQL
- Tailwind CSS v4 (`symfonycasts/tailwind-bundle`)
- EasyAdmin 5 (back-office)
- VichUploaderBundle (upload d'images de jeux)
- Symfony UX Turbo (wishlist + avis sans rechargement de page)
- Symfony Security (connexion par email/mot de passe)

## Installation

```bash
composer install

# Base de données (config dans .env.local)
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

# CSS
php bin/console tailwind:build      # ou --watch en développement

# Serveur
symfony server:start
```

La configuration de la base se trouve dans `.env.local` :

```
DATABASE_URL="mysql://root:@127.0.0.1:3306/all_games?serverVersion=12.3.2-MariaDB&charset=utf8mb4"
```

## Comptes de démonstration (fixtures)

| Rôle  | Email                   | Mot de passe |
|-------|-------------------------|--------------|
| Admin | admin@allgames.test     | `admin`      |
| User  | alice@allgames.test     | `password`   |
| User  | bob@allgames.test       | `password`   |
| User  | charlie@allgames.test   | `password`   |

Le back-office est accessible sur `/admin` (réservé à `ROLE_ADMIN`).

## Fonctionnalités

- Page d'accueil avec les 3 derniers jeux sortis
- Liste et fiche détaillée des jeux
- Pages par genre
- Wishlist personnelle (ajout/retrait via Turbo)
- Avis sur les jeux (recommandation + commentaire, via Turbo Frame)
- Back-office EasyAdmin : jeux (avec image), éditeurs, genres, utilisateurs, avis, wishlist
- Authentification par formulaire (email / mot de passe), mots de passe hachés

## Note sur les images

Les images de jeux s'uploadent depuis le back-office (champ *imageFile* de la fiche jeu),
stockées dans `public/images/games`. Tant qu'un jeu n'a pas d'image, une image de remplacement
(`dummyimage.com`) est affichée.
