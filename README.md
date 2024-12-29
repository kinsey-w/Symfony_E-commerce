# Projet Symfony : Site E-commerce
Par: **Kinsey Witkowski**

## Description de l'exercice

📑 Ce projet est un exercice pédagogique visant à construire un site e-commerce basique à l'aide du framework Symfony.  
Le but de cet exercice est de mettre en pratique des concepts clés tels que :

- **La gestion des rôles utilisateurs** (utilisateurs, administrateurs, super-administrateurs).
- **La gestion des produits** (création, modification, suppression).
- **La gestion des paniers d'achat** (ajout, suppression, validation).
- **La validation des formulaires**.
- **L'utilisation des messages Flash** pour indiquer les succès et les erreurs.
- **La traduction de l'interface** dans plusieurs langues.
- **L'affichage et la personnalisation des pages d'erreur** (403, 404, etc.).

---

## Fonctionnalités principales

### Utilisateur classique :
- Inscription et connexion.
- Visualisation des produits.
- Ajout de produits au panier.
- Finalisation d'une commande.
- Accès à l'historique des commandes dans une page de compte utilisateur.

### Administrateur :
- Gestion des produits (ajout, modification, suppression).
- Gestion des catégories de produits.

### Super-administrateur :
- Visualisation des paniers non validés avec les détails associés.
- Affichage des utilisateurs inscrits le jour même, triés du plus récent au plus ancien.

---

## Technologies utilisées

- **Symfony** : Framework PHP.
- **MySQL** : Base de données relationnelle.
- **Twig** : Moteur de templates.
- **CSS** : Pour le style et la mise en page.

---

## Disclaimer

⚠️ Ce projet est réalisé dans un cadre purement pédagogique et n'a **aucune affiliation** avec une marque, une entreprise ou un produit mentionné ou utilisé dans le cadre de l'exercice.  


## Procédure d'installation

1. Cloner le repo
2. Modifier le `.env` avec vos accès à la base de données
3. Installer les dépendances manquantes : `composer update`
4. Créer la base de données : `php bin/console d:d:c`
5. Exécuter les migrations : `php bin/console d:m:m`
6. Lancer le serveur symfony : `symfony server:start`
