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

    const ouvragesLink = document.getElementById('gerer-ouvrages');
    const mainContent = document.querySelector('.main-content');

    ouvragesLink.addEventListener('click', function(event) {
        event.preventDefault();
        fetch('/livres')
            .then(response => response.json())
            .then(data => {
                const livres = data.livres;

                const tableHTML = `
                    <div class="main">
                        <div class="grid1">
                            <div class="haut_table">
                                <div class="search2">
                                    <label>
                                 <input type="text" placeholder="Rechercher...">   
                                    </label> 
                                </div>
                                <button id="ajouter-btn">ajouter</button>
                                <button id="excelfile">fichier excel</button>
                            </div>

                            <div class="table-cont">
                                <table class="table1">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Titre</th>
                                            <th>Auteur</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${livres.map(livre => `
                                            <tr>
                                            <td><img src="${livre.image}" alt="Image" style="width: 50px; height: 50px;"></td>
                                                <td>${livre.titre}</td>
                                                <td>${livre.auteur}</td>
                                                <td>
                                                <button onclick="editLivre(${livre.id})" class="button1"><i class="fa-solid fa-pen"></i></button>
                                                <button onclick="deleteLivre(${livre.id})" class="button2"><i class="fa-solid fa-trash"></i></button>                
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

                const ajouterBtn = document.getElementById('ajouter-btn');
                ajouterBtn.addEventListener('click', function() {
                    if (!formVisible) {
                        const template = document.getElementById('livreFormTemplate');
                        const formClone = document.importNode(template.content, true);
                        const grid2 = document.querySelector('.grid2');
                        grid2.appendChild(formClone);
                        formVisible = true;
                
                        const imageInput = document.getElementById('imageInput');
                        const livreImage = document.getElementById('livre_img');
                
                        imageInput.addEventListener('change', function() {
                            const file = imageInput.files[0];
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                livreImage.src = event.target.result;
                                livreImage.style.display = 'block';
                                livreImage.style.width = '80px'; 
                                livreImage.style.height = '120px';
                                livreImage.style.margin ='0 auto';   

                            };
                            reader.readAsDataURL(file);
                        });
                    } else {
                        const grid2 = document.querySelector('.grid2');
                        grid2.innerHTML = ''; 
                        formVisible = false;
                    }
                });
                
            })
            .catch(error => console.error('Erreur lors de la récupération des livres:', error));
    });
});


// fonction editer et supprimer //
function editLivre(id) {
    window.location.href = `/livres/${id}/modifier`;
}

function deleteLivre(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce livre ?")) {
        fetch(`/livres/${id}`, {
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
                throw new Error('La suppression du livre a échoué.');
            }
        })
        .catch(error => {
            console.error('Erreur lors de la suppression du livre:', error);
        });
    }
}
