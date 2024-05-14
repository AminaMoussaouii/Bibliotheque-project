<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSTS LIBRARY</title>
    <link rel="stylesheet" href="{{ asset('css/catalogue.css') }}">
    <link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2-web/css/all.min.css')}}">
</head>
<body>
    <header>
        <nav>
            <!--<a href="{{ route('catalogue') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="FSTS LIBRARY">
            </a>-->
            <h2 class="logo"> FSTS BIBLIOTHEQUE</h2>
            <ul class="navlinks">
               <li><a href="{{ route('catalogue') }}">Ouvrages</a></li>
               <li><a href="#">Mes emprunts</a></li>
               <li><a href="#"><i class="fa-solid fa-bell"></i></a></li>
               <li><a href="{{ route('login') }}" target="_blank"><i class="fa-solid fa-user"></i>Déconnexion</a></li>  
            </ul>
        </nav>
    </header>
    <div class="search-bar">
        <input type="text" placeholder="Rechercher un livre...">
        <button type="submit">Rechercher</button>
    </div>

    <div class="page-container">
        <div class="sidebarcontainer">
            @include('filters')   
        </div>

        <div class="main-container">
            <div class="livre-container" id="livre-container">

                @foreach ($livres as $livre)
                    <div class="livre-box" data-id="{{ $livre->id }}">
                        <div class="img-box">
                        <img src="{{ $livre->image }}" alt="{{ $livre->titre }}">
                        </div>
                        <div class="livre-info">
                            <h5>{{ $livre->titre }}</h5>
                            <p><span>Auteur:</span> {{ $livre->auteur }}</p>
                            <p><span>Statut:</span>{{ $livre->statut }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

         
            <div class="pagination">
                
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('javascript/catalogue.js') }}"></script>
    
</body>
</html>
