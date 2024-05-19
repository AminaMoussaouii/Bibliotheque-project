<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLibrary;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class adminController extends Controller
{
    public function admin()
    {
        return view("admin");
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        Excel::import(new UsersImport, $file);

        return redirect()->back()->with('success', 'Les utilisateurs ont été importés avec succès.');
    }
    public function export(){

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'Role' => 'required|string',
            'password' => 'required|string|max:255',
        ]);
       
        $user = new UserLibrary();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->Role = $validatedData['Role'];
        $user->password = $validatedData['password'];
        
    
        $user->save();
    
        return redirect('/admin')->with('success', 'utilisateur enregistré avec succès.');
    }

}   


