// méthode de redirection vers la page de détails 
$('.livre-box').click(function() {
    var livreId = $(this).data('id');
    window.location.href = '/livres/' + livreId;
});

// début filtre 
$(document).ready(function() {
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
                    var html = '<div class="livre-box" data-id="' + livre.id + '">';
                    html += '<div class="img-box"><img src="' + livre.image + '" alt="' + livre.titre + '"></div>';
                    html += '<div class="livre-info">';
                    html += '<h5>' + livre.titre + '</h5>';
                    html += '<p><span>Auteur:</span> ' + livre.auteur + '</p>';
                    html += '<p><span>Statut:</span> ' + livre.statut + '</p>';
                    html += '</div></div>';
                    $('#livre-container').append(html);
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});
// fin filtre 
