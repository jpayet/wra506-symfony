# wra506-symfony (MovieApp - Coté Back-End)

## URL de l'API
### https://movieapi.jean-francoispayet.fr/api

## Installation

```sh
git clone https://github.com/jpayet/wra506-symfony.git
cd wra506-symfony
composer install
```

## Charger les fixtures

1. Créer une base de données
2. Configurer le fichier .env avec les informations de connexion à la base de données (user, mot de passe et nom de la base de données)
3. Passer en environnement de développement
4. Charger les fixtures :

```sh
php bin/console doctrine:fixtures:load
```
5. Repasser en environnement de production

