<?php

namespace App\Http\Middleware;

use App\Models\SuperadminModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AutheticateSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && session('superadmin.guard') === 'superadmin') {
            // Verify the user is still a superadmin
            if (SuperadminModel::where('user_id', Auth::id())->exists()) {
                return $next($request);
            }
            
            Auth::logout();
            return redirect('/login')->with('failed', 'Akses tidak valid');
        }

        return redirect('/login')->with('failed', 'Anda harus login sebagai Superadmin');
    }
    // public function handle(Request $request, Closure $next): Response
    // {
    //     // Check if the user is authenticated and is an admin
    //     if (Auth::check() && Auth::user()->level_id == 1) {
    //         return $next($request);
    //     }

    //     // If not authenticated or not an admin, redirect to login
    //     return redirect('/login');
    // }
}
