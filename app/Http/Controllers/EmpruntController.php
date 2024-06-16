<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprunt;
use DataTables;

use Carbon\Carbon;

class EmpruntController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Emprunt::select([
                'id', 
                'nom', 
                'prénom', 
                'email', 
                'Role', 
                'isbn', 
                'titre', 
                'type_ouvrage', 
                'created_at', 
                'date_limite', 
                'date_retour', 
                'nbr_jrs_retard', 
                'statut'
            ])->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('Type tiertier', function($row) {
                    return $row->Role;
                })
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
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm returnEmprunt" >Retourner</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'tier'])
                ->make(true);
        }

        return view('bibliothecaire');
    }


/*===========Retourner Emprunt ==========================*/
    public function retourner(Request $request)
{
    $emprunt = Emprunt::find($request->id);
    if ($emprunt) {
        $dateRetour = Carbon::now();
        $emprunt->date_retour = $dateRetour;
        $emprunt->statut = 'retourné';

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
 



}
