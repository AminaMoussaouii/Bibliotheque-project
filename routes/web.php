<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RegleEmpruntController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\StatistiquesController;
use App\Http\Controllers\HistoricalUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Auth;
use app\Http\Middleware\CheckBlockedUser;
use App\Http\Middleware\CheckRole;

//route pour l'authentification 

Route::middleware(['web'])->group(function () {
Auth::routes(['register' => false]);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
//Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
Route::get('/', [LoginController::class, 'index']);

//routeS pour admin dashbord

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [adminController::class, 'admin'])->middleware('auth','Role:admin')->name('users.index');
    Route::get('users/get', [adminController::class, 'getUsers']);
    Route::post('users/store', [adminController::class, 'store'])->name('users.store');
    Route::get('users/Edit/{id}', [adminController::class, 'edit']);
    Route::get('users/Delete/{id}', [adminController::class, 'destroy']);
    Route::post('users/update/{id}', [adminController::class, 'update']);
    Route::post('users/block/{id}', [adminController::class, 'block'])->name('users.block');
    Route::post('users/import', [adminController::class, 'import'])->name('users.import');
});



///////////////////////////////////////:::::

// route pour afficher les livres dans la page du catalogue
Route::get('/catalogue', [LivreController::class, 'index'])->middleware('auth','Role:etudiant','Role:personnel')->name('catalogue');

//route pour afficher la page dashboard d responsable
Route::get('/responsable', [LivreController::class, 'responsable'])->middleware('auth','Role:responsable')->name('responsable');



       Route::middleware('auth')->group(function () {

       Route::get('livres', [LivreController::class, 'getLivres']);
       Route::post('livres/Store', [LivreController::class, 'store'])->name('livres.store');

       Route::get('livres/Edit/{id}', [LivreController::class, 'edit']);
       Route::get('livres/Delete/{id}', [LivreController::class, 'destroy']);

       Route::post('livres/Update/{id}',[LivreController::class,'update']);
       });
      




// fin gestion responsable


//router pour rediriger vers la page des details de chaque livre
Route::get('/livres/{id}', [LivreController::class, 'afficherDetails']);


//route pour filtrer les recherches dans le sidebar
Route::get('/livres/filtres', [LivreController::class, 'filtrer'])->name('livres.filtrer');


//afficher le form de reservation 
Route::get('/livres/{id}/reserver', [ReservationController::class, 'reserverLivre'])->name('livres.reserver');




//enregistrer la reservation 
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
//emprunter un un livre
Route::post('/reservations/emprunter/{id}', [ReservationController::class, 'emprunter'])->name('reservations.emprunter');


//bibliothecaire

      Route::get('/bibliothecaire', function () {
         return view('bibliothecaire');
        })->middleware('auth','Role:bibliothècaire');
    //gestions des reservations 
   // Route::get('/reservations', [ReservationController::class, 'index']);
   Route::get('/reservations', [ReservationController::class, 'index'])->middleware('auth')->name('reservations.index');
   Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
   Route::post('reservations/emprunter/{id}', [ReservationController::class,'emprunter'])->middleware('auth')->name('reservations.emprunter');
// route emprunt

Route::get('emprunts', [EmpruntController::class, 'index'])->name('emprunts.index');
Route::post('/emprunt/retourner', [EmpruntController::class, 'retourner'])->name('emprunt.retourner');


Route::get('/bibliothècaire', [ReservationController::class, 'bibliothècaire'])->middleware('auth','Role:bibliothècaire')->name('bibliothècaire');






// Routes pour l'exportation d'un fichier excel 
Route::post('/import', [LivreController::class, 'import'])->name('import');

//Routes pour la methode de recherche des livres 
//Route::get('livres-list',[LivreController::class,'livresListAjax']);
Route::get('/catalogue', [LivreController::class, 'index'])->middleware('auth')->name('catalogue');

Route::get('/livre/search', [LivreController::class, 'search'])->name('livre.search');

Route::get('/mes-emprunts', [HistoricalUserController::class, 'index'])->name('HistoricalUser');


//search respo 
Route::get('/livres/search', [LivreController::class,'searchResponsable'])->name('livres.search.responsable');



//===============Gestion regle d'emprunt =======================


// Routes pour les règles d'emprunt
Route::resource('regles', RegleEmpruntController::class);
Route::post('regles/store', [RegleEmpruntController::class, 'store'])->name('regles.store');
Route::post('regles/update/{id}', [RegleEmpruntController::class, 'update'])->name('regles.update');
Route::get('regles/delete/{id}', [RegleEmpruntController::class, 'destroy'])->name('regles.destroy');
Route::get('regles/edit/{id}', [RegleEmpruntController::class, 'edit'])->name('regles.edit');



//Chart JS ==============================
/////data: {!! json_encode(array_values($data)) !!}
Route::get('/statistiques/emprunts-par-mois', [StatistiquesController::class, 'empruntsParMois'])->name('statistiques.empruntsParMois');

Route::get('/statistiques/emprunts-par-discipline', [StatistiquesController::class, 'empruntsParDiscipline'])->name('statistiques.empruntsParDiscipline');

Route::get('/statistiques/emprunts-quotidiens', [StatistiquesController::class,'empruntsQuotidiens']);

//Route::get('pdf_generator', [ReservationController::class,'telechargerPDF']);
Route::get('reservation/pdf', [ReservationController::class, 'telechargerPDF'])->name('reservation.telechargerPDF');

Route::get('retards', [EmpruntController::class, 'getRetards'])->name('retards.index');
Route::post('retards/envoyer-email', [EmpruntController::class, 'envoyerEmail'])->name('retards.envoyerEmail');

Route::get('/livre/filtre', [LivreController::class, 'filtre'])->name('livre.filtre');

});


