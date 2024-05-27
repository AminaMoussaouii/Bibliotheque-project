<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Auth;

//route pour l'authentification 

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::get('/','index')->name('index');
    Route::post('/login/store', 'Redirection')->name('Redirection');
    Route::post('/logout', 'logout')->name('logout');
});
Auth::routes([
    'register' => false, // Désactiver l'inscription);
]);

//routeS pour admin dashbord

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [adminController::class, 'admin'])->name('users.index');
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
Route::get('/catalogue', [LivreController::class, 'index'])->name('catalogue');

//route pour afficher la page dashboard d responsable
Route::get('/responsable', [LivreController::class, 'responsable'])->name('responsable');


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

       Route::get('livres', [LivreController::class, 'getLivres']);
       Route::post('livres/Store', [LivreController::class, 'store'])->name('livres.store');

       Route::get('livres/Edit/{id}', [LivreController::class, 'edit']);
       Route::get('livres/Delete/{id}', [LivreController::class, 'destroy']);
       Route::post('livres/Update/{id}',[LivreController::class,'update']);
      
      



// fin gestion responsable


//router pour rediriger vers la page des details de chaque livre
Route::get('/livres/{id}', [LivreController::class, 'afficherDetails']);
/*Route::get('/livre/{id}', [LivreController::class, 'show'])->name('details_livre');*/

//route pour filtrer les recherches dans le sidebar
Route::get('/livres/filtre', [LivreController::class, 'filtrerLivres'])->name('livres.filtrer');



Route::get('/reservation', [ReservationController::class, 'show'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

//bibliothecaire
Route::get('/bibliothècaire', [ReservationController::class, 'bibliothècaire'])->name('bibliothècaire');
//gestions des reservations 
Route::get('/reservations', [ReservationController::class, 'index']);



// Routes pour l'export et import d'un fichier excel 
Route::post('/import', [LivreController::class, 'import'])->name('import');

//Routes pour la methode de recherche des livres 
//Route::get('livres-list',[LivreController::class,'livresListAjax']);
Route::get('/catalogue', [LivreController::class, 'index'])->name('catalogue');
Route::get('/livre/search', [LivreController::class, 'search'])->name('livre.search');

Auth::routes();
//search respo 
Route::get('/livres/search', [LivreController::class,'searchResponsable'])->name('livres.search.responsable');

