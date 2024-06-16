<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Responsable</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/responsablegestion.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- JS cdn  Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>


    
    <style>
        #laravel_11_datatable_filter label{
            margin-bottom: 30px;
            margin-right:110px;
          
        }
        #laravel_11_datatable_filter label #text{
            color: blue;
            font-weight: bold;
        }
        #laravel_11_datatable_filter input[type="search"]{
             border: 2px solid #2679e7;
             border-radius: 20px;
             box-shadow: 0 5px 8px #9a9a9a; 
             outline: none;
        }
        .dataTables_length label{
            margin-left: 110px
        }
        .control-label{
            color: brown; 
            font-weight:500; 
            font-family:'Times New Roman', Times, serif;
        }
        .odd img {
            height: 60px;
            width:50px;
            margin-left: 20px;
        }
        .even img{
        height: 60px;
        width: 50px;
        margin-left: 20px;
         }
         .table thead tr th{
        font-family:'Times New Roman', Times, serif;
        }
        .table tbody tr td{
            border-bottom: 1px solid #9a9a9a;
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
                        <span class="title">Responsable</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-link" id="gerer-ouvrages-link">
                        <span class="icon"><i class="fa-solid fa-list-check"></i></span>
                        <span class="title">Gérer les Ouvrages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('#regle-emprunt') }}" class="sidebar-link" id="regle-emprunt-link">
                        <span class="icon"><i class="fa-solid fa-gear"></i></span>
                        <span class="title">Règle d'emprunt</span>
                    </a>
                </li> 
                <li>
                    <a href="{{ route('catalogue') }}" class="sidebar-link">
                        <span class="icon"><i class="fa-solid fa-house"></i></span>
                        <span class="title">Home page</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('#') }}" class="sidebar-link"  id="statistiques-link">
                        <span class="icon"><i class="fa-solid fa-chart-column"></i></span>
                        <span class="title">Statistiques</span>
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

        <!--====================== Main-content ==========================-->
        <div class="main-content">
            <div id="dynamic-content">

        <div id="gerer-ouvrages-content"  style="display: none;">
            <div class="containergestion" style="padding-left: 50px; padding-right:50px;">
                <h2 style="margin-left: 110px">Gestion des ouvrages</h2>
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-livre" style="margin-left: 110px; background-color: #f99324; border:none;border-radius:10px; box-shadow: 0 5px 5px #9a9a9a; ">Ajouter</a>
                <input type="file" id="importFile" style="display:none;">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="import-button" style="background-color: #f99324; border:none;border-radius:10px; box-shadow: 0 5px 5px #9a9a9a;">Importer</a>
        
                <br><br>
               
                <table class="table table-bordered table-striped" id="laravel_11_datatable" style="height:auto; width:90%;">
                    <thead>
                        <tr style="background-color: #096097;">
                            <th style="color: white;font-weight:500; border-top-left-radius: 13px;">Image</th>
                            <th style="color: white;font-weight:500">ISBN</th>
                            <th style="color: white;font-weight:500">Auteur</th>
                            <th style="color: white;font-weight:500">Titre</th>
                            <th style="color: white;font-weight:500">Discipline</th>
                            <th style="color: white;font-weight:500;  border-top-right-radius: 13px;">Action</th>
                        </tr>
                    </thead>
                </table>
              
            </div>
            <div class="modal fade" id="ajax-livre-modal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="livreCrudModal"></h4>
                        </div>
                        <div class="modal-body">
                            <form id="livreForm" name="livreForm" class="form-horizontal" enctype="multipart/form-data">
                             @csrf
                             <input type="hidden" name="livre_id" id="livre_id">
                             
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-12">
                                        <input id="image" type="file" name="image" accept="image/*" onchange="readURL(this);" style="color:#2679e7; ">
                                        <input type="hidden" name="hidden_image" id="hidden_image">
                                        <img id="modal-preview" src="https://via.placeholder.com/150" alt="Aperçu de l'image" class="form-group hidden"  width="100" height="100"/>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label" >ISBN</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Entrer ISBN" value="" maxlength="50" required="" height="20px"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Titre</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrer titre" value="" maxlength="50" required="" height="20px"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Auteur</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="auteur" name="auteur" placeholder="Entrer Auteur" value="" maxlength="50" required="" height="20px"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Langue</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="langue" name="langue" value="" maxlength="50" required="" height="20px">
                                            <option value="Français">Français</option>
                                            <option value="Anglais">Anglais</option>
                                            <option value="Arabe">Arabe</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Editeur</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="editeur" name="editeur" value="" maxlength="50" required="" height="20px">
                                            <option value="Ellipses">Ellipses</option>
                                            <option value="Meral">Meral</option>
                                            <option value="Sochpress">Sochpress</option>
                                            <option value="PUF">PUF</option>
                                            <option value="Belin">Belin</option>
                                            <option value="Dunod">Dunod</option>
                                            <option value="Breal">Breal</option>
                                            <option value="Vuibert">Vuibert</option>
                                            <option value="Hermann">Hermann</option>
                                            <option value="Masson">Masson</option>
                                            <option value="Nathan">Nathan</option>
                                            <option value="Ed.Marketing">Ed.Marketing</option>
                                            <option value="Eyrolles">Eyrolles</option>
                                            <option value="A.Colin">A.Colin</option>
                                            <option value="Tec-doc">Tec-doc</option>
            
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Date_d'Édition</label>
                                    <div class="col-sm-12">
                                        <input type="date"  class="form-control" id="date_edition" name="date_edition" placeholder="Enter la date d'édition" value="" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Exemplaires_disponibles</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="exp_disp" name="exp_disp" placeholder="Nbr d'exemplaires disponibles" value="" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Étage</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="etage" name="etage" placeholder="Étage" value="" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Rayon</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="rayon" name="rayon" placeholder="Rayon" value="" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Nombre_de_pages</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" id="nombre_pages" name="nombre_pages" placeholder="Enter Nbr de pages" value="" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Discipline</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="discipline" name="discipline" value="" maxlength="50" required="" height="20px">
                                            <option value="Mathématiques">Mathématiques</option>
                                            <option value="Informatique">Informatique</option>
                                            <option value="Physique">Physique</option>
                                            <option value="Économie">Économie</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Statut </label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="statut" name="statut" value="" maxlength="50" required="" height="20px">
                                            <option value="disponible">Disponible</option>
                                            <option value="Non empruntable">Non empruntable</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Type_Ouvrage </label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="type_ouvrage" name="type_ouvrage" value="" maxlength="50" required="" height="20px">
                                            <option value="Livre">Livre</option>
                                            <option value="CD">CD</option>
                                            <option value="Mémoire">Mémoire</option>
                                        </select> 
                                    </div>
                                </div>
                                
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" id="btn-save" value="create">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

      <!--=====================table regle emprunt ================== -->
      <div id="regle-emprunt-content">
        <h2 style="margin-left: 130px;">Règle d'emprunt</h2>
        <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-regle" style="margin-left: 150px; margin-right:150px;background-color: #f99324; border:none; border-radius:10px; box-shadow: 0 5px 5px #9a9a9a;">Ajouter</a>
        <br><br>
        <table class="table table-bordered table-striped" id="regle_datatable" style="width:70%; margin-left:80px;">
            <thead>
                <tr style="background-color: #096097;">
                    <th style="color: white;font-weight:500; border-top-left-radius: 13px; ">Nombre emprunt</th>
                    <th style="color: white;font-weight:500;">Type tiers</th>
                    <th style="color: white;font-weight:500; border-top-right-radius: 13px;">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    
    <div class="modal fade" id="ajax-regle-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="regleCrudModal"></h4>
                </div>
                <div class="modal-body">
                    <form id="regleForm" name="regleForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="regle_id" id="regle_id">
                        <div class="form-group">
                            <label for="type_tier" class="col-sm-4 control-label">Type Tier:</label>
                            <div class="col-sm-12">
                                <select name="type_tier" id="type_tier" class="form-control">
                                   <option value="personnel">personnel</option>
                                   <option value="etudiant">etudiant</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nbr_emprunt" class="col-sm-4 control-label">Nombre Emprunt:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nbr_emprunt" name="nbr_emprunt" placeholder="Enter Number" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
    
            </div>
        </div>
    </div>


        
        <!--===================Statistiquees========================= -->
        <div id="statistiques-content" style="display: none;">
            <h2>Statistiques de la bibliothèque de FSTS</h2>
            <div class="boxstat daily">
                <p>Emprunts quotidiens</p>
                <div>
                    <span id="dailyEmpruntsCount"></span> <span>emprunts aujourd'hui</span>
                </div>
            </div>
            <div class="charts-container">
                <div class="boxstat bar">
                    <h3>Emprunts par mois</h3>
                    <canvas id="empruntsChart"></canvas>
                </div>
                <div class="boxstat pie">
                    <h3>Emprunts par discipline</h3>
                    <canvas id="empruntsParDisciplineChart"></canvas>
                </div>
            </div>
           
        </div>



        </div>
    </div>
    <!--===================================================== -->
        </div>
    <!-- ce sccript est utiliser pour gerer l'affichage dans le main-content -->
    <script>
        $(document).ready(function() {
           //contenu initial
           $('#statistiques-content').show();
            $('#gerer-ouvrages-content').hide();
            $('#regle-emprunt-content').hide();
            

          
            $('#gerer-ouvrages-link').click(function() {
                $('#gerer-ouvrages-content').show();
                $('#regle-emprunt-content').hide();
                $('#statistiques-content').hide();
            });

            $('#regle-emprunt-link').click(function() {
                $('#gerer-ouvrages-content').hide();
                $('#regle-emprunt-content').show();
                $('#statistiques-content').hide();
            });

            $('#statistiques-link').click(function() {
                $('#gerer-ouvrages-content').hide();
                $('#regle-emprunt-content').hide();
                $('#statistiques-content').show();
            });
        });
    </script>
    <!-- Fin du script d'affichage-->

