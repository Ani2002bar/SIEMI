<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreModalidadRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Modalidad;
use Exception;

class ModalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modalidades = Modalidad::latest()->get(); // Recupera las modalidades
        return view('modalidades.index', compact('modalidades')); // Pasa la variable a la vista
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modalidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModalidadRequest $request)
{
    try {
        DB::beginTransaction();

        \Log::info('Datos recibidos: ', $request->validated());

        $modalidad = Modalidad::create($request->validated());

        DB::commit();

        return redirect()->route('modalidades.index')->with('success', 'Modalidad registrada exitosamente.');
    } catch (Exception $e) {
        DB::rollBack();
        \Log::error('Error al registrar modalidad: ' . $e->getMessage());

        return redirect()->back()->with('error', 'Hubo un problema al registrar la modalidad: ' . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $modalidad = Modalidad::findOrFail($id);
        return view('modalidades.edit', compact('modalidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Encuentra la modalidad y actualiza los datos
            $modalidad = Modalidad::findOrFail($id);
            $modalidad->update($request->all());

            // Redirige a la lista de modalidades con un mensaje de éxito
            return redirect()->route('modalidades.index')->with('success', 'Modalidad actualizada exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Hubo un problema al actualizar la modalidad: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $modalidad = Modalidad::findOrFail($id); // Encuentra la modalidad o lanza un error
            $modalidad->delete(); // Elimina la modalidad de la base de datos

            return redirect()->route('modalidades.index')->with('success', 'Modalidad eliminada exitosamente.');
        } catch (Exception $e) {
            return redirect()->route('modalidades.index')->with('error', 'Hubo un problema al eliminar la modalidad: ' . $e->getMessage());
        }
    }
    
}
