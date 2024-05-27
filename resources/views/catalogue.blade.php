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
    <header>
        <nav class="navbar-head">
            <h2 class="logo"> FSTS BIBLIOTHEQUE</h2>
            <ul class="navlinks">
               <li><a href="{{ route('catalogue') }}">Ouvrages</a></li>
               <li><a href="#">Mes emprunts</a></li>
               <li><a href="#"><i class="fa-solid fa-bell"></i></a></li>
               <li><a href="{{ route('login') }}" target="_blank"><i class="fa-solid fa-user"></i>Déconnexion</a></li>  
            </ul>
        </nav>
    </header>
   

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
    <script>
        var baseUrl = "{{ asset('images') }}";
    </script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('javascript/catalogue.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    
</body>
</html>
