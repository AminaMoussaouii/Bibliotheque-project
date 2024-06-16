<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Emprunt;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class HistoricalUserController extends Controller
{
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
            $user = Auth::user();
            $emprunts = Emprunt::with('livre')
                        ->where('user_id', $user->id);

            return DataTables::eloquent($emprunts)
                ->addColumn('titre', function($emprunt) {
                    return $emprunt->livre->titre;
                })
                ->addColumn('auteur', function($emprunt) {
                    return $emprunt->livre->auteur;
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d/m/Y');
                })
                ->editColumn('date_retour', function ($row) {
                    return $row->date_retour ? Carbon::parse($row->date_retour)->format('d/m/Y') : '';
                })
                ->toJson();
        }

        return view('historicalUser');
    }
}
