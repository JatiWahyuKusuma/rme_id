<?php

namespace App\Http\Controllers;

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
        // dd($request);

        if (Auth::guard('superadmin')->attempt($credentials)) {
            $superadmin = Auth::guard('superadmin')->user(); // Retrieve the authenticated user
    
            // Optional: Store user information in the session
            session()->put('superadmin.nama', $superadmin->nama);
            session()->put('superadmin.email', $superadmin->email);
    
            return redirect('/cadpot')->with('success', 'Berhasil Masuk!');
        }
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            session()->put('admin.nama', $admin->nama);
            session()->put('admin.email', $admin->email);
            //dd($admin);
            return redirect('/dashboard')->with('success', 'Berhasil Masuk!');
        }


        return redirect('/login')->with('failed', 'No Induk atau Password Salah');
    } 
}
