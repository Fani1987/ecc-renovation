<?php
// On charge la connexion MongoDB et l'autoloader de Composer
require_once '../config/mongodb.php';

// On indique que la réponse sera du JSON
header('Content-Type: application/json');

// On vérifie que la méthode de requête est bien POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // --- SÉCURITÉ : RÉCUPÉRATION ET NETTOYAGE DES DONNÉES ---
    $nom = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validation simple : on vérifie que les champs ne sont pas vides
    if (empty($nom) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'L\'adresse e-mail n\'est pas valide.']);
        exit();
    }

    // --- INSERTION DANS MONGODB ---
    try {
        // On insère un "document" dans la collection
        $insertResult = $collectionMessages->insertOne([
            'nom' => $nom,
            'email' => $email,
            'message' => $message,
            'date_soumission' => new MongoDB\BSON\UTCDateTime(), // Format de date NoSQL
            'statut' => 'nouveau'
        ]);

        // On vérifie si l'insertion a réussi
        if ($insertResult->getInsertedCount() === 1) {
            echo json_encode(['success' => true, 'message' => 'Votre message a bien été envoyé. Nous vous répondrons rapidement !']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Une erreur est survenue lors de l\'enregistrement.']);
        }
    } catch (Exception $e) {
        // Gère les erreurs de connexion ou d'insertion
        echo json_encode(['success' => false, 'message' => 'Erreur de base de données NoSQL : ' . $e->getMessage()]);
    }
} else {
    // Si la méthode n'est pas POST, on renvoie une erreur
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}
