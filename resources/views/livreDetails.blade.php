<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Livre</title>
    <link rel="stylesheet" href="{{ asset('css/LivreDetails.css') }}">
    

</head>
<body>
    <header>
        <nav>
            <h2 class="logo">FSTS BIBLIOTHEQUE</h2>
            <ul class="navlinks">
               <li><a href="{{ route('catalogue') }}">Ouvrages</a></li>
               <li><a href="#">Mes emprunts</a></li>
               <li><a href="#">Historique</a></li>
               <li><a href="{{ route('login') }}" target="_blank">Déconnexion</a></li>  
            </ul>
        </nav>
    </header>  
    
    <section>
        @if($livre)
            <div class="livre-image"><img src="{{ asset($livre->image) }}" alt="Image du livre"></div>
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
                            <td>{{ $livre->statut }}</td>
                        </tr>
                    </table>
                </div>
                </div> 
                <button><a href="{{ route('reservation') }}" target="blank">Réserver</a></button>

            </div>
        @else
            <p>Aucun livre trouvé.</p>
        @endif
    </section> 

</body>
</html>
