<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckIfBlocked
{
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */ 
    public function handle($request, Closure $next): Response
    {
        // if (Auth::check() && Auth::user()->is_blocked) {
        //     Auth::logout();
        //     return redirect('/login')->withErrors(['message' => 'Your account has been blocked. Please contact the administrator.']);
        // }
        // if ($request->input('token') !== 'my-secret-token') {
        //     return redirect('home');
        // }
        //return redirect('responsable');
        // $userId = Cookie::get('user_email');
        // $userStatus = Cookie::get('user_status');
        // echo '==== '. $userId .'==== '. $userStatus .'';

        // if( $userStatus==1 ){

        //     return response()->json(['error' => 'Unauthorized'], 401);

        // }
        //decrypt($request->cookie(""));
        if ($request->hasCookie('user_status')) {
            
            $value = Crypt::decrypt(Cookie::get('user_status'), false);
            $parts = explode('|', $value);

            if (count($parts) > 1) {
                $isBlockedValue = $parts[1];
                echo ' =========== ' . $isBlockedValue . '';
                if ($isBlockedValue == 1) {
                    return response()->json(['error' => 'Unauthorized'], 401);

                }

            }


        }
        return $next($request);
    }

}