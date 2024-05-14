<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; 
use PDF;

class ReservationController extends Controller
{
    //pour afficher le formulaire de demande de reservation 
    public function show()
    {
        return view('formReservation');
    }
    
    
    public function store(Request $request)
    {
    
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email',
            'titre' => 'required|string',
            'auteur' => 'required|string',
            'rang' => 'nullable|string',
            'etage' => 'nullable|string',
            'branche' => 'nullable|string',
        ]);

        $reservation = new Reservation();
        $reservation->nom = $validatedData['nom'];
        $reservation->prenom = $validatedData['prenom'];
        $reservation->email = $validatedData['email'];
        $reservation->titre = $validatedData['titre'];
        $reservation->auteur = $validatedData['auteur'];
        $reservation->rang = $validatedData['rang'];
        $reservation->etage = $validatedData['etage'];
        $reservation->branche = $validatedData['branche'];
        $reservation->save();

        return redirect()->route('details_livre');
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
    $reservation->rang = $request->input('rang');
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
        'Rang' => $request->input('rang'),
        'Étage' => $request->input('etage'),
    ];

    $pdf = PDF::loadView('pdf.reservation', $pdfData);

    // Télécharger le PDF
    return $pdf->download('reservation.pdf');}

}