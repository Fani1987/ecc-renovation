<?php
// Fichier : config/mongodb.php
require_once __DIR__ . '/../vendor/autoload.php';

// Charger les variables depuis le .env (déjà fait dans database.php, mais juste au cas où)
if (empty($config)) {
    $envPath = __DIR__ . '/../.env';
    if (!file_exists($envPath)) {
        die("Le fichier d'environnement .env est manquant.");
    }
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $config[trim($name)] = trim($value);
    }
}

// Utilise la variable MONGO_HOST du .env
$mongo_host = $config['MONGO_HOST'] ?? 'localhost';

try {
    $client = new MongoDB\Client("mongodb://$mongo_host:27017");
    $collectionMessages = $client->ecc_renovation->demandes_contact;
} catch (Exception $e) {
    die("Erreur de connexion à MongoDB : " . $e->getMessage());
}
