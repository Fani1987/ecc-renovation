document.addEventListener('DOMContentLoaded', function() {

// Le script s'exécute uniquement lorsque le document HTML
// est entièrement chargé et analysé par le navigateur.
// C'est une sécurité pour garantir que 'portfolioGrid' existe.
document.addEventListener('DOMContentLoaded', function() {
 
    // --- 1. GESTION DU PORTFOLIO ---
 
    // On sélectionne l'élément conteneur dans le HTML
    // où nous allons injecter nos projets.
    const portfolioGrid = document.querySelector('.portfolio-grid');
 
    // ↓ CECI EST UNE PRATIQUE DE PROGRAMMATION DÉFENSIVE ↓
    // On vérifie si cet élément existe sur la page actuelle.
    // Cela empêche le script de planter (avec une erreur "null")
    // sur les pages qui n'ont pas de galerie (ex: admin, espace client).
    if (portfolioGrid) {
        
        // --- 2. L'APPEL ASYNCHRONE (AJAX) ---
        // On utilise l'API Fetch, la méthode moderne pour faire des requêtes HTTP.
        // L'appel est ASYNCHRONE : le navigateur n'est pas bloqué
        // pendant qu'il attend la réponse du serveur.
        fetch('api/get_projets.php')
 
            // --- 3. GESTION DE LA PROMESSE (Partie 1) ---
            // .then() se déclenche quand le serveur a répondu.
            // 'response' contient la réponse HTTP (statut 200, 404, 500, etc.)
            .then(response => {
                
                // On vérifie si la réponse est un succès (statut 200-299)
                if (!response.ok) {
                    // Si c'est une erreur (ex: 404, script PHP non trouvé),
                    // on lève une erreur pour sauter au bloc .catch()
                    throw new Error('La requête a échoué');
                }
                // Si tout va bien, on décode le corps de la réponse,
                // qui est au format JSON, en un objet JavaScript utilisable.
                return response.json();
            })
 
            // --- 4. GESTION DE LA PROMESSE (Partie 2) ---
            // .then() se déclenche après que le JSON a été décodé.
            // 'data' est maintenant notre tableau d'objets (nos projets).
            .then(data => {
                
                // Cas où le script PHP fonctionne mais ne renvoie rien
                if (data.length === 0) {
                    portfolioGrid.innerHTML = "<p>Aucune réalisation à afficher pour le moment.</p>";
                    return; // On arrête le script ici.
                }

                // On vide la grille pour éviter d'ajouter des doublons
                // si le script était appelé plusieurs fois.
                portfolioGrid.innerHTML = ''; 
                
                // --- 5. CONSTRUCTION DYNAMIQUE DU HTML ---
                // On boucle sur chaque objet 'projet' dans notre tableau 'data'.
                data.forEach(projet => {
                    
                    // On utilise les "template literals" (les backticks ``)
                    // pour construire une chaîne HTML propre en y injectant
                    // les variables ${projet.titre}, etc.
                    const portfolioItemHTML = `
                        <div class="portfolio-item">
                            <img src="${projet.chemin_image}" alt="${projet.titre}">
                            <div class="portfolio-overlay">
                                <h3>${projet.titre}</h3>
                            </div>
                        </div>
                    `;
                    
                    // On ajoute le nouveau bloc HTML à l'intérieur de notre grille.
                    portfolioGrid.innerHTML += portfolioItemHTML;
                });
 
            })
 
            // --- 6. GESTION DES ERREURS ---
            // Ce bloc .catch() intercepte TOUTES les erreurs :
            // - L'erreur 'La requête a échoué' qu'on a levée (ex: 404)
            // - Une erreur réseau (pas d'internet)
            // - Une erreur de décodage (si le PHP renvoie autre chose que du JSON)
            .catch(error => {
                // On log l'erreur technique pour le développeur
                console.error('Erreur lors de la récupération des projets:', error);
                // On affiche un message propre pour l'utilisateur
                portfolioGrid.innerHTML = "<p>Impossible de charger les réalisations. Veuillez réessayer plus tard.</p>";
            });
    }
});


    // --- 2. GESTION DU FORMULAIRE DE CONTACT (uniquement si le formulaire existe) ---
    const contactForm = document.querySelector('#contactForm');
    const formFeedback = document.querySelector('#form-feedback');

    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();

            // Prévention du double-clic
            const submitButton = contactForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Envoi en cours...';

            const formData = new FormData(contactForm);

            // Chemin relatif 
            fetch('api/submit_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                formFeedback.textContent = data.message;
                if (data.success) {
                    formFeedback.style.color = 'green';
                    contactForm.reset();
                } else {
                    formFeedback.style.color = 'red';
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                formFeedback.textContent = 'Une erreur technique est survenue. Veuillez réessayer plus tard.';
                formFeedback.style.color = 'red';
            })
            .finally(() => {
                // Réactivation du bouton après la réponse
                submitButton.disabled = false;
                submitButton.textContent = 'Envoyer la demande';
            });
        });
    }


    // --- 3. GESTION DU MENU BURGER (uniquement si le burger existe) ---
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    if (burger) {
        burger.addEventListener('click', () => {
            navLinks.classList.toggle('nav-active');
            burger.classList.toggle('toggle');
        });
    }
});