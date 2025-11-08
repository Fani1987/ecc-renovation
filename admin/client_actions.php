<?php
// 1. DÉMARRER LA SESSION (Authentification)
require_once '../partials/_session_start.php';
// 2. CONNEXION À LA BASE DE DONNÉES (Pour les opérations CRUD  Create, Read, Update, Delete)
require_once '../config/database.php';



// 3. GARDIEN DE SÉCURITÉ 
// On vérifie que la variable de session 'admin_id' existe.
// Cette variable n'a pu être créée que par le script 'login_process.php'.
if (!isset($_SESSION['admin_id'])) {
    // Si la session n'existe pas, l'utilisateur n'est pas un admin connecté.
    // On lui envoie un code "403 Forbidden" (Accès Interdit).
    header('HTTP/1.1 403 Forbidden');
    // On arrête le script immédiatement.
    exit();
}



// --- GESTION DE LA CRÉATION (CREATE) ---
// ROUTEUR D'ACTION (Logique "Create")
// On vérifie que le formulaire a été envoyé (POST) et qu'il contient
// un champ 'action' avec la valeur 'add'.
if (isset($_POST['action']) && $_POST['action'] == 'add') {

    // 3. RÉCUPÉRATION ET NETTOYAGE DES DONNÉES
    // On récupère les données du formulaire et on supprime les espaces
    // superflus au début ou à la fin avec trim().
    $nom_complet = trim($_POST['nom_complet']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $adresse = trim($_POST['adresse']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // 4. VALIDATION DES DONNÉES
    // On vérifie que les champs obligatoires ne sont pas vides.
    if (empty($nom_complet) || empty($email) || empty($mot_de_passe)) {
        // die() arrête le script et affiche un message. C'est une validation simple.
        die("Erreur : Le nom, l'email et le mot de passe sont obligatoires.");
    }
    // On utilise une fonction PHP robuste pour valider le format de l'email.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erreur : L'adresse email n'est pas valide.");
    }

    // 5. SÉCURITÉ : HACHAGE DU MOT DE PASSE
    // On ne stocke JAMAIS un mot de passe en clair.
    // On utilise password_hash() qui applique l'algorithme BCRYPT (sécurisé).
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // 6. INSERTION SÉCURISÉE (Requête Préparée contre l'injection SQL)
    // On définit le "modèle" de la requête avec des '?' comme marqueurs.
    $sql = "INSERT INTO clients (nom_complet, email, telephone, adresse, mot_de_passe) VALUES (?, ?, ?, ?, ?)";

    // On prépare la requête (on envoie le modèle au serveur MySQL).
    $stmt = $conn->prepare($sql);

    // On lie les variables aux marqueurs '?' (on envoie les données séparément).
    // "sssss" signifie que les 5 variables sont des chaînes de caractères (strings).
    // La BDD traite ces données comme du texte, jamais comme du code SQL.
    $stmt->bind_param("sssss", $nom_complet, $email, $telephone, $adresse, $mot_de_passe_hache);

    // On exécute la requête finale.
    $stmt->execute();
    // On ferme la requête préparée.
    $stmt->close();

    // 7. REDIRECTION
    // Une fois le client créé, on redirige l'administrateur vers la liste des clients.
    header('Location: clients.php');
    exit(); // On arrête le script.
}


// --- GESTION DE LA MODIFICATION (UPDATE) ---

// Vérifie que le formulaire a été envoyé avec l'action "edit"
if (isset($_POST['action']) && $_POST['action'] == 'edit') {

    // 1. RÉCUPÉRATION ET NETTOYAGE DES DONNÉES
    // Récupère l'ID du client, forcé en entier (intval) pour la sécurité
    $client_id = intval($_POST['client_id']);
    // Récupère les données texte en supprimant les espaces blancs au début/fin
    $nom_complet = trim($_POST['nom_complet']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $adresse = trim($_POST['adresse']);
    $mot_de_passe = $_POST['mot_de_passe']; // Récupère le champ (peut être vide)

    // 2. VALIDATION DES DONNÉES
    // S'assure que les champs critiques ne sont pas vides
    if (empty($nom_complet) || empty($email) || $client_id == 0) {
        die("Erreur : Le nom, l'email et l'ID client sont obligatoires.");
    }

    // 3. LOGIQUE MÉTIER CONDITIONNELLE (Mot de passe)
    // C'est le cœur de la logique "Update" :
    // On vérifie si un NOUVEAU mot de passe a été saisi.
    if (!empty($mot_de_passe)) {

        // CAS 1 : L'admin a fourni un nouveau mot de passe
        // On hache le nouveau mot de passe pour le stocker en toute sécurité
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // On prépare une requête SQL qui met à jour TOUS les champs, y compris le mot de passe
        $sql = "UPDATE clients SET nom_complet = ?, email = ?, telephone = ?, adresse = ?, mot_de_passe = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        // On lie 6 paramètres ("sssssi" -> 5 strings, 1 integer)
        $stmt->bind_param("sssssi", $nom_complet, $email, $telephone, $adresse, $mot_de_passe_hache, $client_id);
    } else {

        // CAS 2 : Le champ mot de passe a été laissé vide
        // On prépare une requête SQL qui met à jour tous les champs SAUF le mot de passe
        $sql = "UPDATE clients SET nom_complet = ?, email = ?, telephone = ?, adresse = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        // On ne lie que 5 paramètres ("ssssi" -> 4 strings, 1 integer)
        $stmt->bind_param("ssssi", $nom_complet, $email, $telephone, $adresse, $client_id);
    }

    // 4. EXÉCUTION
    // Exécute la requête préparée (soit celle avec mdp, soit celle sans)
    $stmt->execute();
    $stmt->close();

    // 5. REDIRECTION
    // Redirige l'admin vers la page de recherche, en affichant directement le client modifié
    header('Location: clients.php?search=' . urlencode($nom_complet));
    exit();
}

// --- GESTION DE LA SUPPRESSION D'UN CLIENT ---

// 1. ROUTEUR D'ACTION (Logique "Delete")
// Vérifie si l'URL contient les paramètres (ex: ...?action=delete&id=12)
if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    // 2. SÉCURISATION DE L'ENTRÉE
    // Récupère l'ID depuis l'URL et le force à être un nombre entier.
    // C'est une mesure de sécurité cruciale (assainissement)
    // pour empêcher les injections SQL via le paramètre 'id'.
    $id = intval($_GET['id']);

    // 3. PRÉPARATION DE LA REQUÊTE (Sécurité)
    // Définit le "modèle" SQL avec un marqueur de position '?'.
    $sql = "DELETE FROM clients WHERE id = ?";
    // Prépare la requête, la séparant des données.
    $stmt = $conn->prepare($sql);

    // Lie la variable $id (qui est un entier) au marqueur '?'.
    // Le "i" signifie que la variable est de type Integer.
    $stmt->bind_param("i", $id);

    // 4. EXÉCUTION
    // Exécute la suppression dans la base de données.
    $stmt->execute();
    // Ferme la requête préparée.
    $stmt->close();

    // 5. REDIRECTION
    // Redirige l'administrateur vers la page de gestion des clients.
    header('Location: clients.php');
    // Arrête le script pour s'assurer qu'aucun autre code n'est exécuté.
    exit();
}

$conn->close();
