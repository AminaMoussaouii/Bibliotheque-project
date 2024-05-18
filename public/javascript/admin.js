document.addEventListener('DOMContentLoaded', function() {
    let formVisible = false;

    // Vos autres fonctionnalités existantes ici...

    const usersLink = document.getElementById('gerer-utilisateurs');
    const mainContent = document.querySelector('.main-content');

    usersLink.addEventListener('click', function(event) {
        event.preventDefault();
        fetch('/utilisateurs')
            .then(response => response.json())
            .then(data => {
                const utilisateurs = data.utilisateurs;

                const tableHTML = `
                    <div class="main">
                        <div class="grid1">
                            <div class="haut_table">
                                <div class="search2">
                                    <label>
                                        <input type="text" placeholder="Rechercher...">
                                    </label>
                                </div>
                                <button id="ajouter-utilisateur">Ajouter Utilisateur</button>
                            </div>

                            <div class="table-cont">
                                <table class="table1">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Rôle</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${utilisateurs.map(utilisateur => `
                                            <tr>
                                                <td>${utilisateur.nom}</td>
                                                <td>${utilisateur.email}</td>
                                                <td>${utilisateur.role}</td>
                                                <td>
                                                    <button onclick="editUtilisateur(${utilisateur.id})" class="button1">Editer</button>
                                                    <button onclick="deleteUtilisateur(${utilisateur.id})" class="button2">Supprimer</button>                
                                                </td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="grid2">
                        </div>
                    </div>
                `;
                mainContent.innerHTML = tableHTML;

                const ajouterUtilisateurBtn = document.getElementById('ajouter-utilisateur');
                ajouterUtilisateurBtn.addEventListener('click', function() {
                    // Votre logique pour afficher le formulaire d'ajout d'utilisateur ici...
                });
            })
            .catch(error => console.error('Erreur lors de la récupération des utilisateurs:', error));
    });
});

// Fonction pour éditer un utilisateur
function editUtilisateur(id) {
    window.location.href = `/utilisateurs/${id}/modifier`;
}

// Fonction pour supprimer un utilisateur
function deleteUtilisateur(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
        fetch(`/utilisateurs/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                throw new Error('La suppression de l\'utilisateur a échoué.');
            }
        })
        .catch(error => {
            console.error('Erreur lors de la suppression de l\'utilisateur:', error);
        });
    }
}
