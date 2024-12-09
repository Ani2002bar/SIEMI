<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Equipo;
use App\Models\Mantenimiento;

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
        // Calcula los datos necesarios
        $totalEquipos = Equipo::count();
        $equiposInactivos = Equipo::where('estado', 'Inactivo')->count();
        $mantenimientosPendientes = Mantenimiento::where('estado', 'Pendiente')->count();
        $mantenimientosPendientesList = Mantenimiento::where('estado', 'Pendiente')->take(5)->get();

        // Retorna la vista del panel con los datos cargados
        return view('panel.index', compact(
            'totalEquipos',
            'equiposInactivos',
            'mantenimientosPendientes',
            'mantenimientosPendientesList'
        ));
    }
}