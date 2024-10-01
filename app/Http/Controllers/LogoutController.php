<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        Auth::guard('superadmin')->logout();
    
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        // dd($request);

        return redirect('/login');
    }
}
