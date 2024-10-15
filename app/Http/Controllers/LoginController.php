<?php

namespace App\Http\Controllers;

use App\Models\SuperadminModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login_process(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); 
            // Check if the user is a super admin
            if (SuperadminModel::isSuperAdmin($user->id)) {
                session()->put('superadmin.nama', $user->name);
                session()->put('superadmin.email', $user->email);
                return redirect('/dashboardcadangan')->with('success', 'Berhasil Masuk sebagai Super Admin!');
            }
    
            // For regular admin
            session()->put('admin.nama', $user->name);
            session()->put('admin.email', $user->email);
            return redirect('/dashboardcadpot')->with('success', 'Berhasil Masuk sebagai Admin!');
        }
    
        return redirect('/login')->with('failed', 'Email atau Password Salah');
    }
}
