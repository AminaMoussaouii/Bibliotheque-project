<?php

namespace App\Http\Controllers;

use App\Models\RegleEmprunt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class RegleEmpruntController extends Controller
{
    public function index()
    {
        $regles_emprunt = RegleEmprunt::all();
        return response()->json(['regles_emprunt' => $regles_emprunt]);
    }
    

    public function store(Request $request)
{
   
    $validatedData = $request->validate([
        'type_tier' => 'required|string',
        'nbr_emprunt' => 'required|integer',
    ]);


    $regle_emprunt = new RegleEmprunt();

    $regle_emprunt->type_tier = $validatedData['type_tier'];
    $regle_emprunt->nbr_emprunt = $validatedData['nbr_emprunt'];
    
   
    $regle_emprunt->save();
    Session::flash('message', 'La règle a été bien ajoutée');
    Log::info('Message de session: ' . Session::get('message'));
   
    return back()->with('message', 'La règle a été bien ajoutée');
}


   public function edit($id)
   {
       $regle_emprunt = RegleEmprunt::findOrFail($id);
       return response()->json($regle_emprunt);
   }

   public function update(Request $request, $id)
   {
       try {
           $regle_emprunt = RegleEmprunt::findOrFail($id);
           $request->validate([
               'type_tier' => 'required|string',
               'nbr_emprunt' => 'required|integer',
           ]);

           $regle_emprunt->type_tier = $request->type_tier;
           $regle_emprunt->nbr_emprunt = $request->nbr_emprunt;

           $regle_emprunt->save();

           return response()->json(['message' => 'Les données de la règle d\'emprunt ont été mises à jour avec succès']);
       } catch (\Exception $e) {
           Log::error($e->getMessage());
           return response()->json(['error' => 'Erreur lors de la mise à jour de la règle d\'emprunt.'], 500);
       }
   }



    public function destroy($id)
    {
        $regle_emprunt = RegleEmprunt::findOrFail($id);
        $regle_emprunt->delete();
        return response()->json(['message' => 'Règle supprimée avec succès']);
    }
}
