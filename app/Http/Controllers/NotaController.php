<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Nota::with(['estudiante', 'asignatura'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'nota' => 'nullable|numeric|min:0|max:10'
        ]);

        $nota = Nota::create($request->all());
        return response()->json($nota, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nota = Nota::with(['estudiante', 'asignatura'])->findOrFail($id);
        return response()->json($nota);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nota = Nota::findOrFail($id);

        $request->validate([
            'estudiante_id' => 'sometimes|exists:estudiantes,id',
            'asignatura_id' => 'sometimes|exists:asignaturas,id',
            'nota' => 'nullable|numeric|min:0|max:10'
        ]);

        $nota->update($request->all());
        return response()->json($nota);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Nota::destroy($id);
        return response()->json(null, 204);
    }
    /* método para obtener la media de todas las notas */
    
    public function obtenerMediaGlobal()
    {
       
        // Obtener todas las notas
    $notas = Nota::all();

    // Verificar si hay notas
    if ($notas->isEmpty()) {
        return response()->json(['message' => 'No hay notas disponibles para calcular la media.'], 404);
    }

    // Calcular la media de las notas
    $media = $notas->avg('nota');

    return response()->json([
        'media_global' => $media
    ]);
    }
}
