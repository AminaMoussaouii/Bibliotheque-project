<?php

namespace App\Http\Controllers;

use App\Models\RegleEmprunt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use DataTables;

class RegleEmpruntController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RegleEmprunt::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-success btn-sm edit-regle">Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm delete-regle">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('regles.index');
    }

    public function store(Request $request)
    {
        RegleEmprunt::updateOrCreate(
            ['id' => $request->regle_id],
            ['type_tier' => $request->type_tier, 'nbr_emprunt' => $request->nbr_emprunt]
        );
        return response()->json(['success' => 'Règle enregistrée avec succès.']);
    }

    public function edit($id)
    {
        $regle = RegleEmprunt::find($id);
        return response()->json($regle);
    }

    public function update(Request $request, $id)
    {
        RegleEmprunt::find($id)->update($request->all());
        return response()->json(['success' => 'Règle mise à jour avec succès.']);
    }

    public function destroy($id)
    {
        RegleEmprunt::find($id)->delete();
        return response()->json(['success' => 'Règle supprimée avec succès.']);
    }
}
