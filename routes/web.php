<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\adminController;

//route pour l'authentification 

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::get('/','index')->name('index');
    Route::post('/login/store', 'Redirection')->name('Redirection');
    Route::post('/logout', 'logout')->name('logout');
});
//route pour admin dashbord
Route::controller(adminController::class)->group(function() {
    Route::get('/admin', 'admin')->name('admin');
    Route::post('/admin/ajouter', 'store')->name('ajouterUser');
    Route::post('/import', 'import')->name('import');
});

Auth::routes([
    'register' => false, // Désactiver l'inscription);
]);

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
       Route::post('/livres/ajouter', [LivreController::class, 'store'])->name('livres.store');

       //recuperer les livres existants pour les modifier 
       Route::get('/livres', [LivreController::class, 'getAllLivres'])->name('livres.all');
       // Route pour mettre à jour un livre
       Route::put('/livres/{id}', [LivreController::class, 'update'])->name('livres.update');

       //reccuperer les infos du livre à modifier
        Route::get('/livres/{id}/modifier', [LivreController::class, 'modifier'])->name('livres.modifier');
       
        //suppression d'un livre 
        Route::delete('/livres/{id}', [LivreController::class, 'destroy'])->name('livres.destroy');

    

// fin gestion responsable


//router pour rediriger vers la page des details de chaque livre
Route::get('/livres/{id}', [LivreController::class, 'afficherDetails']);

//route pour filtrer les recherches dans le sidebar
Route::get('/livres/filtre', [LivreController::class, 'filtrerLivres'])->name('livres.filtrer');

Route::get('/livre/{id}', [LivreController::class, 'show'])->name('details_livre');

Route::get('/reservation', [ReservationController::class, 'show'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

//bibliothecaire
Route::get('/bibliothècaire', [ReservationController::class, 'bibliothècaire'])->name('bibliothècaire');
//gestions des reservations 
Route::get('/reservations', [ReservationController::class, 'index']);




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
