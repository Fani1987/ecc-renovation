<?php
session_start();
require_once '../config/database.php';

// Gardien de sécurité : client connecté
if (!isset($_SESSION['client_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

// Vérifier si une action et un ID sont passés dans l'URL
if (!isset($_GET['action']) || !isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$action = $_GET['action'];
$devis_id = intval($_GET['id']);
$client_id = $_SESSION['client_id'];

// On vérifie que le devis appartient bien au client avant toute action
$stmt = $conn->prepare("SELECT statut FROM devis WHERE id = ? AND client_id = ?");
$stmt->bind_param("ii", $devis_id, $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // Tentative d'action sur un devis non autorisé
    header('Location: dashboard.php');
    exit();
}
$devis = $result->fetch_assoc();
$stmt->close();

// Logique des actions
$nouveau_statut = '';
$date_validation = null;

if ($action == 'accept' && $devis['statut'] == 'En attente') {
    $nouveau_statut = 'Accepté';
    $date_validation = date('Y-m-d'); // Date du jour
} elseif ($action == 'refuse' && $devis['statut'] == 'En attente') {
    $nouveau_statut = 'Refusé';
} elseif ($action == 'pay' && $devis['statut'] == 'Accepté') {
    $nouveau_statut = 'Payé';
}

// Si un changement de statut est valide, on met à jour la base de données
if (!empty($nouveau_statut)) {
    if ($date_validation) {
        $stmt_update = $conn->prepare("UPDATE devis SET statut = ?, date_validation = ? WHERE id = ?");
        $stmt_update->bind_param("ssi", $nouveau_statut, $date_validation, $devis_id);
    } else {
        $stmt_update = $conn->prepare("UPDATE devis SET statut = ? WHERE id = ?");
        $stmt_update->bind_param("si", $nouveau_statut, $devis_id);
    }
    $stmt_update->execute();
    $stmt_update->close();
}

$conn->close();

// On redirige toujours vers le tableau de bord après une action
header('Location: dashboard.php');
exit();
