<?php

namespace App\Http\Controllers;

use App\Models\SubComponente;
use App\Models\Componente;
use Illuminate\Http\Request;

class SubComponenteController extends Controller
{
    public function index()
    {
        $subcomponentes = SubComponente::with('componente')->latest()->get();
        return view('subcomponentes.index', compact('subcomponentes'));
    }

    public function create()
    {
        $componentes = Componente::all();
        return view('subcomponentes.create', compact('componentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:100',
            'nro_serie' => 'nullable|string|max:100',
            'componente_id' => 'required|exists:componentes,id',
        ]);

        SubComponente::create($request->all());

        return redirect()->route('subcomponentes.index')->with('success', 'Subcomponente creado exitosamente.');
    }

    public function edit(SubComponente $subcomponente)
    {
        $componentes = Componente::all();
        return view('subcomponentes.edit', compact('subcomponente', 'componentes'));
    }

    public function update(Request $request, SubComponente $subcomponente)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:100',
            'nro_serie' => 'nullable|string|max:100',
            'componente_id' => 'required|exists:componentes,id',
        ]);

        $subcomponente->update($request->all());

        return redirect()->route('subcomponentes.index')->with('success', 'Subcomponente actualizado exitosamente.');
    }

    public function destroy(SubComponente $subcomponente)
    {
        $subcomponente->delete();
        return redirect()->route('subcomponentes.index')->with('success', 'Subcomponente eliminado exitosamente.');
    }
    public function storeFromModal(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'nro_serie' => 'nullable|string|max:255',
            'componente_id' => 'required|exists:componentes,id',
        ]);

        $subcomponente = SubComponente::create($validated);

        return response()->json(['success' => true, 'subcomponente' => $subcomponente]);
    }

    public function getByComponente($componenteId)
    {
        $subcomponentes = SubComponente::where('componente_id', $componenteId)->get();
        return response()->json($subcomponentes);
    }
}

