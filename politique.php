<?php require_once 'partials/_session_start.php'; ?>
<?php require_once 'partials/_header.php'; ?>

<main class="container" style="padding-top: 40px; padding-bottom: 60px;">

    <h2>Politique de Confidentialité</h2>
    <p>Dernière mise à jour : [Date du jour]</p>

    <h3>Introduction</h3>
    <p>L'entreprise ECC Rénovation, éditrice de ce site (ci-après "nous", "notre"), accorde une grande importance à la protection de vos données personnelles. Cette politique de confidentialité vise à vous informer sur la manière dont nous collectons, utilisons, partageons et protégeons les informations que vous nous fournissez via notre site web.</p>

    <h3>Article 1 : Responsable du Traitement</h3>
    <p>Le responsable du traitement des données collectées sur ce site est :</p>
    <p>
        ECC Rénovation<br>
        Représentée par M. Jorge CAPITAO<br>
        Adresse : 36 avenue Victor Cresson, 92130 Issy Les Moulineaux<br>
        Email : ecc.renovation92@gmail.com
    </p>

    <h3>Article 2 : Données Personnelles Collectées</h3>
    <p>Nous collectons différentes catégories de données en fonction de votre utilisation du site :</p>

    <h4>a) Données fournies via le formulaire de contact</h4>
    <p>Lorsque vous utilisez le formulaire de contact public, vous nous fournissez :</p>
    <ul>
        <li>Votre nom complet</li>
        <li>Votre adresse e-mail</li>
        <li>Le contenu de votre message</li>
    </ul>
    <p>Ces informations sont stockées dans notre base de données non relationnelle (NoSQL - MongoDB) à des fins de gestion des prospects.</p>

    <h4>b) Données relatives à l'Espace Client</h4>
    <p>Lorsqu'un compte client est créé pour vous par un administrateur, nous collectons et traitons :</p>
    <ul>
        <li>Vos informations d'identification (nom complet, email, téléphone, adresse).</li>
        <li>Votre mot de passe, qui est stocké de manière **hachée** (algorithme BCRYPT) et n'est jamais accessible en clair.</li>
        <li>Les informations relatives à vos projets (devis, montants, fichiers PDF associés, et le statut de ces devis).</li>
    </ul>
    <p>Ces informations sont stockées dans notre base de données relationnelle (SQL - MySQL).</p>

    <h4>c) Données de navigation (Cookies)</h4>
    <p>Nous utilisons des cookies techniques essentiels au bon fonctionnement du site. (Voir Article 7).</p>

    <h3>Article 3 : Finalités du Traitement</h3>
    <p>Vos données sont collectées pour des objectifs précis :</p>
    <ul>
        <li>**Répondre à vos demandes :** Gérer les demandes envoyées via le formulaire de contact.</li>
        <li>**Fournir l'accès à l'Espace Client :** Vous authentifier de manière sécurisée et vous permettre d'accéder à votre tableau de bord.</li>
        <li>**Gérer la relation commerciale :** Vous permettre de consulter, d'accepter ou de refuser vos devis, et de télécharger les documents associés.</li>
        <li>**Améliorer la sécurité** et le fonctionnement du site.</li>
    </ul>

    <h3>Article 4 : Durée de Conservation</h3>
    <p>Vos données sont conservées pour une durée limitée :</p>
    <ul>
        <li>**Pour les demandes de contact (prospects) :** 3 ans à compter du dernier contact.</li>
        <li>**Pour les données de l'Espace Client :** Pendant toute la durée de la relation commerciale, puis archivées pour la durée légale (par exemple, 10 ans pour les documents comptables comme les devis acceptés/payés).</li>
    </ul>

    <h3>Article 5 : Partage des Données et Destinataires</h3>
    <p>Les données collectées sont destinées à l'usage exclusif d'ECC Rénovation. Elles ne sont ni vendues, ni louées, ni cédées à des tiers.</p>
    <p>Le seul destinataire tiers est notre hébergeur (ex: OVH, AWS, ou dans le cadre de ce projet, un environnement conteneurisé Docker), qui est tenu à une obligation de confidentialité et de sécurité.</p>

    <h3>Article 6 : Sécurité de vos Données</h3>
    <p>Nous prenons la sécurité de vos données très au sérieux. Ce site met en œuvre des mesures techniques et organisationnelles conformes aux standards de l'industrie pour protéger vos informations :</p>
    <ul>
        <li>**Protection contre les injections SQL :** Toutes les requêtes vers notre base de données MySQL sont sécurisées via des **requêtes préparées**.</li>
        <li>**Protection des mots de passe :** Tous les mots de passe (clients et administrateurs) sont **hachés** avec l'algorithme `password_hash()` (BCRYPT).</li>
        <li>**Protection contre les failles XSS :** Toutes les données affichées dans le navigateur sont systématiquement nettoyées avec `htmlspecialchars()`.</li>
        <li>**Sécurité des identifiants :** Les accès à nos bases de données sont stockés dans un fichier `.env`, séparé du code et ignoré par le système de gestion de version (Git).</li>
    </ul>

    <h3>Article 7 : Utilisation des Cookies</h3>
    <p>Ce site utilise uniquement des cookies **techniques et fonctionnels**, indispensables à son fonctionnement :</p>
    <ul>
        <li>**Cookie de session (PHPSESSID) :** Ce cookie est essentiel pour maintenir votre connexion sécurisée lorsque vous accédez à votre Espace Client ou à l'Espace Administration. Il est détruit lorsque vous vous déconnectez ou fermez votre navigateur.</li>
    </ul>
    <p>Nous n'utilisons aucun cookie de suivi publicitaire ou d'analyse tiers (comme Google Analytics).</p>

    <h3>Article 8 : Vos Droits (Conformément au RGPD)</h3>
    <p>Vous disposez d'un droit d'accès, de rectification, de suppression (effacement), de limitation du traitement et de portabilité de vos données personnelles.</p>
    <p>Pour exercer ces droits, vous pouvez nous contacter à l'adresse indiquée à l'Article 1.</p>

</main>

<?php require_once 'partials/_footer.php'; ?>