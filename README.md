# MenuFinder
[![Build Status](https://travis-ci.org/HE-Arc/menu-finder.svg?branch=master)](https://travis-ci.org/HE-Arc/menu-finder)

Backend et API REST permettant aux restaurateurs de proposer leur menu du jour.<br>
Projet Laravel du [cours développement web](https://github.com/HE-Arc/slides-devweb) INF3dlm. HE-Arc, 2018-2019.

[Documentation de l'API](https://he-arc.github.io/menu-finder-api-doc).

## Prérequis
- PHP 7.1
- PostgreSQL 10 et PostGIS 2.4

Il est nécessaire d'initialiser PostGIS dans la base de données utilisée en lançant la commande ``CREATE EXTENSION postgis;`` depuis psql.
Si vous utilisez Homestead comme environnement de développement, un [script](https://github.com/HE-Arc/menu-finder/wiki/Homestead#installation-de-postgis-pendant-le-provisioning-de-la-box) est disponible pour faciliter l'installation et la configuration de PostGIS. 

## Prise en main
1. Installez les dépendances PHP et frontend
```bash
$ composer install
$ npm install
```
2. Copiez le fichier ```.env.example```sous le nom ```.env```et éditez le contenu de ce dernier selon votre configuration locale.
3. Lancer les migrations et *seeder* les catégories
```bash
$ php artisan migrate --seed
```
4. Générez une clé d'application avec artisan
```bash
$ php artisan key:generate
```
5. Générer le lien symbolique pour le disque public de la facade ``Storage``
```bash
$ php artisan storage:link
```
6. L'application doit pouvoir "transformer" des addresses physiques en coordonnées géographiques (**geocoding**).
Pour cela, l'API d'Algolia est utilisé, il est donc nécessaire de [créer un compte](https://www.algolia.com/users/sign_up/places) et de créer une application et une clé d'API
Une fois que cela est fait, remplissez les valeurs ``ALGOLIA_GEOCODE_API_ID`` et ``ALGOLIA_GEOCODE_API_KEY`` dans le fichier ``.env``.

## Tests
```bash
$ phpunit # Tests unitaires
$ composer lint # Linting
```

## Auteurs
* **[Kevin Bütikofer](https://github.com/kevinbutikofer)**
* **[Jordy Crescoli](https://github.com/joecrescoll)**
* **[Jules Perrelet](https://github.com/kulisse)**

