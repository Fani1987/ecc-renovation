<?php require_once '../partials/_header.php'; ?>
<?php
require_once '../config/database.php';

// Le gardien de sécurité
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// Récupération des messages
$result = $conn->query("SELECT * FROM demandes_contact ORDER BY date_soumission DESC");
$messages = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<main class="container">
    <h2>Messages Reçus</h2>

    <div class="table-wrapper">
        <?php if (empty($messages)): ?>
            <p>Il n'y a aucun message pour le moment.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td data-label="Date"><?php echo date('d/m/Y H:i', strtotime($message['date_soumission'])); ?></td>
                            <td data-label="Nom"><?php echo htmlspecialchars($message['nom']); ?></td>
                            <td data-label="Email"><?php echo htmlspecialchars($message['email']); ?></td>
                            <td data-label="Message"><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                            <td data-label="Statut" class="statut-<?php echo strtolower($message['statut']); ?>">
                                <strong><?php echo htmlspecialchars(ucfirst($message['statut'])); ?></strong>
                            </td>
                            <td class="actions">
                                <?php
                                $nom_url = urlencode($message['nom']);
                                $email_url = urlencode($message['email']);
                                ?>
                                <a href="client_form.php?nom=<?php echo $nom_url; ?>&email=<?php echo $email_url; ?>" class="btn-action">Créer Client</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>