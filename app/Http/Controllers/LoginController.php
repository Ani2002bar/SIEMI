<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function index()
    {
        return view('auth.login'); // Vista del login.
    }

    /**
     * Maneja el inicio de sesión.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intenta autenticar al usuario.
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate(); // Regenera la sesión por seguridad.
            return redirect()->route('home.index')->with('success', 'Bienvenido de nuevo.');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Maneja el cierre de sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Invalida la sesión actual.
        $request->session()->regenerateToken(); // Regenera el token CSRF.

        return redirect()->route('login.index')->with('success', 'Has cerrado sesión exitosamente.');
    }
}
