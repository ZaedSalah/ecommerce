<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class Customauth
{
    public function handle(Request $request, Closure $next): Response
    {
        // اذا مسجل دخول وديني للراوت الي بدها
        if (Auth::user()) {
            return $next($request);
        }
        // اذا ما مسجل دخول اودي لشي ثاني 
        else {
            return redirect('login');
        }
    }
}
