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

<!--================================================================================================-->
<div class="containergestion-regle-emprunt" style="padding-left: 50px; padding-right:50px;padding-bottom:70px">
    <h2 style="margin-left: 110px">Gestion de la regle de nombre d'emprunt</h2>
    <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-Regle" style="margin-left: 110px; background-color: #f99324; border:none;border-radius:10px   ;box-shadow: 0 5px 5px #9a9a9a; ">Ajouter</a>
    <br><br>
    <table class="table table-bordered table-striped" id="laravel_11_datatable" style="height: 380px;">
        <thead>
            <tr style="background-color: #2679e7;">
                <th style="color: white;font-weight:500">Type tier</th>
                <th style="color: white;font-weight:500">Nombre d'emprunt</th>
                <th style="color: white;font-weight:500;  border-top-right-radius: 13px;">Action</th>
            </tr>
        </thead>
    </table>
</div>
<div class="modal fade" id="ajax-Regle-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="RegleCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="RegleForm" name="RegleForm" class="form-horizontal" enctype="multipart/form-data">
                 @csrf
                 <input type="hidden" name="Regle_id" id="Regle_id">
                 
        
                   
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label" >Type tier</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="type_tier" name="type_tier" value="" maxlength="50" required="" height="20px">
                                <option value="Ellipses">Professeur</option>
                                <option value="Meral">Étudiant</option>
                            </select> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre d'emprunt</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="nbr_emprunt" name="nbr_emprunt" placeholder="Entrer Nombre emprunt" value="" maxlength="50" required="" height="20px"> 
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
<!-- ============================================================================= -->


</body>
</html>
