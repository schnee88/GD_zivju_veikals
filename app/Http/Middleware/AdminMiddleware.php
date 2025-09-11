<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Pārbaudām, vai lietotājs ir autentificējies un ir administrators
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Ja nav administrators, novirzīt uz sākumlapu ar kļūdas ziņojumu
         return redirect()->route('home')->with('error', 'Nav administratora tiesību!');
    }
}