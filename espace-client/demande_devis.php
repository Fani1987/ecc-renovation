<?php
session_start();
require_once '../config/database.php';

// Gardien de sécurité : le client doit être connecté
if (!isset($_SESSION['client_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_texte = trim($_POST['message']);

    // On récupère les infos du client depuis la session
    $client_id = $_SESSION['client_id'];

    // On va chercher l'email et le nom du client dans la BDD pour les insérer avec le message
    $stmt_client = $conn->prepare("SELECT nom_complet, email FROM clients WHERE id = ?");
    $stmt_client->bind_param("i", $client_id);
    $stmt_client->execute();
    $result_client = $stmt_client->get_result();
    $client_data = $result_client->fetch_assoc();
    $stmt_client->close();

    $nom = $client_data['nom_complet'] . " (Client existant)";
    $email = $client_data['email'];

    if (empty($message_texte)) {
        die("Le message ne peut pas être vide.");
    }

    // On insère la demande dans la même table que les contacts publics
    $sql = "INSERT INTO demandes_contact (nom, email, message) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql);
    $stmt_insert->bind_param("sss", $nom, $email, $message_texte);
    $stmt_insert->execute();
    $stmt_insert->close();
    $conn->close();

    // On redirige vers le tableau de bord avec un message de succès (facultatif mais recommandé)
    header('Location: dashboard.php?success=1');
    exit();
}
