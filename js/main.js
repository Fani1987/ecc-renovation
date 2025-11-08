// Fichier : js/main.js

// Le script s'exécute une seule fois, lorsque le HTML est chargé.
document.addEventListener('DOMContentLoaded', function() {
 
    // --- 1. GESTION DU PORTFOLIO ---
 
    // On sélectionne l'élément conteneur dans le HTML
    const portfolioGrid = document.querySelector('.portfolio-grid');
 
    // On vérifie si cet élément existe sur la page actuelle.
    if (portfolioGrid) {
        
        // On utilise l'API Fetch pour appeler notre API PHP
        fetch('api/get_projets.php')
 
            // .then() se déclenche quand le serveur a répondu.
            .then(response => {
                
                // On vérifie si la réponse est un succès
                if (!response.ok) {
                    throw new Error('La requête a échoué');
                }
                // On décode le JSON en un objet JavaScript.
                return response.json();
            })
 
            // .then() se déclenche après que le JSON a été décodé.
            .then(data => {
                
                // Cas où tout fonctionne mais il n'y a pas de projets
                if (data.length === 0) {
                    portfolioGrid.innerHTML = "<p>Aucune réalisation à afficher pour le moment.</p>";
                    return;
                }

                // On vide la grille
                portfolioGrid.innerHTML = ''; 
                
                // On boucle sur chaque projet reçu
                data.forEach(projet => {
                    
                    // On construit le HTML pour chaque projet
                    const portfolioItemHTML = `
                        <div class="portfolio-item">
                            <img src="${projet.chemin_image}" alt="${projet.titre}">
                            <div class="portfolio-overlay">
                                <h3>${projet.titre}</h3>
                            </div>
                        </div>
                    `;
                    
                    // On ajoute le nouveau bloc HTML à la grille
                    portfolioGrid.innerHTML += portfolioItemHTML;
                });
 
            })
 
            // Ce bloc .catch() intercepte toutes les erreurs
            .catch(error => {
                console.error('Erreur lors de la récupération des projets:', error);
                portfolioGrid.innerHTML = "<p>Impossible de charger les réalisations. Veuillez réessayer plus tard.</p>";
            });
    }

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