<!-- Script pour gerer le dataTable de gestion des ouvrages -->
<script>
$(document).ready(function() {
    var SITEURL = '{{ url("/") }}/';

    console.log(SITEURL);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#create-new-livre').click(function() {
        $('#btn-save').val("create-livre");
        $('#livre_id').val('');
        $('#livreForm').trigger("reset");
        $('#livreCrudModal').html("Ajouter Nouveau Livre");
        $('#ajax-livre-modal').modal('show');
        $('#modal-preview').attr('src', 'https://via.placeholder.com/150').addClass('hidden');
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#modal-preview').attr('src', e.target.result).removeClass('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('body').on('change', '#image', function() {
        readURL(this);
    });

    // Ajout et mise à jour
    $('body').on('submit', '#livreForm', function(e) {
        e.preventDefault();
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');
        var formData = new FormData(this);

        var ajaxType = 'POST';
        var ajaxUrl = SITEURL + 'livres/Store';
        if (actionType === 'edit-livre') {
            var livreId = $('#livre_id').val();
            ajaxUrl = SITEURL + 'livres/Update/' + livreId;
        }

        $.ajax({
            type: ajaxType,
            url: ajaxUrl,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('#livreForm').trigger("reset");
                $('#ajax-livre-modal').modal('hide');
                $('#btn-save').html('Save Changes');
                var oTable = $('#laravel_11_datatable').DataTable();
                oTable.ajax.reload();
            },
            error: function(data) {
                console.log('Error:', data);
                $('#btn-save').html('Save Changes');
            }
        });
    });

    //edit
    $('body').on('click', '.edit-livre', function() {
        var livre_id = $(this).data('id');
        $.get(SITEURL + 'livres/Edit/' + livre_id, function(data) {
            $('#livreCrudModal').html("Modifier Livre");
            $('#btn-save').val("edit-livre");
            $('#livre_id').val(livre_id);
            $('#ajax-livre-modal').modal('show');
            $('#isbn').val(data.isbn);
            $('#titre').val(data.titre);
            $('#auteur').val(data.auteur);
            $('#editeur').val(data.editeur);
            $('#langue').val(data.langue);
            $('#date_edition').val(data.date_edition);
            $('#exp_disp').val(data.exp_disp);
            $('#etage').val(data.etage);
            $('#rayon').val(data.rayon);
            $('#nombre_pages').val(data.nombre_pages);
            $('#discipline').val(data.discipline);
            $('#type_ouvrage').val(data.type_ouvrage);
            $('#statut').val(data.statut);
            $('#modal-preview').attr('src', data.image_url).removeClass('hidden');
        });
    });

    //supprimer
    $('body').on('click', '#delete-livre', function() {
        var livre_id = $(this).data('id');
        if (confirm("Êtes-vous sûr de vouloir supprimer ce livre?")) {
            $.ajax({
                type: "GET",
                url: SITEURL + 'livres/Delete/' + livre_id,
                success: function(data) {
                    var oTable = $('#laravel_11_datatable').DataTable();
                    oTable.ajax.reload();
                    alert(data.success);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }
    });

    //================== EXCEL ===============
    $('#import-button').click(function() {
        $('#importFile').click();
    });

    $('#importFile').change(function(e) {
        var formData = new FormData();
        formData.append('file', e.target.files[0]);
        
        $.ajax({
            type: 'POST',
            url: SITEURL + 'import',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                alert('Les livres ont été importés avec succès.');
                var oTable = $('#laravel_11_datatable').DataTable();
                oTable.ajax.reload();
            },
            error: function(data) {
                console.log('Error:', data);
                alert('Erreur lors de l\'importation des livres.');
            }
        });
    });

    $('#laravel_11_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: SITEURL + 'livres',
        columns: [
            { data: 'image', name: 'image' },
            { data: 'isbn', name: 'isbn' },
            { data: 'auteur', name: 'auteur' },
            { data: 'titre', name: 'titre' },
            { data: 'discipline', name: 'discipline' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']]
    });
});

</script>
<!-- Fin script de gestion des ouvrages -->

<!--Script pour Chart JS-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('statistiques.empruntsParMois') }}",
            method: 'GET',
            success: function(data) {
                var colors = [
                    'rgba(255, 161, 0, 1)',
                    'rgba(116, 201, 221, 1)',
                    'rgba(255, 119, 119, 1)',
                    '#fd9219',
                    '#a80f99',
                    '#6ad639',
                    'rgba(255, 161, 0, 1.2)',
                    'rgba(116, 201, 221, 1)',
                    'rgba(255, 119, 119, 1)',
                    'rgba(36, 130, 128, 1)',
                    'rgba(117, 13, 234, 1)',
                    'rgba(106, 214, 57, 1)',
                ];

                var ctx = document.getElementById('empruntsChart').getContext('2d');
            var empruntsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                    datasets: [{
                        label: '# d\'emprunts',
                        data: data,
                        backgroundColor: colors,
                        borderColor: colors.map(color => color.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : '';
                                },
                                stepSize: 1,
                                color: '#000',  
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            ticks: {
                                color: '#000',  
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#000', 
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            titleFont: {
                                size: 13,
                                weight: '500'
                            },
                            bodyFont: {
                                size: 13,
                                weight: '500'
                            }
                        }
                    }
                }
            });
        }
    });
});
      // emprunt par disciplines
      fetch('/statistiques/emprunts-par-discipline')
        .then(response => response.json())
        .then(data => {
            const labels = Object.keys(data);
            const counts = Object.values(data);
            const total = counts.reduce((sum, value) => sum + value, 0);

            const ctx = document.getElementById('empruntsParDisciplineChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Emprunts par discipline',
                        data: counts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1.5)',
                            'rgba(54, 162, 235, 1.5)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const value = counts[tooltipItem.dataIndex];
                                    const percentage = ((value / total) * 100).toFixed(2);
                                    return `${tooltipItem.label}: ${value} emprunts (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
       // Emprunts quotidiens
       fetch('/statistiques/emprunts-quotidiens')
            .then(response => response.json())
            .then(data => {
                document.getElementById('dailyEmpruntsCount').textContent = data;
            });
  


</script>



<!-- Script pour la gestion de la regle de nombre d'emprunt -->
<script>
    $(document).ready(function() {
        var SITEURL = '{{ url("/") }}/';
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $('#create-new-regle').click(function() {
            $('#btn-save').val("create-regle");
            $('#regle_id').val('');
            $('#regleForm').trigger("reset");
            $('#regleCrudModal').html("Ajouter Nouvelle Règle");
            $('#ajax-regle-modal').modal('show');
        });
    
        var regleTable = $('#regle_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: SITEURL + 'regles',
            columns: [
                { data: 'nbr_emprunt', name: 'nbr_emprunt' },
                { data: 'type_tier', name: 'type_tier' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            paging: false, 
            info: false, 
            lengthChange: false, 
            searching: false, 
            order: [[0, 'desc']],
            columnDefs: [
                { width: '33%', targets: 0 },
                { width: '33%', targets: 1 },
                { width: '34%', targets: 2 }
            ]
        });
    
        $('body').on('submit', '#regleForm', function(e) {
            e.preventDefault();
            var actionType = $('#btn-save').val();
            $('#btn-save').html('Sending..');
            var formData = $(this).serialize();
    
            var ajaxType = 'POST';
            var ajaxUrl = SITEURL + 'regles/store';
            if (actionType === 'edit-regle') {
                var regleId = $('#regle_id').val();
                ajaxUrl = SITEURL + 'regles/update/' + regleId;
            }
    
            $.ajax({
                type: ajaxType,
                url: ajaxUrl,
                data: formData,
                success: function(data) {
                    $('#regleForm').trigger("reset");
                    $('#ajax-regle-modal').modal('hide');
                    $('#btn-save').html('Save Changes');
                    regleTable.ajax.reload();
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#btn-save').html('Save Changes');
                }
            });
        });
    
        $('body').on('click', '.edit-regle', function() {
            var regle_id = $(this).data('id');
            $.get(SITEURL + 'regles/edit/' + regle_id, function(data) {
                $('#regleCrudModal').html("Modifier Règle");
                $('#btn-save').val("edit-regle");
                $('#regle_id').val(regle_id);
                $('#ajax-regle-modal').modal('show');
                $('#type_tier').val(data.type_tier);
                $('#nbr_emprunt').val(data.nbr_emprunt);
            });
        });
    
        $('body').on('click', '.delete-regle', function() {
            var regle_id = $(this).data('id');
            if (confirm("Êtes-vous sûr de vouloir supprimer cette règle?")) {
                $.ajax({
                    type: "GET",
                    url: SITEURL + 'regles/delete/' + regle_id,
                    success: function(data) {
                        regleTable.ajax.reload();
                        alert(data.success);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
    });
</script>



  
<!-- Fin script pour la rgele d'emprunt -->  


<script src="{{ asset('javascript/responsablegestion.js') }}"></script>

<!--===========================================================-->


    




 <!-- ====== ionicons ======= -->
 <script type="module" src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js') }}"></script>
 <script nomodule src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js') }}"></script>



 
</body>
</html>


