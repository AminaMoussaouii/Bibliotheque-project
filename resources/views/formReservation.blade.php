<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demande de réservation d'un ouvrage</title>
    <link rel="stylesheet" href="{{ asset('css/formReserv.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.2-web/css/all.min.css') }}">
    <script src="{{ asset('javascript/formReserv.js') }}"></script>
</head>
<body>

    <div class="containerform">
        <h2 class="title">Demande de réservation d'un ouvrage</h2>
        <form id="reservationForm" action="{{ route('reservation.store') }}" method="POST">
            @csrf
            <input type="hidden" name="livre_id" value="{{ $livre->id }}">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required value="{{ $user->nom }}" readonly >
            </div>
            <div class="form-group">
                <label for="prénom">Prénom :</label>
                <input type="text" id="prénom" name="prénom" required value="{{ $user->prénom}}" readonly>
            </div>
           <div class="form-group">
            @if($user->Role === 'etudiant')
                <label for="Filière">Filière :</label>
                <input type="text" id="Filière" name="Filière" value="{{ $user->Filière }}" readonly>
            @endif
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required value="{{$user->email }}" readonly>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN :</label>
                <input type="text" id="isbn" name="isbn" value="{{ $livre->isbn ?? old('isbn') }}"readonly>
            </div>
            <div class="form-group">
                <label for="type_ouvrage">Type d'ouvrage :</label>
                <input type="text" id="type_ouvrage" name="type_ouvrage" value="{{ $livre->type_ouvrage ?? old('type_ouvrage') }}" readonly>
            </div>
            <div class="form-group">
                <label for="titre">Titre de l'ouvrage :</label>
                <input type="text" id="titre" name="titre" required value="{{ $livre->titre ?? old('titre') }}" readonly>
            </div>
            <div class="form-group">
                <label for="auteur">Auteur :</label>
                <input type="text" id="auteur" name="auteur" required value="{{ $livre->auteur ?? old('auteur') }}" readonly>
            </div>
            <div class="form-group">
                <label for="rayon">Rayon :</label>
                <input type="text" id="rayon" name="rayon" value="{{ $livre->rayon ?? old('rayon') }}" readonly>
            </div>
            <div class="form-group">
                <label for="etage">Étage :</label>
                <input type="text" id="etage" name="etage" value="{{ $livre->etage ?? old('etage') }}" readonly>
            </div>


           
            <button type="submit" id="confirm">Confirmer</button>
            <button type="button" id="telechargerPDF">Télécharger</button>
        </form>
    </div> 




    <script>
        document.getElementById('telechargerPDF').addEventListener('click', function() {
            var form = document.getElementById('reservationForm');
            var formData = new FormData(form);

            var queryString = new URLSearchParams(formData).toString();

            window.location.href = "{{ route('reservation.telechargerPDF') }}?" + queryString;
        });
    </script>
</body>
</html>
