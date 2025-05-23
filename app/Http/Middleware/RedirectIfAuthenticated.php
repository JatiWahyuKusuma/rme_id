<?php

namespace App\Http\Middleware;

use App\Models\SuperadminModel;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ( auth()->user()->id != 3) {
                    return redirect('dashboardcad');
                } else {
                    return redirect('dashboardcadbb')->with('error', 'Logout Terlebih dahulu');;
                }
            }
        }

        return $next($request);
    }
}
