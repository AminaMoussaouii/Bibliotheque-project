<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Livre</title>
    <link rel="stylesheet" href="{{ asset('css/modifierLivre.css') }}">
</head>
<body>
    <section>
        @if($livre)
            <div class="livre-image"><img src="{{ asset($livre->image) }}" alt="Image du livre"></div>
            <div class="informations">
                <div class="titre">{{ $livre->titre }}</div>
                <form action="{{ route('livres.update', $livre->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="details"> 
                        <div class="details1">
                            <table>
                                <tr>
                                    <td class="info">ISBN</td>
                                    <td><input type="text" name="isbn" value="{{ $livre->isbn }}"></td>
                                </tr>
                                <tr>
                                    <td class="info">Auteur</td>
                                    <td><input type="text" name="auteur" value="{{ $livre->auteur }}"></td>
                                </tr>
                                <tr>
                                    <td class="info">Éditeur</td>
                                    <td><input type="text" name="editeur" value="{{ $livre->editeur }}"></td>
                                </tr>
                                <tr>
                                    <td class="info">Langue</td>
                                    <td><input type="text" name="langue" value="{{ $livre->langue }}"></td>
                                </tr>
                                <tr>
                                    <td class="info">Date d'édition</td>
                                    <td><input type="date" name="date_edition" value="{{ $livre->date_edition }}"></td>
                                </tr>
                                <tr>
                                    <td class="info">Exemplaires disponibles</td>
                                    <td><input type="text" name="exp_dispo" value="{{ $livre->exp_disp }}"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="details2">
                            <table>
                                <tr>
                                    <td class="info">Type d'Ouvrage</td>
                                    <td>
                                        <select name="type">
                                            <option value="Livre" {{ $livre->type_ouvrage == 'Livre' ? 'selected' : '' }}>Livre</option>
                                            <option value="CD" {{ $livre->type_ouvrage == 'CD' ? 'selected' : '' }}>CD</option>
                                            <option value="Mémoire" {{ $livre->type_ouvrage == 'Mémoire' ? 'selected' : '' }}>Mémoire</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="info">Nombre de pages</td>
                                    <td><input type="number" name="nbr_pages" value="{{ $livre->nombre_pages }}"></td>
                                </tr>
                                <tr>
                                    <td class="info">Discipline</td>
                                    <td><input type="text" name="discipline" value="{{ $livre->discipline }}"></td>
                                </tr>
                                <tr>
                                    <td class="info">Rayon</td>
                                    <td><input type="text" name="rayon" value="{{ $livre->rayon }}"></td>
                                </tr>
                                <tr>
                                    <td class="info">Étage</td>
                                    <td><input type="text" name="etage" value="{{ $livre->etage }}"></td>
                                </tr>
                                <tr>
                                    <td class="info">Statut</td>
                                    <td>
                                        <select name="disponibilite">
                                            <option value="disponible" {{ $livre->statut == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                            <option value="reserve" {{ $livre->statut == 'reserve' ? 'selected' : '' }}>Réservé</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <button type="submit">Valider</button> 
                </form>
            </div>
        @else
            <p>Aucun livre trouvé.</p>
        @endif
    </section> 
</body>
</html>
