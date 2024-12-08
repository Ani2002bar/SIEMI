<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use App\Models\User;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    // Mostrar lista de técnicos
    public function index()
    {
        $tecnicos = Tecnico::with('user')->get(); // Incluir el usuario vinculado
        return view('tecnicos.index', compact('tecnicos'));
    }

    // Mostrar formulario para crear un técnico
    public function create()
{
    $users = User::doesntHave('tecnico')->get(); // Solo usuarios sin técnico
    return view('tecnicos.create', compact('users'));
}
    // Almacenar técnico en la base de datos
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:50',
        'apellido' => 'required|string|max:50',
        'correo' => 'required|email|max:200',
        'telefono' => 'required|string|max:20',
        'user_id' => 'nullable|exists:users,id',
    ]);

    $tecnico = Tecnico::create($request->only(['nombre', 'apellido', 'correo', 'telefono']));

    // Vincula el técnico con un usuario si se seleccionó
    if ($request->user_id) {
        $tecnico->user_id = $request->user_id;
        $tecnico->save();
    }

    return redirect()->route('tecnicos.index')->with('success', 'Técnico creado exitosamente.');
}


    // Mostrar formulario para editar un técnico
    public function edit(Tecnico $tecnico)
    {
        $users = User::doesntHave('tecnico')->get(); // Usuarios sin técnico vinculado
        return view('tecnicos.edit', compact('tecnico', 'users'));
    }

    // Actualizar técnico en la base de datos
    public function update(Request $request, Tecnico $tecnico)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|max:200|unique:tecnicos,correo,' . $tecnico->id,
            'telefono' => 'required|string|max:20',
            'user_id' => 'nullable|exists:users,id', // Usuario opcional
        ]);

        $tecnico->update($request->only(['nombre', 'apellido', 'correo', 'telefono']));

        // Actualizar la vinculación con el usuario
        $tecnico->user_id = $request->user_id;
        $tecnico->save();

        return redirect()->route('tecnicos.index')->with('success', 'Técnico actualizado exitosamente.');
    }

    // Eliminar técnico
    public function destroy(Tecnico $tecnico)
    {
        $tecnico->delete();

        return redirect()->route('tecnicos.index')->with('success', 'Técnico eliminado exitosamente.');
    }
}
