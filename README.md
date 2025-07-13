# GossipChat
1.Titre du projet
Bienvenue dans le projet GossipChat, un clone de réseau social inspiré de Facebook, incluant une interface utilisateur moderne, des interactions en temps réel, et deux tableaux de bord pour les administrateurs et modérateurs.

 2. Description du projet

GossipChat est une plateforme sociale qui permet à des utilisateurs de :

Créer des publications,

Liker et commenter en temps réel,

Gérer leurs relations amicales,

Accéder à des interfaces de gestion pour les administrateurs et les modérateurs.
Le projet est divisé en modules frontend et backend, avec des technologies modernes pour améliorer l’expérience utilisateur.


3. Fonctionnalités principales

Authentification : inscription, connexion, réinitialisation de mot de passe

Fil d'actualité : création, suppression, affichage d'articles

Interactions : likes, dislikes, commentaires (dynamique avec AJAX et WebSocket)

Dashboard admin : gestion des utilisateurs, statistiques, signalements

Dashboard modérateur : gestion des utilisateur...

 4. Technologies utilisées (explication détaillée)

* Frontend

HTML/CSS : structure et style des pages

JavaScript : affichage dynamique des articles, boutons de likes, transitions et interactions sans rechargement

SessionStorage : gestion des données utilisateur temporaire pour les sessions

AJAX : communication asynchrone avec le serveur (sans recharger la page)


* Backend

PHP : gestion des API (authentification, articles, amis, commentaires, back office)

MySQL : stockage des données (utilisateurs, posts, likes...)

Node.js + Socket.io : gestion des messages et notifications en temps réel

 5. Installation locale (pas à pas)

 Prérequis :

PHP (>= 7.4)

MySQL ou MariaDB

Node.js (>= 14.x)

npm (Node Package Manager)


1. Cloner le projet

git clone https://github.com/TON-UTILISATEUR/GossipChat.git
cd GossipChat

2. Importer la base de données

Ouvrir phpMyAdmin

Créer une base nommée gossipchat

Importer le fichier SQL situé dans /sql/gossipchat.sql


3. Configurer la connexion MySQL

Dans le fichier config/database.php (ou similaire), modifier avec vos infos :

$host = 'localhost';
$db = 'gossipchat';
$user = 'root';
$password = '';

 4. Lancer le serveur WebSocket (pour chat/temps réel)

cd websocket-server
npm install
node index.js
 5. Lancer le backend PHP

Utilisez XAMPP ou un serveur local sur htdocs puis accédez à :

http://localhost/GossipChat/



 6. Structure du projet

GossipChat/
 ├── assets/ # images/
 ├── dashboard/# Fichiers admin/modérateur
      ├── src/  # CSS / JS
     ├── img/# Images
 ├── websocket-server/    # Node.js + Socket.io/package-lock.json/package.json
 ├── include/             # Fichiers réutilisables PHP
 ├── vues/   # profil.php/social_media.php/serveur-socket.js/ws_client.js
─ sql/  # Fichier de la base de données
├── README.md

 7. Auteurs 

Projet réalisé par l'équipe GossipDev
   LIHOUNHINTO Kevin(backend)
   d'ALMEIDA Prunelle(fronend)
   HOUNDJI John ross(backend)
   DJOSSOU Précieuse(frontend)