<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Livre</title>
    <link rel="stylesheet" href="{{ asset('css/LivreDetails.css') }}">
    <link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2-web/css/all.min.css')}}">
    <!-- cdn bootstarp-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #398ec3 !important">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{ asset('images/fsts_logo.png') }}" alt="Logo FSTS" style="width: 60px;height:60px;margin-left:40px;"> FSTS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalogue') }}">Ouvrages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Mes emprunts</a>
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
    
    <div class="section">
        @if($livre)

            <div class="livre-image"><img src="{{ asset('images/' . $livre->image) }}" alt="Image du livre"></div>
            <div class="informations">
                <div class="titre">{{ $livre->titre }}</div>
                <div class="details"> 
                    <div class="details1">
                        <table>
                            <tr>
                                <td class="info">ISBN</td>
                                <td>{{ $livre->isbn }}</td>
                            </tr>
                            <tr>
                                <td class="info">Auteur</td>
                                <td>{{ $livre->auteur }}</td>
                            </tr>
                            <tr>
                                <td class="info">Éditeur</td>
                                <td>{{ $livre->editeur }}</td>
                            </tr>
                            <tr>
                                <td class="info">Langue</td>
                                <td>{{ $livre->langue }}</td>
                            </tr>
                            <tr>
                                <td class="info">Date d'édition</td>
                                <td>{{ $livre->date_edition }}</td>
                            </tr>
                            <tr>
                                <td class="info">Exemplaires disponibles</td>
                                <td>{{ $livre->exp_disp }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="details2">
                        <table>
                            <tr>
                                <td class="info">Type d'Ouvrage</td>
                                <td>{{ $livre->type_ouvrage }}</td>
                            </tr>
                            <tr>
                                <td class="info">Nombre de pages</td>
                                <td>{{ $livre->nombre_pages }}</td>
                            </tr>
                            <tr>
                                <td class="info">Discipline</td>
                                <td>{{ $livre->discipline }}</td>
                            </tr>
                            <tr>
                                <td class="info">Rayon</td>
                                <td>{{ $livre->rayon }}</td>
                            </tr>
                            <tr>
                                <td class="info">Étage</td>
                                <td>{{ $livre->etage }}</td>
                            </tr>
                            <tr>
                                <td class="info">Statut</td>
                                <td class="{{ $livre->statut == 'disponible' ? 'statut-disponible' : 'statut-reserve' }}">{{ $livre->statut }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if($livre->exp_disp > 0)
                    <button class="res"><a href="{{ route('livres.reserver', ['id' => $livre->id]) }}">Réserver</a></button>
                @else
                    <button disabled style="background-color: grey; cursor: not-allowed;" class="res">Réserver</button>
                @endif
            </div>
        
        @else
            <p>Aucun livre trouvé.</p>
        @endif
        </div> 
</body>
</html>
