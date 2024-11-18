<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    // Mostrar lista de técnicos
    public function index()
    {
        $tecnicos = Tecnico::all(); // Obtener todos los técnicos
        return view('tecnicos.index', compact('tecnicos'));
    }

    // Mostrar formulario para crear un técnico
    public function create()
    {
        return view('tecnicos.create');
    }

    // Almacenar técnico en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|max:200',
            'telefono' => 'required|string|max:20',
        ]);

        Tecnico::create($request->all());

        return redirect()->route('tecnicos.index')->with('success', 'Técnico creado exitosamente.');
    }

    // Mostrar formulario para editar un técnico
    public function edit(Tecnico $tecnico)
    {
        return view('tecnicos.edit', compact('tecnico'));
    }

    // Actualizar técnico en la base de datos
    public function update(Request $request, Tecnico $tecnico)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|max:200',
            'telefono' => 'required|string|max:20',
        ]);

        $tecnico->update($request->all());

        return redirect()->route('tecnicos.index')->with('success', 'Técnico actualizado exitosamente.');
    }

    // Eliminar técnico
    public function destroy(Tecnico $tecnico)
    {
        $tecnico->delete();

        return redirect()->route('tecnicos.index')->with('success', 'Técnico eliminado exitosamente.');
    }
}
