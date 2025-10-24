<?php
// Fichier : config/database.php

// Chemin vers le fichier .env à la racine du projet
$envPath = __DIR__ . '/../.env';

if (!file_exists($envPath)) {
    die("Le fichier d'environnement .env est manquant. Veuillez le créer.");
}

// Lire le fichier .env ligne par ligne
$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$config = [];
foreach ($lines as $line) {
    // Ignorer les commentaires
    if (strpos(trim($line), '#') === 0) {
        continue;
    }
    list($name, $value) = explode('=', $line, 2);
    $config[trim($name)] = trim($value);
}

// Utiliser les variables chargées depuis le .env
$servername = $config['DB_HOST'];
$username = $config['DB_USERNAME'];
$password = $config['DB_PASSWORD'];
$dbname = $config['DB_NAME'];

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
