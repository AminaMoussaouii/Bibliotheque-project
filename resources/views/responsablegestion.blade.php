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

    <!-- JS Libraries -->
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
                    <a href="#" class="sidebar-link" id="gerer-ouvrages">
                        <span class="icon"><i class="fa-solid fa-list-check"></i></span>
                        <span class="title">Gérer les Ouvrages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('#') }}" class="sidebar-link">
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
                    <a href="{{ url('#') }}" class="sidebar-link">
                        <span class="icon"><i class="fa-solid fa-chart-column"></i></span>
                        <span class="title">Statistiques</span>
                    </a>
                </li>
                <!--<li>
                    <a href="{{ url('logout') }}" class="sidebar-link">
                        <span class="icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                        <span class="title">Déconnexion</span>
                    </a>
                    </li>-->
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
            <div class="containergestion" style="padding-left: 50px; padding-right:50px;padding-bottom:70px">
                <h2 style="margin-left: 110px">Gestion des ouvrages</h2>
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-livre" style="margin-left: 110px; background-color: #f99324; border:none;border-radius:10px   ;box-shadow: 0 5px 5px #9a9a9a; ">Ajouter</a>
                <input type="file" id="importFile" style="display:none;">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="import-button" style="background-color: #f99324; border:none;border-radius:10px; box-shadow: 0 5px 5px #9a9a9a;">Importer</a>
        
                <br><br>
                <table class="table table-bordered table-striped" id="laravel_11_datatable" style="height: 380px;">
                    <thead>
                        <tr style="background-color: #2679e7;">
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
    </div>


  
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

    $('body').on('change', '#image', function() {
        readURL(this);
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
    // Ajout
    $('body').on('submit', '#livreForm', function(e) {
        e.preventDefault();
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: SITEURL + 'livres/Store',
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
    
//modification methode (update)

    $('body').on('submit', '#livreForm', function(e) {
    e.preventDefault();
    var actionType = $('#btn-save').val();
    $('#btn-save').html('Sending..');
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: SITEURL + 'livres/Update/' + $('#livre_id').val(),
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
           // alert('Erreur lors de la mise à jour du livre. Veuillez vérifier les logs pour plus de détails.');
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
                    //$('#modal-preview').attr('src', 'https://via.placeholder.com/150').addClass('hidden');
                });

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

    
    
        
        


       
    </div>




<script src="{{ asset('javascript/responsablegestion.js') }}"></script>
 <!-- ====== ionicons ======= -->
 <script type="module" src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js') }}"></script>
 <script nomodule src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js') }}"></script>






</body>
</html>
