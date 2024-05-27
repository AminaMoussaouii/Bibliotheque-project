<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\UserLibrary;
use Illuminate\Http\Request;
//use Illuminate\Auth\Notifications\ResetPassword;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{    
    use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return view('auth.login');
    }

    public function index()
    {
        return view('auth.welcomeLibrary');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    
    public function Redirection(Request $request)
    {
    
        $email = $request->input('email');
        $password = $request->input('password');
    
        $user = UserLibrary::where('email', $email)->first();
       
        if ($user) {
            // User found, verify password
            if ($password == $user->password) {
                // Passwords match, redirect to dashboard
                switch ($user->Role) {
                    case 'etudiant':
                        return redirect()->route('catalogue');
                    case 'personnel':
                        return redirect()->route('catalogue');
                    case 'responsable':
                        return redirect()->route('responsable');
                    case 'admin':
                       return redirect()->route('admin.users.index');
                    case 'bibliothècaire':
                        return redirect()->route('bibliothècaire');
                    default:
                        return redirect('index');
                }
               
               
            } else {
                // Passwords do not match, redirect back with error message
            return back()->withInput($request->only('email'))->withErrors(['password' => 'Invalid password']);
            }
        } else {
            // User not found, redirect back with error message
            return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => 'User not found']);
        }
    }
    
    // method logout
    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    //block
    protected function authenticated(Request $request, $user)
    {
        if ($user->is_blocked) {
            Auth::logout();
            return redirect('/login')->withErrors(['message' => 'Your account has been blocked. Please contact the administrator.']);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   /* public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|email|max:250',
            'password' => 'required|min:8'
        ]);

        // Création d'une nouvelle instance du modèle
        $USER = new UserLibrary();

        // Attribution des valeurs aux champs du modèle
        $USER->email = $request->input('email');
        $USER->password = $request->input('password');
        // Ajoutez ici d'autres attributions de valeurs pour vos champs

        // Enregistrement de l'objet dans la base de données
        $USER->save();

        // Redirection avec un message de succès (facultatif)
        return redirect()->route('index')->withSuccess('You have logged out successfully!');
    }*/

   /* public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');

    }*/



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

   // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = 'index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

   
}
