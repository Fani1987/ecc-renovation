<?php require_once '../partials/_header.php'; ?>
<?php
require_once '../config/database.php';

// Le gardien de sécurité
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// Initialisation des variables
$clients = [];
$search_term = '';

// On vérifie si une recherche a été effectuée
if (isset($_GET['search'])) {
    $search_term = trim($_GET['search']);
    if (!empty($search_term)) {
        // On prépare la requête pour éviter les injections SQL
        $sql = "SELECT id, nom_complet, email, telephone FROM clients WHERE nom_complet LIKE ? ORDER BY nom_complet ASC";
        $stmt = $conn->prepare($sql);

        // On ajoute les wildcards '%' pour chercher des correspondances partielles
        $search_pattern = "%" . $search_term . "%";
        $stmt->bind_param("s", $search_pattern);

        $stmt->execute();
        $result = $stmt->get_result();
        $clients = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}
$conn->close();
?>

<main class="container">
    <h2>Gestion des Clients</h2>

    <div class="search-container">
        <form action="clients.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Rechercher un client par nom..." value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit">Rechercher</button>
        </form>
        <a href="client_form.php" class="btn">Ajouter un client</a>
    </div>

    <div class="results-container">
        <?php if (!empty($search_term)): ?>
            <h3>Résultats pour "<?php echo htmlspecialchars($search_term); ?>"</h3>
            <div class="table-wrapper">
                <?php if (empty($clients)): ?>
                    <p>Aucun client trouvé correspondant à votre recherche.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td data-label="Nom"><?php echo htmlspecialchars($client['nom_complet']); ?></td>
                                    <td data-label="Email"><?php echo htmlspecialchars($client['email']); ?></td>
                                    <td data-label="Téléphone"><?php echo htmlspecialchars($client['telephone']); ?></td>
                                    <td data-label="Actions" class="actions">
                                        <a href="devis_form.php?client_id=<?php echo $client['id']; ?>" class="btn-action">Créer devis</a>
                                        <a href="client_actions.php?action=delete&id=<?php echo $client['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ? Tous ses devis seront également effacés.');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>Veuillez entrer un nom dans la barre de recherche pour trouver un client.</p>
        <?php endif; ?>
    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>