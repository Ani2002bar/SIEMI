<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Equipo;
use Illuminate\Http\Request;

class ComponenteController extends Controller
{
    public function index()
    {
        $componentes = Componente::with('equipo')->latest()->get();
        return view('componentes.index', compact('componentes'));
    }

    public function create()
    {
        $equipos = Equipo::all();
        return view('componentes.create', compact('equipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'nro_serie' => 'nullable|string|max:255',
            'equipo_id' => 'required|exists:equipos,id',
        ]);

        Componente::create($request->only('descripcion', 'modelo', 'nro_serie', 'equipo_id'));

        return redirect()->route('componentes.index')->with('success', 'Componente creado exitosamente.');
    }

    public function show(Componente $componente)
    {
        return view('componentes.detail', compact('componente'));
    }

    public function edit(Componente $componente)
    {
        $equipos = Equipo::all();
        return view('componentes.edit', compact('componente', 'equipos'));
    }

    public function update(Request $request, Componente $componente)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'nro_serie' => 'nullable|string|max:255',
            'equipo_id' => 'required|exists:equipos,id',
        ]);

        $componente->update($request->only('descripcion', 'modelo', 'nro_serie', 'equipo_id'));

        return redirect()->route('componentes.index')->with('success', 'Componente actualizado exitosamente.');
    }

    public function destroy(Componente $componente)
    {
        $componente->delete();
        return redirect()->route('componentes.index')->with('success', 'Componente eliminado exitosamente.');
    }
}
