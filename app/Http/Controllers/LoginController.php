<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra la vista de inicio de sesión.
     */
    public function index()
    {
        return response()
            ->view('auth.login') // Vista del login
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    /**
     * Maneja el inicio de sesión.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('home.index')->with('success', 'Inicio de sesión exitoso. Bienvenido.');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas. Por favor, intente de nuevo.',
        ])->withInput([
            'email' => $request->email, // Solo recordar el correo electrónico
        ]);
    }

    /**
     * Maneja el cierre de sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login.index')
            ->with('success', 'Sesión cerrada correctamente.')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}
