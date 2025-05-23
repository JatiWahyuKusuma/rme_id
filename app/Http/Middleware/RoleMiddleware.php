<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check() || !in_array(auth()->user()->level_id, $roles)) {
            if (auth()->user()->id != 3) {
                return redirect('dashboardcad');
            } else {
                return redirect('dashboardcadbb')->with('error', 'Tidak Ada Akses Superadmin');;
            }
        }

        return $next($request);
    }
}
