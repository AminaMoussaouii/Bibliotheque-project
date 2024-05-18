<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre; 

class LivreController extends Controller
{
    public function responsable()
    {
    return view('responsablegestion');
    }

    // methode pour afficher les livres dans le ctalogue
    public function index()
    {
        
        $livres = Livre::all();
        return view('catalogue', ['livres' => $livres]);
    }
    
    //methode pour afficher les details de chaque livre 

    public function afficherDetails($id) {
        $livre = Livre::find($id);
        return view('livreDetails', ['livre' => $livre]);
    }
    

//methode pour ajouter un nouveau livre

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'isbn' => 'required|string',
            'editeur' => 'required|string|max:255',
            'langue' => 'required|string|max:255',
            'date_edition' => 'required|date',
            'exp_dispo' => 'required|string|max:255',
            'etage' => 'required|string|max:255',
            'rayon' => 'required|string|max:255',
            'nbr_pages' => 'required|integer',
            'discipline' => 'required|string|max:255',
            'disponibilite' => 'required|string|in:disponible,reserve',
            'type' => 'required|string|in:Livre,CD,Mémoire',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
       
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }
        
        $livre = new Livre();
        $livre->titre = $validatedData['titre'];
        $livre->auteur = $validatedData['auteur'];
        $livre->isbn = $validatedData['isbn'];
        $livre->editeur = $validatedData['editeur'];
        $livre->langue = $validatedData['langue'];
        $livre->date_edition = $validatedData['date_edition'];
        $livre->exp_disp = $validatedData['exp_dispo'];
        $livre->etage = $validatedData['etage'];
        $livre->rayon = $validatedData['rayon'];
        $livre->nombre_pages = $validatedData['nbr_pages']; 
        $livre->discipline = $validatedData['discipline'];
        $livre->statut = $validatedData['disponibilite'];
        $livre->type_ouvrage = $validatedData['type'];
        $livre->image = $imageName;
    
        $livre->save();
    
        return redirect('/responsable')->with('success', 'Livre enregistré avec succès.');
    }
    


//methode pour le filtre

public function filtrerLivres(Request $request)
{
    $query = Livre::query();

    if ($request->has('statut')) {
        $query->where('statut', 'disponible');
    }

    if ($request->has('discipline')) {
        $query->whereIn('discipline', $request->input('discipline'));
    }

    if ($request->has('type_ouvrage')) {
        $query->whereIn('type_ouvrage', $request->input('type_ouvrage'));
    }

    if ($request->has('langue')) {
        $query->whereIn('langue', $request->input('langue'));
    }

    $livres = $query->get();

    return response()->json(['livres' => $livres]);
}

//methode pour afficher les livres dans le tableau du dasbboard responsable

public function getAllLivres()
{
    $livres = Livre::all();
    return response()->json(['livres' => $livres]);
}


//fonction pour recuperer les infos d'un livre à modifier 
public function modifier($id)
{
    $livre = Livre::find($id);
    return view('modifierLivre', ['livre' => $livre]);
}

//fonction pour faire et update aux données du livre
public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'isbn' => 'required|string|max:255',
        'titre' => 'required|string|max:255',
        'auteur' => 'required|string|max:255',
        'langue' => 'required|string|max:255',
        'editeur' => 'required|string|max:255',
        'date_edition' => 'required|date',
        'exp_dispo' => 'required|integer',
        'etage' => 'required|string|max:255',
        'rayon' => 'required|string|max:255',
        'nbr_pages' => 'required|integer',
        'discipline' => 'required|string|max:255',
        'disponibilite' => 'required|in:disponible,reserve',
        'type' => 'required|in:Livre,CD,Mémoire',
    ]);

    $livre = Livre::findOrFail($id);
    $livre->update($validatedData);
    return redirect('/responsable')->with('success', 'Livre mis à jour avec succès.');
}


//methode pour supprimer un livre existantt dans la base de donneés 
public function destroy($id)
{
    $livre = Livre::findOrFail($id);
    $livre->delete();

    return redirect('/responsable')->with('success', 'Livre supprimé avec succès.');
}




}