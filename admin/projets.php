<?php require_once '../partials/_header.php'; ?>
<?php
require_once '../config/database.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

$sql = "SELECT id, titre, chemin_image FROM projets ORDER BY date_creation DESC";
$result = $conn->query($sql);

$projets = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projets[] = $row;
    }
}
$conn->close();
$admin_nom = $_SESSION['admin_nom'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gérer les Réalisations</title>
    <link rel="stylesheet" href="../css/admin.min.css">
</head>

<body>

    <main class="table-wrapper">
        <h2>Gérer les Réalisations</h2>
        <a href="projet_form.php" class="add-button">Ajouter une nouvelle réalisation</a>

        <table>
            <thead>
                <tr>
                    <th>Aperçu</th>
                    <th>Titre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projets as $projet): ?>
                    <tr>
                        <td data-label="Aperçu"><img src="../<?php echo htmlspecialchars($projet['chemin_image']); ?>" alt="Aperçu" class="thumbnail"></td>
                        <td data-label="Titre"><?php echo htmlspecialchars($projet['titre']); ?></td>
                        <td data-label="Actions" class="actions">
                            <a href="projet_actions.php?action=delete&id=<?php echo $projet['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réalisation ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <?php require_once '../partials/_footer.php'; ?>