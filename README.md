# PROJET : APPLICATION WEB ECC RENOVATION

Application web complète (vitrine et plateforme de gestion) pour une entreprise de rénovation. Ce projet a été réalisé dans le cadre de la préparation au Titre Professionnel Développeur Web et Web Mobile (DWWM).

L'application combine un site vitrine public pour attirer les clients et un back-office sécurisé pour la gestion commerciale (clients et devis).

🚀 Fonctionnalités
👨‍💻 Espace Public (Vitrine)
Accueil : Présentation de l'entreprise et de ses services.

Portfolio dynamique : Galerie des réalisations chargées dynamiquement depuis la base de données via une API PHP/JSON.

Formulaire de contact : Enregistre les messages des visiteurs dans la base de données.

Navigation : Accès distinct à l'espace client et à la page de connexion de l'administration.

Responsive Design : Le site est entièrement adaptable aux formats mobiles (menu hamburger, tableaux en cartes).

👑 Espace Administration (Back-Office)
Connexion sécurisée pour l'administrateur (gestion de session).

Tableau de bord avec statistiques (nombre de messages, clients, projets).

Gestion des Réalisations (CRUD) : Ajouter ou supprimer des projets du portfolio public (avec téléversement d'image).

Gestion des Clients (CRUD) : Créer des comptes clients, rechercher un client par nom.

Gestion des Messages : Consulter les demandes de contact et créer un client directement depuis un message (pré-remplissage du formulaire).

Gestion des Devis (CRUD) :

Créer un nouveau devis en l'assignant à un client.

Téléverser le devis officiel (PDF) généré hors ligne.

Lister et suivre le statut de tous les devis (En attente, Accepté, Payé...).

Accès rapide pour créer un devis depuis la liste des clients.

👤 Espace Client
Connexion sécurisée distincte pour les clients.

Tableau de bord listant tous les devis personnels.

Consultation de devis : Voir le détail (montant, statut) et télécharger le PDF officiel.

Actions sur devis : Le client peut Accepter, Refuser ou Payer (simulé) un devis.

Nouvelle demande : Un formulaire permet à un client déjà connecté de demander un nouveau devis.

🛠️ Stack Technique
Front-end : HTML5, SCSS (Sass), JavaScript (ES6+), Fetch API

Back-end : PHP 8+

Base de données : MySQL

Serveur : Apache (via XAMPP / WAMP)

Outils : Git, Visual Studio Code

Architecture : PHP "from scratch" (natif, sans framework), architecture SCSS modulaire (Partials BEM).

🏁 Installation et Lancement
Cloner le dépôt :

Bash

git clone https://github.com/Fani1987/ecc-renovation.git
cd ecc-renovation
Base de données :

Créez une base de données (ex: ecc_renovation) via phpMyAdmin.

Importez le script SQL ecc_renovation.sql (pensez à l'exporter depuis votre phpMyAdmin) pour créer toutes les tables.

Configuration de l'environnement :

Créez un fichier .env à la racine du projet en copiant le modèle .env.example.

Remplissez vos identifiants de base de données :

Ini, TOML

DB_HOST=localhost
DB_USERNAME=root
DB_PASSWORD=
DB_NAME=ecc_renovation
Lancer le projet :

Placez le dossier du projet dans votre répertoire htdocs (XAMPP) ou www (WAMP).

Démarrez les services Apache et MySQL.

Ouvrez votre navigateur et allez à http://localhost/eccrenovation/ (adaptez le nom du dossier si besoin).

Compiler le SCSS (en cas de modification) :

Si vous modifiez les styles, utilisez l'extension "Live Sass Compiler" sur VS Code et cliquez sur "Watch Sass".

🔒 Sécurité
Ce projet intègre les mesures de sécurité fondamentales requises :

Protection des identifiants grâce au fichier .env et à l'exclusion du .gitignore.

Prévention des injections SQL via l'utilisation systématique de requêtes préparées (MySQLi).

Prévention des failles XSS avec htmlspecialchars() lors de l'affichage de toute donnée provenant de la base de données.

Hachage des mots de passe (admin et clients) avec password_hash() et password_verify().

Gestion des sessions pour une séparation stricte des rôles (Admin, Client, Visiteur).

Validation des fichiers téléversés (type et déplacement sécurisé).