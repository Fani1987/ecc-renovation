<?php
// 1. DÉMARRER LA SESSION
require_once '../partials/_session_start.php';
// 2. CONNEXION À LA BASE DE DONNÉES
require_once '../config/database.php';


// --- TRAITEMENT DU FORMULAIRE ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mot_de_passe_saisi = $_POST['password'];

    // On cherche l'admin par email
    $sql = "SELECT * FROM administrateurs WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // On vérifie le mot de passe haché
        if (password_verify($mot_de_passe_saisi, $admin['mot_de_passe'])) {
            // Le mot de passe est correct !
            // On stocke les infos de l'admin en session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nom'] = $admin['nom'];

            // On redirige vers le tableau de bord
            header('Location: dashboard.php');
            exit();
        }
    }

    // Si l'email n'existe pas ou si le mot de passe est incorrect
    $_SESSION['error_message'] = "Email ou mot de passe incorrect.";
    header('Location: index.php'); // Redirection vers la page de connexion
    exit();
}
