<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Local;

class DepartamentoController extends Controller
{
    /**
     * Muestra una lista de los departamentos.
     */
    public function index()
    {
        $departamentos = Departamento::with('local')->get();
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Muestra el formulario para crear un nuevo departamento.
     */
    public function create()
    {
        $locals = Local::all();
        return view('departamentos.create', compact('locals'));
    }

    /**
     * Almacena un nuevo departamento en la base de datos.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'local_id' => 'required|exists:locals,id',
            ]);

            $departamento = Departamento::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'local_id' => $request->local_id,
            ]);

            return response()->json($departamento, 201); // Retorna el departamento creado
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'local_id' => 'required|exists:locals,id',
        ]);

        Departamento::create($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado exitosamente.');
    }

    /**
     * Muestra los detalles de un departamento específico.
     */
    public function show($id)
    {
        $departamento = Departamento::with('local')->findOrFail($id);
        return view('departamentos.detail', compact('departamento'));
    }

    /**
     * Muestra el formulario para editar un departamento existente.
     */
    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        $locals = Local::all();
        return view('departamentos.edit', compact('departamento', 'locals'));
    }

    /**
     * Actualiza un departamento específico en la base de datos.
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
            ]);

            $departamento = Departamento::findOrFail($id);
            $departamento->update($request->only('nombre', 'descripcion'));

            return response()->json($departamento);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'local_id' => 'required|exists:locals,id',
        ]);

        $departamento = Departamento::findOrFail($id);
        $departamento->update($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado exitosamente.');
    }

    /**
     * Elimina un departamento específico de la base de datos.
     */
    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado exitosamente.');
    }

    /**
     * Obtiene los departamentos asociados a un local específico.
     */
    public function getDepartamentosDisponibles()
    {
        // Solo devuelve los nombres de los departamentos disponibles
        $departamentos = Departamento::select('id', 'nombre')->get();
        return response()->json($departamentos, 200);
    }

    /**
     * Almacena un nuevo departamento desde el modal.
     */
    public function storeFromModal(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $departamento = Departamento::create($validated);

        // Retornar el departamento creado
        return response()->json(['id' => $departamento->id, 'nombre' => $departamento->nombre], 201);
    }
}

