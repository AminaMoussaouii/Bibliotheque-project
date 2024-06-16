<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothécaire panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bibliothecaire.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        .table-striped tbody tr:nth-child(odd) {
    background-color: #f2f2f2;
}
    </style>
    
</head>
<body>


    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="{{ url('#') }}" class="sidebar-link">
                        <span class="icon"></span>
                        <span class="title">Bibliothécaire</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-link" id="gerer-reservation-link">
                        <span class="icon"><i class="fa-solid fa-list-check"></i></span>
                        <span class="title">Gérer les réservations</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-link" id="gerer-historique-link">
                        <span class="icon"><i class="fa-solid fa-gear"></i></span>
                        <span class="title">Historique des emprunts</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-link" id="gerer-retard-link">
                        <span class="icon"><i class="fa-regular fa-envelope"></i></span>
                        <span class="title">Gestion des retards</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('catalogue') }}">
                        <span class="icon"><i class="fa-solid fa-house"></i></span>
                        <span class="title">Home page</span>
                    </a>
                </li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                        <span class="title">Déconnexion</span>
                    </a>
                </li>
            </ul>

        </div>

        <div class="navbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <div class="user">
                <img src="images/profil.jpg" alt="" width="50px" height="50px">
            </div> 
        </div>

        <div class="main-content">
            <div id="dynamic-content">
                <div class="table-container" id="table_reservation">
                    <h2>Gestion des Réservations</h2>
                    <br><br>
                    <form id="reservation-form">
                        @csrf
                    <table class="table table-bordered table-striped" id="reservations_datatable" style="width: 90%; height:400px">
                        <thead>
                            <tr style="background-color: #096097;">
                                <th style="color: white;font-weight:500; border-top-left-radius: 13px;">Nom</th>
                                <th style="color: white;font-weight:500">Prénom</th>
                                <th style="color: white;font-weight:500">Email</th>
                                <th style="color: white;font-weight:500">Titre</th>
                                <th style="color: white;font-weight:500">Auteur</th>
                                <th style="color: white;font-weight:500">Date de Réservation</th>
                                <th style="color: white;font-weight:500; border-top-right-radius: 13px;">Action</th>
                            </tr>
                        </thead>
                    </table>
                    </form>
                </div>
    
                <div id="historique-emprunt" style="display: none;">
                    <h2>Historique des Emprunts</h2>
                    <br><br>
                    <form id="emprunt-form">
                        @csrf
                        <table class="table table-bordered table-striped" id="historique_emprunts_datatable" style="width: 90%; margin-left:80px">
                            <thead>
                                <tr style="background-color: #096097;">
                                    <th style="color: white;font-weight:500; border-top-left-radius: 13px;">Tier</th>
                                    <th style="color: white;font-weight:500;">Type tier</th>
                                    <th style="color: white;font-weight:500;">ISBN</th>
                                    <th style="color: white;font-weight:500;">Titre</th>
                                    <th style="color: white;font-weight:500;">Type ouvrage</th>
                                    <th style="color: white;font-weight:500;">Date Emprunt</th>
                                    <th style="color: white;font-weight:500;">Date Limite</th>
                                    <th style="color: white;font-weight:500;">Date Retour</th>
                                    <th style="color: white;font-weight:500;">Nombre de jours de retard</th>
                                    <th style="color: white;font-weight:500;border-top-right-radius: 13px;">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </form>
                </div>
                <div id="gestion_retard" style="display: none;">
                    <h2>Gestion des Retards</h2>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
           
            $('#table_reservation').show();
            $('#historique-emprunt').hide();
            $('#gestion_retard').hide();
    
            
            $('#gerer-reservation-link').click(function() {
                $('#table_reservation').show();
                $('#historique-emprunt').hide();
                $('#gestion_retard').hide();
            });
    
            $('#gerer-historique-link').click(function() {
                $('#table_reservation').hide();
                $('#historique-emprunt').show();
                $('#gestion_retard').hide();
            });
    
            $('#gerer-retard-link').click(function() {
                $('#table_reservation').hide();
                $('#historique-emprunt').hide();
                $('#gestion_retard').show();
            });
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
        
            var table = $('#reservations_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('reservations.index') }}",
                columns: [
                    { data: 'nom', name: 'nom' },
                    { data: 'prénom', name: 'prénom' },
                    { data: 'email', name: 'email' },
                    { data: 'titre', name: 'titre' },
                    { data: 'auteur', name: 'auteur' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });
    
            // Annuler reservation
            $('body').on('click', '.deleteReservation', function () {
                var reservation_id = $(this).data('id');
                if (confirm("Vous êtes sûr de vouloir annuler cette réservation ?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('reservations') }}" + '/' + reservation_id,
                        success: function (data) {
                            table.draw();
                            alert(data.success);
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
    
            // Emprunter reservation
               
            $('body').on('click', '.emprunterReservation', function () {
                var reservation_id = $(this).data('id');
                var livre_id = $(this).data('livre_id');

                if (confirm("Êtes-vous sûr de vouloir transférer cette réservation aux emprunts ?")) {
                    $.ajax({
                        type: "POST",
                        url: "/reservations/emprunter/" + reservation_id,
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'livre_id': livre_id 
                        },
                        success: function (data) {
                            table.draw();
                            alert(data.success);
                        },
                        error: function (xhr, status, error) {
                            console.error('Erreur:', xhr.responseText);
                            alert('Échec du transfert de la réservation à l\'emprunt. Veuillez vérifier la console pour plus de détails.');
                        }
                    });
                }
            });
        });
    
    </script>
<!--code script de retour-->
    <script>   
    $(document).on('click', '.returnEmprunt', function() {
    var id = $(this).data('id');

    if (confirm("Êtes-vous sûr de vouloir retourner cet emprunt ?")) {
        $.ajax({
            type: "POST",
            url: "{{ route('emprunt.retourner') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                if (response.success) {
                    alert(response.success);
                   
                    var row = $('a[data-id="'+id+'"]').closest('tr');
                    row.find('.date-retour').text(response.date_retour);
                    row.find('.nbr-jrs-retard').text(response.nbr_jrs_retard);
                } else {
                    alert(response.error);
                }
            }
        });
    }
});


</script>

    
    <script>
    $(document).ready(function() {
        var empruntsTable = $('#historique_emprunts_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('emprunts.index') }}",
            columns: [
                { 
                    data: null, 
                    name: 'tier', 
                    render: function (data, type, row) {
                        return data.nom + ' ' + data.prénom;
                    },
                    title: 'Tier'
                },
                { data: 'Role', name: 'Role', title: 'Type tier' },
                { data: 'isbn', name: 'isbn' },
                { data: 'titre', name: 'titre' },
                { data: 'type_ouvrage', name: 'type_ouvrage' },
                { data: 'created_at', name: 'created_at', title: 'Date Emprunt' }, 
                { data: 'date_limite', name: 'date_limite' },
                { data: 'date_retour', name: 'date_retour' },
                { data: 'nbr_jrs_retard', name: 'nbr_jrs_retard' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
        });
    });
    
    
       
    </script>
    <script src="{{ asset('javascript/bibliothecaire.js') }}"></script>
     <!-- ====== ionicons ======= -->
     <script type="module" src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js') }}"></script>
     <script nomodule src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js') }}"></script>
    </body>
    </html>
    