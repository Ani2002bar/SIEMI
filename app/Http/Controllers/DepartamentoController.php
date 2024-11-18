<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Local;
use Illuminate\Support\Facades\Storage;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::all();
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        $locals = Local::all();
        return view('departamentos.create', compact('locals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'local_id' => 'required|exists:locals,id',
        ]);

        Departamento::create($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado exitosamente.');
    }

    public function show($id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('departamentos.detail', compact('departamento'));
    }

    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        $locals = Local::all();
        return view('departamentos.edit', compact('departamento', 'locals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'local_id' => 'required|exists:locals,id',
        ]);

        $departamento = Departamento::findOrFail($id);
        $departamento->update($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado exitosamente.');
    }
    public function getDepartamentos($localId)
{
    $departamentos = Departamento::where('local_id', $localId)->pluck('nombre', 'id');
    return response()->json($departamentos);
}

}
