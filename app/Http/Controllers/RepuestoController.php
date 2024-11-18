<?php

namespace App\Http\Controllers;

use App\Models\Repuesto;
use App\Models\Equipo;
use App\Models\Local;
use Illuminate\Http\Request;

class RepuestoController extends Controller
{
    public function index()
    {
        $repuestos = Repuesto::with('local', 'equipos')->latest()->get();
        return view('repuestos.index', compact('repuestos'));
    }

    public function create()
    {
        $equipos = Equipo::all();
        $locals = Local::all();
        return view('repuestos.create', compact('equipos', 'locals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:45',
            'descripcion' => 'required|string|max:200',
            'observaciones' => 'nullable|string|max:200',
            'costo' => 'required|numeric|min:0',
            'equipo_id' => 'required|exists:equipos,id',
            'local_id' => 'required|exists:locals,id',
        ]);

        $repuesto = Repuesto::create($request->all());

        // Relacionar el repuesto con el equipo
        $repuesto->equipos()->attach($request->equipo_id);

        return redirect()->route('repuestos.index')->with('success', 'Repuesto creado exitosamente.');
    }

    public function show(Repuesto $repuesto)
    {
        return view('repuestos.detail', compact('repuesto'));
    }

    public function edit(Repuesto $repuesto)
    {
        $equipos = Equipo::all();
        $locals = Local::all();
        return view('repuestos.edit', compact('repuesto', 'equipos', 'locals'));
    }

    public function update(Request $request, Repuesto $repuesto)
    {
        $request->validate([
            'codigo' => 'required|string|max:45',
            'descripcion' => 'required|string|max:200',
            'observaciones' => 'nullable|string|max:200',
            'costo' => 'required|numeric|min:0',
            'equipo_id' => 'required|exists:equipos,id',
            'local_id' => 'required|exists:locals,id',
        ]);

        $repuesto->update($request->all());

        // Actualizar la relación con el equipo
        $repuesto->equipos()->sync($request->equipo_id);

        return redirect()->route('repuestos.index')->with('success', 'Repuesto actualizado exitosamente.');
    }

    public function destroy(Repuesto $repuesto)
    {
        $repuesto->equipos()->detach();
        $repuesto->delete();

        return redirect()->route('repuestos.index')->with('success', 'Repuesto eliminado exitosamente.');
    }
}
