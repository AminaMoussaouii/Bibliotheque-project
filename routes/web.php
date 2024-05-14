<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\ReservationController;


Route::get('/', function () {
    return redirect()->route('catalogue');
});
// route pour afficher les livres dans la page du catalogue
Route::get('/catalogue', [LivreController::class, 'index'])->name('catalogue');

Route::get('/login', function () {

    return view('login');
})->name('login');
//route pour afficher la page dashboard d responsable
Route::get('/responsable', function () {
    return view('responsablegestion');
});

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
      Route::get('/bibliothecaire', function () {
         return view('bibliothecaire');
        });
    //gestions des reservations 
    Route::get('/reservations', [ReservationController::class, 'index']);



