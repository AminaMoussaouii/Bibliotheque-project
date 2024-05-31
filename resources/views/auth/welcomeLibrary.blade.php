<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSTs library</title>
    <link rel="stylesheet" href="{{ asset('auth/homePage.css') }}">
</head>
<body>
   <div class="gradient">
        <ul class="navlinks">
            <li><button><a href="{{ route('login') }}">Connexion</a></button></li>
        </ul>

        <div class="center-content">
            <div class="text-anime">
                <img src="{{ asset('images/fsts_logo.png') }}" alt="Logo">
                <span>Bienvenue à la bibliothèque de FSTS</span>
            </div>
        </div>
   </div>
</body>
</html>
