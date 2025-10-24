<?php
// On indique que la réponse sera du JSON
header('Content-Type: application/json');

// On vérifie que la méthode de requête est bien POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // --- CONNEXION À LA BASE DE DONNÉES ---
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecc_renovation";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        // En cas d'erreur de connexion, on envoie une réponse d'erreur
        echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données.']);
        exit(); // On arrête le script
    }

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

    // --- PRÉPARATION DE LA REQUÊTE POUR ÉVITER LES INJECTIONS SQL ---
    $sql = "INSERT INTO demandes_contact (nom, email, message) VALUES (?, ?, ?)";

    // On prépare la requête
    $stmt = $conn->prepare($sql);

    // On lie les variables aux marqueurs '?' en spécifiant leur type ('s' pour string)
    // C'est l'étape cruciale pour la sécurité !
    $stmt->bind_param("sss", $nom, $email, $message);

    // On exécute la requête et on vérifie le résultat
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Votre message a bien été envoyé. Nous vous répondrons rapidement !']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Une erreur est survenue. Veuillez réessayer.']);
    }

    // On ferme le statement et la connexion
    $stmt->close();
    $conn->close();
} else {
    // Si la méthode n'est pas POST, on renvoie une erreur
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}
