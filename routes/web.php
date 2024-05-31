<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RegleEmpruntController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\StatistiquesController;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Auth;
use app\Http\Middleware\CheckBlockedUser;

//route pour l'authentification 
// Route::withoutMiddleware([CheckBlockedUser::class])->group(function() {
// Route::controller(LoginController::class)->group(function() {
//     Route::get('/login', 'login')->name('login');
//     Route::get('/','index')->name('index');
//     Route::post('/login/store', 'Redirection')->name('Redirection');
//     Route::post('/logout', 'logout')->name('logout');
// });
// });

Auth::routes(['register' => false]);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
//Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
Route::get('/', [LoginController::class, 'index']);

//routeS pour admin dashbord

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('users', [adminController::class, 'admin'])->middleware('auth')->name('users.index');
    Route::get('users/get', [adminController::class, 'getUsers']);
    Route::post('users/store', [adminController::class, 'store'])->name('users.store');
    Route::get('users/Edit/{id}', [adminController::class, 'edit']);
    Route::get('users/Delete/{id}', [adminController::class, 'destroy']);
    Route::post('users/update/{id}', [adminController::class, 'update']);
    Route::post('users/block/{id}', [adminController::class, 'block'])->name('users.block');
    Route::post('users/import', [adminController::class, 'import'])->name('users.import');
});

/*Route::get('/admin', [adminController::class, 'admin']);

Route::get('users', [adminController::class, 'getUsers']);
Route::post('users/store', [adminController::class, 'store'])->name('users.store');
Route::get('users/Edit/{id}', [adminController::class, 'edit']);
Route::get('users/Delete/{id}', [adminController::class, 'destroy']);
Route::post('users/update/{id}', [adminController::class, 'update']);
Route::post('/import', [adminController::class, 'import'])->name('import');*/

// Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');



///////////////////////////////////////:::::
/*Route::get('/', function () {
    return redirect()->route('catalogue');
});*/
// route pour afficher les livres dans la page du catalogue
Route::get('/catalogue', [LivreController::class, 'index'])->middleware('auth')->name('catalogue');

//route pour afficher la page dashboard d responsable
Route::get('/responsable', [LivreController::class, 'responsable'])->middleware('auth')->name('responsable');


//debut routes pour faires appels aux methodes ajouter modifer supprimer pour le responsable
       //ajouter nv livre
     //  Route::post('/livres/ajouter', [LivreController::class, 'store'])->name('livres.store');

       //recuperer les livres existants pour les modifier 
      // Route::get('/livres', [LivreController::class, 'getAllLivres'])->name('livres.all');
       // Route pour mettre à jour un livre
      // Route::put('/livres/{id}', [LivreController::class, 'update'])->name('livres.update');

       //reccuperer les infos du livre à modifier
       // Route::get('/livres/{id}/modifier', [LivreController::class, 'modifier'])->name('livres.modifier');
       
        //suppression d'un livre 
       // Route::delete('/livres/{id}', [LivreController::class, 'destroy'])->name('livres.destroy');
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
/*Route::get('/livre/{id}', [LivreController::class, 'show'])->name('details_livre');*/

//route pour filtrer les recherches dans le sidebar
Route::get('/livres/filtre', [LivreController::class, 'filtrerLivres'])->name('livres.filtrer');



//Route::get('/reservation', [ReservationController::class, 'show'])->name('reservation');
Route::get('/livres/{id}/reserver', [LivreController::class, 'reserverLivre'])->name('livres.reserver');

// <button><a href="{{ route('reservation') }}" target="blank">Réserver</a></button>
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::post('/reservations/emprunter/{id}', [ReservationController::class, 'emprunter'])->name('reservations.emprunter');


//bibliothecaire

      Route::get('/bibliothecaire', function () {
         return view('bibliothecaire');
        })->middleware('auth');
    //gestions des reservations 
   // Route::get('/reservations', [ReservationController::class, 'index']);
   Route::get('/reservations', [ReservationController::class, 'index'])->middleware('auth')->name('reservations.index');
   Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
   Route::post('reservations/emprunter/{id}', [ReservationController::class,'emprunter'])->middleware('auth')->name('reservations.emprunter');

   // routes/web.php

Route::get('emprunts', [EmpruntController::class, 'index'])->name('emprunts.index');



Route::get('/bibliothècaire', [ReservationController::class, 'bibliothècaire'])->middleware('auth')->name('bibliothècaire');
//gestions des reservations 
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');




// Routes pour l'export et import d'un fichier excel 
Route::post('/import', [LivreController::class, 'import'])->name('import');

//Routes pour la methode de recherche des livres 
//Route::get('livres-list',[LivreController::class,'livresListAjax']);
Route::get('/catalogue', [LivreController::class, 'index'])->middleware('auth')->name('catalogue');
Route::get('/livre/search', [LivreController::class, 'search'])->name('livre.search');


//search respo 
Route::get('/livres/search', [LivreController::class,'searchResponsable'])->name('livres.search.responsable');



//===============Gestion regle d'emprunt =======================


// Route pour les règles d'emprunt
// routes/web.php

Route::get('/regles', [RegleEmpruntController::class, 'index']);
Route::post('/regles', [RegleEmpruntController::class,'store'])->name('regles.store');

Route::get('/regles/{id}/edit', [RegleEmpruntController::class, 'edit'])->name('regles.edit');
Route::put('/regles/{id}', [RegleEmpruntController::class, 'update'])->name('regles.update');

Route::delete('/regles/{id}', [RegleEmpruntController::class, 'destroy']);


// Route::get('/test-session', function () {
//     Session::put('key', 'value');
//     return Session::get('key');
// });


//Chart JS ==============================
/////data: {!! json_encode(array_values($data)) !!}
Route::get('/statistiques/emprunts-par-mois', [StatistiquesController::class, 'empruntsParMois'])->name('statistiques.empruntsParMois');

Route::get('/statistiques/emprunts-par-discipline', [StatistiquesController::class, 'empruntsParDiscipline'])->name('statistiques.empruntsParDiscipline');

Route::get('/statistiques/emprunts-quotidiens', [StatistiquesController::class,'empruntsQuotidiens']);

//Route::get('pdf_generator', [ReservationController::class,'telechargerPDF']);
Route::get('reservation/pdf', [ReservationController::class, 'telechargerPDF'])->name('reservation.telechargerPDF');




