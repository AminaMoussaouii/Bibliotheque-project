<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSTS LIBRARY</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/historical.css') }}">
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
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #398ec3 !important">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="{{ asset('public/images/fsts_logo.png') }}" alt="" style="width: 60px;height:60px;margin-left:40px;"> FSTS</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('catalogue') }}">Ouvrages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-bell"></i></a>
                        </li>
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                           <button class="btn-logout"> <a class="nav-linka" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: white;font-size:14px">
                                <i class="fa-solid fa-user"></i> Déconnexion
                            </a></button>
                        </li>  
                    </ul>
                </div>
            </div>
        </nav>
<div class="main-content">
            <div class="containergestion" style="padding-left: 50px; padding-right:50px; padding-bottom:70px">
                <br><br>
                <table class="table table-bordered table-striped" id="laravel_11_datatable" style="height: 380px;">
                    <thead>
                        <tr style="background-color: #096097;">
                            <th style="color: white; font-weight:500; border-top-left-radius: 13px;">Titre d'ouvrage</th>
                            <th style="color: white; font-weight:500">Auteur</th>
                            <th style="color: white; font-weight:500">Date d'emprunt</th>
                            <th style="color: white; font-weight:500">Date de retour</th>
                        </tr>
                    </thead>
                </table>
            </div>
</div>



<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#laravel_11_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("HistoricalUser") }}',
                type: 'GET'
            },
            columns: [
                { data: 'titre', name: 'titre' },
                { data: 'auteur', name: 'auteur' },
                { data: 'created_at', name: 'created_at', title: 'Date Emprunt' }, 
                { data: 'date_retour', name: 'date_retour' }
            ]
        });
    });
</script>


</body>
</html>