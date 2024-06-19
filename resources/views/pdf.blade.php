<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demande de réservation d'un ouvrage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .title {
            font-family: cursive;
            font-weight: bold;
            font-size: 30px;
            color: brown;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <p class="title">Demande de réservation d'un livre</p>
    <table>
        <tr>
            <th>Nom</th>
            <td>{{ $nom }}</td>
        </tr>
        <tr>
            <th>Prénom</th>
            <td>{{ $prénom }}</td>
        </tr>
        <tr>
            <th>Filière</th>
            <td>{{ $Filière }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $email }}</td>
        </tr>
        <tr>
            <th>ISBN</th>
            <td>{{ $isbn }}</td>
        </tr>
        <tr>
            <th>Type d'ouvrage</th>
            <td>{{ $type_ouvrage }}</td>
        </tr>
        <tr>
            <th>Titre de l'ouvrage</th>
            <td>{{ $titre }}</td>
        </tr>
        <tr>
            <th>Auteur</th>
            <td>{{ $auteur }}</td>
        </tr>
        <tr>
            <th>Rayon</th>
            <td>{{ $rayon }}</td>
        </tr>
        <tr>
            <th>Étage</th>
            <td>{{ $etage }}</td>
        </tr>
    </table>
</body>
</html>
