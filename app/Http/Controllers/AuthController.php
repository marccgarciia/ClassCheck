<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:admin')->except('showLoginForm', 'login_post');
    // }

    public function showLoginForm(){
        return view('login');
    }

    public function login_post(Request $request)
    {
        // Validar el input
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intento de login
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if (Auth::guard('alumno')->attempt(array_merge($credentials, ['estado' => true]))) {
            return redirect()->route('alumno.panel');
        }
        elseif (Auth::guard('profesore')->attempt(array_merge($credentials, ['estado' => true]))) {
            return redirect()->route('profesore.panel');
        }
        elseif (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.panel');
        }
        else {
            return redirect()->route('login')->withErrors([
                'email' => 'Email o Contraseña incorrectas.',
            ]);
        }
    }

    public function admin()
    {
        // Aquí deberías implementar la lógica que necesites para mostrar la vista
        return view('adminpanel');
    }

    public function alumno()
    {
        return view('alumnopanel');
    }

    public function profesore() 
    {
        return view('profesorepanel');
    }

    public function logout_admin(Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function logout_alumno(Request $request) {
        Auth::guard('alumno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function logout_profesore(Request $request) {
        Auth::guard('profesore')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('login');
    }
}
