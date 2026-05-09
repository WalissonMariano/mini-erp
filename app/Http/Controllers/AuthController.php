<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Mostra a página de login
    public function index ()
    {
        return view('auth.login');
    }

    //Processa a tentativa de login
    public function loginAttempt (Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt([
            'str_email' => $credentials['email'],
            'password'  => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            return redirect()->route('pagina.menu');
        }

        return back()->with(
            'status', 'As credenciais fornecidas estão incorretas.'
        );

    }

    public function logout (Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pagina.login');
    }
}
