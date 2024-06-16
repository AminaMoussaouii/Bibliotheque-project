<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSTS LIBRARY</title>
    <link rel="stylesheet" href="{{ asset('css/catalogue.css') }}">
    <link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2-web/css/all.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    
    <meta name="livre-search-url" content="{{ route('livre.search') }}">
</head>
<body>
   
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #398ec3 !important">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="{{ asset('public/images/fsts_logo.png') }}" alt="" style="width: 60px;height:60px;margin-left:40px;"> FSTS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('catalogue') }}">Ouvrages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('HistoricalUser') }}">Mes emprunts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-bell"></i></a>
                        </li>
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                           <button class="btn-logout"> <a class="nav-linka" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: white;font-size:14px">
                                <i class="fa-solid fa-user"></i> Déconnexion
                            </a></button>
                        </li>  
                    </ul>
                </div>
            </div>
        </nav>

    <div class="page-container">
        <div class="sidebarcontainer">
            @include('filters')   
        </div>

        <div class="main-container">

            <div class="search-bar">
                <input type="search" id="search_livre" placeholder="Rechercher un livre...">
                <button type="submit" id="search-button">Rechercher</button>
            </div>
           

            <div class="livre-container" id="livre-container">

                @foreach ($livres as $livre)
                    <div class="livre-box" data-id="{{ $livre->id }}">
                        <div class="img-box">
                            <img src="{{ asset('images/' . $livre->image) }}" alt="{{ $livre->titre }}">
                       
                        </div>
                        <div class="livre-info">
                            <p id="titre" style="margin-bottom: 0px">{{ $livre->titre }}</p>
                            <p style="margin-bottom: 2px"><span>Auteur:</span> {{ $livre->auteur }}</p>
                            <p style="margin-bottom: 2px"><span>Statut:</span>{{ $livre->statut }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

         
            <div class="pagination" style="margin-left: 200px">
               {{ $livres->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <img src="{{ asset('images/fsts_logo-footer.png') }}" alt="Logo FSTS" class="footer-logo">
            
            </div>
            <div class="footer-section">
                <h3>Contactez-nous</h3>
                <p>Email:  contact_fsts@uhp.ac.ma</p>
                <p>Téléphone:  0523.40.07.36</p>
                <p>Fax:  0523.40.09.69</p>
                <p>Adresse: FST de Settat, Km 3, B.P. : 577 Route de Casablanca, Maroc</p>
            </div>
            <div class="footer-section">
                <p>© 2024 <a href="https://www.fsts.ac.ma/" target="blank">Faculté des Sciences et Techniques de Settat</a></p>
                <p style="font-family: cursive;">Développé par Amina Moussaoui & Nouhaila El Ouafi</p>
            </div>
        </div>
    </footer>
    

    <!-- Script-->
    
    <script>
        var baseUrl = "{{ asset('images') }}";
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('javascript/catalogue.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

    
</body>
</html>
