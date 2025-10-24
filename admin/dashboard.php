<?php require_once '../partials/_header.php'; ?>

<?php
require_once '../config/database.php';

// Le gardien de sécurité
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// Compter le nombre de messages
$count_messages = $conn->query("SELECT COUNT(id) as total FROM demandes_contact")->fetch_assoc()['total'];
// Compter le nombre de projets
$count_projets = $conn->query("SELECT COUNT(id) as total FROM projets")->fetch_assoc()['total'];
// NOUVELLE LIGNE : Compter le nombre de clients
$count_clients = $conn->query("SELECT COUNT(id) as total FROM clients")->fetch_assoc()['total'];

$conn->close();
?>

<main class="container">
    <h2>Bienvenue sur votre tableau de bord</h2>
    <div class="dashboard-grid">

        <div class="card">
            <i class="fas fa-envelope"></i>
            <h3>Messages Reçus</h3>
            <p class="count"><?php echo $count_messages; ?></p>
            <a href="messages.php">Consulter les messages</a>
        </div>

        <div class="card">
            <i class="fas fa-hard-hat"></i>
            <h3>Réalisations</h3>
            <p class="count"><?php echo $count_projets; ?></p>
            <a href="projets.php">Gérer les réalisations</a>
        </div>

        <div class="card">
            <i class="fas fa-users"></i>
            <h3>Clients</h3>
            <p class="count"><?php echo $count_clients; ?></p>
            <a href="clients.php">Gérer les clients</a>
        </div>

        <div class="card card-action">
            <i class="fas fa-plus-circle"></i>
            <h3>Action Rapide</h3>
            <p>Ajouter un nouveau client.</p>
            <a href="client_form.php">Nouveau Client</a>
        </div>

    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>