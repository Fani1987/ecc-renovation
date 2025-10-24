<?php require_once '../partials/_header.php'; ?>
<?php
// Le gardien de sécurité
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// On vérifie si des informations sont passées dans l'URL pour pré-remplir les champs
$nom_predetermine = isset($_GET['nom']) ? htmlspecialchars(urldecode($_GET['nom'])) : '';
$email_predetermine = isset($_GET['email']) ? htmlspecialchars(urldecode($_GET['email'])) : '';
?>

<main class="container">
    <h2>Ajouter un nouveau client</h2>
    <div class="form-container">
        <form action="client_actions.php" method="POST">
            <input type="hidden" name="action" value="add">

            <div class="form-group">
                <label for="nom_complet">Nom complet</label>
                <input type="text" id="nom_complet" name="nom_complet" value="<?php echo $nom_predetermine; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" value="<?php echo $email_predetermine; ?>" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone">
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <textarea id="adresse" name="adresse" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe initial</label>
                <input type="text" id="mot_de_passe" name="mot_de_passe" required>
                <small>Le client pourra modifier son mot de passe plus tard.</small>
            </div>

            <button type="submit">Créer le compte client</button>
        </form>
    </div>
</main>

<?php require_once '../partials/_footer.php'; ?>