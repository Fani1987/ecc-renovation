<?php
// 1. Démarrer la session
require_once '../partials/_session_start.php';

session_unset(); // Efface toutes les variables de session
session_destroy(); // Détruit la session
header('Location: ../index.php'); // Redirige vers la page d'accueil publique
exit();
