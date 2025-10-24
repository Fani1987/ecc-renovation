// Fichier : js/main.js

document.addEventListener('DOMContentLoaded', function() {

    // --- 1. GESTION DU PORTFOLIO (uniquement si la galerie existe) ---
    const portfolioGrid = document.querySelector('.portfolio-grid');

    if (portfolioGrid) {
        // On utilise un chemin absolu depuis la racine du site (commence par un /)
        fetch('/api/get_projets.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('La requête a échoué');
                }
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    portfolioGrid.innerHTML = "<p>Aucune réalisation à afficher pour le moment.</p>";
                    return;
                }
                // On vide la grille avant de la remplir pour éviter les doublons
                portfolioGrid.innerHTML = ''; 
                data.forEach(projet => {
                    const portfolioItemHTML = `
                        <div class="portfolio-item">
                            <img src="${projet.chemin_image}" alt="${projet.titre}">
                        </div>
                    `;
                    portfolioGrid.innerHTML += portfolioItemHTML;
                });
            })
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
            const formData = new FormData(contactForm);

            // On utilise un chemin absolu ici aussi
            fetch('/api/submit_contact.php', {
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