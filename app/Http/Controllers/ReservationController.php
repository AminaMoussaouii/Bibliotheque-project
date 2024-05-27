<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; 
use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Support\Facades\Log; 
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DataTables;

class ReservationController extends Controller
{
    //pour afficher le formulaire de demande de reservation 
   /*public function show()
    {
        return view('formReservation');
    }
    */
  

    
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
            'isbn' => 'nullable|string',
            'type_ouvrage' => 'nullable|string',
        ]);

        $livre = Livre::where('isbn', $validatedData['isbn'])->first();

        if (!$livre) {
            return back()->withErrors(['error' => 'Livre non trouvé.']);
        }

        if ($livre->exp_disp <= 0) {
            return back()->withErrors(['error' => 'Aucun exemplaire disponible pour ce livre.']);
        }

        $reservation = new Reservation();
        $reservation->nom = $validatedData['nom'];
        $reservation->prenom = $validatedData['prenom'];
        $reservation->email = $validatedData['email'];
        $reservation->titre = $validatedData['titre'];
        $reservation->auteur = $validatedData['auteur'];
        $reservation->rayon = $validatedData['rayon'];
        $reservation->etage = $validatedData['etage'];
        $reservation->branche = $validatedData['branche'];
        $reservation->isbn = $validatedData['isbn'];
        $reservation->type_ouvrage = $validatedData['type_ouvrage'];
        
        $reservation->save();

        $livre->exp_disp -= 1;
        $livre->save();

        return back()->with('success', 'Réservation effectuée avec succès.');
    }


  //==========table de reservation affichage==========
  public function index(Request $request)
  {
      if ($request->ajax()) {
          $data = Reservation::latest()->get();
          return Datatables::of($data)
              ->addIndexColumn()
              ->addColumn('action', function($row){
                  $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm emprunterReservation" id="btn1" style=" text-decoration: none;">Emprunter</a>';
                  $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteReservation" id="btn2" style=" text-decoration: none;">Annuler</a>';
                  return $btn;
              })
              ->addColumn('created_at', function($row) {
                  return date('d/m/Y H:i:s', strtotime($row->created_at));
              })
              ->rawColumns(['action'])
              ->make(true);
      }

        return view('bibliothecaire'); 
    }

    public function destroy($id)
    {
        Reservation::find($id)->delete();
        return response()->json(['success' => 'Reservation annulé avec succès!']);
    }
/// empruter reservation
   
public function emprunter($id, Request $request)
    {
        try {
            Log::info('Tentative d\'emprunt pour la réservation ID: ' . $id);

            $reservation = Reservation::findOrFail($id);
            Log::info('Réservation trouvée: ' . json_encode($reservation));

            $emprunt = new Emprunt();
            $emprunt->nom = $reservation->nom;
            $emprunt->prenom = $reservation->prenom;
            $emprunt->email = $reservation->email;
            $emprunt->role = 'Utilisateur';
            $emprunt->isbn = $reservation->isbn;
            $emprunt->titre = $reservation->titre;
            $emprunt->type_ouvrage = $reservation->type_ouvrage;
            $emprunt->date_limite = Carbon::now()->addDays(3); 
            $emprunt->date_retour = null;
            $emprunt->nbr_jrs_retard = 0;
            $emprunt->statut = 'emprunté';

            $emprunt->save();
            Log::info('Emprunt sauvegardé: ' . json_encode($emprunt));

             $reservation->delete();

            return response()->json(['success' => 'Emprunt réussi.']);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'emprunt: ' . $e->getMessage());
            return response()->json(['error' => 'Échec de l\'emprunt.'], 500);
        }
    }
// ===================== PDF ================

public function telechargerPDF(Request $request)
{
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

    //=========== Générer le PDF===============
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
    return $pdf->download('pdf');}

}