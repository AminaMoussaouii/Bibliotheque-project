<?php

namespace App\Http\Controllers;

use App\Models\UserLibrary;
use Illuminate\Http\Request;
use App\Models\Reservation; 
use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Support\Facades\Log; 

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;
use PDF;

class ReservationController extends Controller
{ 
    public function bibliothècaire()
    {
        return view('bibliothecaire');
    } 

//     public function recuperer(Request $request)
// {
//     // Validez les données du formulaire
//     $request->validate([
//         'nom' => 'required|string',
//         'prénom' => 'required|string',
//         'email' => 'required|email',
//     ]);

//     // Récupérer les données du formulaire
//     $nom = $request->input('nom');
//     $prenom = $request->input('prénom');
//     $email = $request->input('email');
// }
 
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prénom' => 'required|string',
            'email' => 'required|email',
            'titre' => 'required|string',
            'auteur' => 'required|string',
            'rayon' => 'nullable|string',
            'etage' => 'nullable|string',
            'Filière' => 'nullable|string',
            'isbn' => 'nullable|string',
            'type_ouvrage' => 'nullable|string',
            'livre_id' => 'required|exists:livres,id',
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
        $reservation->prénom = $validatedData['prénom'];
        $reservation->email = $validatedData['email'];
        $reservation->titre = $validatedData['titre'];
        $reservation->auteur = $validatedData['auteur'];
        $reservation->rayon = $validatedData['rayon'];
        $reservation->etage = $validatedData['etage'];
        $reservation->isbn = $validatedData['isbn'];
        $reservation->type_ouvrage = $validatedData['type_ouvrage'];
        $reservation->livre_id = $validatedData['livre_id'];
        $reservation->user_id = Auth::id();
        if (array_key_exists('Filière', $validatedData)) {
            $reservation->Filière = $validatedData['Filière'];
        }
        
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
                $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" data-livre_id="'.$row->livre_id.'" class="btn btn-primary btn-sm emprunterReservation" id="btn1" style=" text-decoration: none;">Emprunter</a>';
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
            $emprunt->prénom = $reservation->prénom;
            $emprunt->email = $reservation->email;
            $emprunt->role = 'Utilisateur';
            $emprunt->isbn = $reservation->isbn;
            $emprunt->titre = $reservation->titre;
            $emprunt->type_ouvrage = $reservation->type_ouvrage;
            $emprunt->date_limite = Carbon::now()->addDays(3); 
            $emprunt->date_retour = null;
            $emprunt->nbr_jrs_retard = 0;
            $emprunt->statut = 'emprunté';
            $emprunt->livre_id = $reservation->livre_id;
            $emprunt->user_id = $reservation->user_id ;

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
    $pdfData = [
        'title' => 'Demande de réservation d\'un livre',
        'date' => date('d/m/Y'),
        'nom' => $request->nom,
        'prénom' => $request->prénom,
        'Filière' => $request->Filière,
        'email' => $request->email,
        'isbn' => $request->isbn,
        'type_ouvrage' => $request->type_ouvrage,
        'titre' => $request->titre,
        'auteur' => $request->auteur,
        'rayon' => $request->rayon,
        'etage' => $request->etage,
    ];

    $pdf = PDF::loadView('pdf', $pdfData);

    return $pdf->download('DemandeReservation.pdf');
}
  
}