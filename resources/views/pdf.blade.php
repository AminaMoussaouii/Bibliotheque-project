<!DOCTYPE html>
<html>
<head>
    <title>{{ $titre }}</title>
    <style> table {
        border-collapse: collapse;
        width: 100%;
    }
    
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    } </style>
</head>
<body>
   
     <h2>Demande de réservation d'un ouvrage</h2>

<table>
    <tr>
        <td>Nom</td>
        <td>{{Nom}}</td>
    </tr>
    <tr>
        <td>Prénom</td>
        <td>{{Prénom}}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{Email}}</td>
    </tr>
    <tr>
        <td>Branche</td>
        <td>{{Branche}}</td>
    </tr>
    <tr>
        <td>Titre</td>
        <td>{{Titre}}</td>
    </tr>
    <tr>
        <td>Auteur</td>
        <td>{{Auteur}}</td>
    </tr>
    <tr>
        <td>Rang</td>
        <td>{{Rang}}</td>
    </tr>
    <tr>
        <td>Étage</td>
        <td>{{Étage}}</td>
    </tr>
</table>
</body>
</html>
