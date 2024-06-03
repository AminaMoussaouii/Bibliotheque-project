<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use app\Models\Admin;
use app\Models\Responsable;
use app\Models\Bibliothecaire;
use app\Models\Personnel;
use app\Models\Etudiant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

use Exception;

class adminController extends Controller
{
    public function admin()
    {
        return view('admin');
    }
//code amina 
public function getUsers(Request $request)
{   
  
    if ($request->ajax()) {
        $users = User::all();
        return datatables()->of($users)
        ->addIndexColumn()
        ->addColumn('action', function($row){ 
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success edit-user" style="height:20px;font-size:xx-small;width:43px;padding-left:0;background-color:#5dac0e; border:none">Edit</a>';
            //$btn .= ' <a href="javascript:void(0);" id="delete-user" data-toggle="tooltip" data-original-title="Delete" data-id="' . $row->id . '"  class="btn btn-danger btn-sm deleteLivre" style="height:20px;font-size:xx-small;width:43px;padding-left:0; border:none;">Delete</a>';
            $btn .= ' <a href="javascript:void(0);" id="block-user" data-toggle="tooltip" data-original-title="Block" data-id="' . $row->id . '" class="btn btn-warning btn-sm block-user" style="height:20px;font-size:xx-small;width:43px;padding-left:0; border:none;">'.($row->is_blocked ? 'Unblock' : 'Block').'</a>';
            return $btn; })
            
        ->make(true);
    }
    return back();
}

//===================methode pour ajouter un nouveau livre==================

public function store(Request $request)
{
    // Validation des données d'entrée
    request()->validate([
        'nom' => 'required|max:255',
        'prénom' => 'required|max:255',
        'email' => 'required|email',
        'password' => 'required',
        'Role' => 'required',
        'Tél' => 'required'
    ]);

    // Création d'une instance de User
    $user = new User();
    $user->nom = $request->nom;
    $user->prénom = $request->prénom;
    $user->email = $request->email;
    $user->password = $request->password; // Assurez-vous que le mot de passe est hashé
    $user->Role = $request->Role;
    $user->Tél = $request->Tél;

    // Attributs spécifiques basés sur le rôle
    if ($request->Role === 'etudiant') {
        $user->Code_Apogée = $request->Code_Apogée;
        $user->CNE = $request->CNE;
        $user->Filière = $request->Filière;
    } elseif ($request->Role === 'personnel') {
        $user->department = $request->department;
        $user->PPR = $request->PPR;
    } elseif (in_array($request->Role, ['responsable', 'bibliothècaire', 'admin'])) {
        $user->PPR = $request->PPR;
    }

    // Sauvegarde de l'utilisateur dans la base de données
    $user->save();

    // Message de succès
    flash()->success('L`utilisateur est ajouté avec succès');
    return response()->json($user);
}



// =============Edit utilisateur================

public function edit($id)
{
    $user = User::findOrFail($id); 
    return response()->json($user);
}

// ============ Update ============
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->update($request->all());
    return response()->json(['success' => 'User updated successfully']);
  
}

// ================== supprimer un utilisateur ============
public function destroy($id)
{
    $user= User::findOrFail($id);
    $user->delete(); 
    
    flash()->success('l`utilisateur est supprimé avec succés');
    return response()->json(['success' => 'l`utilisateur supprimé avec succès']); 
}


//methode pour limportation du fichier Excel diun ensemble des utilisateurs 

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xls,xlsx,csv'
    ]);

    $file = $request->file('file');

    Excel::import(new UsersImport, $file);

    return redirect()->back()->with('success', 'Les utilisateurs ont été importées avec succès.');
}

//method block
public function block($id)
{
    $user = User::findOrFail($id);
    $user->is_blocked = !$user->is_blocked;
    $user->save();

    return response()->json(['success' => 'User '.($user->is_blocked ? 'blocked' : 'unblocked').' successfully.']);
}
   /* 
    public function block($id)
    {
        $user = UserLibrary::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        return response()->json(['success' => 'User '.($user->is_blocked ? 'blocked' : 'unblocked').' successfully.']);
    }

    /*public function importUsers(Request $request)
{
    $this->validate($request, [
        'file' => 'required|mimes:xls,xlsx'
    ]);
        Excel::import(new UsersImport, request()->file('file'));
        return response()->json(['success' => 'Les utilisateurs ont été importés avec succès.']);
    
    
}
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xls,xlsx'
    ]);

    Excel::import(new UsersImport, $request->file('file'));

    return response()->json(['success' => 'Les utilisateurs ont été importés avec succès.']);
}*/

}
  


