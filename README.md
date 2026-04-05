# Mini Projet Symfony — Blog 

## Démo en ligne

Site disponible ici : [Voir le site](https://whitesmoke-sheep-253771.hostingersite.com)

Projet Symfony (Blog) avec :
- Authentification (register / login)
- CRUD Admin pour Catégories & Posts
- Posts publics (home / liste / détail)
- Commentaires (user connecté uniquement) + validation (pending/approved)
- Fixtures séparées (User / Category / Post / Comment)

---

## ✅ Prérequis

- PHP 8.2+
- Composer
- Symfony CLI (recommandé)
- MySQL (XAMPP/WAMP/MAMP)

---

## 🚀 Installation

1) Cloner le projet puis installer les dépendances :

```bash
composer install
Créer le fichier .env.local (si besoin) et configurer la base :

Exemple :

env

DATABASE_URL="mysql://root@localhost/mini_projet_symfony?serverVersion=8.0.32&charset=utf8mb4"
Créer la base + exécuter les migrations :


php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
🌱 Données de démo (Fixtures)
⚠️ Attention : les fixtures suppriment le contenu de la base (purge).


php bin/console doctrine:fixtures:load --purge-with-truncate
Comptes créés
Admin :

email : admin@gmail.com

password : qwerty

rôle : ROLE_ADMIN

Users :

user1@gmail.com à user5@gmail.com

password : qwerty

▶️ Lancer le projet
Avec Symfony CLI :

bash
Copy code
symfony serve -d
Puis ouvrir :

Home : http://127.0.0.1:8000/

Liste des posts : http://127.0.0.1:8000/posts

Détail d’un post : http://127.0.0.1:8000/posts/{id}

🔐 Authentification
Inscription : /register

Connexion : /login

Déconnexion : /logout

🛠️ Administration
⚠️ L’admin est réservé à ROLE_ADMIN

Admin Posts : /post

Admin Categories : /category

🖼️ Images des posts
Le champ picture correspond à une URL d’image.
Exemple :
https://exemple.com/image.jpg

Les images sont affichées automatiquement dans :

Home

Liste des posts

Détail du post

💬 Commentaires
Un utilisateur connecté peut commenter sur la page détail d’un post.

À l’envoi :

createdAt auto

status = pending

author = user connecté

post = post courant

Seuls les commentaires approved sont affichés publiquement.

✅ Commandes utiles
Voir les routes :


php bin/console debug:router
Vérifier la DB :


php bin/console doctrine:query:sql "SHOW TABLES"
Vider le cache :

php bin/console cache:clear
📌 Auteur
Projet réalisé dans le cadre du module Symfony — IPSSI. 



---
