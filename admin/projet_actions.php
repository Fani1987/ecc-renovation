<?php
session_start();
require_once '../config/database.php';
// Gardien de sécurité pour s'assurer que l'administrateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}



// --- GESTION DE L'AJOUT D'UN PROJET ---
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $titre = trim($_POST['titre']);

    // Vérification basique des données
    if (empty($titre) || !isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
        die("Erreur : Le titre et l'image sont obligatoires.");
    }

    // Gestion de l'upload de l'image
    $target_dir = "../Images/"; // Le dossier où stocker les images
    $image_name = uniqid() . '_' . basename($_FILES["image"]["name"]); // Crée un nom de fichier unique
    $target_file = $target_dir . $image_name;
    $image_path_for_db = "/Images/" . $image_name; // Chemin à stocker en BDD

    // Déplacer le fichier uploadé
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Le fichier est uploadé, on insère en BDD
        $sql = "INSERT INTO projets (titre, chemin_image) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $titre, $image_path_for_db);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Erreur lors de l'upload de l'image.");
    }

    // Redirection vers la liste des projets
    header('Location: projets.php');
    exit();
}

// --- GESTION DE LA SUPPRESSION D'UN PROJET ---
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']); // Sécurité : on s'assure que l'ID est un entier

    // 1. Récupérer le chemin de l'image avant de supprimer l'entrée BDD
    $sql_select = "SELECT chemin_image FROM projets WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    if ($row = $result->fetch_assoc()) {
        $image_path_to_delete = ".." . $row['chemin_image'];
        // 2. Supprimer le fichier image du serveur
        if (file_exists($image_path_to_delete)) {
            unlink($image_path_to_delete);
        }
    }
    $stmt_select->close();

    // 3. Supprimer l'entrée dans la base de données
    $sql_delete = "DELETE FROM projets WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);
    $stmt_delete->execute();
    $stmt_delete->close();

    // Redirection vers la liste
    header('Location: projets.php');
    exit();
}

$conn->close();
