<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSTs library</title>
    <link rel="stylesheet" href="{{ asset('auth/homePage.css') }}">
</head>
<body>
   <div class="gradient">
        <header class="header">
            <img class="logo" src="{{ asset('images/fstsettat.png') }}" alt="Logo">
            <button class="connexion-btn"><a href="{{ route('login') }}">Connexion</a></button>
        </header>

        <div class="center-content">
            <div class="text-anime">
                <span>Bienvenue à la bibliothèque de FSTS</span>
            </div>
        </div>
   </div>
</body>
</html>
