<?php
session_start();
require_once '../config/database.php';

// On vérifie que seul un admin peut exécuter ce script
if (!isset($_SESSION['admin_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

// --- GESTION DE L'AJOUT D'UN CLIENT ---
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $nom_complet = trim($_POST['nom_complet']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $adresse = trim($_POST['adresse']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Validation simple
    if (empty($nom_complet) || empty($email) || empty($mot_de_passe)) {
        die("Erreur : Le nom, l'email et le mot de passe sont obligatoires.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erreur : L'adresse email n'est pas valide.");
    }

    // Hachage sécurisé du mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Insertion en base de données avec une requête préparée
    $sql = "INSERT INTO clients (nom_complet, email, telephone, adresse, mot_de_passe) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nom_complet, $email, $telephone, $adresse, $mot_de_passe_hache);
    $stmt->execute();
    $stmt->close();

    header('Location: clients.php');
    exit();
}

// --- GESTION DE LA SUPPRESSION D'UN CLIENT ---
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);

    // Suppression avec une requête préparée
    // Rappel : la règle "ON DELETE CASCADE" supprimera automatiquement les devis liés.
    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header('Location: clients.php');
    exit();
}

$conn->close();
