<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
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

        // Authenticate using User model (main users table)
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Check if user is superadmin
            if (SuperadminModel::where('user_id', $user->id)->exists()) {
                // Set superadmin session and guard
                Auth::shouldUse('superadmin');
                $request->session()->put('superadmin', [
                    'id' => $user->id,
                    'nama' => $user->name,
                    'email' => $user->email,
                    'guard' => 'superadmin'
                ]);

                return redirect('/dashboardcadbb')->with('success', 'Berhasil Masuk sebagai Super Admin!');
            }

            // Check if user is admin
            if (AdminModel::where('user_id', $user->id)->exists()) {
                // Set admin session and guard
                Auth::shouldUse('admin');
                $request->session()->put('admin', [
                    'id' => $user->id,
                    'nama' => $user->name,
                    'email' => $user->email,
                    'guard' => 'admin'
                ]);

                return redirect('/dashboardcad')->with('success', 'Berhasil Masuk sebagai Admin!');
            }

            // If user doesn't have any role
            Auth::logout();
            return redirect('/login')->with('failed', 'Anda tidak memiliki akses');
        }

        return redirect('/login')->with('failed', 'Email atau Password Salah');
    }

    public function logout(Request $request)
    {
        $guard = $request->session()->get('superadmin.guard') ?? $request->session()->get('admin.guard');

        if ($guard) {
            Auth::guard($guard)->logout();
            $request->session()->forget([$guard, 'superadmin', 'admin']);
        }

        return redirect('/login')->with('success', 'Anda telah logout');
    }
    // $credentials = $request->only('email', 'password');

    // if (Auth::attempt($credentials)) {
        // $user = Auth::user(); 
        // Check if the user is a super admin
    //     if (SuperadminModel::isSuperAdmin($user->id)) {
    //         session()->put('superadmin.nama', $user->name);
    //         session()->put('superadmin.email', $user->email);
    //         return redirect('/dashboardcadbb')->with('success', 'Berhasil Masuk sebagai Super Admin!');
    //     }

    //     // For regular admin
    //     session()->put('admin.nama', $user->name);
    //     session()->put('admin.email', $user->email);
    //     return redirect('/dashboardcad')->with('success', 'Berhasil Masuk sebagai Admin!');
    // }

    // return redirect('/login')->with('failed', 'Email atau Password Salah');
    // }
}
