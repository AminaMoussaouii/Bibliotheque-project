<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
    <script>var SITEURL = '{{ url("/") }}';</script>

    <style>
        #laravel_11_datatable_filter label {
            margin-bottom: 30px;
            margin-right: 110px;

        }

        #laravel_11_datatable_filter label #text {
            color: blue;
            font-weight: bold;
        }

        #laravel_11_datatable_filter input[type="search"] {
            border: 2px solid #2679e7;
            border-radius: 20px;
            box-shadow: 0 5px 8px #9a9a9a;
            outline: none;
        }

        .dataTables_length label {
            margin-left: 110px
        }

        .control-label {
            color: brown;
            font-weight: 500;
            font-family: 'Times New Roman', Times, serif;
        }

        .odd img {
            height: 60px;
            width: 50px;
            margin-left: 20px;
        }

        .even img {
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
                        <span class="title">Administrateur</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-link" id="gerer-ouvrages">
                        <span class="icon"><i class="fa-solid fa-list-check"></i></span>
                        <span class="title">Gérer les utilisateurs</span>
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
            <div class="containergestion" style="padding-left: 50px; padding-right:50px; padding-bottom:70px">
                <h2 style="margin-left: 90px; margin-top:50px">Gestion des utilisateurs</h2>
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-user"
                    style="margin-left: 110px; background-color: #f99324; border:none; border-radius:10px; box-shadow: 0 5px 5px #9a9a9a;">Ajouter
                    utilisateur</a>
                <input type="file" id="importFile" style="display:none;">
                <a href="javascript:void(0)" class="btn btn-info ml-3" id="import-button"
                    style="background-color: #f99324; border:none; border-radius:10px; box-shadow: 0 5px 5px #9a9a9a;">Importer
                    fichier Excel</a>
                <br><br>
                <table class="table table-bordered table-striped" id="laravel_11_datatable" style="height: 380px;">
                    <thead>
                        <tr style="background-color: #096097;">
                            <th style="color: white; font-weight:500; border-top-left-radius: 13px;">Nom</th>
                            <th style="color: white; font-weight:500">Prénom</th>
                            <th style="color: white; font-weight:500">Email</th>
                            <!--<th style="color: white; font-weight:500">Password</th>-->
                            <th style="color: white; font-weight:500">Tél</th>
                            <th style="color: white; font-weight:500">Role</th>
                            <th style="color: white; font-weight:500">Filière</th>
                            <th style="color: white; font-weight:500">Code_Apogée</th>
                            <th style="color: white; font-weight:500">Department</th>
                            <th style="color: white; font-weight:500">PPR</th>
                            <th style="color: white; font-weight:500; border-top-right-radius: 13px;">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal fade" id="ajax-user-modal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="userCrudModal"></h4>
                        </div>
                        <div class="modal-body">
                            <form id="userForm" name="userForm" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" id="user_id">
                                <div class="form-group">
                                    <label for="nom" class="col-sm-2 control-label">Nom</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="nom" name="nom"
                                            placeholder="Entrer nom" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="prénom" class="col-sm-2 control-label">Prénom</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="prénom" name="prénom"
                                            placeholder="Entrer prénom" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-12">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Entrer email" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="password" name="password"
                                            placeholder="Entrer mot de passe" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Role" class="col-sm-2 control-label">Role</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="Role" name="Role" required="">
                                            <option value="etudiant">Etudiant</option>
                                            <option value="personnel">Personnel</option>
                                            <option value="responsable">Responsable</option>
                                            <option value="admin">Administrateur</option>
                                            <option value="bibliothècaire">Bibliothècaire</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div id="etudiant-fields" class="form-group">
                                    <div>
                                <label for="Code_Apogée" class="col-sm-2 control-label">Code Apogée</label>
                                <input type="text" name="Code_Apogée" id="Code_Apogée" class="form-control">
                                </div>
                                <div>
                                <label for="CNE" class="col-sm-2 control-label">CNE</label>
                                <input type="text" name="CNE" id="CNE" class="form-control">
                                </div>
                                <div>
                                <label for="Filière" class="col-sm-2 control-label">Filière</label>
                                <input type="text" name="Filière" id="Filière" class="form-control">
                                </div>
                            </div>
    
                            <div id="personnel-fields" class="form-group">
                                <div>
                                <label for="department" class="col-sm-2 control-label">Department</label>
                                <input type="text" name="department" id="department" class="form-control">
                                </div>
                                <div>
                                <label for="PPR" class="col-sm-2 control-label">PPR</label>
                                <input type="text" name="PPR" id="PPR" class="form-control">
                                </div>
                            </div>

                            <div id="common-fields" class="form-group">
                                <div>
                                <label for="PPR" class="col-sm-2 control-label">PPR</label>
                                <input type="text" name="PPR" id="PPR" class="form-control">
                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="Tél" class="col-sm-2 control-label">Tél</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="Tél" name="Tél"
                                            placeholder="Entrer numéro tél" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" id="btn-save"
                                        value="create">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
   document.addEventListener('DOMContentLoaded', function () {
    var roleSelect = document.getElementById('Role');
    var etudiantFields = document.getElementById('etudiant-fields');
    var personnelFields = document.getElementById('personnel-fields');
    var commonFields = document.getElementById('common-fields');

    // Hide all role-specific fields initially
    etudiantFields.style.display = 'none';
    personnelFields.style.display = 'none';
    commonFields.style.display = 'none';

    function toggleFields() {
        var role = roleSelect.value;
        etudiantFields.style.display = role === 'etudiant' ? 'block' : 'none';
        personnelFields.style.display = role === 'personnel' ? 'block' : 'none';
        commonFields.style.display = (role === 'responsable' || role === 'bibliothècaire' || role === 'admin') ? 'block' : 'none';
    }

    roleSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initial call to set correct fields on page load
});
</script>

        <script>
             $(document).ready(function () {
                var SITEURL = '{{ url("/") }}/';

                console.log(SITEURL);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#create-new-user').click(function () {
                    $('#btn-save').val("create-user");
                    $('#user_id').val('');
                    $('#userForm').trigger("reset");
                    $('#userCrudModal').html("Ajouter Nouveau utilisateur");
                    $('#ajax-user-modal').modal('show');
                });

                $('body').on('change', '#image', function () {
                    readURL(this);
                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#modal-preview').attr('src', e.target.result).removeClass('hidden');
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
   
                // Ajout utilisateur
            
                $('body').on('submit', '#userForm', function (e) {
                    e.preventDefault();
                    var actionType = $('#btn-save').val();
                    $('#btn-save').html('Sending..');
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: SITEURL + 'admin/users/store',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            $('#userForm').trigger("reset");
                            $('#ajax-user-modal').modal('hide');
                            $('#btn-save').html('Save Changes');
                            var oTable = $('#laravel_11_datatable').DataTable();
                            oTable.ajax.reload();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            $('#btn-save').html('Save Changes');
                        }
                    });
                });

                //modification des donnees

                $('body').on('submit', '#userForm', function (e) {
                    e.preventDefault();
                    var actionType = $('#btn-save').val();
                    $('#btn-save').html('Sending..');
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: SITEURL + 'admin/users/update/' + $('#user_id').val(),
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,

                        success: function (data) {
                            console.log(data);
                            $('#userForm').trigger("reset");
                            $('#ajax-user-modal').modal('hide');
                            $('#btn-save').html('Save Changes');
                            var oTable = $('#laravel_11_datatable').DataTable();
                            oTable.ajax.reload();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            // alert('Erreur lors de la mise à jour du livre. Veuillez vérifier les logs pour plus de détails.');
                            $('#btn-save').html('Save Changes');
                        }
                    });
                });

                //edit 
                $('body').on('click', '.edit-user', function () {
                    var user_id = $(this).data('id');
                    $.get(SITEURL + 'admin/users/Edit/' + user_id, function (data) {
                        $('#userCrudModal').html("Modifier utilisateur");
                        $('#btn-save').val("edit-user");
                        $('#user_id').val(user_id);
                        $('#ajax-user-modal').modal('show');
                        $('#nom').val(data.nom);
                        $('#prénom').val(data.prénom);
                        $('#email').val(data.email);
                        $('#password').val(data.password);
                        $('#Role').val(data.Role);
                        $('#Tél').val(data.Tél);
                    });
                });

                //supprimer utilisateur

                $('body').on('click', '#delete-user', function () {
                    var user_id = $(this).data('id');
                    if (confirm("Êtes-vous sûr de vouloir supprimer ce utilisateur?")) {
                        $.ajax({
                            type: "GET",
                            url: SITEURL + 'admin/users/Delete/' + user_id,
                            success: function (data) {
                                var oTable = $('#laravel_11_datatable').DataTable();
                                oTable.ajax.reload();
                                alert(data.success);
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });

                //bloquer utilisateur
                $('body').on('click', '.block-user', function() {
                 var user_id = $(this).data('id');
               if (confirm("Êtes-vous sûr de vouloir bloquer/débloquer cet utilisateur?")) {
               $.ajax({
                 type: "POST",
                url: SITEURL + 'admin/users/block/' + user_id,
                data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
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


                //importation excel
                $(document).ready(function () {
                    var SITEURL = '{{ url("/") }}/';

                    console.log(SITEURL);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#create-new-user').click(function () {
                        $('#btn-save').val("create-user");
                        $('#user_id').val('');
                        $('#userForm').trigger("reset");
                        $('#userCrudModal').html("Ajouter Nouveau utilisateur");
                        $('#ajax-user-modal').modal('show');
                    });

                    $('#import-button').click(function () {
                        $('#importFile').click();
                    });

                    $('#importFile').change(function (e) {
                        var formData = new FormData();
                        formData.append('file', e.target.files[0]);

                        $.ajax({
                            type: 'POST',
                            url: SITEURL + 'admin/users/import',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                console.log(data);
                                alert('Les utilisateurs ont été importés avec succès.');
                                var oTable = $('#laravel_11_datatable').DataTable();
                                oTable.ajax.reload();
                            },
                            error: function (data) {
                                console.log('Error:', data);
                                alert('Erreur lors de l\'importation des utilisateurs.');
                            }
                        });
                    });

                });


                $('#laravel_11_datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: SITEURL + 'admin/users/get',
                    columns: [
                        { data: 'nom', name: 'nom' },
                        { data: 'prénom', name: 'prénom' },
                        { data: 'email', name: 'email' },
                        //{ data: 'password', name: 'password' },
                        { data: 'Tél', name: 'Tél' },
                        { data: 'Role', name: 'Role' },
                        { data: 'Filière', name: 'Filière' },
                        { data: 'Code_Apogée', name: 'Code_Apogée' },
                        { data: 'department', name: 'department' },
                        { data: 'PPR', name: 'PPR' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ],
                    order: [[0, 'desc']]
                });
            });

        </script>
        <!-- <script>
    $(document).ready(function() {
    var SITEURL = '{{ url("/") }}/';

    console.log(SITEURL);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#create-new-user').click(function() {
        $('#btn-save').val("create-user");
        $('#user_id').val('');
        $('#userForm').trigger("reset");
        $('#userCrudModal').html("Ajouter Nouveau Utilisateur");
        $('#ajax-user-modal').modal('show');
        //$('#modal-preview').attr('src', 'https://via.placeholder.com/150').addClass('hidden');
    });

     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            //reader.onload = function(e) {
                //$('#modal-preview').attr('src', e.target.result).removeClass('hidden');
           // };
            reader.readAsDataURL(input.files[0]);
        }
    }
});
    // Ajout
    $('body').on('submit', '#userForm', function(e) {
        e.preventDefault();
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');
        var formData = new FormData(this);
        var url = actionType === 'create-user' ? SITEURL + 'admin/users/store' : SITEURL + 'admin/users/update/' + $('#user_id').val();
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('#userForm').trigger("reset");
                $('#ajax-user-modal').modal('hide');
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

    // Edit
    
    $('body').on('click', '.edit-user', function() {
        var user_id = $(this).data('id');
        $.get(SITEURL + 'admin/users/Edit/' + user_id, function(data) {
            $('#userCrudModal').html("Modifier user");
            $('#btn-save').val("edit-user");
            $('#user_id').val(user_id);
            $('#ajax-user-modal').modal('show');
            $('#nom').val(data.nom);
            $('#prénom').val(data.prénom);
            $('#email').val(data.email);
            $('#password').val(data.password);
            $('#Role').val(data.Role);
            $('#Tél').val(data.Tél);
        });
    });
   
    //supprimer 
    $('body').on('click', '#delete-user', function() {
        var user_id = $(this).data('id');
        if (confirm("Êtes-vous sûr de vouloir supprimer ce utilisateur?")) {
            $.ajax({
                type: "GET",
                url: SITEURL + 'admin/users/Delete/' + user_id,
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
    // Block/Unblock User 
    /*$('body').on('click', '.block-user', function() {
        var user_id = $(this).data('id');
        if (confirm("Êtes-vous sûr de vouloir bloquer/débloquer cet utilisateur?")) {
            $.ajax({
                type: "POST",
                url: SITEURL + 'admin/users/block/' + user_id,
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
    });*/

    // Import Users
$(document).ready(function() {
                var SITEURL = '{{ url("/") }}/';

                console.log(SITEURL);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                 $('#import-button').click(function() {
                    $('#importFile').click();
                });

                $('#importFile').change(function(e) {
                    var formData = new FormData();
                    formData.append('file', e.target.files[0]);
                    
                    $.ajax({
                        type: 'POST',
                        url: SITEURL + 'admin/users/import',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            console.log(data);
                            alert('Les utilisateurs ont été importés avec succès.');
                            var oTable = $('#laravel_11_datatable').DataTable();
                            oTable.ajax.reload();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            alert('Erreur lors de l\'importation des utilisateurs.');
                        }
                    });
                });

            });


    $('#laravel_11_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: SITEURL + 'admin/users/get',
        columns: [
            { data: 'nom', name: 'nom' },
            { data: 'prénom', name: 'prénom' },
            { data: 'email', name: 'email' },
            { data: 'password', name: 'password' },
            { data: 'Role', name: 'Role' },
            { data: 'Tél', name: 'Tél' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']]
    });
</script>-->






    </div>




    <script src="{{ asset('javascript/responsablegestion.js') }}"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js') }}"></script>
    <script nomodule src="{{ asset('https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js') }}"></script>






</body>

</html>