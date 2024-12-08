<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tecnico;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        $users = User::with(['roles', 'tecnico'])->get(); // Incluir roles y técnico asociado
        return view('users.index', compact('users'));
    }

    // Mostrar formulario para crear un usuario
    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles
        $tecnicos = Tecnico::doesntHave('user')->get(); // Técnicos sin usuario vinculado
        return view('users.create', compact('roles', 'tecnicos'));
    }

    // Guardar un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,name',
            'tecnico_id' => 'nullable|exists:tecnicos,id', // Técnico opcional
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        // Vincular técnico si fue seleccionado
        if ($request->tecnico_id) {
            $tecnico = Tecnico::findOrFail($request->tecnico_id);
            $tecnico->user_id = $user->id;
            $tecnico->save();
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    // Mostrar formulario para editar un usuario
    public function edit(User $user)
    {
        $roles = Role::all();
        $tecnicos = Tecnico::doesntHave('user')->orWhere('id', $user->tecnico_id)->get(); // Técnicos no vinculados o técnico del usuario
        return view('users.edit', compact('user', 'roles', 'tecnicos'));
    }

    // Actualizar usuario existente
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role' => 'required|exists:roles,name',
            'tecnico_id' => 'nullable|exists:tecnicos,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        $user->syncRoles($request->role);

        // Actualizar la vinculación con el técnico
        if ($request->tecnico_id) {
            $tecnico = Tecnico::findOrFail($request->tecnico_id);
            $tecnico->user_id = $user->id;
            $tecnico->save();
        } else {
            // Desvincular técnico si no se seleccionó ninguno
            if ($user->tecnico) {
                $user->tecnico->user_id = null;
                $user->tecnico->save();
            }
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    // Eliminar usuario
    public function destroy(User $user)
    {
        if ($user->tecnico) {
            $user->tecnico->user_id = null; // Desvincular técnico antes de eliminar el usuario
            $user->tecnico->save();
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
