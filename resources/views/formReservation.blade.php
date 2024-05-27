<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/formReserv.css') }}">
    <link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2-web/css/all.min.css')}}">
    <script src="{{ asset('javascript/formReserv.js') }}"></script>
</head>
<body>
      

<div class="containerform">
    <h2 class="title">Demande de réservation d'un ouvrage</h2>
    <form id="reservationForm" action="{{ route('reservation.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prénom" name="prenom" required>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="branche">Tél:</label>
            <input type="text" id="Tél" name="branche">
        </div>
        <div class="form-group">
            <label for="titre">Titre de l'ouvrage :</label>
            <input type="text" id="titre" name="titre" required>
        </div>
        <div class="form-group">
            <label for="auteur">Auteur :</label>
            <input type="text" id="auteur" name="auteur" required>
        </div>
        <div class="form-group">
            <label for="rayon">Rayon :</label>
            <input type="text" id="rang" name="rayon">
        </div>
        <div class="form-group">
            <label for="etage">Étage :</label>
            <input type="text" id="etage" name="etage">
        </div>
        
        <button type="submit" id="confirm">Confirmer</button>
        <button type="submit" id="tele"><i class="fa-solid fa-download"></i></button>

    </form>
</div> 




</body>
</html>

