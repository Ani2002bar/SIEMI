<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubDepartamento;
use App\Models\Departamento;

class SubDepartamentoController extends Controller
{
    /**
     * Muestra una lista de los subdepartamentos.
     */
    public function index()
    {
        $subdepartamentos = SubDepartamento::with('departamento')->get();
        return view('subdepartamentos.index', compact('subdepartamentos'));
    }

    /**
     * Muestra el formulario para crear un nuevo subdepartamento.
     */
    public function create()
    {
        $departamentos = Departamento::all();
        return view('subdepartamentos.create', compact('departamentos'));
    }

    /**
     * Guarda un nuevo subdepartamento en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        SubDepartamento::create($request->all());

        return redirect()->route('subdepartamentos.index')->with('success', 'Subdepartamento creado exitosamente.');
    }

    /**
     * Muestra los detalles de un subdepartamento específico.
     */
    public function show($id)
    {
        $subdepartamento = SubDepartamento::with('departamento')->findOrFail($id);
        return view('subdepartamentos.detail', compact('subdepartamento'));
    }

    /**
     * Muestra el formulario para editar un subdepartamento específico.
     */
    public function edit($id)
    {
        $subdepartamento = SubDepartamento::findOrFail($id);
        $departamentos = Departamento::all();
        return view('subdepartamentos.edit', compact('subdepartamento', 'departamentos'));
    }

    /**
     * Actualiza un subdepartamento específico en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        $subdepartamento = SubDepartamento::findOrFail($id);
        $subdepartamento->update($request->all());

        return redirect()->route('subdepartamentos.index')->with('success', 'Subdepartamento actualizado exitosamente.');
    }

    /**
     * Elimina un subdepartamento específico de la base de datos.
     */
    public function destroy($id)
    {
        $subdepartamento = SubDepartamento::findOrFail($id);
        $subdepartamento->delete();

        return redirect()->route('subdepartamentos.index')->with('success', 'Subdepartamento eliminado exitosamente.');
    }
    public function getSubdepartamentos($departamentoId)
{
    $subdepartamentos = SubDepartamento::where('departamento_id', $departamentoId)->pluck('nombre', 'id');
    return response()->json($subdepartamentos);
}
public function getAll()
{
    return SubDepartamento::with('departamento')->get();
}

}

