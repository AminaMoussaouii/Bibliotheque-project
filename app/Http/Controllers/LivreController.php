<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre; 
use Illuminate\Support\Facades\Cookie;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LivresImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
Use Response;
use DataTables;

class LivreController extends Controller
{

    // methode pour afficher les livres dans le ctalogue
   public function index()
    {
        
        $livres = Livre::paginate(10);
        return view('catalogue', ['livres' => $livres]);
    }
    public function responsable()
    {
        return view('responsablegestion');
    }
    public function showProfile()
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Passer les données de l'utilisateur à la vue
        return view('formReservation', compact('user'));
    }
    //recuperer les données du livre dans le form de reservation 
    public function reserverLivre($id)
{
    $livre = Livre::find($id);

    if (!$livre) {
        return redirect()->route('catalogue')->with('error', 'Livre non trouvé.');
    }

    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Vérifier si l'utilisateur est connecté
    if (!$user) {
        // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
        return redirect()->route('login')->with('error', 'Vous devez vous connecter pour accéder à cette page');
    }

    return view('formReservation', ['livre' => $livre,'user'=> $user]);
}
  //methode pour afficher les details de chaque livre 

  
    public function afficherDetails($id) {
        $livre = Livre::find($id);
        return view('livreDetails', ['livre' => $livre]);
    }

   

//============ recupere les livres respo ====================
public function getLivres(Request $request)
{ 
    if ($request->ajax()) {
        $livres = Livre::all();
        return datatables()->of($livres)
        ->addIndexColumn()
        ->addColumn('action', function($row){ 
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success edit-livre" style="height:20px;font-size:xx-small;width:43px;padding-left:0;background-color:#5dac0e; border:none">Edit</a>';
            $btn .= ' <a href="javascript:void(0);" id="delete-livre" data-toggle="tooltip" data-original-title="Delete" data-id="' . $row->id . '"  class="btn btn-danger btn-sm deleteLivre" style="height:20px;font-size:xx-small;width:43px;padding-left:0; border:none;">Delete</a>';
            
            return $btn; })
            ->addColumn('image', function($row){
                $imageUrl = asset('images/' . $row->image);
                return '<img src="'.$imageUrl.'" alt="Image" width="100" height="100">';
            })
            ->rawColumns(['action', 'image'])
       
       
        ->make(true);
    }
    return back();
}

//===================methode pour ajouter un nouveau livre==================

public function store(Request $request)
{
    request()->validate([
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'exp_disp' =>'required|integer',
    ]);

    $isbn = $request->isbn;
    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $imagePath = $imageName; 
    } 

    $livre = new Livre();
    $livre->titre = $request->titre;
    $livre->auteur = $request->auteur;
    $livre->isbn = $isbn;
    $livre->editeur = $request->editeur;
    $livre->langue = $request->langue;
    $livre->date_edition = $request->date_edition;
    $livre->exp_disp = $request->exp_disp;
    $livre->etage = $request->etage;
    $livre->rayon = $request->rayon;
    $livre->nombre_pages = $request->nombre_pages;
    $livre->discipline = $request->discipline;
    $livre->statut = $request->statut;
    $livre->type_ouvrage = $request->type_ouvrage;
    $livre->image = $imagePath;

    $livre->save();
    flash()->success('Le livre est ajouté avec succés');

    return response()->json($livre);
}

// =============Edit Livre================

public function edit($id)
{
    $livre = Livre::findOrFail($id); 
    return response()->json($livre);
}

// ============ Update ============
public function update(Request $request, $id)
{
    try {
        $livre = Livre::findOrFail($id);
        $request->validate([
            'isbn' => 'required|string|max:255',
            'titre' => 'required|string|max:255',
        ]);
        
        $isbn = $request->isbn;
        $imagePath = $livre->image; 
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePath = $imageName; 
        }

        $livre->titre = $request->titre;
        $livre->auteur = $request->auteur;
        $livre->isbn = $isbn;
        $livre->editeur = $request->editeur;
        $livre->langue = $request->langue;
        $livre->date_edition = $request->date_edition;
        $livre->exp_disp = $request->exp_disp;
        $livre->etage = $request->etage;
        $livre->rayon = $request->rayon;
        $livre->nombre_pages = $request->nombre_pages;
        $livre->discipline = $request->discipline;
        $livre->statut = $request->statut;
        $livre->type_ouvrage = $request->type_ouvrage;
        $livre->image = $imagePath;

        $livre->save();
        flash()->success('Le livre est modifié avec succés');
        return response()->json(['message' => 'Les données du livre ont été mises à jour avec succès']);
    } catch (\Exception $e) {
        // Log the error message
        Log::error($e->getMessage());
        return response()->json(['error' => 'Erreur lors de la mise à jour du livre.'], 500);
    }
}



// ================== supprimer un livre ============
public function destroy($id)
{
    $livre = Livre::findOrFail($id);
    $livre->delete(); 
    
    flash()->success('Le livre est supprimé avec succés');
    return response()->json(['success' => 'Livre supprimé avec succès']); 
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



//methode pour limportation du fichier Excel diun ensemble de livres 

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xls,xlsx,csv'
    ]);

    $file = $request->file('file');

    Excel::import(new LivresImport, $file);

    return redirect()->back()->with('success', 'Les livres ont été importées avec succès.');
}

//methode pour la recherche des livres 
public function search(Request $request)
{
    $term = $request->input('term');
    
    $livres = Livre::where('titre', 'LIKE', "%$term%")
                    ->orWhere('auteur', 'LIKE', "%$term%")
                    ->get();
                    
    if ($livres->isEmpty()) {
        return response()->json(['message' => 'No books found'], 404);
    }

    return response()->json($livres);
}



}
