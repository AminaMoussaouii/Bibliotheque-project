document.addEventListener('DOMContentLoaded', function() {
    let formVisible = false; 

    let list = document.querySelectorAll(".navigation li");

    function activeLink() {
        list.forEach((item) => {
            item.classList.remove("hovered");
        });
        this.classList.add("hovered");
    }

    list.forEach((item) => item.addEventListener("mouseover", activeLink));

    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation");
    let main = document.querySelector(".main-content");

    toggle.onclick = function() {
        navigation.classList.toggle("active");
        main.classList.toggle("active");
    };

    const tableBody = document.getElementById('regles-table-body');

    function displayRegles() {
        fetch('/regles', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }) 
        .then(response => response.json())
        .then(data => {
            const regles_emprunt = data.regles_emprunt;
            tableBody.innerHTML = regles_emprunt.map(regle_emprunt => `
                <tr>
                    <td>${regle_emprunt.nbr_emprunt}</td>
                    <td>${regle_emprunt.type_tier}</td>
                    <td>
                        <button onclick="editRegle(${regle_emprunt.id})" class="button1">Modifier</button>
                        <button onclick="deleteRegle(${regle_emprunt.id})" class="button2">Supprimer</button>
                    </td>
                </tr>
            `).join('');
        })
        .catch(error => console.error('Erreur lors de la récupération des règles d\'emprunt:', error));
    }

    displayRegles();
    const ajouterRegleBtn = document.getElementById('ajouter-regle');
    const regleForm = document.getElementById('regle-form');

    ajouterRegleBtn.addEventListener('click', function() {
        formVisible = !formVisible; 
        if (formVisible) {
            regleForm.style.display = 'block'; 
        } else {
            regleForm.style.display = 'none'; 
        }
    });
    regleForm.addEventListener('submit', function(event) {
        event.preventDefault(); 
    
        const typeTier = document.getElementById('type_tier').value;
        const nbrEmprunt = document.getElementById('nbr_emprunt').value;

        fetch('/regles', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ type_tier: typeTier, nbr_emprunt: nbrEmprunt })
        })
        .then(response => response.json())
        .then(data => {
            const nouvelleRegle = `
                <tr>
                    <td>${data.nbr_emprunt}</td>
                    <td>${data.type_tier}</td>
                    <td>
                        <button onclick="editRegle(${data.id})" class="button1">Modifier</button>
                        <button onclick="deleteRegle(${data.id})" class="button2">Supprimer</button>
                    </td>
                </tr>
            `;
       
            tableBody.insertAdjacentHTML('afterbegin', nouvelleRegle);
            regleForm.style.display = 'none';
            formVisible = false; 
        })
        .catch(error => console.error('Erreur lors de l\'enregistrement de la règle d\'emprunt:', error));
        regleForm.reset();
    });
    
    document.addEventListener('click', function(event) {
        if (!regleForm.contains(event.target) && event.target !== ajouterRegleBtn) {
            regleForm.style.display = 'none';
            formVisible = false;
        }
    });
});

function deleteRegle(id) {

    if (confirm("Êtes-vous sûr de vouloir supprimer cette règle d'emprunt ?")) {
        fetch(`/regles/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            displayRegles();
        })
        .catch(error => console.error('Erreur lors de la suppression de la règle d\'emprunt:', error));
    } else {
       
        console.log("Suppression annulée.");
    }
}



