<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Constructor que aplica el middleware de autenticación.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirige al panel principal (home).
     */
    public function index()
    {
        return view('panel.index'); // Usa la vista del panel como el home.
    }
}
