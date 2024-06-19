<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprunt;
use DataTables;
use Illuminate\Mail\Mailable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class EmpruntController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Emprunt::select([
                'id', 
                'nom', 
                'prénom', 
                'Role', 
                'isbn', 
                'titre', 
                'type_ouvrage', 
                'created_at', 
                'date_limite', 
                'date_retour', 
                'nbr_jrs_retard'
            ])->latest()->get();
    
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tier', function($row) {
                    return $row->nom . ' ' . $row->prénom;
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d/m/Y');
                })
                ->editColumn('date_retour', function ($row) {
                    return $row->date_retour ? Carbon::parse($row->date_retour)->format('d/m/Y') : '';
                })
                ->editColumn('nbr_jrs_retard', function ($row) {
                    return $row->nbr_jrs_retard;
                })
                ->addColumn('action', function($row) {
                    return '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm returnEmprunt">Retourner</a>';
                })
                ->rawColumns(['action', 'tier'])
                ->make(true);
        }
    
        return view('bibliothecaire');
    }
    


public function retourner(Request $request)
{
    $emprunt = Emprunt::find($request->id);
    if ($emprunt) {
        $dateRetour = Carbon::now();
        $emprunt->date_retour = $dateRetour;
        $emprunt->statut = 'retourné';

        // Calculer le nombre de jours de retard
        $dateLimite = Carbon::parse($emprunt->date_limite);
        $nbrJrsRetard = $dateRetour->diffInDays($dateLimite, false);
        $nbrJrsRetard = $nbrJrsRetard > 0 ? 0 : abs($nbrJrsRetard);
        $emprunt->nbr_jrs_retard = $nbrJrsRetard;

        $emprunt->save();

        return response()->json([
            'success' => 'Emprunt retourné avec succès.', 
            'date_retour' => $dateRetour->format('d/m/Y'),
            'nbr_jrs_retard' => $nbrJrsRetard
        ]);
    }

    return response()->json(['error' => 'Emprunt non trouvé.'], 404);
}

public function updateLateFees()
{
    $emprunts = Emprunt::whereNull('date_retour')->where('date_limite', '<', now())->get();

    foreach ($emprunts as $emprunt) {
        $dateLimite = Carbon::parse($emprunt->date_limite);
        $nbrJrsRetard = now()->diffInDays($dateLimite, false);
        $nbrJrsRetard = $nbrJrsRetard > 0 ? 0 : abs($nbrJrsRetard);
        $emprunt->nbr_jrs_retard = $nbrJrsRetard;
        $emprunt->save();
    }
    
    return response()->json(['success' => 'Les frais de retard ont été mis à jour.']);
}

public function getRetards(Request $request)
{
    if ($request->ajax()) {
        $data = Emprunt::whereNull('date_retour')
            ->where('date_limite', '<', now())
            ->select([
                'id', 
                'nom', 
                'prénom', 
                'Role', 
                'isbn', 
                'titre', 
                'type_ouvrage', 
                'created_at', 
                'date_limite', 
                'date_retour', 
                'nbr_jrs_retard',
                'email'
            ])->latest()->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('tier', function($row) {
                return $row->nom . ' ' . $row->prénom;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->editColumn('date_retour', function ($row) {
                return $row->date_retour ? Carbon::parse($row->date_retour)->format('d/m/Y') : '';
            })
            ->editColumn('nbr_jrs_retard', function ($row) {
                return $row->nbr_jrs_retard;
            })
            ->addColumn('action', function($row) {
                return '<a href="javascript:void(0)" data-id="'.$row->id.'" data-email="'.$row->email.'" class="btn btn-primary btn-sm sendEmail">Envoyer Email</a>';
            })
            ->rawColumns(['action', 'tier'])
            ->make(true);
    }

    return view('bibliothecaire');
}

public function envoyerEmail(Request $request)
{
    $emprunt = Emprunt::find($request->id);

    if ($emprunt) {
        $email = $request->email;
        $details = [
            'title' => 'Retour du livre en retard',
            'body' => 'Bonjour ' . $emprunt->nom . ' ' . $emprunt->prénom . ',<br><br>' .
                      'Vous avez un livre en retard. Veuillez le retourner dès que possible pour éviter des pénalités.'
        ];

        Mail::send([], [], function ($message) use ($email, $details) {
            $message->to($email)
                ->subject($details['title'])
                ->setBody($details['body'], 'text/html');
        });

        return response()->json(['success' => 'Email envoyé avec succès.']);
    }

    return response()->json(['error' => 'Erreur lors de l\'envoi de l\'email.'], 500);
}


}
