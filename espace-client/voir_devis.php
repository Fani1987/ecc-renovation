<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['client_id'])) {
    header('Location: index.php');
    exit();
}
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$devis_id = intval($_GET['id']);
$client_id = $_SESSION['client_id'];

$sql = "SELECT * FROM devis WHERE id = ? AND client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $devis_id, $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header('Location: dashboard.php');
    exit();
}
$devis = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détail du Devis</title>
    <link rel="stylesheet" href="../css/main.min.css">
</head>

<body>
    <?php require_once '../partials/_header.php'; ?>
    <main class="container">
        <div class="devis-details">
            <div class="devis-header">
                <h2><?php echo htmlspecialchars($devis['titre']); ?></h2>
                <p><strong>Montant Total :</strong> <span><?php echo number_format($devis['montant_total'], 2, ',', ' '); ?> €</span></p>
                <p><strong>Statut :</strong> <strong><?php echo htmlspecialchars($devis['statut']); ?></strong></p>
            </div>

            <?php if (!empty($devis['fichier_path'])): ?>
                <div class="devis-download">
                    <h3>Document Officiel</h3>
                    <p>Téléchargez le document PDF détaillé pour consulter toutes les informations du projet.</p>
                    <a href="../<?php echo htmlspecialchars($devis['fichier_path']); ?>" class="btn" target="_blank">Télécharger le devis (PDF)</a>
                </div>
            <?php endif; ?>

            <?php if ($devis['statut'] == 'En attente'): ?>
                <div class="devis-actions">
                    <a href="devis_action.php?action=accept&id=<?php echo $devis['id']; ?>" class="btn btn-accept">Accepter le devis</a>
                    <a href="devis_action.php?action=refuse&id=<?php echo $devis['id']; ?>" class="btn btn-refuse">Refuser le devis</a>
                </div>
            <?php elseif ($devis['statut'] == 'Accepté'): ?>
                <div class="devis-actions">
                    <a href="devis_action.php?action=pay&id=<?php echo $devis['id']; ?>" class="btn">Procéder au paiement (Simulation)</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php require_once '../partials/_footer.php'; ?>
</body>

</html>