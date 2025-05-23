<?php

namespace App\Http\Middleware;

use App\Models\AdminModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AutheticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated via admin guard
        
        if (Auth::check() && session('admin.guard') === 'admin') {
            // Verify the user is still an admin
            if (AdminModel::where('user_id', Auth::id())->exists()) {
                return $next($request);
            }
            
            Auth::logout();
            return redirect('/login')->with('failed', 'Akses tidak valid');
        }

        return redirect('/login')->with('failed', 'Anda harus login sebagai Admin');
    }
    // public function handle(Request $request, Closure $next): Response
    // {
    //     // Check if the user is authenticated and is an admin
    //     if (Auth::guard('admin')->check()) {
    //         return $next($request);
    //     }

    //     // If not authenticated or not an admin, redirect to login
    //     return redirect('/login');
    // }
}
