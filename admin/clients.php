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

// Initialisation d'un tableau vide pour les clients et du terme de recherche
$clients = [];
$search_term = '';

// Vérifie si le formulaire de recherche a été soumis (via la méthode GET)
if (isset($_GET['search'])) {

    // Nettoie le terme de recherche (supprime les espaces superflus au début et à la fin)
    $search_term = trim($_GET['search']);

    // N'exécute la recherche que si le terme n'est pas vide
    if (!empty($search_term)) {

        // 1. DÉFINITION DE LA REQUÊTE
        // Requête SQL utilisant "LIKE ?" pour trouver des correspondances partielles
        // L'opérateur '?' est un marqueur de position pour la requête préparée.
        $sql = "SELECT id, nom_complet, email, telephone FROM clients WHERE nom_complet LIKE ? ORDER BY nom_complet ASC";

        // 2. PRÉPARATION (Sécurité)
        // Prépare la requête SQL, la sépare des données pour éviter les injections SQL.
        $stmt = $conn->prepare($sql);

        // 3. LIAISON (Binding)
        // Ajoute les wildcards '%' au terme de recherche pour chercher "contient"
        // (ex: "dup" devient "%dup%")
        $search_pattern = "%" . $search_term . "%";
        // Lie la variable $search_pattern au premier '?' de la requête ($stmt).
        // Le "s" indique que la variable est une chaîne de caractères (string).
        $stmt->bind_param("s", $search_pattern);

        // 4. EXÉCUTION
        // Exécute la requête sur le serveur de base de données.
        $stmt->execute();

        // 5. RÉCUPÉRATION
        // Récupère l'ensemble des résultats de la requête.
        $result = $stmt->get_result();
        // Transforme tous les résultats en un tableau associatif PHP.
        $clients = $result->fetch_all(MYSQLI_ASSOC);

        // 6. NETTOYAGE
        // Ferme la requête préparée pour libérer les ressources.
        $stmt->close();
    }
}
// Ferme la connexion à la base de données.
$conn->close();

// 3. INCLURE L'EN-TÊTE HTML
require_once '../partials/_header.php';
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
                                        <a href="client_edit_form.php?id=<?php echo $client['id']; ?>" class="btn-action" style="background-color: #f39c12;">Modifier</a>
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