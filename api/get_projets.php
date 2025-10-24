<?php
require_once '../config/database.php';
// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- RÉCUPÉRATION DES PROJETS ---
$sql = "SELECT id, titre, chemin_image FROM projets ORDER BY date_creation DESC";
$result = $conn->query($sql);

$projets = [];
if ($result->num_rows > 0) {
    // fetch_assoc() récupère chaque ligne comme un tableau associatif
    while ($row = $result->fetch_assoc()) {
        $projets[] = $row;
    }
}

// --- ENVOI DES DONNÉES EN JSON ---
// On indique au navigateur que la réponse est du JSON
header('Content-Type: application/json');

// On encode le tableau PHP $projets en une chaîne de caractères JSON
echo json_encode($projets);

// On ferme la connexion
$conn->close();
