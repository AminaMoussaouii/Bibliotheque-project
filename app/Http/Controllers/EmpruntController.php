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
                'prenom', 
                'email', 
                'role', 
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
                ->addColumn('tier', function($row) {
                    return $row->nom . ' ' . $row->prenom;
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d/m/Y H:i:s');
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
}
