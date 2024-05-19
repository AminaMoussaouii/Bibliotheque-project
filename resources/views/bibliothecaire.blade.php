<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothécaire panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bibliothecaire.css') }}">
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
                    <span class="title">Bibliothécaire</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/reservations') }}" class="sidebar-link sidebar-link-reservations">
                    <span class="icon">
                        <i class="fa-solid fa-list-check"></i>
                    </span>
                    <span class="title">Gérer les reservations</span>
                </a>
            </li>

            <li>
                <a href="{{ url('#') }}" class="sidebar-link">
                    <span class="icon">
                        <i class="fa-solid fa-gear"></i>
                    </span>
                    <span class="title">Historique des emprunts</span>
                </a>
            </li>

            <li>
                <a href="{{ url('#') }}" class="sidebar-link">
                    <span class="icon">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <span class="title">Gestion des retards</span>
                </a>
            </li>

            <li>
                <a href="{{ url('#') }}" class="sidebar-link">
                    <span class="icon">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <span class="title">Gestion du profil</span>
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
  
    <!-- ==========main============== -->
    <div class="navbar">
        <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
        </div>

        <div class="search">
            <label>
                <input type="text" placeholder="Rechercher...">
                <ion-icon name="search-outline"></ion-icon>
            </label>
        </div>

        <div class="user">
            <img src="images/profil.jpg" alt="" width="50px" height="50px">
        </div> 
    </div>
    <div class="main-content">
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
                <tbody id="reservation-table-body">
                  
                </tbody>
            </table>
        </div>
    </div>

</div>
<script src="{{ asset('javascript/bibliothecaire.js') }}"></script>
 <!-- ====== ionicons ======= -->
 <script type="module" src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js') }}"></script>
 <script nomodule src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js') }}"></script>
</body>
</html>
