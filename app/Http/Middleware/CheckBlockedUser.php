<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class CheckBlockedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        

    
        
        if ($request->hasCookie('is_user_blocked')) {
            
            // $value = Crypt::decrypt(Cookie::get('user_email'), false);
            // $parts = explode('|', $value);

            // if (count($parts) > 1) {
            //     $isBlockedValue = $parts[1];
            //     echo ' =========== ' . $isBlockedValue . '';
            //     if ($isBlockedValue == 1) {
            //         return response()->json(['error' => 'Unauthorized'], 401);

            //     }

            // }
            return response()->json(['error' => 'Unauthorized'], 401);


        }
        return $next($request);
    }
}
