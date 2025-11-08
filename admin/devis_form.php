<?php
// 1. DÉMARRER LA SESSION
require_once '../partials/_session_start.php';

// 2. CONNEXION À LA BASE DE DONNÉES
require_once '../config/database.php';

// Le gardien de sécurité
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// On récupère l'ID du client depuis l'URL, s'il existe
$selected_client_id = isset($_GET['client_id']) ? intval($_GET['client_id']) : 0;

// On récupère la liste de tous les clients
$result = $conn->query("SELECT id, nom_complet FROM clients ORDER BY nom_complet ASC");
$clients = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();

// 3. INCLURE L'EN-TÊTE HTML
require_once '../partials/_header.php';
?>

<main class="container">
    <h2>Créer un nouveau devis</h2>
    <div class="form-container">
        <form action="devis_actions.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="client_id">Assigner le devis au client :</label>
                <select id="client_id" name="client_id" required>
                    <option value="">-- Sélectionnez un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo $client['id']; ?>" <?php if ($client['id'] == $selected_client_id) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($client['nom_complet']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="titre">Titre du projet</label>
                <input type="text" id="titre" name="titre" required>
            </div>
            <div class="form-group">
                <label for="montant_total">Montant total (€)</label>
                <input type="number" id="montant_total" name="montant_total" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="devis_file">Fichier du devis (PDF recommandé)</label>
                <input type="file" id="devis_file" name="devis_file" accept=".pdf" required>
            </div>
            <button type="submit">Créer et envoyer le devis</button>
        </form>
    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>