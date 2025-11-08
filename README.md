# PROJET : APPLICATION WEB ECC RENOVATION

Application web complète (vitrine et plateforme de gestion) pour une entreprise de rénovation. Ce projet a été réalisé dans le cadre de la préparation au Titre Professionnel Développeur Web et Web Mobile (DWWM).

L'application combine un site vitrine public pour attirer les clients et un back-office sécurisé pour la gestion commerciale (clients et devis), le tout dans un environnement de production conteneurisé.

🚀 Fonctionnalités
👨‍💻 Espace Public (Vitrine)
Accueil : Présentation de l'entreprise et de ses services.

Portfolio dynamique : Galerie des réalisations chargées dynamiquement depuis la BDD (MySQL) via une API PHP/JSON.

Formulaire de contact : Enregistre les messages des visiteurs dans la base de données NoSQL (MongoDB).

Navigation : Accès distinct à l'espace client et à la page de connexion de l'administration.

Responsive Design : Le site est entièrement adaptable aux formats mobiles (menu hamburger, tableaux en cartes).

👑 Espace Administration (Back-Office)
Connexion sécurisée pour l'administrateur (gestion de session).

Tableau de bord avec statistiques (nombre de nouveaux messages NoSQL, clients, projets).

Gestion des Réalisations (CRUD) : Ajouter ou supprimer des projets du portfolio public (avec téléversement d'image).

Gestion des Clients (CRUD) : Créer, Rechercher, Modifier et Supprimer des comptes clients.

Gestion des Messages (NoSQL) : Consulter les demandes de contact et créer un client directement depuis un message (pré-remplissage du formulaire).

Gestion des Devis (CRUD) :

Créer un nouveau devis en l'assignant à un client.

Téléverser le devis officiel (PDF) généré hors ligne.

Lister et suivre le statut de tous les devis.

Accès rapide pour créer un devis depuis la liste des clients.

👤 Espace Client
Connexion sécurisée distincte pour les clients.

Tableau de bord listant tous les devis personnels.

Consultation de devis : Voir le détail (montant, statut) et télécharger le PDF officiel.

Actions sur devis : Le client peut Accepter, Refuser ou Payer (simulé) un devis.

Nouvelle demande : Un formulaire permet à un client déjà connecté de demander un nouveau devis.

🛠️ Stack Technique
Front-end : HTML5, SCSS (Sass), JavaScript (ES6+), Fetch API

Back-end : PHP 8.1

Conteneurisation : Docker & Docker Compose

Serveur : Apache (dans un conteneur Docker)

Bases de données (Persistance Polyglotte) :

MySQL 8.0 (Relationnel) : Pour les données transactionnelles (clients, devis, projets).

MongoDB (NoSQL) : Pour les données non structurées (messages de contact).

Gestion des Dépendances : Composer (pour la bibliothèque PHP MongoDB)

Outils : Git, Visual Studio Code, Docker Desktop

Architecture : PHP "from scratch" (natif, sans framework), architecture SCSS modulaire (Partials BEM).

🏁 Installation et Lancement (via Docker)
Ce projet est entièrement conteneurisé. Vous n'avez pas besoin d'installer WAMP ou XAMPP. Seul Docker est requis.

Prérequis : Avoir Git et Docker Desktop installés et en cours d'exécution.

Cloner le dépôt :

Bash

git clone [https://github.com/Fani1987/ecc-renovation.git]
cd ecc-renovation
Configuration de l'environnement :

Créez un fichier .env à la racine du projet en copiant le modèle .env.example.

Ouvrez le fichier .env et définissez un mot de passe pour DB_PASSWORD. (Ne le laissez pas vide !).

Ini, TOML

DB_HOST=db-sql
DB_USERNAME=root
DB_PASSWORD=   # <-- METTEZ VOTRE MOT DE PASSE SÉCURISÉ ICI
DB_NAME=ecc_renovation
MONGO_HOST=db-nosql
Lancer l'environnement :

Ouvrez un terminal (PowerShell/CMD) à la racine du projet.

Lancez Docker Compose :

Bash :

docker-compose up -d --build
(Cela va construire l'image PHP, télécharger MySQL/MongoDB et démarrer les 3 conteneurs.)

Installer les dépendances PHP :

Une fois les conteneurs lancés, exécutez Composer à l'intérieur du conteneur app :

Bash

docker-compose exec app composer install
Importer la base de données (SQL) :

Assurez-vous d'avoir votre fichier ecc_renovation.sql à la racine du projet.

Copiez le fichier SQL dans le conteneur MySQL :

Bash

docker cp ecc_renovation.sql ecc_db_sql:/tmp/ecc_renovation.sql
Exécutez le script d'importation (remplacez [VOTRE_MDP_ENV] par le mot de passe de votre fichier .env) :

Bash

docker exec -i ecc_db_sql bash -c "mysql -u root -p[VOTRE_MDP_ENV] ecc_renovation < /tmp/ecc_renovation.sql"
(Note : La base de données NoSQL se créera automatiquement lors du premier envoi de message).

C'est prêt !

Ouvrez votre navigateur et allez à [http://localhost].

🔒 Sécurité
Ce projet intègre les mesures de sécurité fondamentales requises :

Protection des identifiants (BDD, etc.) grâce au fichier .env et à l'exclusion du .gitignore.

Prévention des injections SQL via l'utilisation systématique de requêtes préparées (MySQLi).

Prévention des failles XSS avec htmlspecialchars() lors de l'affichage de toute donnée provenant de la base de données.

Hachage des mots de passe (admin et clients) avec password_hash() et password_verify().

Gestion des sessions pour une séparation stricte des rôles (Admin, Client, Visiteur).

Validation des fichiers téléversés (type et déplacement sécurisé).
