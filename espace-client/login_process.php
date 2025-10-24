<?php
session_start();
require_once '../config/database.php'; // On utilise notre fichier de connexion central

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mot_de_passe_saisi = $_POST['password'];

    // On cherche le client par son email dans la table 'clients'
    $sql = "SELECT * FROM clients WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $client = $result->fetch_assoc();

        // On vérifie le mot de passe haché
        if (password_verify($mot_de_passe_saisi, $client['mot_de_passe'])) {
            // Le mot de passe est correct, on stocke les infos du client en session
            $_SESSION['client_id'] = $client['id'];
            $_SESSION['client_nom'] = $client['nom_complet'];

            // On redirige vers le tableau de bord client
            header('Location: dashboard.php');
            exit();
        }
    }

    // Si l'email n'existe pas ou si le mot de passe est incorrect
    $_SESSION['error_message'] = "Email ou mot de passe incorrect.";
    header('Location: index.php'); // Redirection vers la page de connexion client
    exit();
}
$conn->close();
