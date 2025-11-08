<?php
// 1. DÉMARRER LA SESSION
require_once '../partials/_session_start.php';

// 2. LOGIQUE PHP
// Le gardien de sécurité
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}
// On récupère le nom de l'admin pour le message d'accueil dans le header
$admin_nom = $_SESSION['admin_nom'];

// 3. INCLURE L'EN-TÊTE HTML
require_once '../partials/_header.php';
?>

<main class="container">
    <br>
    <h2>Ajouter une nouvelle réalisation</h2>
    <div class="form-container">
        <form action="projet_actions.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="titre">Titre de la réalisation</label>
                <input type="text" id="titre" name="titre" required>
            </div>
            <div class="form-group">
                <label for="image">Image du projet</label>
                <input type="file" id="image" name="image" required accept="image/jpeg, image/png, image/gif">
            </div>
            <button type="submit">Ajouter le projet</button>
        </form>
    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>