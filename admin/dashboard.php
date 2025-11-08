<?php
// 1. DÉMARRER LA SESSION
require_once '../partials/_session_start.php';

// 2. CONNEXION AUX BASES DE DONNÉES
require_once '../config/database.php'; // Pour les projets et clients (SQL)
require_once '../config/mongodb.php'; // Pour les messages (NoSQL)

// Le gardien de sécurité
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// --- LECTURE SQL (MySQL) ---
$count_projets = $conn->query("SELECT COUNT(id) as total FROM projets")->fetch_assoc()['total'];
$count_clients = $conn->query("SELECT COUNT(id) as total FROM clients")->fetch_assoc()['total'];
$conn->close(); // On ferme la connexion SQL

// --- LECTURE NoSQL (MongoDB) ---
$count_new_messages = $collectionMessages->countDocuments(['statut' => 'nouveau']);

// 3. INCLURE L'EN-TÊTE HTML
require_once '../partials/_header.php';
?>

<main class="container">
    <h2>Bienvenue sur votre tableau de bord</h2>
    <div class="dashboard-grid">

        <div class="card">
            <i class="fas fa-envelope"></i>
            <h3>Messages Reçus</h3>
            <p class="count"><?php echo $count_new_messages; ?></p>
            <a href="messages.php" class="btn">Consulter</a>
        </div>

        <div class="card">
            <i class="fas fa-hard-hat"></i>
            <h3>Réalisations</h3>
            <p class="count"><?php echo $count_projets; ?></p>
            <a href="projets.php" class="btn">Gérer</a>
        </div>

        <div class="card">
            <i class="fas fa-users"></i>
            <h3>Clients</h3>
            <p class="count"><?php echo $count_clients; ?></p>
            <a href="clients.php" class="btn">Gérer</a>
        </div>

        <div class="card card-action">
            <i class="fas fa-plus-circle"></i>
            <h3>Action Rapide</h3>
            <p>Ajouter un nouveau client.</p>
            <a href="client_form.php" class="btn">Nouveau Client</a>
        </div>

    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>