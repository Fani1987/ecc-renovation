<?php
// 1. Démarrer la session
require_once '../partials/_session_start.php';
// 2. Connexion à MySQL (pour LIRE les infos du client)
require_once '../config/database.php';
// 3. Connexion à MongoDB (pour ÉCRIRE le message)
require_once '../config/mongodb.php';

// Gardien de sécurité : le client doit être connecté
if (!isset($_SESSION['client_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_texte = trim($_POST['message']);

    // On récupère les infos du client depuis la session
    $client_id = $_SESSION['client_id'];

    // --- ÉTAPE 1 : LECTURE DEPUIS MYSQL ---
    $stmt_client = $conn->prepare("SELECT nom_complet, email FROM clients WHERE id = ?");
    $stmt_client->bind_param("i", $client_id);
    $stmt_client->execute();
    $result_client = $stmt_client->get_result();
    $client_data = $result_client->fetch_assoc();
    $stmt_client->close();
    $conn->close(); // On ferme la connexion MySQL

    $nom = $client_data['nom_complet'] . " (Client existant)";
    $email = $client_data['email'];

    if (empty($message_texte)) {
        die("Le message ne peut pas être vide.");
    }

    // --- ÉTAPE 2 : ÉCRITURE DANS MONGODB ---
    try {
        $insertResult = $collectionMessages->insertOne([
            'nom' => $nom,
            'email' => $email,
            'message' => $message_texte,
            'date_soumission' => new MongoDB\BSON\UTCDateTime(),
            'statut' => 'nouveau'
        ]);

        if ($insertResult->getInsertedCount() === 1) {
            header('Location: dashboard.php?success=1');
            exit();
        } else {
            die("Une erreur est survenue lors de l'enregistrement dans MongoDB.");
        }
    } catch (Exception $e) {
        die("Erreur de base de données NoSQL : " . $e->getMessage());
    }
}
