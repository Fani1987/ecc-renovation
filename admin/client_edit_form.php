<?php
// 1. DÉMARRER LA SESSION
require_once '../partials/_session_start.php';

// 2. LOGIQUE PHP
require_once '../config/database.php';

// Le gardien de sécurité
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// On vérifie qu'on a bien un ID
if (!isset($_GET['id'])) {
    header('Location: clients.php');
    exit();
}

$client_id = intval($_GET['id']);

// On récupère les infos du client à modifier
$stmt = $conn->prepare("SELECT nom_complet, email, telephone, adresse FROM clients WHERE id = ?");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Client non trouvé.");
}
$client = $result->fetch_assoc();
$stmt->close();
$conn->close();

// 3. INCLURE L'EN-TÊTE HTML
require_once '../partials/_header.php';
?>

<main class="container">
    <h2>Modifier le client : <?php echo htmlspecialchars($client['nom_complet']); ?></h2>
    <div class="form-container">
        <form action="client_actions.php" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">

            <div class="form-group">
                <label for="nom_complet">Nom complet</label>
                <input type="text" id="nom_complet" name="nom_complet" value="<?php echo htmlspecialchars($client['nom_complet']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($client['telephone']); ?>">
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <textarea id="adresse" name="adresse" rows="4"><?php echo htmlspecialchars($client['adresse']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Nouveau mot de passe (optionnel)</label>
                <input type="text" id="mot_de_passe" name="mot_de_passe">
                <small>Laissez vide pour ne pas changer le mot de passe.</small>
            </div>

            <button type="submit">Enregistrer les modifications</button>
        </form>
    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>