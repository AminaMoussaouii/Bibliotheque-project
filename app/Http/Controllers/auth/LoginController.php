<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function index()
    {
        return view('auth.welcomeLibrary');
    }

    public function showLoginForm()
{
    return view('auth.login');
}

    //validation des donnees
    protected function validateLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

}
protected function redirectTo()
{
    $user = Auth::user();

    switch ($user->Role) {
        case 'etudiant':
            return '/catalogue';
        case 'personnel':
            return '/catalogue';
        case 'responsable':
            return '/responsable';
        case 'admin':
            return '/admin/users';
        case 'bibliothècaire':
            return '/bibliothècaire';
        default:
            return '/';
    }
}
protected function attemptLogin(Request $request)
{
    return Auth::attempt(
        $this->credentials($request),
        $request->filled('remember')
    );
}

protected function credentials(Request $request)
{
    return $request->only($this->username(), 'password');
}
public function username()
{
    return 'email';
}

public function login(Request $request)
{    
    $this->validateLogin($request);

    if (method_exists($this, 'hasTooManyLoginAttempts') &&
        $this->hasTooManyLoginAttempts($request)) {
        $this->fireLockoutEvent($request);

        return $this->sendLockoutResponse($request);
    }

    if ($this->attemptLogin($request)) {
        $request->session()->regenerate(); 
        $user = Auth::user();


        if ($user->is_blocked) {
            Auth::logout();
            return redirect('/login')->withErrors(['message' => 'Your account has been blocked. Please contact the administrator.']);
        }

        return $this->sendLoginResponse($request);
    }

    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse($request);
}

}
