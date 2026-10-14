<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function mostrarLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'required' => 'Este campo es obligatorio.',
            'email'    => 'Escribe un correo válido.',
        ]);

        // mismo mensaje si falla el correo o la clave, para no dar pistas
        if (! Auth::attempt($credenciales)) {
            return back()
                ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
                ->onlyInput('email');
        }

        // nuevo id de sesión al entrar, evita robo de sesión
        $request->session()->regenerate();

        return redirect()->route('panel');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        // se destruye la sesión y se cambia el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}