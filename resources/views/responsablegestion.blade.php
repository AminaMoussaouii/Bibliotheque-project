<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Responsable</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/responsablegestion.css') }}">
    <link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2-web/css/all.min.css')}}">
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="{{ url('#') }}" class="sidebar-link">
                        <span class="icon">
                             
                        </span>
                        <span class="title">Responsable</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="sidebar-link" id="gerer-ouvrages">
                        <span class="icon">
                            <i class="fa-solid fa-list-check"></i>
                        </span>
                        <span class="title">Gérer les Ouvrages</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ url('#') }}" class="sidebar-link">
                        <span class="icon">
                            <i class="fa-solid fa-gear"></i>
                        </span>
                        <span class="title">Règle d'emprunt</span>
                    </a>
                </li> 
                <li>
                    <a href="{{ route('catalogue') }}" class="sidebar-link">
                        <span class="icon">
                            <i class="fa-solid fa-house"></i>
                        </span>
                        <span class="title">Home page</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('#') }}" class="sidebar-link">
                        <span class="icon">
                            <i class="fa-solid fa-chart-column"></i>
                        </span>
                        <span class="title">Statistiques</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('#') }}" class="sidebar-link">
                        <span class="icon">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </span>
                        <span class="title">Déconnexion</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="navbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
        
            <div class="user">
                <img src="images/profil.jpg" alt="" width="50px" height="50px">
            </div> 
        </div>


        <div class="main-content">
           
        </div>


<!-- code du formulaire d'ajout d'un ouvrage -->
        <template id="livreFormTemplate">
            <form id="livreForm" enctype="multipart/form-data" method="post" action="{{ route('livres.store') }}"   style="box-shadow: 0 5px 10px #aeadad ; border-radius: 20px; padding-top:10px; padding-bottom:10px; padding-right:20px">
                @csrf
                <img src="" alt="" id="livre_img"  style="display: none">
                <input type="file" name="image" id="imageInput" accept="images/*" style="display: none;">
                <label for="imageInput" class="input-file-button">Choisir</label>
                <span class="input-file-label">Aucun fichier sélectionné</span>
                <section class="informations">
                    <table class="table2">
                        <tr>
                            <td> <label class="ISBN">ISBN</label></td> <td> <input type="text" name="isbn" placeholder="ISBN"></td> 
                            </tr>
                            <tr>
                             <td><label class="titre">Titre</label> </td><td><input type="text" name="titre" placeholder="Titre"></td>
                             </tr>
                             <tr>
                             <td><label class="auteur">Nom d'auteur</label> </td><td> <input type="text" name="auteur" placeholder="Auteur"></td>
                             </tr>
                             <tr>
                             <td><label class="langue">La langue</label> </td><td> <input type="text" name="langue" placeholder="Langue"></td>
                             </tr>
                             <tr>
                             <td><label class="editeur">L'éditeur</label> </td><td> <input type="text" name="editeur" placeholder="Editeur"></td>
                             </tr>
                             <tr>
                             <td><label class="date-edition">La date d'édition</label> </td><td><input type="date" name="date_edition" placeholder="Date d'edition"></td>
                             </tr>
                             <tr>
                             <td><label class="exp">Exemplaires disponibles</label> </td><td><input type="text" name="exp_dispo" placeholder="Exp dispo"></td>
                             </tr>
                             <tr> 
                             <td><label class="etage">Étage</label> </td><td><input type="text" name="etage" placeholder="Etage"></td>
                             </tr>
                             <tr>
                             <td><label class="rayon">Rayon</label> </td><td><input type="text" name="rayon" placeholder="Rayon"></td>
                             </tr>
                             <tr>
                             <td><label class="pages">Nombres de pages</label> </td><td><input type="number" name="nbr_pages" placeholder="Nombre de pages"></td>
                             </tr>
                             <tr>
                             <td><label class="discipline">Discipline</label> </td><td><input type="text" name="discipline" placeholder="Discipline"></td>
                             </tr>                           
                    </table>
                    <select name="disponibilite">
                        <option value="disponible">Disponible</option>
                        <option value="reserve">Reservé</option>
                    </select>
                    <select name="type">
                        <option value="Livre">Livre</option>
                        <option value="CD">CD</option>
                        <option value="Mémoire">Mémoire</option>
                    </select>
                    <button type="submit" class="valider">Valider</button>
                </section>
            </form>
        </template>
    </div>

    <script src="{{ asset('javascript/responsablegestion.js') }}"></script>
     <!-- ====== ionicons ======= -->
     <script type="module" src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js') }}"></script>
     <script nomodule src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js') }}"></script>
</body>
</html>
