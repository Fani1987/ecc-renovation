<footer class="footer">
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> ECC Rénovation. Tous droits réservés.</p>
        <p style="margin-top: 10px; font-size: 0.8rem;">
            <a href="/mentions-legales.php" style="color: #aaa; text-decoration: none; margin-right: 15px;">Mentions Légales</a>
            <a href="/admin/index.php" style="color: #aaa; text-decoration: none;">Administration</a>
        </p>
    </div>
</footer>

<?php
// On calcule le bon chemin ici, juste avant d'appeler le script
$is_admin_page = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false || strpos($_SERVER['REQUEST_URI'], '/espace-client/') !== false;
$js_path = $is_admin_page ? '../js/main.js' : 'js/main.js';
echo '<script src="' . $js_path . '"></script>';
?>

</body>

</html>