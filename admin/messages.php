<?php
// 1. DÉMARRER LA SESSION
require_once '../partials/_session_start.php';

// 2. CONNEXION À LA BASE DE DONNÉES
require_once '../config/mongodb.php'; // On charge la connexion MongoDB

// Le gardien de sécurité (maintenant il est AVANT l'en-tête HTML)
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// Récupération des messages depuis MongoDB
// On cherche tous les documents, avec une option pour les trier
$messagesCursor = $collectionMessages->find(
    [], // Pas de filtre, on prend tout
    ['sort' => ['date_soumission' => -1]] // Trier par date de soumission, la plus récente en premier
);

// On convertit le "curseur" (le résultat) en un tableau PHP
$messages = $messagesCursor->toArray();

// 3. INCLURE L'EN-TÊTE HTML
require_once '../partials/_header.php';
?>

<main class="container">
    <h2>Messages Reçus (NoSQL)</h2>
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
                            <td data-label="Date"><?php echo $message['date_soumission']->toDateTime()->format('d/m/Y H:i'); ?></td>

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