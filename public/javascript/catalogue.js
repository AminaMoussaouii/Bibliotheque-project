$(document).ready(function() {
    // Méthode de redirection vers la page de détails
    $(document).on('click', '.livre-box', function() {
        var livreId = $(this).data('id');
        window.location.href = '/livres/' + livreId;
    });

    // Début filtre par checkboxes
    $('input[type="checkbox"]').change(function() {
        var filters = {};
        $('input[type="checkbox"]:checked').each(function() {
            var filterName = $(this).attr('name').replace('[]', ''); 
            if (!filters[filterName]) {
                filters[filterName] = [];
            }
            filters[filterName].push($(this).val());
        });

        console.log("Filtres appliqués :", filters);

        $.ajax({
            url: '/livres/filtres',
            type: 'GET',
            data: filters,
            success: function(response) {
                console.log("Réponse du serveur :", response);
                $('#livre-container').empty();
                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(function(livre) {
                        var imageUrl = baseUrl + '/' + livre.image;
                        var html = '<div class="livre-box" data-id="' + livre.id + '">' +
                                   '<div class="img-box"><img src="' + imageUrl + '" alt="' + livre.titre + '"></div>' +
                                   '<div class="livre-info">' +
                                   '<h5>' + livre.titre + '</h5>' +
                                   '<p><span>Auteur:</span> ' + livre.auteur + '</p>' +
                                   '<p><span>Statut:</span> ' + livre.statut + '</p>' +
                                   '</div></div>';
                        $('#livre-container').append(html);
                    });
                } else {
                    $('#livre-container').append('<p>Aucun livre trouvé.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Erreur :", xhr.responseText);
            }
        });
    });

    //=============methode recherche livres===========================
    var searchUrl = "/livre/search";

    $("#search_livre").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: searchUrl,
                dataType: "json",
                data: { term: request.term },
                success: function(data) {
                    var suggestions = data.map(function(livre) {
                        return {
                            label: livre.titre + " - " + livre.auteur + "-" + livre.discipline + "-" + livre.langue,
                            value: livre.titre
                        };
                    });
                    response(suggestions);
                }
            });
        },
        minLength: 1
    });

    $("#search-button").click(function() {
        var searchTerm = $("#search_livre").val();
        $.ajax({
            url: searchUrl,
            method: "GET",
            data: { term: searchTerm },
            success: function(data) {
                $("#livre-container").empty();
                if (data.length === 0) {
                    $("#livre-container").append('<p>No books found.</p>');
                } else {
                    data.forEach(function(livre) {
                        var imageUrl = baseUrl + '/' + livre.image;
                        var livreBox = '<div class="livre-box" data-id="' + livre.id + '">' +
                                       '<div class="img-box">' +
                                       '<img src="' + imageUrl + '" alt="' + livre.titre + '">' +
                                       '</div>' +
                                       '<div class="livre-info">' +
                                       '<p id="titre" style="margin-bottom: 0px">' + livre.titre + '</p>' +
                                       '<p style="margin-bottom: 2px"><span>Auteur:</span> ' + livre.auteur + '</p>' +
                                       '<p style="margin-bottom: 2px"><span>Statut:</span> ' + livre.statut + '</p>' +
                                       '</div>' +
                                       '</div>';
                        $("#livre-container").append(livreBox);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Search error:', xhr.responseText);
            }
        });
    });
});