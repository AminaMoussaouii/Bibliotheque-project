<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
                        <span class="title">admin</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="sidebar-link" id="gerer-utilisateurs">
                        <span class="icon">
                            <i class="fa-solid fa-list-check"></i>
                        </span>
                        <span class="title">Gérer les utilisateurs</span>
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
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
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


        

<!-- code du formulaire d'ajout des utlisateurs-->
        <template id="livreFormTemplate">
            <form id="livreForm" enctype="multipart/form-data" method="post" action="{{ route('ajouterUser') }}"   style="box-shadow: 0 5px 10px #aeadad ; border-radius: 20px; padding-top:10px; padding-bottom:10px; padding-right:20px">
                @csrf
                
                <section class="informations">
                    <table class="table2">
                        <tr>
                            <td> <label class="ISBN">name</label></td> <td> <input type="text" name="name" placeholder="ISBN"></td> 
                            </tr>
                            <tr>
                             <td><label class="titre">email</label> </td><td><input type="text" name="email" placeholder="Titre"></td>
                             </tr>
                             <tr>
                             <td><label class="auteur">Role</label> </td><td> <input type="text" name="Role" placeholder="Auteur"></td>
                             </tr>
                             <tr>
                             <td><label class="langue">password</label> </td><td> <input type="text" name="langue" placeholder="Langue"></td>
                             </tr>                          
                    </table>
                    
                     <button type="submit" class="valider">Ajouter</button>
                </section>
            </form>
        </template>
        <!DOCTYPE html>
<html>
<head>
    <title>Import Users</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <div class="container">
        <h1>Import Users</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Choose Excel File</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
</body>
</html>

    </div>

    <script src="{{ asset('javascript/admin.js') }}"></script>
    <!-- ====== ionicons ======= -->
     <script type="module" src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js') }}"></script>
     <script nomodule src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js') }}"></script>
</body>
</html>
