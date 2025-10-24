<?php require_once '../partials/_header.php'; ?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}
$admin_nom = $_SESSION['admin_nom'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une Réalisation</title>
    <link rel="stylesheet" href="../css/admin.min.css">
</head>

<body>
    <header>
        <h1>Tableau de Bord - ECC Rénovation</h1>
        <nav>
            <a href="dashboard.php">Accueil</a>
            <a href="projets.php">Gérer les Réalisations</a>
            <a href="messages.php">Voir les Messages</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>

    <main class="container">
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