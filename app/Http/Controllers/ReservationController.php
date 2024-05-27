<?php

namespace App\Http\Controllers;

use App\Models\UserLibrary;
use Illuminate\Http\Request;
use App\Models\Reservation; 
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{ 
    public function bibliothècaire()
    {
        return view('bibliothecaire');
    }  
    //pour afficher le formulaire de demande de reservation 
    public function show()
    {
        // Récupérer l'utilisateur connecté
    $user = Auth::user();
    
    // Vérifier si l'utilisateur est connecté
    if ($user) {
        // Afficher le formulaire de réservation avec les informations de l'utilisateur
        return view('formReservation', compact('user'));
    } else {
        // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
        return redirect()->route('login')->with('error', 'Vous devez vous connecter pour accéder à cette page');
    }
    }
    
    
    public function store(Request $request)
    {
    
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email',
            'titre' => 'required|string',
            'auteur' => 'required|string',
            'rayon' => 'nullable|string',
            'etage' => 'nullable|string',
            'branche' => 'nullable|string',
        ]);

        $reservation = new Reservation();
        $reservation->nom = $validatedData['nom'];
        $reservation->prenom = $validatedData['prenom'];
        $reservation->email = $validatedData['email'];
        $reservation->titre = $validatedData['titre'];
        $reservation->auteur = $validatedData['auteur'];
        $reservation->rayon = $validatedData['rayon'];
        $reservation->etage = $validatedData['etage'];
        $reservation->branche = $validatedData['branche'];
        $reservation->save();

        return back();
    }

  //table de reservation affichage
  public function index()
  {
    $reservations = Reservation::all();
    return response()->json(['reservations' => $reservations]);
  }
 
// ===================== PDF ================

public function telechargerPDF(Request $request)
{
    // Valider et enregistrer les données dans la base de données
    $reservation = new Reservation();
    $reservation->nom = $request->input('nom');
    $reservation->prenom = $request->input('prenom');
    $reservation->email = $request->input('email');
    $reservation->titre = $request->input('titre');
    $reservation->auteur = $request->input('auteur');
    $reservation->rayon = $request->input('rayon');
    $reservation->etage = $request->input('etage');
    $reservation->branche = $request->input('branche');
    $reservation->save();

    // Générer le PDF
    $pdfData = [
        'Nom' => $request->input('nom'),
        'Prénom' => $request->input('prenom'),
        'Email' => $request->input('email'),
        'Branche' => $request->input('branche'),
        'Titre' => $request->input('titre'),
        'Auteur' => $request->input('auteur'),
        'Rayon' => $request->input('rayon'),
        'Étage' => $request->input('etage'),
    ];

    $pdf = PDF::loadView('pdf', $pdfData);

    // Télécharger le PDF
    return $pdf->download('reservation.pdf');}

  
}