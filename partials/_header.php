<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>ECC Rénovation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <?php
    // LOGIQUE DE DÉTECTION AMÉLIORÉE ICI
    $is_subdirectory = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false || strpos($_SERVER['REQUEST_URI'], '/espace-client/') !== false;

    // Chemin correct pour le CSS
    $css_path = $is_subdirectory ? '../css/main.min.css' : 'css/main.min.css';
    echo '<link rel="stylesheet" href="' . $css_path . '">';
    ?>
</head>

<body>

    <header class="header">
        <nav class="navbar container">
            <a href="/index.php" class="logo">
                <?php
                // Chemin correct pour le logo
                $logo_path = $is_subdirectory ? '../Images/Logo2.png' : 'Images/Logo2.png';
                echo '<img src="' . $logo_path . '" alt="Logo ECC Rénovation">';
                ?>
            </a>

            <?php if (isset($_SESSION['admin_id'])): ?>
                <ul class="nav-links">
                    <li><a href="/admin/dashboard.php">Accueil Admin</a></li>
                    <li><a href="/admin/projets.php">Réalisations</a></li>
                    <li><a href="/admin/devis.php">Devis</a></li>
                    <li><a href="/admin/messages.php">Messages</a></li>
                    <li><a href="/admin/clients.php">Clients</a></li>
                    <li><a href="/admin/logout.php">Se déconnecter</a></li>
                </ul>
            <?php elseif (isset($_SESSION['client_id'])): ?>
                <ul class="nav-links">
                    <li><span>Bonjour, <?php echo htmlspecialchars($_SESSION['client_nom']); ?> !</span></li>
                    <li><a href="/espace-client/dashboard.php">Mes Devis</a></li>
                    <li><a href="/espace-client/logout.php">Se déconnecter</a></li>
                </ul>
            <?php else: ?>
                <ul class="nav-links">
                    <li><a href="/index.php#services">Nos Services</a></li>
                    <li><a href="/index.php#about">À Propos</a></li>
                    <li><a href="/index.php#portfolio">Nos Réalisations</a></li>
                    <li><a href="/index.php#contact">Contact</a></li>
                    <li><a href="/espace-client/index.php">Espace Client</a></li>
                </ul>
            <?php endif; ?>

            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>