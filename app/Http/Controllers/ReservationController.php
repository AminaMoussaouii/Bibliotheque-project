<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Reservation; 
use App\Models\Emprunt;
use App\Models\RegleEmprunt;
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
    

    
    //recuperer les données du livre et du user dans le form de reservation 
            public function reserverLivre($id = null)
        {
            if (!$id) {
                return redirect()->route('catalogue')->with('error', 'ID du livre non spécifié.');
            }

            $livre = Livre::find($id);

            if (!$livre) {
                return redirect()->route('catalogue')->with('error', 'Livre non trouvé.');
            }

            $user = Auth::user();

            if (!$user) {
                return redirect()->route('login')->with('error', 'Vous devez vous connecter pour accéder à cette page');
            }
              // Vérification pour les livres non empruntables
            if ($livre->statut == 'non empruntable') {
                return redirect()->route('catalogue')->with('error', 'Ce livre est non empruntable. Vous pouvez venir à la bibliothèque pour le lire.');
            }

            $regleEmprunt = RegleEmprunt::where('type_tier', $user->Role)->first();

            if ($regleEmprunt) {
            
                $nombreEmpruntsActuels = Emprunt::where('user_id', $user->id)->whereNull('date_retour')->count();
                $nombreReservationsActuelles = Reservation::where('user_id', $user->id)->count();

                if ($nombreEmpruntsActuels >= $regleEmprunt->nbr_emprunt) {
                    return redirect()->back()->with('error', 'Vous avez atteint la limite d\'emprunts autorisés. Veuillez retourner un emprunt avant de faire une nouvelle réservation.');
                }

                if ($nombreReservationsActuelles >= $regleEmprunt->nbr_emprunt) {
                    return redirect()->back()->with('error', 'Vous avez atteint la limite de réservations autorisées. Veuillez emprunter vos réservations avant d\'en faire de nouvelles.');
                }
            }


            return view('formReservation', ['livre' => $livre, 'user' => $user]);
        }

    


    /*=====Fct qui détermine la limite d'emprunt pour chaque utilisateur */
    
    protected function peutEmprunter(User $user)
    {
        $regleEmprunt = RegleEmprunt::where('type_tier', $user->Role)->first();
    
        if (!$regleEmprunt) {
            return false;
        }
    
        $nombreEmpruntsActuels = Emprunt::where('user_id', $user->id)->whereNull('date_retour')->count();
        $nombreReservationsActuelles = Reservation::where('user_id', $user->id)->count();
    
        return ($nombreEmpruntsActuels < $regleEmprunt->nbr_emprunt) && ($nombreReservationsActuelles < $regleEmprunt->nbr_emprunt);
    }
    


  
/*====== Stocker une nouvelle reservation ======*/
    
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

        $user = Auth::user();

        if (!$this->peutEmprunter($user)) {
            return back()->withErrors(['error' => 'Vous avez atteint la limite d\'emprunts autorisés. Veuillez retourner un emprunt avant de faire une nouvelle réservation.']);
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
        $reservation->Role = Auth::user()->Role;
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
                  return date('d/m/Y', strtotime($row->created_at));
              })
              ->rawColumns(['action'])
              ->make(true);
      }

        return view('bibliothecaire'); 
    }

//============== annuler reservation===========
public function destroy($id)
{
    $reservation = Reservation::findOrFail($id);

    $livre = Livre::find($reservation->livre_id);

    if ($livre) {
        $livre->exp_disp += 1; 
        $livre->save();
    }

    $reservation->delete();

    return response()->json(['success' => 'Réservation annulée avec succès!']);
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
            $emprunt->Role = $reservation->Role;
            $emprunt->isbn = $reservation->isbn;
            $emprunt->titre = $reservation->titre;
            $emprunt->type_ouvrage = $reservation->type_ouvrage;
            $emprunt->date_limite = Carbon::now()->addDays(1); 
            $emprunt->date_retour = null;
            $emprunt->nbr_jrs_retard;
            $emprunt->statut = 'emprunté';
            $emprunt->livre_id = $reservation->livre_id;
            $emprunt->user_id = $reservation->user_id;

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