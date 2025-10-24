<?php require_once '../partials/_header.php'; ?>
<?php
require_once '../config/database.php';

// Le gardien de sécurité
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// On récupère tous les devis avec les informations du client associé grâce à une JOINTURE SQL
$sql = "SELECT 
            d.id, 
            d.titre, 
            d.montant_total, 
            d.statut, 
            d.date_creation, 
            c.nom_complet as client_nom 
        FROM devis d 
        JOIN clients c ON d.client_id = c.id 
        ORDER BY d.date_creation DESC";
$result = $conn->query($sql);
$devis = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<main class="container">
    <h2>Gestion des Devis</h2>
    <a href="devis_form.php" class="btn" style="margin-bottom: 20px; display: inline-block;">Créer un nouveau devis</a>

    <div class="table-wrapper">
        <?php if (empty($devis)): ?>
            <p>Aucun devis n'a été créé pour le moment.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Titre du projet</th>
                        <th>Montant</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($devis as $item): ?>
                        <tr>
                            <td data-label="Date"><?php echo date('d/m/Y', strtotime($item['date_creation'])); ?></td>
                            <td data-label="Client"><?php echo htmlspecialchars($item['client_nom']); ?></td>
                            <td data-label="Titre du projet"><?php echo htmlspecialchars($item['titre']); ?></td>
                            <td data-label="Montant"><?php echo number_format($item['montant_total'], 2, ',', ' '); ?> €</td>
                            <td data-label="Statut" class="statut-<?php echo strtolower(str_replace(' ', '', $item['statut'])); ?>">
                                <strong><?php echo htmlspecialchars($item['statut']); ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>