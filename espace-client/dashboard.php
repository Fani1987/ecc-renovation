<?php require_once '../partials/_header.php'; ?>
<?php
require_once '../config/database.php';

// Le gardien de sécurité
if (!isset($_SESSION['client_id'])) {
    header('Location: index.php');
    exit();
}

// On récupère les informations du client connecté
$client_id = $_SESSION['client_id'];
$client_nom = $_SESSION['client_nom'];

// On récupère tous les devis associés à ce client
$sql = "SELECT id, titre, montant_total, statut, date_creation FROM devis WHERE client_id = ? ORDER BY date_creation DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
$devis = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<main>
    <div class="welcome-banner">
        <div class="container">
            <h1>Mon Espace Client</h1>
            <p>Bonjour <?php echo htmlspecialchars($client_nom); ?>, consultez vos devis ou demandez-en un nouveau.</p>
        </div>
    </div>

    <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
        <h2>Mes Devis</h2>
        <div class="table-wrapper">
            <?php if (empty($devis)): ?>
                <p>Vous n'avez aucun devis pour le moment.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Projet</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($devis as $item): ?>
                            <tr>
                                <td data-label="Date"><?php echo date('d/m/Y', strtotime($item['date_creation'])); ?></td>
                                <td data-label="Projet"><?php echo htmlspecialchars($item['titre']); ?></td>
                                <td data-label="Montant"><?php echo number_format($item['montant_total'], 2, ',', ' '); ?> €</td>
                                <td data-label="Statut" class="statut-<?php echo strtolower(str_replace(' ', '', $item['statut'])); ?>">
                                    <strong><?php echo htmlspecialchars($item['statut']); ?></strong>
                                </td>
                                <td data-label="Actions">
                                    <a href="voir_devis.php?id=<?php echo $item['id']; ?>" class="btn">Voir le détail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <hr style="margin: 60px 0;">

        <h2>Demander un nouveau devis</h2>
        <div class="form-container">
            <form action="demande_devis.php" method="POST">
                <div class="form-group">
                    <label for="message">Décrivez brièvement votre nouveau projet :</label>
                    <textarea id="message" name="message" rows="6" required placeholder="Exemple : Je souhaiterais rénover ma cuisine de 12m²..."></textarea>
                </div>
                <button type="submit">Envoyer ma demande</button>
            </form>
        </div>
    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>