<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECC Rénovation</title>
    <meta name="description" content="ECC Rénovation, votre partenaire de confiance pour tous vos projets de rénovation intérieure et extérieure. Qualité, savoir-faire et satisfaction client.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/main.min.css">

</head>

<body>
    <?php require_once 'partials/_header.php'; ?>
    <main>

        <section id="hero" class="hero">
            <div class="hero-content">
                <h1>Transformez votre habitat avec ECC Rénovation</h1>
                <p>Votre partenaire de confiance pour tous vos projets de rénovation. Qualité, savoir-faire et satisfaction garantis.</p>
                <a href="#contact" class="btn">Obtenir un devis gratuit</a>
            </div>
        </section>

        <section id="services">
            <div class="container">
                <h2>Nos Services</h2>
                <div class="services-grid">
                    <div class="service-card">
                        <i class="fas fa-paint-roller"></i>
                        <h3>Rénovation Intérieure</h3>
                        <p>Peinture, plâtrerie, pose de cloisons. Nous donnons une nouvelle vie à vos espaces intérieurs.</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-hard-hat"></i>
                        <h3>Maçonnerie Générale</h3>
                        <p>Travaux de gros œuvre, murs porteurs, chapes et fondations pour des structures solides et durables.</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-bath"></i>
                        <h3>Rénovation de Salle de Bain</h3>
                        <p>Création et modernisation de votre salle de bain, de la plomberie à la pose de carrelage.</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-kitchen-set"></i>
                        <h3>Aménagement de Cuisine</h3>
                        <p>Installation et conception de cuisines modernes et fonctionnelles adaptées à vos besoins.</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-ruler-combined"></i>
                        <h3>Pose de revêtements</h3>
                        <p>Parquet, carrelage, lino... Nous posons tous types de revêtements de sol et muraux avec précision.</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-house-chimney-window"></i>
                        <h3>Rénovation Extérieure</h3>
                        <p>Ravalement de façade, isolation par l'extérieur et aménagement pour valoriser votre bien.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="about">
            <div class="container">
                <h2>Qui sommes-nous ?</h2>
                <div class="about-content">
                    <div class="about-text">
                        <h3>ECC Rénovation : L'excellence et le conseil à votre service</h3>
                        <p>Fondée par Jorge CAPITAO, ECC Rénovation est une entreprise familiale dédiée à la transformation de vos espaces de vie. Forts de plus de 40 ans d'expérience, nous mettons notre savoir-faire au service de vos projets, des plus simples aux plus ambitieux.</p>
                        <p>Notre engagement : allier des matériaux de qualité, des techniques éprouvées et une écoute attentive de vos besoins pour un résultat à la hauteur de vos attentes. Chaque chantier est une nouvelle histoire que nous écrivons avec vous.</p>
                        <a href="#portfolio" class="btn">Voir nos projets</a>
                    </div>
                    <div class="about-image">
                        <img src="https://images.pexels.com/photos/5691535/pexels-photo-5691535.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Équipe ECC Rénovation au travail">
                    </div>
                </div>
            </div>
        </section>

        <section id="portfolio">
            <div class="container">
                <h2>Nos Réalisations</h2>
                <div class="portfolio-grid">

                </div>
            </div>
        </section>

        <section id="contact">
            <div class="container">
                <h2>Contactez-nous</h2>
                <div class="contact-form">
                    <p style="text-align: center; margin-bottom: 20px;">Un projet en tête ? Remplissez ce formulaire ou appelez-nous directement pour obtenir un devis personnalisé et gratuit.</p>

                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name">Nom complet</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Adresse e-mail</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Description de votre projet</label>
                            <textarea id="message" name="message" rows="6" required></textarea>
                        </div>
                        <button type="submit" class="btn">Envoyer la demande</button>
                    </form>

                    <div id="form-feedback" style="margin-top: 20px; text-align: center;"></div>
                </div>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt">36 avenue Victor Cresson 92130 Issy Les Moulineaux</i> </p>
                    <p><i class="fas fa-phone"></i> <a href="tel:+33123456789">06 64 54 22 63</a></p>
                    <p><i class="fas fa-envelope"></i> <a href="mailto:contact@ecc-renovation.fr">ecc.renovation92@gmail.com</a></p>
                </div>
            </div>
        </section>
    </main>

    <?php require_once 'partials/_footer.php'; ?>

    <script>
        const burger = document.querySelector('.burger');
        const navLinks = document.querySelector('.nav-links');

        burger.addEventListener('click', () => {
            // Toggle Nav
            navLinks.classList.toggle('nav-active');

            // Burger Animation
            burger.classList.toggle('toggle');
        });
    </script>
    <script src="js/main.js"></script>
</body>

</html>