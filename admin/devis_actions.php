<?php
// 1. DÉMARRER LA SESSION
require_once '../partials/_session_start.php';
// 2. CONNEXION À LA BASE DE DONNÉES
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $client_id = intval($_POST['client_id']);
    $titre = trim($_POST['titre']);
    $montant_total = floatval($_POST['montant_total']);
    $fichier_path = null;

    if (isset($_FILES['devis_file']) && $_FILES['devis_file']['error'] == 0) {
        $target_dir = "../devis_files/";
        $file_name = uniqid() . '-' . basename($_FILES["devis_file"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["devis_file"]["tmp_name"], $target_file)) {
            $fichier_path = "/devis_files/" . $file_name;
        } else {
            die("Erreur critique lors de l'upload du fichier.");
        }
    } else {
        die("Aucun fichier n'a été uploadé ou une erreur est survenue.");
    }

    $sql = "INSERT INTO devis (client_id, titre, montant_total, fichier_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $client_id, $titre, $montant_total, $fichier_path);
    $stmt->execute();
    $stmt->close();

    header('Location: devis.php');
    exit();
}
$conn->close();
