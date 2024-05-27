
$(document).ready(function() {
    // =================méthode de redirection vers la page de détails ================
    $(document).on('click', '.livre-box', function() {
        var livreId = $(this).data('id');
        window.location.href = '/livres/' + livreId;
    });


    // =================début filtre ===========================
    $('input[type="checkbox"]').change(function() {
        var filters = {};
        $('input[type="checkbox"]:checked').each(function() {
            filters[$(this).attr('name')] = $(this).val();
        });

        console.log(filters);


        $.ajax({
            url: '/livres/filtres',
            type: 'GET',
            data: filters,
            success: function(response) {
                $('#livre-container').empty();
                $.each(response.livres, function(index, livre) {
                    var html = '<div class="livre-box" data-id="' + livre.id + '">' +
                               '<div class="img-box"><img src="' + livre.image + '" alt="' + livre.titre + '"></div>' +
                               '<div class="livre-info">' +
                               '<h5>' + livre.titre + '</h5>' +
                               '<p><span>Auteur:</span> ' + livre.auteur + '</p>' +
                               '<p><span>Statut:</span> ' + livre.statut + '</p>' +
                               '</div></div>';
                    $('#livre-container').append(html);
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
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
                            label: livre.titre + " - " + livre.auteur,
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
                                       '<img src="' + imageUrl + '" alt="' + livre.titre + '">' +
                                       '</div>' +
                                       '<div class="livre-info">' +
                                       '<p id="titre" style="margin-bottom: 0px">' + livre.titre + '</p>' +
                                       '<p style="margin-bottom: 2px"><span>Auteur:</span> ' + livre.auteur + '</p>' +
                                       '<p style="margin-bottom: 2px"><span>Statut:</span> ' + livre.statut + '</p>' +
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
                                       '</div>';
                        $("#livre-container").append(livreBox);
                    });
                }
            },
          
        });
    });
});
