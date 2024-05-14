
// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main-content");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};






document.addEventListener('DOMContentLoaded', function() {
    const mainContent = document.querySelector('.main-content');

    // Fonction pour afficher les réservations
    function displayReservations() {
        fetch('/reservations', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }) 
            .then(response => response.json())
            .then(data => {
                const reservations = data.reservations;
                const tableHtml = `
                    <div class="table-container">
                        <table class="reservation-table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${reservations.map(reservation => `
                                    <tr>
                                        <td>${reservation.nom}</td>
                                        <td>${reservation.prenom}</td>
                                        <td>${reservation.email}</td>
                                        <td>${reservation.titre}</td>
                                        <td>${reservation.auteur}</td>
                                        <td>
                                            <button onclick="annulerReservation(${reservation.id})" class="button1">Annuler</button>
                                            <button onclick="emprunterReservation(${reservation.id})" class="button2">Emprunter</button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
                mainContent.innerHTML = tableHtml;
            })
            .catch(error => console.error('Erreur lors de la récupération des réservations:', error));
    }

    // Fonction pour afficher l'historique des emprunts (à implémenter)
    function displayHistoriqueEmprunts() {
        // Implémenter la logique pour afficher l'historique des emprunts ici
    }

    // Écouteurs d'événements pour les liens du menu latéral
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const linkText = this.querySelector('.title').innerText.trim();

            switch (linkText) {
                case 'Gérer les reservations':
                    displayReservations();
                    break;
                case 'Historique des emprunts':
                    displayHistoriqueEmprunts();
                    break;
                // Ajouter d'autres cas au besoin
                
                default:
                    break;
            }
        });
    });
});
